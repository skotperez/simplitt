<aside>
	<div id="blocks" class='box'>
		<div class="box-text">
			<h3 class="box-tit">Sections</h3>
		</div>
		<nav><ul class='box-footer'>
		<?php foreach ( sptt_get_data('categs') as $cat ) {
			$cat_perma = sptt_get_cat_link($cat); ?>

			<li><a href='<?php echo $cat_perma ?>'><?php echo $cat ?></a></li>

		<?php } ?>
		</ul></nav>
	</div><!-- .box -->
</aside>
