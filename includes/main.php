<div class='box'>
<article>
	<?php if ( sptt_post_has_image() ) { ?>
		<figure><img src='<?php echo sptt_get_post_data('image_url'); ?>' alt='<?php echo sptt_get_post_data('image_url'); ?>' /></figure>
	<?php } ?>
	<div class='box-text'>
		<header><h3 class='box-tit'><?php echo sptt_get_post_data('title'); ?></h3></header>
		<?php if ( sptt_post_has_description() ) { ?>
			<div class='box-desc'><?php echo sptt_get_post_data('content'); ?></div>
		<?php } ?>
	</div>
	<footer><ul class='box-footer'>
		<li><a href='<?php echo sptt_get_cat_link(sptt_get_post_data('category')); ?>' title='<?php echo sptt_get_post_data('category'); ?>'>#<?php echo sptt_get_post_data('category'); ?></a></li>
		<li><a href='<?php echo sptt_get_post_data('permalink'); ?>' title='Enlace permanente a <?php echo sptt_get_post_data('title'); ?>'>&infin;</a></li>
	</ul></footer>
</article>
</div><!-- .box -->
