<div class="sidebar col3">
<?php if(is_singular()){ ?>
			
      <div class="listing-info listing-details">
        <h4><?php _e('Listing Details', 'colabsthemes') ?></h4>
        <ul>
            <?php
            global $post;
            // grab the category id for the functions below
            $cat_id = colabsthemes_get_custom_taxonomy( $post->ID, COLABS_TAX_CAT, 'term_id' );
            // check to see if ad is legacy or not
            if ( get_post_meta( $post->ID, 'expires', true ) ) {  ?>
                <li><strong><?php _e('Listed', 'colabsthemes') ?>:&nbsp;</strong><?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ?></li>
                <li><strong><?php _e('Expires', 'colabsthemes') ?>:&nbsp;</strong><?php echo colabs_timeleft( strtotime( get_post_meta( $post->ID, 'expires', true ) ) ); ?></li>
                <?php colabs_get_ad_details( $post->ID, $cat_id );?>
            <?php
            } else {
                if ( get_post_meta($post->ID, 'colabs_ad_sold', true) == 'true' ) : ?>
                    <li id="colabs_sold"><strong><?php _e('This item has been sold', 'colabsthemes'); ?></strong></li>
                <?php endif; ?>
                <li id="colabs_listed"><strong><?php _e('Listed', 'colabsthemes') ?>:&nbsp;</strong><?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ?></li>
                <?php if ( get_post_meta($post->ID, 'colabs_sys_expire_date', true) ){ ?>
                  <li id="colabs_expires"><strong><?php _e( 'Expires', 'colabsthemes' ) ?>:&nbsp;</strong><?php echo colabs_timeleft( strtotime( get_post_meta( $post->ID, 'colabs_sys_expire_date', true) ) ); ?></li>
								<?php } ?>
								<?php colabs_get_ad_details( $post->ID, $cat_id );?>
								<li><strong><?php _e('Member Since','colabsthemes');?>:&nbsp;</strong><?php echo date_i18n( get_option('date_format'), strtotime( get_the_author_meta('user_registered') ) ); ?></li>
								
            <?php
            } // end legacy check
            ?>        
            <li><strong><?php _e('Author','colabsthemes');?>:&nbsp;</strong><?php echo colabsthemes_make_clickable( get_the_author_meta('user_url') ); ?></li>
            <?php if(get_the_author_meta('twitter_id')!=''){?>
						<li><strong><?php _e('Twitter','colabsthemes');?>:&nbsp;</strong><a href="http://twitter.com/<?php echo get_the_author_meta('twitter_id'); ?>"><?php echo get_the_author_meta('twitter_id'); ?></a></li>
						<?php
						}
						if(get_the_author_meta('facebook_id')!=''){
						?>
						<li><strong><?php _e('Facebook','colabsthemes');?>:&nbsp;</strong><a href="http://facebook.com/<?php echo get_the_author_meta('facebook_id'); ?>"><?php echo get_the_author_meta('facebook_id'); ?></a></li>
						<?php }?>
				</ul>
        <p><strong><?php _e('More Listing by','colabsthemes');?> <a href="#"><?php the_author_meta('display_name'); ?></a></strong></p>
        <ul class="users-listing">
    		<?php $wp_query = new WP_Query( array( 'posts_per_page' => 5, 'post_type' => COLABS_POST_TYPE, 'post_status' => 'publish', 'author' => get_the_author_meta('ID'), 'orderby' => 'rand', 'post__not_in' => array( $post->ID ) ) ); ?>
    		<?php if ( have_posts() ) : ?>
    			<?php while ( have_posts() ) : the_post() ?>
    				<li>
    					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    				</li>
    			<?php endwhile; ?>
    		<?php else: ?>
    			<li><?php _e('No other ads by this poster found.','colabsthemes'); ?></li>
    		<?php endif; wp_reset_postdata(); ?>
        </ul>
        <!-- /.users-listing -->
      </div>
      <!-- /.listing-details -->
			      
      <?php include_once(get_template_directory() . '/includes/sidebar-map.php'); ?>
			
			<div class="listing-info listing-details">
        <h4><?php _e('Contact','colabsthemes'); ?></h4>
        <p class="contact_msg"><?php _e('To inquire about this ad listing, complete the form below to send a message to the ad poster.', 'colabsthemes') ?></p>
            <?php include_once(get_template_directory() . '/includes/sidebar-contact.php'); ?>
			</div>
    <!-- /.listing-details -->
<?php } ?>
	<?php if (colabs_active_sidebar('sidebar_ad')) : ?>
		<?php colabs_sidebar('sidebar_ad'); ?>		           
	<?php endif; ?>
</div>
<!-- .sidebar -->