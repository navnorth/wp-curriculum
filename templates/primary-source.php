<?php

add_filter('body_class', function($classes){
    $classes[] = 'primary-source-template';
    return $classes;
});

get_header();

$active_tab = null;
$back_url = "";
$source_id = 0;
$lp_prev_class = "";
$lp_next_class = "";
$prev_url = "";
$next_url = "";

if (isset($_POST['activeTab']))
    $active_tab = $_POST['activeTab'];

// Back Button URL
$curriculum = get_query_var('curriculum');
$curriculum_details = get_page_by_path($curriculum, OBJECT, "lesson-plans");
$curriculum_id = $curriculum_details->ID;
if ($curriculum)
    $back_url = site_url("inquiry-sets/".$curriculum);

// Get Resource ID
$psource = get_query_var('source');
$sources = explode("-",$psource);
if ($sources)
    $source_id = $sources[count($sources)-1];

$resource = get_post($source_id);

// Get Featured Image Url
$featured_image_url = get_the_post_thumbnail_url($resource->ID, "full");
$resource_url = get_post_meta($resource->ID, "oer_resourceurl", true);
$youtube = oer_is_youtube_url($resource_url);
$isPDF = is_pdf_resource($resource_url);

// Get Curriculum Meta for Primary Sources
$post_meta_data = get_post_meta($curriculum_id);
$primary_resources = (isset($post_meta_data['oer_lp_primary_resources'][0]) ? unserialize($post_meta_data['oer_lp_primary_resources'][0]) : array());
$index = 0;
$teacher_info = "";
$student_info = "";
$embed = "";
$prev_url = null;
$next_url = null;
if (!empty($primary_resources) && lp_scan_array($primary_resources)) {
    if (!empty(array_filter($primary_resources['resource']))) {
        $source_count = count($primary_resources['resource']);
        foreach ($primary_resources['resource'] as $resourceKey => $source) {
            if ($source==$resource->post_title)
                break;
            if (strcmp(esc_html($source),$resource->post_title)==0)
                break;
            $index++;
        }
        if (isset($primary_resources['resource'][$index-1])){
            // get previous url
            $prevIndex = $index - 1;
            do {
                $prev_resource = oer_lp_get_resource_details($primary_resources['resource'][$prevIndex]);
                $prevIndex--;
            } while(!$prev_resource && $prevIndex >= 0);
            if ($prev_resource)
                $prev_url = $back_url."/source/".sanitize_title($prev_resource->post_title)."-".$prev_resource->ID;
        }
        if (isset($primary_resources['resource'][$index+1])){
            //get next url
            $nextIndex = $index + 1;
            do {
                $next_resource = oer_lp_get_resource_details($primary_resources['resource'][$nextIndex]);   
                $nextIndex++;
            } while(!$next_resource && $nextIndex < $source_count);
            if ($next_resource)
                $next_url = $back_url."/source/".sanitize_title($next_resource->post_title)."-".$next_resource->ID;
        }
        if ($index==0)
            $lp_prev_class = "ps-nav-hidden";
        if ($index==count($primary_resources['resource'])-1)
            $lp_next_class = "ps-nav-hidden";
        if (isset($primary_resources['teacher_info'][$index]))
            $teacher_info = $primary_resources['teacher_info'][$index];
        if (isset($primary_resources['student_info'][$index]))
            $student_info = $primary_resources['student_info'][$index];
    }
}
if ($youtube || $isPDF)
    $featured_image_url = "";
?>
<a class="back-button" href="<?php echo $back_url; ?>"><i class="fal fa-arrow-left"></i><?php _e("Back to Inquiry Set", OER_LESSON_PLAN_SLUG)?></a>
<div class="ps-header" style="background:url(<?php echo $featured_image_url; ?>) no-repeat center center #9C9C9C;" data-curid="<?php echo $index; ?>">
    <?php if ($youtube): ?>
    <div class="ps-youtube-video">
        <?php
            echo '<div class="youtubeVideoWrapper">';
            if (function_exists('oer_generate_youtube_embed_code'))
                $embed = oer_generate_youtube_embed_code($resource_url, $resource->post_title);
            echo $embed;
            echo '</div>';
        ?>
    </div>
    <?php endif; ?>
    <?php if ($isPDF): ?>
    <div class="ps-pdf-block">
        <?php
            echo '<div class="psPDFWrapper">';
            oer_display_pdf_embeds($resource_url);
            echo '</div>';
        ?>
    </div>
    <?php endif; ?>
    <span class="ps-nav-left <?php echo $lp_prev_class; ?>"><a class="lp-nav-left" href="<?php echo $prev_url; ?>" data-activetab="" data-id="<?php echo $index-1; ?>" data-count="<?php echo count($primary_resources['resource']); ?>" data-curriculum="<?php echo $curriculum_id; ?>" data-prevsource="<?php echo $primary_resources['resource'][$index-1]; ?>"><i class="fal fa-chevron-left fa-2x"></i></a></span>
    <span class="ps-nav-right <?php echo $lp_next_class; ?>"><a class="lp-nav-right" href="<?php echo $next_url; ?>" data-activetab="" data-id="<?php echo $index+1; ?>" data-count="<?php echo count($primary_resources['resource']); ?>" data-curriculum="<?php echo $curriculum_id; ?>" data-nextsource="<?php echo $primary_resources['resource'][$index+1]; ?>"><i class="fal fa-chevron-right fa-2x"></i></a></span>
    <span class="ps-expand"><a href="<?php echo $featured_image_url; ?>" class="lp-expand-img" target="_blank"><i class="fal fa-expand-arrows-alt"></i></a></span>
