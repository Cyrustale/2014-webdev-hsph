<?php
$options_new_field = array (

    array( 'type' => 'notab'),

	array(	'name' => __('Field Information', 'colabsthemes'),
                'type' => 'title'),

		array(  'name' => __('Field Name', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('Create a field name that best describes what this field will be used for. (i.e. Color, Size, etc). It will be visible on your site.','colabsthemes'),
                        'id' => 'field_label',
                        'css' => 'min-width:400px;',
                        'type' => 'text',
                        'req' => '1',
                        'vis' => '',
                        'min' => '2',
                        'std' => ''),

                array(  'name' => __('Meta Name', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('This field is used by WordPress so you cannot modify it. Doing so could cause problems displaying the field on your ads.','colabsthemes'),
                        'id' => 'field_name',
                        'css' => 'min-width:400px;',
                        'type' => 'text',
                        'req' => '1',
                        'vis' => '',
                        'min' => '5',
                        'std' => '',
                        'dis' => '1'),

                array(  'name' => __('Field Description','colabsthemes'),
                        'desc' => '',
                        'tip' => __('Enter a description of your new form layout. It will not be visible on your site.','colabsthemes'),
                        'id' => 'field_desc',
                        'css' => 'width:400px;height:100px;',
                        'type' => 'textarea',
                        'req' => '1',
                        'vis' => '',
                        'min' => '5',
                        'std' => ''),
				
                array(  'name' => __('Field Tooltip','colabsthemes'),
                        'desc' => '',
                        'tip' => __('This will create a ? tooltip icon next to this field on the submit ad page.','colabsthemes'),
                        'id' => 'field_tooltip',
                        'css' => 'width:400px;height:100px;',
                        'type' => 'textarea',
                        'req' => '0',
                        'vis' => '',
                        'min' => '5',
                        'std' => ''),
				
               array(   'name' => __('Field Type', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('This is the type of field you want to create.','colabsthemes'),
                        'id' => 'field_type',
                        'css' => 'min-width:100px;',
                        'std' => '',
                        'js' => 'onchange="show(this)"',
                        'req' => '1',
                        'vis' => '',
                        'min' => '',
                        'type' => 'select',
                        'options' => array( 'text box'  => __('text box', 'colabsthemes'),
                                            'drop-down' => __('drop-down', 'colabsthemes'),
                                            'text area' => __('text area', 'colabsthemes'),
                                            'radio'     => __('radio buttons', 'colabsthemes'),
                                            'checkbox'  => __('checkboxes', 'colabsthemes'),
                                          ),
                   ),
				   
				   array(  'name' => __('Minimum Length', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('Defines the minimum number of characters required for this field. Enter a number like 2 or leave it empty to make the field optional.','colabsthemes'),
                        'id' => 'field_min_length',
                        'css' => 'min-width:400px;',
                        'type' => 'text',
                        'req' => '0',
                        'vis' => '0',
                        'min' => '',
                        'std' => ''),

                array(  'name' => __('Field Values', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('Enter a comma separated list of values you want to appear in this drop-down box. (i.e. XXL,XL,L,M,S,XS). Do not separate values with the return key.','colabsthemes'),
                        'id' => 'field_values',
                        'css' => 'width:400px;height:200px;',
                        'type' => 'textarea',
                        'req' => '',
                        'min' => '1',
                        'std' => '',
                        'vis' => '0',
                    ),


    array( 'type' => 'notabend'),

);

function colabs_customfields_admin_options() {
	if ( !current_user_can('manage_options') ) return;
	add_submenu_page( 'colabsthemes', __('Custom Fields','colabsthemes'), __('Custom Fields','colabsthemes'), 'manage_options', 'fields', 'colabs_custom_fields' );
}
add_action('admin_menu', 'colabs_customfields_admin_options');

function colabs_custom_fields() {
    global $options_new_field, $wpdb, $current_user;

    get_currentuserinfo();
    ?>

    <!-- show/hide the dropdown field values tr -->
    <script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function() {
				jQuery("#mainform").validate({errorClass: "invalid"});
			});

			function show(o){
				if(o){switch(o.value){
					case 'drop-down': jQuery('#field_values_row').show(); jQuery('#field_min_length_row').hide(); break;
					case 'radio': jQuery('#field_values_row').show(); jQuery('#field_min_length_row').hide(); break;
					case 'checkbox': jQuery('#field_values_row').show(); jQuery('#field_min_length_row').hide(); break;
					case 'text box': jQuery('#field_min_length_row').show(); jQuery('#field_values_row').hide(); break;
					default: jQuery('#field_values_row').hide();jQuery('#field_min_length_row').hide();
				}}
			}

			//show/hide immediately on document load
			jQuery(document).ready(function() {
				show(jQuery('#field_type').get(0));
			});
		/* ]]> */
    </script>

    <?php

    // check to prevent php "notice: undefined index" msg when php strict warnings is on
    if ( isset( $_GET['action'] ) ) $theswitch = $_GET['action']; else $theswitch = '';

    switch ( $theswitch ) {

    case 'addfield':
    ?>

        <div class="wrap">
            <div class="icon32" id="icon-themes"><br/></div>
            <h2><?php _e('New Custom Field','colabsthemes') ?></h2>

            <?php colabs_admin_info_box(); ?>

        <?php
        // check and make sure the form was submitted
        if ( isset( $_POST['submitted'] ) ) {

            $_POST['field_search'] = ''; // we aren't using this field so set it to blank for now to prevent notice

            $insert = "INSERT INTO " . $wpdb->prefix . "colabs_ad_fields ( field_name, field_label, field_desc, field_tooltip, field_type, field_values, field_search, field_owner, field_created, field_modified ) VALUES ( '" .
                        $wpdb->escape(colabsthemes_clean(colabs_make_custom_name($_POST['field_label']))) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_label'])) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_desc'])) . "','" .
                        $wpdb->escape(esc_attr(colabsthemes_clean($_POST['field_tooltip']))) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_type'])) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_values'])) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_search'])) . "','" .
                        $wpdb->escape(colabsthemes_clean($_POST['field_owner'])) . "','" .
                        current_time('mysql') . "','" .
                        current_time('mysql') .
                    "' )";

            $results = $wpdb->query( $insert );


            if ( $results ) :

            ?>

                <p style="text-align:center;padding-top:50px;font-size:22px;"><?php _e('Creating your field.....','colabsthemes') ?><br /><br /><img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" /></p>
                <meta http-equiv="refresh" content="0; URL=?page=fields">

            <?php
            endif;

            die;

        } else {
        ?>

            <form method="post" id="mainform" action="">

                <?php colabs_admin_fields( $options_new_field ) ?>

                <p class="submit"><input class="btn button-primary" name="save" type="submit" value="<?php _e('Create New Field','colabsthemes') ?>" />&nbsp;&nbsp;&nbsp;
                    <input name="cancel" type="button" onClick="location.href='?page=fields'" value="<?php _e('Cancel','colabsthemes') ?>" /></p>
                <input name="submitted" type="hidden" value="yes" />
                <input name="field_owner" type="hidden" value="<?php echo $current_user->user_login ?>" />

            </form>

        <?php
        }
        ?>

        </div><!-- end wrap -->

    <?php
    break;


    case 'editfield':
    ?>

        <div class="wrap">
            <div class="icon32" id="icon-themes"><br/></div>
            <h2><?php _e('Edit Custom Field','colabsthemes') ?></h2>

            <?php colabs_admin_info_box(); ?>

        <?php
        if ( isset( $_POST['submitted'] ) && $_POST['submitted'] == 'yes' ) {

	    // @todo Change to Update
            $update = $wpdb->prepare( "UPDATE " . $wpdb->prefix . "colabs_ad_fields SET" .
                    " field_name = %s," .
                    " field_label = %s," .
                    " field_desc = %s," .
                    " field_tooltip = %s," .
                    " field_type = %s," .
                    " field_values = %s," .
                    " field_min_length = %s," .
                    " field_owner = %s," .
                    " field_modified = %s" .
                    " WHERE field_id = %s",
                    colabsthemes_clean($_POST['field_name']),
                    colabsthemes_clean($_POST['field_label']),
                    colabsthemes_clean($_POST['field_desc']),
                    esc_attr(colabsthemes_clean($_POST['field_tooltip'])),
                    colabsthemes_clean($_POST['field_type']),
                    colabsthemes_clean($_POST['field_values']),
                    colabsthemes_clean($_POST['field_min_length']),
                    colabsthemes_clean($_POST['field_owner']),
                    current_time('mysql'),
                    $_GET['id']
                    );

            $results = $wpdb->query(  $update );

            ?>

            <p style="text-align:center;padding-top:50px;font-size:22px;">

                <?php _e('Saving your changes.....', 'colabsthemes') ?><br /><br />
                <img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" />

            </p>

            <meta http-equiv="refresh" content="0; URL=?page=fields">

        <?php
        } else {
        ?>


            <form method="post" id="mainform" action="">

            <?php colabs_admin_db_fields($options_new_field, 'colabs_ad_fields', 'field_id') ?>

                <p class="submit">
                    <input class="btn button-primary" name="save" type="submit" value="<?php _e('Save changes','colabsthemes') ?>" />&nbsp;&nbsp;&nbsp;
                    <input name="cancel" type="button" onClick="location.href='?page=fields'" value="<?php _e('Cancel','colabsthemes') ?>" />
                    <input name="submitted" type="hidden" value="yes" />
                    <input name="field_owner" type="hidden" value="<?php echo $current_user->user_login ?>" />
                </p>

            </form>

        <?php } ?>

        </div><!-- end wrap -->

    <?php
    break;


    case 'delete':

        // check and make sure this fields perms allow deletion
        $sql = "SELECT field_perm "
             . "FROM " . $wpdb->prefix . "colabs_ad_fields "
             . "WHERE field_id = '". $_GET['id'] ."' LIMIT 1";

        $results = $wpdb->get_row( $sql );

        // if it's not greater than zero, then delete it
        if ( !$results->field_perm > 0 ) {

            $delete = "DELETE FROM " . $wpdb->prefix . "colabs_ad_fields WHERE field_id = '". $_GET['id'] ."'";

            $wpdb->query( $delete );
        }
        ?>
        <p style="text-align:center;padding-top:50px;font-size:22px;"><?php _e('Deleting custom field.....','colabsthemes') ?><br /><br /><img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" /></p>
        <meta http-equiv="refresh" content="0; URL=?page=fields">

    <?php

    break;


    // colabs_custom_fields() show the table of all custom fields
    default:

         $sql = "SELECT field_id, field_name, field_label, field_desc, field_tooltip, field_type, field_perm, field_owner, field_modified "
             . "FROM " . $wpdb->prefix . "colabs_ad_fields "
             . "ORDER BY field_name desc";

        $results = $wpdb->get_results($sql);
        ?>

        <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2><?php _e('Custom Fields','colabsthemes') ?>&nbsp;<a class="button add-new-h2" href="?page=fields&amp;action=addfield"><?php _e('Add New','colabsthemes') ?></a></h2>

        <?php colabs_admin_info_box(); ?>

        <p class="admin-msg"><?php _e('Custom fields allow you to customize your ad submission forms and collect more information. Each custom field needs to be added to a form layout in order to be visible on your website. You can create unlimited custom fields and each one can be used across multiple form layouts. It is highly recommended to NOT delete a custom field once it is being used on your ads because it could cause ad editing problems for your customers.','colabsthemes') ?></p>

        <table id="tblspacer" class="widefat fixed">

            <thead>
                <tr>
                    <th scope="col" style="width:35px;">&nbsp;</th>
                    <th scope="col"><?php _e('Name','colabsthemes') ?></th>
                    <th scope="col" style="width:100px;"><?php _e('Type','colabsthemes') ?></th>
                    <th scope="col"><?php _e('Description','colabsthemes') ?></th>
                    <th scope="col" style="width:150px;"><?php _e('Modified','colabsthemes') ?></th>
                    <th scope="col" style="text-align:center;width:100px;"><?php _e('Actions','colabsthemes') ?></th>
                </tr>
            </thead>

            <?php
            if ($results) {
            ?>

                <tbody id="list">

                  <?php
                  $rowclass = '';
                  $i=1;

                  foreach($results as $result) {

                    $rowclass = 'even' == $rowclass ? 'alt' : 'even';
                    ?>

                    <tr class="<?php echo $rowclass ?>">
                        <td style="padding-left:10px;"><?php echo $i ?>.</td>
                        <td><a href="?page=fields&amp;action=editfield&amp;id=<?php echo $result->field_id ?>"><strong><?php echo $result->field_label ?></strong></a></td>
                        <td><?php echo $result->field_type ?></td>
                        <td><?php echo $result->field_desc ?></td>
                        <td><?php echo mysql2date(get_option('date_format') .' '. get_option('time_format'), $result->field_modified) ?> <?php _e('by','colabsthemes') ?> <?php echo $result->field_owner; ?></td>
                        <td style="text-align:center">

                            <?php
                            // show the correct edit options based on perms
                            switch($result->field_perm) {

                                case '1': // core fields no editing
                                ?>

                                    <a href="?page=fields&amp;action=editfield&amp;id=<?php echo $result->field_id ?>"><img src="<?php echo bloginfo('template_directory') ?>/images/edit.png" alt="" /></a>&nbsp;&nbsp;&nbsp;
                                    <img src="<?php echo bloginfo('template_directory'); ?>/images/cross-grey.png" alt="" />

                                <?php
                                break;

                                case '2': // core fields some editing
                                ?>

                                    <a href="?page=fields&amp;action=editfield&amp;id=<?php echo $result->field_id ?>"><img src="<?php echo bloginfo('template_directory') ?>/images/edit.png" alt="" /></a>&nbsp;&nbsp;&nbsp;
                                    <img src="<?php echo bloginfo('template_directory') ?>/images/cross-grey.png" alt="" />

                                <?php
                                break;

                                default: // regular fields full editing
                                    // don't change these two lines to plain html/php. Get t_else error msg
                                    echo '<a href="?page=fields&amp;action=editfield&amp;id='. $result->field_id .'"><img src="'. get_bloginfo('template_directory') .'/images/edit.png" alt="" /></a>&nbsp;&nbsp;&nbsp;';
                                    echo '<a onclick="return confirmBeforeDelete();" href="?page=fields&amp;action=delete&amp;id='. $result->field_id .'"><img src="'. get_bloginfo('template_directory') .'/images/cross.png" alt="" /></a>';

                           } // endswitch
                           ?>

                        </td>
                    </tr>

                <?php
                    $i++;

                  } //end foreach;
                  //} // mystery bracket which makes it work
                  ?>

              </tbody>

            <?php
            } else {
            ?>

                <tr>
                    <td colspan="5"><?php _e('No custom fields found. This usually means your install script did not run correctly. Go back and try reactivating the theme again.','colabsthemes') ?></td>
                </tr>

            <?php
            } // end $results
            ?>

        </table>

        </div><!-- end wrap -->

    <?php
    } // endswitch
    ?>



    <script type="text/javascript">
        /* <![CDATA[ */
            function confirmBeforeDelete() { return confirm("<?php _e('WARNING: Deleting this field will prevent any existing ads currently using this field from displaying the field value. Deleting fields is NOT recommended unless you do not have any existing ads using this field. Are you sure you want to delete this field?? (This cannot be undone)', 'colabsthemes'); ?>"); }
        /* ]]> */
    </script>

