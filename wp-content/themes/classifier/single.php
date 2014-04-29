<?php get_header(); ?>
<div class="row">
<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
</div>
<!-- #Main Starts -->
<?php colabs_main_before(); ?>
    <div class="row main-container">

        <div class="main-content <?php if(get_post_meta($post->ID,'layout',true)=='one-col'){echo 'col12';}else{?>col9<?php }?>">

            <!-- #Content Starts -->
            <?php colabs_content_before(); ?>
            
            <header class="entry-header">
			  <h2><?php the_title(); ?></h2>
			</header>
			
			<?php while (have_posts()) : the_post();?>
			<div <?php post_class(); ?>>
				<?php colabs_post_inside_before(); ?>
				
				<div class="entry-meta meta-detail">
					<?php _e('Posted by','colabsthemes');?> <?php the_author_posts_link(); ?> &bull; 
					<?php the_time(get_option( 'date_format' ));?> &bull; 
					<?php the_category(', ');?> &bull; 
					<a href="<?php comments_link(); ?>" title=""><?php comments_number( __('Add Comment','colabsthemes'), __('1 Comment','colabsthemes'), __('% Comments','colabsthemes') ); ?></a>
					<?php edit_post_link('Edit', '&bull; ', ''); ?>
				</div><!-- .entry-meta -->
				
				<?php   
				$single_top = get_post_custom_values("colabs_single_top");
				if (($single_top[0]!='')||($single_top[0]=='none')){
					?>
					<div class="entry-images">					
						<?php 
						if ($single_top[0]=='single_video'){
							$embed = colabs_get_embed('colabs_embed',725,355,'single_video',$post->ID);
							if ($embed!=''){
								echo $embed; 
							}
						}elseif($single_top[0]=='single_image'){
							colabs_image('width=725');				
						}										
						?>
					</div>					
				<?php }?>
				

				<div class="entry-content">

						<?php
					if ( has_post_format( 'audio' )){
						$attr = array(
								'no' => $post->ID,
								'file' => get_post_meta($post->ID,'colabs_audio_url',true)
								);
						$content = wp_audio_player($attr);
						echo $content;	
					}else if ( has_post_format( 'gallery' )){
						echo do_shortcode('[gallery size="medium"]');	
						//the_content();	
					}else if ( has_post_format( 'quote' )){	
					the_content();
					if(get_post_meta($post->ID,'colabs_quote_author',true)!='')echo '<p class="quote-author">'.get_post_meta($post->ID,'colabs_quote_author',true).'</p>';
					}else{
						the_content();	 
					}
					?>
					
				</div>
				<!-- /.entry-content -->
				
				<div class="entry-author">
                        <span class="profile-image"><?php $email = get_the_author_meta('user_email'); ?>
						<?php echo get_avatar( $email, $size = '55'); ?></span>
                        <div class="profile-content author-detail">
                            <h3><?php _e('About','colabsthemes');?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><? the_author_meta('display_name'); ?></a></h3>
                            <p><?php the_author_meta( 'description' ); ?></p>
                        </div>
                </div>
				
				<?php echo colabs_share(); ?>
				<?php if( !has_post_format('gallery') ) {
					wp_link_pages(array('before' => __('<p><strong>Pages:</strong>','colabsthemes'), 'after' => '</p>', 'next_or_number' => 'number')); 
				} ?>
            </div>
			<?php endwhile;?>
			
            <?php colabs_content_after(); ?>
            
			<?php comments_template( '', true ); ?><!-- #comments -->
        </div><!-- /.main-content -->  
		
		<?php if(get_post_meta($post->ID,'layout',true)!='one-col'){get_sidebar('page');} ?>
		
    </div><!-- /.main-container -->
	
<?php colabs_main_after(); ?>
  
<?php get_footer(); ?>