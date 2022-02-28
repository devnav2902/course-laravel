import { ajax, generateRandomId } from "./utils.js";
import {
  renderAddLectureItem,
  renderAddSectionItem,
  renderAsset,
  renderButtonAddCurriculum,
  renderContentTab,
  renderForm,
  renderLectureItem,
  renderMediaTab,
  renderModal,
  renderResourceTab,
  renderSectionItem,
} from "./render.js";

(function () {
  // const target = $(".curriculum-list")[0];

  // const observer = new MutationObserver(function (mutationsList, observer) {
  //     console.log(mutationsList, observer);
  //     for (const mutation of mutationsList) {
  //         if (mutation.type === "childList") {
  //             console.log("A child node has been added or removed.");
  //         } else if (mutation.type === "attributes") {
  //             console.log(
  //                 "The " + mutation.attributeName + " attribute was modified."
  //             );
  //         }
  //     }
  // });
  // observer.observe(target, {
  //     attributes: true,
  //     childList: true,
  //     subtree: true,
  //     attributeFilter: ["class", "data-lecture"],
  // });

  const course_id = location.pathname.match(/\d+/g).length
    ? location.pathname.match(/\d+/g)[0]
    : null;

  $(".curriculum-list").sortable({
    opacity: 0.8,

    update: function (event, ui) {
      const container = ui.item.parent();

      const list = [];
      container.find(".curriculum-item").each(function (i, e) {
        const index = i + 1;
        $(e)
          .find(".section-content__title .section")
          .text("Section " + index + ":");

        const section_id = $(e).children().data("section");
        if (section_id) list.push(section_id);
      });

      ajax(
        "/curriculum/order/section",
        { list, course_id },
        function (response) {
          console.log(response);
        },
        function (error) {
          console.log(error);
        }
      );
    },
  });
  $(".lecture-wrapper").sortable(sortableLecture(course_id));

  // SHOW ADD ITEM
  $("body").on("click", ".curriculum-add-item .add-item", function () {
    const button = $(this);
    const lectureWrapper = button.parents(".lecture-wrapper");
    $(".curriculum-add-item").each((i, e) => $(e).show());
    $(".curriculum-item__add").each((i, e) => $(e).remove());
    button.parent().hide();

    const data = button.data("curriculum");
    data == "section" &&
      $(".curriculum-list").append(renderAddSectionItem(course_id));

    data == "lecture" && lectureWrapper.append(renderAddLectureItem(course_id));

    if (!lectureWrapper.hasClass("ui-sortable"))
      lectureWrapper.sortable(sortableLecture(course_id));
  });
  // ADD SECTION
  $("body").on("click", ".curriculum-item .add-section", function () {
    const button = $(this);
    const parent = button.parents(".curriculum-item__add");
    const title = parent.find("input[name='title']").val();
    const buttonAddItem = $(
      ".edit-course-form > .wrapper-section .curriculum-add-item"
    );
    if (title) {
      ajax("/create-section", { course_id, title }, function (response) {
        const { title, order, id } = response;
        parent.remove();
        $(".curriculum-list").append(renderSectionItem(title, order, id));
        buttonAddItem.length
          ? buttonAddItem.show()
          : $(".edit-course-form").append(renderButtonAddCurriculum("section"));
      });
    }
  });
  // ADD LECTURE
  $("body").on("click", ".curriculum-item .add-lecture", function () {
    const button = $(this);
    const parent = button.parents(".curriculum-item__add");
    const section_id = button
      .parents(".curriculum-item")
      .find(".curriculum-content")
      .data("section");

    const title = parent.find("input[name='title']").val();
    if (title && section_id) {
      ajax(
        "/create-lecture",
        { section_id, title },
        function (response) {
          const { id, title, order } = response;

          $(".curriculum-add-item").each((i, e) => $(e).show());
          parent
            .parents(".lecture-wrapper")
            .append(renderLectureItem(title, order, id));

          parent.remove();
        },
        function (response) {
          console.log(response);
        }
      );
    }
  });

  $("body").on(
    "click",
    ".curriculum-item__add .cancel-section,.curriculum-item__add .cancel-lecture",
    function () {
      const parent = $(this).parents(".curriculum-item__add");
      if (parent.length) {
        $(".curriculum-add-item").each((i, e) => {
          $(e).show();
        });
        parent.remove();
      }
    }
  );

  // EDIT LECTURE OR SECTION
  $("body").on(
    "click",
    "button.section-edit-btn,button.lecture-edit-btn",
    function () {
      handleEditBtn($(this), course_id);
    }
  );

  // CANCEL BUTTON
  $("body").on(
    "click",
    "button.cancel-section,button.cancel-lecture",
    function () {
      const parent = $(this).parents(".hidden");
      if (parent.length) {
        parent.removeClass("hidden");
        parent.find("> form").remove();
      }
    }
  );

  // CLOSE TAB
  $("body").on("click", "button.content-tab-close", function () {
    const parent = $(this).parents(".lecture-content");

    if (parent.length) {
      defaultCollapse(parent);
      parent.removeClass("hidden-btn");
      hiddenContentTab(parent);
    }
  });

  let currentElement = null; // store current element want to delete - TEST
  // SUBMIT CONFIRM
  $("body").on("click", "button.submit-confirm-modal", function () {
    const button = $(this);
    const input = button.siblings("input");
    const type = input.prop("name");
    if (input.length) {
      button.prop("disabled", true);
      if (type == "lecture") {
        ajax(
          "/delete-curriculum",
          {
            type: type,
            course_id,
            id: input.val(),
          },
          function (response) {
            deleteLecture(button, currentElement);
          },
          function (response) {
            console.log(response);
          }
        );
      } else if (type == "section") {
        ajax(
          "/delete-curriculum",
          {
            type: type,
            course_id,
            id: input.val(),
          },
          function (response) {
            console.log(response);
            deleteSection(button, currentElement);
          },
          function (response) {
            console.log(response);
          }
        );
      }
    }
  });

  // ADD CONTENT LECTURE
  $("body").on("click", "button.lecture-add-content", function () {
    const parent = $(this).parents(".lecture-content");

    if (parent.length) {
      defaultCollapse(parent);
      parent.addClass("hidden-btn");
      parent.append(renderContentTab());
    }
  });

  // ADD RESOURCE
  $("body").on("click", "button.lecture-add-resource", function () {
    const parent = $(this).parents(".lecture-content");
    const lecture_id = parent.data("lecture");
    if (parent.length && lecture_id) {
      const data = { parent, course_id, lecture_id };
      handleFile(data, false);
      parent.addClass("hidden-btn");
    }
  });

  // SAVE SECTION
  $("body").on("click", ".save-section,.save-lecture", function () {
    const button = $(this);
    const parent = button.parents(".curriculum-content");
    const type = getTypeCurriculum(parent);

    const form = $(this).parents(`.${type}-form`);

    if (form.length && parent.length) {
      button.prop("disabled", true);
      const title = form.find('input[name="title"]').val();

      const type = getTypeCurriculum(parent);

      ajax(
        "/curriculum/update/" + type,
        form.serializeArray(),
        function (response) {
          // console.log(response);
          if (response == "success") {
            button.prop("disabled", false);
            setTitle(parent.find(".curriculum-title"), title);

            if (parent.hasClass("hidden")) {
              parent.removeClass("hidden");
              parent.find("form").remove();
            }
          }
        },
        function (response) {
          console.log(response);
        }
      );
    }
  });

  // UPLOAD VIDEO
  $("body").on("click", ".content-type-option,.replace-btn", function () {
    const parent = $(this).parents(".lecture-content");
    const lecture_id = parent.data("lecture");

    if (parent.length && lecture_id)
      handleFile({ parent, lecture_id, course_id });
  });

  // DELETE LECTURE AND SECTION
  $("body").on("click", ".lecture-delete-btn,.section-delete-btn", function () {
    const button = $(this);

    const parent = button.parents(".curriculum-content");
    const type = getTypeCurriculum(parent);

    if (type && parent.data(type)) {
      currentElement = type == "section" ? parent.parent() : parent;
      $("body")
        .addClass("modal-open")
        .append(renderModal(type, parent.data(type)));
    }
  });

  $("body").on("click", "button.lecture-collapse-btn", function () {
    const button = $(this);
    const icon = button.find("i");
    const parent = button.parents(".lecture-content");

    if (parent.length) {
      parent.toggleClass("show-collapse");
      const asset = parent.find(".content-tab.content-resources");
      if (asset.length) {
        changeCollapseIcon(icon);
      }
    }
  });

  $("body").on("click", ".cancel-confirm-modal,.close-modal", function () {
    closeModal();
  });

  $("body").on("click", "button.delete-asset-btn", function () {
    const button = $(this);
    const parent = button.parent();
    const lecture_id = parent.data("lecture");
    const resource_id = parent.data("resource");

    if (resource_id && lecture_id) {
      ajax(
        "/delete-asset",
        { resource_id, course_id, lecture_id },
        function (response) {
          const lectureEle = button.parents(".lecture-content");
          lectureEle.find(".content-resources").remove();
          lectureEle.append(renderAsset(response));
        }
      );
    }
  });
})();

