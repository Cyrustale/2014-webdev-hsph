<?php
/*
Template Name: Right Sidebar
*/
?>
<?php get_header(); ?>

	<div class="row">
		<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
	</div>

  <div class="row main-container rightsidebar">

    <div class="main-content col9">
      <article class="entry">       
        <header class="entry-header">
          <h2><?php the_title(); ?></h2>
        </header>

        <div class="entry-images">
          <div class="entry-slides">
            <?php colabs_image(); ?>
          </div>
        </div>

        <div class="entry-content">

            <?php the_content(); ?>
            
        </div>
        <!-- /.entry-content -->

      </article>
      <!-- /.post -->
    </div>
    <!-- .main-content -->

    <?php get_sidebar('page'); ?>

  </div>
  <!-- /.main-container -->

<?php get_footer(); ?>
