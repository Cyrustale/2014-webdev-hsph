<?php
/**
 * This is step 1 of 3 for the ad submission form
 *
 * @package Classifier
 * @subpackage New Ad
 * @author ColorLabs & Company
 *
 *
 */


global $current_user, $wpdb;

?>
<style type="text/css">
.form_step #getform, .form_step #step1, .form_step #chosenCategory {
    display: none;
}
</style>

  <div class="row main-container">

    <?php colabsthemes_before_submit(); ?>
    
    <!--div id="step1"></div><!--#step1-->
    
    <div class="entry-content">
      <h4><?php _e('Fill The Form','colabsthemes');?></h4>
      <?php echo get_option('colabs_ads_form_msg'); ?>
    </div>

    <div class="row form-submit-listing">
			<?php if ( !isset($_POST['cat'] ) || ($_POST['cat'] == '-1') )  :?>
			<form name="mainform" id="mainform" class="form_step" action="" method="post">
				<div class="col6">
					
          <div class="input-text">
            <label><?php _e('Cost Per Listing','colabsthemes');?>:</label>
            <?php colabs_cost_per_listing(); ?> 
          </div>
          <div class="input-select">
            <label><?php _e('Select Categories','colabsthemes'); ?>: <span class="colour">*</span></label>
            <div class="ad-categories">
                <div id="catlvl0">
                <?php
                
                if ( get_option('colabs_price_scheme') == 'category' && get_option('colabs_enable_paypal') == 'true' && get_option('colabs_ad_parent_posting') != 'false' ) {
                
                    colabs_dropdown_categories_prices('show_option_none='.__('Select one','colabsthemes').'&class=dropdownlist required&orderby=name&order=ASC&hide_empty=0&hierarchical=1&taxonomy='.COLABS_TAX_CAT.'&depth=1');
                
                } else {

                   wp_dropdown_categories('show_option_none='.__('Select one','colabsthemes').'&class=dropdownlist required&orderby=name&order=ASC&hide_empty=0&hierarchical=1&taxonomy='.COLABS_TAX_CAT.'&depth=1');
                
                }
                
                ?>
                </div><!-- /#catlvl0 -->
            </div><!-- /.ad-categories -->
            
          </div><!-- /.input-select -->
          <div id="ad-form-input" class="input-submit">
						<input style="display: none" type="submit" name="getcat" id="getcat" class="btn btn-primary" value="<?php _e('Go','colabsthemes'); ?>&rsaquo;&rsaquo;" />
					</div>
        </div>
        <!-- /.col6 -->
			</form>
			<?php else:?>
      <form name="mainform" id="mainform" class="form_step" action="" method="post" enctype="multipart/form-data">
				<div class="col6">
					
          <div class="input-text">
            <label><?php _e('Cost Per Listing','colabsthemes');?>:</label>
            <?php colabs_cost_per_listing(); ?> 
          </div>
          <div class="input-select">
            <label><?php _e('Select Categories','colabsthemes'); ?>: <span class="colour">*</span></label>
            <div class="ad-categories">
                <div id="catlvl0">
                <?php
                
                if ( get_option('colabs_price_scheme') == 'category' && get_option('colabs_enable_paypal') == 'true' && get_option('colabs_ad_parent_posting') != 'false' ) {
                
                    colabs_dropdown_categories_prices('show_option_none='.__('Select one','colabsthemes').'&class=dropdownlist required&orderby=name&order=ASC&hide_empty=0&hierarchical=1&taxonomy='.COLABS_TAX_CAT.'&depth=1&selected='.$_POST['cat']);
                
                } else {

                   wp_dropdown_categories('show_option_none='.__('Select one','colabsthemes').'&class=dropdownlist required&orderby=name&order=ASC&hide_empty=0&hierarchical=1&taxonomy='.COLABS_TAX_CAT.'&disabled=true&depth=0&selected='.$_POST['cat']); ?>
										<script type="text/javascript">
											console.log('<?php echo json_encode($_POST); ?>');
											jQuery('#cat').prop('disabled', true);
										</script>
									<?php
                }
                
                ?>
                </div><!-- /#catlvl0 -->
            </div><!-- /.ad-categories -->
            
          </div><!-- /.input-select -->
          <div class="input-select">
            <label><?php _e('Select Location','colabsthemes'); ?>: </label>
            <div class="ad-location">
                <div id="loclvl0">
                <?php
                   wp_dropdown_categories('show_option_none='.__('Select one','colabsthemes').'&class=dropdownlist&name=loc&orderby=name&order=ASC&hide_empty=0&hierarchical=1&taxonomy='.COLABS_TAX_LOC.'&depth=0');
                ?>
                </div><!-- /#loclvl0 -->
            </div><!-- /.ad-location -->
          </div><!-- /.input-select -->
          
        </div>
        <!-- /.col6 -->
        <div class="col6">
					<?php echo colabs_show_form( $_POST['cat'] ); ?>
          
        
          <div id="ad-form-input" class="input-submit">
            <input style="display:block" type="submit" name="step1" id="step1" class="btn btn-primary" value="<?php _e('Continue &rsaquo;&rsaquo;','colabsthemes'); ?>" />
            <div id="chosenCategory"><input id="cat" name="cat" type="input" value="-1" /><input id="loc" name="loc" type="input" value="-1" /></div>
          </div>          

        </div>
        <!-- /.col6 -->

        <input type="hidden" id="cat" name="catid" value="<?php echo $_POST['cat']; ?>" />
        <input type="hidden" id="fid" name="fid" value="<?php if(isset($_POST['fid'])) echo $_POST['fid']; ?>" />
        <input type="hidden" id="oid" name="oid" value="<?php echo $order_id; ?>" />

      </form>
      <?php endif;?>  
    </div>
    <!-- /.form-submit-listing -->

    <?php colabsthemes_after_submit(); ?>
  
  </div>
  <!-- /.main-container -->
