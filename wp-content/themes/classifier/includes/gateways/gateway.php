<?php
/*
 * Payment gateway processing happens here
 *
 */
include_once( get_template_directory() . '/includes/gateways/paypal/paypal.php' );
include_once( get_template_directory() . '/includes/gateways/banktransfer/banktransfer.php' );
//membership system does not use $advals for security purposes
if ( !isset( $advals ) )
    $advals = $_POST;
if ( 'banktransfer' != $advals['colabs_payment_method'] ) { ?>
  
	    <h2><?php _e('Please wait while we redirect you to our payment page.', 'colabsthemes');?></h2>
        <div class="payment-loader"></div>
	    <p class="small"><?php _e('(Click the button below if you are not automatically redirected within 5 seconds.)', 'colabsthemes');?></p>

<?php
}
    // determine which payment gateway was selected and serve up the correct script
	if ( !isset( $advals['colabs_payment_method'] ) )
	    $advals['colabs_payment_method'] = $_POST['colabs_payment_method'];
	// membership purchase returns array of order values
	if ( !isset( $post_id ) ) {
	    $order_vals = colabs_get_order_pack_vals( $advals );
	// ad listing purchase returns array of order values
	} else {
	    $advals['post_id'] = $post_id;
	    $order_vals = colabs_get_order_vals( $advals );
	}
	// do action hook

  colabs_action_gateway( $order_vals );

?>