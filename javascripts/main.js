var parallax;
var mainHeader;
var isMobile;

$(document).on('ready', function() {
	initialize();
	bindEvents();
	showAchievement();
});

function initialize() {
	$('#prevent-space').focus();

	parallax = $('#activity-background');
	mainHeader = $('#main-wrapper').children('.header');
	activityDescription = $('#activity').children('.description-wrapper');

	initializeDisqusComments();
	initializeSubmissionImageUpload();
	initializeUpdateAvatar();
	initializeSlideshows();

	isMobile = $(window).width() <= 640 ? true : false;
	/mobile/i.test(navigator.userAgent) && setTimeout(function() {   window.scrollTo(0, 1); }, 1000); // hide navigation bar for mobile
}

function bindEvents() {
	$('.explore').on('click', function(e) {
		if(!isMobile) {
			e.preventDefault();
			$(window).scrollTo($(window).height()-60, 750);
		}
	});
	$('.toggle-mobile-menu').on('click', function(e) {
		$('#mobile-menu').toggle();
		window.location.hash = '';
	});
	$('#mobile-menu').find('a').on('click', function(e) {
		e.stopPropagation();
	});
	$('#mobile-menu').on('click', function(e) {
		$('#mobile-menu').hide();
	});
	
	$(window).on('scroll', function() {
		if (!isMobile) {
			parallaxScrollActivity(parallax, mainHeader);
		}
	});
 
	$('#file-upload').on('change', function() {
		$('#add-submission').animate({height: '520px'}, 250, function() {
			$(this).css('height', 'auto');
		});
	});
	$('#youtube').on('focus', function() {
		$('#add-submission').animate({height: '520px'}, 250, function() {
			$(this).css('height', 'auto');
		});
	});

	$('.submit').on('click',function(e) {
		e.preventDefault();
		$(this).closest('form').find('input[type=submit]').click();
	})

	$('.file-upload').on('click',function(e) {
		e.preventDefault();
		$(this).closest('form').find('input[type=file]').click();
	})

	$('.ajaxSubmit').on('click',function(e) {
		e.preventDefault();
		if (!$(this).hasClass('toggled')) {
			$.ajax($(this).data('ajax'));
			if ($(this).hasClass('like')) {
				$(this).removeClass('ajaxSubmit').addClass('toggled').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
				l = $('#'+$(this).data('like-counter'));
				l.html('+'+(parseInt(l.html())+1)+'@');
			}
		}
	})

	$('.like').on('click', function(e) {
		e.preventDefault();
	})

	$('#invite').on('keyup', function(e) {
		invite = $('#invite-name').val();
		invite = invite.indexOf('@')>=0 ? invite : '@'+invite;
		$('#invite-twitter').attr('href','https://twitter.com/intent/tweet?text='+invite+' '+escape('ik vond dit op Offf!, zin om dat samen te gaan doen?')+'&hashtags='+$('#invite-twitter').data('hashtags')+'&url='+escape(window.location));
	});
}

function initializeDisqusComments() {
	$('.disqus-comments .widget').css({height: '0px', opacity: 0});
	$('.disqus-comments .foldout').on('click', function(e) {
		e.preventDefault();
		var widget = $(this).siblings('.widget');
		var iframe = widget.find('iframe.auto-height');
		var height = iframe.contents().find('body').height();
		iframe.css('height', (height+20)+'px');
		widget.animate({height: height+'px', opacity: 1}, 500)
	});
}

