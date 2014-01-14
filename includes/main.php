<div class='box'>
<article>
	<?php if ( sptt_post_has_image() ) { ?>
		<figure><img src='<?php echo sptt_get_post_data('image_url'); ?>' alt='<?php echo sptt_get_post_data('image_url'); ?>' /></figure>
	<?php } ?>
	<div class='box-text'>
		<header><h3 class='box-tit'><a href='<?php echo sptt_get_post_data('permalink'); ?>' title='Enlace permanente a <?php echo sptt_get_post_data('title'); ?>'><?php echo sptt_get_post_data('title'); ?></a></h3></header>
		<?php if ( sptt_post_has_description() ) { ?>
			<div class='box-desc'><?php echo sptt_get_post_data('description'); ?></div>
		<?php } ?>
	</div>
	<footer><ul class='box-footer'>
		<li><a href='<?php echo sptt_get_post_data('permalink'); ?>' title='Enlace permanente a <?php echo sptt_get_post_data('title'); ?>' rel='bookmark'>&infin;</a></li>
		<?php if ( sptt_post_has_link() ) { ?>
			<li><a href='<?php echo sptt_get_post_data('more_link'); ?>' title='Más información sobre <?php echo sptt_get_post_data('title'); ?>'>+</a></li>
		<?php } ?>
	</ul></footer>
</article>
</div><!-- .box -->
