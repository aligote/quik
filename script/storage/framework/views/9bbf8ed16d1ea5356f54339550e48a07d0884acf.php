<div class="container-fluid">
<div id="leftarrow"></div>
    <div class="row">
        <div class="col-lg-7 p-0">
            <div class="video-section" onclick="play()">
                <video id='singlevideo' autoplay playsinline webkit-playsinline>
                    <source src='<?php echo e(asset($video->url)); ?>' type='video/mp4'>
                </video>
                <div class="video-action">
                    <a href="javascript:void(0)" class="play"><i class="fas fa-play"></i></a>
                </div>
            </div>
            <div class="volume-action">
                <input type="hidden" id="volume_img" value="<?php echo e(asset('frontend/img/volume.png')); ?>">
                <input type="hidden" id="muted_img" value="<?php echo e(asset('frontend/img/muted.png')); ?>">
                <input type="hidden" id="muted_img" value="<?php echo e(asset('frontend/img/muted.png')); ?>">
                <a href="javascript:void(0)" class="volume"><img class="volume_img" src="<?php echo e(asset('frontend/img/volume.png')); ?>"></a>
            </div> 
            <div id="proflink">
                <a href="<?php echo e(route('profile.show',$video->user->slug)); ?>" class="volume"><img src="<?php echo e(asset('frontend/img/profile.png')); ?>"></a>
            </div> 
            <div class="loader">
                <div class="video-single-loader"></div>
            </div>
            <div class="video-ads-append-area">
                
            </div>
        </div>
        <div class="col-lg-5 p-0">
            <div class="modal-right-section">
                <div class="user-top-info">
                    <div class="user-profile-info">
                        <a class="pjax" id="profilelink" href="<?php echo e(route('profile.show',$video->user->slug)); ?>" onclick="profileshow()"> <img src="<?php echo e(asset($video->user->image)); ?>" alt=""> <?php echo e($video->user->username); ?></a>
                    </div>
                    <div class="arrow-button">
                        <a href="javascript:void(0)" onclick="ellipsis_open('<?php echo e($video->slug); ?>')"><i class="fas fa-ellipsis-h"></i></a>
                    </div>
                </div>
                <div class="modal-comment-list">
					<h5 id="vidtitleh5"><?php echo e($video->title); ?></h5>
                    <?php $__currentLoopData = $video->comments()->where('parent_id',null)->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-comment">
                        <a class="pjax" href="<?php echo e(route('profile.show',$comment->user->slug)); ?>" onclick="profileshow()">
                            <img src="<?php echo e(asset($comment->user->image)); ?>" alt="">
                        </a>
                        <?php if($comment->user->fire): ?>
                        <img src="/backend/assets/img/achievments/fire.svg" class="achievscommentava">
                        <?php elseif($comment->user->check): ?>
                        <img src="/backend/assets/img/achievments/check.svg" class="achievscommentava">
                        <?php endif; ?>
                        <span> 
                            <a class="pjax" href="<?php echo e(route('profile.show', $comment->user->slug)); ?>" onclick="profileshow()"><?php echo e($comment->user->username); ?></a>
							<?php if($comment->user->heart): ?>
							<img src="/backend/assets/img/achievments/heart.svg" class="achievscommentlogin">
							<?php elseif($comment->user->diamond): ?>
							<img src="/backend/assets/img/achievments/diamond.svg" class="achievscommentlogin">
							<?php endif; ?>
                            <?php echo e($comment->message); ?> 
                            <div class="comment-info">
                                <span><?php echo e($comment->created_at->isoFormat('Do')); ?> <span id="comment_like_count<?php echo e($comment->id); ?>" class="likes"> <?php echo e($comment->favourite_to_user->count()); ?>likes</span><a href="javascript:void(0)" onclick="reply('<?php echo e($comment->id); ?>','<?php echo e($comment->user->username); ?>','<?php echo e($comment->user->id); ?>')"><?php echo e(__('Reply')); ?></a></span>
                            </div>
                        </span>
                        <input type="hidden" id="comment_like_url" value="<?php echo e(route('comment_like')); ?>">
                        <div class="favourite-icon">
                            <?php if(Auth::check()): ?>
                            <a href="javascript:void(0)" onclick="comment_like('<?php echo e($comment->id); ?>')"><i id="comment_like<?php echo e($comment->id); ?>" class="<?php echo e(!Auth::User()->favourite_comments->where('pivot.comment_id',$comment->id)->count() == 0 ? 'fas fa-heart' : 'far fa-heart'); ?>"></i></a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="pjax" onclick="profileshow()"><i id="like" class="far fa-heart"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-comment ml-50">
                        <a class="pjax" href="<?php echo e(route('profile.show',$value->user->slug)); ?>" onclick="profileshow()">
                            <img src="<?php echo e(asset($value->user->image)); ?>" alt="">
                        </a>
                        <?php if($value->user->fire): ?>
                        <img src="/backend/assets/img/achievments/fire.svg" class="achievscommentava">
                        <?php elseif($value->user->check): ?>
                        <img src="/backend/assets/img/achievments/check.svg" class="achievscommentava">
                        <?php endif; ?>
                        <span> 
                            <a class="pjax" href="<?php echo e(route('profile.show',$value->user->slug)); ?>" onclick="profileshow()"><?php echo e($value->user->username); ?></a>
							<?php if($value->user->heart): ?>
							<img src="/backend/assets/img/achievments/heart.svg" class="achievscommentlogin">
							<?php elseif($value->user->diamond): ?>
							<img src="/backend/assets/img/achievments/diamond.svg" class="achievscommentlogin">
							<?php endif; ?>
							<br><a class="username" href="<?php echo e($value->mention_id != null ? route('profile.show',$value->mention_user->slug) : ''); ?>" onclick="profileshow()"><?php echo e($value->mention_id != null ? $value->mention_user->username : ''); ?></a><?php echo e($value->message); ?> 
                            <div class="comment-info">
                                <span><?php echo e($value->created_at->isoFormat('Do')); ?> <span id="comment_like_count<?php echo e($value->id); ?>" class="likes"> <?php echo e($value->favourite_to_user->count()); ?>likes</span><a href="javascript:void(0)" onclick="reply('<?php echo e($value->main_comment->id); ?>','<?php echo e($value->user->username); ?>','<?php echo e($value->user->id); ?>')"><?php echo e(__('Reply')); ?></a></span>
                            </div>
                        </span>
                        <div class="favourite-icon">
                             <?php if(Auth::check()): ?>
                            <a href="javascript:void(0)" onclick="comment_like('<?php echo e($value->id); ?>')"><i id="comment_like<?php echo e($value->id); ?>" class="<?php echo e(!Auth::User()->favourite_comments->where('pivot.comment_id',$value->id)->count() == 0 ? 'fas fa-heart' : 'far fa-heart'); ?>"></i></a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="pjax" onclick="profileshow()"><i id="like" class="far fa-heart"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="modal-video-post-action">
                    <div class="modal-main-action">
                        <?php if(Auth::check()): ?>
                        <a href="javascript:void(0)" onclick="like('<?php echo e($video->id); ?>')"><i id="like" class="<?php echo e(!Auth::User()->favourite_videos->where('pivot.video_id',$video->id)->count() == 0 ? 'fas fa-heart' : 'far fa-heart'); ?>"></i></a>
                        <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="pjax" onclick="profileshow()"><i id="like" class="far fa-heart"></i></a>
                        <?php endif; ?>
                        <?php if(Auth::check()): ?>
                        <a href="javascript:void(0)"><label for="comment"><i class="far fa-comment"></i></label></a>
                        <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="pjax" onclick="profileshow()"><label for="comment"><i class="far fa-comment"></i></label></a>
                        <?php endif; ?>
                        <a href="javascript:void(0)" onclick="share('<?php echo e($video->slug); ?>')"><i class="far fa-paper-plane"></i></a>
                        <?php if(Auth::check()): ?>
                        <a href="javascript:void(0)" class="f-right" onclick="report('<?php echo e($video->slug); ?>')"><i class="far fa-flag"></i></a>
                        <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="pjax f-right" onclick="profileshow()"><i class="far fa-flag"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="modal-total-views">
                        <?php echo e(App\Helpers\UserSystemInfo::conveter($video->view)); ?> <?php echo e(__('views')); ?>

                    </div>
                    <div class="modal-video-date">
                        <?php echo e($video->created_at->isoFormat('LL')); ?>

                    </div>
                </div>
                <input type="hidden" id="like_url" value="<?php echo e(route('like')); ?>">
                <div class="send-comment-area">
                    <?php if(Auth::check()): ?>
                    <form action="<?php echo e(route('comment')); ?>" method="POST" id="comment_send">
                        <?php echo csrf_field(); ?>
                        <div class="d-flex">
                            <span class="d-none" id="comment_username">@arafat</span>
                            <input type="hidden" name="video_id" value="<?php echo e($video->id); ?>">
                            <input type="hidden" id="comment_parent" name="parent_id">
                            <input type="hidden" id="mention_id" name="mention_id">
                            <input type="text" id="comment" name="comment" autocomplete="off" placeholder="<?php echo e(__('Add a comment')); ?>">
                            <button type="submit" id="postcommbtn"><?php echo e(__('Post')); ?></button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="please-login text-center">
                        <p><?php echo e(__('Please')); ?> <a href="<?php echo e(route('login')); ?>" class="pjax" onclick="profileshow()"><?php echo e(__('Login')); ?></a> <?php echo e(__('or')); ?> <a href="<?php echo e(route('register')); ?>" class="pjax" onclick="profileshow()"><?php echo e(__('SignUp')); ?></a></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<div id="rightarrow"></div>
</div>
<input type="hidden" id="video_ads_url" value="<?php echo e(route('ads.show')); ?>">
<input type="hidden" id="report_url" value="<?php echo e(route('report.show')); ?>">
<script src="<?php echo e(asset('frontend/js/modal/modal.js')); ?>"></script><?php /**PATH D:\Server\domains\qick.fun\script\resources\views/modal.blade.php ENDPATH**/ ?>