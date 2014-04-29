<?php
/*
Template Name: Membership Confirm
*/

// if not logged in, redirect to login page
auth_redirect_login();

//otherwise load step functions file with functions required to process the order
include_once (get_template_directory() . '/includes/forms/step-functions.php');

global $wpdb, $current_user;
$order = get_user_orders($current_user->ID, $_REQUEST['oid']);

//if the order was found by OID, setup the order details into the $order variable
if(isset($order) && $order) $order = get_option($order);
//make sure the order sent from payment gateway is logged in the database and that the current user created it
if(isset($order['order_id']) && $order['order_id'] == $_REQUEST['oid'] && $order['user_id'] == $current_user->ID) {
	$order_processed = colabsthemes_process_membership_order($current_user, $order);
	
} else {
	$order_processed = false;
	// check and make sure this transaction hasn't already been added
    $sql = "SELECT * "
         . "FROM " . $wpdb->prefix . "colabs_order_info "
         . "WHERE custom = '".$wpdb->escape(colabsthemes_clean($_REQUEST['oid']))."' LIMIT 1";
    $results = $wpdb->get_row($sql);
	if($results) $order_processed = 'IPN';
}
?>
<?php get_header(); ?>
<div class="row">
	<?php colabs_breadcrumbs(array('before'=>'','after')); ?>
</div>

<!-- #Main Starts -->

<div class="row main-container">
  <div class="main-content col9">
	<?php colabs_main_before(); ?>
    <header class="entry-header">
			  <h2><?php the_title(); ?></h2>
		</header>
		<div <?php post_class(); ?>>
			<div class="entry-content">
      <div id="step3"></div>
			<?php
        if($order_processed == 'IPN') { 
			?>
        <h2 class="dotted"><?php _e('Thank You!','colabsthemes'); ?></h2>
        <div class="thankyou">
          <h3><?php _e('Your payment has been processed and your membership status should now be active.','colabsthemes'); ?></h3>
          <p><?php echo sprintf(__('Visit your <a href="%1$s">dashboard</a> to review your membership status details.','colabsthemes'), COLABS_DASHBOARD_URL); ?></p>
				</div>
      <?php
				}elseif($order_processed) { 
		      if (file_exists(get_template_directory() . '/includes/gateways/process.php'))
		        include_once (get_template_directory() . '/includes/gateways/process.php');
						
			?>
          <h2><?php _e('Thank You!','colabsthemes'); ?></h2>
          <div class="thankyou">
            <h3><?php _e('Your payment has been processed and your membership status should now be active.','colabsthemes') ?></h3>
            <p><?php _e('Visit your dashboard to review your membership status details.','colabsthemes') ?></p>
            <ul class="membership-pack">
                <li><strong><?php _e('Membership Pack','colabsthemes')?>:</strong> <?php echo stripslashes($order_processed['pack_name']); ?></li>
                <li><strong><?php _e('Membership Expires','colabsthemes')?>:</strong> <?php echo colabsthemes_display_date($order_processed['updated_expires_date']); ?></li>
                <li><a href="<?php echo COLABS_MEMBERSHIP_BUY_URL; ?>"><?php _e('Renew or Extend Your Membership Pack','colabsthemes'); ?></a></li>
            </ul>
          </div>
      <?php } else { ?>
        <h2 ><?php _e('An Error Has Occurred','colabsthemes') ?></h2>
        <div class="thankyou">
              <p><?php _e('There was a problem processing your membership or payment was not successful. This error can also occur if you refresh the payment confirmation page. If you believe your order was not completed successfully, please contact the site administrator.','colabsthemes') ?></p>
        </div>
       <?php } ?>
      </div>
		</div>
	<?php colabs_main_after(); ?>					
  </div><!-- /.main-content -->  
	<?php get_sidebar('user'); ?>
</div><!-- /.main-container -->

<?php get_footer(); ?>