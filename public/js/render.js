function renderModal(type, value) {
  return `<div class="modal">
    <div class="modal__dialog">
        <div class="modal-content">
            <div class="modal-content__header">
                <h4 class="confirm-title">Please Confirm</h4>
                <button type="button" class="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content__body">
                You are about to remove a curriculum item. Are you sure you want to continue?
            </div>
            <div class="modal-content__footer">
                <button class="cancel-confirm-modal btn-style-two">Cancel</button>
                <button class="submit-confirm-modal btn-style-two">OK</button>
                <input type="hidden" name="${type}" value="${value}" />
            </div>
        </div>
    </div>
</div>`;
}

function renderContentTab() {
  return `
    <div class="content-tab">
        <div class="content-tab__header">
            <span>Select content type</span>
            <button type="button" class="content-tab-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content-tab__nav content-tab__main">
            <p class="content-tab__nav-header">
                Select the main type of content.
            </p>
            <ul class="content-tab__nav-container">
                <li class="content-type-selector">
                    <div class="content-type-option">
                        <i class="fas fa-file-video"></i>
                        <i class="hover fas fa-file-video"></i>
                        <span class="content-type__label">Video</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    `;
}

function renderResourceTab(id) {
  return `
    <div class="content-tab content-upload-resource">
        <div class="content-tab__header">
            <span>
                Thêm tài liệu
            </span>
            <button type="button" class="content-tab-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content-tab__resource content-tab__main">
            <div class="content-tab__resource-file">

                <!--<div class="input-group">
                    <div class="file-upload">
                        Chưa chọn file
                    </div>
                    <button type="button" class="button-select-file">
                        Chọn file
                    </button>
                </div>-->
                <span class="note">
                    <b>Note: </b>
                    Tài liệu được sử dụng để trợ giúp học viên trong bài giảng. kích thước tài liệu phải nhỏ hơn 1 GiB.
                </span>

                <div class="lecture-editor">
                    <input data-id="${id}" type="file" class="filepond" name="resource" data-max-file-size="1GB">
                </div>
            </div>
        </div>
    </div>
    `;
}

