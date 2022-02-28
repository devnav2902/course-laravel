<p class="font-heading">
  Mã giảm giá
</p>
<div class="table-container">
  <p class="month-coupons">{{ $current_month }} coupons</p>
  <div class="content content-coupons">
    @if (!$showFormCreate)
      @if ($isValid && $price > 0.0)
        <form method="POST" action="{{ route('promotions', ['id' => $id]) }}" class="content-header__info d-flex">
          @csrf
          <span>
            Bạn có thể tạo tối đa <b>3 mã giảm giá</b> mỗi tháng
          </span>
          <button class="create-coupon">Tạo mới</button>
        </form>
      @elseif($price === 0.0)
        <div class="content-header__info d-flex" style="justify-content: center">
          <p>Bạn không thể tạo mã giảm giá cho khóa học miễn phí.
          </p>
        </div>
      @else
        <div class="content-header__info d-flex" style="justify-content: center">
          <span class="notification">
            Bạn đã tạo tối đa số lượng mã giảm giá trong tháng
          </span>
        </div>
      @endif
    @else
      <form method="POST" id="create-coupon" action="{{ route('createCoupon') }}" class="coupon">
        @csrf
        <input type="hidden" name="course_id" value="{{ $id }}">
        <div class="coupon-code">
          <span class="coupon-code__description">
            Mã giảm giá phải có 6 - 20 ký tự, Bao gồm:
            Chữ cái viết hoa (A-Z), Số (0-9) và những ký tự có thể sử dụng:
            Dấu chấm
            (.), gạch ngang (-), và gạch dưới (_). Những mã giảm giá chứa ký tự viết thường và các ký tự đặc
            biệt khác sẽ không được chấp nhận.
          </span>
          <input type="text" oninput="this.value = this.value.toUpperCase()" name="code" id="code" />
        </div>

        <div class="data-coupon">
          <div class="data-coupon__wrapper d-flex">
            <div class="data-coupon__type">
              <div class="radio">
                <span>Chọn kiểu phù hợp:</span>
                <div class="radio-grid d-flex">
                  @foreach ($types_of_coupons as $type)
                    <div class="radio-item">
                      <input name="coupon_type" type="radio" id="{{ $type->id }}" value="{{ $type->id }}">
                      <label for="{{ $type->id }}">{{ $type->type }}</label>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="data-coupon__input"></div>

              <button type="submit" class="button-coupon">Tạo mã giảm giá</button>

              @if ($errors->any())
                <div class="message">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach

                  </ul>
                </div>
              @endif
            </div>
            {{-- <div class="data-coupon__info">
                        <div class="info__text">
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fas fa-question-circle"></i>
                                            Type
                                        </th>
                                        <th>Description</th>
                                        <th>Expiration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Free</td>
                                        <td>Creates a limited-time offer that allows up to 1000 students to enroll in
                                            your course for free.</td>
                                        <td>1000 redemptions or 5 days after activation, whichever comes first</td>
                                    </tr>
                                    <tr>
                                        <td>Custom price</td>
                                        <td>Creates a longer-lasting offer for a price you pick from the range
                                            displayed. </td>
                                        <td>31 days after activation
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
          </div>

        </div>
      </form>
    @endif
  </div>
</div>
