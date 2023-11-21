<?php


namespace CNP\Theme;


class CPT_Item {

	public function __construct() {
		add_action( 'init', array( $this, 'setupCustomPostType' ) );
		add_action( 'admin_menu', array( $this, 'removeMenuItems' ) );
		add_filter( 'manage_cngitem_posts_columns', array( $this, 'alterColumnHeader' ) );
		add_action( 'manage_cngitem_posts_custom_column', array( $this, 'renderColumnContent' ), 10, 2 );
	}

	public function setupCustomPostType() {
		$labels  = array(
			'name'               => 'Galerie Elemente',
			'singular_name'      => 'Galerie Element',
			'menu_name'          => 'Galerie',
			'parent_item_colon'  => '',
			'all_items'          => 'Galerie Elemente',
			'view_item'          => 'Galerie Element ansehen',
			'add_new_item'       => 'Neues Galerie Element',
			'add_new'            => 'Hinzufügen',
			'edit_item'          => 'Galerie Element bearbeiten',
			'update_item'        => 'Galerie Element aktualisieren',
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
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-format-gallery',
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);
		register_post_type( 'cngitem', $args );
	}

	public function removeMenuItems() {
		remove_submenu_page( 'edit.php?post_type=cngitem', 'post-new.php?post_type=cngitem' );
		remove_menu_page('edit.php?post_type=cngitem');
	}

	/**
	 * Alters the columns on admin page for CPT Item
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function alterColumnHeader( $columns ) {
		$newColumns = array();
		foreach ( $columns as $key => $title ) {

			if ( $key == 'title' ) {
				$newColumns['cng_preview'] = 'Vorschau';
				$newColumns['cng_type']    = 'Typ';
			}

			$newColumns[ $key ] = $title;
		}

		unset( $newColumns['title'] );
		unset( $newColumns['date'] );

		return $newColumns;
	}


	/**
	 * Renders the column contents on admin page for CPT Item
	 *
	 * @param $column_name
	 * @param $post_id
	 */
	public function renderColumnContent( $column_name, $post_id ) {
		$itemtype = get_field( 'cng_itemtype', $post_id );
		if ( $column_name == 'cng_preview' ) {
			switch ( $itemtype ) {
				case 'image':
					echo sprintf( '<img src="%s" />', get_field( 'cng_image', $post_id )['sizes']['thumbnail'] );
					break;
				case 'video':
					echo 'video';
					break;
			}
		}

		if ( $column_name == 'cng_type' ) {
			switch ( $itemtype ) {
				case 'image':
					echo 'Bild';
					break;
				case 'video':
					echo 'Video';
					break;
				case 'album':
					echo 'Album';
					break;
			}
		}
	}

}