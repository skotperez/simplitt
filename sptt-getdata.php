<?
// include config vars
include "sptt-config.php";

function sptt_get_site_metadata($whatdata) {
// $whatdata parameter values: lang, home, title, description, short_description, logo_url
	global $site_lang;
	global $site_tit;
	global $site_desc;
	global $site_short_desc;
	global $site_logo;
	global $img_path;
	global $site_path;
	global $site_home;
	if ( $whatdata == 'lang' ) { $sitedata = $site_lang; }
	elseif ( $whatdata == 'title' ) { $sitedata = $site_tit; }
	elseif ( $whatdata == 'description' ) { $sitedata = $site_desc; }
	elseif ( $whatdata == 'short_description' ) { $sitedata = $site_short_desc; }
	elseif ( $whatdata == 'logo_url' ) { $sitedata = $img_path.$site_logo; }
	elseif ( $whatdata == 'home' ) { $sitedata = $site_home; }

	return $sitedata;
}
// end get_site_metadata funcion

/**
 * Function: sanitize
 * Returns a sanitized string, typically for URLs.
 * Author: http://chyrp.net/
 *
 * Parameters:
 *     $string - The string to sanitize.
 *     $force_lowercase - Force the string to lowercase?
 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
 */
function sptt_sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}
// end sptt_sanitize

// check if URL already exists
// if true, constructs a new one
function sptt_check_url($filename) {
	global $site_path;
	$ext = ".html";
	$filepath = $site_path.$filename;
	if ( is_file($filepath) ) { // if file exists
		$count = 0;
		while ( is_file($filepath) ) {
			$count++;
			$filename = basename($filepath, $ext);
			$filename = $filename . '-' . $count . $ext;
			$filepath = $site_path . $filename;
		}
	} // end if file exist
	return $filename;
}
// end check if URL already exists


if ( $key != '' ) {
// if google key is set in sptt-config.php, so the content is in a google drive spreadsheet

	function sptt_get_data($whatdata) {
	// $whatdata parameter values: allposts, postsbycateg, categs

		global $working_path; // base directory
		global $site_path; // where the HTML files will be stored
		global $img_path; // images folder

		global $key;
		$url = "https://spreadsheets.google.com/feeds/list/" .$key. "/od6/public/values?alt=json";
		$file= file_get_contents($url);
		$json = json_decode($file);
		$rows = $json->{'feed'}->{'entry'};

		// data array generation
		$data = array();
		foreach ( $rows as $row ) {
			$status = $row->{'gsx$status'}->{'$t'};
			if ( $status  != 'publish' ) {}
			else {
				$cat = $row->{'gsx$category'}->{'$t'};
				$tit = $row->{'gsx$title'}->{'$t'};
				$desc = $row->{'gsx$description'}->{'$t'};
				$content = $row->{'gsx$fullcontent'}->{'$t'};
				if ( $desc == '' ) { $desc = $content; }
				$img = $row->{'gsx$image'}->{'$t'};
				$img_alt = $tit;
				$link = $row->{'gsx$externallink'}->{'$t'};
				$perma = sptt_sanitize($tit);
				$perma = $perma. ".html";
				$perma = sptt_check_url($perma);
				$athome = $row->{'gsx$showathome'}->{'$t'};

				if ( $whatdata == 'postsbycateg' ) {
					$data[$cat][] = array(
						'categ' => $cat,
						'tit' => $tit,
						'desc' => $desc,
						'content' => $content,
						'img' => $img,
						'img-alt' => $tit,
						'link' => $link,
						'perma' => $perma,
						'athome' => $athome,
					);
					$posts = $data;
				} elseif ( $whatdata == 'allposts' ) {
					$data[] = array(
						'categ' => $cat,
						'tit' => $tit,
						'desc' => $desc,
						'content' => $content,
						'img' => $img,
						'img-alt' => $tit,
						'link' => $link,
						'perma' => $perma,
					);
					$posts = $data;
				} elseif ( $whatdata == 'categs' ) {
					$data[$cat][] = array(
					);
					$posts = array_keys($data);
				} // end if order values

			} // end if col1 = 'publish'

		} // end loop across gdrive file
	return $posts;
	}
	// end get data from gdrive function

} else {
// if google key is not set in sptt-config.php, so content is in localhost

	function sptt_get_data($whatdata) {
	// $whatdata parameter values: allposts, postsbycateg, categs
	
		global $working_path; // base directory
		global $site_path; // where the HTML files will be stored
		global $img_path; // images folder
	
		global $csv_filename; // name (no extension)
		global $line_length; // max line lengh (increase in case you have longer lines than 1024 characters)
		global $delimiter; // field delimiter character
		global $enclosure; // field enclosure character
	
		// open the data file
		$fp = fopen($csv_filename.".csv",'r');
	
		// get data and store it in array
		if ( $fp !== FALSE ) { // if the file exists and is readable
	
			// data array generation
			$data = array();
			$line = 0;
			while ( ($fp_csv = fgetcsv($fp,$line_length,$delimiter,$enclosure)) !== FALSE ) { // begin main loop
				if ( $line == 0 ) {}
				elseif ( $fp_csv[0] != 'publish') {}
				else {
					$cat = $fp_csv[1];
					$tit = $fp_csv[2];
					$desc = $fp_csv[3];
					$content = $fp_csv[4];
					if ( $desc == '' ) { $desc == $content; }
					$img = $fp_csv[5];
					$img_alt = $tit;
					$link = $fp_csv[6];
					$perma = sptt_sanitize($tit);
					$perma = $perma. ".html";
					$perma = sptt_check_url($perma);
					$athome = $fp_csv[7];
	
					if ( $whatdata == 'postsbycateg' ) {
						$data[$cat][] = array(
							'categ' => $cat,
							'tit' => $tit,
							'desc' => $desc,
							'content' => $content,
							'img' => $img,
							'img-alt' => $tit,
							'link' => $link,
							'perma' => $perma,
							'athome' => $athome,
						);
						$posts = $data;
					} elseif ( $whatdata == 'allposts' ) {
						$data[] = array(
							'categ' => $cat,
							'tit' => $tit,
							'desc' => $desc,
							'content' => $content,
							'img' => $img,
							'img-alt' => $tit,
							'link' => $link,
							'perma' => $perma,
						);
						$posts = $data;
					} elseif ( $whatdata == 'categs' ) {
						$data[$cat][] = array(
						);
						$posts = array_keys($data);
					} // end if order values
	
				} // end if first line
				$line++;
	
			} // end while main loop	
			fclose($fp); // close file pointer
	
		} else {
			echo $cvs_filename. "doesn't exist or is not readable. Check it.";
		} // end if file exist and readable
	
	return $posts;
	} // end sptt_all_posts function

} // end if google key is set in sptt-config.php


