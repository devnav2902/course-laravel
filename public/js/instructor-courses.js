import { ajax } from "./utils.js";

const course_id = location.pathname.match(/\d+/g);

$(".cat-multi").select2({
  maximumSelectionLength: 3,
  placeholder: "-- Select Category --",
  allowClear: true,
});

FilePond.registerPlugin(FilePondPluginImagePreview);

FilePond.create($("#thumbnail")[0], {
  labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
  instantUpload: false,
  maxFiles: 2,
  allowMultiple: true,
  server: {
    process: {
      url: location.origin + "/image-upload",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      onload: (response) => {
        $(".gallery img").prop("src", location.origin + "/" + response);
        console.log(response);
      },
      onerror: (response) => response.data,
      ondata: (formData) => {
        formData.append("course-id", $("#label-thumbnail").data("course"));

        return formData;
      },
    },
  },
});

$("#description").summernote({
  placeholder: "Hello stand alone ui",
  tabsize: 2,
  height: 120,
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "underline", "clear"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["table", ["table"]],
    ["insert", ["link", "picture", "video"]],
    ["view", ["fullscreen", "codeview", "help"]],
  ],
  callbacks: {
    onKeyup: function (contents, $editable) {
      $("#description").trigger("input");
    },
  },
});

$(".form-group input, .form-group select, .form-group textarea").on(
  "input",
  function () {
    if (course_id.length) {
      ajax(
        "/auto-save/" + course_id[0],
        $("#form-course").serialize(),
        function (response) {
          console.log(response);
        },
        function (error) {
          console.log(error);
        }
      );
    }
    // console.log($(this));
  }
);

// CREATE COUPON
(function () {
  let id_type;
  let coupon_type = [];

  const wrapper = $(".data-coupon__wrapper");
  const coupon_input = $(".data-coupon__input");

  $("input[name='coupon_type']").on("change", function () {
    id_type = $(this).val();

    if (id_type) {
      const type = coupon_type.filter((coupon) => coupon.id === id_type);

      if (!type.length) {
        ajax("/data-coupon", { id_type: id_type }, function (coupon) {
          coupon &&
            (renderCouponType(wrapper, coupon),
            renderCouponInput(coupon_input, coupon));
        });
      } else {
        renderCouponType(wrapper, type[0]);
        renderCouponInput(coupon_input, type[0]);
      }
    }
  });

  $("button.button-coupon").on("click", function (e) {
    e.preventDefault();

    const code = $(".coupon-code input#code").val();
    const values = $("form#create-coupon").serialize();
    const messageEle = $(".data-coupon__type").find(".message");

    code &&
      ajax(
        "/create-coupon",
        values,
        function () {
          messageEle.remove();
          location.href = location.href;
        },
        function (error) {
          const errors = error.responseJSON.errors;

          let text = "";

          Object.values(errors)?.forEach((error) => {
            text += `<li>${error[0]}</li>`;
          });

          messageEle.remove();

          $(".data-coupon__type").append(
            `<div class="message"><ul>${text}</ul></div>`
          );
        }
      );
  });

  function renderCouponType(parent, coupon) {
    if (parent.children().length > 1)
      parent.find(".data-coupon__info").remove();

    parent.append(`
    <div class="data-coupon__info">
        <div class="info__text">
            <table>
            <thead>
                <tr>
                    <th>
                        <i class="fas fa-question-circle"></i> Type
                    </th>
                    <th>Description</th>
                    <th>Expiration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${coupon.type}</td>
                    <td>${coupon.description}</td>
                    <td>${coupon.expiration}</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
        `);
  }

  function renderCouponInput(parent, coupon) {
    const { type, enrollment_limit, id } = coupon;

    if (parent.length) {
      if (type.toLowerCase() == "free") {
        parent.html(`
                <label>Optional</label>
                <div class="limited-students data-input">
                    <span class="">Giới&nbsp;hạn</span>
                    <input name="enrollment_limit" required min="1" max="${enrollment_limit}" type="number">
                    <span class="">học viên</span>
                </div>
                `);
      } else if (type.toLowerCase() == "custom price") {
        parent.html(`
                <div class="price-coupon data-input">
                    <span class="usd">USD</span>
                    <input name="discount_price" required type="number">
                    <span>.99</span>
                </div>
                
                <label>Optional</label>
                <div class="limited-students data-input">
                    <span class="">Giới&nbsp;hạn</span>
                    <input name="enrollment_limit" min="1" max="" type="number">
                    <span class="">Học viên</span>
                </div>
                `);
      }
    }
  }
})();