function initializeSubmissionImageUpload() {
	var files = new Array();
	var fileUploadTitle = $('#file-upload').attr('title');
	// #submissionImages is the form
	// #fileUpload is the upload field
	$('#file-upload').on('change', function() { 
		$('#file-upload').attr('title', 'Bezig met uploaden...');
		$('#status').html('Bezig met uploaden...');
		$("#submission-images").ajaxForm({
			clearForm: true,
			dataType: 'json',
			uploadProgress: function(e, p, t, percentage) {
				$('#file-upload').attr('title', 'Bezig met uploaden: '+percentage+'%');
			},
			success: function(response) {
				$('#status').html('');
				$('#file-upload').attr('title', fileUploadTitle);
				if (response.error) {
					$('#form-error').html(response.error);
				} else {
					$.each(response.images, function(key, value) {
						/*
						<div id="thumb[#]" class="thumb" data-id="[id]">
							<img src="[url]">
							<div class="closeButtonWrapper">
								<a href="#" class="closeButton" data-id="[id]">X</a>
							</div>
						</div>
						*/
						$('#preview').append('<div id="thumb'+value.image_id+'" class="thumb" data-id="'+value.image_id+'"><img src="'+url('uploads/'+value.file_name)+'"><div class="close-button-wrapper"><a href="#" class="close-button" data-id="'+value.image_id+'">X</a></div></div>');
						$('#images').val($('#images').val() + ($('#images').val() ? ',' : '') + value.image_id);
						$('#thumb'+value.image_id).on('click', bindPreviewImageCloseButton);
					});
				}
			}
		}).submit();
	});
	$('#preview').find('.close-button').on('click', bindPreviewImageCloseButton);
}

function initializeUpdateAvatar() {
	var files = new Array();
	var fileUploadTitle = $('#file-upload').attr('title');
	// #submissionImages is the form
	// #fileUpload is the upload field
	$('#file-upload').on('change', function() { 
		$('#file-upload').attr('title', 'Bezig met uploaden...');
		$("#update-avatar").ajaxForm({
			clearForm: true,
			dataType: 'json',
			uploadProgress: function(e, p, t, percentage) {
				$('#file-upload').attr('title', 'Bezig met uploaden: '+percentage+'%');
			},
			success: function(response) {
				$('#file-upload').attr('title', fileUploadTitle);
				if (response.error) {
					$('#form-error').html(response.error);
				} else {
					$('.avatar').attr('src', response.avatar);
				}
			},
			error: function(e) {
				//console.log(e);
			}
		}).submit();
	});
}

function bindPreviewImageCloseButton(e) {
	e.preventDefault();

	//console.log('click');

	id = $(this).data('id');
	//console.log(id);

	// remove image from images input
	
	value = $('#images').val().split(',');
	//console.log('value before');
	//console.log(value);
	value.splice(value.indexOf(''+id), 1);
	value.join(',');
	$('#images').val(value)
	//console.log('value after');
	//console.log(value);

	// delete thumb
	$(this).closest('.thumb').remove();
}

function initializeSlideshows() {
	$(".slides").each(function() {
		w = $(this).parent().width();
		//console.log(w);
		w = w < 498 ? w : 498;
		h = Math.floor(374/498*w);
		if ($(this).children('img').length > 1) {
			$(this).slidesjs({
				width: w,
				height: h,
				navigation: {
		      		active: false
		      	},
				pagination: {
					active: false
				},
				play: {
					active: false,
					effect: "slide",
					interval: 5000,
					auto: true,
					swap: false
				}
			});
		}
	});
}

function parallaxScrollActivity(parallax, mainHeader) {
	var scroll = $(window).scrollTop();
	if (scroll<=$(window).height()) {
		var scrollModifier = scroll/2;	
		if (scroll<200) {
			scrollModifier *= scroll/200;
		}
		parallax.css('background-position', '0px ' + (-scrollModifier/2) + 'px');
		mainHeader.css({height: (200+scrollModifier) + 'px', top: (-200-scrollModifier) + 'px'});
	}
}

function showAchievement() {
	descriptions = $('#queue').find('.description-wrapper');
	points = $('#queue').find('.points');
	levelUp = $('#queue').find('.level-up');
	progress = $('#level').find('.progress-bar');
	
	setTimeout(function() { points.removeClass('fade-out'); }, 750);
	setTimeout(function() { levelUp.removeClass('fade-out'); }, 750);
	setTimeout(function() { descriptions.removeClass('fade-out'); }, 1250);
	setTimeout(function() { progress.css('width', progress.data('target')+'%'); }, 2000)
	setTimeout(function() {
		levelUp.addClass('fade-out');
		descriptions.addClass('fade-out');
		points.addClass('fade-out');
	}, 12000)
}

function url(path) {
	path = !path ? '' : path;
	return "/sandbox/afst/"+path;
}