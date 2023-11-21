<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

$group_cpt_cngitem_details = array(
	'key'                   => 'group_E2AC45A95DAB8',
	'title'                 => 'Galerie Element',
	'fields'                => array(
		array(
			'key'        => 'field_37D841DD989BB',
			'name'       => 'cng_itemtype',
			'label'      => 'Typ',
			'type'       => 'select',
			'choices'    => array(
				'image' => 'Bild',
				'video' => 'Video',
				'album' => 'Album'
			),
			'allow_null' => 0,
		),
		array(
			'key'               => 'field_EF366F648CE35',
			'label'             => 'Bild',
			'name'              => 'cng_image',
			'prefix'            => '',
			'type'              => 'image',
			'instructions'      => '',
			'required'          => 1,
			'return_format'     => 'object',
			'preview_size'      => 'medium',
			'library'           => 'all',
			'min_width'         => '',
			'min_height'        => '',
			'min_size'          => '',
			'max_width'         => '',
			'max_height'        => '',
			'max_size'          => '',
			'mime_types'        => '',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_37D841DD989BB',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
		),
	),
	'location'              => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'cngitem',
			)
		)
	),
	'menu_order'            => 0,
	'position'              => 'normal',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'field',
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
	)
);

acf_add_local_field_group( $group_cpt_cngitem_details );

// Fields for Custom Post Type "cngitem"

