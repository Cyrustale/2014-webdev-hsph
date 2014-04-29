<?php
$options_new_form = array (

    array( 'type' => 'notab'),

	array(	'name' => __('New Form', 'colabsthemes'),
                'type' => 'title'),

		array(  'name' => __('Form Name', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('Create a form name that best describes what category or categories this form will be used for. (i.e. Auto Form, Clothes Form, General Form, etc). It will not be visible on your site.','colabsthemes'),
                        'id' => 'form_label',
                        'css' => 'min-width:400px;',
                        'type' => 'text',
                        'vis' => '',
                        'req' => '1',
                        'min' => '5',
                        'std' => ''),

                array(  'name' => __('Form Description','colabsthemes'),
                        'desc' => '',
                        'tip' => __('Enter a description of your new form layout. It will not be visible on your site.','colabsthemes'),
                        'id' => 'form_desc',
                        'css' => 'width:400px;height:100px;',
                        'type' => 'textarea',
                        'vis' => '',
                        'req' => '1',
                        'min' => '5',
                        'std' => ''),

                array(  'name' => __('Available Categories', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('Select the categories you want this form to be displayed for. Categories not listed are being used on a different form layout. You can only have one category assigned to each form layout. Any unselected categories will use the default ad form.','colabsthemes'),
                        'id' => 'post_category[]',
                        'css' => '',
                        'type' => 'cat_checklist',
                        'vis' => '',
                        'req' => '1',
                        'std' => ''),

                array(  'name' => __('Status', 'colabsthemes'),
                        'desc' => '',
                        'tip' => __('If you do not want this new form live on your site yet, select inactive.','colabsthemes'),
                        'id' => 'form_status',
                        'css' => 'min-width:100px;',
                        'std' => '',
                        'js' => '',
                        'vis' => '',
                        'req' => '1',
                        'type' => 'select',
                        'options' => array( 'active'   => __('Active', 'colabsthemes'),
                                            'inactive' => __('Inactive', 'colabsthemes'))),

    array( 'type' => 'notabend'),

);

function colabs_forms_editor_admin_options() {
	if ( !current_user_can('manage_options') ) return;
	add_submenu_page( 'colabsthemes', __('Forms Editor','colabsthemes'), __('Forms Editor','colabsthemes'), 'manage_options', 'layouts', 'colabs_forms_editor' );
}
add_action('admin_menu', 'colabs_forms_editor_admin_options');

function colabs_forms_editor() {
    global $options_new_form, $wpdb, $current_user;

    get_currentuserinfo();

    // check to prevent php "notice: undefined index" msg when php strict warnings is on
    if ( isset($_GET['action']) ) $theswitch = $_GET['action']; else $theswitch ='';
	?>

	<script type="text/javascript">
	/* <![CDATA[ */
	/* initialize the form validation */
	jQuery(document).ready(function($) {
		$("#mainform").validate({errorClass: "invalid"});
	});
	/* ]]> */
    </script>

	<?php
    switch ( $theswitch ) {

    case 'addform':
    ?>

        <div class="wrap">
            <div class="icon32" id="icon-themes"><br/></div>
            <h2><?php _e('New Form Layout','colabsthemes') ?></h2>

            <?php colabs_admin_info_box(); ?>

        <?php
        // check and make sure the form was submitted and the hidden fcheck id matches the cookie fcheck id
        if ( isset($_POST['submitted']) ) {

            if ( !isset($_POST['post_category']) )
                wp_die( '<p style="color:red;">' .__("Error: Please select at least one category. <a href='#' onclick='history.go(-1);return false;'>Go back</a>",'colabsthemes') .'</p>' );

	    // @todo Change to Insert
            $insert = $wpdb->prepare( "INSERT INTO " . $wpdb->prefix . "colabs_ad_forms" .
                    " (form_name, form_label, form_desc, form_cats, form_status, form_owner, form_created) " .
                    "VALUES ( %s, %s, %s, %s, %s, %s, %s)",
                    colabsthemes_clean(colabs_make_custom_name($_POST['form_label'])),
                    colabsthemes_clean($_POST['form_label']),
                    colabsthemes_clean($_POST['form_desc']),
                    serialize($_POST['post_category']),
                    colabsthemes_clean($_POST['form_status']),
                    colabsthemes_clean($_POST['form_owner']),
                    gmdate('Y-m-d H:i:s')
                );

            $results = $wpdb->query( $insert );


            if ( $results ) {
                         ?>

                <p style="text-align:center;padding-top:50px;font-size:22px;"><?php _e('Creating your form.....','colabsthemes') ?><br /><br /><img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" /></p>
                <meta http-equiv="refresh" content="0; URL=?page=layouts">

            <?php
            } // end $results

        } else {
        ?>

            <form method="post" id="mainform" action="">

                <?php echo colabs_admin_fields($options_new_form); ?>

                <p class="submit"><input class="btn button-primary" name="save" type="submit" value="<?php _e('Create New Form','colabsthemes') ?>" />&nbsp;&nbsp;&nbsp;
                <input name="cancel" type="button" onClick="location.href='?page=layouts'" value="<?php _e('Cancel','colabsthemes') ?>" /></p>
                <input name="submitted" type="hidden" value="yes" />
                <input name="form_owner" type="hidden" value="<?php echo $current_user->user_login ?>" />

            </form>

        <?php
        } // end isset $_POST
        ?>

        </div><!-- end wrap -->

    <?php
    break;


    case 'editform':
    ?>

        <div class="wrap">
        <div class="icon32" id="icon-themes"><br/></div>
        <h2><?php _e('Edit Form Properties','colabsthemes') ?></h2>

        <?php
        if ( isset($_POST['submitted']) && $_POST['submitted'] == 'yes' ) {

            if ( !isset($_POST['post_category']) )
                wp_die( '<p style="color:red;">' .__("Error: Please select at least one category. <a href='#' onclick='history.go(-1);return false;'>Go back</a>",'colabsthemes') .'</p>' );


	    // @todo Change to Update
            $update = $wpdb->prepare( "UPDATE " . $wpdb->prefix . "colabs_ad_forms SET" .
                            " form_label    = %s," .
                            " form_desc     = %s," .
                            " form_cats     = %s," .
                            " form_status   = %s," .
                            " form_owner    = %s," .
                            " form_modified = %s" .
                            " WHERE id      = %s",
                            colabsthemes_clean($_POST['form_label']),
                            colabsthemes_clean($_POST['form_desc']),
                            serialize($_POST['post_category']),
                            colabsthemes_clean($_POST['form_status']),
                            $_POST['form_owner'],
                            gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ) ),
                            $_GET['id']);

            $results = $wpdb->get_row( $update );

            ?>

            <p style="text-align:center;padding-top:50px;font-size:22px;"><?php _e('Saving your changes.....','colabsthemes') ?><br /><br /><img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" /></p>
            <meta http-equiv="refresh" content="0; URL=?page=layouts">

        <?php
        } else {
        ?>

            <form method="post" id="mainform" action="">

            <?php echo colabs_admin_db_fields($options_new_form, 'colabs_ad_forms', 'id'); ?>

                <p class="submit"><input class="btn button-primary" name="save" type="submit" value="<?php _e('Save changes','colabsthemes') ?>" />&nbsp;&nbsp;&nbsp;
                <input name="cancel" type="button" onClick="location.href='?page=layouts'" value="<?php _e('Cancel','colabsthemes') ?>" /></p>
                <input name="submitted" type="hidden" value="yes" />
                <input name="form_owner" type="hidden" value="<?php echo $current_user->user_login ?>" />

            </form>

        <?php
        } // end isset $_POST
        ?>

        </div><!-- end wrap -->

    <?php
    break;


    /**
    * Form Builder Page
    * Where fields are added to form layouts
    */

    case 'formbuilder':
    ?>

        <div class="wrap">
        <div class="icon32" id="icon-themes"><br/></div>
        <h2><?php _e('Edit Form Layout','colabsthemes') ?></h2>
				<style>
					.widefat td {
							padding: 10px 8px;
					}
					textarea, input[type="text"], input[type="password"], input[type="file"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="url"], select {
							width: 100%;
					}
					
					div.fields-panel {
							overflow: auto;
							width: 400px;
					}
					tbody.sortable tr.even:hover {
							cursor: move;
					}
				</style>
        <?php colabs_admin_info_box(); ?>

        <?php
        // add fields to page layout on left side
        if ( isset($_POST['field_id']) ) {

            // take selected checkbox array and loop through ids
            foreach ( $_POST['field_id'] as $value ) {

		// @todo Change to Insert
                $insert = $wpdb->prepare( "INSERT INTO " . $wpdb->prefix .
                        "colabs_ad_meta (form_id, field_id) VALUES ( %s, %s)",
                        colabsthemes_clean($_POST['form_id']),
                        colabsthemes_clean($value)
                );

                $results = $wpdb->query( $insert );

            } // end foreach

        } // end $_POST



        // update form layout positions and required fields on left side.
        if ( isset($_POST['formlayout']) ) {

            // loop through the post array and update the required checkbox and field position
            foreach ( $_POST as $key => $value ) :

                // since there's some $_POST values we don't want to process, only give us the
                // numeric ones which means it contains a meta_id and we want to update it
                if ( is_numeric($key) ) {

                    // quick hack to prevent php "notice: undefined index:" msg when php strict warnings is on
                    if ( !isset($value['field_req']) ) $value['field_req'] = '';
                    if ( !isset($value['field_search']) ) $value['field_search'] = '';

                    $update = "UPDATE " . $wpdb->prefix . "colabs_ad_meta SET "
                            . "field_req = '" . $wpdb->escape(colabsthemes_clean($value['field_req'])) . "', "
							. "field_search = '" . $wpdb->escape(colabsthemes_clean($value['field_search'])) . "' "
                            . "WHERE meta_id ='" . $wpdb->escape($key) ."'";

                    $wpdb->query( $update );

                } // end if_numeric

            endforeach; // end for each

            echo '<p class="info">'. __('Your changes have been saved.', 'colabsthemes') .'</p>';

        } // end isset $_POST


        // check to prevent php "notice: undefined index" msg when php strict warnings is on
        if ( isset($_GET['del_id']) ) $theswitch = $_GET['del_id']; else $theswitch ='';


        // Remove items from form layout
        if ( $theswitch ) $wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "colabs_ad_meta WHERE meta_id = %s", $_GET['del_id'] ) );


	// @todo Change to Update
        //update the forms modified date
        $update = $wpdb->prepare( "UPDATE " . $wpdb->prefix . "colabs_ad_forms SET" .
                " form_modified = %s WHERE id = %s",
                gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ) ),
                $_GET['id']
        );

        $results = $wpdb->get_row( $update );

        ?>


        <table>
            <tr style="vertical-align:top;">
                <td style="width:800px;padding:0 20px 0 0;">


                <h3><?php _e('Form Name','colabsthemes') ?> - <?php echo ucfirst(urldecode($_GET['title'])) ?>&nbsp;&nbsp;&nbsp;&nbsp;<span id="loading"></span></h3>

                <form method="post" id="mainform" action="">

                    <table class="widefat">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2"><?php _e('Form Preview','colabsthemes') ?></th>
								<th scope="col" style="width:75px;text-align:center;" title="<?php _e('Show field in the category refine search sidebar','colabsthemes') ?>"><?php _e('Advanced Search','colabsthemes') ?></th>
                                <th scope="col" style="width:75px;text-align:center;"><?php _e('Required','colabsthemes') ?></th>
                                <th scope="col" style="width:75px;text-align:center;"><?php _e('Remove','colabsthemes') ?></th>
                            </tr>
                        </thead>



                        <tbody class="sortable">

                        <?php

                            // If this is the first time this form is being customized then auto
                            // create the core fields and put in colabs_meta db table
                            echo colabs_add_core_fields( $_GET['id'] );


                            // Then go back and select all the fields assigned to this
                            // table which now includes the added core fields.
                            $sql = $wpdb->prepare( "SELECT f.field_label, f.field_name, f.field_type, f.field_values, f.field_perm, m.meta_id, m.field_pos, m.field_search, m.field_req, m.form_id "
                                 . "FROM ". $wpdb->prefix . "colabs_ad_fields f "
                                 . "INNER JOIN ". $wpdb->prefix . "colabs_ad_meta m "
                                 . "ON f.field_id = m.field_id "
                                 . "WHERE m.form_id = %s "
                                 . "ORDER BY m.field_pos asc",
                                 $_GET['id']
                            );

                            $results = $wpdb->get_results( $sql );

                            if ( $results ) {

                                echo colabs_admin_formbuilder( $results );

                            } else {

                        ?>

                        <tr>
                            <td colspan="5" style="text-align: center;"><p><br/><?php _e('No fields have been added to this form layout yet.','colabsthemes') ?><br/><br/></p></td>
                        </tr>

                        <?php
                            } // end $results
                            ?>

                        </tbody>

                    </table>

                    <p class="submit">
                        <input class="btn button-primary" name="save" type="submit" value="<?php _e('Save Changes','colabsthemes') ?>" />&nbsp;&nbsp;&nbsp;
                        <input name="cancel" type="button" onClick="location.href='?page=layouts'" value="<?php _e('Cancel','colabsthemes') ?>" />
                        <input name="formlayout" type="hidden" value="yes" />
                        <input name="form_owner" type="hidden" value="<?php $current_user->user_login ?>" />
                    </p>
                </form>

                </td>
                <td>

                <h3><?php _e('Available Fields','colabsthemes') ?></h3>

                <form method="post" id="mainform" action="">


                <div class="fields-panel">

                    <table class="widefat">
                        <thead>
                            <tr>
                                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"/></th>
                                <th scope="col"><?php _e('Field Name','colabsthemes') ?></th>
                                <th scope="col"><?php _e('Type','colabsthemes') ?></th>
                            </tr>
                        </thead>


                        <tbody>

                        <?php
                        // Select all available fields not currently on the form layout.
                        // Also exclude any core fields since they cannot be removed from the layout.
                        $sql = $wpdb->prepare( "SELECT f.field_id,f.field_label,f.field_type "
                             . "FROM ". $wpdb->prefix . "colabs_ad_fields f "
                             . "WHERE f.field_id "
                             . "NOT IN (SELECT m.field_id "
                             . "FROM ". $wpdb->prefix . "colabs_ad_meta m "
                             . "WHERE m.form_id =  %s) "
                             . "AND f.field_perm <> '1'",
                             $_GET['id']);

                        $results = $wpdb->get_results( $sql );

                        if ( $results ) {

                            foreach ( $results as $result ) {
                        ?>

                        <tr class="even">
                            <th class="check-column" scope="row"><input type="checkbox" value="<?php echo $result->field_id; ?>" name="field_id[]"/></th>
                            <td><?php echo $result->field_label; ?></td>
                            <td><?php echo $result->field_type; ?></td>
                        </tr>

                        <?php
                            } // end foreach

                        } else {
                        ?>

                        <tr>
                            <td colspan="4" style="text-align: center;"><p><br/><?php _e('No fields are available.','colabsthemes') ?><br/><br/></p></td>
                        </tr>

                        <?php
                        } // end $results
                        ?>

                        </tbody>

                    </table>

                </div>

                    <p class="submit"><input class="btn button-primary" name="save" type="submit" value="<?php _e('Add Fields to Form Layout','colabsthemes') ?>" /></p>
                        <input name="form_id" type="hidden" value="<?php echo $_GET['id']; ?>" />
                        <input name="submitted" type="hidden" value="yes" />


                </form>

                </td>
            </tr>
        </table>

    </div><!-- /wrap -->

    <?php

    break;



    case 'delete':

        // delete the form based on the form id
        colabs_delete_form($_GET['id']);
        ?>
        <p style="text-align:center;padding-top:50px;font-size:22px;"><?php _e('Deleting form layout.....','colabsthemes') ?><br /><br /><img src="<?php echo bloginfo('template_directory') ?>/images/loader.gif" alt="" /></p>
        <meta http-equiv="refresh" content="0; URL=?page=layouts">

    <?php
    break;

    default:

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "colabs_ad_forms ORDER BY id desc" ) );

    ?>

        <div class="wrap">
        <div class="icon32" id="icon-themes"><br/></div>
        <h2><?php _e('Form Layouts','colabsthemes') ?>&nbsp;<a class="button add-new-h2" href="?page=layouts&amp;action=addform"><?php _e('Add New','colabsthemes') ?></a></h2>

        <?php colabs_admin_info_box(); ?>

        <p class="admin-msg"><?php _e('Form layouts allow you to create your own custom ad submission forms. Each form is essentially a container for your fields and can be applied to one or all of your categories. If you do not create any form layouts, the default one will be used. To change the default form, create a new form layout and apply it to all categories.','colabsthemes') ?></p>

        <table id="tblspacer" class="widefat fixed">

            <thead>
                <tr>
                    <th scope="col" style="width:35px;">&nbsp;</th>
                    <th scope="col"><?php _e('Name','colabsthemes') ?></th>
                    <th scope="col"><?php _e('Description','colabsthemes') ?></th>
                    <th scope="col"><?php _e('Categories','colabsthemes') ?></th>
                    <th scope="col" style="width:150px;"><?php _e('Modified','colabsthemes') ?></th>
                    <th scope="col" style="width:75px;"><?php _e('Status','colabsthemes') ?></th>
                    <th scope="col" style="text-align:center;width:100px;"><?php _e('Actions','colabsthemes') ?></th>
                </tr>
            </thead>

            <?php
            if ( $results ) {
              $rowclass = '';
              $i=1;
            ?>

              <tbody id="list">

            <?php
                foreach ( $results as $result ) {

                $rowclass = 'even' == $rowclass ? 'alt' : 'even';
              ?>

                <tr class="<?php echo $rowclass ?>">
                    <td style="padding-left:10px;"><?php echo $i ?>.</td>
                    <td><a href="?page=layouts&amp;action=editform&amp;id=<?php echo $result->id ?>"><strong><?php echo $result->form_label ?></strong></a></td>
                    <td><?php echo $result->form_desc ?></td>
                    <td><?php echo colabs_match_cats( unserialize($result->form_cats) ) ?></td>
                    <td><?php echo mysql2date( get_option('date_format') .' '. get_option('time_format'), $result->form_modified ) ?> <?php _e('by','colabsthemes') ?> <?php echo $result->form_owner; ?></td>
                    <td><?php echo ucfirst( $result->form_status ) ?></td>
                    <td style="text-align:center"><a href="?page=layouts&amp;action=formbuilder&amp;id=<?php echo $result->id ?>&amp;title=<?php echo urlencode($result->form_label) ?>"><img src="<?php echo bloginfo('template_directory') ?>/images/layout_add.png" alt="<?php echo _e('Edit form layout','colabsthemes') ?>" title="<?php echo _e('Edit form layout','colabsthemes') ?>" /></a>&nbsp;&nbsp;&nbsp;
                        <a href="?page=layouts&amp;action=editform&amp;id=<?php echo $result->id ?>"><img src="<?php echo bloginfo('template_directory') ?>/images/edit.png" alt="<?php echo  _e('Edit form properties','colabsthemes') ?>" title="<?php echo _e('Edit form properties','colabsthemes') ?>" /></a>&nbsp;&nbsp;&nbsp;
                        <a onclick="return confirmBeforeDelete();" href="?page=layouts&amp;action=delete&amp;id=<?php echo $result->id ?>"><img src="<?php echo bloginfo('template_directory') ?>/images/cross.png" alt="<?php echo _e('Delete form layout','colabsthemes') ?>" title="<?php echo _e('Delete form layout','colabsthemes') ?>" /></a></td>
                </tr>

              <?php

                $i++;

                } // end for each
              ?>

              </tbody>

            <?php

            } else {

            ?>

                <tr>
                    <td colspan="7"><?php _e('No form layouts found.','colabsthemes') ?></td>
                </tr>

            <?php
            } // end $results
            ?>

            </table>


        </div><!-- end wrap -->

    <?php
    } // end switch
    ?>
    <script type="text/javascript">
        /* <![CDATA[ */
            function confirmBeforeDelete() { return confirm("<?php _e('Are you sure you want to delete this?', 'colabsthemes'); ?>"); }
            function confirmBeforeRemove() { return confirm("<?php _e('Are you sure you want to remove this?', 'colabsthemes'); ?>"); }
        /* ]]> */
    </script>

