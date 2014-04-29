<?php
/*---------------------------------------------------------------------------------*/
/* Latest Custom Type widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Latest_Ads extends WP_Widget {
   function CoLabs_Latest_Ads() {
	   $widget_ops = array('description' => 'Add your latest Ads for the sidebar with this widget.' );
       parent::WP_Widget(false, __('ColorLabs - Latest Ads', 'colabsthemes'),$widget_ops);      
   }
   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
	$number = $instance['number'];
	if($number=='')$number=4;
    echo $before_widget;
    if ($title) { echo $before_title . $title . $after_title; }else { echo $before_title .__('Latest Ads','colabsthemes'). $after_title;}
		$wp_query = new WP_Query( array(
						'showposts' => $number,
						'post_type' => 'ad',
					));
        $count = 0;
        if ( $wp_query->have_posts() ) : ?>
        <style>

        table#kline-table a:link {
          color: #666;
          font-weight: bold;
          text-decoration:none;
        }
        table#kline-table a:visited {
          color: #999999;
          font-weight:bold;
          text-decoration:none;
        }
        table#kline-table a:active,
        table#kline-table a:hover {
          color: #bd5a35;
          text-decoration:underline;
          cursor:pointer;
        }
        table#kline-table {
          font-family:Arial, Helvetica, sans-serif;
          color:#666;
          font-size:12px;
          text-shadow: 1px 1px 0px #fff;
          background:#eaebec;
          margin:20px;
          border:#ccc 1px solid;
          margin-top:-25px;

          -moz-border-radius:3px;
          -webkit-border-radius:3px;
          border-radius:3px;

          -moz-box-shadow: 0 1px 2px #d1d1d1;
          -webkit-box-shadow: 0 1px 2px #d1d1d1;
          box-shadow: 0 1px 2px #d1d1d1;
          width:215px;
          margin-left:10px;
        }
        table#kline-table th {
          padding:21px 25px 22px 25px;
          border-top:1px solid #e0e0e0;
          border-bottom:1px solid #e0e0e0;

          background: #ededed;
          background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
          background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
        }
        table#kline-table th:first-child {
          text-align: left;
          padding-left:20px;
        }
        table#kline-table tr:first-child th:first-child {
          -moz-border-radius-topleft:3px;
          -webkit-border-top-left-radius:3px;
          border-top-left-radius:3px;
        }
        table#kline-table tr:first-child th:last-child {
          -moz-border-radius-topright:3px;
          -webkit-border-top-right-radius:3px;
          border-top-right-radius:3px;
        }
        table#kline-table tr {
          padding-left:20px;
        }
        table#kline-table td:first-child {
          text-align: left;
          padding-left:20px;
          border-left: 0;
        }
        table#kline-table td {
          padding:10px;
          border-bottom:1px solid #e0e0e0;
          border-bottom:1px solid #e0e0e0;
          border-left: 1px solid #e0e0e0;
          
          background: #fafafa;
          background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
          background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
        }
        table#kline-table tr.even td {
          background-color: #f6f6f6;
          background-color: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
          background-color: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
        }
        table#kline-table tr:last-child td {
          border-bottom:0;
        }
        table#kline-table tr:last-child td:first-child {
          -moz-border-radius-bottomleft:3px;
          -webkit-border-bottom-left-radius:3px;
          border-bottom-left-radius:3px;
        }
        table#kline-table tr:last-child td:last-child {
          -moz-border-radius-bottomright:3px;
          -webkit-border-bottom-right-radius:3px;
          border-bottom-right-radius:3px;
        }
        table#kline-table tr:hover td {
          background-color: #f2f2f2;
          background-color: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
          background-color: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);  
          background-image:url('<?php echo get_template_directory_uri(); ?>/images/hotsale-logo.png');
          background-repeat:no-repeat;
          background-position:center bottom;
          cursor:pointer;
        }
        h4.item-name {
          font-size:13px;
          margin-top:-18px;
        }

        .colabs-image.item-images {
          border-top-left-radius: 5px;
          border-top-right-radius: 5px;
          -webkit-border-top-left-radius: 5px;
          -moz-border-top-right-radius: 5px;
          border-bottom: solid 2px #ab0000;
        }

        img.colabs-image:hover {
          -webkit-box-shadow: 0px 0px 20px rgba(50, 50, 50, 1);
          -moz-box-shadow:    0px 0px 20px rgba(50, 50, 50, 1);
          box-shadow:         0px 0px 20px rgba(50, 50, 50, 1);
          cursor:pointer;
        }

        .latest-ads-kline {
          background:url("<?php echo get_template_directory_uri(); ?>/images/latest-ads.png");
          width:49px;
          height:50px;
          z-index: 99999 !important;
          margin-top: -6px;
          float: right;
          margin-right: 6px;
        }
        </style>

        <table id="kline-table">
          <thead>
          <tr>
            <th>Item</th>
          </tr>
        </thead>
        <tbody>
    		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); $count++; global $post; ?>
    		<tr class="even">
        <td>
            <?php colabs_image('width=173&height=80&class=item-images'); ?>
          <div class="latest-ads-kline"></div>
        <br/><br/>
                <h4 class="item-name"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                <span class="price"><?php if ( get_post_meta($post->ID, 'colabs_price', true) ) colabs_get_price_legacy($post->ID); else colabs_get_price($post->ID, 'colabs_price'); ?></span>
        </td>
        </tr>
    		<?php 
    		endwhile;?>
        <td colspan="2"><a href="<?php echo get_post_type_archive_link( 'ad' ); ?>" class="more-link"><?php _e('View All','colabsthemes'); ?></a></td>
        </tbody>
        </table>

        <?php endif;
        echo $after_widget;
   }
   function update($new_instance, $old_instance) {                
       return $new_instance;
   }
   function form($instance) {        
       $title = esc_attr($instance['title']);
	   $number = esc_attr($instance['number']);
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
	    <p>
	   	   <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('number'); ?>"  value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
       </p>
      <?php
   }
} 
register_widget('CoLabs_Latest_Ads');
?>