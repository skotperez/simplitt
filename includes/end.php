	<?php
	if ( sptt_is_home() || sptt_is_category() ) { // if home page or category archive
		echo sptt_active_masonry("js/masonry.pkgd.min.js","box");
	} // end if index or categs
	?>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="js/blocks.js"></script>
	<script type="text/javascript" src="js/menutotop.js"></script>

</body>
</html>
