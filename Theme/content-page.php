<?php

if ( have_rows( 'pagecontent' ) ):
	while ( have_rows( 'pagecontent' ) ):the_row();
		switch ( get_row_layout() ) {
			case 'clientList':
				\CTWP\Theme\TemplateManager::IncludeTemplate( 'clientList' );
				break;
			case 'headline':
				\CTWP\Theme\TemplateManager::IncludeTemplate( 'headline' );
				break;
			case 'twoColImgText':
				\CTWP\Theme\TemplateManager::IncludeTemplate('twoColImgText');
				break;
		}
	endwhile;
endif;
