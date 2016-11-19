<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head',array('title'=>lang('menu_slide_add'))); ?>    
</head>
<body>
<?php echo $this->load->view('header'); ?>
<ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
    <li class="active"><?php echo lang('menu_slide_add')?></li>
</ol>

<div class="row">
    <div class="col-md-12">
        <?php if (isset($success)):?>
        <div class="alert alert-success"><strong><span class="glyphicon glyphicon-saved"></span> <?php echo lang('gallery_success')?> </strong></div>	  
        <?php endif;?>
    </div>
	   
    <div class="col-md-9"> 
    	<div class="well well-lg" style="overflow:hidden;">
        <legend class="text-center"><?=lang('menu_slide_add')?> </legend>  	    	
            <form class="form-horizontal" role="form" id="create-site-form" enctype="multipart/form-data" name="create-site-form" action="<?php echo uri_string();?>" method="post">   
            <table class="table table-bordered">
              <!--<tr class="warning">
                	<td colspan="2"><h2 style="margin:0;"><?php //echo lang('cms_gallery_add')?></h2></td>
              </tr>-->
              <tr>
              		<td width="170"><label id="gallery_title_en"><strong><?php echo lang('image_caption_en')?></strong></label></td>
                    <td>
                    	<?php echo form_input(array('name' => 'image_caption_en', 'id' => 'gallery_title_en', 'placeholder' => lang('image_caption_en'), 'class'=>'form-control input-sm', 'value' => set_value('image_caption_en') ? set_value('image_caption_en') : (isset($update_slide_details->image_caption_en) ? $update_slide_details->image_caption_en : ''), 'maxlength' => 200)); ?>
                    	
                        <span style="color:red;"><?php echo form_error('image_caption_en'); ?></span>  
                   </td>
              </tr>
              <tr>
              		<td><label id="gallery_title_bn"><strong><?php echo lang('image_caption_bn')?></strong></label></td>
                    <td>
                    <?php echo form_input(array('name' => 'image_caption_bn', 'id' => 'gallery_title_bn', 'placeholder' => lang('image_caption_bn'), 'class'=>'form-control input-sm', 'value' => set_value('gallery_name_bn') ? set_value('image_caption_bn') : (isset($update_slide_details->image_caption_bn) ? $update_slide_details->image_caption_bn : ''), 'maxlength' => 200)); ?>
                   </td>
              </tr>
              
              <tr>
              		<td><label id="enable"><strong><?=lang('cms_news_status')?></strong></label></td>
                    <td>
                    	<select name="enable"  class="col-md-3 input-sm" id="enable">
                            <option <?php echo (isset($update_slide_details->enable) && $update_slide_details->enable==0) ? 'selected': '' ?>  value="0"><?php echo lang('cms_inactive') ?></option>
                            <option <?php echo (isset($update_slide_details->enable) && $update_slide_details->enable==1) ? 'selected': '' ?> value="1"><?php echo lang('cms_active') ?></option>
                        </select>
                    </td>
              </tr>
              <tr>
              		<td><label id="file"><strong><?=lang('cms_image_upload')?></strong> <br> (<?php echo lang('cms_image_size_thumb')?>)</label></td>
                    <td>
                    	<span class="col-md-5">
                    		<input type="file" class="form-control input-sm col-md-5" name="userfile" id="userfile"> 
                        </span>
                        <span class="col-md-5">
                    		<?php if (isset($update_slide_details->slide_thumb)) :?> 
                            <?php if ($update_slide_details->slide_thumb!=NULL || $update_slide_details->slide_thumb!="") :?>
                            	<img src="<?php echo base_url()."resource/img/sliders/".$update_slide_details->slide_thumb?>" class="img-rounded">
                            <?php endif;?>
                            <?php endif;?>
                        </span>
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
                    <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/slider"><?php echo lang('cms_slide_image_page_title')?> </a></li>
            <li><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/slider/save"> <?php echo lang('menu_slide_add')?> </a></li>
           
                </ul>
              </div>
            </div>
        
        </div>
    </div>
</div>


<?php echo $this->load->view('footer'); ?>
