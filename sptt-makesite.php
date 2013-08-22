<?php
include "sptt-config.php";
include "sptt-getdata.php";
include "includes/header.php";
include "includes/footer.php";

// delete all old content
$files = glob($site_path.'*.html'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

// make index html file
$posts = sptt_get_data('postsbycateg');
if ( count($posts) != 0 ) {
	$index_handle = fopen($site_path."index.html", 'w') or die('Cannot create the file index.html. Be sure that ' .$site_path. ' is writable.'); //open file for writing
	$categ_count = 0;
	$index_data = "";
	$categ_names = sptt_get_data('categs');
	foreach ( $posts as $categ ) {
		$sec_tit = $categ_names[$categ_count];
		$index_data .= $header. "<section><header>" .$sec_tit. "</header>";
		foreach ( $categ as $post ) {
			$cat = $post['categ'];
			$tit = $post['tit'];
			$desc = $post['desc'];
			$img = $img_path.$post['img'];
			$img_alt = $post['img-alt'];
			$link = $post['link'];
			$perma = $post['perma'];
			include "includes/sptt-index.php";
			$index_data .= $content;

		} // end foreach post
		$categ_count++;
		$index_data .= "</section>" .$footer;
	} // end foreach categ

	fwrite($index_handle, $index_data);
	fclose($index_handle);
} // end if posts

// make categ html files
$posts = sptt_get_data('postsbycateg');
if ( count($posts) != 0 ) {
	$categ_count = 0;
	$categ_names = sptt_get_data('categs');
	foreach ( $posts as $categ ) {
		$categ_file = sptt_get_cat_link($categ_names[$categ_count]);

		$sec_tit = $categ_names[$categ_count];
		$categ_data = $header. "<section><header>" .$sec_tit. "</header>";
		$categ_handle = fopen($site_path.$categ_file, 'a') or die('Cannot create the file ' .$categ_file. '. Be sure that ' .$site_path. ' is writable.'); //open file for writing

		foreach ( $categ as $post ) {
			$cat = $post['categ'];
			$cat_link = $categ_file;
			$tit = $post['tit'];
			$desc = $post['desc'];
			$img = $img_path.$post['img'];
			$img_alt = $post['img-alt'];
			$link = $post['link'];
			$perma = $post['perma'];

			include "includes/sptt-categs.php";
			$categ_data .= $content;

		} // end foreach post
		$categ_data .= "</section>" .$footer;
		fwrite($categ_handle, $categ_data);
		fclose($categ_handle);
		$categ_count++;
	} // end foreach categ

} // end if posts

// make single html files
$posts = sptt_get_data('allposts');
if ( count($posts) != 0 ) {
	foreach ( $posts as $post ) {
		$cat = $post['categ'];
		$cat_link = sptt_get_cat_link($cat);
		$tit = $post['tit'];
		$desc = $post['desc'];
		$img = $img_path.$post['img'];
		$img_alt = $post['img-alt'];
		$link = $post['link'];
		$perma = $post['perma'];
		include "includes/sptt-single.php";

		$single_data = $header.$content.$footer;
		$single_handle = fopen($site_path.$perma, 'w') or die('Cannot create the file ' .$perma. '. Be sure that ' .$site_path. ' is writable.'); //open file for writing
		fwrite($single_handle, $single_data);
		fclose($single_handle);

	} // end foreach posts
} // end if posts
// end create single post files
?>
