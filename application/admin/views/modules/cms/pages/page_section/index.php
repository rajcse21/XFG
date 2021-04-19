<style>
	.page-blocks .ui-state-highlight {
		height: 5.5em;
		line-height: 5.2em;
	}
	
</style>
<div class="admin_content" id="page_content_wrapper">

	<div class="form-group text-right">		
		<a href="javascript:void(0);" data-link="<?php echo base_url(); ?>cms/page-section/globalSection/<?php echo $page_details['page_i18n_id']; ?>"  class="fancybox btn btn-primary"><span class="fa fa-plus fa-w-14"></span> Add Section</a>
	</div>
    <input name="page_i18n_id" type="hidden" id="page_i18n_id" value="<?php echo $page_details['page_i18n_id']; ?>" />
    <input name="section_id" type="hidden" id="section_id" value="" />

	<?php echo $this->view->load('cms/pages/page_section/listing'); ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Processing</h4>
                </div>
                <div class="modal-body">
                    <p>Sort order is being updated...</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>