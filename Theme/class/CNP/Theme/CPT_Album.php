<?php


namespace CNP\Theme;


class CPT_Album {

	public function __construct() {
		add_action( 'init', array( $this, 'setupCustomPostType' ) );
	}

	public function setupCustomPostType() {
		$labels  = array(
			'name'               => 'Alben',
			'singular_name'      => 'Album',
			'menu_name'          => 'Alben',
			'parent_item_colon'  => '',
			'all_items'          => 'Alben',
			'view_item'          => 'Album ansehen',
			'add_new_item'       => 'Neues Album',
			'add_new'            => 'Hinzufügen',
			'edit_item'          => 'Album bearbeiten',
			'update_item'        => 'Album aktualisieren',
			'search_items'       => '',
			'not_found'          => '',
			'not_found_in_trash' => '',
		);
		$rewrite = array();
		$args    = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=cngitem',
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-format-gallery',
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);
		register_post_type( 'cngalbum', $args );
	}


}