<?php

}

function colabs_make_custom_name($cname) {

	$cname = preg_replace('/[^a-zA-Z0-9\s]/', '', $cname);
	$cname = 'colabs_' . str_replace(' ', '_', strtolower(substr(colabsthemes_clean($cname), 0, 30)));

	return $cname;
}

function colabs_admin_fields($options) {
?>


<div id="tabs-wrap">


    <?php

    // first generate the page tabs
    $counter = 0;

    echo '<ul class="tabs">'. "\n";
    foreach ( $options as $value ) {

        if ( in_array('tab', $value) ) :
            echo '<li><a href="#'.$value['type'].$counter.'">'.$value['tabname'].'</a></li>'. "\n";
            $counter = $counter + 1;
        endif;

    }
    echo '</ul>'. "\n\n";


     // now loop through all the options
    $counter = 0;
    $table_width = get_option('colabs_table_width');

    foreach ( $options as $value ) {

        switch ( $value['type'] ) {

            case 'tab':

                echo '<div id="'.$value['type'].$counter.'">'. "\n\n";
                echo '<table class="widefat fixed" style="width:'.$table_width.'; margin-bottom:20px;">'. "\n\n";

            break;

            case 'notab':

                echo '<table class="widefat fixed" style="width:'.$table_width.'; margin-bottom:20px;">'. "\n\n";

            break;

            case 'title':
            ?>

                <thead><tr><th scope="col" width="200px"><?php echo $value['name'] ?></th><th scope="col"><?php if ( isset( $value['desc'] ) ) echo $value['desc'] ?>&nbsp;</th></tr></thead>

            <?php
            break;

            case 'text':
            ?>

            <?php if ( $value['id'] <> 'field_name' ) { // don't show the meta name field used by WP. This is automatically created by CP. ?>
                <tr <?php if ($value['vis'] == '0') { ?>id="<?php if ( !empty($value['visid']) ) { echo $value['visid']; } else { echo 'field_values'; } ?>" style="display:none;"<?php } else { ?>id="<?php echo $value['id'] ?>_row"<?php } ?>>
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp"><input name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" type="<?php echo $value['type'] ?>" style="<?php echo $value['css'] ?>" value="<?php if (get_option( $value['id'])) echo get_option( $value['id'] ); else echo $value['std'] ?>"<?php if ($value['req']) { ?> class="required <?php if ( !empty($value['altclass']) ) echo $value['altclass'] ?>" <?php } ?> <?php if ( $value['min'] ) { ?> minlength="<?php echo $value['min'] ?>"<?php } ?> /><br /><small><?php echo $value['desc'] ?></small></td>
                </tr>
            <?php } ?>

            <?php
            break;

            case 'select':
            ?>

                <tr id="<?php echo $value['id'] ?>_row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp"><select <?php if ( !empty( $value['js'] ) ) echo $value['js']; ?> name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" style="<?php echo $value['css'] ?>"<?php if ( $value['req'] ) { ?> class="required"<?php } ?>>

                        <?php
                        foreach ($value['options'] as $key => $val) {
                        ?>

                            <option value="<?php echo $key ?>" <?php if ( get_option($value['id']) == $key ) { ?> selected="selected" <?php } ?>><?php echo ucfirst($val) ?></option>

                        <?php
                        }
                        ?>

                       </select><br /><small><?php echo $value['desc'] ?></small>
                    </td>
                </tr>

            <?php
            break;

            case 'checkbox':
            ?>

                <tr id="<?php echo $value['id'] ?>_row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp"><input type="checkbox" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" value="true" style="<?php echo $value['css']?>" <?php if(get_option($value['id'])) { ?>checked="checked"<?php } ?> />
                        <br /><small><?php echo $value['desc'] ?></small>
                    </td>
                </tr>

            <?php
            break;

            case 'textarea':
            ?>
                <tr id="<?php echo $value['id'] ?>_row"<?php if ( $value['id'] == 'field_values' ) { ?> style="display: none;" <?php } ?>>
                    <td class="titledesc"><?php if ( $value['tip'] ) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp">
                        <textarea name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" style="<?php echo $value['css'] ?>" <?php if ($value['req']) { ?> class="required" <?php } ?><?php if ( $value['min'] ) { ?> minlength="<?php echo $value['min'] ?>"<?php } ?>><?php if ( get_option($value['id']) ) echo stripslashes( get_option($value['id']) ); else echo $value['std']; ?></textarea>
                        <br /><small><?php echo $value['desc'] ?></small>
                    </td>
                </tr>

            <?php
            break;

            case 'cat_checklist':
            ?>

                <tr id="<?php echo $value['id'] ?>_row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp">
                        <div id="categorydiv">
                            <div  id="categories-all" style="<?php echo $value['css'] ?>">
                                <ul class="list:category categorychecklist form-no-clear" id="categorychecklist">
                                <?php $catcheck = colabs_category_checklist(0,colabs_exclude_cats()); ?>
                                <?php if($catcheck) echo $catcheck; else wp_die( '<p style="color:red;">' .__('All your categories are currently being used. You must remove at least one category from another form layout before you can continue.','colabsthemes') .'</p>' ); ?>
                                </ul>
                            </div>
                        </div>
                        <br /><small><?php echo $value['desc'] ?></small>
                    </td>
                </tr>

            <?php
            break;

			case 'upload':
			?>
				<tr>
					<td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
					<td class="forminp">
						<input id="<?php echo $value['id'] ?>" class="upload_image_url" type="text" style="<?php echo $value['css'] ?>" name="<?php echo $value['id'] ?>" value="<?php if (get_option( $value['id'])) echo get_option( $value['id'] ); else echo $value['std'] ?>" />
						<input id="upload_image_button" class="upload_button button" rel="<?php echo $value['id'] ?>" type="button" value="<?php _e('Upload Image', 'colabsthemes') ?>" />
						<?php if (get_option( $value['id'])){ ?>
						    <input name="<?php echo $value['id'] ?>" value="Clear Image" id="delete_image_button" class="delete_button button" rel="<?php echo $value['id'] ?>" type="button" />
						<?php } ?>
						<br /><small><?php echo $value['desc'] ?></small>
						<div id="<?php echo $value['id'] ?>_image" class="<?php echo $value['id'] ?>_image upload_image_preview"><?php if (get_option( $value['id'])) echo '<img src="' .get_option( $value['id'] ) . '" />'; ?></div>
						
					</td>
                </tr>

			<?php
			break;

            case 'logo':
            ?>
                <tr id="<?php echo $value['id'] ?>_row">
                    <td class="titledesc"><?php echo $value['name'] ?></td>
                    <td class="forminp">&nbsp;</td>
                </tr>

            <?php
            break;

            case 'price_per_cat':
            ?>
                <tr id="<?php echo $value['id'] ?>_row"  class="cat-row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>

                    <td class="forminp">

                        <table style="width:100%;">

                        <?php

                        $categories = get_categories('orderby=name&order=asc&hide_empty=0&taxonomy='.COLABS_TAX_CAT);
                        $i = 0;

                        foreach ($categories as $cat) {

                            if (($i % 2) == 0) { ?>
                                <tr>
                            <?php
                            }

                            // if the category price is empty, put a zero in it so it doesn't error out
                            $cat_price = get_option('colabs_cat_price_'.$cat->cat_ID);
                            if ($cat_price == '') {
                                $cat_price = '0';
                            }
                            ?>

                            <td nowrap style="padding-top:15px; text-align: right;"><?php echo $cat->cat_name; ?>:</td>
                            <td nowrap style="color:#bbb;"><input name="catarray[colabs_cat_price_<?php echo $cat->cat_ID; ?>]" type="text" size="10" maxlength="100" value="<?php echo $cat_price ?>" />&nbsp;<?php echo get_option('colabs_curr_pay_type') ?></td>
                            <td cellspan="2" width="100">&nbsp;</td>

                            <?php
                            if (($i % 2) != 0) { ?>
                                </tr>
                            <?php
                            }

                            $i++;

                        } // end foreach
                        ?>

                        </table>

                    </td>
                </tr>


            <?php
            break;

			case 'required_per_cat':
            ?>
                <tr id="<?php echo $value['id'] ?>_row"  class="cat-row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>

                    <td class="forminp">

                        <table style="width:100%;">

                        <?php

                        $categories = get_categories('orderby=name&order=asc&hide_empty=0&taxonomy='.COLABS_TAX_CAT);
						$required_categories = get_option('colabs_required_categories');
                        $i = 0;

                        foreach ($categories as $cat) {

                            if (($i % 2) == 0) { ?>
                                <tr>
                            <?php
                            }

                            ?>

                            <td nowrap style="padding-top:15px; text-align: right;"><?php echo $cat->cat_name; ?>:</td>
                            <td nowrap style="color:#bbb;"><input name="catreqarray[colabs_cat_req_<?php echo $cat->cat_ID; ?>]" type="checkbox" value="<?php echo $cat->cat_ID; ?>" <?php if(isset($required_categories[$cat->cat_ID])) echo 'checked="checked"'; ?> /></td>
                            <td cellspan="2" width="100">&nbsp;</td>

                            <?php
                            if (($i % 2) != 0) { ?>
                                </tr>
                            <?php
                            }

                            $i++;

                        } // end foreach
                        ?>

                        </table>

                    </td>
                </tr>


            <?php
            break;

            case 'tabend':

                echo '</table>'. "\n\n";
                echo '</div> <!-- #tab'.$counter.' -->'. "\n\n";
                $counter = $counter + 1;

            break;

            case 'notabend':

                echo '</table>'. "\n\n";

            break;

        } // end switch

    } // end foreach
    ?>

   </div> <!-- #tabs-wrap -->

<?php
}

