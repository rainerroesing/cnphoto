<?php get_header(); ?>
	<div class="main blog">
		<div class="container">

			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php

					while ( have_posts() ) : the_post();
						?>

						<div class="row post wow fadeIn" data-wow-delay="0.2s">
							<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

								<div class="posttitle">
									<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
									<div class="tl"></div>
									<div class="tr"></div>
									<div class="bl"></div>
									<div class="br"></div>
								</div>

								<!-- Post Content -->
								<div class="postPreviewContent">
									<div class="entry-content">
										<?php the_content(); ?>
										<?php
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
											'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
											'separator'   => '<span class="screen-reader-text">, </span>',
										) );
										?>
									</div>

									<?php
									if ( get_field( 'postimages', get_the_ID() ) ):
										foreach ( get_field( 'postimages', get_the_ID() ) as $addimg ):
											?>
											<a class="fancybox-thumbs" data-thumbimg="<?php echo wp_get_attachment_image_url( $addimg['ID'], 'thumbnail' ); ?>" rel="group-post<?php echo get_the_ID(); ?>" href="<?php echo $addimg['url']; ?>">
												<img class="img-responsive" src="<?php echo $addimg['url']; ?>"
												     srcset="<?php echo wp_get_attachment_image_srcset( $addimg['ID'] ); ?>"
												     alt="<?php echo $addimg['alt']; ?>">
											</a>
											<?php
										endforeach;
									endif;
									?>
								</div>
								<?php if ( strlen( get_field( 'showmoretext', get_the_ID() ) ) >= 1 || get_field( 'additionalimgs', get_the_ID() ) ): ?>
									<!-- Button -->
									<div class="expbtn">
										<a id="longpost-<?php echo get_the_ID(); ?>" class="btn btn-primary hidden-button" data-toggle="collapse" href="#collapse-post<?php echo get_the_ID(); ?>" aria-expanded="false" aria-controls="">
											Show <b class="caret"></b> more
										</a>
									</div>
									<!-- Collabsed Content -->
									<div class="collapse wow fadeIn" data-wow-delay="0.2s" id="collapse-post<?php echo get_the_ID(); ?>">
										<div class="additional">
											<?php
											if ( strlen( get_field( 'showmoretext', get_the_ID() ) ) >= 1 ):
												echo get_field( 'showmoretext', get_the_ID() );
											endif;
											if ( get_field( 'additionalimgs', get_the_ID() ) ):
												foreach ( get_field( 'additionalimgs', get_the_ID() ) as $addimg ):
													?>
													<a class="fancybox-thumbs" data-thumbimg="<?php echo wp_get_attachment_image_url( $addimg['ID'], 'thumbnail' ); ?>" rel="group-post<?php echo get_the_ID(); ?>" href="<?php echo $addimg['url']; ?>">
														<img class="img-responsive" src="<?php echo $addimg['url']; ?>"
														     srcset="<?php echo wp_get_attachment_image_srcset( $addimg['ID'] ); ?>"
														     alt="<?php echo $addimg['alt']; ?>">
													</a>
													<?php
												endforeach;
											endif;
											?>
										</div>
									</div>
								<?php endif; ?>
							</div>
							<!-- /.col -->
						</div>

						<?php
					endwhile;
					?>

					<?php
					the_posts_pagination( array(
						'prev_text'          => 'Previous Page',
						'next_text'          => 'Next Page',
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . '',
						' </span>',
					) );
					?>

				</main>
				<!-- .site-main -->
			</div>
			<!-- .content-area -->
		</div>
	</div>

<?php get_footer(); ?>