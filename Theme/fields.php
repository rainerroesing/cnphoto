<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( function_exists( 'register_field_group' ) ):

	$layout_ClientList = array(
		'key'        => 'layoutClientList',
		'name'       => 'clientList',
		'label'      => 'Kundenliste',
		'display'    => 'block',
		'sub_fields' => array(
			array(
				'key'   => 'field_5FC5B92760F05',
				'name'  => 'headline',
				'type'  => 'text',
				'label' => 'Überschrift',
			),
			array(
				'key'               => 'field_93F652B1AB0B5',
				'label'             => 'Kunden',
				'name'              => 'clients',
				'type'              => 'repeater',
				'required'          => 0,
				'conditional_logic' => 0,
				'min'               => '',
				'max'               => '',
				'layout'            => 'table',
				'button_label'      => 'Kunde hinzufügen',
				'sub_fields'        => array(
					array(
						'key'   => 'field_3EF9913E8FEDD',
						'label' => 'Name',
						'name'  => 'clientname',
						'type'  => 'text',
					)
				),
			)
		)
	);

	$layout_Headline = array(
		'key'        => 'layoutHeadline',
		'name'       => 'headline',
		'label'      => 'Überschrift',
		'display'    => 'block',
		'sub_fields' => array(
			array(
				'key'   => 'field_3BA4CD9F5DBB6',
				'name'  => 'headline',
				'type'  => 'text',
				'label' => 'Überschrift',
			)
		)
	);

	$layout_TwoColImgText = array(
		'key'        => 'layoutTwoColImgText',
		'name'       => 'twoColImgText',
		'label'      => 'Zweispalter Bild/Text',
		'display'    => 'block',
		'sub_fields' => array(
			array(
				'key'           => 'field_1422C397EF4B6',
				'name'          => 'image',
				'type'          => 'image',
				'label'         => 'Bild',
				'return_format' => 'object',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
				'min_width'     => '',
				'min_height'    => '',
				'min_size'      => '',
				'max_width'     => '',
				'max_height'    => '',
				'max_size'      => '',
				'mime_types'    => '',
			),
			array(
				'key'          => 'field_5895EDCE3A7B4',
				'label'        => 'Text',
				'name'         => 'content',
				'type'         => 'wysiwyg',
				'tabs'         => 'all',
				'toolbar'      => 'full',
				'media_upload' => 0,
			),
		)
	);

	$flexField_pageContent = array(
		'key'          => 'field_pageContent001',
		'label'        => 'Seiteninhalt',
		'name'         => 'pagecontent',
		'type'         => 'flexible_content',
		'button_label' => 'Element hinzufügen',
		'layouts'      => array(
			$layout_ClientList,
			$layout_Headline,
			$layout_TwoColImgText,
		),
	);


	$group_pageLayoutMain = array(
		'key'                   => 'group_PageGroup0001',
		'title'                 => 'Seite',
		'fields'                => array(
			$flexField_pageContent,
		),
		'location'              => array(
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'default',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => array(
			//0  => 'permalink',
			1  => 'the_content',
			//2  => 'excerpt',
			3  => 'custom_fields',
			4  => 'discussion',
			5  => 'comments',
			6  => 'revisions',
			7  => 'slug',
			8  => 'author',
			9  => 'format',
			//10 => 'page_attributes',
			11 => 'featured_image',
			12 => 'categories',
			13 => 'tags',
			14 => 'send-trackbacks',
		),
	);

	acf_add_local_field_group( $group_pageLayoutMain );


	$group_postLayoutDefault = array(
		'key'                   => 'group_PostLayout0001',
		'title'                 => 'weiterer Inhalt',
		'fields'                => array(
			array(
				'key'          => 'field_1E5C924AFBA8E',
				'label'        => '"Show more" - Inhalt',
				'name'         => 'showmoretext',
				'type'         => 'wysiwyg',
				'tabs'         => 'all',
				'toolbar'      => 'full',
				'media_upload' => 0,
			),
			array(
				'key'           => 'field_88D8627FCDB29',
				'label'         => 'Vorschaubilder',
				'name'          => 'postimages',
				'type'          => 'gallery',
				'return_format' => 'object',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
				'min_width'     => '',
				'min_height'    => '',
				'min_size'      => '',
				'max_width'     => '',
				'max_height'    => '',
				'max_size'      => '',
				'mime_types'    => '',
			),
			array(
				'key'               => 'field_1CEFF1F85CB70',
				'label'             => 'weitere Bilder',
				'name'              => 'additionalimgs',
				'prefix'            => '',
				'type'              => 'gallery',
				'return_format'     => 'object',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'min'               => '',
				'max'               => '',
				'preview_size'      => 'thumbnail',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => array(
			//0  => 'permalink',
			//1  => 'the_content',
			2  => 'excerpt',
			3  => 'custom_fields',
			4  => 'discussion',
			5  => 'comments',
			6  => 'revisions',
			7  => 'slug',
			8  => 'author',
			9  => 'format',
			//10 => 'page_attributes',
			//11 => 'featured_image',
			12 => 'categories',
			13 => 'tags',
			14 => 'send-trackbacks',
		),
	);
	acf_add_local_field_group( $group_postLayoutDefault );


	//------------------------------------------------------------------------------
	// region Options Page

	register_field_group( array(
		'key'                   => 'group_FA49904BBADAF',
		'title'                 => 'Optionen',
		'fields'                => array(
			array(
				'key'       => 'field_2D85E19B660BE',
				'label'     => 'Social Links',
				'name'      => '',
				'type'      => 'tab',
				'placement' => 'top',
			),
			array(
				'key'           => 'field_24E496F012599',
				'label'         => 'Facebook',
				'name'          => 'social_link_facebook',
				'prefix'        => '',
				'type'          => 'url',
				'instructions'  => '',
				'required'      => 0,
				'default_value' => '',
				'placeholder'   => 'http://',
			),
			array(
				'key'           => 'field_013C50922CDBB',
				'label'         => 'Twitter',
				'name'          => 'social_link_twitter',
				'prefix'        => '',
				'type'          => 'url',
				'instructions'  => '',
				'required'      => 0,
				'default_value' => '',
				'placeholder'   => 'http://',
			),
			array(
				'key'           => 'field_D002BE01DECC7',
				'label'         => 'Vimeo',
				'name'          => 'social_link_vimeo',
				'prefix'        => '',
				'type'          => 'url',
				'instructions'  => '',
				'required'      => 0,
				'default_value' => '',
				'placeholder'   => 'http://',
			),
			array(
				'key'           => 'field_193F8C15905B2',
				'label'         => 'Instagram',
				'name'          => 'social_link_instagram',
				'prefix'        => '',
				'type'          => 'url',
				'instructions'  => '',
				'required'      => 0,
				'default_value' => '',
				'placeholder'   => 'http://',
			),
			array(
				'key'       => 'field_F53DA61F09E77',
				'label'     => 'Interne Links',
				'name'      => '',
				'type'      => 'tab',
				'placement' => 'top',
			),
			array(
				'key'               => 'field_6CA4CAF51B465',
				'label'             => 'Link für Copyright Vermerk',
				'name'              => 'copyrightlink',
				'instructions'      => 'Dieser Link wird für den Copyright Vermerk im Footer der Seite verwendet.',
				'prefix'            => '',
				'type'              => 'page_link',
				'required'          => 0,
				'post_type' => array (
					0 => 'page',
				),
				'taxonomy'          => '',
				'allow_null'        => 1,
				'multiple'          => 0,
			),

		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'ctwp-web-settings',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
	) );

	// endregion
	//------------------------------------------------------------------------------

	include_once( '_fields-cpt_cngitem.php' );
	include_once( '_fields-cpt_cngclient.php' );

endif;
