<?php
// output for each post in its single page
// the output html code must be stored in $content var
// the following vars can be used:
// $cat -- post category (string)
// $cat_perma -- post category link (URL)
// $tit -- post title (string)
// $desc -- post content (string)
// $img -- post image (URL)
// $img_alt -- post image alternative description (string)
// $link -- more info link (URL)
// $perma -- link to single page of the post (URL)

if ( sptt_post_has_image() ) { $post_img = "<figure><img src='" .$img. "' alt='" .$img_alt. "' /></figure>"; }
else { $post_img = ""; }
if ( sptt_post_has_description() ) { $post_desc = "<div class='box-desc'>" .$desc. "</div>"; }
else { $post_desc = ""; }

$content = "
<div class='article'>
<article>
	" .$post_img. "
	<div class='article-text'>
		<header><h2 class='article-tit'>" .$tit. "</h2></header>
		<ul class='article-meta'>
			<li><a href='" .$cat_perma. "' title='" .$cat. "'>#" .$cat. "</a></li>
		</ul>
		" .$post_desc. "
	</div>
	</article>
</div><!-- .article -->
";
?>
