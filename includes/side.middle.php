<aside>
	<div class='box'>
		<nav><ul class='box-text'>
		<?php foreach ( sptt_get_data('categs') as $cat ) {
			$cat_perma = sptt_get_cat_link($cat); ?>

			<li><a href='<?php echo $cat_perma ?>' class='scrolltoanchor'><?php echo $cat ?></a></li>

		<?php } ?>
		</ul></nav>
	</div><!-- .box -->
</aside>
