<?php



/*---------------------------------------------------------------------------------*/

/* Loads all the .php files found in /includes/widgets/ directory */

/*---------------------------------------------------------------------------------*/



include( get_template_directory() . '/includes/widgets/widget-colabs-tabs.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-ad-sidebar.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-embed.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-flickr.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-search.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-twitter.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-latest-ads.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-latest-blog.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-list-taxonomy.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-googlemaps.php' );

include( get_template_directory() . '/includes/widgets/widget-colabs-featured-ad.php' );



/*---------------------------------------------------------------------------------*/

/* Deregister Default Widgets */

/*---------------------------------------------------------------------------------*/

if (!function_exists('colabs_deregister_widgets')) {

	function colabs_deregister_widgets(){

	    unregister_widget('WP_Widget_Search');         

	}

}

add_action('widgets_init', 'colabs_deregister_widgets');  



?>