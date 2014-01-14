<?php
include "sptt-config.php";
include "sptt-getdata.php";

// delete all old content
$files = glob($site_path.'*.html'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

// get data for index and categs
$posts = sptt_get_data('postsbycateg');
$categ_names = sptt_get_data('categs');

// make index html file
$building = "index";
if ( count($posts) != 0 ) {
	// include begin.php
	ob_start(); # start buffer
	include( 'includes/begin.php' );
	$begin = ob_get_contents();
	ob_end_clean(); # end buffer

	// include end.php
	ob_start();
	include( 'includes/end.php' );
	$end = ob_get_contents();
	ob_end_clean();

	// include side.top.php
	if ( file_exists('includes/side.top.php') ) {
		ob_start();
		include( 'includes/side.top.php' );
		$side_top = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.middle.php') ) {
		ob_start();
		include( 'includes/side.middle.php' );
		$side_middle = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.bottom.php') ) {
		ob_start();
		include( 'includes/side.bottom.php' );
		$side_bottom = ob_get_contents();
		ob_end_clean();
	}
	$sidebar = "<div id='pre'>" .$side_top.$side_middle.$side_bottom. "</div><!-- #pre -->";

	$index_handle = fopen($site_path."index.html", 'w') or die('Cannot create the file index.html. Be sure that ' .$site_path. ' is writable.'); //open file for writing
	$categ_count = 0;
	$main = "<div id='content'>";
	foreach ( $posts as $categ ) {
		$sec_tit = $categ_names[$categ_count];
		$sec_id = $categ_count + 1;
		$main .= "<section><div class='section'><header><div class='section-tit'><h2>" .$sec_tit. "</h2></div></header><div id='section-" .$sec_id. "'>";
		foreach ( $categ as $post ) {
		$athome = strtolower($post['athome']);
		if ( $athome == 'true' || $athome == 1 ) {
			$cat = $post['categ'];
			$cat_perma = sptt_get_cat_link($cat);
			$tit = $post['tit'];
			$desc = $post['desc'];
			$img = $img_path.$post['img'];
			$img_alt = $post['img-alt'];
			$link = $post['link'];
			$perma = $post['perma'];
			if ( file_exists('includes/main.php') ) {
				ob_start();
				include( 'includes/main.php' );
				$main .= ob_get_contents();
				ob_end_clean();
			}

		} // end if $athome is true
		} // end foreach post
		$categ_count++;
		$main .= "</div></section>";
	} // end foreach categ
	$main .= "</div><!-- #content -->";

	$index_data = $begin.$sidebar.$main.$end;
	$write_success = fwrite($index_handle, $index_data);
	fclose($index_handle);
	// generate feedback for user
	if ( $write_success == FALSE ) {
		$feedback_index = "<p class='error'>There was an error while generating <code>index.html</code>.</p>";
	} else {
		$feedback_index = "<p class='success'><strong><code>index.html</code></strong> has been generated correctly.</p>";

	}
} // end if posts

// make categ html files
$building = "categs";
$feedback_categs = ""; // user's feedback output
if ( count($posts) != 0 ) {
	// include begin.php
	ob_start(); # start buffer
	include( 'includes/begin.php' );
	$begin = ob_get_contents();
	ob_end_clean(); # end buffer

	// include end.php
	ob_start();
	include( 'includes/end.php' );
	$end = ob_get_contents();
	ob_end_clean();

	// build sidebar
	if ( file_exists('includes/side.top.php') ) {
		ob_start();
		include( 'includes/side.top.php' );
		$side_top = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.middle.php') ) {
		ob_start();
		include( 'includes/side.middle.php' );
		$side_middle = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.bottom.php') ) {
		ob_start();
		include( 'includes/side.bottom.php' );
		$side_bottom = ob_get_contents();
		ob_end_clean();
	}
	$sidebar = "<div id='pre'>" .$side_top.$side_middle.$side_bottom. "</div><!-- #pre -->";

	$categ_count = 0;
	foreach ( $posts as $categ ) {
		$categ_file = sptt_get_cat_link($categ_names[$categ_count]);
		//$categ_file = sptt_check_url($categ_file);

		$sec_tit = $categ_names[$categ_count];
		//$sec_id = $categ_count + 1;
		$sec_id = 1;
		$main = "<div id='content'><section><div class='section'><header><div class='section-tit'><h2>" .$sec_tit. "</h2></div></header><div id='section-" .$sec_id. "'>";
		$categ_handle = fopen($site_path.$categ_file, 'a') or die('Cannot create the file ' .$categ_file. '. Be sure that ' .$site_path. ' is writable.'); //open file for writing

		foreach ( $categ as $post ) {
			$cat = $post['categ'];
			$cat_perma = $categ_file;
			$tit = $post['tit'];
			$desc = $post['desc'];
			$img = $img_path.$post['img'];
			$img_alt = $post['img-alt'];
			$link = $post['link'];
			$perma = $post['perma'];

			if ( file_exists('includes/main.php') ) {
				ob_start();
				include( 'includes/main.php' );
				$main .= ob_get_contents();
				ob_end_clean();
			}

		} // end foreach post
		$main .= "</div></section></div><!-- #content -->";
		$categ_data = $begin.$sidebar.$main.$end;
		$write_success = fwrite($categ_handle, $categ_data);
		fclose($categ_handle);
		// generate feedback for user
		if ( $write_success == FALSE ) {
			$feedback_categs .= "<p class='error'>There was an error while generating <code>" .$categ_file. "</code>.</p>";
		} else {
			$feedback_categs .= "<p class='success'><strong><code>" .$categ_file. "</code></strong> has been generated correctly.</p>";
		}

		$categ_count++;
	} // end foreach categ

} // end if posts

// make single html files
$building = "single";
$posts = sptt_get_data('allposts');
$feedback_singles = ""; // user feedback output
if ( count($posts) != 0 ) {
	// include begin.php
	ob_start(); # start buffer
	include( 'includes/begin.php' );
	$begin = ob_get_contents();
	ob_end_clean(); # end buffer

	// include end.php
	ob_start();
	include( 'includes/end.php' );
	$end = ob_get_contents();
	ob_end_clean();

	// include side.top.php
	if ( file_exists('includes/side.top.php') ) {
		ob_start();
		include( 'includes/side.top.php' );
		$side_top = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.middle.php') ) {
		ob_start();
		include( 'includes/side.middle.php' );
		$side_middle = ob_get_contents();
		ob_end_clean();
	}
	if ( file_exists('includes/side.bottom.php') ) {
		ob_start();
		include( 'includes/side.bottom.php' );
		$side_bottom = ob_get_contents();
		ob_end_clean();
	}
	$sidebar = "<div id='pre'>" .$side_top.$side_middle.$side_bottom. "</div><!-- #pre -->";

	foreach ( $posts as $post ) {
		$main = "<div id='content'>";
		$cat = $post['categ'];
		$cat_perma = sptt_get_cat_link($cat);
		//$cat_perma = sptt_check_url($cat_perma);
		$tit = $post['tit'];
		$desc = $post['desc'];
		$img = $img_path.$post['img'];
		$img_alt = $post['img-alt'];
		$link = $post['link'];
		$perma = $post['perma'];
		if ( file_exists('includes/main-single.php') ) {
			ob_start();
			include( 'includes/main-single.php' );
			$main .= ob_get_contents();
			ob_end_clean();
		}
		$main .= "</div><!-- #content -->";

		$single_data = $begin.$sidebar.$main.$end;
		$single_handle = fopen($site_path.$perma, 'w') or die('Cannot create the file ' .$perma. '. Be sure that ' .$site_path. ' is writable.'); //open file for writing
		$write_success = fwrite($single_handle, $single_data);
		fclose($single_handle);
		// generate feedback for user
		if ( $write_success == FALSE ) {
			$feedback_singles .= "<p class='error'>There was an error while generating <code>" .$perma. "</code>.</p>";
		} else {
			$feedback_singles .= "<p class='success'><strong><code>" .$perma. "</code></strong> has been generated correctly.</p>";
		}

	} // end foreach posts
} // end if posts
// end create single post files

// build style sheets
$feedback_styles = "";
// reset.css
$reset_css_data = file_get_contents("reset.css");
$reset_css_handle = fopen($site_path."reset.css", 'w') or die('Cannot create the file reset.css. Be sure that ' .$site_path. ' is writable.'); //open file for writing
$write_success = fwrite($reset_css_handle, $reset_css_data);
fclose($reset_css_handle);
// generate feedback for user
if ( $write_success == FALSE ) {
	$feedback_styles .= "<p class='error'>There was an error while generating <code>reset.css</code>.</p>";
} else {
	$feedback_styles .= "<p class='success'><strong><code>reset.css</code></strong> has been generated correctly.</p>";
}

// style.css
// compile .less stylesheet into .css
require 'lessc.inc.php';
$less = new lessc;
//$css_path = preg_replace('/includes/',$site_path,__DIR__);
$css_path = __DIR__."/".$site_path;
$less->checkedCompile( "style.less", $css_path. "style.css");
//try {
//  $less->compile("invalid LESS } {");
//} catch (exception $e) {
//  echo "fatal error: " . $e->getMessage();
//}
// generate feedback for user
if ( $write_success == FALSE ) {
	$feedback_styles .= "<p class='error'>There was an error while generating <code>style.css</code>.</p>";
} else {
	$feedback_styles .= "<p class='success'><strong><code>style.css</code></strong> has been generated correctly.</p>";
}

// end compile .less

// generation output
?>
<!DOCTYPE html>
<html lang="<?php echo sptt_get_site_metadata("lang"); ?>">

<head>
<meta charset="UTF-8" />
<title>Generator script for the site <?php echo sptt_get_site_metadata("title"); ?></title>

<meta content="<?php echo sptt_get_site_metadata("title"); ?>" name="description" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<style>
.error { color: #f00;}
.success { color: #0f0;}
</style>

</head>

<body>

<h1>Generator script for the site "<?php echo sptt_get_site_metadata("title"); ?>"</h1>
<p><strong>This script generates your site</strong>. Basically it writes HTML files in a dynamic way from the data you have included in <code>sptt-content.csv</code>. This is the result:</p>

<h2>Home page</h2>
<?php echo $feedback_index; ?>

<h2>Category pages</h2>
<?php echo $feedback_categs; ?>

<h2>Single post pages</h2>
<?php echo $feedback_singles; ?>

<h2>Style files</h2>
<?php echo $feedback_styles; ?>

</body>
</html>
