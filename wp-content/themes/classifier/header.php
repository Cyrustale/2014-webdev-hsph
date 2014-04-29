<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 ie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <title><?php colabs_title(); ?></title>

<?php 
  if ( function_exists( 'colabs_meta') ) colabs_meta();
  if ( function_exists( 'colabs_meta_head') )colabs_meta_head(); 
    global $colabs_options;    
?>
  
  <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/includes/js/html5shiv.js"></script>
  <![endif]-->
  
  <!-- CSS -->
  <link href="http://fonts.googleapis.com/css?family=Lato:400,700|Armata" rel="stylesheet" type="text/css">
  <link href="<?php bloginfo('template_url'); ?>/includes/css/colabs-css.css" rel="stylesheet" type="text/css" />
  <link href="<?php bloginfo('template_url'); ?>/includes/css/plugins.css" rel="stylesheet" type="text/css" />
  <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />

<?php 
    if ( function_exists( 'colabs_head') ) colabs_head();
    wp_head(); 
  $site_title = get_bloginfo( 'name' );
  $site_url = home_url( '/' );
  $site_description = get_bloginfo( 'description' ); 
?>
  <?php if(get_option('colabs_disable_mobile')=='false') : ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <?php endif; ?>
  
  <script type="text/javascript">
    if( typeof jQuery.validator !== "undefined" ) {
      jQuery.validator.message = {
        required: '<?php _e("This field is required.", "colabsthemes");?>',
        remote: '<?php _e("Please fix this field.", "colabsthemes");?>',
        email: '<?php _e("Please enter a valid email address.", "colabsthemes");?>',
        url: '<?php _e("Please enter a valid URL.", "colabsthemes");?>',
        date: '<?php _e("Please enter a valid date.", "colabsthemes");?>',
        dateISO: '<?php _e("Please enter a valid date (ISO).", "colabsthemes");?>',
        number: '<?php _e("Please enter a valid number.", "colabsthemes");?>',
        digits: '<?php _e("Please enter only digits.", "colabsthemes");?>',
        creditcard: '<?php _e("Please enter a valid credit card number.", "colabsthemes");?>',
        equalTo: '<?php _e("Please enter the same value again.", "colabsthemes");?>',
        maxlength: jQuery.validator.format("<?php _e('Please enter no more than {0} characters.','colabsthemes');?>"),
        minlength: jQuery.validator.format("<?php _e('Please enter at least {0} characters.','colabsthemes');?>"),
        rangelength: jQuery.validator.format("<?php _e('Please enter a value between {0} and {1} characters long.','colabsthemes');?>"),
        range: jQuery.validator.format("<?php _e('Please enter a value between {0} and {1}.','colabsthemes');?>"),
        max: jQuery.validator.format("<?php _e('Please enter a value less than or equal to {0}.','colabsthemes');?>"),
        min: jQuery.validator.format("<?php _e('Please enter a value greater than or equal to {0}.','colabsthemes');?>")
      };
    }
  </script>
<?php colabs_custom_styling(); ?>


<script type="text/javascript">
 
  /* Replace #your_subdomain# by the subdomain of a Site in your OneAll account */    
  var oneall_subdomain = 'wspi-hotsale';
 
  /* The library is loaded asynchronously */
  var oa = document.createElement('script');
  oa.type = 'text/javascript'; oa.async = true;
  oa.src = '//' + oneall_subdomain + '.api.oneall.com/socialize/library.js';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(oa, s);
       
</script>


</head>
<body <?php body_class(); ?>>

<?php colabs_header_before(); ?>

<section class="container section-header">
  <div style="margin-left:4%;" class="row">

    <header class="logo col4">
    <?php
      if (get_option('colabs_logotitle')=='logo'){
      if ( isset($colabs_options['colabs_logo']) && $colabs_options['colabs_logo'] ) {
        echo '<div id="logo"><a href="' . $site_url . '" title="' . $site_description . '"><img src="' . $colabs_options['colabs_logo'] . '" alt="' . $site_title . '" /></a></div>';
      } 
      }else {
        echo '<h1><a href="' . $site_url . '">' . $site_title . '</a></h1>';
      } // End IF Statement
      ?>    
      <hgroup class="tagline">
        <?php
      if ( $site_description ) { echo '<h3>' . $site_description . '</h3>'; }
    ?>      
      </hgroup>
    </header>
    <!-- /.logo -->

    <form action="<?php bloginfo('url'); ?>" method="get" id="searchform" class="form_search advance-search col8">
      <div class="column col10">
        <p class="search-what column col4" style="margin-left:-15px;">
          <input name="s" type="text"  <?php if(get_search_query()) { echo 'value="'.trim(strip_tags(esc_attr(get_search_query()))).'"'; } else { ?> value="<?php _e('What are you looking for?','colabsthemes'); ?>" onfocus="if (this.value == '<?php _e('What are you looking for?','colabsthemes'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('What are you looking for?','colabsthemes'); ?>';}" <?php } ?>>
        </p>
        <p class="search-categories column col4" style="margin-left:10px;" >
          <?php wp_dropdown_categories('show_option_all='.__('All Categories', 'colabsthemes').'&title_li=&use_desc_for_title=1&tab_index=2&name=scat&selected='.colabs_get_search_catid().'&class=custom-select&taxonomy='.COLABS_TAX_CAT.'&echo=false');
          ?>
        </p>
        <p class="search-where column col4" style="margin-left:10px;">
          <?php 
            if( isset( $_GET['sloc'] ) ) {
              $current_location = get_term_by( 'slug', $_GET['sloc'], 'ad_location' )->term_id;
            } else {
              $current_location = 0;
            }
            colabs_dropdown_location('show_option_all='.__('All Location', 'colabsthemes').'&title_li=&use_desc_for_title=1&name=sloc&selected=&class=custom-select&selected='. $current_location .'&taxonomy='.COLABS_TAX_LOC.'&echo=false'); ?>
        </p>
      </div>

      <div class="column col2">
        <p class="search-button">
          <input type="submit"  id="go" value="<?php _e('Search','colabsthemes'); ?>">
        </p>
      </div>
      
      <input type="hidden" name="action" value="advance_search">
    </form>


    <div style="width:240px; height:26px; float:right; margin-top:-25px; margin-right:25px;">
    <style>
      ul.social-kline {

      }
      ul.social-kline li {
        display:inline;
      }
    </style>
      <ul class="social-kline">
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/facebook.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/twitter.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/google-plus.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/reddit.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/pinterest.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/linkedin.png" style="width:24px;height:24px;"></a></li>
        <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/social-media/email.png" style="width:24px;height:24px;"></a></li>
      </ul>
    <!-- .advance-search -->

    </div>
  </div>
</section>
<!-- /.section-header -->

<div class="container main-nav">
  <div class="row">
    <a class="btn-navbar collapsed">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="nav-collapse collapse">
      <?php 
      $arr = array(
          'theme_location' => 'main-menu',
          'container' => 'div',
          'container_class' => 'main-menu',
      );
      wp_nav_menu($arr); ?>
      <?php if ( !is_user_logged_in() ) : ?>
      <a href="http://hotsale.ph/wp-login.php?action=register" class="btn btn-primary" style="float:right;margin-top:10px;">Post Free Ad</a>
      <a href="http://hotsale.ph/wp-login.php" class="btn btn-primary" style="float:right;margin-top:10px;margin-right:10px;">Login</a>
      <?php else: echo ""; endif; ?>
    </div>
  </div>
</div>
<!-- /.main-nav -->

<?php //get_template_part('content', 'advance-search'); ?>



<div class="container">  
<div style="height:25px;width:100%"></div>