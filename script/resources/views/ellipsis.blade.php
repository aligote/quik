<div class="ellipish-close-btn">
    <a href="javascript:void(0)" onclick="cancel_ellipish()"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17">
<g>
</g>
  <path d="M9.207 8.5l6.646 6.646-0.707 0.707-6.646-6.646-6.646 6.646-0.707-0.707 6.646-6.646-6.647-6.646 0.707-0.707 6.647 6.646 6.646-6.646 0.707 0.707-6.646 6.646z" fill="#ED4956" />
</svg></a>
</div>
@if(isset($video->user))
<input type="text" id="copy_link" value="/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}" class="offscreen" aria-hidden="true">
@endif
<div class="ellipish-list text-center">
  <nav>
    <ul>
      <li>
        @if(Auth::check())
        <a href="javascript:void(0)" class="active" onclick="report('{{ $video->slug }}')">{{ __('Report Inappropriate') }}</a>
        @else
        <a href="{{ route('login') }}" class="active pjax" onclick="profileshow()">{{ __('Report Inappropriate') }}</a>
        @endif
      </li>
@if(isset($video->user))
      <li><a class="pjax" href="{{ route('profile.show', $video->user->slug) }}" onclick="profileshow()">{{ __('View Profile') }}</a></li>
@endif
@if(isset($video->user))
      <li><a target="__blank" href="/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}">{{ __('Go to video') }}</a></li>
@endif
@if(isset($video->slug))
      <li><a href="javascript:void(0)" onclick="share('{{ $video->slug }}')">{{ __('Share') }}</a></li>
@endif
      <li><a href="javascript:void(0)" onclick="copy_link()">{{ __('Copy Link') }}</a></li>
@if(isset($video->slug))
      <li><a href="javascript:void(0)" onclick="embed('{{ $video->slug }}')">{{ __('Embed') }}</a></li>
@endif
      <li><a href="javascript:void(0)" onclick="cancel_ellipish()">{{ __('Cancel') }}</a>127</li>
    </ul>
  </nav>
</div>