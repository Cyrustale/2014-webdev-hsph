<div class="sidebar col3">

    <?php if ( is_home() ) { 

        $current_user = wp_get_current_user();
        $display_user_name = $current_user->display_name;
        
        ?>
        
      <div class="widget widget_welcome">

          <?php if ( !is_user_logged_in() ) : ?>

          <?php else: ?>
              <h4 class="widget-title"><?php _e('Your Profile', 'colabsthemes');?></h4>
              <div class="avatar"><?php colabsthemes_get_profile_pic( $current_user->ID, $current_user->user_email, 60 ) ?></div>

              <div class="user">

                  <p class="welcome-back"><?php _e('Welcome back,','colabsthemes'); ?> <a href="<?php echo get_author_posts_url($current_user->ID); ?>"><strong><?php echo $display_user_name; ?></strong></a></p>
                  <p class="last-login"><?php _e('You last logged in at:','colabsthemes'); ?> <?php echo colabsthemes_get_last_login($current_user->ID); ?></p>
	             </div><!-- /user -->
               <p>
                  <a href="<?php echo COLABS_DASHBOARD_URL ?>" class="btn btn-primary"><?php _e('Manage Ads', 'colabsthemes') ?></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo COLABS_PROFILE_URL ?>" class="btn btn-primary"><?php _e('Edit Profile', 'colabsthemes') ?></a>
                </p>

	    <?php endif; ?>

      </div><!-- /.widget_welcome -->


    <?php } // is_home ?>

	<?php if (colabs_active_sidebar('sidebar')) : ?>

		<?php colabs_sidebar('sidebar'); ?>		           

	<?php endif; ?>

</div>
<!-- .sidebar -->