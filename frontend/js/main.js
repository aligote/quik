(function($) {
    "use strict";
   

    /*---------------------------------
           Settings Menu Class Active
        -------------------------------------*/
    $('.settings-menu').on('click','li',function(){
        $(this).addClass('active').siblings().removeClass('active');
    });


    /*---------------------------------
            Data Append
        -------------------------------------*/
    var asset_url = $('#asset_url').val();
    if ($('*').hasClass('grid')){
        var elem = document.querySelector('.grid');
        var infScroll = new InfiniteScroll( elem, {
            // options
            path: asset_url+'?page={{#}}',
            append: '.col-lg-4',
            history: false,
            status: '.page-load-status'
        });
    }
    
    /*---------------------------------
            Data Append with Pjax
        -------------------------------------*/
    $(document).on('pjax:complete', function(){
        if ($('*').hasClass('grid')){
            var elem = document.querySelector('.grid');
            var infScroll = new InfiniteScroll( elem, {
              // options
              path: asset_url+'?page={{#}}',
              append: '.col-lg-4',
              history: false,
              status: '.page-load-status'
          });
        }
        $('.settings-menu').on('click','li',function(){
            $(this).addClass('active').siblings().removeClass('active');
        });
    });
	$("#addpersonbtn").click(function()
	{
		$("#verifiedmsg").hide();
		$("#verifyform").show();
	});
    
    /*------------------------------
            Video Upload With Pjax
        ------------------------------------*/
    $(document).on('pjax:complete', function(){
        $('#video_upload').on('change',function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = $('#video_url').val();
            let form = document.getElementById('video_form');
            let formdata = new FormData(form);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('.video_percentence_number').html(percentComplete.toFixed(0)+'%');
                            $('.percent').addClass('value'+percentComplete.toFixed(0));
                            if (percentComplete.toFixed(0) == 100){
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('.video-upload-input-area').addClass('p-0');
                                    //$('.video-upload-input-area').html('<video controls autoplay muted="muted"><source src="'+e.target.result+'" type="video/mp4"></video>');
                                }
                                reader.readAsDataURL(e.target.files[0]);
                            }
                        }
                    }, false);
                    return xhr;
                },
                url: url,
                data: formdata,
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.video-upload-input-area').html('<div class="box"><div class="percent"><svg><circle cx="70" cy="70" r="70"></circle><circle cx="70" cy="70" r="70"></circle></svg></div><div class="number"><h2 class="video_percentence_number">0%</h2></div></div>');
                },
                success: function(response) {
                    var base_url = $('#base_url').val();
                    if (response.errors)
                    {
                        $('.error-message-area').fadeIn();
                        $('.error-msg').html(response.errors);
                        $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                        $.pjax({url: base_url+'/upload', container: '#pjax-container'});
                    }
					else
					{
                       $('.video-upload-input-area').append(response);
						if ($('#caption').val() && $('#video_path').val() && $("#ihaveobtained").is(":checked"))
							$('#upload_btn').removeClass('disabled');
						else
							$('#upload_btn').addClass('disabled');
                    }
                }
            });
        });
    });

   /*------------------------
            Video Upload
        -----------------------------*/
    $('#video_upload').on('change',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = $('#video_url').val();
        let form = document.getElementById('video_form');
        let formdata = new FormData(form);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $('.video_percentence_number').html(percentComplete.toFixed(0)+'%');
                        $('.percent').addClass('value'+percentComplete.toFixed(0));
                        if (percentComplete.toFixed(0) == 100){
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('.video-upload-input-area').addClass('p-0');
                                //$('.video-upload-input-area').html('<video controls autoplay muted="muted"><source src="'+e.target.result+'" type="video/mp4"></video>');
                            }
                            reader.readAsDataURL(e.target.files[0]);
                        }
                    }
                }, false);
                return xhr;
            },
            url: url,
            data: formdata,
            type: "POST",
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.video-upload-input-area').html('<div class="box"><div class="percent"><svg><circle cx="70" cy="70" r="70"></circle><circle cx="70" cy="70" r="70"></circle></svg></div><div class="number"><h2 class="video_percentence_number">0%</h2></div></div>');
            },
            success: function(response) {
                var base_url = $('#base_url').val();
                if (response.errors)
                {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html(response.errors);
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $.pjax({url: base_url+'/upload', container: '#pjax-container'});
                }else{
					$('.video-upload-input-area').append(response);
					$("#submit_post").append(response);
					if ($('#caption').val() && $('#video_path').val() && $("#ihaveobtained").is(":checked"))
						$('#upload_btn').removeClass('disabled');
					else
						$('#upload_btn').addClass('disabled');
                }
            }
        });
    });
	
    /*-----------------------
            Post Submit
        ---------------------------*/
    $('#submit_post').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = $('#post_url').val();
        let form = document.getElementById('submit_post');
        let formdata = new FormData(form);
        formdata.append('video_file',$('#video_path').val());
        $.ajax({
            url: this.action,
            data: formdata,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#upload_btn').html('Please Wait...');
            },
            success: function(response) {
                if (response.errors)
                {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html(response.errors);
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('#upload_btn').html('Post');
                }else{
                    $('#upload_btn').html('Post');
                    var url = $('#base_url').val();
                    $('.ellipish-modal').removeClass('d-none');
                    $('.ellipish-close-btn').fadeOut();
                    $('.ellipish-modal-content').html('<div class="upload_success"><i class="fas fa-check"></i><h4>Your video successfully uploaded</h4><a class="pjax" href="'+url+'/upload">Upload Another Video</a><a class="pjax" href="'+url+'/user/'+response+'">View Profile</a></div>');
                }
            }
        });
    });
    /*------------------------------

            Post Submit With Pjax
        ------------------------------------*/
    $(document).on('pjax:complete', function(){
        $('#submit_post').on('submit',function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = $('#post_url').val();
            let form = document.getElementById('submit_post');
            let formdata = new FormData(form);
            formdata.append('video_file',$('#video_path').val());
            $.ajax({
                url: this.action,
                data: formdata,
                type: "POST",
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#upload_btn').html('Please Wait...');
                },
                success: function(response) {
                    if (response.errors)
                    {
                        $('.error-message-area').fadeIn();
                        $('.error-msg').html(response.errors);
                        $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                        $('#upload_btn').html('Post');
                    }else{
                        $('#upload_btn').html('Post');
                        var url = $('#base_url').val();
                        $('.ellipish-modal').removeClass('d-none');
                        $('.ellipish-close-btn').fadeOut();
                        $('.ellipish-modal-content').html('<div class="upload_success"><i class="fas fa-check"></i><h4>Your video successfully uploaded</h4><a class="pjax" href="'+url+'/upload">Upload Another Video</a><a class="pjax" href="'+url+'/user/'+response+'">View Profile</a></div>');
                    }
                }
            });
        });
    });


})(jQuery);


