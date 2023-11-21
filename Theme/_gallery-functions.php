<?php

function cngalerie_admin_enqueue_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'fontawesome', 'http:////netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css', '', '4.2.0', 'all' );
	wp_register_style( 'cngalerie_style', get_template_directory_uri() . '/cngalerie/cngalerie.css' );
	wp_enqueue_style( 'cngalerie_style' );

}

add_action( 'admin_enqueue_scripts', 'cngalerie_admin_enqueue_scripts' );

//------------------------------------------------------------------------------

function cngalerie_menu() {
	add_menu_page( 'Galerie', 'Galerie', 'manage_options', 'cngalerie', 'cngalerie_default_page', 'dashicons-format-gallery', 20 );
	add_submenu_page( 'cngalerie', 'Alben', 'Alben', 'manage_options', 'cngal-alben', 'cngalerie_album_overview_page' );
	add_submenu_page( 'options.php', 'Album bearbeiten', 'Album bearbeiten', 'manage_options', 'cngal-album-edit', 'cngalerie_album_edit_page' );
}

add_action( 'admin_menu', 'cngalerie_menu' );

function cngalerie_default_page() {
	global $title;

	print '<div class="wrap">';
	print "<h1>$title</h1>";

	$file_edit = get_template_directory() . '/cngalerie/cngal-edit.php';

	if ( file_exists( $file_edit ) ) {
		require $file_edit;
	}

	print '</div>';
}

function cngalerie_album_overview_page() {
	global $title;

	print '<div class="wrap">';
	print "<h1>$title</h1>";

	$file_edit = get_template_directory() . '/cngalerie/cngal-album-list.php';

	if ( file_exists( $file_edit ) ) {
		require $file_edit;
	}

	print '</div>';
}


function cngalerie_album_edit_page() {
	global $title;

	print '<div class="wrap">';
	print "<h1>$title</h1>";

	$file_edit = get_template_directory() . '/cngalerie/cngal-album-edit.php';

	if ( file_exists( $file_edit ) ) {
		require $file_edit;
	}

	print '</div>';
}

//------------------------------------------------------------------------------


add_action( 'wp_ajax_cng_getitems', 'cngalerie_getitems_callback' );
add_action( 'wp_ajax_cng_additem', 'cngalerie_additem_callback' );
add_action( 'wp_ajax_cng_reorderitems', 'cngalerie_reorder_items_callback' );
add_action( 'wp_ajax_cng_updateitem', 'cngalerie_update_item_callback' );
add_action( 'wp_ajax_cng_deleteitem', 'cngalerie_delete_item_callback' );
add_action( 'wp_ajax_cng_getimgattachmentid', 'cngalerie_get_image_attachment_id_callback' );
add_action( 'wp_ajax_cng_getvideoinfo', 'cngalerie_get_video_info_callback' );
add_action( 'wp_ajax_cng_album_getdetails', 'cngalerie_get_album_details_callback' );
add_action( 'wp_ajax_cng_album_updatedetails', 'cngalerie_update_album_details_callback' );
add_action( 'wp_ajax_cng_album_delete', 'cngalerie_delete_album_callback' );
add_action( 'wp_ajax_cng_albums_get', 'cngalerie_get_albums_callback' );
add_action( 'wp_ajax_cng_album_create', 'cngalerie_create_album_callback' );


// Frontend
add_action( 'wp_ajax_cng_fe_getdata', 'cngalerie_fe_getData' );
add_action( 'wp_ajax_nopriv_cng_fe_getdata', 'cngalerie_fe_getData' );

