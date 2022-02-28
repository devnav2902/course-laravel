<div class="content">
  <!-- Accordion Box -->
  <ul class="accordion-box">
    <!-- Block -->
    @foreach ($course->section as $section)

      <li class="accordion block">
        <div class="acc-btn">
          <div class="icon-outer">
            <i class="up fas fa-angle-down"></i>
          </div>
          {!! $section->title !!}
        </div>

        <div class="acc-content">
          @foreach ($section->lecture as $lecture)
            <div class="content">
              <a href="#" class="play-media">
                <div class="pull-left">
                  <i class="fas fa-lock media-icon"></i>{!! $lecture->title !!}
                </div>
                {{-- <div class="pull-right">
                                    <div class="minutes">35 Minutes</div>
                                </div> --}}
              </a>
            </div>
            <!-- end content -->
          @endforeach
        </div>
      </li>
    @endforeach
  </ul>
</div>
