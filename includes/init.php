<?php
/**
 * Initialize the plugin installation
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Create menu item under the OER menu
add_action('init', 'oer_lesson_plan_creation');

function oer_lesson_plan_creation() {
    global $_use_gutenberg;
    $labels = array(
        'name'          => _x('Curriculum', 'post type general name'),
        'singular_name' => _x('Curriculum', 'post type singular name'),
        'add_new'       => _x('Add New Curriculum', 'book'),
        'add_new_item'  => __('Add New Curriculum'),
        'edit_item'     => __('Edit Curriculum'),
        'new_item'      => __('Create Curriculum'),
        'all_items'     => __('All Curriculum'),
        'view_item'     => __('View Curriculum'),
        'search_items'  => __('Search'),
        'menu_name'     => 'Curriculum'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'show_ui'               => true,
        'has_archive'           => true,
        'show_in_menu'          => true,//'edit.php?post_type=resource',
        'public'                => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'query_var'             => true,
        'menu_position'         => 26,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'taxonomies'            => array('post_tag', 'resource-subject-area'),
        'supports'              => array('title', 'editor', 'thumbnail', 'revisions'),
        'register_meta_box_cb'  => 'oer_lesson_plan_custom_meta_boxes'
    );

    if ($_use_gutenberg == "on" or $_use_gutenberg == "1")
        $args['show_in_rest'] = true;

    register_post_type('lesson-plans', $args);
}

function oer_lesson_plan_custom_meta_boxes() {
    add_meta_box( 'oer_lesson_plan_grades', 'Grade Level', 'oer_lp_grade_level_cb', 'lesson-plans', 'side', 'high' );
    add_meta_box('oer_lesson_plan_meta_boxid', 'Lesson Meta Fields', 'oer_lesson_plan_meta_callback', 'lesson-plans', 'advanced');

    // Add a download copy option
    add_meta_box( 'oer_lesson_plan_download_copy', 'Download Copy', 'oer_lp_download_copy_cb', 'lesson-plans', 'side', 'high' );
    
    // Add Related Inquiry Sets metabox
    add_meta_box('oer_lesson_plan_related_inquiry', 'Related Inquiry Sets', 'oer_lesson_plan_related_inquiry_callback', 'lesson-plans', 'advanced');
}

//Meta fields callback
function oer_lesson_plan_meta_callback() {
    include_once(OER_LESSON_PLAN_PATH . 'includes/lesson-plan-meta-fields.php');
}

// Related Inquiry Sets Callback
function oer_lesson_plan_related_inquiry_callback(){
    include_once(OER_LESSON_PLAN_PATH . 'includes/lesson-plan-related-inquiry-sets.php');
}

/**
 * Display the grade level into the side bar
 */
function oer_lp_grade_level_cb() {
    global $post;
    $post_meta_data = get_post_meta($post->ID );
    $oer_lp_grade_options = array(
        'pre-k' => 'Pre-K',
        'k' => 'K (Kindergarten)',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12'
    );
    $oer_lp_grades = (isset($post_meta_data['oer_lp_grades'][0]) ? unserialize($post_meta_data['oer_lp_grades'][0]) : array());
    foreach ($oer_lp_grade_options as $key => $oer_lp_grade_option) {
        $checkbox = '<div class="form-checkbox">';
        $checkbox .= '<input type="checkbox" name="oer_lp_grades[]" value="'.$key.'" id="oer_lp_grade_'.$key.'" '.oer_lp_show_selected($key, $oer_lp_grades, 'checkbox').'>';
        $checkbox .= '<label for="oer_lp_grade_'.$key.'">'.$oer_lp_grade_option.'</label>';
        $checkbox .= '</div>';
        echo $checkbox;
    }
}

/**
 * Add a checkbox option to the sidebar
 * To download file
 */