function renderMediaTab(id) {
  return `<div class="content-tab content-media">
        <div class="content-tab__header">
            <span>Add video</span>
            <button type="button" class="content-tab-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content-tab__media content-tab__main">
            <div class="content-tab__media-file">
                <!-- <div class="input-group">
                    <div class="file-upload">No file selected</div>
                    <button type="button" class="button-select-video">
                        Select Video
                    </button>
                </div> -->
                <span class="note">
                    <b>Note: </b>
                    All files should be at least 720p and less than 2.0 GB.
                </span>

                <div class="lecture-editor">
                    <input data-id="${id}" type="file" class="filepond" name="video" data-max-file-size="2GB">
                </div>
            </div>
        </div>
    </div>`;
}
function renderForm(value = {}, type, edit = true) {
  const txt = edit ? capitalize(type) : "Add " + type;
  const action = edit ? "save" : "add";
  const { title, course_id, idEdit } = value;

  return `<form class="${type}-form">
        <div class="${type}-form__title">
            <span class="${type}-form-txt">${txt}</span>
            <input maxlength="80" name="title" placeholder="Enter a Title" type="text" value="${title}">
            <input name="id" type="hidden" value="${idEdit}">
            <input name="course" type="hidden" value="${course_id}">
        </div>
        <div class="${type}-form__footer">
            <button type="button" class="cancel-${type}">Cancel</button>
            <button type="button" class="${action}-${type}">
                ${capitalize(action)} ${type}
            </button>
        </div>
    </form>`;
}
function renderAsset(data) {
  const { original_filename, resource, updated_at, id } = data;

  let resource_item = "";
  resource.forEach((file) => {
    resource_item += `
        <div data-resource="${file.id}" data-lecture="${id}" class="item">
            <div class="item__file">
                <div class="icon">
                    <i class="fas fa-download"></i>
                </div>
                <span class="filename">${file.original_filename}</span>
            </div>
            <button class="delete-asset-btn" type="button">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
  });

  return `
    <div class="content-tab content-resources">
        <!--<div
            class="content-tab__asset content-tab__main 
            d-flex fw-bold justify-content-center align-items-center">
            No content found
        </div>
        -->
        <div class="content-tab__asset content-tab__main">
        ${
          !original_filename
            ? ""
            : `
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${original_filename}</td>
                            <td>Video</td>
                            <td>Success</td>
                            <td>${updated_at}</td>
                            <td><button type="button" class="replace-btn">Replace</button></td>
                        </tr>
                    </tbody>
                </table>

                <span class="note">
                    <b>Note: </b>
                    Video phải đạt tối thiểu 720p và không vượt quá 2.0 GB.
                </span>
            </div>`
        }
            
        ${
          resource_item
            ? `<div class='resources'>
                        <p>Downloadable materials</p>
                        <div class='list'>${resource_item}</div>
                    </div>`
            : ""
        }

            <div class="add-resource">
                <button class="lecture-add-resource">+ Tài liệu</button>
            </div>
            
        </div> 
    </div>
    `;
}

function renderAddSectionItem(course_id) {
  return `<div class="curriculum-item curriculum-list__section curriculum-item__add">
        <div data-section="" class="curriculum-content section-content section-editor">
            ${renderForm(
              { title: "", course_id, idEdit: "" },
              "section",
              false
            )}
        </div>
    </div>`;
}

function renderLectureItem(title, order, idLecture) {
  return `<li data-lecture="${idLecture}" class="curriculum-content lecture-content">
    <div class="lecture-content__title">
        <div class="lecture-editor">
            <span class="lecture">
                <i class="fas fa-check-circle"></i>
                <span class="order">Bài giảng ${order}:</span>
            </span>
            <span class="curriculum-title">
                <i class="fas fa-file-alt"></i>
                <span>${title}</span>
            </span>
            <button class="lecture-edit-btn item-icon-button">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <button class="lecture-delete-btn item-icon-button">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        <!-- test -->
        <div class="add-content">
            <button class="lecture-add-content">+ Nội dung</button>
        </div>
        <div class="lecture-collapse">
            <button class="lecture-collapse-btn"><i class="fas fa-chevron-down"></i></button>
        </div>
    </div>
    <div class="content-tab content-resources">
        <div class="content-tab__asset content-tab__main">
            <div class="add-resource">
                <button class="lecture-add-resource">+ Tài liệu</button>
            </div>
        </div>
    </div>
</li>`;
}

function renderSectionItem(title, order, idSection) {
  return `
    <div class="curriculum-item curriculum-list__section">
        <div data-section="${idSection}" class="curriculum-content section-content section-editor">
            <div class="section-content__title">
                <span class="section">Chương ${order}:</span>
                <span class="curriculum-title">
                    <i class="fas fa-file-alt"></i>
                    <span>${title}</span>
                </span>
                <button type="button" class="item-icon-button section-edit-btn"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="item-icon-button section-delete-btn">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <ul class="lecture-wrapper">
            <div class="curriculum-add-item">
                <button class="add-item" data-curriculum="lecture"><i class="fas fa-plus"></i></button>
            </div>
        </ul>
    </div>`;
}
function renderButtonAddCurriculum(type) {
  return `<div class="wrapper-section"><div class="curriculum-add-item">
        <button class="add-item" data-curriculum="${type}">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    </div>`;
}

function renderAddLectureItem(course_id) {
  return (
    `<li class="curriculum-content lecture-content curriculum-item__add">` +
    renderForm({ title: "", course_id, idEdit: "" }, "lecture", false) +
    "</li>"
  );
}

function capitalize(s) {
  return s && s[0].toUpperCase() + s.slice(1);
}

function renderShoppingList(values) {
  const { count, total, renderCoursesS4L, renderCoursesInCart, promo_code } =
    values;

  let renderCoupon = "";
  for (let code of promo_code) renderCoupon += renderCouponItem(code);

  return `<div class="shopping-container">
    <div class="shopping-container__left">
        <div class="shopping-list">
            <div class="shopping-list__title">
                <span class="count">${count}</span> Khóa học trong giỏ hàng
            </div>
            <div class="shopping-list__course" id="cart">
                ${renderCoursesInCart}
            </div>
        </div>

        ${renderCoursesS4L ? renderS4L(renderCoursesS4L) : ""}
    </div>
    <div class="shopping-container__right">
        <div class="checkout">
            <div class="checkout-box-total">
                <div class="total-label">Tổng cộng:</div>
                <div class="total-price">$<span class="price">${total}</span></div>
                <div class="btn-checkout">Checkout</div>
                <div class="promotions">
                    <label>Promotions</label>

                    ${renderCoupon}

                    <div class="form-group has-error">
                        <div class="input-group">
                            <input placeholder="" type="text" id="coupon-input" class="form-control" value="">
                            <button type="button" class="btn btn-apply-coupon">
                                Apply
                            </button>
                        </div>
                        <span class="help-block"></span>
                    </div>                    
                </div>
                <div class="payment-method"></div>
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>
    </div>`;
}
function renderCouponItem(code) {
  return `<div class="coupon-item">
        <button type="button" data-coupon="${code}" class="btn remove-coupon">
            <i class="fas fa-times"></i>
        </button>
        <span class="coupon-code"><b>${code}</b>&nbsp;đã được áp dụng</span>
    </div>`;
}
function renderActionsCart() {
  return "<span class='remove-btn'>Remove</span><span class='move-to-s4L-btn'>Save for Later</span>";
}
function renderActionsS4L() {
  return "<span class='remove-btn'>Remove</span><span class='move-to-cart'>Move to cart</span>";
}
function renderEmptyCart() {
  return `<div class="shopping-list-empty">
        <img src="https://s.udemycdn.com/browse_components/flyout/empty-shopping-cart-v2.jpg" alt="">
        <p>Giỏ hàng của bạn trống, khám phá kiến thức <a href="/" class="keep-shopping-action">tại đây</a>.</p>
    </div>`;
}
function renderEmptyItemCheckout() {
  return `<div class="list-empty">
        <img src="https://s.udemycdn.com/browse_components/flyout/empty-shopping-cart-v2.jpg" alt="">
        <p>Bạn chưa có khóa học nào để thanh toán! Khám phá kiến thức <a href="/" class="keep-shopping-action">tại đây</a>.</p>
    </div>`;
}

function renderLoading() {
  return `<div class="loading-wrapper">
    <div class="loading show">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
</div>`;
}

function renderCourse(course, actions) {
  const {
    rating_count,
    rating_avg_rating,
    thumbnail,
    slug,
    id,
    author,
    price,
    title,
    coupon,
  } = course;

  let discount = null;
  const discount_price = coupon.discount_price;
  if (typeof discount_price === "number")
    discount = discount_price === 0 ? "Free" : discount_price;

  return `<div class="course-item" data-course="${id}" >
            <a href="${location.origin + "/course/" + slug}" class="">
                <div class="card-thumbnail">
                    <img src="${
                      thumbnail.includes("http")
                        ? thumbnail
                        : location.origin + "/" + thumbnail
                    }">
                </div>
                <div class="card-info">
                    <div class="card-info__title">${title}</div>
                    <div class="card-info__instructor">
                        by&nbsp;${author.fullname} 
                    </div>
                    <div class="card-info__rating">
                        ${renderRating(rating_avg_rating, rating_count)}
                    </div> 
                </div>
            </a>
            <div class="card-action">${actions}</div>
            <div class="card-price">
                ${
                  discount === "Free"
                    ? `<span title="${coupon.code}" class='discount d-flex align-items-center'>Free<i class='fas fa-tag'></i>
                        </span>`
                    : discount
                    ? `<span title="${coupon.code}" class='discount d-flex align-items-center'>$<span>${discount}</span>
                            <i class="fas fa-tag"></i>
                        </span>`
                    : ""
                }
                    
                <span class="${
                  discount ? "original-price line-through" : ""
                }">$<span>${price.price}</span></span>
            </div>
    </div>`;
}
function renderS4L(list) {
  return `<div class="shopping-list s4L">
            <div class="shopping-list__title">Saved for later</div>
            <div class="shopping-list__course" id="saved_for_later">
                ${list}
            </div>
    </div>`;
}

function renderRating(ratingAverage, ratingCount) {
  let render = "";
  render +=
    ratingAverage >= 1
      ? "<i class='fas fa-star'></i>"
      : ratingAverage >= 0.5
      ? "<i class='fas fa-star-half'></i>"
      : "<i class='far fa-star'></i>";

  render +=
    ratingAverage >= 2
      ? "<i class='fas fa-star'></i>"
      : ratingAverage >= 1.5
      ? "<i class='fas fa-star-half'></i>"
      : "<i class='far fa-star'></i>";

  render +=
    ratingAverage >= 3
      ? "<i class='fas fa-star'></i>"
      : ratingAverage >= 2.5
      ? "<i class='fas fa-star-half'></i>"
      : "<i class='far fa-star'></i>";

  render +=
    ratingAverage >= 4
      ? "<i class='fas fa-star'></i>"
      : ratingAverage >= 3.5
      ? "<i class='fas fa-star-half'></i>"
      : "<i class='far fa-star'></i>";

  render +=
    ratingAverage >= 5
      ? "<i class='fas fa-star'></i>"
      : ratingAverage >= 4.5
      ? "<i class='fas fa-star-half'></i>"
      : "<i class='far fa-star'></i>";

  return `${
    ratingAverage
      ? `<div class="ratings d-flex align-items-center">
        <span>${parseFloat(ratingAverage).toFixed(1)}</span>
        <div class="stars">${render}</div>
        <span class="rating-count">
        (${
          ratingCount >= 2 ? ratingCount + " ratings" : ratingCount + " rating"
        })
        </span>
    </div>`
      : ""
  }`;
}

export {
  renderEmptyItemCheckout,
  renderLoading,
  renderLectureItem,
  renderButtonAddCurriculum,
  renderSectionItem,
  renderAddLectureItem,
  renderAddSectionItem,
  renderAsset,
  renderForm,
  renderContentTab,
  renderModal,
  renderMediaTab,
  renderResourceTab,
  renderCouponItem,
  renderCourse,
  renderActionsS4L,
  renderActionsCart,
  renderEmptyCart,
  renderShoppingList,
  renderS4L,
};