/*------------------------------
        Ellipsis Modal Open
    ------------------------------------*/
function ellipsis(slug)
{
    var url = $("#ellipsis_url").val();
    $.ajax({
        url: url,
        data: { slug: slug },
        type: "GET",
        dataType: "HTML",
        beforeSend: function() {
            $('.ellipish-modal-content').html('<div class="ellipish-list text-center"> <nav><ul><li><a href="javascript:report(\'' + slug + '\');" class="active">Report Inappropriate</a></li><li><a href="' + $("#profilelink").attr("href") + '" target="_blank">View Profile</a></li><li><a href="' + $("#copy_link").val() + '">Go to video</a></li><li id="sharebtns"><a href="https://t.me/share/url?url=' + $("#copy_link").val() + '&text=' + $("#vidtitleh5").html() + '" target="_blank" id="sharereddit"><img src="/frontend/img/reddit.png"></a><a href="https://twitter.com/intent/tweet?url=' + $("#copy_link").val() + '" target="_blank" id="sharetelegram"><img src="/frontend/img/reddit.png"></a><a href="http://www.reddit.com/submit?url=' + $("#copy_link").val() + '&title=' + $("#vidtitleh5").html() + '" target="_blank" id="sharetwitter"><img src="/frontend/img/reddit.png"></a></li><li><a href="javascript:copy_link();">Copy Link</a></li><li><a href="javascript:void(0)">Embed</a></li><li><a href="javascript:cancel_ellipish()">Cancel</a></li></ul> </nav></div>');
        },
        success: function(response) {
            $('.ellipish-modal-content').html(response);
        }
    });
}

