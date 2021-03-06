<?php
global $root_slug;
add_filter('body_class', function($classes){
    $classes[] = 'primary-source-template';
    return $classes;
});

get_header();
$module_title = "";
$module_content = "";
$modules = array();
$back_url = "";
$source_id = 0;
$oer_curriculum_prev_class = "";
$oer_curriculum_next_class = "";
$prev_url = "";
$next_url = "";
$current_index = 0;

$post_meta_data = get_post_meta($post->ID );
$elements_orders = isset($post_meta_data['oer_curriculum_order'][0]) ? unserialize($post_meta_data['oer_curriculum_order'][0]) : array();

// Back Button URL
$curriculum = get_query_var('curriculum');
$curriculum_details = get_page_by_path($curriculum, OBJECT, "oer-curriculum");
$curriculum_id = $curriculum_details->ID;
if ($curriculum)
    $back_url = site_url($root_slug."/".$curriculum);

// Get Resource ID
$module_slug = get_query_var('module');
if (!empty($elements_orders)) {
    $keys = array(
        "oer_curriculum_introduction_order",
        "oer_curriculum_primary_resources",
        "oer_curriculum_lesson_times_order",
        "oer_curriculum_industries_order",
        "oer_curriculum_standard_order",
        "oer_curriculum_activities_order",
        "oer_curriculum_summative_order",
        "oer_curriculum_authors_order",
        "oer_curriculum_iq",
        "oer_curriculum_oer_materials"
    );
    $eIndex = 0;
    foreach($elements_orders as $elementKey=>$order){
        if (!in_array($elementKey,$keys)){
            if (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_curriculum_vocabulary_list_title_') === false) 
                $module = (isset($post_meta_data[$elementKey][0]) ? unserialize($post_meta_data[$elementKey][0]) : "");
            
            if (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_curriculum_custom_text_list_') !== false){
                $module['title'] = "Text List";
                $module['description'] = $module[0];
            } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_curriculum_vocabulary_list_title_') !== false) {
                $oer_curriculum_vocabulary_list_title = (isset($post_meta_data[$elementKey][0]) ? $post_meta_data[$elementKey][0] : "");
                $oer_keys = explode('_', $elementKey); 
                $listOrder = end($oer_keys);
                $oer_curriculum_vocabulary_details = (isset($post_meta_data['oer_curriculum_vocabulary_details_'.$listOrder][0]) ? $post_meta_data['oer_curriculum_vocabulary_details_'.$listOrder][0] : "");
                $module['title'] = $oer_curriculum_vocabulary_list_title;
                $module['description'] = $oer_curriculum_vocabulary_details;
            } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_curriculum_oer_materials_list_') !== false) {
                $module['title'] = "Materials";
                $html = "";
                $i = 0;
                foreach($module['url'] as $url){
                    $img = oercurr_get_file_type_from_url($url, "fa-4x");
                    $html .= "<div class='row clear input-group'>";
                    if ($img['title']=="Image")
                        $html .= "<div class='col-md-4'><img src='".esc_url($url)."'></div>";
                    else
                        $html .= "<div class='col-md-4' style='display:flex;align-items:center;justify-content:center;'>".$img['icon']."</div>";
                    $html .= "<div class='col-md-8'>".$module['description'][$i]."</div>";
                    $html .= "</div>";
                    $i++;
                }
                $module['description'] = $html;
            }
            if (sanitize_title($module['title'])==$module_slug){
                $module_title = $module['title'];
                if (isset($module['description']))
                    $module_content = $module['description'];
                $current_index = $eIndex;
            }
            $modules[] = $module;
            $eIndex++;
        }
    }
}

// Get Curriculum Meta for Primary Sources
$post_meta_data = get_post_meta($curriculum_id);
$primary_resources = (isset($post_meta_data['oer_curriculum_primary_resources'][0]) ? unserialize($post_meta_data['oer_curriculum_primary_resources'][0]) : array());
$index = 0;
$prev_url = null;
$next_url = null;
$cnt = count($primary_resources['resource']);
if (!empty($primary_resources) && oercurr_scan_array($primary_resources)) {
    if (!empty(array_filter($primary_resources['resource']))) {
        if ($current_index==0) {
            if (isset($primary_resources['resource'][$cnt-1])){
                $prev_resource = oercurr_get_resource_details($primary_resources['resource'][$cnt-1]);
                $prev_url = $back_url."/source/".sanitize_title($prev_resource->post_title)."-".$prev_resource->ID;
            }
        } else {
            if (isset($modules[$current_index-1])){
                $prev_resource = $modules[$current_index-1];
                $prev_url = $back_url."/module/".sanitize_title($prev_resource['title']);
            }
        }
    }
}
if (isset($modules[$current_index+1])){
    $next_resource = $modules[$current_index+1];
    $next_url = $back_url."/module/".sanitize_title($next_resource['title']);
}
?>
<div class="oercurr-nav-block"><a class="back-button" href="<?php echo esc_url($back_url); ?>"><i class="fas fa-arrow-left"></i><?php echo esc_html($curriculum_details->post_title); ?></a></div>
<div class="row ps-details-row">
    <?php
    $resource_meta = null;
    $subject_areas = null;
    ?>
    <div class="ps-details col-md-12 col-sm-12">
        <div class="ps-info">
            <h1 class="ps-info-title"><?php echo esc_html($module_title); ?></h1>
            <div class="ps-info-description">
                <?php echo esc_html($module_content); ?>
            </div>
        </div>
    </div>
