	<header>
	<div id="header">
		<div class="box">
			<?php if ( sptt_site_has_logo() ) { ?>
				<div id="sitelogo"><img src="<?php echo sptt_get_site_metadata("logo_url"); ?>" alt="<?php echo sptt_get_site_metadata("title"); ?>" /></div>
			<?php } ?>
			<div class="box-text">
				<h1 id="sitetit"><a href="<?php echo sptt_get_site_metadata("home"); ?>" title="Ir al inicio"><?php echo sptt_get_site_metadata("title"); ?></a></h1>
				<div id="sitedesc"><?php echo sptt_get_site_metadata("description"); ?></div>
			</div>
		</div>
	</div><!-- #header -->
	</header>