</div>
<?php
$resource_meta = null;
$subject_areas = null;
$transcription_display = false;
$sensitive_material_display = false;
$tab_count = 3;
if (function_exists('oer_get_resource_metadata')){
    $resource_meta = oer_get_resource_metadata($resource->ID);
}
if (isset($resource_meta['oer_transcription']) && $resource_meta['oer_transcription'][0]!==""){
    $transcription_display = true;
    $tab_count++;
}

if (isset($resource_meta['oer_sensitive_material']) && $resource_meta['oer_sensitive_material'][0]!==""){
    $sensitive_material_display = true;
    $tab_count++;
}
$tabs = floor(12/$tab_count);   

if (in_array($active_tab,array("ps-transcription-info-tab","ps-sensitive-info-tab"))){
    if (($active_tab=="ps-transcription-info-tab" && !$transcription_display) || ($active_tab=="ps-sensitive-info-tab" && !$sensitive_material_display))
        $active_tab = null;
}

if ($sensitive_material_display==true) : ?>
<div class="tc-sensitive-material-section tc-primary-source-sensitive-material-section">
    <p><i class="fal fa-exclamation-triangle"></i><span class="sensitive-material-text">Sensitive Material</span></p>
    <button class="question-popup-button" role="button" data-toggle="tab" data-tabid="ps-sensitive-info-tab" href="#ps-sensitive-info-tab-content"><i class="fal fa-question-circle"></i></button>
