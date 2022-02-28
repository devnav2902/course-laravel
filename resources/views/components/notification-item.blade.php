<li class="notification-item">
    <div class="notification-item__content">
        <a href="{{ route('entry-course', ['id' => $notifi->course_id]) }}">
        </a>
        <img src="https://image.shutterstock.com/image-vector/letter-dev-simple-logo-design-260nw-1784944118.jpg"
            alt="">
        <div class="notification-item__title">
            <span>
                {{ $notifi->entity->text_start }} <strong>{!! Str::limit($notifi->course->title, 40) !!}</strong>
                {{ $notifi->entity->text_end }}
            </span>
            <time>1 day ago</time>
        </div>
    </div>
</li>
