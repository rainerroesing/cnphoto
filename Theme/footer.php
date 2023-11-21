
<!-- Footer -->
<footer class="rollin">
	<div class="row">
		<div class="col-lg-12">
			<p><a href="<?php echo (strlen(get_field('copyrightlink', 'option')) >= 1 ) ? get_field('copyrightlink', 'option') : get_site_url(); ?>">&copy; Chris Noltekuhlmann</a><?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => '',
					'items_wrap'     => '%3$s',
					'fallback_cb'    => false,
					'walker'         => new \CNP\Theme\Footer_Menu_Walker(),
				) );
				?></p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
