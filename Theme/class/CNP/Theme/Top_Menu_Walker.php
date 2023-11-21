<?php

namespace CNP\Theme;


class Top_Menu_Walker extends \Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			$output .= '<ul class="dropdown-menu dropdown-menu-left">';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			$output .= '</ul>';
		}
	}

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

		if ( $depth == 0 ) {
			if ( $item->hasChildren ) {
				$output .= sprintf( '<li class="dropdown %s"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">%s</a>',$class_names, $item->title );
			} else {
				$output .= sprintf( '<li class="%s"><a href="%s" title="%s">%s</a>', $class_names, $item->url, $linktitle, $item->title );
			}
		}
		if ( $depth == 1 ) {
			$output .= sprintf( '<li class="%s"><a href="%s" title="%s">%s</a>', $class_names, $item->url, $linktitle, $item->title );
		}
	}

	public function end_el( &$output, $object, $depth = 0, $args = array() ) {
		if ( $depth == 0 ) {
			$output .= sprintf( '</li>' );
		}
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		$element->hasChildren = isset( $children_elements[ $element->ID ] ) && ! empty( $children_elements[ $element->ID ] );

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}