function oer_lp_download_copy_cb() {
    global $post;
    $post_meta_data = get_post_meta($post->ID );

    $oer_lp_download_copy = (isset($post_meta_data['oer_lp_download_copy'][0]) ? $post_meta_data['oer_lp_download_copy'][0] : 'yes');
    $is_checked = (($oer_lp_download_copy == 'yes') ? 'checked="checked"' : '');

    // Upload document
    $oer_lp_download_copy_document = (isset($post_meta_data['oer_lp_download_copy_document'][0]) ? $post_meta_data['oer_lp_download_copy_document'][0] : '');
    // Icon
    if (!empty($oer_lp_download_copy_document)) {
        $icon = get_file_type_from_url($oer_lp_download_copy_document);
        $icon = $icon['icon'];
    } else {
        $icon = '<i class="fa fa-upload"></i>';
    }
    $checkbox = '<div class="form-checkbox form-group">';
    $checkbox .= '<input type="checkbox" class="form-control" name="oer_lp_download_copy" value="yes" id="oer_lp_download_copy" ' . $is_checked . '>';
    $checkbox .= '<label for="oer_lp_download_copy">Download Copy</label>';
    $checkbox .= '</div>';
    $checkbox .= '<div class="form-group">';
    $checkbox .= '<div class="input-group">';
    $checkbox .= '<input type="text" class="form-control" name="oer_lp_download_copy_document" placeholder="Select Document" value="'.$oer_lp_download_copy_document.'">';
    $checkbox .= '<div class="input-group-addon oer-lp-download-copy-icon" title="Select Material">'.$icon.'</div>';
    $checkbox .= '</div></div>';
    echo $checkbox;
}

/**
 * Enqueue the assets into the admin
 * Scripts and styles
 */
add_action('admin_enqueue_scripts', 'oer_lesson_plan_assets');

function oer_lesson_plan_assets() {
    global $post;
    if (
        (isset($_GET['post_type']) && $_GET['post_type'] == 'lesson-plans') ||
        (isset($post->post_type) && $post->post_type == 'lesson-plans')
    ) {
        wp_enqueue_style('lesson-plan-load-fa', OER_LESSON_PLAN_URL . 'assets/lib/font-awesome/css/all.min.css');
        wp_enqueue_style('lesson-plan-bootstrap', OER_LESSON_PLAN_URL . 'assets/lib/bootstrap-3.3.7/css/bootstrap.min.css');
        wp_enqueue_style('admin-lesson-plan', OER_LESSON_PLAN_URL . 'assets/css/backend/lp-style.css');

        //Enqueue script
        if (!wp_script_is('admin-lp-bootstrap', 'enqueued')) {
            wp_enqueue_script('admin-lp-bootstrap', OER_LESSON_PLAN_URL . 'assets/lib/bootstrap-3.3.7/js/bootstrap.min.js');
        }

        wp_enqueue_script('lesson-plan', OER_LESSON_PLAN_URL . 'assets/js/backend/lesson-plan.js');

    }
}

/**
 * Enqueue the scripts and style into the frontend
 */
