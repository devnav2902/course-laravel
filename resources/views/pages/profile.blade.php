@extends('layouts.master')

@section('link')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('main-content')

  <div class="profile-page">
    <div class="profile-banner transparent-bgr">
      <div class="banner-wrap">
        <div class="title">Profile & settings</div>
      </div>
    </div>
    <div class="profile-main">
      <div class="main-wrap">
        <div class="bar">
          <div class="user">
            <form action="{{ route('uploadAvatar') }}" method="POST" class="profile-avatar"
              enctype="multipart/form-data">
              @csrf
              <label for="change-avatar" class="label-avatar">
                <img class="avatar" src="{{ asset($globalUser->avatar) }}" alt="" /></label>
              <input type="file" id="change-avatar" name="change-avatar">
              <label for="change-submit" class="change-avatar" class="save-avatar">Save</label>
              <input type="submit" value="Submit" id="change-submit">

              <div class="meta">
                <span id="name">{{ $globalUser->fullname }}</span>
                <span id="create_at">Ngày tạo:
                  {{ Auth::user()->created_at->toDateString() }}</span>
                @error('avatar')
                  <div class="message">{{ $message }}</div>
                @enderror
            </form>
          </div>
        </div>

      </div>

      @if (session('success'))
        <span class="message success">{{ session('success') }}</span>
      @elseif (session('fail'))
        <span class="message fail">{{ session('fail') }}</span>
      @endif

      <div class="form">
        <form action="{{ route('saveProfile') }}" method="POST" class="form-profile">
          @csrf
          <div class="title">Profile</div>
          <div class="form-group">

            <div class="group">
              <label for="fullname">Tên của bạn</label>
              <input class="@error('fullname') is-invalid @enderror" type="text"
                value="{{ old('fullname') ? old('fullname') : $globalUser->fullname }}" name="fullname" />
              @error('fullname')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <button type="submit" class="btn btn-form">
            Save</button>
        </form>
        <form action="{{ route('changePassword') }}" method="POST" class="form-profile">
          @csrf
          <div class="title">Đổi mật khẩu</div>
          <div class="form-group">
            <div class="group">
              <label for="old_password">Mật khẩu cũ</label>
              @error('message_password')
                <div class="message mb-1">{{ $message }}</div>
              @enderror
              <input value="{{ old('old_password') }}" class="@error('old_password') is-invalid @enderror"
                type="password" id="old_password" name="old_password" placeholder="" />
              @error('old_password')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="new_password">Mật khẩu mới</label>
              <input value="{{ old('new_password') }}" class="@error('new_password') is-invalid @enderror"
                type="password" id="new_password" name="new_password" placeholder="" />
              @error('new_password')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>

          </div>
          <button type="submit" class="btn btn-form">
            Save
          </button>
        </form>
        <form action="{{ route('changeBio') }}" method="POST" class="form-profile">
          @csrf
          <div class="title">Devco Profile</div>
          <div class="form-group">
            <div class="group">
              <label for="headline">Headline</label>
              <input value="{{ isset($globalUser->bio->headline) ? $globalUser->bio->headline : old('headline') }}"
                class="@error('headline') is-invalid @enderror" type="text" id="headline" name="headline"
                placeholder="" />
              @error('headline')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="bio">Giới thiệu</label>
              <textarea id="bio" cols="30" rows="10" class="@error('bio') is-invalid @enderror" type="text" id="bio"
                name="bio" placeholder="">
                                          {{ isset($globalUser->bio->bio) ? $globalUser->bio->bio : old('bio') }}
                                              </textarea>
              @error('bio')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="website">Website</label>
              <input type="text" id="website" name="website" placeholder=""
                value="{{ isset($globalUser->bio->website) ? $globalUser->bio->website : old('website') }}">
              @error('new_password')
                <div class=" message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="linkedIn">LinkedIn</label>
              <input type="text" id="linkedIn" class="@error('linkedin') is-invalid @enderror" name=" linkedIn"
                placeholder=""
                value="{{ isset($globalUser->bio->linkedin) ? $globalUser->bio->linkedin : old('linkedin') }}">
              @error('linkedin')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="youtube">Youtube</label>
              <input type="text" id="youtube" class="@error('youtube') is-invalid @enderror" name="youtube" placeholder=""
                value="{{ isset($globalUser->bio->youtube) ? $globalUser->bio->youtube : old('youtube') }}">
              @error('youtube')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="twitter">Twitter</label>
              <input type="text" id="twitter" name="twitter" class="@error('twitter') is-invalid @enderror" placeholder=""
                value="{{ isset($globalUser->bio->twitter) ? $globalUser->bio->twitter : old('twitter') }}">
              @error('twitter')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
            <div class="group">
              <label for="facebook">Facebook</label>
              <input type="text" id="facebook" name="facebook" class="@error('facebook') is-invalid @enderror"
                placeholder=""
                value="{{ isset($globalUser->bio->facebook) ? $globalUser->bio->facebook : old('facebook') }}">
              @error('facebook')
                <div class="message">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <button type="submit" class="btn btn-form">
            Save
          </button>
        </form>
      </div>
    </div>
  </div>
  </div>

@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

  <script>
    $("#bio").summernote({
      placeholder: "Hello stand alone ui",
      tabsize: 2,
      height: 120,
      toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline", "clear"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["table", ["table"]],
        ["insert", ["link", "picture", "video"]],
        ["view", ["fullscreen", "codeview", "help"]],
      ],
      callbacks: {
        onKeyup: function(contents, $editable) {
          $("#description").trigger("input");
        },
      },
    });
  </script>
  <script src="{{ asset('js/avatar.js') }}"></script>
@endsection
