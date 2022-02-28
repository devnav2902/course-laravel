import {
  addToLocalStorage,
  ajax,
  getDataFromLocalStorage,
  initialShoppingCart,
  moveTo,
  setCounterCart,
  removeCourseAndGetList,
} from "./utils.js";

import {
  renderCourse,
  renderS4L,
  renderEmptyCart,
  renderShoppingList,
  renderActionsS4L,
  renderActionsCart,
  renderLoading,
} from "./render.js";

(function () {
  const data = getDataFromLocalStorage("shoppingCart");
  let coursesDB = [];

  if (!data) $(".shopping-cart-section").append(renderEmptyCart());
  else {
    const list = data.saved_for_later.concat(data.cart);
    $(".shopping-cart-section").append(renderLoading());

    if (!list.length) {
      $(".shopping-cart-section").find(".loading-wrapper").remove();
      return $(".shopping-cart-section").append(renderEmptyCart());
    }

    ajax(
      "/get-courses",
      {
        courses: list,
      },
      function (response) {
        coursesDB = [...response];
        console.log(response);

        const data = getDataFromLocalStorage("shoppingCart");
        const cart = getListCourses(coursesDB, data.cart);
        const saved_for_later = getListCourses(coursesDB, data.saved_for_later);

        // UPDATE
        addToLocalStorage(
          "shoppingCart",
          initialShoppingCart(cart, saved_for_later)
        );

        $(".shopping-cart-section").find(".loading-wrapper").remove();
        shoppingListDom(coursesDB, data);
      },
      function (error) {
        console.log(error);
      }
    );
  }

  $("body").on("click", ".move-to-s4L-btn,.move-to-cart", function () {
    const data = getDataFromLocalStorage("shoppingCart");
    const courseId = $(this).parents(".course-item").data("course");

    const dataSavedForLater = data.saved_for_later;
    const dataCart = data.cart;

    if ($(this).hasClass("move-to-s4L-btn")) {
      const course = dataCart.find((course) => course.id === courseId);
      course && moveTo(course, dataCart);
    } else {
      const course = dataSavedForLater.find((course) => course.id === courseId);
      course && moveTo(course, dataSavedForLater, "cart");
    }

    const newData = getDataFromLocalStorage("shoppingCart");
    setCounterCart(newData?.cart?.length);
    shoppingListDom(coursesDB, newData);
  });

  $("body").on("click", ".remove-btn", function () {
    const data = getDataFromLocalStorage("shoppingCart");
    const courseId = $(this).parents(".course-item").data("course");

    if ($(this).parents("#cart").length) {
      data.cart = removeCourseAndGetList(courseId, data.cart);
    } else if ($(this).parents("#saved_for_later")) {
      data.saved_for_later = removeCourseAndGetList(
        courseId,
        data.saved_for_later
      );
    }

    addToLocalStorage("shoppingCart", data);
    $(".shopping-container").html("");

    const newData = getDataFromLocalStorage("shoppingCart");
    setCounterCart(newData?.cart?.length);
    shoppingListDom(coursesDB, newData);
  });

  $("body").on("click", ".remove-coupon", function () {
    const code = $(this).data("coupon");

    if (code) {
      coursesDB = coursesDB.map((course) => {
        course.coupon.code === code && (course.coupon = {});
        return course;
      });
    }

    const data = getDataFromLocalStorage("shoppingCart");
    const cart = getListCourses(coursesDB, data.cart);
    const saved_for_later = getListCourses(coursesDB, data.saved_for_later);

    // UPDATE
    addToLocalStorage(
      "shoppingCart",
      initialShoppingCart(cart, saved_for_later)
    );

    shoppingListDom(coursesDB, getDataFromLocalStorage("shoppingCart"));
  });

  $("body").on("click", ".btn-checkout", function () {
    location.href = location.origin + "/cart/checkout";
  });
  $("body").on("click", ".btn-apply-coupon", function () {
    const couponInput = $("#coupon-input").val();
    if (couponInput) {
      const list = data.saved_for_later.concat(data.cart);
      const code = couponInput.toUpperCase();
      ajax(
        "/applying-coupon",
        { coupon: code, courses: list },
        function (response) {
          coursesDB = [...response];

          const data = getDataFromLocalStorage("shoppingCart");
          const cart = getListCourses(coursesDB, data.cart);
          const saved_for_later = getListCourses(
            coursesDB,
            data.saved_for_later
          );

          // UPDATE
          addToLocalStorage(
            "shoppingCart",
            initialShoppingCart(cart, saved_for_later)
          );

          shoppingListDom(coursesDB, getDataFromLocalStorage("shoppingCart"));

          const coupons = coursesDB.filter((course) => {
            return course.coupon?.code === code;
          });

          !coupons.length &&
            $(".help-block").text(
              "Mã code vừa nhập không chính xác, vui lòng thử lại."
            );
        },
        function (response) {
          console.log(response);
          const error = response.responseJSON.errors?.coupon;

          if (error) $(".help-block").text(`${error[0]}`);
        }
      );
    }
  });
})();

function getListCourses(coursesDB, dataCourse) {
  return coursesDB
    .map((course) => {
      const index = dataCourse.findIndex((item) => item.id === course.id);

      if (index === -1) return null;

      return {
        id: course.id,
        coupon: course.coupon ? course.coupon : {},
      };
    })
    .filter((course) => course);
}

function getDataCourses(coursesDB, coursesLocalStorage) {
  return coursesDB
    .map((course) => {
      const index = coursesLocalStorage.findIndex((e) => e.id === course.id);
      if (index === -1) return null;

      !course.coupon && (course.coupon = {});
      return course;
    })
    .filter((course) => course);
}

function shoppingListDom(courses, data) {
  const coursesInCart = getDataCourses(courses, data.cart);
  const coursesInSavedForLater = getDataCourses(courses, data.saved_for_later);

  $(".shopping-container").remove();
  $(".shopping-list-empty").remove();
  $(".shopping-list").remove();

  if (!coursesInCart.length) {
    $(".shopping-cart-section").append(renderEmptyCart());
    if (coursesInSavedForLater.length) {
      let render = "";
      let actions = renderActionsS4L();

      coursesInSavedForLater.forEach(
        (element) => (render += renderCourse(element, actions))
      );

      $(".shopping-cart-section").append(renderS4L(render));
    }
  } else {
    let renderCoursesInCart = "",
      renderCoursesS4L = "",
      promo_code = new Set(),
      total = 0,
      actionsS4L = renderActionsS4L(),
      actionsCart = renderActionsCart();

    coursesInCart.forEach((element) => {
      const discount = element.coupon?.discount_price;

      if (typeof discount === "number") {
        total += discount;
        promo_code.add(element.coupon.code);
      } else total += element.price.price;

      renderCoursesInCart += renderCourse(element, actionsCart);
    });

    coursesInSavedForLater.forEach((element) => {
      const discount = element.coupon?.discount_price;
      typeof discount === "number" && promo_code.add(element.coupon.code);

      renderCoursesS4L += renderCourse(element, actionsS4L);
    });

    const values = {
      count: coursesInCart.length,
      total: total.toFixed(2),
      promo_code,
      renderCoursesS4L,
      renderCoursesInCart,
    };
    $(".shopping-cart-section").append(renderShoppingList(values));
  }
}
