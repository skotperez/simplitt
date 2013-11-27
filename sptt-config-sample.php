<?php
///////////////////////
////// SETUP YOUR VARS

//// directories
$site_path = "site/"; // where the HTML files will be stored. don't forget to create this folder and give it the right permissions
$img_path = "site/img/"; // images folder. this folder must be created into $site_path folder
$site_home = "http://localhost/simplitt/site/"; // home page

//// CSV data file vars
$csv_filename = "sptt-content"; // name (no extension)
$line_length = "1024"; // max line lengh (increase in case you have longer lines than 1024 characters)
$delimiter = ","; // field delimiter character
$enclosure = '"'; // field enclosure character

//// site vars
$site_lang = "en-US"; // site language
$site_tit = "simplitt"; // site title
$site_desc = "A simple CMS editable from a single flat file"; // site description for human beings (as long as you want)
$site_short_desc = "A simple CMS editable from a single flat file"; // site description for search engines (not longer than 155 char)
$site_logo = ""; // site logo filename. put this file into $img_path folder

// if you want to customize the styles, you must edit style.less
?>
