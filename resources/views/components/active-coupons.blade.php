<p class="font-heading">Còn hiệu lực</p>
@if (count($active_coupons) == 0)
  <div class="table-container">
    <div class="content content-coupons">
      <div class="content-header__info d-flex" style="justify-content: center">
        <span>Chưa có mã giảm giá nào được kích hoạt</span>
      </div>
    </div>
  </div>
@else
  <div>
    <table>
      <tr>
        <th>Code</th>
        <th>Giảm giá</th>
        <th>Thời gian hiệu lực</th>
        <th>Số lượng</th>
        <th>Trạng thái</th>
      </tr>

      @foreach ($active_coupons as $coupon)
        <tr>
          <td>
            <span>
              {{ $coupon->code }}
            </span>
          </td>
          <td>
            <span>
              {{ $coupon->discount_price == 0.0 ? 'Free' : "$" . $coupon->discount_price }}
            </span>
          </td>
          <td>
            <div>
              {{ $coupon->time_remaining . ' ngày' }}
            </div>
            {{-- <br /> --}}
            <div>
              {{ $coupon->expires }}
            </div>
          </td>
          <td>
            <span>
              0 /
              {{ $coupon->enrollment_limit == 0 ? 'Unlimited' : $coupon->enrollment_limit }}
            </span>
          </td>
          <td>
            <span>
              {{ $coupon->status == 1 ? 'Kích hoạt' : 'Đã tắt' }}
            </span>
          </td>
        </tr>
      @endforeach
    </table>
  </div>
@endif
