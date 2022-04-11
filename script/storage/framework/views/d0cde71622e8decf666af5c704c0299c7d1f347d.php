<footer class="mt-70">
    <div class="footer-area pt-25 pb-25">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="footer-left-area">
                        <div class="page-links">
                            <?php 
                            $pages = App\Page::all();
                            ?>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="pjax" href="<?php echo e(route('page.show',encrypt($page->id))); ?>"><?php echo e($page->title); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php 
                $option = App\Option::where('key','site_value')->first();
                $site_value = json_decode($option->value);
                ?>
                <div class="col-lg-6">
                    <div class="copyright-section f-right">
                        <p><?php echo e(__('© copyright')); ?> <?php echo e(date('Y')); ?> <?php echo e(__('by')); ?> <?php echo e($site_value->site_name); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><?php /**PATH D:\Server\domains\qick.fun\script\resources\views/layouts/frontend/partials/footer.blade.php ENDPATH**/ ?>