<?php
// output for each post in home page
// the output html code must be stored in $content var
// the following vars can be used:
// $cat -- post category (string)
// $tit -- post title (string)
// $desc -- post content (string)
// $img -- post image (URL)
// $img_alt -- post image alternative description (string)
// $link -- more info link (URL)
// $perma -- link to single page of the post (URL)

if ( sptt_post_has_image() ) { $post_img = "<figure><img src='" .$img. "' alt='" .$img_alt. "' /></figure>"; }
else { $post_img = ""; }
if ( sptt_post_has_description() ) { $post_desc = "<div>" .$desc. "</div>"; }
else { $post_desc = ""; }

$content = "
<article>
<div>
	" .$post_img. "
	<header><h3>" .$tit. "</h3></header>
	" .$post_desc. "
	<footer><a href='" .$perma. "' title='" .$tit. "'>Permalink</a></footer>
</div>
</article>
";
?>
