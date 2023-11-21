<?php

namespace CNP\Theme;

class Footer_Menu_Walker extends \Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$linktitle = $item->title;
		if(strlen($item->attr_title) >= 1) {
			$linktitle = $item->attr_title;
		}
		$output .= sprintf('  //  <a href="%s" title="%s">%s</a>', $item->url, $linktitle, $item->title);
	}

}