/*---------------------------------
        Ads Show in video section
    ------------------------------------*/
	
function copy_link()
{
	navigator.clipboard.writeText("ghfghgf")
  .then(() => {
    // ????????????????????!
  })
  .catch(err => {
    console.log('Something went wrong', err);
  });
}

function ads(slug)
{
    var url = $("#video_ads_url").val();
    $.ajax({
        url: url,
        data: { slug: slug },
        type: "GET",
        dataType: "HTML",
        beforeSend: function() {
        },
        success: function(response) {
            $('.video-ads-append-area').html(response);
        }
    });
}

var popupshow = false, curvideo, curvidnum = 0;

/*------------------------------
        Modal Popup data Append
    ------------------------------------*/
function popup(slug, videourl, counter = 0)
{
	if (counter)
		curvidcounter = counter;
	$("#copy_link").val(videourl);
    var url = $("#popup_url").val();
    $.ajax({
        url: url,
        data: { slug: slug },
        type: "GET",
        dataType: "HTML",
        beforeSend: function() {
            $('.loading').removeClass('d-none');
        },
        success: function(response) {
            $('.loading').addClass('d-none');
            $('.bg-modal').removeClass('d-none');
            $('.modal-content-area').html(response);
            ellipsis(slug);
            ads(slug);
			//$("#leftarrow").hide();
			setTimeout("HideCloseBtn()", 3000);
			if (curvidcounter < videolist.length - 1)
				$("#rightarrow").show();
			else
				$("#rightarrow").css("display", "none");
			if (curvidcounter == 0)
				$("#leftarrow").css("display", "none");
			else
				$("#leftarrow").show();
       }
    });
	popupshow = true;
	videos = [];
	videos.push(slug);
	curvideo = slug;
	curvidnum = 0;
}

var curvidcounter = 0;
function NextVideo()
{
	//$('.loading').removeClass('d-none');
	if (typeof isprofile !== "undefined")
	{
		curvidcounter ++;
		if (curvidcounter < videolist.length)
		{
			$("#leftarrow").show();
			var url = $("#popup_url").val();
			$.ajax({
				url: url,
				data: { slug: videolist[curvidcounter] },
				type: "GET",
				dataType: "HTML",
				beforeSend: function() {
					//$('.loading').removeClass('d-none');
				},
				success: function(response) {
					$('.loading').addClass('d-none');
					$('.bg-modal').removeClass('d-none');
					$('.modal-content-area').html(response);
					ellipsis(videolist[curvidcounter]);
					ads(videolist[curvidcounter]);
					curvidnum ++;
					setTimeout("HideCloseBtn()", 3000);
					if (curvidcounter < videolist.length - 1)
						$("#rightarrow").show();
					else
						$("#rightarrow").css("display", "none");
				}
			});
		}
	}
	else
	{
		$.post("/video/genrandvid", {videos: videos, pol: curpol}, function(data)
		{
			if (data)
			{
				$("#leftarrow").show();

				var url = $("#popup_url").val();
				$.ajax({
					url: url,
					data: { slug: data },
					type: "GET",
					dataType: "HTML",
					beforeSend: function() {
						//$('.loading').removeClass('d-none');
					},
					success: function(response) {
						$('.loading').addClass('d-none');
						$('.bg-modal').removeClass('d-none');
						$('.modal-content-area').html(response);
						ellipsis(data);
						ads(data);
						curvidnum ++;
						$("#rightarrow").show();
						setTimeout("HideCloseBtn()", 3000);
					}
				});
			}
			else
			{
				$("#rightarrow").hide();
				$('.loading').addClass('d-none');
			}
		});
	}
	popupshow = true;
}

function HideCloseBtn()
{
	$(".volume-action").hide();
	$("#proflink").hide();
	$(".close-btn").hide();
}