</div>
<div class="ps-related-sources oercurr-primary-sources-row">
    <div class="oercurr-ps-nav-left-block <?php echo esc_attr($oer_curriculum_prev_class); ?> col-md-6 col-sm-12">
        <?php if (!empty($prev_resource)):
        $resource_img = wp_get_attachment_image_url( get_post_thumbnail_id($prev_resource), 'resource-thumbnail' );
        ?>
        <a class="oercurr-ps-nav-left" href="<?php echo esc_url($prev_url); ?>" data-activetab="" data-id="<?php echo esc_html($index)-1; ?>" data-count="<?php echo esc_attr(count($primary_resources['resource'])); ?>" data-curriculum="<?php echo esc_attr($curriculum_id); ?>" data-prevsource="<?php echo esc_attr($primary_resources['resource'][$index-1]); ?>">
            <span class="col-md-3">&nbsp;</span>
            <span class="nav-media-icon"><i class="fas fa-arrow-left fa-2x"></i></span>
            <span class="nav-media-image col-md-8">
                <span class="nav-image-thumbnail col-md-4">
                    <?php if (!empty($resource_img)):
                    if (is_object($prev_resource))
                        $ps_url = site_url($root_slug."/".sanitize_title($post->post_name)."/source/".sanitize_title($prev_resource->post_title)."-".$prev_resource->ID);
                    else
                        $ps_url = site_url($root_slug."/".sanitize_title($post->post_name)."/module/".sanitize_title($prev_resource['title']));
                    ?>
                    <div class="resource-thumbnail" style="background: url('<?php echo esc_url($resource_img) ?>') no-repeat center rgba(204,97,12,.1); background-size:cover;"></div>
                    <?php else: ?>
                    <div class="resource-thumbnail" style="background: rgba(204,97,12,.1); background-size:cover; display:flex; align-items:center; justify-content: center;"><i class="fa fa-file-text-o fa-4x"></i></div>
                    <?php endif; ?>
                </span>
                <span class="oercurr-nav-resource-title col-md-8">
                    <?php
                    if (is_object($prev_resource))
                        echo esc_html($prev_resource->post_title);
                    else
                        echo esc_html($prev_resource['title']);
                    ?>
                </span>
            </span>
        </a>
        <?php endif; ?>
    </div>
    <div class="oercurr-ps-nav-right-block <?php echo esc_attr($oer_curriculum_next_class); ?> col-md-6 col-sm-12">
        <?php if (!empty($next_resource)):
        $resource_img = wp_get_attachment_image_url( get_post_thumbnail_id($next_resource), 'resource-thumbnail' );
        ?>
        <a class="oercurr-ps-nav-right" href="<?php echo esc_url($next_url); ?>" data-activetab="" data-id="<?php echo esc_attr($index)+1; ?>" data-count="<?php echo esc_attr(count($primary_resources['resource'])); ?>" data-curriculum="<?php echo esc_attr($curriculum_id); ?>" data-nextsource="<?php echo esc_attr($primary_resources['resource'][$index+1]); ?>">
            <span class="nav-media-image col-md-8">
                <span class="nav-image-thumbnail col-md-4">
                    <?php if (!empty($resource_img)):
                    $ps_url = site_url($root_slug."/".sanitize_title($post->post_name)."/module/".sanitize_title($next_resource['title']));
                    ?>
                    <div class="resource-thumbnail" style="background: url('<?php echo esc_html($resource_img) ?>') no-repeat center rgba(204,97,12,.1); background-size:cover;"></div>
                    <?php else: ?>
                    <div class="resource-thumbnail" style="background: rgba(204,97,12,.1); background-size:cover; display:flex; align-items:center; justify-content: center;"><i class="fa fa-file-text-o fa-4x"></i></div>
                    <?php endif; ?>
                </span>
                <span class="oercurr-nav-resource-title col-md-8">
                    <?php
                    if (is_object($next_resource))
                        echo esc_html($next_resource->post_title);
                    else
                        echo esc_html($next_resource['title']);
                    ?>
                </span>
            </span>
            <span class="nav-media-icon"><i class="fas fa-arrow-right fa-2x"></i></span>
            <span class="col-md-3">&nbsp;</span>
        </a>
        <?php endif; ?>
    </div>
</div>
<div class="oercurr-ajax-loader" role="status">
    <div class="oercurr-ajax-loader-img">
        <img src="<?php echo esc_url(OERCURR_CURRICULUM_URL)."/images/load.gif"; ?>" />
    </div>
</div>
<?php
get_footer();
?>