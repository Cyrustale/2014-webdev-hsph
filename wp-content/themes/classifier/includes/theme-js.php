<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'colabsthemes_add_javascript' );

if (!function_exists('colabsthemes_add_javascript')) {

	function colabsthemes_add_javascript () {
		
    wp_enqueue_script('jquery'); //https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js
        
    // needed for single ad sidebar email & comments on pages, edit ad & profile pages, ads, blog posts
    if ( is_singular() )
      wp_enqueue_script('validate', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.validate.min.js', array('jquery'), '1.8.1');
        
		wp_enqueue_script( 'colabs_plugins', trailingslashit( get_template_directory_uri() ) . 'includes/js/plugins.js', array('jquery') );
        
    wp_enqueue_script( 'colabs_scripts', trailingslashit( get_template_directory_uri() ) . 'includes/js/scripts.js', array('jquery') );

		/* We add some JavaScript to pages with the comment form to support sites with threaded comments (when in use). */        
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
					
		$colabs_gmaps_lang = esc_attr( get_option('colabs_gmaps_lang') );
	  $colabs_gmaps_region = esc_attr( get_option('colabs_gmaps_region') );
    wp_enqueue_script('google-maps', "http://maps.google.com/maps/api/js?sensor=false&amp;language=$colabs_gmaps_lang&amp;region=$colabs_gmaps_region", array('jquery'), '3.0');			
        
	} /* // End colabsthemes_add_javascript() */
	
} /* // End IF Statement */
?>