</div>
<?php endif; ?>
<div class="ps-info">
    <ul class="nav nav-tabs ps-info-tabs" id="ps-info-tabs-section" role="tablist">
        <li class="nav-item col-md-<?php echo $tabs; ?> col-sm-6 padding-0">
            <a class="nav-link <?php if (!$active_tab || $active_tab=="ps-information-tab"): ?>active<?php endif; ?>" id="ps-information-tab" data-toggle="tab" href="#ps-information-tab-content" role="tabs" aria-controls="ps-information-tab-content" aria-selected="true" aria-expanded="false">
                <?php _e("Resource Info.", OER_LESSON_PLAN_SLUG); ?>    
            </a>
        </li>
        <li class="nav-item col-md-<?php echo $tabs; ?> col-sm-6 padding-0">
            <a class="nav-link <?php if ($active_tab=="ps-student-info-tab"): ?>active<?php endif; ?>" id="ps-student-info-tab" data-toggle="tab" href="#ps-student-info-tab-content" role="tabs" aria-controls="ps-student-info-tab-content" aria-selected="true" aria-expanded="false">
                For The Student    
            </a>
        </li>
        <li class="nav-item col-md-<?php echo $tabs; ?> col-sm-6 padding-0">
            <a class="nav-link <?php if ($active_tab=="ps-teacher-info-tab"): ?>active<?php endif; ?>" id="ps-teacher-info-tab" data-toggle="tab" href="#ps-teacher-info-tab-content" role="tabs" aria-controls="ps-teacher-info-tab-content" aria-selected="true" aria-expanded="false">
                For The Teacher    
            </a>
        </li>
        <?php if ($transcription_display==true) : ?>
        <li class="nav-item col-md-<?php echo $tabs; ?> col-sm-6 padding-0">
            <a class="nav-link <?php if ($active_tab=="ps-transcription-info-tab"): ?>active<?php endif; ?>" id="ps-transcription-info-tab" data-toggle="tab" href="#ps-transcription-info-tab-content" role="tabs" aria-controls="ps-transcription-info-tab-content" aria-selected="true" aria-expanded="false">
                <?php _e("Transcription", OER_LESSON_PLAN_SLUG); ?>    
            </a>
        </li>
        <?php endif; ?>
        <?php if ($sensitive_material_display==true) : ?>
        <li class="nav-item col-md-<?php echo $tabs; ?> col-sm-6 padding-0">
            <a class="nav-link <?php if ($active_tab=="ps-sensitive-info-tab"): ?>active<?php endif; ?>" id="ps-sensitive-info-tab" data-toggle="tab" href="#ps-sensitive-info-tab-content" role="tabs" aria-controls="ps-sensitive-info-tab-content" aria-selected="true" aria-expanded="false">
                <?php _e("Sensitive Material Warning", OER_LESSON_PLAN_SLUG); ?>    
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>
<div class="ps-info-tabs-content">
    <div class="tab-pane clearfix fade active in" id="ps-information-tab-content" role="tabpanel" aria-labelledby="ps-information-tab">
        <?php
        $isFile = false;
        if (function_exists('is_file_resource'))
            $isFile = is_file_resource($resource_meta['oer_resourceurl'][0]);
        
        if (function_exists('is_pdf_resource') && $isFile==false)
            $isFile = is_pdf_resource($resource_meta['oer_resourceurl'][0]);
        
        if (function_exists('is_image_resource') && $isFile==false)
            $isFile = is_image_resource($resource_meta['oer_resourceurl'][0]);
        
        if (function_exists('is_audiovideo_resource') && $isFile==false)
            $isFile = is_audiovideo_resource($resource_meta['oer_resourceurl'][0]);
        ?>
        <div class="col-md-8">
            <h1 class="ps-info-title"><?php echo $resource->post_title; ?></h1>
            <div class="ps-info-description">
                <?php echo $resource->post_content; ?>
            </div>
            <?php if (isset($resource_meta['oer_resourceurl'])) { ?>
            <div class="ps-meta-group ps-resource-url">
                <a href="<?php echo $resource_meta['oer_resourceurl'][0]; ?>" class="tc-view-button" target="_blank">Full Resource View</a>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-4">
            <div class="ps-meta-icons">
                <?php if ($isFile==true) : ?>
                <span class="ps-download-source ps-meta-icon"><a href="<?php echo $resource_meta['oer_resourceurl'][0]; ?>" class="ps-download"><i class="fal fa-download"></i></a></span>
                <?php endif; ?>
                <div class="sharethis-inline-share-buttons"></div>
            </div>
            <?php
            if (function_exists('oer_get_subject_areas')){
                $subject_areas = oer_get_subject_areas($resource->ID);
            }
            if (is_array($subject_areas) && count($subject_areas)>0) {
                $subjects = array_unique($subject_areas, SORT_REGULAR);
            ?>
            <div class="ps-tagcloud">
                <?php foreach($subjects as $subject){ ?>
                    <span><a class="ps-button"><?php echo ucwords($subject->name); ?></a></span>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if (isset($resource_meta['oer_authorname']) && $resource_meta['oer_authorname'][0]!=="") {
                $author_url = "";
                if (isset($resource_meta['oer_authorurl']))
                    $author_url = $resource_meta['oer_authorurl'][0];
                
                $option_set = false;
                if (get_option('oer_authorname_label'))
                    $option_set = true;
            ?>
            <div class="ps-meta-group">
                <label class="ps-label">
                    <?php
                    if (!$option_set)
                        _e("Author:", OER_SLUG);
                    else
                        echo get_option('oer_authorname_label').":";
                    ?> 
                </label>
                <?php if ($author_url=="") : ?>
                    <span class="ps-value"><?php echo $resource_meta['oer_authorname'][0]; ?></span>
                <?php else: ?>
                    <span class="ps-value"><a href="<?php echo $author_url; ?>" target="_blank"><?php echo $resource_meta['oer_authorname'][0]; ?></a></span>
                <?php endif; ?>
            </div>
            <?php } ?>
            <?php if (isset($resource_meta['oer_datecreated_estimate']) && $resource_meta['oer_datecreated_estimate'][0]!=="") {
                
                $option_set = false;
                if (get_option('oer_datecreated_estimate_label'))
                    $option_set = true;
            ?>
            <div class="ps-meta-group">
                <label class="ps-label">
                    <?php
                    if (!$option_set)
                        _e("Date Created Estimate:", OER_SLUG);
                    else
                        echo get_option('oer_datecreated_estimate_label').":";
                    ?>
                </label>
                <span class="ps-value"><?php echo $resource_meta['oer_datecreated_estimate'][0]; ?></span>
            </div>
            <?php } ?>
            <?php if (isset($resource_meta['oer_format'][0]) && $resource_meta['oer_format'][0]!=="") {
                
                $option_set = false;
                if (get_option('oer_format_label'))
                    $option_set = true;
            ?>
            <div class="ps-meta-group">
                <label class="ps-label">
                    <?php
                    if (!$option_set)
                        _e("Format:", OER_SLUG);
                    else
                        echo get_option('oer_format_label').":";
                    ?>
                </label>
                <span class="ps-value"><?php echo ucwords($resource_meta['oer_format'][0]); ?></span>
            </div>
            <?php } ?>
            <?php if (isset($resource_meta['oer_publishername']) && $resource_meta['oer_publishername'][0]!=="") {
                $publisher_url = "";
                if (isset($resource_meta['oer_publisherurl']))
                    $publisher_url = $resource_meta['oer_publisherurl'][0];
                    
                $option_set = false;
                if (get_option('oer_publishername_label'))
                    $option_set = true;
            ?>
            <div class="ps-meta-group">
                <label class="ps-label">
                    <?php
                    if (!$option_set)
                        _e("Publisher:", OER_SLUG);
                    else
                        echo get_option('oer_publishername_label').":";
                    ?>
                </label>
                <?php if ($publisher_url=="") : ?>
                <span class="ps-value"><?php echo $resource_meta['oer_publishername'][0]; ?></span>
                <?php else: ?>
                <span class="ps-value"><a href="<?php echo $publisher_url;  ?>" target="_blank"><?php echo $resource_meta['oer_publishername'][0]; ?></a></span>
                <?php endif; ?>
            </div>
            <?php } ?>
            <?php if (isset($resource_meta['oer_citation'][0]) && $resource_meta['oer_citation'][0]!=="") {
                
                $option_set = false;
                if (get_option('oer_citation_label'))
                    $option_set = true;
            ?>
            <div class="ps-meta-group">
                <label class="ps-label">
                    <?php
                    if (!$option_set)
                        _e("Citation:", OER_SLUG);
                    else
                        echo get_option('oer_citation_label').":";
                    ?>
                </label>
                <span class="ps-value"><?php echo $resource_meta['oer_citation'][0]; ?></span>
            </div>
            <?php } ?>
            <?php //if (isset($resource_meta['oer_interactivity'][0]) && $resource_meta['oer_interactivity'][0]!=="") { ?>
            <!--<div class="ps-meta-group">
                <label class="ps-label">Interactivity:</label>
                <span class="ps-value"><?php echo ucwords($resource_meta['oer_interactivity'][0]); ?></span>
            </div>-->
            <?php //} ?>
            <?php /*if (isset($resource_meta['oer_grade'][0]) && $resource_meta['oer_interactivity'][0]!=="") {
                $grades = explode(",",$resource_meta['oer_grade'][0]);
                if (is_array($grades) && !empty($grades) && $grades[0]!=="" ){
                    if (function_exists('oer_grade_levels'))
                        $grades = oer_grade_levels($grades);*/
            ?>
            <!--<div class="ps-meta-group">
                <label class="ps-label">Grades:</label>
                <span class="ps-value"><?php //echo $grades; ?></span>
            </div>-->
            <?php //}
            //} ?>
            <!--<div class="ps-meta-group">
                <label class="ps-label">Keywords:</label>
            </div>-->
            <?php
            //$keywords = wp_get_post_tags($resource->ID);
            //if(!empty($keywords)) { ?>
            <!--<div class="ps-tagcloud ps-keywords">-->
                <?php //foreach($keywords as $keyword){ ?>
                    <!--<span><a href="<?php //echo esc_url(get_tag_link($keyword->term_id)); ?>" class="ps-button"><?php //echo ucwords($keyword->name); ?></a></span>-->
                <?php //} ?>
            <!--</div>-->
            <?php //} ?>
        </div>
    </div>
    <div class="tab-pane clearfix fade in" id="ps-student-info-tab-content" role="tabpanel" aria-labelledby="ps-student-info-tab">
        <?php echo $student_info; ?>
    </div>
    <div class="tab-pane clearfix fade in" id="ps-teacher-info-tab-content" role="tabpanel" aria-labelledby="ps-teacher-info-tab">
        <?php echo $teacher_info; ?>
    </div>
    <?php if ($transcription_display==true) : ?>
    <div class="tab-pane clearfix fade in" id="ps-transcription-info-tab-content" role="tabpanel" aria-labelledby="ps-transcription-info-tab">
        <?php echo $resource_meta['oer_transcription'][0]; ?>
    </div>
    <?php endif; ?>
    <?php if ($sensitive_material_display==true) : ?>
    <div class="tab-pane clearfix fade in" id="ps-sensitive-info-tab-content" role="tabpanel" aria-labelledby="ps-sensitive-info-tab">
        <?php echo $resource_meta['oer_sensitive_material'][0]; ?>
    </div>
    <?php endif; ?>
</div>
<div class="lp-ajax-loader" role="status">
    <div class="lp-ajax-loader-img">
        <img src="<?php echo OER_LESSON_PLAN_URL."/assets/images/load.gif"; ?>" />
    </div>
</div>
<?php
get_footer();
?>