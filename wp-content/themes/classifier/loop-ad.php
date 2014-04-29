<?php if (have_posts()) : $count = 0; ?>
    <header class="entry-header">
        <h2><?php _e( 'All Listings', 'colabsthemes' );?></h2>
    </header>
    <div class="tab-panel">
<?php while (have_posts()) : the_post(); $count++; ?>
    <!-- Post Starts -->
    <div <?php post_class('post-block'); ?>>
        <?php colabs_post_inside_before(); ?>
        <figure class="post-image">
        <?php colabs_image('width=239&height=143&size=thumbnail'); ?>
				<?php $colabs_price = get_post_meta($post->ID, 'colabs_price', true); ?>
                <span class="price"><?php if ( !empty($colabs_price) ) colabs_get_price_legacy($post->ID); else colabs_get_price($post->ID, 'colabs_price'); ?></span>
        </figure>
        <header class="post-title">
        <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
        </header>
        <div class="post-content">
            <?php global $more; $more = 0; ?>
            <p><?php echo get_the_excerpt(); ?></p>
            <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>"><?php _e('Read More','colabsthemes'); ?></a>
        </div>
        <?php colabs_post_meta(); ?>
    </div><!-- /.post -->
<?php endwhile; ?>
    </div><!-- /.tab-panel -->
<?php else: ?>
    <div class="post-block">
        <p><?php _e('Sorry, no posts matched your criteria.', 'colabsthemes') ?></p>
    </div><!-- /.post -->
<?php endif; ?>  
 