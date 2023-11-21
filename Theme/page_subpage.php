<?php
/**
 * Template Name: Unterseite
 *
 */
?>
<?php
get_header();
?>
	<div class="main">
		<div class="container">
			<div class="ContentBox">
				<div class="ContentWrapper">
					<?php
					while ( have_posts() ): the_post();

						get_template_part( 'content', 'page' );

					endwhile;
					?>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();
?>