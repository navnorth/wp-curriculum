<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $message, $type;

    if (isset($_REQUEST['settings-updated'])) {
        if (!current_user_can('manage_options')) {
            wp_die( "You don't have permission to access this page!" );
        }
    }
    
?>
<div class="wrap">
    
    <!--<div id="icon-themes" class="oer-logo"><img src="<?php echo esc_url(OER_URL) ?>images/wp-oer-admin-logo.png" /></div>-->
    <h2><?php _e("Settings - WP Curriculum", OERCURR_CURRICULUM_SLUG); ?></h2>
    <?php settings_errors(); ?>
     
    <?php
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'metadata';
    ?>
     
    <h2 class="nav-tab-wrapper">
                <a href="?post_type=oer-curriculum&page=oer_curriculum_settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e("General", OERCURR_CURRICULUM_SLUG); ?></a>
        <a href="?post_type=oer-curriculum&page=oer_curriculum_settings&tab=metadata" class="nav-tab <?php echo $active_tab == 'metadata' ? 'nav-tab-active' : ''; ?>"><?php _e("Metadata Fields", OERCURR_CURRICULUM_SLUG); ?></a>
        </h2>
    
    <?php
    switch ($active_tab) {
        case "metadata":
            oercurr_show_metadata_settings();
            break;
        case "general":
            oercurr_show_general_settings();
            break;
        default:
            break;
    }
    ?>
</div><!-- /.wrap -->
<div class="oer-plugin-footer">
    <div class="oer-plugin-info"><?php echo OERCURR_CURRICULUM_PLUGIN_NAME . " " . OERCURR_CURRICULUM_VERSION .""; ?></div>
    <div class="oer-plugin-link"><a href='https://www.wp-oer.com/' target='_blank'><?php _e("More Information", OERCURR_CURRICULUM_SLUG); ?></a></div>
    <div class="clear"></div>
</div>
<?php


function oercurr_show_general_settings(){    
    if (!is_admin()) exit;
    oercurr_save_general_setting(); ?>
    <div class="oercurr-plugin-body">
        <div class="oercurr-plugin-row">
            <div class="oer-row-left">Use the options below to update general plugin options.</div>
            <div class="oer-row-right"></div>
        </div>
        <div class="oercurr-plugin-row">
            <form method="post" enctype="multipart/form-data">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Option</th>
                            <th>Value</th>
                            <th>Enabled</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php    $_genset = json_decode(get_option('oer_curriculum_general_setting')); ?>
                            <tr>    
                                    <td>Curriculum Root Slug</td>
                                    <td><input type="text" name="oer_curriculum_general_setting[rootslug]" value="<? echo (isset($_genset->rootslug))? $_genset->rootslug: 'curriculum'; ?>"></td>
                                    <td>
                                        <input type="hidden" name="oer_curriculum_general_setting[rootslug_enabled]" value="0">
                                        <input type="checkbox" name="oer_curriculum_general_setting[rootslug_enabled]" value="1" <? echo (isset($_genset->rootslug_enabled) && $_genset->rootslug_enabled > 0)? 'checked': ''; ?> />
                                    </td>
                            </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="oer_curriculum_general_setting_submit" id="submit" class="button button-primary" value="Save General Options"></p></form>
            </form>
        </div>
    </div>
    <?php
}

function oercurr_save_general_setting(){
    $_forbidkey = array("oer_curriculum_general_setting_submit");
    global $pagenow;
    if ( 'edit.php' !== $pagenow || !current_user_can('edit_others_posts')) return $query;
    if (!isset( $_POST['oer_curriculum_general_setting'] )) return;                                            
    $_arr = array();            
    foreach ($_POST['oer_curriculum_general_setting'] as $key => $genset){
        if(!in_array($genset)) $_arr[$key] = $genset;
    }
    if(!get_option('oer_curriculum_general_setting')){
        add_option('oer_curriculum_general_setting', json_encode($_arr));
    }else{
            update_option('oer_curriculum_general_setting', json_encode($_arr));
    }
}



function oercurr_show_metadata_settings() {
    global $oer_curriculum_deleted_fields;
    $metas = oercurr_get_all_meta("oer-curriculum");
    $inquirysets = null;
    $labeldata = null;
    $metadata = null;
    
    foreach($metas as $met){
        if (strpos($met['option_name'],"_curmetset_label")!==false){
            $labeldata[] = $met['option_name'];
        }
        $metadata[] = $met['option_name'];
    }
    
    // Add Options for related Curriculum 1-3
    /*
    for($i=1;$i<=3;$i++){
        $metadata[] = $inquirysets[] = 'oer_curriculum_related_curriculum_'.$i;
    }
    */
    
    $meta = array_unique($metadata);
    $label = array_unique($labeldata);
    
    /*
    print_r( $meta );
    echo( '<br><br>' );
    print_r( $label );
    echo( '<br><br>' );
    */
    
    // Save Option
    if ($_POST){
        // Remove meta key enabled option
        /*
        foreach($metas as $met){
            if (strpos($met['meta_key'],"oer_")!==false || strpos($met['meta_key'],"oer_curriculum_oer_")!==false){
                delete_option($met['meta_key']."_enabled");
            }
        }
        foreach($inquirysets as $inquiryset){
            delete_option($inquiryset."_enabled");
        }
        */
        //print_r($_POST);
        oercurr_save_metadata_options($_POST);
    }
?>
<div class="oercurr-plugin-body">
    <div class="oercurr-plugin-row">
        <div class="oer-row-left">
            <?php _e("Use the options below to update metadata field options.", OER_SLUG); ?>
        </div>
        <div class="oer-row-right">
        </div>
    </div>
    <div class="oercurr-plugin-row">
        <form method="post" class="oer_settings_form" onsubmit="return lpInitialSettings(this);">
            <table class="table">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Label</th>
                        <th>Enabled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($label as $key) {
                        $label = "";
                        $enabled = "0";
                        $option_set = false;
                            if (get_option($key."_curmetset_label")){
                                $label = get_option($key."_label");
                                $option_set = true;
                            }else{
                                $label = get_option($key);
                            }
                            
                            $enb_key = str_replace("_label","_enable",$key);
                            $enabled = get_option($enb_key);
                            $enb_val = ($enabled=='checked')?'1':'0';    
                            /*
                            if (get_option($key))
                                $enabled = (get_option($key."_curmetset_enabled")=="1")?true:false;
                            elseif ($option_set==false)
                                $enabled = "1";
                            */
                            
                        if (!in_array($key,$oer_curriculum_deleted_fields)){ 
                        ?>
                        <tr>
                            <td><?php echo str_replace("_curmetset","",$key); ?></td>
                            <td><input type="text" name="<?php echo $key; ?>" value="<?php echo $label; ?>" /></td>
                            <td><input type="checkbox" class="oercurr-enabled-checkbox" name="<?php echo $enb_key; ?>" value="<?php echo $enb_val; ?>" <?php echo $enabled; ?>/></td>
                        </tr>
                        <?php
                        }
                    } ?>
                </tbody>
            </table>
            <?php submit_button("Save Metadata Options"); ?>
        </form>
    </div>
</div>
<?php
}
oercurr_display_loader();
