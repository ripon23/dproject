<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_edit')?> <?=lang('menu_salary_month')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_edit')?> <?=lang('menu_salary_month')?> </legend>
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
            
                
            <div class="form-group <?php echo (form_error('season_name')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-6 control-label" for="season_name"><?=lang('season_name')?> *</label>
              <div class="col-md-6">              	 
                <input id="season_name" name="season_name" type="text" placeholder="<?=lang('season_name')?>" value="<?=$season_info->season_name?>" class="form-control">
                <?php if (form_error('season_name')) :?>                                                  
                	<?php echo form_error('season_name', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
    		
            <div class="form-group <?php echo (form_error('season_name_bn')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-6 control-label" for="season_name_bn"><?=lang('season_name_bn')?> *</label>
              <div class="col-md-6">              	 
                <input id="season_name_bn" name="season_name_bn" type="text" placeholder="<?=lang('season_name_bn')?>" value="<?=$season_info->season_name_bn?>" class="form-control">
                <?php if (form_error('season_name_bn')) :?>                                                  
                	<?php echo form_error('season_name_bn', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-6 control-label" for="season_address"><?=lang('current_season')?>?</label>
              <div class="col-md-6">
               <label class="radio-inline">
                    <input type="radio" name="current_season" id="current_season" value="Yes" <?php if($season_info->current_season=='Yes') echo 'checked';?>> <?=lang('yes')?>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="current_season" id="current_season" value="No" <?php if($season_info->current_season=='No') echo 'checked';?>> <?=lang('no')?>
                </label>
                <?php if (form_error('season_status')) :?>                                                  
                	<?php echo form_error('season_status', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?> 
              </div>
            </div> 
            
           <!-- Site Latitude input-->
            <div class="form-group <?php echo (form_error('season_status')) ? 'has-error' : ''; ?>">
              <label class="col-md-6 control-label" for="season_latitude"><?=lang('status')?> *</label>
              <div class="col-md-6">
                <label class="radio-inline">
                    <input type="radio" name="season_status" id="season_status" value="1" <?php if($season_info->season_status==1) echo 'checked';?>> <?=lang('active')?>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="season_status" id="season_status" value="0" <?php if($season_info->season_status==0) echo 'checked';?>> <?=lang('inactive')?>
                </label>
                <?php if (form_error('season_status')) :?>                                                  
                	<?php echo form_error('season_status', '<p class="text-danger">', '</p>'); ?>                                                  
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
        	<li><a href="./season/season/season_list"><?=lang('action_view')?> <?=lang('menu_salary_month')?> </a></li>
            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
