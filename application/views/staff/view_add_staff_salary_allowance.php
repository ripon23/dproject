<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>

</head>
<body>
<?php echo $this->load->view('header'); ?>

<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_add')?> <?=lang('salary_allowance')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_add')?> <?=lang('salary_allowance')?> </legend>
<form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="" method="post" enctype="multipart/form-data">   
<div class="col-md-9">
	
   <fieldset>
			
            <?php                		                        
			if(isset($error))
            {					 
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?=$error?>
            </div>
            <?php
            }
            ?>				
            
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
            
            <table class="table table-striped">
              <tr class="success">
                <td><?=lang('staff_id')?>: <?=$staff_info->staff_id?></td>
                <td><?=lang('staff_name')?>:
				<?php
				$language = $this->session->userdata('site_lang');
				if($language=='bangla')
				echo $staff_info->staff_name_bangla;
				else
				echo $staff_info->fullname;			
				?>
                </td>
                <td><?=lang('menu_designation')?>: <?php echo $this->site_model->get_designation_name_by_id($staff_info->designation_id);?></td>
              </tr>
            </table>

            	
            <!-- Patient  input-->
            <table class="table table-bordered table-striped">
            	
                <tr>
                	<td><?=lang('season_name')?> *</td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('season_id')) ? 'has-error' : ''; ?>">
                    <?php $language = $this->session->userdata('site_lang'); ?>
                    <select name="season_id" class="form-control">
                      	<option value=""><?php echo lang('select'); ?></option>
                        <?php foreach ($season_info as $season) : ?>
                        <option value="<?=$season->season_id?>" <?php if($season->current_season=="Yes")  echo "selected"; ?>><?php if($language=='bangla') echo $season->season_name_bn; else echo $season->season_name; ?></option>
                        <?php endforeach; ?>
	                </select>
                    <?php if (form_error('season_id')) :?>                                                  
                	<?php echo form_error('season_id', '<p class="text-danger">', '</p>'); ?>                                                  
					<?php endif; ?>
                    </div>
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('main_salary')?> *</td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('main_salary')) ? 'has-error' : ''; ?>">
                     <input id="main_salary" name="main_salary" type="text" value="<?=$staff_info->main_salary?>" placeholder="<?=lang('main_salary')?>" class="form-control" />  
                    <?php if (form_error('main_salary')) :?>                                                  
                	<?php echo form_error('main_salary', '<p class="text-danger">', '</p>'); ?>                                                  
					<?php endif; ?>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('house_rent')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('house_rent')) ? 'has-error' : ''; ?>">
                       	<input id="house_rent" name="house_rent" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->house_rent?>" <?php } else { ?>  value="<?=set_value('house_rent')?>" <?php }?> placeholder="<?=lang('house_rent')?>" class="form-control" />
                       	<?php if (form_error('house_rent')) :?>                                                  
                		<?php echo form_error('house_rent', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>                
               
               <tr>   
                    <td>
                    <?=lang('treatment_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('treatment_allowance')) ? 'has-error' : ''; ?>">
                      <input id="treatment_allowance" name="treatment_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->treatment_allowance?>" <?php } else { ?>  value="<?=set_value('treatment_allowance')?>" <?php }?> placeholder="<?=lang('treatment_allowance')?>" class="form-control" />
                      	<?php if (form_error('treatment_allowance')) :?>                                                  
                		<?php echo form_error('treatment_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                 
                <tr>   
                    <td>
                    <?=lang('transportation_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('transportation_allowance')) ? 'has-error' : ''; ?>">
                        <input id="transportation_allowance" name="transportation_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->transportation_allowance?>" <?php } else { ?>  value="<?=set_value('transportation_allowance')?>" <?php }?> placeholder="<?=lang('transportation_allowance')?>" class="form-control" />
                      	<?php if (form_error('transportation_allowance')) :?>                                                  
                		<?php echo form_error('transportation_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>  
                      </div>
                    </td>
            	</tr>                
                <tr>
                	<td><?=lang('border_allowance')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('border_allowance')) ? 'has-error' : ''; ?>">
                    	<input id="border_allowance" name="border_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->border_allowance?>" <?php } else { ?>  value="<?=set_value('border_allowance')?>" <?php }?> placeholder="<?=lang('border_allowance')?>" class="form-control"/>
                    	<?php if (form_error('border_allowance')) :?>                                                  
                		<?php echo form_error('border_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                    
                    </td>
                </tr>
                <tr>
                	<td><?=lang('tiffin_allowance')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('tiffin_allowance')) ? 'has-error' : ''; ?>">
                    <input id="tiffin_allowance" name="tiffin_allowance" type="tiffin_allowance" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->tiffin_allowance?>" <?php } else { ?>  value="<?=set_value('tiffin_allowance')?>" <?php }?> placeholder="<?=lang('tiffin_allowance')?>" class="form-control"/>
                    	<?php if (form_error('tiffin_allowance')) :?>                                                  
                		<?php echo form_error('tiffin_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
            	
                
                <tr>   
                    <td>
                    <?=lang('mountains_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('mountains_allowance')) ? 'has-error' : ''; ?>">
                        <input id="mountains_allowance" name="mountains_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->mountains_allowance?>" <?php } else { ?>  value="<?=set_value('mountains_allowance')?>" <?php }?> placeholder="<?=lang('mountains_allowance')?>" class="form-control"/>
                      	<?php if (form_error('mountains_allowance')) :?>                                                  
                		<?php echo form_error('mountains_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('education_help_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('education_help_allowance')) ? 'has-error' : ''; ?>">
                      <input id="education_help_allowance" name="education_help_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->education_help_allowance?>" <?php } else { ?>  value="<?=set_value('education_help_allowance')?>" <?php }?> placeholder="<?=lang('education_help_allowance')?>" class="form-control"/>
                      	<?php if (form_error('education_help_allowance')) :?>                                                  
                		<?php echo form_error('education_help_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                
                
                 <tr>   
                    <td>
                    <?=lang('costly_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('costly_allowance')) ? 'has-error' : ''; ?>">
                      <input id="costly_allowance" name="costly_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->costly_allowance?>" <?php } else { ?>  value="<?=set_value('costly_allowance')?>" <?php }?> placeholder="<?=lang('costly_allowance')?>" class="form-control"/>
                      	<?php if (form_error('costly_allowance')) :?>                                                  
                		<?php echo form_error('costly_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('servant_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('servant_allowance')) ? 'has-error' : ''; ?>">
                      <input id="servant_allowance" name="servant_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->servant_allowance?>" <?php } else { ?>  value="<?=set_value('servant_allowance')?>" <?php }?> placeholder="<?=lang('servant_allowance')?>" class="form-control"/>
                      	<?php if (form_error('servant_allowance')) :?>                                                  
                		<?php echo form_error('servant_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>

                    </td>
            	</tr>
                
                
                <tr>   
                    <td>
                    <?=lang('employee_allowance')?>
                    </td>                    
                    <td>             
                     <div class="col-md-8 <?php echo (form_error('employee_allowance')) ? 'has-error' : ''; ?>">
                     <input id="employee_allowance" name="employee_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->employee_allowance?>" <?php } else { ?>  value="<?=set_value('employee_allowance')?>" <?php }?> placeholder="<?=lang('employee_allowance')?>" class="form-control"/>
                     	<?php if (form_error('employee_allowance')) :?>                                                  
                		<?php echo form_error('employee_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                     </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('washed_allowance')?>  
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('washed_allowance')) ? 'has-error' : ''; ?>">
                      <input id="washed_allowance" name="washed_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->washed_allowance?>" <?php } else { ?>  value="<?=set_value('washed_allowance')?>" <?php }?> placeholder="<?=lang('washed_allowance')?>" class="form-control" />
                      	<?php if (form_error('washed_allowance')) :?>                                                  
                		<?php echo form_error('washed_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>                      
                      
                    </td>
            	</tr>
               
                <tr>
                	<td>
               		<?=lang('barber_allowance')?>  
    				</td>
    				<td>
      	              	<div class="col-md-8 <?php echo (form_error('barber_allowance')) ? 'has-error' : ''; ?>">
                		<input class="form-control" id="barber_allowance" name="barber_allowance" placeholder="<?=lang('barber_allowance')?>" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->barber_allowance?>" <?php } else { ?>  value="<?=set_value('barber_allowance')?>" <?php }?>/>
              			<?php if (form_error('barber_allowance')) :?>                                                  
                		<?php echo form_error('barber_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                        </div>                
                    </td>
                 <tr>   
                    <td>
                    <?=lang('fuller_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('fuller_allowance')) ? 'has-error' : ''; ?>">
                        <input id="fuller_allowance" name="fuller_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->fuller_allowance?>" <?php } else { ?>  value="<?=set_value('fuller_allowance')?>" <?php }?> placeholder="<?=lang('fuller_allowance')?>" class="form-control"/>
                        <?php if (form_error('fuller_allowance')) :?>                                                  
                		<?php echo form_error('fuller_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                
                    </td>
            	</tr>                
            	<tr>   
                    <td><?=lang('leave_allowance')?> </td>
            		<td>
                    <div class="col-md-8 <?php echo (form_error('leave_allowance')) ? 'has-error' : ''; ?>">                        
                        <input id="leave_allowance" name="leave_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->leave_allowance?>" <?php } else { ?>  value="<?=set_value('leave_allowance')?>" <?php }?> placeholder="<?=lang('leave_allowance')?>" class="form-control"/>
                        <?php if (form_error('leave_allowance')) :?>                                                  
                		<?php echo form_error('leave_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>
                    </td>
                </tr>     
            
            	<tr>   
                    <td><?=lang('ration_allowance')?></td>
            		<td>
                    <div class="col-md-8 <?php echo (form_error('season_id')) ? 'has-error' : ''; ?>">
                        <input id="ration_allowance" name="ration_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->ration_allowance?>" <?php } else { ?>  value="<?=set_value('ration_allowance')?>" <?php }?> placeholder="<?=lang('ration_allowance')?>" class="form-control"/>
                        <?php if (form_error('ration_allowance')) :?>                                                  
                		<?php echo form_error('ration_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>
                    </td>
                </tr>
                <tr>   
                    <td><?=lang('new_year_allowance')?></td>
            		<td>
                    <div class="col-md-8 <?php echo (form_error('new_year_allowance')) ? 'has-error' : ''; ?>">
                        <input id="new_year_allowance" name="new_year_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->new_year_allowance?>" <?php } else { ?>  value="<?=set_value('new_year_allowance')?>" <?php }?> placeholder="<?=lang('new_year_allowance')?>" class="form-control"/>
                    <?php if (form_error('new_year_allowance')) :?>                                                  
                	<?php echo form_error('new_year_allowance', '<p class="text-danger">', '</p>'); ?>                                                  
					<?php endif; ?>    
                    </div>
                    </td>
                </tr>
                
                
                
               <tr>   
                    <td><?=lang('time_scale')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="time_scale" name="time_scale" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->time_scale?>" <?php } else { ?>  value="<?=set_value('time_scale')?>" <?php }?> placeholder="<?=lang('time_scale')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
                
                
                <tr>   
                    <td><?=lang('earn_leave')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="earn_leave" name="earn_leave" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->earn_leave?>" <?php } else { ?>  value="<?=set_value('earn_leave')?>" <?php }?> placeholder="<?=lang('earn_leave')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
               
               <tr>   
                    <td><?=lang('festival_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="festival_allowance" name="festival_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->festival_allowance?>" <?php } else { ?>  value="<?=set_value('festival_allowance')?>" <?php }?> placeholder="<?=lang('festival_allowance')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
               
               
               <tr>   
                    <td><?=lang('entertainment_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="entertainment_allowance" name="entertainment_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->entertainment_allowance?>" <?php } else { ?>  value="<?=set_value('entertainment_allowance')?>" <?php }?> placeholder="<?=lang('entertainment_allowance')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
               
               
               <tr>   
                    <td><?=lang('gpf_advanced')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="gpf_advanced" name="gpf_advanced" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->gpf_advanced?>" <?php } else { ?>  value="<?=set_value('gpf_advanced')?>" <?php }?> placeholder="<?=lang('gpf_advanced')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
               
               <tr>   
                    <td><?=lang('subsidiary_salary_or_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="subsidiary_salary_or_allowance" name="subsidiary_salary_or_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->subsidiary_salary_or_allowance?>" <?php } else { ?>  value="<?=set_value('subsidiary_salary_or_allowance')?>" <?php }?> placeholder="<?=lang('subsidiary_salary_or_allowance')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
               
               <tr>   
                    <td><?=lang('honorary_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="honorary_allowance" name="honorary_allowance" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->honorary_allowance?>" <?php } else { ?>  value="<?=set_value('honorary_allowance')?>" <?php }?> placeholder="<?=lang('honorary_allowance')?>" class="form-control"/>
                    </div>
                    </td>
                </tr> 
                
                
                
                
                
                <tr>   
                    <td><?=lang('gpf_number')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="gpf_number" name="gpf_number" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->gpf_number?>" <?php } else { ?>  value="<?=set_value('gpf_number')?>" <?php }?> placeholder="<?=lang('gpf_number')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>
                <tr>   
                    <td><?=lang('extra_field_1')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_1" name="extra_field_1" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_1?>" <?php } else { ?>  value="<?=set_value('extra_field_1')?>" <?php }?> placeholder="<?=lang('extra_field_1')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('extra_field_2')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_2" name="extra_field_2" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_2?>" <?php } else { ?>  value="<?=set_value('extra_field_2')?>" <?php }?> placeholder="<?=lang('extra_field_2')?>" class="form-control"/>
                    </div>
                    </td>
                </tr> 
                
                <tr>   
                    <td><?=lang('extra_field_3')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_3" name="extra_field_3" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_3?>" <?php } else { ?>  value="<?=set_value('extra_field_3')?>" <?php }?> placeholder="<?=lang('extra_field_3')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>               
            </table>
                                        
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg"><?=lang('action_save')?></button>
              </div>
            </div>
            
          </fieldset>

</div> <!-- col-md-5 -->
</form>

<div class="col-md-3">


    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><a href="./"><?=lang('menu_home')?> </a></li>
        	<li><a href="./staff/staff/staff_details_list"><?=lang('action_view')?> <?=lang('menu_staff')?> </a></li>
            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
