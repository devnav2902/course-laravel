function ajax(url, data, callback, cbError = function () {}) {
  $.ajax({
    url: location.origin + url,
    data: data,
    type: "POST",
    contentType: "application/x-www-form-urlencoded",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (response) {
      callback(response);
    },
    error: function (response) {
      cbError(response);
    },
  });
}
function dropdown(element, elementDisplay) {
  $(element).on("click", function () {
    $(elementDisplay).fadeToggle(200, "swing");
  });

  $("body").on("click", function (e) {
    if ($(e.target).closest($(element)).length) return;

    $(elementDisplay).is(":visible") && $(elementDisplay).fadeOut();
  });
}

function generateRandomId() {
  var randLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));
  var uniqid = randLetter + Date.now();

  return uniqid;
}

function getDataFromLocalStorage(key) {
  return localStorage.getItem(key)
    ? JSON.parse(localStorage.getItem(key))
    : null;
}

function removeCourseAndGetList(value, data) {
  return data.filter((item) => item.id !== value);
}

function addToLocalStorage(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function moveTo(course, fromList, type = "saved_for_later") {
  const listCourses = removeCourseAndGetList(course.id, fromList);
  const data = getDataFromLocalStorage("shoppingCart");

  if (data) {
    if (type == "cart") {
      data.saved_for_later = listCourses;
      data.cart.push(course);
    } else {
      data.cart = listCourses;
      data.saved_for_later.push(course);
    }
    addToLocalStorage("shoppingCart", data);
  }
}
function initialObject(id, coupon = {}) {
  return { id, coupon };
}
function initialShoppingCart(cart = [], saved_for_later = []) {
  return {
    cart: cart,
    saved_for_later: saved_for_later,
  };
}

function setCounterCart(number) {
  if (number) $(".shopping-cart .notification-badge").text(number);
  else $(".shopping-cart .notification-badge").text("");
}

export {
  setCounterCart,
  initialObject,
  initialShoppingCart,
  moveTo,
  addToLocalStorage,
  ajax,
  dropdown,
  generateRandomId,
  getDataFromLocalStorage,
  removeCourseAndGetList,
};
