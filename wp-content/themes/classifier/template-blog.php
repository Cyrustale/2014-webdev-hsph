<?php
/**
 * Template Name: Blog
 *
 * The Blog page template displays your posts with a "Blog"-style
 *
 * @package CoLabsFramework
 * @subpackage Template
 */

get_header();
?>

	<div class="row">
		<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
	</div>

    <!-- #content Starts -->
	<?php colabs_main_before(); ?>
    <div class="row main-container">

        <div class="main-content col9">

            <!-- #main Starts -->
            <?php colabs_content_before(); ?>
            
            <?php get_template_part('loop'); ?>
                
            <?php colabs_content_after(); ?>
			
			<?php colabs_pagination(); ?>
            
        </div><!-- /.main-content -->  
		
		<?php get_sidebar(); ?>
		
    </div><!-- /.main-container -->
	<?php colabs_main_after(); ?>

<?php get_footer(); ?>
