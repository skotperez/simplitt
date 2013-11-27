	</div><!-- #content -->

	<?php
	if ( sptt_is_home() || sptt_is_category() ) { // if home page or category archive
		echo sptt_active_masonry("js/masonry.pkgd.min.js","box");
	} // end if index or categs
	?>

</body>
</html>
