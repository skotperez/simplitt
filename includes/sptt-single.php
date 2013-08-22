<?php
// output for each post in its single page
// the output html code must be stored in $content var
// the following vars can be used:
// $cat -- post category (string)
// $cat_link -- link to category page (URL)
// $tit -- post title (string)
// $desc -- post content (string)
// $img -- post image (URL)
// $img_alt -- post image alternative description (string)
// $link -- more info link (URL)
// $perma -- link to single page of the post (URL)

if ( $img != $img_path ) { $figure = "<figure><img src='" .$img. "' alt='" .$img_alt. "' /></figure>"; }
else { $figure = ""; }
if ( $desc != '' ) { $content = "<div>" .$desc. "</div>"; }
else { $content = ""; }
$post_footer = "<footer>Context: <a href='" .$cat_link. "'>" .$cat. "</a>";
if ( $link != '' ) { $post_footer .= "<a href='" .$link. "'>More info</a></footer>"; }
else { $post_footer .= "</footer>"; }

$content = "
	<article>
		" .$figure. "
		<header>" .$tit. "</header>
		" .$content.$post_footer. "
	</article>	
";
?>
