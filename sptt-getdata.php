<?
// include config vars
include "sptt-config.php";

function sptt_get_data($whatdata) {
// $order parameter values: allposts, postsbycateg, categs
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
			else {
				$pattern = '/"/';
				$replace = "\&quot;";
				$cat = $fp_csv[1];
				$tit = preg_replace($pattern,$replace,$fp_csv[2]);
				$desc = preg_replace($pattern,$replace,$fp_csv[3]);
				$img = $fp_csv[4];
				$img_alt = $tit;
				$link = $fp_csv[5];
				$perma = $tit. ".html";
				$perma = preg_replace("/ /","-",$perma);
				$perma = preg_replace("/\?/","",$perma);
				$perma = strtolower($perma);

				if ( $whatdata == 'postsbycateg' ) {
					$data[$cat][] = array(
						'categ' => $cat,
						'tit' => $tit,
						'desc' => $desc,
						'img' => $img,
						'img-alt' => $tit,
						'link' => $link,
						'perma' => $perma,
					);
					$posts = $data;
				} elseif ( $whatdata == 'allposts' ) {
					$data[] = array(
						'categ' => $cat,
						'tit' => $tit,
						'desc' => $desc,
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

$har = sptt_get_data('allposts');
echo "<pre>";
print_r($har);
echo "</pre>";

// get category function
function sptt_get_cat_link($cat_name) {
	$cat_link = $cat_name. ".html";
	$cat_link = preg_replace("/ /","-",$cat_link);
	$cat_link = preg_replace("/\?/","",$cat_link);
	$cat_link = strtolower($cat_link);
	return $cat_link;
} // end get category link function

echo sptt_get_cat_link("Features");

// if post has image function
function sptt_post_has_image() {
	global $img;
	global $img_path;
	if ( $img != $img_path ) { return true; }
	else { return false; }
} // end if post has image

// if post has description
function sptt_post_has_description() {
	global $desc;
	if ( $desc != '' ) { return true; }
	else { return false; }
} // end if post has description

// if post has more info link
function sptt_post_has_link() {
	global $link;
	if ( $link != '' ) { return true; }
	else { return false; }
} // end if post has link

// get data from a post
//function sptt_get_post_field($field) {
//	global $cat;
//	global $tit;
//	global $desc;
//	global $img;
//	global $img_alt;
//	global $link;
//	global $perma;
//	if ( $field == 'category' ) { echo $cat; }
//	if ( $field == 'title' ) { echo "<header><h3>" .$tit. "</h3></header>"; }
//	elseif ( $field == 'description' ) { echo "<div>" .$desc. "</div>"; }
//	elseif ( $field == 'image' ) { echo "<figure><img src='" .$img. "' alt='" .$img_alt. "' /></figure>"; }
//	elseif ( $field == 'link' ) { echo "<a href='" .$perma. "' title='More about " .$tit. "'>+</a>"; }
//	elseif ( $field == 'permalink' ) { echo "<a rel='bookmark' href='" .$perma. "' title='" .$tit. "'>Permalink</a>"; }
//	else { echo "<span style='background-color: yellow; color: black;'>Wrong parameter for sptt_get_post_field(). Try one of the following: category, title, description, image, link, permalink.</span>"; }
//}
?>