function deleteSection(button, currentElement) {
  button.prop("disabled", false);
  closeModal();

  currentElement
    .addClass("deleted")
    .delay(2000)
    .queue(function () {
      const parent = currentElement.parent();
      $(this).remove();

      currentElement = null;
      parent.find(".section-content__title .section").each(function (i, e) {
        const index = i + 1;
        $(e).text("Section " + index + ":");
      });
    });
}
function deleteLecture(button, currentElement) {
  button.prop("disabled", false);
  closeModal();
  currentElement
    .addClass("deleted")
    .delay(2000)
    .queue(function () {
      const parent = currentElement.parent();
      $(this).remove();

      currentElement = null;
      parent.find(".lecture-content .order").each(function (i, e) {
        const index = i + 1;
        $(e).text("Lecture " + index + ":");
      });
    });
}

function sortableLecture(course_id) {
  return {
    update: function (event, ui) {
      const container = ui.item.parent();
      const list = [];
      container.find(".lecture-content").each(function (i, e) {
        const index = i + 1;
        $(e)
          .find(".lecture .order")
          .text("Lecture " + index + ":");

        const lecture_id = $(e).data("lecture");
        if (lecture_id) list.push(lecture_id);
      });

      ajax(
        "/curriculum/order/lecture",
        { list, course_id },
        function (response) {
          console.log(response);
        },
        function (error) {
          console.log(error);
        }
      );
    },
    remove: function (event, ui) {
      console.log("remove");
    },
  };
}

