<?php

//need to replace this with a check if the cron hook already exists, instead of using random variable
if (get_option('colabs_ad_expired_check') != 'true' && get_option('colabs_ad_expired_check_recurrance') != 'none')
    colabs_schedule_expire_check();

// If the user selects "None" from the Classifier Options page, remove all scheduled crons and set the scheduler check to NO (not set).
// To minimize use of this function, added a check to only run the function if the scheduler check is set to yes.
if (get_option('colabs_ad_expired_check_recurrance') == 'none' && get_option('colabs_ad_expired_check') == 'true') {
    wp_clear_scheduled_hook('colabs_ad_expired_check');
    update_option('colabs_ad_expired_check', 'false');
}

//schedule the cron jobs
function colabs_schedule_expire_check() {
    wp_clear_scheduled_hook('colabs_ad_expired_check');

    if(!get_option('colabs_ad_expired_check_recurrance')) $recurranceValue = 'daily';
    else $recurranceValue = get_option('colabs_ad_expired_check_recurrance');
    wp_schedule_event(strtotime('today + 1 hour'), $recurranceValue, 'colabs_ad_expired_check');
    add_option('colabs_ad_expired_check', 'true');
}

//cron jobs execute the following function everytime they run
function colabs_check_expired_cron() {
    if( get_option('colabs_post_prune') == 'true' ) {
        global $wpdb;

        //keep in mind the email takes the tabbed formatting and uses it in the email, so please keep formatting of query below.
        $qryToString = "SELECT $wpdb->posts.ID FROM $wpdb->posts
        LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id
        WHERE $wpdb->postmeta.meta_key = 'colabs_sys_expire_date'
        AND timediff(STR_TO_DATE($wpdb->postmeta.meta_value, '%m/%d/%Y %H:%i:%s'), now()) <= 0
        AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = '".COLABS_POST_TYPE."'";

        $postids = $wpdb->get_col($qryToString);
        $messageDetails = '';

        //create msgDetails variable that has a set of links to expired ads that are found.
        if ($postids) foreach ($postids as $id) {
            $update_ad = array();
            $update_ad['ID'] = $id;
            $update_ad['post_status'] = 'draft';
            wp_update_post($update_ad);
            $messageDetails .= get_bloginfo ( 'url' ) . "/?p=" . $id . '' . "\r\n";
        }
        //get rid of the trailing comma
        $messageDetails = trim($messageDetails, ',');

        if($messageDetails == '')
            $messageDetails = __('No expired ads were found.', 'colabsthemes');
        else
            $messageDetails = __('The following ads expired and have been taken down from your website: ', 'colabsthemes') . "\r\n" . $messageDetails;
            $message = __('Your cron job has run successfully. ', 'colabsthemes') . "\r\n" . $messageDetails;

    } else {
        $message = __('Your cron job has run successfully. However, the pruning ads option is turned off so no expired ads were taken down from the website.', 'colabsthemes'); }

        if(get_option('colabs_prune_ads_email') == 'true')
            wp_mail(get_option('admin_email'), __('Classifier Ads Expired', 'colabsthemes'), $message . "\r\n\n" . __('Regards', 'colabsthemes') . ", \r\n" . __('Classifier'));
}

add_action('colabs_ad_expired_check', 'colabs_check_expired_cron');

?>