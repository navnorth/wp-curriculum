<!-- Modal -->
<div class="modal fade" id="lpOerStandardModal" tabindex="-1" role="dialog" aria-labelledby="lpOerStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="lpOerStandardModalLabel">Add Standard</h4>
            </div>
            <div id="standards-list" class="modal-body">
                <div class="lp-standard-search-bar">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text"
                                   name="searchStandard"
                                   class="form-control"
                                   id="exampleInputAmount"
                                   placeholder="Search Standards">
                            <div class="input-group-addon"><i class="fa fa-search"></i> </div>
                        </div>
                    </div>
                </div>
                <?php
                lp_oer_display_standards();
                if (function_exists('was_selectable_admin_standards')){
                    global $post;
                    was_selectable_admin_standards($post->ID);
                }?>
            </div>
            <div class="modal-footer">
                <button type="button" id="lpSelectStandardSaveBtn" class="btn btn-default btn-sm" data-dismiss="modal">Select</button>
            </div>
        </div>
    </div>
</div>