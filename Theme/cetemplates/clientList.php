<div class="row">
	<div class="col-xs-12 clients col-sm-7 col-sm-offset-2 wow fadeIn" data-wow-delay="0.2s">
		<h2><?php echo get_sub_field( 'headline' ); ?></h2>
		<ul class="clients">
			<?php while ( have_rows( 'clients' ) ):the_row(); ?>
				<li><?php echo get_sub_field( 'clientname' ); ?></li>
			<?php endwhile; ?>
		</ul>

	</div>
</div>
