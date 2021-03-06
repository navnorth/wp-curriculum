<?php
/*
 Plugin Name:        OER Curriculum
 Plugin URI:         https://www.wp-oer.com/curriculum
 Description:        Manage and display collections of Open Educational Resources in lesson plans or curriculums with alignment to Common Core State Standards.
 Version:            0.5.0
 Requires at least:  4.4
 Requires PHP:       7.4
 Author:             Navigation North
 Author URI:         https://www.navigationnorth.com
 Text Domain:        oer-curriculum
 Domain Path:        /languages/
 License:            GPL3
 License URI:        https://www.gnu.org/licenses/gpl-3.0.html

 Copyright (C) 2021 Navigation North

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//defining the url,path and slug for the plugin
define( 'OERCURR_CURRICULUM_URL', plugin_dir_url(__FILE__) );
define( 'OERCURR_CURRICULUM_PATH', plugin_dir_path(__FILE__) );
define( 'OERCURR_CURRICULUM_SLUG','oer-curriculum' );
define( 'OERCURR_CURRICULUM_FILE',__FILE__);
// Plugin Name and Version
define( 'OERCURR_CURRICULUM_PLUGIN_NAME', 'OER Curriculum Plugin' );
define( 'OERCURR_CURRICULUM_ADMIN_PLUGIN_NAME', 'OER Curriculum Plugin');
define( 'OERCURR_CURRICULUM_VERSION', '0.5.0' );

include_once(OERCURR_CURRICULUM_PATH.'includes/oer-curriculum-functions.php');
include_once(OERCURR_CURRICULUM_PATH.'includes/init.php');

require_once(OERCURR_CURRICULUM_PATH.'includes/blocks/curriculum-block/init.php');
require_once(OERCURR_CURRICULUM_PATH.'includes/blocks/curriculum-featured-block/init.php');

global $oer_curriculum_default_structure;
global $oer_convert_info;
global $oer_curriculum_deleted_fields;
global $root_slug;
$oer_curriculum_default_structure = array(
    'oer_curriculum_authors_order',
    'oer_curriculum_standard_order',
    'oer_curriculum_iq',
    'oer_curriculum_required_materials',
    'oer_curriculum_additional_sections',
    'oer_curriculum_primary_resources',
    // 'oer_curriculum_custom_editor_teacher_background',
    // 'oer_curriculum_custom_editor_student_background',
    //'oer_curriculum_custom_editor_historical_background',
    'oer_curriculum_oer_materials',
    //'oer_curriculum_add_module'
);

$oer_curriculum_deleted_fields = array(
    'oer_curriculum_oer_materials',
    'oer_curriculum_custom_editor_6',
    'oer_curriculum_vocabulary_list_title_6',
    'oer_curriculum_vocabulary_details_6',
    'oer_curriculum_custom_editor_7',
    'oer_curriculum_custom_text_list_7',
    'oer_curriculum_custom_text_list_8',
    'oer_curriculum_oer_materials_list_8',
    'oer_curriculum_oer_materials_list_9',
    'oer_curriculum_custom_text_list_6',
    'oer_curriculum_vocabulary_list_title_7',
    'oer_curriculum_vocabulary_details_7',
    'oer_curriculum_vocabulary_list_title_8',
    'oer_curriculum_vocabulary_details_8',
    'oer_curriculum_vocabulary_list_title_9',
    'oer_curriculum_vocabulary_details_9'
);

$oer_convert_info = true;
$root_slug = oercurr_retrieve_rootslug();
/**
 * Parent plugin (WP OER) required to activate OER Curriculum
 * Check if WP OER plugin already installed or not
 * If WP OER not installed then show the error message
 * And stop the installation process of OER Curriculum plugin
 */