function PrevVideo()
{
	if (typeof isprofile !== "undefined")
	{
		curvidcounter --;
		if (curvidcounter >= 0)
		{
			$("#leftarrow").show();
			var url = $("#popup_url").val();
			$.ajax({
				url: url,
				data: { slug: videolist[curvidcounter] },
				type: "GET",
				dataType: "HTML",
				beforeSend: function() {
					//$('.loading').removeClass('d-none');
				},
				success: function(response) {
					$('.loading').addClass('d-none');
					$('.bg-modal').removeClass('d-none');
					$('.modal-content-area').html(response);
					ellipsis(videolist[curvidcounter]);
					ads(videolist[curvidcounter]);
					curvidnum ++;
					$("#rightarrow").show();
					setTimeout("HideCloseBtn()", 3000);
					if (curvidcounter == 0)
						$("#leftarrow").css("display", "none");
					else
						$("#leftarrow").show();
				}
			});
		}
	}
	else
	{
		if (!curvidnum)
		{
			$("#leftarrow").hide();
			return;
		}
		curvidnum --;
		//$('.loading').removeClass('d-none');
		
		$("#leftarrow").show();

		var url = $("#popup_url").val();
		$.ajax({
			url: url,
			data: { slug: videos[curvidnum] },
			type: "GET",
			dataType: "HTML",
			beforeSend: function() {
				//$('.loading').removeClass('d-none');
			},
			success: function(response) {
				$('.loading').addClass('d-none');
				$('.bg-modal').removeClass('d-none');
				$('.modal-content-area').html(response);
				ellipsis(videos[curvidnum]);
				ads(videos[curvidnum]);
				setTimeout("HideCloseBtn()", 3000);
			}
		});
		popupshow = true;
	}
}

/*-------------------
        Video Play
    -------------------------*/
function play() {

    var myVideo = document.getElementById("singlevideo");
    if (myVideo.paused) {
        myVideo.play();
        $('.video-action a.play').fadeOut();
    } else {
        myVideo.pause();
        $('.video-action a.play').fadeIn();
    }

}

/*-------------------
        Video Play
    -------------------------*/
function single_play() {

    var myVideo = document.getElementById("singlevideo");
    if (myVideo.paused) {
        myVideo.play();
        $('.video-action a.single_play').fadeOut();
    }else{
        myVideo.pause();
        $('.video-action a.single_play').fadeIn();
    }

}

/*------------------------
        Video Mousrover
    -----------------------------*/
function mouseover(id)
{

    var getid = document.getElementById(id);

    var mediaPlayer;
    
    let slowInternetTimeout = null;

    let threshold = 500;
    
    getid.addEventListener('waiting', () => {
        slowInternetTimeout = setTimeout(() => {
            $('.loader'+id).removeClass('d-none');
        }, threshold);
    });
    getid.addEventListener('playing', () => {
        if (slowInternetTimeout != null){
            clearTimeout(slowInternetTimeout);
            slowInternetTimeout = null;
        }
    });
    
    getid.addEventListener('canplay', () => {
        $('.loader'+id).addClass('d-none');
    });

    mediaPlayer = getid;
    mediaPlayer.play();

}

/*-------------------
        Video Mouseout
    -------------------------*/
function mouseout(id)
{
    var mediaPlayer;
    mediaPlayer = document.getElementById(id);
    mediaPlayer.pause();

}

/*-----------------------------
        Caption Length Check
    -------------------------------*/
function mycaption()
{
	if ($('#caption').val() && $('#video_path').val() && $("#ihaveobtained").is(":checked"))
        $('#upload_btn').removeClass('disabled');
	else
        $('#upload_btn').addClass('disabled');
}

/*-------------------
        Plus Count
    -------------------------*/
var l = $('#total_limit').val();
function limit_plus() {
    l++;
    document.getElementById('total_limit').value = l;
}

/*-------------------
        Minus Count
    -------------------------*/
function limit_minus() {
    if ($('#total_limit').val() > 1)
    {
        l --;
        document.getElementById('total_limit').value = l;
    }
}

/*--------------------------
        Image Preview Show
    -----------------------------*/
$(document).on("click", function()
{
	if (popupshow)
	{
		$(".close-btn").show();
		$(".volume-action").show();
		$("#proflink").show();
		setTimeout("HideCloseBtn()", 3000);
	}
});

$(document).on('pjax:complete', function(){
    $('#ads_media').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#ads_label").css("background-image", "url("+e.target.result+")");
            $("#ads_label i").fadeOut();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
});

$(document).on("change", "#ihaveobtained", function()
{
	if ($('#caption').val() && $('#video_path').val() && $("#ihaveobtained").is(":checked"))
		$('#upload_btn').removeClass('disabled');
	else
		$('#upload_btn').addClass('disabled');
});

