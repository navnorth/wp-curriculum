<?php
/**
 * The Template for displaying all single Curriculum
 */

/**
 * Enqueue the assets
 */
wp_enqueue_style('lesson-plan-load-fa', OER_LESSON_PLAN_URL.'assets/lib/font-awesome/css/font-awesome.min.css');
wp_enqueue_style('lesson-plan-bootstrap', OER_LESSON_PLAN_URL.'assets/lib/bootstrap-3.3.7/css/bootstrap.min.css');

get_header();

global $post;
global $wpdb;
$post_meta_data = get_post_meta($post->ID );
$elements_orders = isset($post_meta_data['lp_order'][0]) ? unserialize($post_meta_data['lp_order'][0]) : array();
//Grade Level
$lp_grade = isset($post_meta_data['oer_lp_grades'][0])? unserialize($post_meta_data['oer_lp_grades'][0])[0]:"";
if ($lp_grade!=="pre-k" && $lp_grade!=="k")
    $lp_grade = "Grade ".$lp_grade;
    
// Download Copy
$download_copy = ($post_meta_data['oer_lp_download_copy'][0]=="yes")? true:false;
$oer_lp_standards = isset($post_meta_data['oer_lp_standards'][0])?unserialize($post_meta_data['oer_lp_standards'][0]):"";
$tags = get_the_terms($post->ID,"post_tag");
$authors = (isset($post_meta_data['oer_lp_authors'][0]) ? unserialize($post_meta_data['oer_lp_authors'][0]) : array());
if (have_posts()) : while (have_posts()) : the_post();
?>
<div class="container">
    <div class="row lp-featured-section">
        <div class="col-md-6 col-sm-12 featured-image padding-0">
            <?php the_post_thumbnail(); ?>
            <div class="tc-lp-grade"><?php echo $lp_grade ?></div>
            <div class="tc-lp-controls">
                <a href=""><i class="fa fa-share-alt"></i></a>
                <?php if ($download_copy): ?>
                <a href=""><i class="fa fa-download"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 curriculum-detail padding-0">
            <div class="tc-lp-details">
                <div class="tc-lp-details-header">
                    <h1 class="tc-lp-title"><?php echo the_title(); ?></h1>
                    <div class="tc-lp-authors-list">
                        <?php
                        if (!empty($authors)){
                            $aIndex = 0;
                            
                            foreach($authors['name'] as $author){
                                $author_url = $authors['author_url'][$aIndex];
                                
                                if (isset($author_url))
                                    echo "<span class='tc-lp-author'><a href='".$author_url."'>".$authors['name'][$aIndex]."</a></span>";
                                else
                                    echo "<span class='tc-lp-author'>".$authors['name'][$aIndex]."</span>";
                                    
                                $aIndex++;
                            }
                        } 
                        ?>
                    </div>
                </div>
                <div class="tc-lp-details-description">
                    <?php echo the_content(); ?>
                </div>
                <div class="tc-lp-details-standards-list">
                    <?php
                    if (is_array($oer_lp_standards)):
                        foreach($oer_lp_standards as $standard){
                            $standard_details = "";
                            if (function_exists('was_standard_details'))
                                $standard_details = was_standard_details($standard);
                        ?>
                        <div class="tc-lp-details-standard">
                            <a href="javascript:void(0)"><?php if ($standard_details): echo $standard_details->description; endif; ?></a>
                        </div>
                        <?php
                        }
                    endif;
                    ?>
                </div>
                <div class="tc-lp-details-tags-list">
                    <?php
                    if ($tags):
                    foreach($tags as $tag){
                    ?>
                    <a href="javascript:void(0)" class="tc-lp-details-tag"><?php echo $tag->name; ?></a>
                    <?php
                    }
                    endif;
                    ?>
                </div>
                <div class="tc-sensitive-material-section">
                    <p><i class="fa fa-exclamation-triangle"></i><span class="sensitive-material-text">Sensitive Material</span></p>
                    <button class="question-popup-button"><i class="fa fa-question-circle-o"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row tc-investigative-section">
        <div class="col-md-3 col-sm-3 col-xs-12 padding-0 custom-pink-bg investigate-section-custom-width">
            <div class="investigate-question-section">
                <p>Investigate Question</p>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12 padding-0 custom-dark-pink-bg excerpt-section-custom-width">
            <div class="col-md-1 col-sm-1 hidden-xs padding-0">
                <div class="tc-pink-triangle"></div>
            </div>
            <div class="col-md-11 col-sm-11">
                <div class="excerpt-section">
                    <h2>Lorem ipsum dolor sit amet, consectetur ?</h2>
                    <div class="show-excerpt-section text-right">
                        <button type="button" class="excerpt-button" data-toggle="collapse" data-target="#demo1">Framework Excerpt<i class="fa fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 tc-padding-0">
                <div id="demo1" class="investigative-section-answer custom-dark-pink-bg collapse">
                    <div class="excerpt-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit qui,
                            reprehenderit! Accusamus fugiat incidunt nihil officia perferendis repudiandae
                            similique soluta tenetur. Adipisci aspernatur corporis mollitia, nemo obcaecati perferendis quod recusandae!</p>
                        <br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Amet assumenda delectus deleniti dolor doloremque, esse eum eveniet
                            ex excepturi exercitationem iusto, molestias omnis pariatur quos repellat tempora ullam veritatis vitae.
                        </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit qui,
                            reprehenderit! Accusamus fugiat incidunt nihil officia perferendis repudiandae
                            similique soluta tenetur. Adipisci aspernatur corporis mollitia, nemo obcaecati perferendis quod recusandae!</p>
                        <br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Amet assumenda delectus deleniti dolor doloremque, esse eum eveniet
                            ex excepturi exercitationem iusto, molestias omnis pariatur quos repellat tempora ullam veritatis vitae.
                        </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit qui,
                            reprehenderit! Accusamus fugiat incidunt nihil officia perferendis repudiandae
                            similique soluta tenetur. Adipisci aspernatur corporis mollitia, nemo obcaecati perferendis quod recusandae!</p>
                        <br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Amet assumenda delectus deleniti dolor doloremque, esse eum eveniet
                            ex excepturi exercitationem iusto, molestias omnis pariatur quos repellat tempora ullam veritatis vitae.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="close-excerpt text-right ">
                                <button type="button" class="excerpt-button" data-toggle="collapse" data-target="#demo1">CLOSE<i class="fa fa-angle-up"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 padding-0">
            <div class="media-image">
                <div class="image-thumbnail">
                    <div class="image-section">
                        <img src="images/machine_works.jpg" alt="" class="img-thumbnail-square img-responsive img-loaded">
                    </div>
                </div>
            </div>
            <div class="sensitive-source">
                <p><i class="fa fa-exclamation-triangle"></i></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($elements_orders)) {
                foreach ($elements_orders as $elementKey => $value) {
                    if($elementKey == 'lp_introduction_order') {?>
                        <?php
                        if(
                            isset($post_meta_data['oer_lp_introduction'][0]) &&
                            !empty($post_meta_data['oer_lp_introduction'][0])
                        )
                        {?>
                            <div class="panel panel-default oer-lp-introduction-group" id="oer-lp-introduction-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <span><?php _e("Introduction", OER_LESSON_PLAN_SLUG); ?></span>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $post_meta_data['oer_lp_introduction'][0];?>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_primary_resources') {?>
                        <?php
                        $primary_resources = (isset($post_meta_data['oer_lp_primary_resources'][0]) ? unserialize($post_meta_data['oer_lp_primary_resources'][0]) : array());
                        if (!empty($primary_resources) && lp_scan_array($primary_resources)) {?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php _e("Primary Resources", OER_LESSON_PLAN_SLUG); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel-group">
                                        <?php
                                        if (!empty(array_filter($primary_resources['resource']))) {
                                            foreach ($primary_resources['resource'] as $resourceKey => $resource) {
                                                $sensitiveMaterial = (isset($primary_resources['sensitive_material'][$resourceKey]) ? $primary_resources['sensitive_material'][$resourceKey]: "");
                                                $teacherInfo = (isset($primary_resources['teacher_info'][$resourceKey]) ? $primary_resources['teacher_info'][$resourceKey]: "");
                                                $studentInfo = (isset($primary_resources['student_info'][$resourceKey]) ? $primary_resources['student_info'][$resourceKey]: "");
                                                ?>
                                                <div class="panel panel-default">
                                                    <!--<div class="panel-heading">
                                                        <h3 class="panel-title"></h3>
                                                    </div>-->
                                                    <div class="panel-body">
                                                        <?php
                                                        if ($sensitiveMaterial == 'yes') {
                                                            echo 'Sensitive Material';
                                                        }
                                                        ?>
                                                        <?php if (!empty($resource)) { ?>
                                                            <div class="form-group">
                                                                <label>OER Resource:</label>
                                                                <?php echo $resource; ?>
                                                            </div>
                                                        <?php }?>
                                                        <?php if (!empty($teacherInfo)) { ?>
                                                            <div class="form-group">
                                                                <label>Teacher Information:</label>
                                                                <?php echo $teacherInfo; ?>
                                                            </div>
                                                        <?php }?>
                                                        <?php if (!empty($studentInfo)) { ?>
                                                            <div class="form-group">
                                                                <label>Student Information:</label>
                                                                <?php echo $studentInfo; ?>
                                                            </div>
                                                        <?php }?>

                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_oer_materials') {?>
                        <?php
                        $materials = (isset($post_meta_data['lp_oer_materials'][0]) ? unserialize($post_meta_data['lp_oer_materials'][0]) : array());
                        if (!empty($materials) && lp_scan_array($materials)) {?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php _e("Materials", OER_LESSON_PLAN_SLUG); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel-group">
                                        <?php
                                        if (!empty(array_filter($materials['url']))) {
                                            foreach ($materials['url'] as $materialKey => $material) {
                                                $file_response = get_file_type_from_url($material);
                                                ?>
                                                <div class="panel panel-default">
                                                    <!--<div class="panel-heading">
                                                        <h3 class="panel-title"></h3>
                                                    </div>-->
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label>Material:</label>
                                                            <?php
                                                            if($oer_lp_download_copy == 'yes') { ?>
                                                                <a href="<?php echo $material?>" target="_blank"><?php echo $file_response['icon'];?></a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0)"><?php echo $file_response['icon'];?></a>
                                                            <?php } ?>
                                                        </div>
                                                        <?php
                                                        if (isset($materials['title'][$materialKey]) &&
                                                            !empty($materials['title'][$materialKey])
                                                        ) {?>
                                                            <div class="form-group">
                                                                <label>Title:</label>
                                                                <span><?php echo $materials['title'][$materialKey];?></span>
                                                            </div>
                                                        <?php }?>
                                                        <?php
                                                        if (isset($materials['description'][$materialKey]) &&
                                                            !empty($materials['description'][$materialKey])
                                                        ) {?>
                                                            <div class="form-group">
                                                                <label>Description:</label>
                                                                <span><?php echo $materials['description'][$materialKey];?></span>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_lesson_times_order') {?>
                        <!--For Lesson Times-->
                        <?php
                        $oer_lp_times_label  = isset($post_meta_data['oer_lp_times_label'][0]) ? unserialize($post_meta_data['oer_lp_times_label'][0]) : array();
                        $oer_lp_times_number = isset($post_meta_data['oer_lp_times_number'][0]) ? unserialize($post_meta_data['oer_lp_times_number'][0]) : array();
                        $oer_lp_times_type   = isset($post_meta_data['oer_lp_times_type'][0]) ? unserialize($post_meta_data['oer_lp_times_type'][0]) : array();
                        ?>
                        <?php if(!empty(array_filter($oer_lp_times_label))) {?>
                            <div class="panel panel-default oer-lp-times-group" id="oer-lp-times-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <?php _e("Lesson Times", OER_LESSON_PLAN_SLUG); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <?php
                                        foreach ($oer_lp_times_label as $key => $item){?>
                                            <?php
                                            $times = ((isset($oer_lp_times_number[$key]) && (!empty($oer_lp_times_number[$key]))) ? $oer_lp_times_number[$key] : '0');
                                            $minutes = (isset($oer_lp_times_type[$key]) ? $oer_lp_times_type[$key] : '');
                                            if(
                                                empty($item) &&
                                                empty($times) &&
                                                ($minutes == 'minutes')
                                            ) {
                                                continue;
                                            }
                                            ?>
                                            <li class="list-group-item">
                                                <?php echo $item;?> -
                                                <?php echo $times;?>
                                                <?php echo $minutes;?>
                                            </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } elseif ($elementKey == 'lp_industries_order') {?>
                        <?php
                        $oer_lp_grades = (isset($post_meta_data['oer_lp_grades'][0]) ? unserialize($post_meta_data['oer_lp_grades'][0]) : array());
                        if(!empty($oer_lp_grades)) {?>
                            <!--For industries/subject/grades-->
                            <div class="panel panel-default oer-lp-industries-group" id="oer-lp-industries-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title">
                                        <?php _e("Industries / Subjects / Grades", OER_LESSON_PLAN_SLUG); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <h4>Grade Levels</h4>
                                    <?php
                                    foreach ($oer_lp_grades as $key => $oer_lp_grade) { ?>
                                        <label><?php echo $oer_lp_grade; ?></label>,
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_standard_order') {?>
                        <!--For Standards and Objectives -->
                        <?php
                        $oer_lp_related_objective = isset($post_meta_data['oer_lp_related_objective'][0]) ? unserialize($post_meta_data['oer_lp_related_objective'][0]) : array();
                        $standards = (isset($post_meta_data['oer_lp_standards'][0])? $post_meta_data['oer_lp_standards'][0] : "");
                        if(!empty(array_filter($oer_lp_related_objective)) || !empty($standards)){?>
                            <div class="panel panel-default oer-lp-standards-group" id="oer-lp-standards-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title">
                                        <?php _e("Standards and Objectives", OER_LESSON_PLAN_SLUG); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div id="selected-standard-wrapper">
                                        <?php
                                        get_standard_notations_from_ids($standards);
                                        ?>
                                    </div>
                                    <?php
                                    foreach ( $oer_lp_related_objective as $key => $item) { ?>
                                        <div class="lp-related-objective-row" id="lp-related-objective-row">
                                            <?php echo $item;?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_activities_order') {?>
                        <!--Activities in this lesson-->
                        <?php
                        // Lesson activity data
                        $oer_lp_activity_title  = isset($post_meta_data['oer_lp_activity_title'][0]) ? unserialize($post_meta_data['oer_lp_activity_title'][0]) : array();
                        $oer_lp_activity_type   = isset($post_meta_data['oer_lp_activity_type'][0]) ? unserialize($post_meta_data['oer_lp_activity_type'][0]) : array();
                        $oer_lp_activity_detail = isset($post_meta_data['oer_lp_activity_detail'][0]) ? unserialize($post_meta_data['oer_lp_activity_detail'][0]) : array();

                        if(!empty(array_filter($oer_lp_activity_title)))
                        {?>
                            <div class="panel panel-default oer-lp-activities-group" id="oer-lp-activities-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title">
                                        <?php _e("Activities in this Lesson", OER_LESSON_PLAN_SLUG); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel-group" id="lp-ac-inner-panel">
                                        <?php foreach ($oer_lp_activity_title as $key => $item) { ?>
                                            <?php
                                            $title       = $item;
                                            $type        = (isset($oer_lp_activity_type[$key]) ? $oer_lp_activity_type[$key] : "");
                                            $description = (isset($oer_lp_activity_detail[$key]) ? $oer_lp_activity_detail[$key] : "");
                                            if(
                                                empty($title) &&
                                                empty($type) &&
                                                empty($description)
                                            ) {
                                                continue;
                                            }
                                            ?>
                                            <div class="panel panel-default lp-ac-item" id="lp-ac-item-<?php echo $key;?>">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label>Activity Title</label>
                                                        <?php echo $title; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Activity Type</label>
                                                        <?php echo $type;?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Activity Description</label>
                                                        <?php echo $description;?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif ($elementKey == 'lp_summative_order') {?>
                        <!--Summative Assessment-->
                        <?php
                        $oer_lp_assessment_type = (isset($post_meta_data['oer_lp_assessment_type'][0]) ? unserialize($post_meta_data['oer_lp_assessment_type'][0]) : array());
                        if (!empty($oer_lp_assessment_type)) {?>
                            <div class="panel panel-default oer-lp-summative-group" id="oer-lp-summative-group">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title">
                                        <?php _e("Summative Assessment", OER_LESSON_PLAN_SLUG); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <h4><?php _e("Assessment Type(s):", OER_LESSON_PLAN_SLUG); ?></h4>
                                    <ul>
                                        <?php foreach ($oer_lp_assessment_type as $key => $oer_lp_assessment) { ?>
                                            <li><?php echo ucfirst($oer_lp_assessment); ?></li>
                                        <?php }?>
                                    </ul>
                                    <?php
                                    $oer_lp_other_assessment_type = (isset($post_meta_data['oer_lp_other_assessment_type'][0]) ? $post_meta_data['oer_lp_other_assessment_type'][0] : '');
                                    if(!empty($oer_lp_other_assessment_type)) {
                                        echo "Others: " . $oer_lp_other_assessment_type;
                                    }
                                    ?>
                                    <div class="form-group">
                                        <?php
                                        echo $oer_lp_assessment = (isset($post_meta_data['oer_lp_assessment'][0]) ? $post_meta_data['oer_lp_assessment'][0] : '');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_lp_custom_editor_') !== false) {?>
                        <!--For custom editor-->
                        <?php
                        $oer_lp_custom_editor = (isset($post_meta_data[$elementKey][0]) ? unserialize($post_meta_data[$elementKey][0]) : "");
                        if(!empty($oer_lp_custom_editor)) { ?>
                            <div class="panel panel-default lp-element-wrapper oer-lp-introduction-group" id="oer-lp-custom-editor-group-<?php echo $key; ?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title"><?php echo $oer_lp_custom_editor['title']; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $oer_lp_custom_editor['description'];?>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_lp_custom_text_list_') !== false) {?>
                        <!--For list-->
                        <?php
                        $oer_lp_custom_text_list = (isset($post_meta_data[$elementKey][0]) ? unserialize($post_meta_data[$elementKey][0]) : array());
                        if (!empty(array_filter($oer_lp_custom_text_list))) {
                            foreach ($oer_lp_custom_text_list as $key => $list) { ?>
                                <div class="panel panel-default lp-element-wrapper" id="oer-lp-text-list-group-<?php echo $key;?>">
                                    <div class="panel-heading">
                                        <h3 class="panel-title lp-module-title">Text List</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php echo $list;?>
                                    </div>
                                </div>
                            <?php }
                        }
                        ?>
                    <?php } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'oer_lp_vocabulary_list_title_') !== false) {?>
                        <!--For vocabulary-->
                        <?php
                        $oer_lp_vocabulary_list_title = (isset($post_meta_data[$elementKey][0]) ? $post_meta_data[$elementKey][0] : "");
                        $listOrder = end(explode('_', $elementKey));
                        $oer_lp_vocabulary_details = (isset($post_meta_data['oer_lp_vocabulary_details_'.$listOrder][0]) ? $post_meta_data['oer_lp_vocabulary_details_'.$listOrder][0] : "");
                        if (!empty($oer_lp_vocabulary_list_title)) { ?>
                            <div class="panel panel-default lp-element-wrapper" id="oer-lp-vocabulary-list-group-<?php echo $key;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title lp-module-title">Vocabulary List</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <p><?php echo $oer_lp_vocabulary_list_title;?></p>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $oer_lp_vocabulary_details;?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php } elseif (isset($post_meta_data[$elementKey]) && strpos($elementKey, 'lp_oer_materials_list_') !== false) {?>
                        <?php
                        $materials = (isset($post_meta_data[$elementKey][0]) ? unserialize($post_meta_data[$elementKey][0]) : array());
                        if (!empty($materials) && lp_scan_array($materials)) {?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php _e("Materials", OER_LESSON_PLAN_SLUG); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel-group">
                                        <?php
                                        if (!empty(array_filter($materials['url']))) {
                                            foreach ($materials['url'] as $materialKey => $material) {
                                                $file_response = get_file_type_from_url($material);
                                                ?>
                                                <div class="panel panel-default">
                                                    <!--<div class="panel-heading">
                                                        <h3 class="panel-title"></h3>
                                                    </div>-->
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label>Material:</label>
                                                            <a href="<?php echo $material?>" target="_blank"><?php echo $file_response['icon'];?></a>
                                                        </div>
                                                        <?php
                                                        if (isset($materials['title'][$materialKey]) &&
                                                            !empty($materials['title'][$materialKey])
                                                        ) {?>
                                                            <div class="form-group">
                                                                <label>Title:</label>
                                                                <span><?php echo $materials['title'][$materialKey];?></span>
                                                            </div>
                                                        <?php }?>
                                                        <?php
                                                        if (isset($materials['description'][$materialKey]) &&
                                                            !empty($materials['description'][$materialKey])
                                                        ) {?>
                                                            <div class="form-group">
                                                                <label>Description:</label>
                                                                <span><?php echo $materials['description'][$materialKey];?></span>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }
                }
            } else {?>
                <?php
                if(
                    isset($post_meta_data['oer_lp_introduction'][0]) &&
                    !empty($post_meta_data['oer_lp_introduction'][0])
                )
                {?>
                    <div class="panel panel-default oer-lp-introduction-group" id="oer-lp-introduction-group">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span><?php _e("Introduction", OER_LESSON_PLAN_SLUG); ?></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $post_meta_data['oer_lp_introduction'][0];?>
                        </div>
                    </div>
                <?php }?>

                <!--For Lesson Times-->
                <?php
                $oer_lp_times_label  = isset($post_meta_data['oer_lp_times_label'][0]) ? unserialize($post_meta_data['oer_lp_times_label'][0]) : array();
                $oer_lp_times_number = isset($post_meta_data['oer_lp_times_number'][0]) ? unserialize($post_meta_data['oer_lp_times_number'][0]) : array();
                $oer_lp_times_type   = isset($post_meta_data['oer_lp_times_type'][0]) ? unserialize($post_meta_data['oer_lp_times_type'][0]) : array();
                ?>
                <?php if(!empty($oer_lp_times_label)) {?>
                    <div class="panel panel-default oer-lp-times-group" id="oer-lp-times-group">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php _e("Lesson Times", OER_LESSON_PLAN_SLUG); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <?php
                                foreach ($oer_lp_times_label as $key => $item){?>
                                    <li class="list-group-item">
                                        <?php echo $item;?> -
                                        <?php echo isset($oer_lp_times_number[$key]) ? $oer_lp_times_number[$key] : '';?>
                                        <?php echo (isset($oer_lp_times_type[$key]) ? $oer_lp_times_type[$key] : '');?>
                                    </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <?php
                $oer_lp_grades = (isset($post_meta_data['oer_lp_grades'][0]) ? unserialize($post_meta_data['oer_lp_grades'][0]) : array());
                if(!empty($oer_lp_grades))
                {?>
                    <!--For industries/subject/grades-->
                    <div class="panel panel-default oer-lp-industries-group" id="oer-lp-industries-group">
                        <div class="panel-heading">
                            <h3 class="panel-title lp-module-title">
                                <?php _e("Industries / Subjects / Grades", OER_LESSON_PLAN_SLUG); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <h4>Grade Levels</h4>
                            <?php
                            foreach ($oer_lp_grades as $key => $oer_lp_grade) { ?>
                                <label><?php echo $oer_lp_grade; ?></label>,
                            <?php }?>
                        </div>
                    </div>
                <?php }?>

                <!--For Standards and Objectives -->
                <?php
                $oer_lp_related_objective = isset($post_meta_data['oer_lp_related_objective'][0]) ? unserialize($post_meta_data['oer_lp_related_objective'][0]) : array();
                if(!empty($oer_lp_related_objective))
                {?>
                    <div class="panel panel-default oer-lp-standards-group" id="oer-lp-standards-group">
                        <div class="panel-heading">
                            <h3 class="panel-title lp-module-title">
                                <?php _e("Standards and Objectives", OER_LESSON_PLAN_SLUG); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            foreach ( $oer_lp_related_objective as $key => $item) { ?>
                                <div class="lp-related-objective-row" id="lp-related-objective-row">
                                    <?php echo $item;?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }?>

                <!--Activities in this lesson-->
                <?php
                // Lesson activity data
                $oer_lp_activity_title  = isset($post_meta_data['oer_lp_activity_title'][0]) ? unserialize($post_meta_data['oer_lp_activity_title'][0]) : array();
                $oer_lp_activity_type   = isset($post_meta_data['oer_lp_activity_type'][0]) ? unserialize($post_meta_data['oer_lp_activity_type'][0]) : array();
                $oer_lp_activity_detail = isset($post_meta_data['oer_lp_activity_detail'][0]) ? unserialize($post_meta_data['oer_lp_activity_detail'][0]) : array();

                if(!empty($oer_lp_activity_title))
                {?>
                    <div class="panel panel-default oer-lp-activities-group" id="oer-lp-activities-group">
                        <div class="panel-heading">
                            <h3 class="panel-title lp-module-title">
                                <?php _e("Activities in this Lesson", OER_LESSON_PLAN_SLUG); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="lp-ac-inner-panel">
                                <?php foreach ($oer_lp_activity_title as $key => $item) { ?>
                                    <div class="panel panel-default lp-ac-item" id="lp-ac-item-<?php echo $key;?>">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>Activity Title</label>
                                                <?php echo $item; ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Activity Type</label>
                                                <?php echo (isset($oer_lp_activity_type[$key]) ? $oer_lp_activity_type[$key] : "");?>
                                            </div>
                                            <div class="form-group">
                                                <label>Activity Description</label>
                                                <?php echo isset($oer_lp_activity_detail[$key]) ? $oer_lp_activity_detail[$key] : "";?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php }?>

                <!--Summative Assessment-->
                <?php
                $oer_lp_assessment_type = (isset($post_meta_data['oer_lp_assessment_type'][0]) ? unserialize($post_meta_data['oer_lp_assessment_type'][0]) : array());
                if (!empty($oer_lp_assessment_type)) {?>
                    <div class="panel panel-default oer-lp-summative-group" id="oer-lp-summative-group">
                        <div class="panel-heading">
                            <h3 class="panel-title lp-module-title">
                                <?php _e("Summative Assessment", OER_LESSON_PLAN_SLUG); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <h4><?php _e("Assessment Type(s):", OER_LESSON_PLAN_SLUG); ?></h4>
                            <ul>
                                <?php foreach ($oer_lp_assessment_type as $key => $oer_lp_assessment) { ?>
                                    <li><?php echo ucfirst($oer_lp_assessment); ?></li>
                                <?php }?>
                            </ul>
                            <?php echo "Others: " . $oer_lp_other_assessment_type = (isset($post_meta_data['oer_lp_other_assessment_type'][0]) ? $post_meta_data['oer_lp_other_assessment_type'][0] : '');?>
                            <div class="form-group">
                                <?php
                                echo $oer_lp_assessment = (isset($post_meta_data['oer_lp_assessment'][0]) ? $post_meta_data['oer_lp_assessment'][0] : '');
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }?>

                <!--For custom editor-->
                <?php
                $oer_lp_custom_editor = (isset($post_meta_data['oer_lp_custom_editor'][0]) ? unserialize($post_meta_data['oer_lp_custom_editor'][0]) : array());
                if(!empty($oer_lp_custom_editor)) {
                    foreach ($oer_lp_custom_editor as $key => $editor) { ?>
                        <div class="panel panel-default lp-element-wrapper oer-lp-introduction-group" id="oer-lp-custom-editor-group-<?php echo $key; ?>">
                            <div class="panel-heading">
                                <h3 class="panel-title lp-module-title">Text Editor</h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                echo $editor;
                                ?>
                            </div>
                        </div>
                    <?php }
                }
                ?>

                <!--For list-->
                <?php
                $oer_lp_custom_text_list = (isset($post_meta_data['oer_lp_custom_text_list'][0]) ? unserialize($post_meta_data['oer_lp_custom_text_list'][0]) : array());
                if (!empty($oer_lp_custom_text_list)) {
                    foreach ($oer_lp_custom_text_list as $key => $list) { ?>
                        <div class="panel panel-default lp-element-wrapper" id="oer-lp-text-list-group-<?php echo $key;?>">
                            <div class="panel-heading">
                                <h3 class="panel-title lp-module-title">Text List</h3>
                            </div>
                            <div class="panel-body">
                                <?php echo $list;?>
                            </div>
                        </div>
                    <?php }
                }
                ?>

                <!--For vocabulary-->
                <?php
                $oer_lp_vocabulary_list_title = (isset($post_meta_data['oer_lp_vocabulary_list_title'][0]) ? unserialize($post_meta_data['oer_lp_vocabulary_list_title'][0]) : array());
                $oer_lp_vocabulary_details = (isset($post_meta_data['oer_lp_vocabulary_details'][0]) ? unserialize($post_meta_data['oer_lp_vocabulary_details'][0]) : array());
                if (!empty($oer_lp_vocabulary_list_title)) {
                    foreach ($oer_lp_vocabulary_list_title as $key => $vocabulary) { ?>
                        <div class="panel panel-default lp-element-wrapper" id="oer-lp-vocabulary-list-group-<?php echo $key;?>">
                            <div class="panel-heading">
                                <h3 class="panel-title lp-module-title">Vocabulary List</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <p><?php echo $vocabulary;?></p>
                                </div>
                                <div class="form-group">
                                    <?php echo isset($oer_lp_vocabulary_details[$key]) ? $oer_lp_vocabulary_details[$key] : "";?>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
                ?>
            <?php }?>

        </div>
    </div>
</div>
<?php
	// Display Activity Objects
 	endwhile; 
endif; 
get_footer();
