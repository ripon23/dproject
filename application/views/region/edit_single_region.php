<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_create')?> <?=lang('menu_region')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_create')?> <?=lang('menu_region')?> </legend>
<form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="" method="post">   
<div class="col-md-6">
	
   <fieldset>
                		                        
			
			<?php 
			if(isset($success_msg))
			{					 
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?=$success_msg?>
			</div>
			<?php
			}
			?>
			
            <?php 
			if(isset($error_msg))
			{					 
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?=$error_msg?>
			</div>
			<?php
			}
			?>
            	
            <!-- Site Name input-->
            
                
            <div class="form-group <?php echo (form_error('region_name')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="region_name"><?=lang('region_name')?> *</label>
              <div class="col-md-7">              	 
                <input id="region_name" name="region_name" type="text" placeholder="<?=lang('region_name')?>" value="<?=$region_info->region_name?>" class="form-control">
                <?php if (form_error('region_name')) :?>                                                  
                	<?php echo form_error('region_name', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
    		
            <div class="form-group <?php echo (form_error('region_name_bn')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="region_name_bn"><?=lang('region_name_bn')?> *</label>
              <div class="col-md-7">              	 
                <input id="region_name_bn" name="region_name_bn" type="text" placeholder="<?=lang('region_name_bn')?>" value="<?=$region_info->region_name_bn?>" class="form-control">
                <?php if (form_error('region_name_bn')) :?>                                                  
                	<?php echo form_error('region_name_bn', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-5 control-label" for="region_address"><?=lang('region_address')?></label>
              <div class="col-md-7">
                <textarea class="form-control" id="region_address" name="region_address" placeholder="<?=lang('region_address')?>" rows="5"><?=$region_info->region_address?></textarea>
              </div>
            </div> 
            
           <!-- Site Latitude input-->
            <div class="form-group <?php echo (form_error('region_status')) ? 'has-error' : ''; ?>">
              <label class="col-md-5 control-label" for="region_latitude"><?=lang('status')?> *</label>
              <div class="col-md-7">
                <label class="radio-inline">
                    <input type="radio" name="region_status" id="region_status" value="1" <?php if($region_info->region_status==1) echo 'checked';?>> <?=lang('active')?>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="region_status" id="region_status" value="zero" <?php if($region_info->region_status==0) echo 'checked';?>> <?=lang('inactive')?>
                </label>
                <?php if (form_error('region_status')) :?>                                                  
                	<?php echo form_error('region_status', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            
            
            
            
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg"><?=lang('action_save')?></button>
              </div>
            </div>
            
          </fieldset>

</div> <!-- col-md-5 -->
</form>

<div class="col-md-3 col-md-offset-3">


    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><a href="./"><?=lang('home')?> </a></li>
        	<li><a href="./region/region/region_list"><?=lang('action_view')?> <?=lang('menu_region')?> </a></li>
            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