function cngalerie_getitems_callback() {
	global $wpdb;

	$query_args = array(
		'post_type'      => 'cngitem',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => 'cng_albumid',
				'compare' => '=',
				'type'    => 'SIGNED',
				'value'   => 0,
			),
			array(
				'key'     => 'cng_albumid',
				'compare' => 'NOT EXISTS',
			),
		),
		'meta_key'       => 'cng_frontorder',
		'orderby'        => 'meta_value_num',
		'order'          => ASC
	);

	$galleryitems = new WP_Query( $query_args );

	$response = [ ];

	foreach ( $galleryitems->posts as $item ) {
		$mediatype = get_field( 'cng_itemtype', $item->ID );

		$newitem                = [ ];
		$newitem['post_ID']     = $item->ID;
		$newitem['post_status'] = $item->post_status;
		$newitem['itemtype']    = 'attachment';
		$newitem['mediatype']   = $mediatype;
		if ( $mediatype == 'image' || $mediatype == 'video' ) {
			$newitem['preview_img'] = get_field( 'cng_image', $item->ID )['sizes']['thumbnail'];
		}
		if ( $mediatype == 'album' ) {
			$album_post_id            = get_post_meta( $item->ID, 'cng_album_postid' )[0];
			$newitem['preview_img']   = wp_get_attachment_image_url( get_post_meta( $album_post_id, 'cng_image' )[0], 'thumbnail' );
			$newitem['album_post_id'] = $album_post_id;
		}
		array_push( $response, $newitem );
	}

	echo json_encode( $response );

	wp_die();
}

function cngalerie_additem_callback() {
	global $wpdb;

	$mediatype = $_POST['mediatype'];
	if ( $mediatype == 'image' ) {

		$image_id = intval( $_POST['image_id'] );
		$album_id = 0;
		$album_id = intval( $_POST['album_id'] );

		$post_id = wp_insert_post(
			array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => get_current_user_id(),
				'post_title'     => '',
				'post_status'    => 'publish',
				'post_type'      => 'cngitem'
			)
		);


		add_post_meta( $post_id, 'cng_albumid', $album_id, true );
		add_post_meta( $post_id, 'cng_itemtype', 'image', true );
		add_post_meta( $post_id, '_cng_itemtype', 'field_37D841DD989BB', true );
		add_post_meta( $post_id, 'cng_image', $image_id, true );
		add_post_meta( $post_id, '_cng_image', 'field_EF366F648CE35', true );
		add_post_meta( $post_id, 'cng_frontorder', 9999, true );

		echo json_encode( array( 'success' => true, 'new_post_id' => $post_id ) );
		wp_die();
	}

	if ( $mediatype == 'video' ) {
		$previmg_id = intval( $_POST['previmg_id'] );
		$videourl   = $_POST['videourl'];
		$album_id   = 0;
		$album_id   = intval( $_POST['album_id'] );
		$videotitle = $_POST['videotitle'];
		$termids    = $_POST['termids'];

		$post_id = wp_insert_post(
			array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => get_current_user_id(),
				'post_title'     => $videotitle,
				'post_status'    => 'publish',
				'post_type'      => 'cngitem'
			)
		);


		$newTermIds = [ ];
		foreach ( $termids as $termid ) {
			array_push( $newTermIds, (int) $termid );
		}

		wp_set_object_terms( $post_id, $newTermIds, 'media_category', false );


		add_post_meta( $post_id, 'cng_albumid', $album_id, true );
		add_post_meta( $post_id, 'cng_itemtype', 'video', true );
		add_post_meta( $post_id, '_cng_itemtype', 'field_37D841DD989BB', true );
		add_post_meta( $post_id, 'cng_image', $previmg_id, true );
		add_post_meta( $post_id, '_cng_image', 'field_EF366F648CE35', true );
		add_post_meta( $post_id, 'cng_videourl', $videourl, true );
		add_post_meta( $post_id, 'cng_videosrc', 'vimeo', true );
		add_post_meta( $post_id, 'cng_frontorder', 9999, true );

		echo json_encode( array( 'success' => true, 'new_post_id' => $post_id ) );
		wp_die();
	}

	if ( $mediatype == 'album' ) {
		$album_id = intval( $_POST['album_id'] );

		$post_id = wp_insert_post(
			array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => get_current_user_id(),
				'post_title'     => '',
				'post_status'    => 'publish',
				'post_type'      => 'cngitem'
			)
		);

		add_post_meta( $post_id, 'cng_album_postid', $album_id, true );
		add_post_meta( $post_id, 'cng_albumid', 0, true );
		add_post_meta( $post_id, 'cng_itemtype', 'album', true );
		add_post_meta( $post_id, '_cng_itemtype', 'field_37D841DD989BB', true );
		add_post_meta( $post_id, 'cng_frontorder', 9999, true );

		echo json_encode( array( 'success' => true, 'new_post_id' => $post_id ) );
		wp_die();
	}

	echo json_encode( array( 'success' => false ) );
	wp_die();
}

