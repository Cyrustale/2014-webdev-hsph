<?php
/**
 * WordPress Forgot Password Form
 * Function outputs the forgotten password form
 *
 *
 * @author ColorLabs
 * @package Classifier
 *
 */

function colabs_forgot_password_form() {
?>
	
    <form action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post" class="loginform" name="lostpasswordform" id="lostpasswordform">

        <p>
            <label for="login_username"><?php _e('Username or Email:', 'colabsthemes'); ?></label>
            <input type="text" class="text" name="user_login" id="login_username" />
        </p>

        <div id="checksave">
            <?php do_action('lostpassword_form'); ?>
            <p class="submit"><input type="submit" class="btn btn-primary" name="login" id="login" value="<?php _e('Get New Password','colabsthemes'); ?>" tabindex="100" /></p>
        </div>
	
    </form>
    
    <script type="text/javascript">document.getElementById('login_username').focus();</script> 
	
<?php
}
?>