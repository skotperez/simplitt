// to change the bg color of all the active block elements
$(document).ready(function(){
	$('#blocks a').each(
		function( i ){
			var $counter = (i+1);
			var $access = 'section-' + $counter;
			$(this).addClass($access);

			$('a.section-' + $counter).mouseover(function(){
				$('#section-' + $counter + ' div.box').addClass('featured');
			}).mouseout(function(){
				$('#section-' + $counter + ' div.box').removeClass('featured');
			});
		}
	);
});
