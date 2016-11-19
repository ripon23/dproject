<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_create')?> <?=lang('menu_designation')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_create')?> <?=lang('menu_designation')?> </legend>
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
            
                
            <div class="form-group <?php echo (form_error('designation_name')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="designation_name"><?=lang('designation_name')?> *</label>
              <div class="col-md-7">              	 
                <input id="designation_name" name="designation_name" type="text" placeholder="<?=lang('designation_name')?>" value="<?=set_value('designation_name')?>" class="form-control">
                <?php if (form_error('designation_name')) :?>                                                  
                	<?php echo form_error('designation_name', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
    		
            <div class="form-group <?php echo (form_error('designation_name_bn')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="designation_name_bn"><?=lang('designation_name_bn')?> *</label>
              <div class="col-md-7">              	 
                <input id="designation_name_bn" name="designation_name_bn" type="text" placeholder="<?=lang('designation_name_bn')?>" value="<?=set_value('designation_name_bn')?>" class="form-control">
                <?php if (form_error('designation_name_bn')) :?>                                                  
                	<?php echo form_error('designation_name_bn', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>            
            
           <!-- Site Latitude input-->
            <div class="form-group <?php echo (form_error('designation_status')) ? 'has-error' : ''; ?>">
              <label class="col-md-5 control-label" for="designation_latitude"><?=lang('status')?> *</label>
              <div class="col-md-7">
                <label class="radio-inline">
                    <input type="radio" name="designation_status" id="designation_status" value="1" <?php if(isset($designation_status)) {if($designation_status==1) echo 'checked';}?>> <?=lang('active')?>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="designation_status" id="designation_status" value="zero" <?php if(isset($designation_status)) {if($designation_status==0) echo 'checked';}?>> <?=lang('inactive')?>
                </label>
                <?php if (form_error('designation_status')) :?>                                                  
                	<?php echo form_error('designation_status', '<p class="text-danger">', '</p>'); ?>                                                  
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
        	<li><a href="./designation/designation/designation_list"><?=lang('action_view')?> <?=lang('menu_designation')?> </a></li>
            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
