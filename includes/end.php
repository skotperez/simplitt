<?php
if ( $building == 'index' || $building == 'categs' ) {

	if ( $building == 'index' ) {
		$categ_num = count($categ_names);
	} else { $categ_num = 1; }

	$masonry_count = 1;
	$masonry_out = "
		<script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
		<script>
	";
	while ( $categ_num >= $masonry_count ) {
		$masonry_out .= "
		var section" .$masonry_count. " = document.querySelector('#section-" .$masonry_count. "');
		var msnry = new Masonry( section" .$masonry_count. ", {
		  itemSelector: '.box'
		});
		";
		$masonry_count++;
	}
	$masonry_out .= "</script>";
} else {
	$masonry_out = "";
} // end if building index or categs

$footer = "
	</div><!-- #content -->
	" .$masonry_out. "
	</body>
	</html>
";
?>
