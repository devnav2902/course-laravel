@extends('layouts.master') @section('main-content')

  <div class="purchase-history-container">
    <div class="title">
      Lịch sử thanh toán
    </div>
    <div class="bars">
      <div class="bar__item">Courses</div>
    </div>

    <div class="purchase-content">
      @if (!count($courseBill))
        <div class="empty">
          <i class="fas fa-shopping-cart"></i>
          <p>Bạn chưa có bất kỳ thanh toán nào.</p>
        </div>
      @else
        <div class="list-item">
          <table>
            <thead>
              <tr>
                <th>Khóa học</th>
                <th>Ngày thanh toán</th>
                <th>Mã giảm giá</th>
                <th>Giá</th>
                <th>Thanh toán</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($courseBill as $course)
                <tr>
                  <td>{{ $course->title }}</td>
                  <td>{{ $course->created_at }}</td>
                  <td>{{ !empty($course->promo_code) ? $course->promo_code : 'Không có' }}</td>
                  <td>${{ $course->price }}</td>
                  <td>${{ $course->purchase }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

@endsection
@section('script')
@endsection