<?php

}

// find a category match and then output it
function colabs_match_cats($form_cats) {
    global $wpdb;
    $out = array();

    $terms = get_terms( COLABS_TAX_CAT, array(
        'include' => $form_cats
    ));

    if ( $terms ) :
		
        foreach ( $terms as $term ) {
            $out[] = '<a href="edit-tags.php?action=edit&taxonomy='.COLABS_TAX_CAT.'&post_type='.COLABS_POST_TYPE.'&tag_ID='. $term->term_id .'">'. $term->name .'</a>';
        }

    endif;

    return join( ', ', $out );
}

// this creates the default fields when a form layout is created
function colabs_add_core_fields($form_id) {
	global $wpdb;

    // check to see if any rows already exist for this form. If so, don't insert any data
    $wpdb->get_results( $wpdb->prepare( "SELECT form_id FROM " . $wpdb->prefix . "colabs_ad_meta WHERE form_id  = %s", $form_id ) );

    // no fields yet so let's add the defaults
    if ( $wpdb->num_rows == 0 ) {

        $insert = "INSERT INTO " . $wpdb->prefix . "colabs_ad_meta" .
        " (form_id, field_id, field_req, field_pos) " .
        "VALUES ('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('1'). "','" // post_title
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('1')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('2'). "','" // colabs_price
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('2')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('3'). "','" // colabs_street
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('3')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('4'). "','" // colabs_city
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('4')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('5'). "','" // colabs_state
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('5')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('6'). "','" // colabs_country
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('6')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('7'). "','" // colabs_zipcode
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('7')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('8'). "','" // tags_input
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('8')
          . "'),"
          . "('"
          . $wpdb->escape($form_id). "','"
          . $wpdb->escape('9'). "','" // post_content
          . $wpdb->escape('1'). "','"
          . $wpdb->escape('9')
          . "')";

        $results = $wpdb->query( $insert );

    }
}

