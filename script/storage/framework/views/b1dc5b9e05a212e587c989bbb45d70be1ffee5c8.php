<header>
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo-area">
                        <input type="hidden" id="logo_change_url" value="logo_change">
                        <?php
                        $option = App\Option::where('key','site_value')->first();
                        $option_value = json_decode($option->value);
                        ?>
                        <?php if(Session::has('mode')): ?>
                        <?php if(Session::get('mode')['id'] == 'night'): ?>
                         <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="logo_mode" src="<?php echo e(asset($option_value->light_logo)); ?>" alt=""></a>
                        <?php else: ?>
                         <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="logo_mode" src="<?php echo e(asset($option_value->dark_logo)); ?>" alt=""></a>
                        <?php endif; ?>
                        <?php else: ?>
                         <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="logo_mode" src="<?php echo e(asset($option_value->dark_logo)); ?>" alt=""></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-search-area">
                        <div class="header-searchbox text-center">
                            <input type="text" placeholder="<?php echo e(__('Search')); ?>" id="search" oninput="search()" autocomplete="off">
                            <input type="hidden" id="search_url" value="<?php echo e(route('search')); ?>">
                            <input type="hidden" id="base_url" value="<?php echo e(url('/')); ?>">
                        </div>
                        <div class="search-append">

                        </div>
                    </div>
                </div>
                <?php
                $option_currency = App\Option::where('key','currency')->first();
                $option_currency_value = json_decode($option_currency->value);
                ?>
                <input type="hidden" value="<?php echo e(env('PAYPAL_ID')); ?>" id="paypal_client_id">
                <input type="hidden" value="<?php echo e($option_currency_value->code); ?>" id="currency_code">
                <div class="col-lg-3">
                    <div class="header-right-section f-right">
                        <?php if(Auth::check()): ?>
                        <div class="upload-btn">
                            <?php if(Session::has('mode')): ?>
                            <?php if(Session::get('mode')['id'] == 'night'): ?>
                            <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="home_mode" class="home" src="<?php echo e(asset('frontend/img/white_home.png')); ?>" alt=""></a>
                            <?php else: ?>
                            <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="home_mode" class="home" src="<?php echo e(asset('frontend/img/home.png')); ?>" alt=""></a>
                            <?php endif; ?>
                            <?php else: ?>
                            <a class="pjax" href="<?php echo e(route('welcome')); ?>"><img id="home_mode" class="home" src="<?php echo e(asset('frontend/img/home.png')); ?>" alt=""></a>
                            <?php endif; ?>
                        </div>
                        <div class="upload-btn">
                            <div class="notification-menu">
                                <?php
                                $notifications = App\Notification::with('user')->where([
                                    ['parent_id',Auth::User()->id],
                                ])->orderBy('id','DESC')->get();
                                $notification_count = App\Notification::where([
                                    ['parent_id',Auth::User()->id],
                                    ['status','unread']
                                ])->get();
                                ?>
                                <?php if(Session::has('mode')): ?>
                                <?php if(Session::get('mode')['id'] == 'night'): ?>
                                <a href="#" onclick="notification_unread()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="notification_mode" src="<?php echo e(asset('frontend/img/white_notification.png')); ?>" alt=""></a>
                                <?php else: ?>
                                <a href="#" onclick="notification_unread()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="notification_mode" src="<?php echo e(asset('frontend/img/notification.png')); ?>" alt=""></a>
                                <?php endif; ?>
                                <?php else: ?>
                                <a href="#" onclick="notification_unread()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="notification_mode" src="<?php echo e(asset('frontend/img/notification.png')); ?>" alt=""></a>
                                <?php endif; ?>
                                <div class="notification-count">
                                    <span class="notification_count <?php echo e($notification_count->count() > 0 ? '' : 'd-none'); ?>"><?php echo e($notification_count->count()); ?></span>
                                </div>
                                <div class="dropdown-menu dropdown-notification dropdown-menu-right">
                                    <div class="notification-check">
                                        <?php if($notifications->count() > 0): ?>
                                        <div class="notification-title">
                                            <span>Notification</span>
                                        </div>
                                        <div class="notification-list">
                                            <?php echo $__env->make('layouts.frontend.section.notification',$notifications, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <?php else: ?>
                                        <div class="not-found text-center">
                                            <span><?php echo e(__('No Result Found.')); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="upload-btn">
                            <?php if(Session::has('mode')): ?>
                            <?php if(Session::get('mode')['id'] == 'night'): ?>
                             
                               <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Upload <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php else: ?>
                             
                              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Upload <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php endif; ?>
                            <?php else: ?>
                             
                              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Upload <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php endif; ?>
                        </div>
                        <div class="profile-seeting">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="profile" src="<?php echo e(asset(Auth::User()->image)); ?>" alt=""></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo e(route('profile.show',Auth::User()->slug)); ?>" class="pjax dropdown-item"><?php echo e(Auth::User()->first_name); ?> <?php echo e(Auth::User()->last_name); ?></a>
                                <a href="<?php echo e(route('profile.edit')); ?>" class="pjax dropdown-item"><?php echo e(__('Edit Profile')); ?></a>
                                <a href="<?php echo e(route('settings')); ?>" class="dropdown-item"><?php echo e(__('Settings')); ?></a>
                                <div class="dropdown-border">
                                    <a href="<?php echo e(route('ads.index')); ?>" class="dropdown-item"><?php echo e(__('Advertising')); ?></a>
                                </div>
                                <div class="dropdown-border">
                                    <a href="<?php echo e(route('trending')); ?>" class="pjax dropdown-item"><?php echo e(__('Trending')); ?></a>
                                    <a href="<?php echo e(route('latest')); ?>" class="pjax dropdown-item"><?php echo e(__('Latest')); ?></a>
                                    <a href="<?php echo e(route('popular')); ?>" class="pjax dropdown-item"><?php echo e(__('Most View')); ?></a>
                                    <a href="<?php echo e(route('users')); ?>" class="pjax dropdown-item"><?php echo e(__('Find Users')); ?></a>
                                </div>
                                <?php if(Auth::User()->role_id == 1): ?>
                                <div class="dropdown-border">
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="dropdown-item"><?php echo e(__('Admin Panel')); ?></a>
                                </div>
                                <?php endif; ?>
                                <div class="dropdown-border">
                                    <a href="<?php echo e(route('user.logout')); ?>" class="dropdown-item"><?php echo e(__('Logout')); ?></a>
                                </div>
                                <div class="dropdown-border">
                                    <input type="hidden" id="mode_url" value="<?php echo e(route('mode')); ?>">
                                    <?php if(Session::has('mode')): ?>
                                    <?php if(Session::get('mode')['id'] == 'day'): ?>
                                    <a href="#" id="mode_action" onclick="mode()" class="dropdown-item"><?php echo e(__('Night Mode')); ?> <div class="mode night"><i class="far fa-moon"></i></div></a>
                                    <?php endif; ?>
                                    <?php if(Session::get('mode')['id'] == 'night'): ?>
                                    <a href="#" id="mode_action" onclick="mode()" class="dropdown-item"><?php echo e(__('Day Mode')); ?> <div class="mode day"><i class="far fa-sun"></i></div></a>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <a href="#" id="mode_action" onclick="mode()" class="dropdown-item"><?php echo e(__('Night Mode')); ?> <div class="mode night"><i class="far fa-moon"></i></div></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="upload-btn d-block mr-2 ">
                            <?php if(Session::has('mode')): ?>
                            <?php if(Session::get('mode')['id'] == 'night'): ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                
                                Upload
                             <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php else: ?>
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Upload <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php endif; ?>
                            <?php else: ?>
                              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelinkupload','data' => []]); ?>
<?php $component->withName('welcome.homelinkupload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>Upload <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <?php endif; ?>
                        </div>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.welcome.homelink','data' => []]); ?>
<?php $component->withName('welcome.homelink'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Login')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<input type="hidden" id="notification_url" value="<?php echo e(route('notification')); ?>">
<input type="hidden" id="notification_count" value="<?php echo e(route('notification_count')); ?>">
<input type="hidden" id="notification_unread" value="<?php echo e(route('notification_unread')); ?>">
<?php /**PATH D:\Server\domains\qick.fun\script\resources\views/layouts/frontend/partials/header.blade.php ENDPATH**/ ?>