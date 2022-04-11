<?php if($notifications->count() > 0): ?>
<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="single-notification-colum">
	<a  href="<?php echo e(url($notification->link)); ?>" target="_blank" class="dropdown-item">
		<div class="notification-single-content d-flex">
			<img src="<?php echo e(asset($notification->user->image)); ?>">
			<div class="notification-content">
				<p><b><?php echo e($notification->user->username); ?></b> <?php echo e($notification->body); ?> </p>
				<time><?php echo e($notification->created_at->diffForHumans()); ?></time>
			</div>
		</div>
	</a>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH D:\Server\domains\qick.fun\script\resources\views/layouts/frontend/section/notification.blade.php ENDPATH**/ ?>