function colabs_admin_db_fields($options, $colabs_table, $colabs_id) {
    global $wpdb;

    // gat all the admin fields
    $results = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ". $wpdb->prefix . $colabs_table . " WHERE ". $colabs_id ." = %d", $_GET['id'] ) );

    // If the pack has a type, check if it satisfies. 
    if( isset( $results->pack_type ) && strpos( $results->pack_type, "required_" ) === 0 ){
	$results->pack_satisfies_required = "required_";
    }else{
	$results->pack_satisfies_required = "";
    }

    ?>

    <table class="widefat fixed" id="tblspacer" style="width:850px;">

    <?php

    foreach ( $options as $value ) {

      if ( $results ) {

          // foreach ($results as $result):

          // check to prevent "Notice: Undefined property: stdClass::" error when php strict warnings is turned on
          if ( !isset($results->field_type) ) $field_type = ''; else $field_type = $results->field_type;
          if ( !isset($results->field_perm) ) $field_perm = ''; else $field_perm = $results->field_perm;

          switch($value['type']) {

            case 'title':
            ?>

                <thead>
                    <tr>
                        <th scope="col" width="200px"><?php echo $value['name'] ?></th><th scope="col">&nbsp;</th>
                    </tr>
                </thead>

            <?php

            break;

            case 'text':

            ?>

	       <tr id="<?php echo $value['id'] ?>_row" <?php if ($value['vis'] == '0') echo ' style="display:none;"'; ?>>
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp"><input name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" type="<?php echo $value['type'] ?>" style="<?php echo $value['css'] ?>" value="<?php echo $results->$value['id'] ?>" <?php if ($value['req']) { ?> class="required <?php if (!empty($value['altclass'])) echo $value['altclass'] ?>" <?php } ?><?php if ($value['min']) ?> minlength="<?php echo $value['min'] ?>" <?php if($value['id'] == 'field_name') { ?>readonly="readonly"<?php } ?> /><br /><small><?php echo $value['desc'] ?></small></td>
                </tr>

            <?php

            break;

            case 'select':

            ?>

               <tr id="<?php echo $value['id'] ?>_row">
                   <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                   <td class="forminp"><select <?php if ($value['js']) echo $value['js']; ?> <?php if(($field_perm == 1) || ($field_perm == 2)) { ?>DISABLED<?php } ?> name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" style="<?php echo $value['css'] ?>">

                       <?php foreach ( $value['options'] as $key => $val ) { ?>

                             <option value="<?php echo $key ?>"<?php if (isset($results->$value['id']) && $results->$value['id'] == $key) { ?> selected="selected" <?php $field_type_out = $field_type; } ?>><?php echo $val; ?></option>

                       <?php } ?>

                       </select><br />
                       <small><?php echo $value['desc'] ?></small>

                       <?php
                       // have to submit this field as a hidden value if perms are 1 or 2 since the DISABLED option won't pass anything into the $_POST
                       if ( ($field_perm == 1) || ($field_perm == 2) ) { ?><input type="hidden" name="<?php echo $value['id'] ?>" value="<?php echo $field_type_out; ?>" /><?php } ?>

                   </td>
               </tr>

            <?php

            break;

            case 'textarea':

            ?>

               <tr id="<?php echo $value['id'] ?>_row"<?php if($value['id'] == 'field_values') { ?> style="display: none;" <?php } ?>>
                   <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                   <td class="forminp"><textarea <?php if((($field_perm == 1) || ($field_perm == 2)) && ($value['id'] != 'field_tooltip') && $value['id'] != 'field_values') { ?>readonly="readonly"<?php } ?> name="<?php echo $value['id']?>" id="<?php echo $value['id'] ?>" style="<?php echo $value['css'] ?>"><?php echo $results->$value['id'] ?></textarea>
                       <br /><small><?php echo $value['desc'] ?></small></td>
               </tr>

            <?php

            break;

            case 'checkbox':
            ?>

                <tr id="<?php echo $value['id'] ?>_row">
                    <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                    <td class="forminp"><input type="checkbox" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" value="1" style="<?php echo $value['css']?>" <?php if($results->$value['id']) { ?>checked="checked"<?php } ?> />
                        <br /><small><?php echo $value['desc'] ?></small>
                    </td>
                </tr>

            <?php
            break;

            case 'cat_checklist':

            ?>

               <tr id="<?php echo $value['id'] ?>_row">
                   <td class="titledesc"><?php if ($value['tip']) { ?><a href="#" tip="<?php echo $value['tip'] ?>" tabindex="99"><div class="helpico"></div></a><?php } ?><?php echo $value['name'] ?>:</td>
                   <td class="forminp">
                       <div id="categorydiv">
                           <div  id="categories-all" style="<?php echo $value['css'] ?>">
                               <ul class="list:category categorychecklist form-no-clear" id="categorychecklist">

                                   <?php echo colabs_category_checklist( unserialize($results->form_cats),(colabs_exclude_cats($results->id)) ); ?>

                               </ul>
                           </div>
                       </div>
                       <br /><small><?php echo $value['desc'] ?></small>
                   </td>
               </tr>

            <?php

            break;


        } // end switch

      } // end $results

    } // endforeach

    ?>

    </table>

<?php
}

