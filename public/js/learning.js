import { ajax, dropdown } from "./utils.js";

(function () {
  if ($(".sidebar-container").offset().top >= 56) {
    $(window).scrollTop(0);
  }

  $(window).on("scroll", function () {
    const scroll = $(window).scrollTop();
    if (scroll <= 56) {
      $(".sidebar-container").css("top", 56 - scroll);
    } else {
      $(".sidebar-container").css("top", 0);
    }
  });

  $("#sidebar-close-btn").on("click", function () {
    $(".main-content-wrapper").addClass("no-sidebar");
  });
  $(".open-course-content button").on("click", function () {
    $(".main-content-wrapper").removeClass("no-sidebar");
  });

  $(".section__header").on("click", function () {
    const icon = $(this).find("i");
    const accordionPanel = $(this).next();

    if (accordionPanel.hasClass("d-none")) {
      accordionPanel.removeClass("d-none");
      icon.addClass("show");
    } else {
      icon.removeClass("show");
      accordionPanel.addClass("d-none");
    }
  });

  const player = new Plyr($("video")[0]);

  $(".curriculum-item .link").on("click", function (e) {
    const parent = $(this).parent();
    const lecture = parent.find("input.lecture").val();

    if (lecture && !$(e.target).hasClass("dropdown")) {
      $(".curriculum-item").each(function (i, e) {
        $(e).removeClass("is-current");
      });
      parent.addClass("is-current");
      player.source = {
        type: "video",
        sources: [
          {
            src: lecture.includes("http")
              ? lecture
              : location.origin + "/" + lecture,
          },
        ],
      };
    }
  });

  $(".resource-list .dropdown").on("click", function () {
    $(this).next().fadeToggle(200, "swing");
  });

  $("body").on("click", function (e) {
    if ($(e.target).closest($(".resource-list .dropdown")).length) return;

    $(".resource-list .list").is(":visible") &&
      $(".resource-list .list").fadeOut();
  });

  const data_progress = $("#progress").data("progress");
  const data_course = $("#progress").data("course");
  const numberOfLectures = $("#progress").data("lectures");

  const current_progress = calcProgress(data_progress.length, numberOfLectures);

  var circle = new ProgressBar.Circle("#progress", {
    strokeWidth: 6,
    trailColor: "#3e4143",
    easing: "easeOut",
    color: "#47d3f3",
    duration: 1500,
  });

  circle.animate(current_progress, {
    easing: "easeOut",
    from: { color: "#5624d0" },
    to: { color: "#000" },
  });

  $("input[name='progress']").on("change", function () {
    const lecture_id = parseInt($(this).val());
    const section = $(this).parents(".section");
    const checked = $(this).is(":checked");

    ajax(
      "/update-progress",
      {
        course_id: data_course,
        lecture_id,
        checked: checked ? 1 : 0,
      },
      function (response) {
        console.log(response);
        if (response) {
          const array = response.data_progress;

          const current_section = response.section;
          const count_progress = current_section.count_progress.length;

          section.find(".bottom .count").text(count_progress);

          const current_progress = calcProgress(array.length, numberOfLectures);

          circle.animate(current_progress);
        }
      },
      function (response) {
        console.log(response);
      }
    );
  });
})();

function calcProgress(number, all) {
  return all > 0 ? (number / all).toFixed(2) : 0;
}
