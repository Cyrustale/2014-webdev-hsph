<!-- Post Starts -->
<div <?php post_class('post-block'); ?>>

	<?php colabs_post_inside_before(); ?>
				
		<figure class="post-image">
		<?php colabs_image('width=239&height=143&size=thumbnail'); ?> 
		</figure>
				
		<header class="post-title">
			<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
		</header>

		<div class="post-content">
			<?php global $more; $more = 0; ?>
			
			<?php 
		$status = get_option ( "colabs_excerptColumn" );		
		if ( $status != "no" ) {
			if(has_post_format( 'chat' ) || has_post_format( 'quote' ))
				the_content();
			elseif(has_post_format( 'audio' )){
				$attr = array(	'no' => $post->ID,
								'file' => get_post_meta($post->ID,'colabs_audio_url',true));
				$content = wp_audio_player($attr);
				echo $content;	
			}else{ 
			the_excerpt();
			?>
			<a href="<?php the_permalink() ?>" title="<?php _e('Read More','colabsthemes'); ?>"><?php _e('Read More','colabsthemes'); ?></a>
			<?php
			}
		} ?>
			
		
			
		</div>
				
	<?php colabs_post_meta(); ?>
				
</div><!-- /.post -->
												
