<div class="ellipish-close-btn">
    <a href="javascript:void(0)" onclick="cancel_ellipish()"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17">
<g>
</g>
  <path d="M9.207 8.5l6.646 6.646-0.707 0.707-6.646-6.646-6.646 6.646-0.707-0.707 6.646-6.646-6.647-6.646 0.707-0.707 6.647 6.646 6.646-6.646 0.707 0.707-6.646 6.646z" fill="#ED4956" />
</svg></a>
</div>
<?php if(isset($video->user)): ?>
<input type="text" id="copy_link" value="/<?php echo e($video->user->slug); ?>/<?php echo e($video->id); ?>/<?php echo e($video->slug); ?>" class="offscreen" aria-hidden="true">
<?php endif; ?>
<div class="ellipish-list text-center">
  <nav>
    <ul>
      <li>
        <?php if(Auth::check()): ?>
        <a href="javascript:void(0)" class="active" onclick="report('<?php echo e($video->slug); ?>')"><?php echo e(__('Report Inappropriate')); ?></a>
        <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="active pjax" onclick="profileshow()"><?php echo e(__('Report Inappropriate')); ?></a>
        <?php endif; ?>
      </li>
<?php if(isset($video->user)): ?>
      <li><a class="pjax" href="<?php echo e(route('profile.show', $video->user->slug)); ?>" onclick="profileshow()"><?php echo e(__('View Profile')); ?></a></li>
<?php endif; ?>
<?php if(isset($video->user)): ?>
      <li><a target="__blank" href="/<?php echo e($video->user->slug); ?>/<?php echo e($video->id); ?>/<?php echo e($video->slug); ?>"><?php echo e(__('Go to video')); ?></a></li>
<?php endif; ?>
<?php if(isset($video->slug)): ?>
      <li><a href="javascript:void(0)" onclick="share('<?php echo e($video->slug); ?>')"><?php echo e(__('Share')); ?></a></li>
<?php endif; ?>
      <li><a href="javascript:void(0)" onclick="copy_link()"><?php echo e(__('Copy Link')); ?></a></li>
<?php if(isset($video->slug)): ?>
      <li><a href="javascript:void(0)" onclick="embed('<?php echo e($video->slug); ?>')"><?php echo e(__('Embed')); ?></a></li>
<?php endif; ?>
      <li><a href="javascript:void(0)" onclick="cancel_ellipish()"><?php echo e(__('Cancel')); ?></a>127</li>
    </ul>
  </nav>
</div><?php /**PATH D:\Server\domains\qick.fun\script\resources\views/ellipsis.blade.php ENDPATH**/ ?>