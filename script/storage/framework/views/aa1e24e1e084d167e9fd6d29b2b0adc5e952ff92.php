 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.title','data' => []]); ?>
<?php $component->withName('welcome.title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?><?php echo e($site_value->site_title); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<?php $__env->startSection('content'); ?>

<script src="/frontend/js/jquery.swipe.js"></script>
<script>
var videolink = "";
var videos = [];
  <?php
	if ($md->isMobile())
	{
  ?>
$("video, body").swipe({
  swipe:function(event, direction, distance, duration, fingerCount){
	if (direction == "left")
		NextVideo();
	else if (direction == "right")
		PrevVideo();
  },
  threshold:100
});
<?php
	}
?>

</script>
<!-- success-alert start -->
<div class="alert-message-area">
    <div class="alert-content">
        <h4 class="ale"><?php echo e(__('Your Settings Successfully Updated')); ?></h4>
    </div>
</div>
<!-- success-alert end -->

<!-- error-alert start -->
<div class="error-message-area">
    <div class="error-content">
        <h4 class="error-msg"><?php echo e(__('Your Settings Successfully Updated')); ?></h4>
    </div>
</div>
<!-- error-alert end -->

<!-- ellipsis modal -->
<div class="ellipish-modal d-none">
  <div class="ellipish-modal-content">

  </div>
</div>


<!-- modal -->
<div class="bg-modal d-none">
    <div class="close-btn">
        <a href="javascript:void(0)"><img src="<?php echo e(asset('frontend/img/cancel.png')); ?>"></a>
    </div>
    <div class="modal-content-area">

    </div>
</div>

<section>
	<input type="text" id="copy_link" value="hgghjg">
    <div class="main-area pt-50">
        <div class="container">
            <div class="row">
                <div class="col col-lg-7 offset-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-area-title">
                                <h2><?php echo e(__('Trending')); ?></h2>
                                <p><?php echo e(__('Watch the latest videos from our community')); ?></p>
                            </div>







                            <a href="/" rel="all" class="videopolfilter">All videos</a>
                            <a href="/category/0" rel="0" class="videopolfilter">Female</a>
                            <a href="/category/1" rel="1" class="videopolfilter">Male</a>
                            <a href="/category/2" rel="2" class="videopolfilter">Trans</a>
                            <a href="/category/3" rel="3" class="videopolfilter">Couple</a>

                        </div>
                    </div>
                    <?php echo csrf_field(); ?>
                    <div class="row justify-content-center" id="videoholder">
                        <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('layouts.frontend.section.singlevideo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="page-load-status">
                      <p class="infinite-scroll-request"></p>
                      <p class="infinite-scroll-error"><?php echo e(__('No more pages to load')); ?></p>
                    </div>
                </div>
                <?php echo $__env->make('layouts.frontend.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="popup_url" value="<?php echo e(route('popup')); ?>">
<input type="hidden" id="ellipsis_url" value="<?php echo e(route('ellipsis')); ?>">
<input type="hidden" id="asset_url" value="<?php echo e(route('welcome')); ?>">

<!-- copied to clipboard -->
<div class="copied">
  <p><?php echo e(__('Link copied to clipboard.')); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Server\domains\qick.fun\script\resources\views/welcome.blade.php ENDPATH**/ ?>