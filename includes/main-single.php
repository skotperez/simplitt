<div class='article'>
<article>
	<?php if ( sptt_post_has_image() ) { ?>
		<figure><img src='<?php echo sptt_get_post_data('image_url'); ?>' alt='<?php echo sptt_get_post_data('image_url'); ?>' /></figure>
	<?php } ?>
	<div class='article-text'>
		<header><h2 class='article-tit'><?php echo sptt_get_post_data('title'); ?></h2></header>
		<ul class='article-meta'>
			<li><a href='<?php echo sptt_get_cat_link(sptt_get_post_data('category')); ?>' title='<?php echo sptt_get_post_data('category'); ?>'>#<?php echo sptt_get_post_data('category'); ?></a></li>
		</ul>
		<?php if ( sptt_post_has_description() ) { ?>
			<div class='box-desc'><?php echo sptt_get_post_data('content'); ?></div>
		<?php } ?>
		<?php if ( sptt_post_has_link() ) { ?>
			<ul class='article-meta'>
				<li><a href='<?php echo sptt_get_post_data('more_link'); ?>' title='Más información sobre <?php echo sptt_get_post_data('title'); ?>'>Más información</a> (enlace externo)</li>
			</ul>
		<?php } ?>
	</div>
	</article>
</div><!-- .article -->