// delete the custom form and the meta custom field data
function colabs_delete_form($form_id) {
    global $wpdb;

	$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "colabs_ad_forms WHERE id = %s", $form_id ) );
	$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "colabs_ad_meta WHERE form_id = %s", $form_id ) );
}

function colabs_admin_formbuilder($results) {
	global $wpdb;

	foreach ( $results as $result ) :
	?>

		<tr class="even" id="<?php echo $result->meta_id; ?>"><!-- id needed for jquery sortable to work -->
			<td style="min-width:100px;"><?php echo $result->field_label; ?></td>
			<td>

		<?php

		switch ( $result->field_type ) {

		case 'text box':
		?>

			<input name="<?php echo $result->field_name; ?>" type="text" style="min-width:200px;" value="" disabled />

		<?php
		break;

		case 'text area':

		?>

			<textarea rows="4" cols="23" disabled></textarea>

		<?php
		break;

		case 'radio':

			$options = explode( ',', $result->field_values );
			foreach ( $options as $label ) {
			?>
				<input type="radio" name="radiobutton" value="" disabled />&nbsp;<?php echo $label; ?><br />

		<?php
			}
		break;

		case 'checkbox':

			$options = explode( ',', $result->field_values );
			foreach ( $options as $label ) {
			?>
				<input type="checkbox" name="checkbox" value="" disabled />&nbsp;<?php echo $label; ?><br />

		<?php
			}
		break;

		default: // used for drop-downs, radio buttons, and checkboxes
		?>

			<select name="dropdown">

			<?php
			$options = explode( ',', $result->field_values );

			foreach ( $options as $option ) {
			?>

				<option style="min-width:177px" value="<?php echo $option; ?>" disabled><?php echo $option; ?></option>

			<?php
			}
			?>

			</select>

		<?php

		} //end switch
		?>

			</td>

			<td style="text-align:center;">

			    <?php
			    // only show the advanced search checkbox for price, city, and zipcode since they display the sliders
				// all other text fields are not intended for advanced search use
				$ad_search = '';
				if ( $result->field_name == 'colabs_price' || $result->field_name == 'colabs_city' || $result->field_name == 'colabs_zipcode' )
                    $ad_search = '';
				elseif ( $result->field_perm == 1 || $result->field_type == 'text area' || $result->field_type == 'text box' )
				    $ad_search = 'disabled="disabled"';
				?>

				<input type="checkbox" name="<?php echo $result->meta_id; ?>[field_search]" id="" <?php if ( $result->field_search ) echo 'checked="yes"' ?> <?php if ( $result->field_search ) echo 'checked="yes"' ?> <?php echo $ad_search; ?> value="1" style="" />

			</td>

			<td style="text-align:center;">

				<input type="checkbox" name="<?php echo $result->meta_id; ?>[field_req]" id="" <?php if ( $result->field_req ) echo 'checked="yes"' ?> <?php if ( $result->field_req ) echo 'checked="yes"' ?> <?php if ( $result->field_perm == 1 ) echo 'disabled="disabled"'; ?> value="1" style="" />
				<?php if ($result->field_perm == 1) { ?>
					<input type="hidden" name="<?php echo $result->meta_id; ?>[field_req]" checked="yes" value="1" />
				<?php } ?>

			</td>

			<td style="text-align:center;">

				<input type="hidden" name="id[]" value="<?php echo $result->meta_id; ?>" />
				<input type="hidden" name="<?php echo $result->meta_id; ?>[id]" value="<?php echo $result->meta_id; ?>" />

				<?php if ( $result->field_perm == 1 ) { ?>
				<img src="<?php bloginfo('template_directory'); ?>/images/remove-row-gray.png" alt="<?php  _e('Cannot remove from layout','colabsthemes') ?>" title="<?php  _e('Cannot remove from layout','colabsthemes') ?>" />
				<?php } else { ?>
				<a onclick="return confirmBeforeRemove();" href="?page=layouts&amp;action=formbuilder&amp;id=<?php echo $result->form_id ?>&amp;del_id=<?php echo $result->meta_id ?>&amp;title=<?php echo urlencode($_GET['title']) ?>"><img src="<?php bloginfo('template_directory'); ?>/images/remove-row.png" alt="<?php  _e('Remove from layout','colabsthemes') ?>" title="<?php  _e('Remove from layout','colabsthemes') ?>" /></a>
				<?php } ?>

			</td>
		</tr>

	<?php
	endforeach;

}