function handleFile({ parent, course_id, lecture_id }, isVideo = true) {
  const generateId = generateRandomId();
  const render = isVideo
    ? renderMediaTab(generateId)
    : renderResourceTab(generateId);
  const url = isVideo
    ? location.origin + `/curriculum/handle-lecture-video`
    : location.origin + `/curriculum/handle-resources`;

  hiddenContentTab(parent);
  defaultCollapse(parent);
  parent.append(render);

  const fileTypes = isVideo ? ["video/mp4"] : [];
  FilePond.create($(`input[data-id='${generateId}']`)[0], {
    acceptedFileTypes: fileTypes,
    instantUpload: false,
    maxFiles: 1,
    allowMultiple: false,
    allowRevert: false,
    labelFileProcessingError: (error) => {
      if (error.body.video?.length) {
        return error.body.video[0];
      }
    },
    labelIdle: `
        <div class="input-group">
            <div class="file-upload">No file selected</div>
            <a class="filepond--label-action button-select-file">
                ${isVideo ? "Select Video" : "Select File"}
            </a>
        </div>`,
    server: {
      process: {
        url: url,
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        onload: (response) => {
          const data = JSON.parse(response);

          hiddenContentTab(parent);

          isVideo && parent.find(".add-content").remove();
          parent.find(".content-resources").remove();

          parent.removeClass("hidden-btn");
          parent.addClass("show-collapse");
          changeCollapseIcon(parent.find(".lecture-collapse-btn i"));

          parent.append(renderAsset(data));
          // Should call the load method when done and pass the returned server file id
          // this server file id is then used later on when reverting or restoring a file
          return data;
        },

        onerror: (errors) => {
          console.log(errors);
          return JSON.parse(errors);
        },

        ondata: (formData) => {
          formData.append("course_id", course_id);
          formData.append("lecture_id", lecture_id);
          return formData;
        },
      },
    },
  });
}

function defaultCollapse(parent) {
  if (parent.hasClass("show-collapse")) {
    changeCollapseIcon(parent.find(".lecture-collapse-btn i"));
    parent.removeClass("show-collapse");
  }
}

function changeCollapseIcon(icon) {
  if (icon.hasClass("fa-chevron-down")) {
    icon.removeClass("fa-chevron-down");
    icon.addClass("fa-chevron-up");
  } else if ("fa-chevron-up") {
    icon.removeClass("fa-chevron-up");
    icon.addClass("fa-chevron-down");
  }
}

function handleEditBtn(button, course_id) {
  const parent = button.parents(".curriculum-content");
  const titleEle = button.prev();
  const type = getTypeCurriculum(parent);
  const typeId = parent.data(type);

  if (
    parent.length &&
    titleEle.hasClass("curriculum-title") &&
    course_id &&
    type
  ) {
    parent.addClass("hidden"); //hide lecture-content__title
    hiddenFormEditExcept(parent);

    if (type == "lecture") {
      if (parent.hasClass("show-collapse")) {
        changeCollapseIcon(parent.find(".lecture-collapse-btn i"));
        parent.removeClass("show-collapse");
      }
      parent.removeClass("hidden-btn");
      hiddenContentTab(parent);
    }

    const values = {
      title: getTitle(titleEle),
      idEdit: typeId,
      course_id,
    };

    parent.append(renderForm(values, type));
  }
}

function getTypeCurriculum(parent) {
  return parent.hasClass("section-content")
    ? "section"
    : parent.hasClass("lecture-content")
    ? "lecture"
    : null;
}

function hiddenContentTab(parent) {
  const tab = parent.find(".content-tab");

  tab.each((i, e) => {
    !$(e).hasClass("content-resources") && $(e).remove();
  });
}

function hiddenFormEditExcept(current) {
  const form = $(".section-content.hidden,.lecture-content.hidden");

  form.each((i, e) => {
    if (!$(current).is($(e))) {
      $(e).removeClass("hidden");
      $(e).find("form").remove();
    }
  });
}

function getTitle(element) {
  return element.find("span").text();
}

function setTitle(element, title) {
  element.find("span").text(title);
}

function closeModal() {
  $("body").removeClass("modal-open");
  $("body").find(".modal").remove();
}