// get category function
function sptt_get_cat_link($cat_name) {
	global $building;
	$cat_link = sptt_sanitize($cat_name);
	$cat_link = $cat_link . ".html";
	if ( $building != 'single' ) { $cat_link = sptt_check_url($cat_link); }
	//$cat_link = preg_replace("/ /","-",$cat_link);
	//$cat_link = preg_replace("/\?/","",$cat_link);
	//$cat_link = strtolower($cat_link);
	return $cat_link;
} // end get category link function

// if post has image function
function sptt_post_has_image() {
	global $img;
	global $img_path;
	if ( $img != $img_path ) { return true; }
	else { return false; }
} // end if post has image

// if post has description
function sptt_post_has_description() {
	global $content;
	if ( $content != '' ) { return true; }
	else { return false; }
} // end if post has description

// if post has more info link
function sptt_post_has_link() {
	global $link;
	if ( $link != '' ) { return true; }
	else { return false; }
} // end if post has link

// if site has a logo
function sptt_site_has_logo() {
	global $site_logo;
	if ( $site_logo != '' ) { return true; }
	else { return false; }
} // end if site has a logo

// if is home function
function sptt_is_home() {
	global $building;
	if ( $building == 'index' ) { return true; }
} // end if is home function

// if is category function
function sptt_is_category() {
	global $building;
	if ( $building == 'categs' ) { return true; }
} // end if is category function

// if is single function
function sptt_is_single() {
	global $building;
	if ( $building == 'single' ) { return true; }
} // end if is single function

// get data from a post
function sptt_get_post_data($field) {
	global $cat;
	global $tit;
	global $desc;
	global $content;
	global $img;
	global $img_alt;
	global $link;
	global $perma;
	$perma = sptt_check_url($perma);
	if ( $field == 'category' ) { $post_data = $cat; }
	elseif ( $field == 'title' ) { $post_data = $tit; }
	elseif ( $field == 'description' ) { $post_data = $desc; }
	elseif ( $field == 'content' ) { $post_data = $content; }
	elseif ( $field == 'image_url' ) { $post_data = $img; }
	elseif ( $field == 'image_alt' ) { $post_data = $img_alt; }
	elseif ( $field == 'more_link' ) { $post_data = $link; }
	elseif ( $field == 'permalink' ) { $post_data = $perma; }
	else { $post_data = "<span style='background-color: yellow; color: black;'>Wrong parameter for sptt_get_post_data(). Try one of the following: category, title, description, content, image_url, image_alt, more_link, permalink.</span>"; }
	return $post_data;
} // end get data from a post

// include masonry library function
function sptt_active_masonry($masonry_path,$item_css_class) {
	if ( sptt_is_home() ) {
		$categ_names = sptt_get_data('categs');
		$categ_num = count($categ_names);
	} else { $categ_num = 1; }

	$masonry_count = 1;
	$masonry_out = "
		<script type='text/javascript' src='" .$masonry_path. "'></script>
		<script>
	";
	while ( $categ_num >= $masonry_count ) {
		$masonry_out .= "
		var section" .$masonry_count. " = document.querySelector('#section-" .$masonry_count. "');
		var msnry = new Masonry( section" .$masonry_count. ", {
		  itemSelector: '." .$item_css_class. "'
		});
		";
		$masonry_count++;
	}
	$masonry_out .= "</script>";

return $masonry_out;
} // end masonry library function
?>
