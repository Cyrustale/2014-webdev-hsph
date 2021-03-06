<?php
/*
Template Name: User Profile
*/
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();
global $errmsg;
$current_user = wp_get_current_user(); // grabs the user info and puts into vars
  $display_user_name = $current_user->display_name;
// check to see if the form has been posted. If so, validate the fields
if ( !empty($_POST['submit']) ) {
    if ( defined('ABSPATH') ) {
        require_once(ABSPATH . 'wp-admin/includes/user.php');
    } else {
        require_once('../wp-admin/includes/user.php');
    }
    //Deprecated since WP 3.1. This file no longer needs to be included.
    //require_once( ABSPATH . WPINC . '/registration.php' );
    check_admin_referer( 'update-profile_' . $user_ID );
    $errors = edit_user( $user_ID );
    if ( is_wp_error( $errors ) ) {
        foreach ( $errors->get_error_messages() as $message )
            $errmsg = "$message";
            //exit;
    }
    // if there are no errors, then process the profile updates
    if ( $errmsg == '' ) {
        // update the user fields
        do_action( 'personal_options_update', $user_ID );
        // update the custom user fields
        update_user_meta( $user_ID, 'twitter_id', sanitize_text_field( $_POST['twitter_id'] ) );
        update_user_meta( $user_ID, 'facebook_id', sanitize_text_field( $_POST['facebook_id'] ) );
        update_user_meta( $user_ID, 'paypal_email', sanitize_text_field( $_POST['paypal_email'] ) );
        wp_redirect( './?updated=true' );
    } else {
        $errmsg = '<div class="box-red"><strong>**  ' . $errmsg . ' **</strong></div>';
        $errcolor = 'style="background-color:#FFEBE8;border:1px solid #CC0000;"';
    }
}	
?>
<?php get_header(); ?>
<script type='text/javascript' src='<?php echo get_option('siteurl'); ?>/wp-admin/js/password-strength-meter.js?ver=20081210'></script>
<script type="text/javascript">/*<![CDATA[*/(function($){function check_pass_strength(){var pass=$('#pass1').val();var user=$('#user_login').val();$('#pass-strength-result').removeClass('short bad good strong');if(!pass){$('#pass-strength-result').html(pwsL10n.empty);return;}
var strength=passwordStrength(pass,user,this);if(2==strength)
$('#pass-strength-result').addClass('bad').html(pwsL10n.bad);else if(3==strength)
$('#pass-strength-result').addClass('good').html(pwsL10n.good);else if(4==strength)
$('#pass-strength-result').addClass('strong').html(pwsL10n.strong);else
$('#pass-strength-result').addClass('short').html(pwsL10n.short);}
$(document).ready(function(){$('#pass1').val('').keyup(check_pass_strength);});})(jQuery);pwsL10n={empty:"<?php _e('Strength indicator','colabsthemes') ?>",short:"<?php _e('Very weak','colabsthemes') ?>",bad:"<?php _e('Weak','colabsthemes') ?>",good:"<?php _e('Medium','colabsthemes') ?>",strong:"<?php _e('Strong','colabsthemes') ?>"}
try{convertEntities(pwsL10n);}catch(e){};jQuery(document).ready(function($){$("#your-profile").validate({errorClass:"invalid"});});/*]]>*/</script>
<!-- #Main Starts -->
<?php colabs_main_before(); ?>
    <div class="row main-container">
        <div class="main-content col9">
            <header class="entry-header">
			  <h2><?php printf( __('%s\'s Profile', 'colabsthemes'), esc_html( $display_user_name ) ); ?></h2>
			</header>
			<?php if ( isset($_GET['updated']) ) { ?>
                <div class="notification-success"><?php _e('Your profile has been updated.','colabsthemes')?></div>
			<?php  } ?>
			<?php echo $errmsg; ?>
			<div <?php post_class(); ?>>
				<form name="profile" id="your-profile" action="" method="post" class="form-section">
				<?php wp_nonce_field( 'update-profile_' . $user_ID ); ?>
				<input type="hidden" name="from" value="profile" />
				<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
				<div class="input-text">
					<label for="user_login"><?php _e('Username', 'colabsthemes'); ?></label>
					<input type="text" name="user_login" id="user_login" value="<?php esc_attr_e( $current_user->user_login ); ?>" class="txt textboxcontact" />
				</div>
				<div class="input-text">
				<label for="first_name"><?php _e('First Name:','colabsthemes') ?></label></th>
				<input type="text" name="first_name" class="txt requiredField" id="first_name" value="<?php esc_attr_e( $current_user->first_name ); ?>" />
				</div>
				<div class="input-text">
				<label for="last_name"><?php _e('Last Name:','colabsthemes') ?></label></th>
				<input type="text" name="last_name" class="txt requiredField" id="last_name" value="<?php esc_attr_e( $current_user->last_name ); ?>" />
				</div>
				<div class="input-text">
				<label for="nickname"><?php _e('Nickname:','colabsthemes') ?></label></th>
				<input type="text" name="nickname" class="txt" id="nickname" value="<?php esc_attr_e( $current_user->nickname ); ?>" />
				</div>
				<div class="input-text">
				<label for="display_name"><?php _e('Display name publicly as:','colabsthemes') ?></label>
				<select name="display_name" class="regular-dropdown" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_displayname'] = esc_attr($current_user->display_name);
						$public_display['display_nickname'] = esc_attr($current_user->nickname);
						$public_display['display_username'] = esc_attr($current_user->user_login);
						$public_display['display_firstname'] = esc_attr($current_user->first_name);
						$public_display['display_firstlast'] = esc_attr($current_user->first_name) . '&nbsp;' . esc_attr($current_user->last_name);
						$public_display['display_lastfirst'] = esc_attr($current_user->last_name) . '&nbsp;' . esc_attr($current_user->first_name);
						$public_display = array_unique(array_filter(array_map('trim', $public_display)));
						foreach($public_display as $id => $item) {
					?>
						<option id="<?php echo $id; ?>" value="<?php echo esc_attr($item); ?>"><?php esc_attr_e($item); ?></option>
					<?php
						}
					?>
				</select>
				</div>
				<div class="input-text">
				<label for="email"><?php _e('Email:','colabsthemes') ?></label>
				<input type="text" name="email" class="txt" id="email" value="<?php esc_attr_e($current_user->user_email); ?>" />
				</div>
				<div class="input-text">
				<label for="url"><?php _e('Website:','colabsthemes') ?></label>
				<input type="text" name="url" class="txt" id="url" value="<?php echo esc_url($current_user->user_url); ?>" />
				</div>
				<div class="input-text">
				<label for="description"><?php _e('About Yourself:','colabsthemes'); ?></label>
				<textarea name="description" class="txt" id="description" rows="10" cols="50"><?php echo esc_textarea($current_user->description); ?></textarea>
				</div>
				<?php
				$show_password_fields = apply_filters('show_password_fields', true);
				if ( $show_password_fields ) :
				?>
				<div class="input-text">
				<label for="pass1"><?php _e('New Password:','colabsthemes'); ?></label>
				<input type="password" name="pass1" class="regular-text" id="pass1" value="" />
				<span class="description"><?php _e('If you would like to change the password type a new one. Otherwise leave this blank.','colabsthemes'); ?></span>
				</div>
				<div class="input-text">
				<label for="pass1"><?php _e('Re-Type Password:','colabsthemes'); ?></label>
				<input type="password" name="pass2" class="regular-text" id="pass2" value="" />
				<span class="description"><?php _e('Type your new password again.','colabsthemes'); ?></span>
				</div>
				<div class="input-text">
				<label for="pass1">&nbsp;</label>
				<div id="pass-strength-result"><?php _e('Strength indicator','colabsthemes'); ?></div>
				<span class="description"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).','colabsthemes'); ?></span>
				</div>
				<?php endif; ?>
				<?php
				do_action('profile_personal_options', $current_user);
				do_action('show_user_profile', $current_user);
				?>
				<p class="submit center">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_ID; ?>" />
					<input type="hidden" name="admin_color" value="<?php esc_attr_e( $current_user->admin_color ); ?>" />
					<input type="hidden" name="rich_editing" value="<?php esc_attr_e( $current_user->rich_editing ); ?>" />
					<input type="hidden" name="comment_shortcuts" value="<?php esc_attr_e( $current_user->comment_shortcuts ); ?>" />
					<?php if ( !empty($current_user->admin_bar_front) ) { ?>
						<input type="hidden" name="admin_bar_front" value="<?php esc_attr_e( $current_user->admin_bar_front ); ?>" />
					<?php } ?>
					<?php if ( !empty($current_user->admin_bar_admin) ) { ?>
						<input type="hidden" name="admin_bar_admin" value="<?php esc_attr_e( $current_user->admin_bar_admin ); ?>" />
					<?php } ?>
					<input type="submit" id="cpsubmit" class="btn btn-primary" value="<?php _e('Update Profile ', 'colabsthemes')?>" name="submit" />
				</p>
				</form>	
            </div>
        </div><!-- /.main-content -->  
		<?php get_sidebar('user'); ?>
    </div><!-- /.main-container -->
<?php colabs_main_after(); ?>
<?php get_footer(); ?>