@foreach($videos as $video)
<div class="col-lg-4 mb-25">
  <div class="video-card">
    <video preload="metadata" id='{{ $video->slug ? $video->slug : $video->id }}' onclick="popup('{{ $video->slug ? $video->slug : $video->id }}', 'https://qick.fun/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}')" loop muted="muted" onmouseover="mouseover('{{ $video->slug ? $video->slug : $video->id }}')" onmouseout="mouseout('{{ $video->slug ? $video->slug : $video->id }}')">
      <source src='{{ asset($video->url) }}' type='video/mp4'>
    </video>
    <div class="video-card-details-info">
      <div class="video-author-profile-img">
        <a class="pjax" href="{{ route('profile.show',$video->user->slug) }}">
			<img src="{{ asset($video->user->image) }}" alt=""></a>
            @if($video->user->check)
            <img src="/backend/assets/img/achievments/check.svg" class="achievssmallhome">
            @elseif($video->user->fire)
            <img src="/backend/assets/img/achievments/fire.svg" class="achievssmallhome">
            @endif
      </div>
      <div class="video-total-view">
       <a href="/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}"><i class="fas fa-play"></i> {{ App\Helpers\UserSystemInfo::conveter($video->view) }}
	   </a>
     </div>
   </div>
   <div class="loader{{ $video->slug }} d-none">
     <div class="video-loader"></div>
   </div>
 </div>
</div>
@endforeach