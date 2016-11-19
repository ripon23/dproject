<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head',array('title'=>lang('cms_page_add'))); ?>
    <script type="text/javascript" src="<?php echo base_url().RES_DIR; ?>/tinymce/tinymce.min.js"></script>
    <!-- place in header of your html document -->
	<script>
    tinymce.init({
		selector: "textarea#editor",
		plugins: [
			 "advlist autolink lists link image charmap print preview anchor",
			 "searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste jbimages"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
		height: 300,
		style_formats_merge: true,
		style_formats: [
			{
				title: 'Image Left',
				selector: 'img',
				styles: {
					'float': 'left', 
					'margin': '0 10px 10px 0'
				}
			 },
			 {
				 title: 'Image Right',
				 selector: 'img', 
				 styles: {
					 'float': 'right', 
					 'margin': '0 0 10px 10px'
				 }
			 }
		],
		// ===========================================
		// SET RELATIVE_URLS to FALSE (This is required for images to display properly)
		// ===========================================
		relative_urls: false
	});
	tinymce.init({
		selector: "textarea#editor2",
		plugins: [
			 "advlist autolink lists link image charmap print preview anchor",
			 "searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste jbimages"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
		height: 300,
		style_formats_merge: true,
		style_formats: [
			{
				title: 'Image Left',
				selector: 'img',
				styles: {
					'float': 'left', 
					'margin': '0 10px 10px 0'
				}
			 },
			 {
				 title: 'Image Right',
				 selector: 'img', 
				 styles: {
					 'float': 'right', 
					 'margin': '0 0 10px 10px'
				 }
			 }
		],
		// ===========================================
		// SET RELATIVE_URLS to FALSE (This is required for images to display properly)
		// ===========================================
		relative_urls: false
	});
    </script>
</head>
<body>
<?php echo $this->load->view('header'); ?>
<ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
    <li class="active"><?php echo lang('cms_page_add')?></li>
</ol>

<div class="row">
    <div class="col-md-12">
        <?php if (isset($success)):?>
        <div class="alert alert-success"><strong><span class="glyphicon glyphicon-saved"></span> <?php echo lang('page_success')?> </strong></div>	  
        <?php endif;?>
    </div>
	   
    <div class="col-md-9"> 
    	<div class="well well-lg" style="overflow:hidden;">
        <legend class="text-center"><?=lang('cms_page_add')?> </legend>  	    	
            <form class="form-horizontal" role="form" enctype="multipart/form-data" id="create-site-form"  name="create-site-form" action="<?php echo uri_string();?>" method="post">   
            <table class="table table-bordered">
              <!--<tr class="warning">
                	<td colspan="2"><h2 style="margin:0;"><?php //echo lang('cms_page_add')?></h2></td>
              </tr>-->
              <tr>
              		<td width="170"><label id="page_title_en"><strong><?php echo lang('page_title_en')?></strong></label></td>
                    <td>
                    	<?php echo form_input(array('name' => 'page_title_en', 'id' => 'page_title_en', 'placeholder' => lang('page_title_en'), 'class'=>'form-control input-sm', 'value' => (isset($success))? '': set_value('page_title_en') ? set_value('page_title_en') : (isset($update_page_details->page_title_en) ? $update_page_details->page_title_en : ''), 'maxlength' => 200)); ?>
                    	
                        <?php echo form_error('page_title_en'); ?>  
                   </td>
              </tr>
              <tr>
              		<td><label id="page_title_bn"><strong><?php echo lang('page_title_bn')?></strong></label></td>
                    <td>
                    <?php echo form_input(array('name' => 'page_title_bn', 'id' => 'page_title_bn', 'placeholder' => lang('page_title_bn'), 'class'=>'form-control input-sm', 'value' => (isset($success))? '': set_value('page_title_bn') ? set_value('page_title_bn') : (isset($update_page_details->page_title_bn) ? $update_page_details->page_title_bn : ''), 'maxlength' => 200)); ?>
                   </td>
              </tr>
              <tr>
              		<td><label id="slug"><strong><?php echo lang('cms_page_slug')?></strong></label></td>
                    <td>
                    <?php echo form_input(array('name' => 'slug', 'id' => 'slug', 'placeholder' => lang('cms_page_slug'), 'class'=>'col-md-3 input-sm', 'value' => (isset($success))? '': set_value('slug') ? set_value('slug') : (isset($update_page_details->slug) ? $update_page_details->slug : ''), 'maxlength' => 200)); ?>
                    <?php echo form_error('slug'); ?> 
                   </td>
              </tr>
              <tr>
              		<td><label id="enable"><strong><?=lang('cms_news_status')?></strong></label></td>
                    <td>
                    	<select name="enable"  class="col-md-3 input-sm" id="enable">
                            <option <?php echo (isset($update_page_details->enable) && $update_page_details->enable==0) ? 'selected': '' ?>  value="0"><?php echo lang('cms_inactive') ?></option>
                            <option <?php echo (isset($update_page_details->enable) && $update_page_details->enable==1) ? 'selected': '' ?> value="1"><?php echo lang('cms_active') ?></option>
                        </select>
                    </td>
              </tr>
              <tr>
              		<td><label id="file"><strong><?=lang('cms_image_upload')?></strong><br> (<?php echo lang('cms_image_size')?>)</label></td>
                    <td>
                        <span class="col-md-5">
                    		<input type="file" class="form-control input-sm" name="userfile" id="userfile"> 
                        </span>
                        <span class="col-md-5">
                    		<?php if (isset($update_page_details->thumbnail)) :?> 
                            <?php if ($update_page_details->thumbnail!=NULL || $update_page_details->thumbnail!="") :?>
                            	<img src="<?php echo base_url()."resource/img/page/".$update_page_details->thumbnail?>" class="img-rounded">
                            <?php endif;?>
                            <?php endif;?>
                        </span>
                    </td>
              </tr>
              <tr>
              		<td colspan="2"><label id=""><strong><?php echo lang('page_details_en')?></strong></label></td>
                   
              </tr>
              <tr>
                    <td colspan="2">
                    	<textarea name="page_details_en" id="editor"><?php echo (isset($update_page_details->page_details_en) ? $update_page_details->page_details_en : '')?></textarea>
                    </td>
              </tr>
              <tr>
              		<td colspan="2"><label id=""><strong><?php echo lang('page_details_bn')?></strong></label></td>
                   
              </tr>
              <tr>
                    <td colspan="2">
                    	<textarea name="page_details_bn" id="editor2"><?php echo (isset($update_page_details->page_details_bn) ? $update_page_details->page_details_bn : '')?></textarea>
                    </td>
              </tr>
              <tr>
                    <td colspan="2">
                    	<?php if($action=='create'):?>
                    	<button type="submit" class="btn btn-primary"><?=lang('action_save')?></button>
                        <?php else:?>
                        <button type="submit" class="btn btn-primary"><?=lang('action_update')?></button>
                        <?php endif;?>
                    </td>
              </tr>            
            </table>      
            </form>                
        </div>
    </div> <!-- col-md-9-->
    
    <div class="col-md-3">
        <div class="well well-lg">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled">                
                    <li><a href="<?php echo base_url();?>cms/pages/save"><?=lang('cms_page_add')?> </a></li>
                    <li><a href="<?php echo base_url();?>cms/pages"> <?php echo lang('cms_page_title')?> </a></li>
                </ul>
              </div>
            </div>
        
        </div>
    </div>
</div>


<?php echo $this->load->view('footer'); ?>
