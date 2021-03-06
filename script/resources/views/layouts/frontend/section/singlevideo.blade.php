<div class="col-sm-6  col-lg-4 mb-25 d-flex justify-content-center">
<?php
	$extarr = explode('.', $video->url);
	$ext = end($extarr);
	$type = 'video/mp4';
	if ($ext == 'mov')
		$type = 'video/quicktime';
?>
  <div class="video-card videoblock" rel="{{ asset($video->url) }}" type="{{$type}}" slug="{{ $video->slug ? $video->slug : $video->id }}" id="videoblock_{{$video->id}}">
  <?php
	if ($md->isMobile())
	{
  ?>
	<img src="/thumbnails/{{$video->id}}.jpg" alt="" id="videoscreen_{{$video->id}}" onclick="popup('{{ $video->slug ? $video->slug : $video->id }}', 'https://qick.fun/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}')" class="videoscreen">
  <?php
	}
	else
	{
	?>
	<video preload="metadata" id="{{ $video->slug ? $video->slug : $video->id }}" onclick="popup('{{ $video->slug ? $video->slug : $video->id }}', 'https://qick.fun/{{$video->user->slug}}/{{$video->id}}/{{$video->slug}}', <?php print isset($vidcounter)?$vidcounter:'null' ?>)" loop="loop" muted="muted" onmouseover="mouseover('{{ $video->slug ? $video->slug : $video->id }}')" src="{{ asset($video->url) }}" onmouseout="mouseout('{{ $video->slug ? $video->slug : $video->id }}')"></video>
	<?php
	}
  ?>
    <div class="video-card-details-info">
      <div class="video-author-profile-img">
        <a class="pjax videolink" href="{{ route('profile.show', $video->user->slug) }}">
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
