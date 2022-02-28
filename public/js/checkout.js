import {
    getDataFromLocalStorage,
    ajax,
    addToLocalStorage,
    initialShoppingCart,
} from "./utils.js";
import { renderEmptyItemCheckout } from "./render.js";
(function () {
    const courses = getDataFromLocalStorage("shoppingCart");

    if (!courses?.cart.length)
        return $(".checkout-page__container")
            .html("")
            .append(renderEmptyItemCheckout());

    ajax("/get-courses", { courses: courses.cart }, function (response) {
        const courses = [...response];
        console.log(response);

        if (courses.length) {
            let shoppingList = "";
            let original = 0,
                total = 0;

            courses.forEach((course) => {
                shoppingList += renderShoppingItem(course);
                original += course.price.price;
                total += course.coupon
                    ? course.coupon.discount_price
                    : course.price.price;
            });

            original = original.toFixed(2);
            total = total.toFixed(2);
            $(".checkout-page__container")
                .html("")
                .append(
                    renderContainer(shoppingList, function () {
                        return renderInfoCheckout(original, total);
                    })
                );

            paypal
                .Buttons({
                    style: {
                        size: "medium",
                        color: "blue",
                        shape: "rect",
                        label: "checkout",
                    },
                    createOrder: function (data, actions) {
                        // This function sets up the details of the transaction, including the amount and line item details.
                        return actions.order.create({
                            purchase_units: [
                                {
                                    amount: {
                                        value: total,
                                    },
                                },
                            ],
                        });
                    },
                    onApprove: function (data, actions) {
                        // This function captures the funds from the transaction.
                        return actions.order.capture().then(function (details) {
                            // This function shows a transaction success message to your buyer.
                            enrollment(courses, details);
                        });
                    },
                })
                .render("#paypal-button-container");
        }
    });
    // console.log(courses.cart);
})();

function enrollment(courses, details) {
    ajax(
        "/purchase",
        { courses: JSON.stringify(courses) },
        function (response) {
            console.log(response);
            if (response == "success") {
                $("body").append(renderPaymentPopup(courses, details));
                const value = initialShoppingCart();
                addToLocalStorage("shoppingCart", value);
            }
        },
        function (error) {
            console.log(error);
        }
    );
}
function renderPaymentPopup(courses, details) {
    console.log(courses);
    console.log(details);
    let shoppingList = "";
    const purchase_units = details.purchase_units[0];
    const {
        amount: { currency_code, value: total },
    } = purchase_units;

    courses.forEach((course) => {
        let purchase = 0.0;
        if (course.coupon) purchase = course.coupon.discount_price;
        else purchase = course.price.price;

        shoppingList += ` <tr><td>${course.title}</td><td>$${purchase}</td></tr>`;
    });
    return `
    <div class="payment container">
    <div class="form-payment">
        <div class="icon-check">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="title-payment">
            <span>Thanh toán thành công</span>
        </div>
        <table>
            <tbody>
                <tr>
                    <td>Thời gian thanh toán</td>
                    <td>${details.update_time}</td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td>${details.payer.name.given_name}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>Paypal</td>
                </tr>
                <tr>
                    <td>Số tiền thanh toán</td>
                    <td>${currency_code == "USD" && "$"}${total}</td>
                </tr>
            </tbody>
        </table>

        <div class="shopping-list__container">
            <table class="shopping-list">
                <thead>
                    <tr><th>Khóa học</th><th>Thanh toán</th></tr>
                </thead>
                <tbody>${shoppingList}</tbody>
            </table>
        </div>

        <div class="buttons">
            <a href="${location.origin}" class="print">Trở về</a>
            <a href="${
                location.origin + "/" + "my-learning"
            }" class="button">Danh sách khóa học</a>
        </div>
    </div>
</div>
    `;
}

function renderInfoCheckout(original, total) {
    const discount_price = (original - total).toFixed(2);

    return `<div class="checkout-page-right">
    <div class="title">Summary</div>

    <div class="checkout-page-right__price">
        <div class="original-price d-flex align-items-center">
            <div class="title">Tất cả khóa học</div>
            <div class="price">$${original}</div>
        </div>
        <div class="discount-price d-flex align-items-center">
            <div class="title">Áp dụng mã giảm giá</div>
            <div class="price">-$${discount_price}</div>
        </div>
        <div class="total d-flex align-items-center">
            <div class="title">Tổng cộng</div>
            <div class="price">$${total}</div>
        </div>
    </div>

    <div id="paypal-button-container"></div>
    <!-- <button class="complete-payment">Thanh toán</button> -->
</div>`;
}
function renderShoppingItem(course) {
    const {
        thumbnail,
        title,
        price: { price },
        coupon,
    } = course;

    return `<div class="course d-flex">
    <img src="${
        thumbnail.includes("http")
            ? thumbnail
            : location.origin + "/" + thumbnail
    }" alt="">
    <div class="card-title">${title}</div>
    <div class="card-price">
    ${
        coupon
            ? `<div class="discount-price">$${coupon.discount_price}</div>`
            : ""
    }
        
        <div class="${
            coupon ? "line-through" : ""
        } original-price">$${price}</div>
    </div>
</div>`;
}

function renderContainer(shoppingList, cb) {
    const renderInfoCheckout = cb();
    return `
    <div class="checkout-page-left">
    <div class="title">Checkout</div>
    <div class="address-container">
        <label for="">Billing Address</label>
        <div class="address-select">
            <select data-purpose="billing-address-country" autocomplete="off" id="billingAddressCountry"
                class="form-control">
                <option value="" disabled="">Please select...</option>
                <option value="SJ">Svalbard and Jan Mayen</option>
                <option value="SZ">Swaziland</option>
                <option value="TR">Turkey</option>
                <option value="TM">Turkmenistan</option>
                <option value="TC">Turks and Caicos Islands</option>
                <option value="TV">Tuvalu</option>
                <option value="VN">Vietnam</option>
            </select>
        </div>
        <div class="checkout-selection">
            <div class="radio">
                <div class="radio-label d-flex align-items-center">
                    <input name="payment-methods" checked type="radio">
                    <span class="label">PayPal</span>
                    <img src="https://s3.amazonaws.com/growth-prototypes/pp_cc_mark_111x69.jpg"
                        alt="PayPal Icon" class="" width="74" height="20">
                </div>
            </div>
        </div>
        <div class="order-details">
            <div class="title">Danh sách khóa học:</div>
            <div class="shopping-list">
                <div class="shopping-list__item">${shoppingList}
                </div>
            </div>
        </div>
    </div>
    </div>
    ${renderInfoCheckout}
    `;
}