$(document).on("keypress", "#caption", function()
{
	mycaption();
});

var curpol = "all";
$(document).on("click", ".videopolfilter", function()
{
	let pol = $(this).attr("rel")
	curpol = pol
	$(".videopolfilter").removeClass("activepol")
	$(this).addClass("activepol")
    console.log($.post('video/videopol'));
	$.post('video/videopol', {pol: pol}, function(data)
	{
        
		$("#videoholder").html(data);
		$("#results").html(data);
	});
});

$(document).on("click", "#rightarrow", function()
{
	NextVideo();
});

var showregpass = true;
$(document).on("click", "#showregpass", function()
{
	if (showregpass){
		showregpass = false;
		$('#password').attr('type', 'text');

	} else {
		showregpass = true;
		$('#password').attr('type', 'password');

	}
});

$(document).on("click", "#leftarrow", function()
{
	PrevVideo();
});

$(document).on("click", "#regbtn", function()
{
	if ($("#username").val().length < 3 || $("#username").val().length > 20)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of username must be from 3 to 20 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#first_name").val().length < 3 || $("#first_name").val().length > 50)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of first name must be from 3 to 50 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
 	if (typeof inp !== "undefined")
	{
		$("#regform").append(inp);
	}
});

$(document).on("click", "#upload_btn", function()
{
	if ($("#caption").val().length < 5 || $("#caption").val().length > 150)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of Caption must be from 5 to 150 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
});

$(document).on("click", "#postcommbtn", function()
{
	if ($("#comment").val().length > 150)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of comment must be less than 150 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
});

var videobg, curvid;
/*$(document).on("mouseenter", ".videoblock", function()
{
	if (curvid == $(this).attr("id"))
		return;
	$("#videoscreen_" + $(this).attr("id").replace("videoblock_", "")).hide();
	$(this).find("video").remove();
	$(this).append('<video id="' + $(this).attr("slug") + '" onclick="popup(\'' + $(this).attr("slug") + '\')" loop="loop" muted="muted" onmouseover="mouseover(\'' + $(this).attr("slug") + '\')" src="' + $(this).attr("rel") + '"></video>');
	curvid = $(this).attr("id");
});

$(document).on("mouseleave", ".videoblock", function()
{
	$(this).find("video").remove();
	$("#videoscreen_" + $(this).attr("id").replace("videoblock_", "")).show();
});*/

$(document).on("click", "#updatesettingbtn", function()
{
	if ($("#biotext").val().length > 150)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field About me must be less than 150 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#onlyfans").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Onlyfans must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#instagram").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Instagram must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#youtube").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Youtube must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#twitch").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Twitch must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#twitter").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Twitter must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#reddit").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Reddit must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
	if ($("#offwebsite").val().length > 100)
	{
		$('.error-message-area').fadeIn();
		$('.error-msg').html("Length of field Official website must be less than 100 characters.");
		$(".error-message-area").delay( 5000 ).fadeOut( 2000 );
		return false;
	}
});

$(document).on("click", "#iagreebtn", function()
{
	document.cookie = "iagree=1; max-age=2592000";
	$("#overlay").fadeOut(500);
	$(".welcome_form").fadeOut(500);
});

/*-------------------
        Video Mouseout
    -------------------------*/
$('#ads_media').on('change',function(){
    var reader = new FileReader();
    reader.onload = function (e) {
        $("#ads_label").css("background-image", "url("+e.target.result+")");
        $("#ads_label i").fadeOut();
    }
    reader.readAsDataURL(event.target.files[0]);
});

/*-----------------------
        Ads Form Submit
    -------------------------*/
$('#ads_form').on('submit', function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: this.action,
        data: new FormData(this),
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('.ads_button').html('Please Wait');
        },
        success: function(response) {
            if (response.errors) 
            {
                $('.error-message-area').fadeIn();
                $('.error-msg').html(response.errors);
                $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }

            if (response == 'wallet_error') {
                $('.error-message-area').fadeIn();
                $('.error-msg').html('Your Balance is not Available');
                $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }

            if (response == 'ok')
            {
                var url = $('#ads_url').val();
                $.pjax({url: url, container: '#pjax-container'});
                $('.alert-message-area').fadeIn();
                $(".alert-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }
        }
    });
});

/*---------------------------------
        Ads Form Submit With Pjax
    ----------------------------------*/