add_action('admin_head', 'colabs_ajax_sortable_js');

function colabs_ajax_sortable_js() {
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

	// Return a helper with preserved width of cells
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			jQuery(this).width(jQuery(this).width());
			//ui.placeholder.html('<!--[if IE]><td>&nbsp;</td><![endif]-->');
		});
		return ui;
	};

	jQuery("tbody.sortable").sortable({
		helper: fixHelper,
		opacity: 0.7,
		cursor: 'move',
		// connectWith: 'table.widefat tbody',
		placeholder: 'ui-placeholder',
		forcePlaceholderSize: true, 
		items: 'tr',
		update: function() {
			var results = jQuery("tbody.sortable").sortable("toArray"); // pass in the array of row ids based off each tr css id
			
			var data = { // pass in the action
			action: 'colabs_ajax_update',
			rowarray: results
			};

			jQuery("span#loading").html('<img src="<?php echo bloginfo('template_directory') ?>/images/ajax-loading.gif" />');
			jQuery.post(ajaxurl, data, function(theResponse){
				jQuery("span#loading").html(theResponse);
			}); 															 
		}	
	}).disableSelection();

 
});

</script>
<?php
}

// db update function for the column sort ajax feature
add_action('wp_ajax_cp_ajax_update', 'colabs_ajax_sort_callback');