function cngalerie_create_album_callback() {
	$post_id = wp_insert_post(
		array(
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'post_author'    => get_current_user_id(),
			'post_title'     => 'Neues Album',
			'post_status'    => 'publish',
			'post_type'      => 'cngalbum'
		)
	);

	echo json_encode( array( 'success' => true, 'new_album_id' => $post_id ) );
	wp_die();
}

function cngalerie_update_item_callback() {
	global $wpdb;

	$post_id    = intval( $_POST['item_id'] );
	$previmg_id = intval( $_POST['previmg_id'] );
	$videourl   = $_POST['videourl'];
	$videotitle = $_POST['videotitle'];

	$termids = $_POST['termids'];

	$newTermIds = [ ];
	if ( $termids ) {
		foreach ( $termids as $termid ) {
			array_push( $newTermIds, (int) $termid );
		}
		wp_set_object_terms( $post_id, $newTermIds, 'media_category', false );
	}

	wp_update_post( array(
		'ID'         => $post_id,
		'post_title' => $videotitle,
	) );

	update_post_meta( $post_id, 'cng_image', $previmg_id );
	update_post_meta( $post_id, 'cng_videourl', $videourl );

	echo json_encode( array( 'success' => true ) );
	wp_die();
}

function cngalerie_reorder_items_callback() {
	global $wpdb;
	$orderarray = $_POST['orderarray'];

	foreach ( $orderarray as $item ) {
		update_post_meta( $item['item_id'], 'cng_frontorder', intval( $item['index'] ) + 1 );
	}
	echo json_encode( array( 'success' => true ) );
	wp_die();
}

function cngalerie_delete_item_callback() {
	global $wpdb;
	$item_id = $_POST['item_id'];
	wp_delete_post( $item_id, true );
	echo json_encode( array( 'success' => true ) );
	wp_die();
}

function cngalerie_get_image_attachment_id_callback() {
	global $wpdb;
	$item_id       = $_POST['item_id'];
	$attachment_id = get_field( 'cng_image', $item_id )['ID'];
	echo json_encode( array( 'success' => true, 'attachment_id' => $attachment_id ) );
	wp_die();
}

function cngalerie_get_video_info_callback() {
	global $wpdb;
	$item_id = $_POST['item_id'];

	$infoarray                = array();
	$infoarray['item_id']     = $item_id;
	$infoarray['previmg_url'] = get_field( 'cng_image', $item_id )['sizes']['thumbnail'];
	$infoarray['previmg_id']  = get_field( 'cng_image', $item_id )['ID'];
	$infoarray['videourl']    = get_field( 'cng_videourl', $item_id );
	$infoarray['videosrc']    = get_field( 'cng_videosrc', $item_id );
	$infoarray['termids']     = [ ];
	$infoarray['videotitle']  = get_the_title( $item_id );
	foreach ( wp_get_post_terms( $item_id, 'media_category' ) as $term ) {
		array_push( $infoarray['termids'], $term->term_id );
	}


	echo json_encode( $infoarray );
	wp_die();
}


function cngalerie_get_album_details_callback() {
	global $wpdb;

	$album_id = intval( $_POST['album_id'] );

	$query_args = array(
		'post_type'      => 'cngitem',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'cng_albumid',
				'compare' => '=',
				'value'   => $album_id
			)
		),
		'meta_key'       => 'cng_frontorder',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC'
	);

	$dbitems = new WP_Query( $query_args );

	$data                = [ ];
	$data['album_id']    = $album_id;
	$data['album_title'] = get_the_title( $album_id );
	$data['items']       = [ ];
	if ( count( get_post_meta( $album_id, 'cng_image' ) ) > 0 ) {
		$data['previmg_id']  = get_post_meta( $album_id, 'cng_image' )[0];
		$data['previmg_url'] = wp_get_attachment_image_url( get_post_meta( $album_id, 'cng_image' )[0], 'thumbnail' );
	}

	foreach ( $dbitems->posts as $item ) {
		$newitem                = [ ];
		$newitem['item_id']     = $item->ID;
		$newitem['mediatype']   = get_post_meta( $item->ID, 'cng_itemtype' )[0];
		$newitem['itemtype']    = 'attachment';
		$newitem['previmg_id']  = intval( get_post_meta( $item->ID, 'cng_image' )[0] );
		$newitem['previmg_url'] = wp_get_attachment_image_url( get_post_meta( $item->ID, 'cng_image' )[0], 'thumbnail' );

		array_push( $data['items'], $newitem );
	}

	echo json_encode( $data );
	wp_die();
}