add_action('wp_enqueue_scripts', 'lp_enqueue_scripts_and_styles');
if (!function_exists('lp_enqueue_scripts_and_styles')) {
    function lp_enqueue_scripts_and_styles() {
        global $post;
        if (
            (isset($_GET['post_type']) && $_GET['post_type'] == 'lesson-plans') ||
            (isset($post->post_type) && $post->post_type == 'lesson-plans')
        ) {
            wp_enqueue_style('lp-style', OER_LESSON_PLAN_URL . 'assets/css/frontend/lp-style.css');
            wp_enqueue_script('lp-script', OER_LESSON_PLAN_URL . 'assets/js/frontend/lp-script.js', array('jquery'));
            wp_localize_script( 'lp-script', 'lp_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
        }
        wp_enqueue_script( 'jquery-ui-dialog' );
    }
}

/**
 * Save post meta fields into the post meta table
 */
add_action('save_post', 'lp_save_custom_fields');
function lp_save_custom_fields() {
    global $post, $wpdb, $_oer_prefix;
    
    //Check first if $post is not empty
    if ($post) {
        if ($post->post_type == 'lesson-plans') {
            //Save/update introduction
            if (isset($_POST['oer_lp_introduction'])) {
                update_post_meta($post->ID, 'oer_lp_introduction', $_POST['oer_lp_introduction']);
            }

            // Save authors data
            if (isset($_POST['oer_lp_authors'])) {
                update_post_meta($post->ID, 'oer_lp_authors', $_POST['oer_lp_authors']);
            }

            // Save primary resource
            if (isset($_POST['oer_lp_primary_resources'])) {
                update_post_meta($post->ID, 'oer_lp_primary_resources', $_POST['oer_lp_primary_resources']);
            }
            // Save materials
            if (isset($_POST['lp_oer_materials'])) {
                update_post_meta($post->ID, 'lp_oer_materials', $_POST['lp_oer_materials']);
            }

            // Save Investigative Question
            if (isset($_POST['oer_lp_iq'])) {
                update_post_meta($post->ID, 'oer_lp_iq', $_POST['oer_lp_iq']);
            }

            //Save/update lesson times
            if (isset($_POST['oer_lp_times_label'])) {
                update_post_meta($post->ID, 'oer_lp_times_label', $_POST['oer_lp_times_label']);
            }

            if (isset($_POST['oer_lp_times_number'])) {
                update_post_meta($post->ID, 'oer_lp_times_number', $_POST['oer_lp_times_number']);
            }

            if (isset($_POST['oer_lp_times_type'])) {
                update_post_meta($post->ID, 'oer_lp_times_type', $_POST['oer_lp_times_type']);
            }

            if (isset($_POST['oer_lp_grades'])) {
                update_post_meta($post->ID, 'oer_lp_grades', $_POST['oer_lp_grades']);
            }

            // Save Standards
            if (isset($_POST['oer_lp_standards'])) {
                update_post_meta($post->ID, 'oer_lp_standards', $_POST['oer_lp_standards']);
            }
            // Save / update Standard and Objectives
            if (isset($_POST['oer_lp_related_objective'])) {
                update_post_meta($post->ID, 'oer_lp_related_objective', $_POST['oer_lp_related_objective']);
            }

            // Save / update activity in this lesson
            if (isset($_POST['oer_lp_activity_title'])) {
                update_post_meta($post->ID, 'oer_lp_activity_title', $_POST['oer_lp_activity_title']);
            }

            // Save activity types
            if (isset($_POST['oer_lp_activity_type'])) {
                update_post_meta($post->ID, 'oer_lp_activity_type', $_POST['oer_lp_activity_type']);
            }

            // Save activity details
            if (isset($_POST['oer_lp_activity_detail'])) {
                update_post_meta($post->ID, 'oer_lp_activity_detail', $_POST['oer_lp_activity_detail']);
            }

            // Save / update assessment
            if (isset($_POST['oer_lp_assessment_type'])) {
                update_post_meta($post->ID, 'oer_lp_assessment_type', $_POST['oer_lp_assessment_type']);
            }

            // Save assessment type
            if (isset($_POST['oer_lp_other_assessment_type'])) {
                update_post_meta($post->ID, 'oer_lp_other_assessment_type', sanitize_text_field($_POST['oer_lp_other_assessment_type']));
            }

            // Save assessment
            if (isset($_POST['oer_lp_assessment'])) {
                update_post_meta($post->ID, 'oer_lp_assessment', $_POST['oer_lp_assessment']);
            }

            // Save custom editor fields
            if (isset($_POST['oer_lp_custom_editor'])) {
                update_post_meta($post->ID, 'oer_lp_custom_editor', $_POST['oer_lp_custom_editor']);
            }

            // Save custom modules
            if (isset($_POST['lp_order'])) {
                foreach ($_POST['lp_order'] as $moduleKey => $order) {
                    if (isset($_POST[$moduleKey])) {
                        update_post_meta($post->ID, $moduleKey, $_POST[$moduleKey]);
                        // Check for vocabulary and save the vocabulary details
                        if (strpos($moduleKey, 'oer_lp_vocabulary_list_title_') !== false) {
                            $listOrder = end(explode('_', $moduleKey));
                            if (isset($_POST['oer_lp_vocabulary_details_' . $listOrder])) {
                                update_post_meta($post->ID, 'oer_lp_vocabulary_details_' . $listOrder, $_POST['oer_lp_vocabulary_details_' . $listOrder]);
                            }
                        }
                    }
                }
            }

            // Save elements Order
            if (isset($_POST['lp_order'])) {
                update_post_meta($post->ID, 'lp_order', $_POST['lp_order']);
            }

            //Save download file options
            if (isset($_POST['oer_lp_download_copy'])) {
                $oer_lp_download_copy = sanitize_text_field($_POST['oer_lp_download_copy']);
            } else {
                $oer_lp_download_copy = 'no';
            }
            update_post_meta($post->ID, 'oer_lp_download_copy', $oer_lp_download_copy);

            // Save download copy document
            if (isset($_POST['oer_lp_download_copy_document'])) {
                update_post_meta($post->ID, 'oer_lp_download_copy_document', sanitize_text_field($_POST['oer_lp_download_copy_document']));
            }

            // Save related inquiry sets
            if (isset($_POST['oer_lp_related_inquiry_set'])) {
                update_post_meta($post->ID, 'oer_lp_related_inquiry_set', $_POST['oer_lp_related_inquiry_set']);
            }
        }
        
    }
}

// Ajax Requests
/**
 * Create dynamic more activity editor
 */
add_action('wp_ajax_lp_add_more_activity_callback', 'lp_add_more_activity_callback');
add_action('wp_ajax_nopriv_lp_add_more_activity_callback', 'lp_add_more_activity_callback');

function lp_add_more_activity_callback() {
    $totalElements = isset($_REQUEST['row_id']) ? $_REQUEST['row_id'] : '15';
    $content = '<div class="panel panel-default lp-ac-item" id="lp-ac-item-' . $totalElements . '">
                    <span class="lp-inner-sortable-handle">
                        <i class="fa fa-arrow-down activity-reorder-down hide" aria-hidden="true"></i>
                        <i class="fa fa-arrow-up activity-reorder-up" aria-hidden="true"></i>
                    </span>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label>Activity Title</label>
                                <input type="text" name="oer_lp_activity_title[]" class="form-control" placeholder="Activity Title">
                            </div>
                            <div class="col-md-2 lp-ac-delete-container">
                                <span class="btn btn-danger btn-sm lp-remove-module" title="Delete"><i class="fa fa-trash"></i> </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="activity-title">Activity Title</label>
                                <select name="oer_lp_activity_type[]" class="form-control">
                                    <option value=""> - Activity Type -</option>
                                    <option value="hooks_set">Hooks / Set</option>
                                    <option value="lecture">Lecture</option>
                                    <option value="demonstration">Demo / Modeling</option>
                                    <option value="independent_practice">Independent Practice</option>
                                    <option value="guided_practice">Guided Practice</option>
                                    <option value="check_understanding">Check Understanding</option>
                                    <option value="lab_shop">Lab / Shop</option>
                                    <option value="group_work">Group Work</option>
                                    <option value="projects">Projects</option>
                                    <option value="assessment">Formative Assessment</option>
                                    <option value="closure">Closure</option>
                                    <option value="research">Research / Annotate</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">';
    ob_start(); // Start output buffer
    wp_editor('',
        'oer-lp-activity-detail-' . $totalElements,
        $settings = array(
            'textarea_name' => 'oer_lp_activity_detail[]',
            'media_buttons' => true,
            'textarea_rows' => 10,
            'drag_drop_upload' => true,
            'teeny' => true,
        )
    );
    $content .= ob_get_clean();
    $content .= '</div>
                    </div>
                </div>';

    echo $content;
    exit();
}

/**
 * Add more primary resource
 */
add_action('wp_ajax_lp_add_more_pr_callback', 'lp_add_more_pr_callback');
add_action('wp_ajax_nopriv_lp_add_more_pr_callback', 'lp_add_more_pr_callback');

function lp_add_more_pr_callback() {
    $totalElements = isset($_REQUEST['row_id']) ? $_REQUEST['row_id'] : '15';
    $content = '<div class="panel panel-default lp-primary-resource-element-wrapper" id="lp-primary-resource-element-wrapper-' . $totalElements . '">
                    <div class="panel-heading">
                        <h3 class="panel-title lp-module-title">
                            Resource
                            <span class="lp-sortable-handle">
                                <i class="fa fa-arrow-down resource-reorder-down" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up resource-reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm lp-remove-source"
                                  title="Delete"
                                  disabled="disabled"
                            ><i class="fa fa-trash"></i> </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Resource</label>
                                    <select name="oer_lp_primary_resources[resource][]" class="form-control">';
                                        $content .= oer_lp_primary_resource_dropdown();
                        $content .= '</select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" name="oer_lp_primary_resources[sensitive_material][]" value="yes">
                                        Sensitive Material
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Teacher Information</label>';
                            ob_start(); // Start output buffer
                            wp_editor('',
                                'oer-lp-resource-teacher-' . $totalElements,
                                $settings = array(
                                    'textarea_name' => 'oer_lp_primary_resources[teacher_info][]',
                                    'media_buttons' => true,
                                    'textarea_rows' => 6,
                                    'drag_drop_upload' => true,
                                    'teeny' => true,
                                )
                            );
                        $content .= ob_get_clean();
                        $content .= '</div>';
                        $content .= '<div class="form-group">
                            <label>Student Information</label>';
                            ob_start(); // Start output buffer
                            wp_editor('',
                                'oer-lp-resource-student-' . $totalElements,
                                $settings = array(
                                    'textarea_name' => 'oer_lp_primary_resources[student_info][]',
                                    'media_buttons' => true,
                                    'textarea_rows' => 6,
                                    'drag_drop_upload' => true,
                                    'teeny' => true,
                                )
                            );
                            $content .= ob_get_clean();
                        $content .= '</div>
                    </div>
                </div>';

    echo $content;
    exit();
}

/**
 * Create dynamic module
 */
add_action('wp_ajax_lp_create_module_callback', 'lp_create_module_callback');
add_action('wp_ajax_nopriv_lp_create_module_callback', 'lp_create_module_callback');

function lp_create_module_callback() {
    $module_type = isset($_REQUEST['module_type']) ? $_REQUEST['module_type'] : 'editor';
    $element_id = isset($_REQUEST['row_id']) ? $_REQUEST['row_id'] : '15';

    if ($module_type == 'editor') {
        echo create_dynamic_editor($element_id);
        exit();
        /* echo json_encode(
             array(
                 'status' => 'ok',
                 'result' => create_dynamic_editor($element_id)
             )
         );*/
    } elseif ($module_type == 'list') {
        echo create_dynamic_text_list($element_id);
    } elseif ($module_type == 'vocabulary') {
        echo create_dynamic_vocabulary_list($element_id);
    } elseif ($module_type == 'materials') {
        echo create_dynamic_materials_module($element_id);
    }
    exit();
}

/**
 * Create dynamic text editor
 * @param $id
 * @return string
 */
function create_dynamic_editor($id) {

    $content = '<div class="panel panel-default lp-element-wrapper oer-lp-introduction-group" id="oer-lp-custom-editor-group-' . $id . '">
                    <input type="hidden" name="lp_order[oer_lp_custom_editor_' . $id . ']" class="element-order" value="' . $id . '">
                    <div class="panel-heading">
                        <h3 class="panel-title lp-module-title">
                            Text Editor
                            <span class="lp-sortable-handle">
                                <i class="fa fa-arrow-down reorder-down hide" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm lp-remove-module" title="Delete"><i class="fa fa-trash"></i> </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="oer_lp_custom_editor_'. $id.'[title]" maxlength="512" class="form-control" placeholder="Text Module Title" />
                        </div>
                        <div class="form-group">';
                        ob_start(); // Start output buffer
                        wp_editor('',
                            'oer-lp-custom-editor-' . $id,
                            $settings = array(
                                'textarea_name' => 'oer_lp_custom_editor_' . $id . '[description]',
                                'media_buttons' => true,
                                'textarea_rows' => 10,
                                'drag_drop_upload' => true,
                                'teeny' => true,
                            )
                        );
    $content .= ob_get_clean();
    $content .= '</div></div>
                </div>';

    return $content;
}

/**
 * Create dynamic text list
 * @param $id
 * @return string
 */
function create_dynamic_text_list($id) {
    $content = '<div class="panel panel-default lp-element-wrapper" id="oer-lp-text-list-group' . $id . '">
                    <input type="hidden" name="lp_order[oer_lp_custom_text_list_' . $id . ']" class="element-order" value="' . $id . '">
                    <div class="panel-heading">
                        <h3 class="panel-title lp-module-title">
                            Text List
                            <span class="lp-sortable-handle">
                                <i class="fa fa-arrow-down reorder-down hide" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm lp-remove-module" title="Delete"><i class="fa fa-trash"></i> </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="lp-text-list-row" id="lp-text-list-row' . $id . '">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control"
                                               name="oer_lp_custom_text_list_' . $id . '[]"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button"
                                            class="btn btn-danger lp-remove-text-list"
                                            disabled="disabled"
                                    ><i class="fa fa-trash"></i> </button>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>';

    return $content;
}

/**
 * Create dynamic vocabulary list
 * @param $id
 * @return string
 */
function create_dynamic_vocabulary_list($id) {
    $content = '<div class="panel panel-default lp-element-wrapper" id="oer-lp-vocabulary-list-group' . $id . '">
                    <input type="hidden" name="lp_order[oer_lp_vocabulary_list_title_' . $id . ']" class="element-order" value="' . $id . '">
                    <div class="panel-heading">
                        <h3 class="panel-title lp-module-title">
                            Vocabulary List
                            <span class="lp-sortable-handle">
                                <i class="fa fa-arrow-down reorder-down hide" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm lp-remove-module" title="Delete"><i class="fa fa-trash"></i> </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="oer_lp_vocabulary_list_title_' . $id . '"
                            >
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="oer_lp_vocabulary_details_' . $id . '" rows="6"></textarea>
                        </div>   
                    </div>
                </div>';

    return $content;
}

if (! function_exists('create_dynamic_materials_module')) {
    /**
     * Create dynamic vocabulary list
     * @param $id
     * @return string
     */
    function create_dynamic_materials_module($id) {
        $content = '<div class="panel panel-default lp-element-wrapper" id="oer-lp-materials-'.$id.'">
                        <input type="hidden" name="lp_order[lp_oer_materials_list_'.$id.']" class="element-order" value="'.$id.'">
                        <div class="panel-heading">
                            <h3 class="panel-title lp-module-title">
                                Materials
                                <span class="lp-sortable-handle">
                                    <i class="fa fa-arrow-down reorder-down" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-up reorder-up" aria-hidden="true"></i>
                                </span>
                                <span class="btn btn-danger btn-sm lp-remove-module" title="Delete"><i class="fa fa-trash"></i></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="panel-group lp-materials-container" id="lp-materials-container">
                            </div>
                            <button type="button" data-type="custom" data-name="lp_oer_materials_list_'.$id.'" class="btn btn-default lp-add-materials"><i class="fa fa-plus"></i> Add Materials</button>
                        </div>
                    </div>';
        return $content;
    }
}
/**
 * Hide installation notice
 */
add_action('wp_ajax_lp_dismiss_notice_callback', 'lp_dismiss_notice_callback');
add_action('wp_ajax_nopriv_lp_dismiss_notice_callback', 'lp_dismiss_notice_callback');

function lp_dismiss_notice_callback() {
    update_option('lp_setup_notification', true);
}

/**
 * Search standards in modal
 */
add_action('wp_ajax_lp_searched_standards_callback', 'lp_searched_standards_callback');
add_action('wp_ajax_nopriv_lp_searched_standards_callback', 'lp_searched_standards_callback');

function lp_searched_standards_callback() {
    $post_id = null;
    $keyword = null;
    $meta_key = "oer_lp_standards";

    if (isset($_POST['post_id'])){
        $post_id = $_POST['post_id'];
    }
    if (isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }

    if (!$post_id){
        echo "Invalid Post ID";
        die();
    }

    if (!$keyword){
        was_selectable_admin_standards($post_id);
        die();
    }

    if (function_exists('was_search_standards')){
        was_search_standards($post_id,$keyword,$meta_key);
    }
    die();
}

add_action('wp_ajax_lp_get_source_callback', 'lp_get_source_callback');
add_action('wp_ajax_nopriv_lp_get_source_callback', 'lp_get_source_callback');
function lp_get_source_callback(){
    $source = null;
    $curriculum_id = null;
    $data = null;
    $source_id = null;
    $teacher_info = "";
    $student_info = "";
    $resource_meta = null;
    $subject_areas = null;
    $subjects = null;
    
    if (isset($_POST['next_source']))
        $source = $_POST['next_source'];
    
    if (isset($_POST['curriculum']))
        $curriculum_id = $_POST['curriculum'];
    
    if (isset($_POST['index']))
        $source_id = $_POST['index'];
    
    // Get Resource Details
    $resource = get_page_by_title($source,OBJECT,"resource");
    $resource_img = get_the_post_thumbnail_url($resource);
    
    // Get Resource Meta
    if (function_exists('oer_get_resource_metadata')){
        $resource_meta = oer_get_resource_metadata($resource->ID);
    }
    
    if (function_exists('oer_get_subject_areas')){
        $subject_areas = oer_get_subject_areas($resource->ID);
    }
    if (is_array($subject_areas) && count($subject_areas)>0) {
        $subjects = array_unique($subject_areas, SORT_REGULAR);
    }
    
    // Get Curriculum Details
    $post_meta_data = get_post_meta($curriculum_id);
    $primary_resources = (isset($post_meta_data['oer_lp_primary_resources'][0]) ? unserialize($post_meta_data['oer_lp_primary_resources'][0]) : array());
     if (isset($primary_resources['teacher_info']))
        $teacher_info = $primary_resources['teacher_info'][$source_id];
    if (isset($primary_resources['student_info']))
        $student_info = $primary_resources['student_info'][$source_id];
    
    $data['resource'] = $resource;
    $data['featured_image'] = esc_url($resource_img);
    $data['teacher_info'] = $teacher_info;
    $data['student_info'] = $student_info;
    $data['resource_meta'] = $resource_meta;
    
    echo json_encode($data);
    die();
}

function change_post_types_slug( $args, $post_type ) {

   /*item post type slug*/   
   if ( 'lesson-plans' === $post_type ) {
      $args['rewrite']['slug'] = 'inquiry-sets';
   }

   return $args;
}
add_filter( 'register_post_type_args', 'change_post_types_slug', 10, 2 );