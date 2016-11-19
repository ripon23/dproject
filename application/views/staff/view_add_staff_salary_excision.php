<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>

</head>
<body>
<?php echo $this->load->view('header'); ?>

<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_add')?> <?=lang('salary_excision')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_add')?> <?=lang('salary_excision')?> </legend>
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
                    <div class="col-md-8">
                    <?=$this->site_model->get_season_name_by_id($season_id)?>                    
                    </div>
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('gpf_excision')?> *</td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('gpf_excision')) ? 'has-error' : ''; ?>">
                     <input id="gpf_excision" name="gpf_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->gpf_excision?>" <?php } else { ?>  value="<?=set_value('gpf_excision')?>" <?php }?> placeholder="<?=lang('gpf_excision')?>" class="form-control" />  
                    <?php if (form_error('gpf_excision')) :?>                                                  
                	<?php echo form_error('gpf_excision', '<p class="text-danger">', '</p>'); ?>                                                  
					<?php endif; ?>
                    </div>
                    </td>
                </tr>
                
                
                <tr>
                	<td><?=lang('gpf_payment')?> </td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('gpf_payment')) ? 'has-error' : ''; ?>">
                     <input id="gpf_payment" name="gpf_payment" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->gpf_payment?>" <?php } else { ?>  value="<?=set_value('gpf_payment')?>" <?php }?> placeholder="<?=lang('gpf_payment')?>" class="form-control" />  
                    <?php if (form_error('gpf_payment')) :?>                                                  
                	<?php echo form_error('gpf_payment', '<p class="text-danger">', '</p>'); ?>                                                  
					<?php endif; ?>
                    </div>
                    </td>
                </tr>
                
                
                <tr>   
                    <td>
                    <?=lang('house_building_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('house_building_excision')) ? 'has-error' : ''; ?>">
                       	<input id="house_building_excision" name="house_building_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->house_building_excision?>" <?php } else { ?>  value="<?=set_value('house_building_excision')?>" <?php }?> placeholder="<?=lang('house_building_excision')?>" class="form-control" />
                       	<?php if (form_error('house_building_excision')) :?>                                                  
                		<?php echo form_error('house_building_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>                
               
               <tr>   
                    <td>
                    <?=lang('house_building_interest')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('house_building_interest')) ? 'has-error' : ''; ?>">
                      <input id="house_building_interest" name="house_building_interest" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->house_building_interest?>" <?php } else { ?>  value="<?=set_value('house_building_interest')?>" <?php }?> placeholder="<?=lang('house_building_interest')?>" class="form-control" />
                      	<?php if (form_error('house_building_interest')) :?>                                                  
                		<?php echo form_error('house_building_interest', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                 
                <tr>   
                    <td>
                    <?=lang('miscellaneous_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('miscellaneous_excision')) ? 'has-error' : ''; ?>">
                        <input id="miscellaneous_excision" name="miscellaneous_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->miscellaneous_excision?>" <?php } else { ?>  value="<?=set_value('miscellaneous_excision')?>" <?php }?> placeholder="<?=lang('miscellaneous_excision')?>" class="form-control" />
                      	<?php if (form_error('miscellaneous_excision')) :?>                                                  
                		<?php echo form_error('miscellaneous_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>  
                      </div>
                    </td>
            	</tr>                
                <tr>
                	<td><?=lang('motorcycle_excision')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('motorcycle_excision')) ? 'has-error' : ''; ?>">
                    	<input id="motorcycle_excision" name="motorcycle_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->motorcycle_excision?>" <?php } else { ?>  value="<?=set_value('motorcycle_excision')?>" <?php }?> placeholder="<?=lang('motorcycle_excision')?>" class="form-control"/>
                    	<?php if (form_error('motorcycle_excision')) :?>                                                  
                		<?php echo form_error('motorcycle_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                    
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('additional_house_rent_excision')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('additional_house_rent_excision')) ? 'has-error' : ''; ?>">
                    <input id="additional_house_rent_excision" name="additional_house_rent_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->additional_house_rent_excision?>" <?php } else { ?>  value="<?=set_value('additional_house_rent_excision')?>" <?php }?> placeholder="<?=lang('additional_house_rent_excision')?>" class="form-control"/>
                    	<?php if (form_error('additional_house_rent_excision')) :?>                                                  
                		<?php echo form_error('additional_house_rent_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
            	
                <tr>
                	<td><?=lang('income_tax')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('income_tax')) ? 'has-error' : ''; ?>">
                    <input id="income_tax" name="income_tax" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->income_tax?>" <?php } else { ?>  value="<?=set_value('income_tax')?>" <?php }?> placeholder="<?=lang('income_tax')?>" class="form-control"/>
                    	<?php if (form_error('income_tax')) :?>                                                  
                		<?php echo form_error('income_tax', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                
                <tr>
                	<td><?=lang('extra_salary_excision')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('extra_salary_excision')) ? 'has-error' : ''; ?>">
                    <input id="extra_salary_excision" name="extra_salary_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_salary_excision?>" <?php } else { ?>  value="<?=set_value('extra_salary_excision')?>" <?php }?> placeholder="<?=lang('extra_salary_excision')?>" class="form-control"/>
                    	<?php if (form_error('extra_salary_excision')) :?>                                                  
                		<?php echo form_error('extra_salary_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                
                <tr>
                	<td><?=lang('ration_subsidy')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('ration_subsidy')) ? 'has-error' : ''; ?>">
                    <input id="ration_subsidy" name="ration_subsidy" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->ration_subsidy?>" <?php } else { ?>  value="<?=set_value('ration_subsidy')?>" <?php }?> placeholder="<?=lang('ration_subsidy')?>" class="form-control"/>
                    	<?php if (form_error('ration_subsidy')) :?>                                                  
                		<?php echo form_error('ration_subsidy', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('spice_excision')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('spice_excision')) ? 'has-error' : ''; ?>">
                        <input id="spice_excision" name="spice_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->spice_excision?>" <?php } else { ?>  value="<?=set_value('spice_excision')?>" <?php }?> placeholder="<?=lang('spice_excision')?>" class="form-control"/>
                      	<?php if (form_error('spice_excision')) :?>                                                  
                		<?php echo form_error('spice_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>
                	<td><?=lang('rc_fresh')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('rc_fresh')) ? 'has-error' : ''; ?>">
                    <input id="rc_fresh" name="rc_fresh" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->rc_fresh?>" <?php } else { ?>  value="<?=set_value('rc_fresh')?>" <?php }?> placeholder="<?=lang('rc_fresh')?>" class="form-control"/>
                    	<?php if (form_error('rc_fresh')) :?>                                                  
                		<?php echo form_error('rc_fresh', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('rc_dry')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('rc_dry')) ? 'has-error' : ''; ?>">
                    <input id="rc_dry" name="rc_dry" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->rc_dry?>" <?php } else { ?>  value="<?=set_value('rc_dry')?>" <?php }?> placeholder="<?=lang('rc_dry')?>" class="form-control"/>
                    	<?php if (form_error('rc_dry')) :?>                                                  
                		<?php echo form_error('rc_dry', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('battalion_loan')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('battalion_loan')) ? 'has-error' : ''; ?>">
                    <input id="battalion_loan" name="battalion_loan" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->battalion_loan?>" <?php } else { ?>  value="<?=set_value('battalion_loan')?>" <?php }?> placeholder="<?=lang('battalion_loan')?>" class="form-control"/>
                    	<?php if (form_error('battalion_loan')) :?>                                                  
                		<?php echo form_error('battalion_loan', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('barber_excision')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('barber_excision')) ? 'has-error' : ''; ?>">
                      <input id="barber_excision" name="barber_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->barber_excision?>" <?php } else { ?>  value="<?=set_value('barber_excision')?>" <?php }?> placeholder="<?=lang('barber_excision')?>" class="form-control"/>
                      	<?php if (form_error('barber_excision')) :?>                                                  
                		<?php echo form_error('barber_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                
                
                 <tr>   
                    <td>
                    <?=lang('fuller_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('fuller_excision')) ? 'has-error' : ''; ?>">
                      <input id="fuller_excision" name="fuller_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->fuller_excision?>" <?php } else { ?>  value="<?=set_value('fuller_excision')?>" <?php }?> placeholder="<?=lang('fuller_excision')?>" class="form-control"/>
                      	<?php if (form_error('fuller_excision')) :?>                                                  
                		<?php echo form_error('fuller_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('washed_allowance_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8 <?php echo (form_error('washed_allowance_excision')) ? 'has-error' : ''; ?>">
                      <input id="washed_allowance_excision" name="washed_allowance_excision" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->washed_allowance_excision?>" <?php } else { ?>  value="<?=set_value('washed_allowance_excision')?>" <?php }?> placeholder="<?=lang('washed_allowance_excision')?>" class="form-control"/>
                      	<?php if (form_error('washed_allowance_excision')) :?>                                                  
                		<?php echo form_error('washed_allowance_excision', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                      </div>

                    </td>
            	</tr>
                
                 <tr>
                	<td><?=lang('rc_bgb_fresh')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('rc_bgb_fresh')) ? 'has-error' : ''; ?>">
                    <input id="rc_bgb_fresh" name="rc_bgb_fresh" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->rc_bgb_fresh?>" <?php } else { ?>  value="<?=set_value('rc_bgb_fresh')?>" <?php }?> placeholder="<?=lang('rc_bgb_fresh')?>" class="form-control"/>
                    	<?php if (form_error('rc_bgb_fresh')) :?>                                                  
                		<?php echo form_error('rc_bgb_fresh', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('rc_bgb_dry')?></td>
                    <td>
                    <div class="col-md-8 <?php echo (form_error('rc_bgb_dry')) ? 'has-error' : ''; ?>">
                    <input id="rc_bgb_dry" name="rc_bgb_dry" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->rc_bgb_dry?>" <?php } else { ?>  value="<?=set_value('rc_bgb_dry')?>" <?php }?> placeholder="<?=lang('rc_bgb_dry')?>" class="form-control"/>
                    	<?php if (form_error('rc_bgb_dry')) :?>                                                  
                		<?php echo form_error('rc_bgb_dry', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('bgb_health_support_subscription')?>
                    </td>                    
                    <td>             
                     <div class="col-md-8 <?php echo (form_error('bgb_health_support_subscription')) ? 'has-error' : ''; ?>">
                     <input id="bgb_health_support_subscription" name="bgb_health_support_subscription" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->bgb_health_support_subscription?>" <?php } else { ?>  value="<?=set_value('bgb_health_support_subscription')?>" <?php }?> placeholder="<?=lang('bgb_health_support_subscription')?>" class="form-control"/>
                     	<?php if (form_error('bgb_health_support_subscription')) :?>                                                  
                		<?php echo form_error('bgb_health_support_subscription', '<p class="text-danger">', '</p>'); ?>                                                  
						<?php endif; ?>
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
                <tr>   
                    <td><?=lang('extra_field_4')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_4" name="extra_field_4" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_4?>" <?php } else { ?>  value="<?=set_value('extra_field_4')?>" <?php }?> placeholder="<?=lang('extra_field_4')?>" class="form-control"/>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('extra_field_5')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_5" name="extra_field_5" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_5?>" <?php } else { ?>  value="<?=set_value('extra_field_5')?>" <?php }?> placeholder="<?=lang('extra_field_5')?>" class="form-control"/>
                    </div>
                    </td>
                </tr> 
                
                <tr>   
                    <td><?=lang('extra_field_6')?></td>
            		<td>
                    <div class="col-md-8">
                        <input id="extra_field_6" name="extra_field_6" type="text" <?php if($previous_season_salary_info) {?> value="<?=$previous_season_salary_info->extra_field_6?>" <?php } else { ?>  value="<?=set_value('extra_field_6')?>" <?php }?> placeholder="<?=lang('extra_field_6')?>" class="form-control"/>
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