$(document).on('pjax:complete', function(){
    $('#ads_form').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: this.action,
            data: new FormData(this),
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.ads_button').html('Please Wait...');
            },
            success: function(response) {
                if (response.errors) 
                {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html(response.errors);
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }


                if (response == 'wallet_error') {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html('Your Balance is not Available');
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }

                if (response == 'ok')
                {
                    var url = $('#ads_url').val();
                    $.pjax({url: url, container: '#pjax-container'});
                    $('.alert-message-area').fadeIn();
                    $(".alert-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }
            }
        });
    });
});

/*-----------------------
        Ads Close
    -------------------------*/
function ads_close()
{
    $('.video-ads-append-area').fadeOut();
}

/*-----------------------
        Ads Delete
    -------------------------*/
function ads_delete(id)
{
    if (confirm('Are You sure to delete this?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var ads_delete_url = $('#ads_delete_url').val();
        $.ajax({
            url: ads_delete_url,
            data: {id: id},
            type: "GET",
            dataType: "HTML",
            success: function(response) {
                if (response == 'ok') {
                    var url = $('#ads_url').val();
                    $.pjax({url: url, container: '#pjax-container'});
                    $('.alert-message-area').fadeIn();
                    $('.ale').html('Your Advertising successfully deleted');
                    $(".alert-message-area").delay( 5000 ).fadeOut( 2000 );
                }
                console.log(response);
            }
        });
    }
}

/*-----------------------
        Ads Form Update
    -------------------------*/
$('#update_ads_form').on('submit',function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: this.action,
        data: new FormData(this),
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('.ads_button').html('Please Wait...');
        },
        success: function(response) {
            if (response.errors) 
            {
                $('.error-message-area').fadeIn();
                $('.error-msg').html(response.errors);
                $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }


            if (response == 'wallet_error') {
                $('.error-message-area').fadeIn();
                $('.error-msg').html('Your Balance is not Available');
                $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }

            if (response == 'ok')
            {
                var url = $('#ads_url').val();
                $.pjax({url: url, container: '#pjax-container'});
                $('.alert-message-area').fadeIn();
                $(".alert-message-area").delay( 5000 ).fadeOut( 2000 );
                $('.ads_button').html('Submit');
            }
        }
    });
});

/*---------------------------------
        Ads Form Update with Pjax
    -----------------------------------*/
$(document).on('pjax:complete', function(){
    $('#update_ads_form').on('submit',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: this.action,
            data: new FormData(this),
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.ads_button').html('Please Wait...');
            },
            success: function(response) {
                if (response.errors) 
                {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html(response.errors);
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }


                if (response == 'wallet_error') {
                    $('.error-message-area').fadeIn();
                    $('.error-msg').html('Your Balance is not Available');
                    $(".error-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }

                if (response == 'ok')
                {
                    var url = $('#ads_url').val();
                    $.pjax({url: url, container: '#pjax-container'});
                    $('.alert-message-area').fadeIn();
                    $(".alert-message-area").delay( 5000 ).fadeOut( 2000 );
                    $('.ads_button').html('Submit');
                }
            }
        });
    });
});

/*-----------------------
        Live Data Search
    -------------------------*/
function search()
{
    var data = $('#search').val();
    var url = $('#search_url').val();
    $.ajax({
        url: url,
        data: {search: data},
        type: "GET",
        dataType: "HTML",
        success: function(response) {
            $('.search-append').html(response);
        }
    });
}

/*-----------------------
        User Search
    -------------------------*/
function user_search(username)
{
    $('#search').val(username);
    $('.search-append').html('');
}

/*-----------------------
        Data Append
    -------------------------*/
$(document).on('click', function(){
    $('.search-append').html('');
});

/*-----------------------
        User Report
    -------------------------*/
