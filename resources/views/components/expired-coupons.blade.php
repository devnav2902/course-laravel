<p class="font-heading">
  Hết hạn
</p>
<div class="table-container">
  <div class="content content-coupons">
    <div class="content-header__info d-flex" style="justify-content: center">
      <span>Không có mã giảm giá nào</span>
    </div>
  </div>
  {{-- <table>
        <tr>
            <th>
                Code
            </th>
            <th>
                Discount
            </th>
            <th>
                Time remaining
            </th>
            <th>
                Redemptions
            </th>
            <th>
                Status
            </th>
        </tr>

        @foreach ($expired_coupons as $coupon)
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
                    <span>
                        {{ $coupon->time_remaining < 2 ? $coupon->time_remaining . ' day' : $coupon->time_remaining . ' days' }}
                    </span>

                    <span>
                        {{ $coupon->expires }}
                    </span>
                </td>
                <td>
                    <span>
                        0 / {{ $coupon->enrollment_limit == 0 ? 'Unlimited' : $coupon->enrollment_limit }}
                    </span>
                </td>
                <td>
                    <span>

                    </span>
                </td>
            </tr>
        @endforeach
    </table> --}}
</div>