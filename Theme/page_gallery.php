<?php
/**
 * Template Name: Galerie
 *
 */
get_header(); ?>

	<div class="main start" id="gallerygrid">

	</div>

<?php
$cng_usefilter    = false;
$cng_filtertype   = ( $_GET['type'] ) ? $_GET['type'] : 'null';
$cng_filtertermid = ( $_GET['termid'] ) ? $_GET['termid'] : 'null';

if ( $cng_filtertype == 'null' ) {
	$cng_usefilter = false;
} else {
	$cng_usefilter = true;
}

?>

	<script type="text/javascript">
		var cng = {};
		var cng_filter = <?php echo ($cng_usefilter) ? 'true' : 'false'; ?>;
		var cng_typefilter = <?php echo ($cng_filtertype != null || $cng_filtertype != 'null') ? "'" . $cng_filtertype . "'" : 'image'; ?>;
		var cng_filterid = <?php echo ($cng_filtertermid != null) ? $cng_filtertermid : 'null'; ?>;

		cng.fireOnReady = function() {
			$('.page-loader').delay(350).fadeOut('slow');
		};
	</script>


	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/cngalerie/js/cngalerie.js"></script>

<?php get_footer(); ?>