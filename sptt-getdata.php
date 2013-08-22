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
	$fp = fopen($working_path.$csv_filename.".csv",'r');

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

function sptt_get_cat_link($cat_name) {
	$cat_link = $cat_name. ".html";
	$cat_link = preg_replace("/ /","-",$cat_link);
	$cat_link = preg_replace("/\?/","",$cat_link);
	$cat_link = strtolower($cat_link);
	return $cat_link;
} // end get category link function

echo sptt_get_cat_link("Features");
?>
