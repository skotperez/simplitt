$(function () {
	var $win = $(window);
	var $header_h = $('#header .box').height();
	var $pos = 18+$header_h;
	$win.scroll(function () {
		if ($win.scrollTop() <= $pos)
			$('#blocks').removeClass('menutotop');
		else {
			$('#blocks').addClass('menutotop');
		}
	});
});
