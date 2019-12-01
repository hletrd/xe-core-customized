var $ = jQuery;

function ab_fontSizeCtr(pm){
	var c = jQuery('.xe_content');
	if (pm == 'm') {
		var font_size = parseFloat(c.css('fontSize'))-2;
		if (font_size < 8){
			return;
		}
	};
	if (pm == 'p') {
		var font_size = parseFloat(c.css('fontSize'))+2;
		if (font_size > 24){
			return;
		}
	};
	c.css('font-size',''+font_size+'px');
}

function reComment(doc_srl,cmt_srl,edit_url,cmt_nn,lang){
	if (lang == 'ko') {
		jQueryto = "<span class='recomment-to'><span class='ab-point-bgcolor'>" + cmt_nn + "님께</span> </span>";
	}
	else {
		jQueryto = "<span class='recomment-to'><span class='ab-point-bgcolor'>To. " + cmt_nn + "</span> </span>";
	}
	jQuery('.recomment-to').remove();
	jQuery(jQueryto).prependTo('#reCommentHT');

	var tmp = jQuery('#reCommentBox').eq(0);
	tmp.find('input[name=error_return_url]').val('/' + doc_srl);
	tmp.find('input[name=mid]').val(current_mid);
	tmp.find('input[name=document_srl]').val(doc_srl);
	tmp.appendTo(jQuery('#comment_' + cmt_srl)).show().find('input[name=parent_srl]').val(cmt_srl);
	tmp.find('#use_editor').attr('href',edit_url);
	tmp.find('textarea').focus();
}

String.prototype.replaceAll = function(searchStr, replaceStr) {
	var temp = this;
	while (temp.indexOf(searchStr) != -1) {
		temp = temp.replace(searchStr, replaceStr);
	}
	return temp;
}

// 페이지가 로드되고 나서
$(document).ready(function () {
	$('.showPopover').click(function(){
		$parent = $(this).parent();
		$parent.children('.ab-popover').show();
		$('.ab-popover-bg').show();
		$(this).addClass('hidePopover');
	});
	$('.ab-popover-bg').click(function(){
		$parent = $('.hidePopover').parent();
		$parent.children('.ab-popover').hide();
		$('.ab-popover-bg').hide();
		$('.hidePopover').removeClass('hidePopover');
	});
	$('.ab-faq-q').click(function(){
		if($(this).find('strong').length) {
			$parent = $(this).parent();
			$parent.find('.ab-faq-a').slideToggle();
			$(this).find('p').unwrap()
		}
		else {
			$parent = $(this).parent();
			$parent.find('.ab-faq-a').slideToggle();
			$(this).find('p').wrap('<strong />')
		}
	});
});