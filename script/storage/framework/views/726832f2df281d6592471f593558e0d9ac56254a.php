<div class="col-sm-6  col-lg-4 mb-25 d-flex justify-content-center">
<?php
	$extarr = explode('.', $video->url);
	$ext = end($extarr);
	$type = 'video/mp4';
	if ($ext == 'mov')
		$type = 'video/quicktime';
?>
  <div class="video-card videoblock" rel="<?php echo e(asset($video->url)); ?>" type="<?php echo e($type); ?>" slug="<?php echo e($video->slug ? $video->slug : $video->id); ?>" id="videoblock_<?php echo e($video->id); ?>">
  <?php
	if ($md->isMobile())
	{
  ?>
	<img src="/thumbnails/<?php echo e($video->id); ?>.jpg" alt="" id="videoscreen_<?php echo e($video->id); ?>" onclick="popup('<?php echo e($video->slug ? $video->slug : $video->id); ?>', 'https://qick.fun/<?php echo e($video->user->slug); ?>/<?php echo e($video->id); ?>/<?php echo e($video->slug); ?>')" class="videoscreen">
  <?php
	}
	else
	{
	?>
	<video preload="metadata" id="<?php echo e($video->slug ? $video->slug : $video->id); ?>" onclick="popup('<?php echo e($video->slug ? $video->slug : $video->id); ?>', 'https://qick.fun/<?php echo e($video->user->slug); ?>/<?php echo e($video->id); ?>/<?php echo e($video->slug); ?>', <?php print isset($vidcounter)?$vidcounter:'null' ?>)" loop="loop" muted="muted" onmouseover="mouseover('<?php echo e($video->slug ? $video->slug : $video->id); ?>')" src="<?php echo e(asset($video->url)); ?>" onmouseout="mouseout('<?php echo e($video->slug ? $video->slug : $video->id); ?>')"></video>
	<?php
	}
  ?>
    <div class="video-card-details-info">
      <div class="video-author-profile-img">
        <a class="pjax videolink" href="<?php echo e(route('profile.show', $video->user->slug)); ?>">
			<img src="<?php echo e(asset($video->user->image)); ?>" alt=""></a>
            <?php if($video->user->check): ?>
            <img src="/backend/assets/img/achievments/check.svg" class="achievssmallhome">
            <?php elseif($video->user->fire): ?>
            <img src="/backend/assets/img/achievments/fire.svg" class="achievssmallhome">
            <?php endif; ?>
      </div>
      <div class="video-total-view">
       <a href="/<?php echo e($video->user->slug); ?>/<?php echo e($video->id); ?>/<?php echo e($video->slug); ?>"><i class="fas fa-play"></i> <?php echo e(App\Helpers\UserSystemInfo::conveter($video->view)); ?>

	   </a>
     </div>
   </div>
   <div class="loader<?php echo e($video->slug); ?> d-none">
     <div class="video-loader"></div>
   </div>
 </div>
</div>
<?php /**PATH D:\Server\domains\qick.fun\script\resources\views/layouts/frontend/section/singlevideo.blade.php ENDPATH**/ ?>