<div class="col-lg-3">
    <div class="main-sidebar">
        <div class="suggest-account-area mb-25">
            <h4><?php echo e(__('Suggested Accounts')); ?></h4>
            
            <?php 
            if (Auth::check()) {
                $trending_users = App\User::where([
                    ['role_id',2],
                    ['id','!=',Auth::User()->id]
                ])
                ->withCount('followers')
                ->withCount('videos')
                ->withCount('favourite_videos')
                ->orderBy('followers_count','desc')
                ->orderBy('videos_count','desc')
                ->orderBy('favourite_videos_count','desc')
                ->take('5')
                ->get();
                $suggested_users = App\User::where([
                    ['role_id',2],
                    ['id','!=',Auth::User()->id]
                ])->inRandomOrder()
                ->limit(5)
                ->get();
            }else{
                $trending_users = App\User::where('role_id',2)
                ->withCount('followers')
                ->withCount('videos')
                ->withCount('favourite_videos')
                ->orderBy('followers_count','desc')
                ->orderBy('videos_count','desc')
                ->orderBy('favourite_videos_count','desc')
                ->take('5')
                ->get();
                $suggested_users = App\User::where('role_id',2)
                ->inRandomOrder()->limit(5)
                ->get();
            }
            
            ?>
            <?php $__currentLoopData = $suggested_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="account-info">
                <div class="profile-info-sidebar">
                    <a href="<?php echo e(route('profile.show',$user->slug)); ?>" class="pjax d-flex">
                        <img src="<?php echo e(asset($user->image)); ?>" alt="">

                        <?php if($user->fire): ?>
                        <img src="/backend/assets/img/achievments/fire.svg" class="achievssmall">
                        <?php elseif($user->check): ?>
                        <img src="/backend/assets/img/achievments/check.svg" class="achievssmall">
                        <?php endif; ?>
                        <div class="profile-info d-block">
                            <h5><?php echo e(Str::limit($user->first_name, 10)); ?> <?php echo e(Str::limit($user->last_name,5)); ?></h5>
                            <p><?php echo e(Str::limit($user->username, 14)); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php 
        $sponsor = App\Sponsor::inRandomOrder()
        ->first();
        ?>
        <?php if($sponsor): ?>
        <div class="suggest-account-area mb-25">
            <a href="<?php echo e($sponsor->url); ?>" target="_blank">
                <h4><?php echo e(__('Sponsored')); ?></h4>
                <div class="sponsor-img">
                    <img class="img-fluid" src="<?php echo e(asset($sponsor->image)); ?>">
                </div>
                <div class="sponsor-title">
                    <h5><?php echo e($sponsor->title); ?></h5>
                    <p><?php echo e(parse_url($sponsor->url)['host']); ?></p>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <div class="suggest-account-area mb-25">
            <h4><?php echo e(__('Trending Accounts')); ?></h4>
            <?php $__currentLoopData = $trending_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="account-info">
                <div class="profile-info-sidebar">
                    <a href="<?php echo e(route('profile.show',$user->slug)); ?>" class="pjax d-flex">
                        <img src="<?php echo e(asset($user->image)); ?>" alt="">
                        <?php if($user->fire): ?>
                        <img src="/backend/assets/img/achievments/fire.svg" class="achievssmall">
                        <?php elseif($user->check): ?>
                        <img src="/backend/assets/img/achievments/check.svg" class="achievssmall">
                        <?php endif; ?>
                        <div class="profile-info d-block">
                            <h5><?php echo e(Str::limit($user->first_name,6)); ?> <?php echo e(Str::limit($user->last_name,5)); ?></h5>
                            <p><?php echo e(Str::limit($user->username,14)); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php 
        $pages = App\Page::all();
        ?>
        <div class="page-links">
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="pjax" href="<?php echo e(route('page.show',encrypt($page->id))); ?>"><?php echo e($page->title); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php 
        $option = App\Option::where('key', 'site_value')->first();
        $site_value = json_decode($option->value);
        ?>
        <div class="lang-social-actions d-flex">
            <div class="social-actions">
                <ul>
                    <li><a target="_blank" href="<?php echo e($site_value->facebook_url); ?>"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a target="_blank" href="<?php echo e($site_value->twitter_url); ?>"><i class="fab fa-twitter"></i></a></li>
                    <li><a target="_blank" href="<?php echo e($site_value->google_url); ?>"><i class="fab fa-google-plus-g"></i></a></li>
                </ul>
            </div>
            <?php 
            $language_file = file_get_contents(resource_path('json/lang.json'));
            $langs = json_decode($language_file);
            foreach ($langs as $key => $value) {
                if($value->code == App::getLocale())
                {
                    $default_lang = $value;
                }
            }
            ?>
            <div class="select-language ml-auto">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e($default_lang->name); ?></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-language">
                        <?php $__currentLoopData = App\Language::where('status','active')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="pjax dropdown-item" href="<?php echo e(route('lang.set',$lang->code)); ?>"><?php echo e($lang->name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-section">
            <p><?php echo e(__('© copyright')); ?> <?php echo e(date('Y')); ?> <?php echo e(__('by')); ?> <?php echo e($site_value->site_name); ?></p>
        </div>
    </div>
</div><?php /**PATH D:\Server\domains\qick.fun\script\resources\views/layouts/frontend/partials/sidebar.blade.php ENDPATH**/ ?>