function user_report(slug)
{
    var url = $("#user_report_url").val();
    $.ajax({
        url: url,
        data: { slug: slug },
        type: "GET",
        dataType: "HTML",
        beforeSend: function() {
            $('.ellipish-modal').removeClass('d-none');
            $('.ellipish-modal-content').html('<div class="ellipish-close-btn"><a href="javascript:void(0)" onclick="cancel_ellipish()"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17"><g></g><path d="M9.207 8.5l6.646 6.646-0.707 0.707-6.646-6.646-6.646 6.646-0.707-0.707 6.646-6.646-6.647-6.646 0.707-0.707 6.647 6.646 6.646-6.646 0.707 0.707-6.646 6.646z" fill="#ED4956" /></svg></a></div><div class="ellipish-list text-center"><form id="user_report_form"><textarea id="embed_video" class="embed_textarea" placeholder="Write report issue"></textarea><button type="submit" class="embed_action">Send Report</button></form></div>');
        },
        success: function(response) {
            $('.ellipish-modal').removeClass('d-none');
            $('.ellipish-modal-content').html(response);
        }
    });
}

/*-----------------------
        Night & Day Mode
    -------------------------*/
function mode()
{
    var url = $('#mode_url').val();
    $.ajax({
        url: url,
        data: null,
        type: "GET",
        dataType: "HTML",
        beforeSend: function() {
            
        },
        success: function(response) {
            if (response == 'night')
            {
                logo_change();
                var baseurl = $('#base_url').val();
                $('#mode').attr('href',baseurl+'/frontend/css/dark.css');
                $('#home_mode').attr('src',baseurl+'/frontend/img/white_home.png');
                $('#notification_mode').attr('src',baseurl+'/frontend/img/white_notification.png');
                $('#upload_mode').attr('src',baseurl+'/frontend/img/white_upload.png');
                $('#mode_action').html('Day Mode <div class="mode day"><i class="far fa-sun"></i></div>');
            }

            if (response == 'day')
            {
                logo_change();
                var baseurl = $('#base_url').val();
                $('#mode').attr('href',baseurl+'/frontend/css/style.css');
                $('#home_mode').attr('src',baseurl+'/frontend/img/home.png');
                $('#notification_mode').attr('src',baseurl+'/frontend/img/notification.png');
                $('#upload_mode').attr('src',baseurl+'/frontend/img/upload.png');
                $('#mode_action').html('Night Mode <div class="mode night"><i class="far fa-moon"></i></div>');

            }
        }
    });
}

/*-----------------------
        Logo Change
    -------------------------*/
function logo_change()
{
    var url = $('#logo_change_url').val();
    $.ajax({
        url: url,
        data: null,
        type: "GET",
        dataType: "HTML",
        success: function(response) {
            var baseurl = $('#base_url').val();
            $('#logo_mode').attr('src',baseurl+'/'+response);
        }
    });
}

document.addEventListener('DOMContentLoaded', function(){
	var result = getUrlVar();
	if (result['page'] == "verify")
	{
		$("#verifylink").click();
	}
});

function getUrlVar(){
    var urlVar = window.location.search; // ???????????????? ?????????????????? ???? ????????
    var arrayVar = []; // ???????????? ?????? ???????????????? ????????????????????
    var valueAndKey = []; // ???????????? ?????? ???????????????????? ???????????????? ???????????????? ?? ?????????? ????????????????????
    var resultArray = []; // ???????????? ?????? ???????????????? ????????????????????
    arrayVar = (urlVar.substr(1)).split('&'); // ?????????????????? ?????? ???? ??????????????????
    if (arrayVar[0]=="") return false; // ???????? ?????? ???????????????????? ?? ????????
    for (i = 0; i < arrayVar.length; i ++) { // ???????????????????? ?????? ???????????????????? ???? ????????
        valueAndKey = arrayVar[i].split('='); // ?????????? ?? ???????????? ?????? ???????????????????? ?? ???? ????????????????
        resultArray[valueAndKey[0]] = valueAndKey[1]; // ?????????? ?? ???????????????? ???????????? ?????? ???????????????????? ?? ???? ????????????????
    }
    return resultArray; // ???????????????????? ??????????????????
}


const esc =   document.querySelector('.bg-modal')
const btnClose = document.querySelector('.close-btn')
document.addEventListener('keydown', function (e){
    if(e.key === 'Escape') {

        if(!esc.classList.contains('d-none')) {
            esc.classList.add('d-none')
        }
    }

})
esc.onmouseover = function () {
    if (popupshow)
    {
        $(".close-btn").show();
        $(".volume-action").show();
        $("#proflink").show();
        setTimeout("HideCloseBtn()", 3000);
    }
}
esc.onmouseout =  setTimeout("HideCloseBtn()", 3000);