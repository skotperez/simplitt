<?php
include "sptt-config.php";

if ( sptt_site_has_logo() ) { $logo = '<div id="sitelogo"><img src="' .$img_path.$site_logo. '" alt="' .$site_tit. '" /></div>'; }

$header = '
<!DOCTYPE html>

<html lang="' .$site_lang. '">

<head>
<meta charset="UTF-8" />
<title>' .$site_tit. '</title>
<meta content="' .$site_short_desc. '" name="description" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>

	<header>
	<div id="pre">
		<div class="box">
			' .$logo. '
			<div class="box-text">
				<h1 id="sitetit"><a href="' .$site_path. '" title="Ir al inicio">' .$site_tit. '</a></h1>
				<div id="sitedesc">' .$site_desc. '</div>
			</div>
		</div>
	</div><!-- #pre -->
	</header>

	<div id="content">
';
?>
