<?php get_header(); ?>

  

  <div class="row main-container">

    <div class="main-content col9">
	<?php //added joel ?>		
		<section class="container section-featured">
		
			  <div class="row">

				<?php get_template_part('includes/featured','main'); ?>

				<?php 
			   /* $arr = array(
					'theme_location' => 'secondary-menu',
					'container' => 'div',
					'container_class' => 'category-listing',
					'fallback_cb' => 'secondarymenu',
				);
				wp_nav_menu($arr);*/ ?>

			  </div>
			</section>
		
<?php //added joel ?>	

      <div class="content-tab">

        <ul class="tab-nav">

          <li><a href="#ad-categories"><?php _e('Ad Categories','colabsthemes'); ?></a></li>

          <?php colabs_cat_tab_list(); ?>

        </ul>

        <!-- .tab-nav -->

        <div class="tab-panel" id="ad-categories">

            <?php echo colabs_cat_menu_drop_down( get_option('colabs_dir_sub_num') ); ?>

        </div>

        <!-- /#ad-categories -->

        <?php colabs_cat_tab_content(); ?>
	
      </div>

      <!-- /.content-tab -->

  
    <!-- .content-tab -->    

    </div>

    <!-- .main-content -->

    <?php get_sidebar(); ?>

  </div>

  <!-- /.main-container -->
  <?php if( is_home() ){ ?>


<!-- /.section-featured -->
<?php } wp_reset_postdata(); ?>
<?php get_template_part('includes/featured','list'); ?>
<?php get_footer(); ?>