// creates the category checklist box
function colabs_category_checklist($checkedcats, $exclude = '') {

	if (empty($walker) || !is_a($walker, 'Walker'))
		$walker = new Walker_Category_Checklist;

	$args = array();

    if (is_array( $checkedcats ))
        $args['selected_cats'] = $checkedcats;
    else
        $args['selected_cats'] = array();

    $args['popular_cats'] = array();
    $categories = get_categories( array('hide_empty' => 0,
                                       'taxonomy' 	 => COLABS_TAX_CAT,
                                       'exclude' 	 => $exclude) );

	return call_user_func_array( array(&$walker, 'walk'), array($categories, 0, $args) );
}


// this grabs the cats that should be excluded
function colabs_exclude_cats ($id = NULL) {
    global $wpdb;

    $output = array();

    if ( $id )
        $sql = $wpdb->prepare( "SELECT form_cats FROM ". $wpdb->prefix ."colabs_ad_forms WHERE id != %s", $id );
    else
        $sql = $wpdb->prepare( "SELECT form_cats FROM ". $wpdb->prefix ."colabs_ad_forms" );

    $records = $wpdb->get_results( $sql );

    if ( $records ) :

        foreach ( $records as $record )
            $output[] = implode( ',',unserialize($record->form_cats) );

    endif;

    $exclude = colabs_unique_str( ',', (join( ',', $output )) );

    return $exclude;
}

function colabs_unique_str($separator, $str) {

    $str_arr = explode($separator, $str);
    $result = array_unique($str_arr);
    $unique_str = implode(',', $result);

    return $unique_str;
}
?>