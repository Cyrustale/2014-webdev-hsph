<?php get_header(); ?>

<script type='text/javascript'>
// <![CDATA[
/* setup the form validation */
jQuery(document).ready(function ($) {
		$('#mainform').validate({
				errorClass: 'invalid'
		});
});
// ]]>
</script>

	<div class="row">
		<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
	</div>

	<div class="row main-container">

		<div class="main-content col9">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class('entry'); ?>>
			
				<?php colabsthemes_before_post_content(); ?>
		<?php colabs_stats_update( $post->ID ); //records the page hit ?>
				<header class="entry-header">
					<h2><?php the_title(); ?></h2>
					<span class="price-tag"><?php if ( get_post_meta($post->ID, 'colabs_price', true) ) colabs_get_price_legacy($post->ID); else colabs_get_price($post->ID, 'colabs_price'); ?></span>
			
				</header>

				<div class="entry-images">
					<div class="entry-slides">
						<?php 
						$custom_field = 'colabs_discount';
						$listing_discount = get_post_meta($post->ID,$custom_field,true);

						// If ads is on sale
						if( !empty($listing_discount) ) : ?>
							<div class="sale-price"> <?php echo $listing_discount; ?>% <strong><?php _e('Sale','colabsthemes'); ?></strong>
							</div>
						<?php endif; ?>

						<?php colabs_image('width=724&height=478&size=single-ad&link=img'); ?>
					</div><!-- .entry-slides -->

					<div class="entry-thumbs clearfix">
						<?php 
						$gallery_thumb = get_posts(  array(
							'post_type'			=>	'attachment',
							'posts_per_page'=> -1,
							'post_parent'		=>	$post->ID )
						); 

						if( $gallery_thumb && count($gallery_thumb) > 1 ) {
							foreach( $gallery_thumb as $thumb ) {
								$thumb_src = wp_get_attachment_image_src( $thumb->ID, 'full' );
								echo '<a href="'.$thumb_src[0].'" >';
								echo colabs_image('link=img&width=75&height=75&src='.$thumb_src[0]);
								echo '</a>';
							}
						} ?>
					</div>
					
				</div><!-- .entry-images -->

				<div class="entry-content">

						<?php the_content(); ?>
						
				</div>
				<!-- /.entry-content -->

				<?php colabsthemes_after_post_content(); ?>

			</article>
		<?php endwhile;endif;?>
			<!-- /.entry -->
				
				<?php comments_template( '/comments-ad.php' ); ?>

		</div>
		<!-- .main-content -->

		<?php get_sidebar('ad'); ?>

	</div>
	<!-- /.main-container -->

<?php get_footer(); ?>