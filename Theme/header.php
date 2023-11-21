<!DOCTYPE html>
<html lang="de">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="theme-color" content="#16191b">

	<!-- SEO META -->
	<title>Chris Noltekuhlmann - Freelance Photographer from Berlin</title>

	<!-- FAVICONS -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/images/favicons/manifest.json">
	<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/safari-pinned-tab.svg" color="#16191b">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicons/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/images/favicons/browserconfig.xml">
	<meta name="theme-color" content="#16191b">
	<?php wp_head(); ?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">
		var templateUrl = '<?= get_bloginfo("template_url"); ?>';
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';

		function cng_navigate(type, termid) {
			if(typeof cng !== "undefined") {
				if(type == null && termid == null) {
					cng.resetFilter();
				} else {
					cng.applyFilter(type, termid);
				}
			} else {
				window.location = 'http://noltekuhlmann.com/galerie/?type=' + type + '&termid=' + termid;
			}
		}
	</script>



</head>
<body>

<!-- Preloader -->
<?php if ( is_page_template( 'page_subpage.php' ) || is_page_template( 'page.php' ) ): ?>
<div class="page-loader-sub">
	<?php else: ?>
	<div class="page-loader">
		<?php endif; ?>

		<div class="loader">Loading...</div>
		<svg width="93" height="92" viewbox="0 0 40 40">
			<polygon points="0 0 0 40 40 40 40 0" class="rect"/>
		</svg>
		<div class="loaderback"></div>
	</div>
	<!-- Preloader end -->

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-nav">
			<a href="<?php echo site_url(); ?>"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg"></a>

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar top-bar"></span>
					<span class="icon-bar middle-bar"></span>
					<span class="icon-bar bottom-bar"></span>
				</button>
			</div>
			<div id="navbar" class="navbar-collapse collapse">

				<ul class="nav navbar-nav navbar-right">
					<li class="cng_null_null"><a href="#" onclick="cng_navigate(null, null)">Overview</a></li>
					<li class="dropdown cng_image_null">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle" onclick="cng_navigate('image', null)">Photos <b class="caret"></b></a>
						<ul class="dropdown-menu dropdown-menu-left  filters-button-group">
							<li><a class="filter" href="#" onclick="cng_navigate('image', null)">Show All</a></li>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'galleryphoto',
								'container'      => '',
								'items_wrap'     => '%3$s',
								'fallback_cb'    => false,
								'walker'         => new \CNP\Theme\GalleryImage_Menu_Walker(),
							) );
							?>
						</ul>
					</li>
					<li class="space-right cng_video_null"><a href="#" onclick="cng_navigate('video', null)">Videos</a></li>
					<?php /*
					<li class="active"><a href="index.html">Latest</a></li>
					<li class="dropdown">
						<!-- fotos filter werden automatisch reingeladen -->
						<a href="index.html" data-toggle="dropdown" class="dropdown-toggle">Photos <b class="caret"></b></a>
						<!-- klick auf foto ist gleich show all -->
						<ul class="dropdown-menu dropdown-menu-left  filters-button-group">
							<li><a class="filter" href="#" data-filter="*">Show All</a></li>
							<li><a class="filter" href="#" data-filter=".people">people</a></li>
							<li><a class="filter" href="#" data-filter=".landscape">landscape</a></li>
							<li><a class="filter" href="#" data-filter=".automotive">Automotive</a></li>
							<li><a class="filter" href="#" data-filter=".actors">Actors</a></li>
							<li><a class="filter" href="#" data-filter=".music">Music</a></li>
						</ul>
					</li>
					<!-- menuoption klasse space right -->
					<li class="dropdown space-right">
						<a href="index.html" data-toggle="dropdown" class="dropdown-toggle">Videos <b class="caret"></b></a>
						<ul class="dropdown-menu dropdown-menu-left">
							<li><a href="#">Lorem</a></li>
							<li><a href="#">Ipsum</a></li>
							<li><a href="#">Dolore</a></li>
						</ul>
					</li>*/ ?>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => '',
						'items_wrap'     => '%3$s',
						'fallback_cb'    => false,
						'walker'         => new \CNP\Theme\Top_Menu_Walker(),
					) );
					?>
					<?php
					$social_link_facebook  = get_field( 'social_link_facebook', 'option' );
					$social_link_twitter   = get_field( 'social_link_twitter', 'option' );
					$social_link_vimeo     = get_field( 'social_link_vimeo', 'option' );
					$social_link_instagram = get_field( 'social_link_instagram', 'option' );

					if ( strlen( $social_link_facebook ) >= 1 ) {
						echo sprintf( '<li class="social"><a href="%s"><i class="fa fa-facebook"></i></a></li>', $social_link_facebook );
					}
					if ( strlen( $social_link_twitter ) >= 1 ) {
						echo sprintf( '<li class="social"><a href="%s"><i class="fa fa-twitter"></i></a></li>', $social_link_twitter );
					}
					if ( strlen( $social_link_vimeo ) >= 1 ) {
						echo sprintf( '<li class="social"><a href="%s"><i class="fa fa-vimeo"></i></a></li>', $social_link_vimeo );
					}
					if ( strlen( $social_link_instagram ) >= 1 ) {
						echo sprintf( '<li class="social"><a href="%s"><i class="fa fa-instagram"></i></a></li>', $social_link_instagram );
					}
					?>


				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<!-- Content -->
