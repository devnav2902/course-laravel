import {
  getDataFromLocalStorage,
  addToLocalStorage,
  moveTo,
  initialObject,
  initialShoppingCart,
  setCounterCart,
} from "./utils.js";

(function () {
  $(".tab-buttons .tab-btn").on("click", function () {
    $(".tab-buttons .tab-btn").each((i, e) => $(e).removeClass("active-btn"));
    $(this).addClass("active-btn");

    const dataTab = $(this).data("tab");
    $(".tabs-content .tab").each((i, e) => {
      $(e).attr("id") == dataTab
        ? $(e).addClass("active-tab")
        : $(e).removeClass("active-tab");
    });
  });

  $(".accordion.block .acc-btn").on("click", function () {
    const lecture = $(this).next();
    const icon = $(this).find(".fas");
    if (icon.hasClass("up")) {
      icon.removeClass("up");
      icon.addClass("down");
    } else {
      icon.addClass("up");
      icon.removeClass("down");
    }

    if (lecture.hasClass("acc-content")) lecture.toggle();
  });

  const starRating = $(".star-rating");
  const inputRating = $("#user_rating");

  if (inputRating.length) {
    // rating 5 star when user not click
    inputRating.value = 5;

    Array.from({ length: 5 }, (_, i) => {
      const starEle = document.createElement("i");
      starEle.classList.add("fas", "fa-star");
      starEle.dataset.rating = ++i;
      const number = i++;

      $(starEle).on("click", () => {
        const stars = $(".star-rating i");

        inputRating.val(number);

        stars.each((i, ele) => {
          if (number >= $(ele).data("rating")) {
            ele.classList.add("fas");
            ele.classList.remove("far");
            return;
          }

          ele.classList.remove("fas");
          ele.classList.add("far");
        });
      });

      $(starRating).append(starEle);
    });
  }

  const courseId = $(".addToCart").data("course");
  const dataCoupon = $(".addToCart").data("coupon") ?? {};
  const coupon = Object.keys(dataCoupon).length ? dataCoupon : {};

  const dataLocalStorage = getDataFromLocalStorage("shoppingCart");

  if (dataLocalStorage && courseId) {
    if (existInLocalStorage(courseId, dataLocalStorage.cart)) {
      $(".addToCart")
        .removeClass("addToCart")
        .addClass("goToCart")
        .text("Go to cart");
    }
  }

  $("body").on("click", ".goToCart", function () {
    if ($(".goToCart").hasClass("change")) $(".goToCart").removeClass("change");
    else location.href = location.origin + "/cart";
  });

  $("#buy").on("click", function () {
    $(".addToCart").trigger("click");

    location.href = location.origin + "/cart/checkout";
  });

  $(".addToCart").on("click", function () {
    if (!dataLocalStorage && courseId) {
      addToLocalStorage(
        "shoppingCart",
        initialShoppingCart([initialObject(courseId, coupon)])
      );
    } else {
      const course = existInLocalStorage(
        courseId,
        dataLocalStorage.saved_for_later
      );

      if (course) {
        course.coupon = coupon;
        moveTo(course, dataLocalStorage.saved_for_later, "cart");
      } else {
        dataLocalStorage.cart.push(initialObject(courseId, coupon));
        addToLocalStorage("shoppingCart", dataLocalStorage);
      }
    }

    const data = getDataFromLocalStorage("shoppingCart");
    setCounterCart(data?.cart?.length);
    changeToGoToCartButton("addToCart");
  });

  const video = videojs("#videoPlayer");

  $(".intro-video").on("click", function () {
    $(".video-demo").removeClass("hidden");
    video.play();
  });
  $(".video-top-right i").on("click", function () {
    $(".video-demo").addClass("hidden");

    video.pause();
  });
})();

function existInLocalStorage(courseId, courses) {
  return courses.find((item) => item.id === courseId);
}

function changeToGoToCartButton(classButton) {
  $(`.${classButton}`)
    .removeClass(classButton)
    .addClass("goToCart")
    .addClass("change")
    .text("Go to cart");
}
