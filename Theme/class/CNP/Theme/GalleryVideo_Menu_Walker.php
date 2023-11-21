<?php

namespace CNP\Theme;


class GalleryVideo_Menu_Walker extends \Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$class_names = in_array( "current_page_item", $item->classes ) ? ' active' : '';
		$class_names .= ( $item->current_item_parent ) ? ' active' : '';

		foreach ( $item->classes as $cls ) {
			$class_names .= " " . $cls;
		}

		$linktitle = $item->title;
		if ( strlen( $item->attr_title ) >= 1 ) {
			$linktitle = $item->attr_title;
		}

		$output .= sprintf( '<li><a class="filter" href="#" onclick="cng_navigate(\'video\', \'%s\')">%s</a></li>', $item->object_id, $item->title );
	}


	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		$element->hasChildren = isset( $children_elements[ $element->ID ] ) && ! empty( $children_elements[ $element->ID ] );

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}