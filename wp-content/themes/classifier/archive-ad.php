<?php get_header(); global $colabs_options; ?>
<div class="row">
	<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
</div>

<div class="row main-container">

		<div class="main-content col9">

        <div class="content-tab">
            
            <?php get_template_part('loop','ad'); ?>
            
			<?php colabs_pagination(); ?>
        
        </div><!-- /.content-tab -->
               
		</div><!-- /.main-content -->
		<?php get_sidebar();?>
</div><!-- /.main-container -->
		
<?php get_footer(); ?>