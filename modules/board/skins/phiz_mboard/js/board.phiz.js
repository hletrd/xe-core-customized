// search Box Toggle
jQuery(function($) {
		// remember top status
	var remember = getCookie('__phiz_search_box_status');
	if (remember == 'open') {
		$('.search-box').addClass('open-box');
	}
	else  {
		$('.search-box').removeClass('open-box');
	}
//board search top
    $('.search-btn').click(function() {
		if ($('.search-box').hasClass('open-box')) {
			setCookie('__phiz_search_box_status', 'close');
			$('.search-box').removeClass('open-box');
		}
		else {
			 setCookie('__phiz_search_box_status', 'open');
			$('.search-box').addClass('open-box');
		}
	});
		// remember bottom status
	var rememberB = getCookie('__phiz_search_boxB_status');
	if (rememberB == 'open') {
		$('.search-boxB').addClass('open-box');
	}
	else  {
		$('.search-boxB').removeClass('open-box');
	}
//board search bottom
    $('.search-btnB').click(function() {
		if ($('.search-boxB').hasClass('open-box')) {
			setCookie('__phiz_search_boxB_status', 'close');
			$('.search-boxB').removeClass('open-box');
		}
		else {
			 setCookie('__phiz_search_boxB_status', 'open');
			$('.search-boxB').addClass('open-box');
		}
	});

// add class to the parent category
	$('.cBar>li>ul>li.on_').parents('li:first').addClass('on');
	// delete the margin-top for the first child of the ccomments
//infinite session storage clear
    $('.clearSession').click(function() {
		sessionStorage.clear();
		location.href = current_url;
	});

});
