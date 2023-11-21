<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

$group_cpt_cngclient_details = array(
	'key'                   => 'group_27337B3C3DC74',
	'title'                 => 'Kunde',
	'fields'                => array(
	),
	'location'              => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'cnpclient',
			)
		)
	),
	'menu_order'            => 0,
	'position'              => 'normal',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen'        => array(
		0  => 'permalink',
		1  => 'the_content',
		2  => 'excerpt',
		3  => 'custom_fields',
		4  => 'discussion',
		5  => 'comments',
		6  => 'revisions',
		7  => 'slug',
		8  => 'author',
		9  => 'format',
		10 => 'page_attributes',
		11 => 'featured_image',
		12 => 'categories',
		13 => 'tags',
		14 => 'send-trackbacks',
	)
);

acf_add_local_field_group( $group_cpt_cngclient_details );

// Fields for Custom Post Type "cngitem"

