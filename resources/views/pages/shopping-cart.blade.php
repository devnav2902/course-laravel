@extends('layouts.master')
@section('main-content')
    <div class="shopping-cart-section">
        <div class="header-bar">
            <h1 class="shopping-cart-title">Shopping Cart</h1>
        </div>

        {{-- <div class="shopping-list-empty">
            <img src="https://s.udemycdn.com/browse_components/flyout/empty-shopping-cart-v2.jpg" alt="">
            <p>Your cart is empty. Keep shopping to find a course!</p>
            <a href="/" class="btn keep-shopping-action">Keep shopping</a>
        </div> --}}

        {{-- <div class="shopping-container">

            <div class="shopping-container__left">
                <div class="shopping-list">
                    <div class="shopping-list__title"><span class="count"></span> khóa học trong giỏ hàng</div>
                    <div class="shopping-list__course" id="cart"></div>
                </div>

                <div class="shopping-list s4L">
                    <div class="shopping-list__title">Khóa học chờ thanh toán</div>
                    <div class="shopping-list__course" id="saved_for_later"></div>
                </div>
            </div>
            <div class="shopping-container__right">
                <div class="checkout">
                    <div class="checkout-box-total">
                        <div class="total-label">Tổng cộng:</div>
                        <div class="total-price">$<span class="price"></span></div>
                        <div class="btn-checkout">Thanh toán toàn bộ</div>
                        <div class="payment-method"></div>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>

        </div> --}}
    </div>
@endsection

@section('script')
    <script type="module" src="{{ asset('js/cart.js') }}"></script>
@endsection
