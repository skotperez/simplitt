<?php
$categ_names = sptt_get_data('categs');
$categ_num = count($categ_names);
$masonry_count = 1;
$masonry_out = "";
while ( $categ_num >= $masonry_count ) {
	$masonry_out .= "
	var section" .$masonry_count. " = document.querySelector('#section-" .$masonry_count. "');
	var msnry = new Masonry( section" .$masonry_count. ", {
	  itemSelector: '.box'
	});
	";
	$masonry_count++;
}

$footer = "
</div><!-- #content -->
<script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
<script>
	" .$masonry_out. "
</script>
</body>
</html>
";
?>
