import { dropdown, getDataFromLocalStorage, setCounterCart } from "./utils.js";

(function () {
  dropdown(".user-dropdown", ".profile-content");
  dropdown(".icon-notification", ".wrapper-notification");

  const data = getDataFromLocalStorage("shoppingCart");

  setCounterCart(data?.cart?.length);
})();