function colabs_ajax_sort_callback() {
	global $wpdb;
	
	$counter = 1;
	foreach ($_POST['rowarray'] as $value) {		
		$wpdb->update($wpdb->prefix . "colabs_ad_meta",
			array(
				"field_pos" => $counter
			),
			array(
				"meta_id" => $value
			)
		);
		$counter = $counter + 1;	
	}	
	die();
}

function colabs_load_admin_scripts() {

    wp_register_script('jquery-ui-sortable', get_bloginfo('template_directory').'/includes/js/jquery-ui/jquery-ui-1.8.5.sortonly.min.js', array('jquery-ui-core'));
    wp_register_script('jquery-ui-draggable', get_bloginfo('template_directory').'/includes/js/jquery-ui/jquery-ui-1.8.5.draggable.min.js', array('jquery-ui-core'));
    wp_register_script('jquery-ui-droppable', get_bloginfo('template_directory').'/includes/js/jquery-ui/jquery-ui-1.8.5.droppable.min.js', array('jquery-ui-draggable'));

    //TODO: For now we call these on all admin pages because of some javascript errors, however it should be registered per admin page (like wordpress does it)
    wp_enqueue_script('jquery-ui-sortable'); //this script has issues on the page edit.php?post_type=ad_listing
  
}


add_action('admin_enqueue_scripts', 'colabs_load_admin_scripts');
?>