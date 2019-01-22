/**
 * All backend custom JavaScript code are here
 *
 */
( function( $ ){

    var LessonPlan = {
        UpdateActivityTitle: function () {
            $(document).on('keyup', '.lp-ac-item input[type=text]', function () {
                var InputValue = $(this).val();
                var ContainerId = $(this).closest('.lp-ac-item').attr('id');
                $('a[href=#' + ContainerId +']').text(InputValue);
            });
        },

        // Add more time elements
        AddMoreTimeElements: function () {
            $(document).on('click', '.lp-add-time-element', function () {
                var ClonedDiv = $('.lp-time-element-row:first').clone();
                ClonedDiv.insertAfter('div.lp-time-element-row:last');
                ClonedDiv.find('input[type=text]').val('');
                ClonedDiv.find(':selected').removeAttr('selected');
                $('.remove-time-element').removeClass('disabled').prop('disabled', false);
            });
        },

        // Remove time elements
        RemoveTimeElements: function () {
            $(document).on('click', '.remove-time-element', function () {
                $(this).closest('.lp-time-element-row').remove();
                if($('.lp-time-element-row').length == 1) {
                    $('.lp-time-element-row .remove-time-element ').addClass('disabled').prop('disabled', true);
                }
            });
        },

        // Add More Related Instructional Objectives
        AddMoreObjectives: function () {
            $(document).on('click', '.lp-add-related-objective', function () {
                var ClonedDiv = $('.lp-related-objective-row:first').clone();
                ClonedDiv.insertAfter('div.lp-related-objective-row:last');
                ClonedDiv.find('input[type=text]').val('');
                $('.lp-remove-related-objective').prop('disabled', false);
            });
        },

        // Remove time elements
        RemoveObjectives: function () {
            $(document).on('click', '.lp-remove-related-objective', function () {
                $(this).closest('.lp-related-objective-row').remove();
                if($('.lp-related-objective-row').length == 1) {
                    $('.lp-related-objective-row .lp-remove-related-objective').prop('disabled', true);
                }
            });
        },

        // Add Activity in Lesson
        AddActivityInLesson: function () {
            $(document).on('click', '.lp-add-ac-item', function () {
                var $TargetDiv = $('.lp-ac-item:last');
                var total_form_box = parseInt($('.lp-ac-item').length, 10);

                $.post(ajaxurl, {action:'lp_add_more_activity_callback', row_id: total_form_box}).done(function (response) {
                    $(response).insertAfter('div.lp-ac-item:last');
                    tinymce.execCommand( 'mceRemoveEditor', false, 'oer-lp-activity-detail-' + total_form_box );
                    tinymce.execCommand( 'mceAddEditor', false, 'oer-lp-activity-detail-' + total_form_box );

                    // Create dynamic elements on sidebar
                    var cloned = $('.sidebar-lesson-activities-title li:last').clone();
                    cloned.find('a').attr('href', '#lp-ac-item-' + total_form_box);
                    cloned.find('a').text('Unnamed Activity');
                    cloned.insertAfter('.sidebar-lesson-activities-title li:last');
                });
              
            });
        }
    };

    // Initialize all function on ready state
    LessonPlan.UpdateActivityTitle();
    LessonPlan.AddMoreTimeElements();
    LessonPlan.RemoveTimeElements();
    LessonPlan.AddMoreObjectives();
    LessonPlan.RemoveObjectives();
    LessonPlan.AddActivityInLesson();

})(jQuery);