function cngalerie_update_album_details_callback() {
	global $wpdb;

	$album_id         = $_POST['album_id'];
	$album_title      = $_POST['album_title'];
	$album_previmg_id = $_POST['album_previmg_id'];

	wp_update_post( array(
		'ID'         => $album_id,
		'post_title' => $album_title,
	) );

	update_post_meta( $album_id, 'cng_image', $album_previmg_id );

	echo json_encode( array( 'success' => true ) );
	wp_die();
}

function cngalerie_delete_album_callback() {
	global $wpdb;

	$album_id = intval( $_POST['album_id'] );

	$query_args = array(
		'post_type'      => 'cngitem',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'cng_albumid',
				'compare' => '=',
				'value'   => $album_id
			)
		),
		'meta_key'       => 'cng_frontorder',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC'
	);

	$dbitems = new WP_Query( $query_args );

	foreach ( $dbitems->posts as $item ) {
		wp_delete_post( $item->ID, true );
	}

	wp_delete_post( $album_id, true );
	echo json_encode( array( 'success' => true ) );
	wp_die();
}

function cngalerie_get_albums_callback() {
	global $wpdb;

	$query_args = array(
		'post_type'      => 'cngalbum',
		'posts_per_page' => - 1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$albums = new WP_Query( $query_args );

	$data = [ ];
	foreach ( $albums->posts as $album ) {
		array_push( $data, [ 'id' => $album->ID, 'title' => $album->post_title ] );
	}

	echo json_encode( $data );
	wp_die();
}


//------------------------------------------------------------------------------
// Frontend
//------------------------------------------------------------------------------


function cngalerie_fe_getImageEntry( &$targetArray, $id ) {
	$image_id             = intval( get_post_meta( $id, 'cng_image' )[0] );
	$targetArray['terms'] = [ ];
	$terms                = wp_get_post_terms( $image_id, 'media_category' );
	foreach ( $terms as $term ) {
		array_push( $targetArray['terms'], $term->term_id );
	}
	$targetArray['previmg_src']  = wp_get_attachment_image_url( $image_id, 'large' );
	$targetArray['thumbimg_src'] = wp_get_attachment_image_url( $image_id, 'thumbnail' );
	$targetArray['image_src']    = wp_get_attachment_image_url( $image_id, 'large' );
	$targetArray['image_srcset'] = wp_get_attachment_image_srcset( $image_id, 'full' );
	$targetArray['image_alt']    = get_post_meta( $image_id, '_wp_attachment_image_alt' )[0];
	$targetArray['title']        = get_post( $image_id )->post_excerpt;
	$targetArray['sort']         = get_post_meta( $id, 'cng_frontorder' )[0];
}

function cngalerie_fe_getVideoEntry( &$targetArray, $id ) {
	$image_id             = intval( get_post_meta( $id, 'cng_image' )[0] );
	$targetArray['terms'] = [ ];
	$terms                = wp_get_post_terms( $id, 'media_category' );
	foreach ( $terms as $term ) {
		array_push( $targetArray['terms'], $term->term_id );
	}
	$targetArray['previmg_src']  = wp_get_attachment_image_url( $image_id, 'large' );
	$targetArray['thumbimg_src'] = wp_get_attachment_image_url( $image_id, 'thumbnail' );
	$targetArray['video_url']    = get_post_meta( $id, 'cng_videourl' )[0];
	$targetArray['image_srcset'] = wp_get_attachment_image_srcset( $image_id, 'large' );
	$targetArray['image_alt']    = get_post_meta( $image_id, '_wp_attachment_image_alt' )[0];
	$targetArray['title']        = get_the_title( $id );
	$targetArray['sort']         = get_post_meta( $id, 'cng_frontorder' )[0];
}

function cngalerie_fe_getData() {

	$response          = array();
	$response['items'] = [ ];

	$paged = ( $_POST['paged'] ) ? $_POST['paged'] : null;

	$query_args = array(
		'post_type'      => 'cngitem',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => 'cng_albumid',
				'compare' => '=',
				'type'    => 'SIGNED',
				'value'   => 0,
			),
			array(
				'key'     => 'cng_albumid',
				'compare' => 'NOT EXISTS',
			),
		),
		'meta_key'       => 'cng_frontorder',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		//'paged'          => $paged,
	);

	if ( $paged != null ) {
		$query_args['posts_per_page'] = 10;
		$query_args['paged']          = $paged;
	}


	$dbitems           = new WP_Query( $query_args );
	$response['pages'] = $dbitems->max_num_pages;


	foreach ( $dbitems->posts as $item ) {
		$newItem              = [ ];
		$newItem['mediatype'] = get_post_meta( $item->ID, 'cng_itemtype' )[0];
		$newItem['key']       = $item->ID;

		if ( $newItem['mediatype'] == 'image' ) {
			cngalerie_fe_getImageEntry( $newItem, $item->ID );
		}

		if ( $newItem['mediatype'] == 'video' ) {
			cngalerie_fe_getVideoEntry( $newItem, $item->ID );
		}

		if ( $newItem['mediatype'] == 'album' ) {
			$album_post_id               = get_post_meta( $item->ID, 'cng_album_postid' )[0];
			$newItem['album_post_id']    = $album_post_id;
			$newItem['previmg_src']      = wp_get_attachment_image_url( get_post_meta( $album_post_id, 'cng_image' )[0], 'large' );
			$newItem['thumbimg_src'] = wp_get_attachment_image_url( get_post_meta( $album_post_id, 'cng_image' )[0], 'thumbnail' );
			$newItem['subitems']         = [ ];
			$newItem['terms']            = [ ];
			$newItem['image_alt']        = '';
			$newItem['title']            = get_post( $album_post_id )->post_title;
			$newItem['sort']             = get_post_meta( $item->ID, 'cng_frontorder' )[0];

			$album_query_args = array(
				'post_type'      => 'cngitem',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					array(
						'key'     => 'cng_albumid',
						'compare' => '=',
						'value'   => $album_post_id
					)
				),
				'meta_key'       => 'cng_frontorder',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC'
			);

			$dbalbumitems = new WP_Query( $album_query_args );

			foreach ( $dbalbumitems->posts as $albumitem ) {
				$newAlbumItem              = [ ];
				$newAlbumItem['mediatype'] = get_post_meta( $albumitem->ID, 'cng_itemtype' )[0];
				$newAlbumItem['key']       = $albumitem->ID;

				$terms = array();
				if ( $newAlbumItem['mediatype'] == 'image' ) {
					$terms = wp_get_post_terms( intval( get_post_meta( $albumitem->ID, 'cng_image' )[0] ), 'media_category' );
				}
				if ( $newAlbumItem['mediatype'] == 'video' ) {
					$terms = wp_get_post_terms( $albumitem->ID, 'media_category' );
				}
				foreach ( $terms as $term ) {
					if ( ! in_array( $term->term_id, $newItem['terms'] ) ) {
						array_push( $newItem['terms'], $term->term_id );
					}
				}


				if ( $newAlbumItem['mediatype'] == 'image' ) {
					cngalerie_fe_getImageEntry( $newAlbumItem, $albumitem->ID );
				}
				if ( $newAlbumItem['mediatype'] == 'video' ) {
					cngalerie_fe_getVideoEntry( $newAlbumItem, $albumitem->ID );
				}

				array_push( $newItem['subitems'], $newAlbumItem );
			}
		}

		array_push( $response['items'], $newItem );

	}
	$response['itemcount'] = count( $response['items'] );


	wp_send_json( $response );
}