register_activation_hook( __FILE__, 'oercurr_check_parent_plugin' );
function oercurr_check_parent_plugin()
{
    // Require parent plugin
    if( !current_user_can( 'activate_plugins' )){
        wp_die('Sorry, but you don\'t have enough permission to install this plugin. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }else{
      if (!defined('OER_ADMIN_PLUGIN_NAME')) {
        wp_die('This plugin requires Wordpress <a href="https://wordpress.org/plugins/wp-oer/" target="_new">Open Educational Resources (OER)</a> Plugin. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
      }
    }
}

/**
 * Runs only when the plugin is activated.
 * @since 0.1.0
 */
function oercurr_plugin_activate()
{
    //Activation code
}
register_activation_hook( __FILE__, 'oercurr_plugin_activate' );

/**
 * Admin Notice on Activation.
 * @since 0.1.0
 */
add_action( 'admin_notices', 'oercurr_plugin_activation_notice');
function oercurr_plugin_activation_notice()
{
    global $post;
    if(
        (isset($post->post_type) && $post->post_type=='oer-curriculum') &&
        !get_option('oer_curriculum_setup_notification')
    )
    {?>
        <div class="notice notice-success is-dismissible" id="oer-curriculum-dismissible">
            <p>Thank you for installing the <strong>OER Curriculum</strong> plugin.</p>
        </div>
    <?php }

}

/**
 * Filter for adding Template for Plugin.
 * @since 0.1.0
 * @param $single_template
 * @return string
 */
function oercurr_get_single_template($single_template)
{
    global $post;

    if ($post->post_type == 'oer-curriculum') {
        $single_template = dirname( __FILE__ ) . '/templates/single-oer-curriculum.php';
    }
    return $single_template;
}
add_filter( 'single_template', 'oercurr_get_single_template' );

// Add rewrite rule for substandards
add_action( 'init', 'oercurr_add_rewrites', 10, 0 );
function oercurr_add_rewrites()
{
  global $root_slug;
    global $wp_rewrite;
    add_rewrite_tag( '%curriculum%', '([^/]*)' );
    add_rewrite_tag( '%source%', '([^&]+)' );
    add_rewrite_tag( '%topic%', '([^&]+)' );
    add_rewrite_tag( '%module%', '([^&]+)' );
    add_rewrite_tag( '%idx%', '([^&]+)' );
    add_rewrite_rule( '^'.$root_slug.'/([^/]*)/source/([^&]+)/idx/([^&]+)/?$', 'index.php?post_type=oer-curriculum&curriculum=$matches[1]&source=$matches[2]&idx=$matches[3]', 'top' );
    add_rewrite_rule( '^'.$root_slug.'/topic/([^&]+)/?$', 'index.php?post_type=oer-curriculum&topic=$matches[1]', 'top' );
    add_rewrite_rule( '^'.$root_slug.'/([^/]*)/module/([^&]+)/?$', 'index.php?post_type=oer-curriculum&curriculum=$matches[1]&module=$matches[2]', 'top' );
    add_rewrite_endpoint( 'curriculum', EP_PERMALINK | EP_PAGES );
    add_rewrite_endpoint( 'source', EP_PERMALINK | EP_PAGES );
    add_rewrite_endpoint( 'topic', EP_PERMALINK | EP_PAGES );
    add_rewrite_endpoint( 'module', EP_PERMALINK | EP_PAGES );

    $flush_rewrite = get_option('oer_curriculum_rewrite_rules');
    if (empty($flush_rewrite)){
        add_option('oer_curriculum_rewrite_rules', false);
    }

    $wp_rewrite->init();
    $wp_rewrite->flush_rules();
    update_option('oer_curriculum_rewrite_rules', true);
}

add_filter( 'query_vars', 'oercurr_add_query_vars' );
function oercurr_add_query_vars( $vars ){
    $vars[] = "source";
    $vars[] = "topic";
    $vars[] = "module";
    return $vars;
}

add_action( 'template_include' , 'oercurr_assign_standard_template' );
function oercurr_assign_standard_template($template) {
    global $wp_query;
  global $root_slug;
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');

    status_header(200);

    if ( strpos( $url_path, $root_slug ) !== false && get_query_var($root_slug) && get_query_var('source')) {
        $wp_query->is_404 = false;
        $template = locate_template('templates/primary-source.php', true);
        if (!$template) {
            $template = dirname(__FILE__) . '/templates/primary-source.php';
        }
    } elseif ( strpos( $url_path, $root_slug ) !== false && get_query_var($root_slug) && get_query_var('module')) {
        $wp_query->is_404 = false;
        $template = locate_template('templates/module.php', true);
        if (!$template) {
            $template = dirname(__FILE__) . '/templates/module.php';
        }
    } elseif ( strpos( $url_path, $root_slug ) !== false && get_query_var('topic')) {
        $wp_query->is_404 = false;
        $template = locate_template('templates/oer-curriculum-tag.php', true);
        if (!$template) {
            $template = dirname(__FILE__) . '/templates/oer-curriculum-tag.php';
        }
    }
    return $template;
}

add_action( 'init', 'oercurr_add_inquiry_set_rest_args', 30 );
function oercurr_add_inquiry_set_rest_args() {
    global $wp_post_types;

    $wp_post_types['oer-curriculum']->show_in_rest = true;
    $wp_post_types['oer-curriculum']->rest_base = 'inquiryset';
    $wp_post_types['oer-curriculum']->rest_controller_class = 'WP_REST_Posts_Controller';
}

/* Enqueue script and css for Gutenberg Inquiry Set Thumbnail block */
add_action('enqueue_block_editor_assets', 'oercurr_enqueue_inquiry_set_block');
function oercurr_enqueue_inquiry_set_block(){
    global $post;
    wp_enqueue_script(
        'curriculum-thumbnail-block-js',
        OERCURR_CURRICULUM_URL . "/js/backend/oer-curriculum-thumbnail-block.build.js",
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-api')
    );
    wp_localize_script(
        'curriculum-thumbnail-block-js',
        'oer_curriculum_thumbnail_block_localized',
        array(
            "theme_path" => get_template_directory_uri()
        )
    );
    wp_enqueue_style(
        'curriculum-thumbnail-block-css',
        OERCURR_CURRICULUM_URL . "/css/backend/oer-curriculum-thumbnail-block.css",
        array('wp-edit-blocks')
    );
    /* Register Thumbnail Block */
    register_block_type('oer-curriculum/curriculum-thumbnail-block', array(
        'editor_script' => 'curriculum-thumbnail-block-js',
        'editor_style' => 'curriculum-thumbnail-block-css'
    ));
}

add_action( 'rest_api_init', 'oercurr_add_meta_to_api');
function oercurr_add_meta_to_api() {
    // Register Grade Levels to REST API
    register_rest_field( 'oer-curriculum',
                'oer_curriculum_grades',
                array(
                'get_callback' => 'oercurr_rest_get_meta_field',
                'update_callback' => null,
                'schema' => null
                  ) );

    // Register Featured Image to REST API
    register_rest_field( 'oer-curriculum',
            'featured_image_url',
            array(
                'get_callback'    => 'oercurr_get_rest_featured_image',
                'update_callback' => null,
                'schema'          => null,
            ) );

}

function oercurr_retrieve_rootslug(){
  $_segments = explode("/",get_option( 'permalink_structure' )); $_pref = '';
  foreach ($_segments as $_segment){
    if(trim($_segment," ") !== '' && substr_count($_segment,'%') == 0){$_pref .= $_segment.'/';}
  }
  if(get_option('oer_curriculum_general_setting')){
    $_genset = json_decode(get_option('oer_curriculum_general_setting'));
    $_root_slug = ($_genset->rootslug_enabled > 0 && trim($_genset->rootslug)!= '')? $_genset->rootslug: 'curriculum';
  }else{
    $_root_slug = 'curriculum';
  }
  return $_pref.$_root_slug;
}

function oercurr_rest_get_meta_field($inquiryset, $field, $request){
    if ($field=="oer_curriculum_grades") {
        $grades = get_post_meta($inquiryset['id'], $field, true);
                if (is_array($grades))
                    $grades = $grades[0];
        $grade_level = "";

                if ($grades == "pre-k")
                    $grade_level = "Pre-Kindergarten";
                elseif ($grades == "k")
                    $grade_level = "Kindergarten";
                else
                    $grade_level = "Grade ".$grades;

                return $grade_level;
    } else
        return get_post_meta($inquiryset['id'], $field, true);
}

function oercurr_get_rest_featured_image($inquiryset, $field, $request) {
    if( $inquiryset['featured_media'] ){
        $img = wp_get_attachment_image_src( $inquiryset['featured_media'], 'app-thumb' );
        return $img[0];
    }
    return false;
}

add_action( 'wp_enqueue_scripts', 'oercurr_load_dashicons_front_end' );
function oercurr_load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}


//Load the text domain
add_action('plugins_loaded', 'oercurr_load_textdomain');
function oercurr_load_textdomain() {
	load_plugin_textdomain( OERCURR_CURRICULUM_SLUG, false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}