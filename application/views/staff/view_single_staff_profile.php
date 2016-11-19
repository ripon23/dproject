<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head');
	?>
	<script type="text/javascript" src="<?php echo base_url().RES_DIR; ?>/dist/js/bootstrap-datepicker.min.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/dist/css/bootstrap-datepicker.min.css"/>
	
	<script type="text/javascript">
		// When the document is ready
		$(document).ready(function () {			
			$('#date1').datepicker({
				format: "yyyy/mm/dd",
				autoclose:true,
				todayHighlight:true
			}); 
			$('#date2').datepicker({
				format: "yyyy/mm/dd",
				autoclose:true,
				todayHighlight:true
			});  
		
		});
	</script>
	<script>
	$(function(){
		$('a[title]').tooltip();
		});
	
	$(function () {
	var activeTab = $('[href=' + location.hash + ']');
	activeTab && activeTab.tab('show');
	});
	
	
	
	function deleteclick_id(checkup_id)
	{
		
		var agree=confirm("Are you sure you want to delete this checkup?");
		if(agree)
		{
	
		$.ajax({
			   type: "POST",
			   url: "patients/patient/delete_checkup",
			   data: "checkup_id="+checkup_id,
			   success: function(msg)
			   {               	
					var result = $.trim(msg);    				
					if(result==="Successfully deleted")
					{
					$('#row_' + checkup_id).addClass('error');			  
					//document.getElementById('row_' + numeric).style.backgroundColor = 'red';
					$('#row_' + checkup_id).fadeOut(4000, function(){   				
					//$("#row_"+ numeric).remove();
					$('#row_' + checkup_id).removeClass('error');
					});
					}
				alert(msg); // show response from the php script.			      	
			   }
			 });
	
		return false; // avoid to execute the actual submit of the form.
		}// END IF
		else
		{
			return false; // avoid to execute the actual submit of the form.
		}
				
	}// END deleteclick_id
	</script>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_view')?> <?=lang('menu_patient_profile')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('menu_patient_profile')?> </legend>

				<div class="board">
					<!-- <h2>Welcome to IGHALO!<sup></sup></h2>-->
					<div class="board-inner">
					<ul class="nav nav-tabs" id="myTab">
					<div class="liner"></div>
					<li class="active">
					<a href="#home" data-toggle="tab" title="Home">
					  <span class="round-tabs one">
							 <i class="glyphicon glyphicon-home"></i>
					  </span> 
					</a></li>
					
					<li><a href="#profile" data-toggle="tab" title="Profile">
					 <span class="round-tabs two">
						 <i class="glyphicon glyphicon-user"></i>
					 </span></a>            				
					</li>
					
					
					<li><a href="#checkup" data-toggle="tab" title="Monthly salary">
						<span class="round-tabs four">
						<i class="glyphicon glyphicon-usd"></i>
						</span></a>
					</li>
					
					 
					</ul>
					</div>
					
					<div class="tab-content">
						<div class="tab-pane fade in active" id="home">
						<!--- Start 1 -->
						<div class="col-md-12">         
									
								<!-- Site Name input-->
								<table class="table table-striped">            	
									<tr>
										<td rowspan="11" align="center">
										<?php
										if($staff_info->picture)
										{
											
											if(preg_match('/gravatar.com/',$staff_info->picture)) //gravatar.com
											{
												echo '<img src="'.$staff_info->picture.'" alt="'.$staff_info->fullname.'" title="'.$staff_info->fullname.'" class="img-circle" width="128px" height="128px" />';
												echo "<br/>".$staff_info->fullname;
											}
											else	//Uploded image
											{					
												echo '<img src="'.base_url().RES_DIR.'/user/profile/'.$staff_info->picture.'" alt="'.$staff_info->fullname.'" title="'.$staff_info->fullname.'" class="img-circle" width="128px" height="128px" />';
												echo "<br/>".$staff_info->fullname;
											}
										
										}
										else
										{
										//Deafult pic
			
										if($staff_info->gender=='m')
										echo '<img src="'.base_url().RES_DIR.'/img/user_male.png" alt="'.$staff_info->fullname.'" title="'.$staff_info->fullname.'" class="img-circle" width="128px" height="128px" />';
										else if($staff_info->gender=='f')
										echo '<img src="'.base_url().RES_DIR.'/img/user_female.png" alt="'.$staff_info->fullname.'" title="'.$staff_info->fullname.'" class="img-circle" width="128px" height="128px" />';
										else                                        
										echo '<img src="'.base_url().RES_DIR.'/img/default-person.png" alt="'.$staff_info->fullname.'" title="'.$staff_info->fullname.'" class="img-circle" width="128px" height="128px" />';
										echo "<br/>".$staff_info->fullname;
										}
										?> 
										</td>
										<td><?=lang('user_name')?></td>
										<td><?=$staff_info->username?></td>
									</tr>                                    
									<tr>
										<td>
										<?=lang('staff_id')?>  
										</td>
										<td>
										<?=$staff_info->staff_id ?>  	               
										</td>
									</tr> 
									<tr>
										<td>
										<?=lang('user')?> <?=lang('create_date')?>  
										</td>
										<td>
										<?=$staff_info->create_date?>  	               
										</td>
									</tr> 
									<tr>
										<td>
										<?=lang('last_login')?>  
										</td>
										<td>
										<?=$staff_info->lastsignedinon?>
										</td>
									</tr> 
                                   <tr>
										<td>
										<?=lang('company')?>  
										</td>
										<td>
										<?=$this->site_model->get_company_name_by_id($staff_info->company_id)?>
										</td>
									</tr> 
                                   
                                    <tr>
										<td>
										<?=lang('menu_region')?>  
										</td>
										<td>
										<?=$this->site_model->get_region_name_by_id($staff_info->region_id)?>
										</td>
									</tr> 
                                    <tr>
										<td>
										<?=lang('menu_sector')?>  
										</td>
										<td>
										<?=$this->site_model->get_sector_name_by_id($staff_info->sector_id)?>
										</td>
									</tr> 
									<tr>
										<td>
										<?=lang('menu_battalion')?>  
										</td>
										<td>
										<?php
										$all_user_battalion=$this->site_model->get_all_user_battalion($staff_info->id);
										foreach ($all_user_battalion as $user_battalion) :
											echo '<span class="label label-primary">'.$this->site_model->get_battalion_name_by_id($user_battalion->battalion_id).'</span> ';
										endforeach; 
										?>
										</td>
									</tr>                                      
												  
								</table>
													
					
					</div> <!-- col-md-12 -->
					
					
					  
											  
						  
					  <!--- End 1 -->    
					  </div>
					  
					  
					  <div class="tab-pane fade" id="profile">
						  
						  <!--- Start 2 -->
						<div class="col-md-9">
	
						<fieldset>      
								<!-- Site Name input-->
								<table class="table table-striped">            	
									
									<tr>
										<td>
										<?=lang('fullname')?>  
										</td>
										<td>
										<?php
										$language = $this->session->userdata('site_lang');
										if($language=='bangla')
										echo $staff_info->staff_name_bangla;
										else
										echo $staff_info->fullname;			
										?>
										</td>
									</tr>                                    
                                    <tr>
										<td>
										<?=lang('designation_name')?>  
										</td>
										<td>
										<?php echo $this->site_model->get_designation_name_by_id($staff_info->designation_id);?>
										</td>
									</tr>
									<tr>
										<td>
										<?=lang('email')?>  
										</td>
										<td>
										<a href="mailto:<?=$staff_info->email?>"><?=$staff_info->email?></a>
										</td>
									</tr>
									<tr>
										<td>
										<?=lang('staff_id')?>  
										</td>
										<td>
										<?=$staff_info->staff_id ?>  	               
										</td>
									</tr> 
									<tr>
										<td>
										<?=lang('gender')?>  
										</td>
										<td>
										<?php 
										if($staff_info->gender=='m')
										echo lang('gender_male');
										else if($staff_info->gender=='f')
										echo lang('gender_female');
										else
										echo '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>';
										?>
										</td>
									</tr> 
									<tr>
										<td>
										<?=lang('date_of_birth')?>  
										</td>
										<td>
										<?=$staff_info->dateofbirth?>  	               
										</td>
									</tr>
									<tr>
										<td>
										<?=lang('age')?>  
										</td>
										<td>
										<?php 
										$date = new DateTime($staff_info->dateofbirth);
										$now = new DateTime();
										$interval = $now->diff($date);
										echo $interval->y;
										//$staff_info->age
										
										?>
										</td>
									</tr>
									<tr>
										<td>
										<?=lang('address')?>  
										</td>
										<td>
										<?=$staff_info->address?>  	               
										</td>
									</tr>
                                    <tr>
										<td>
										<?=lang('joining_date')?>  
										</td>
										<td>
										<?=$staff_info->joining_date?>  	               
										</td>
									</tr>
									<tr>   
										<td>
										<?=lang('mobile_no')?> *
										</td>                    
										<td>             
										<?=$staff_info->mobile?> 
										</td>
									</tr>
                                    
                                    <tr>   
										<td>
										<?=lang('bank_account_no')?> 
										</td>                    
										<td>             
										<?=$staff_info->bank_account_no?> 
										</td>
									</tr>
                                    
                                    <tr>   
										<td>
										<?=lang('successor')?> 
										</td>                    
										<td>             
										<?=$staff_info->successor?> 
										</td>
									</tr>
                                    
                                    <tr>   
										<td>
										<?=lang('educational_qualification')?> 
										</td>                    
										<td>             
										<?=$staff_info->educational_qualification?> 
										</td>
									</tr>
                                    
                                    <tr>   
										<td>
										<?=lang('marital_status')?> 
										</td>                    
										<td>             
										<?=$staff_info->marital_status?> 
										</td>
									</tr>
                                    
									<tr>   
										<td><?=lang('national_id')?></td>
										<td>
										<?=$staff_info->national_id?> 
										</td>
									</tr>
                                    <tr>   
										<td><?=lang('blood_group')?></td>
										<td>
										<?=$staff_info->blood_group?> 
										</td>
									</tr>                            	
									<tr>   
										<td><?=lang('main_salary')?></td>
										<td>
										<?=$staff_info->main_salary?> 
										</td>
									</tr>
									<tr>   
										<td><?=lang('note')?></td>
										<td>
										<?=$staff_info->note?> 
										</td>
									</tr> 
												  
								</table>
					
								<a href="#" onClick="history.go(-1);" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"> <?=lang('action_back')?></span></a>																									
							   
								
							  </fieldset>
					
					</div> <!-- col-md-5 -->
					
					
					<div class="col-md-3">
					
						
						<div class="panel panel-warning">
						  <div class="panel-heading">
							<h3 class="panel-title"><?=lang('menu_update_history')?></h3>
						  </div>
						  <div class="panel-body">
								<table class="table table-hover table-striped" style="font-size:11px;">
									<tr>
										<td><?=lang('create_user')?></td>
										<td><?=$this->account_model->get_username_by_id($staff_info->create_user_id)?></td>
									</tr>
									<tr>    
										<td><?=lang('create_date')?></td>
										<td><?=$staff_info->create_date?></td>
									</tr>
									<tr>    
										<td><?=lang('update_user')?></td>
										<td><?=$this->account_model->get_username_by_id($staff_info->update_user_id)?></td>
									</tr>
									<tr>    
										<td><?=lang('update_date')?></td>
										<td><?=$staff_info->update_date?></td>
									</tr> 
								</table>
						  </div>
						</div>
						
						
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
											  
						  
					  <!--- End 2 -->  
						  
					  </div>


					  
					  <div class="tab-pane fade" id="checkup" style="overflow: scroll;">
					  <!-- Edit Button -->
					  <div style="width:100%; margin-bottom:10px;overflow:hidden;"> 
					  <?php if ($this->authorization->is_permitted('add_salary_allowance')) : ?> 
					  <a href="<?php echo base_url().'staff/staff/add_staff_salary_allowance/'.$staff_info->id;?>" class="btn btn-info btn-xs pull-left"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?=lang('salary_allowance')?> <?=lang('action_add')?> </a>&nbsp;&nbsp;
					  <?php endif; ?>                      
					  </div>
					  
						  <table class="table table-striped table-bordered" style="font-size:11px; ">
								<tr>               
									<th><?=lang('season_name')?></th>
                                    <th><?=lang('main_salary')?></th>         
									<th><?=lang('house_rent')?></th>
									<th><?=lang('treatment_allowance')?></th>
									<th><?=lang('transportation_allowance')?></th>
									<th><?=lang('border_allowance')?></th>
									<th><?=lang('tiffin_allowance')?></th>
									<th><?=lang('mountains_allowance')?></th>
									<th><?=lang('education_help_allowance')?></th>
									<th><?=lang('costly_allowance')?></th>
									<th><?=lang('servant_allowance')?></th>
									<th><?=lang('employee_allowance')?></th>
									<th><?=lang('washed_allowance')?></th>
									<th><?=lang('barber_allowance')?></th>
									<th><?=lang('fuller_allowance')?></th>
									<th><?=lang('leave_allowance')?></th>
									<th><?=lang('ration_allowance')?></th>
									<th><?=lang('new_year_allowance')?></th>
									<th><?=lang('gpf_number')?></th>
									<th><?=lang('extra_field_1')?></th>
									<th><?=lang('extra_field_2')?></th>
									<th><?=lang('extra_field_3')?></th>
									<th align="center"><?=lang('action_edit')?></th>
								</tr>		
								<?php
								if( !empty($bgb_main_salary) ) {
								foreach ($bgb_main_salary as $salary_info) : 
								?>
								<tr id="row_<?=$salary_info->salary_id?>">									                                    
									<td><?=$this->site_model->get_season_name_by_id($salary_info->season_id)?></td>
                                    <td><?=$salary_info->main_salary?></td>
                                    <td><?=$salary_info->house_rent?></td>
                                    <td><?=$salary_info->treatment_allowance?></td>
                                    <td><?=$salary_info->transportation_allowance?></td>
                                    <td><?=$salary_info->border_allowance?></td>
                                    <td><?=$salary_info->tiffin_allowance?></td>
                                    <td><?=$salary_info->mountains_allowance?></td>
                                    <td><?=$salary_info->education_help_allowance?></td>
                                    <td><?=$salary_info->costly_allowance?></td>
                                    <td><?=$salary_info->servant_allowance?></td>
                                    <td><?=$salary_info->employee_allowance?></td>
                                    <td><?=$salary_info->washed_allowance?></td>
                                    <td><?=$salary_info->barber_allowance?></td>
                                    <td><?=$salary_info->fuller_allowance?></td>
                                    <td><?=$salary_info->leave_allowance?></td>
                                    <td><?=$salary_info->ration_allowance?></td>
                                    <td><?=$salary_info->new_year_allowance?></td>
                                    <td><?=$salary_info->gpf_number?></td>
                                    <td><?=$salary_info->extra_field_1?></td>
                                    <td><?=$salary_info->extra_field_2?></td>
                                    <td><?=$salary_info->extra_field_3?></td>
                                    <td>
                                    <?php
                                    if($this->authorization->is_permitted('add_salary_allowance'))
									{
                                    ?>
                                    <a href="<?php echo base_url().'staff/staff/edit_staff_salary_allowance/'.$staff_info->id."/".$salary_info->salary_id;?>" class="btn btn-warning btn-xs pull-left"> <?=lang('salary_allowance')?> <?=lang('action_edit')?> </a>
                                    <?php
									}
									if(!$this->general_model->is_exist_in_a_table('bgb_main_excision','salary_id',$salary_info->salary_id))
									{
									?>
                                    <?php if ($this->authorization->is_permitted('add_salary_excision')) : ?> 
					  				<a href="<?php echo base_url().'staff/staff/add_staff_salary_excision/'.$staff_info->id."/".$salary_info->salary_id;?>" class="btn btn-info btn-xs pull-left"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?=lang('salary_excision')?> <?=lang('action_add')?> </a>
					  				<?php endif; 
									}
									else
									{
									if ($this->authorization->is_permitted('add_salary_excision')) : ?> 
					  				<a href="<?php echo base_url().'staff/staff/edit_staff_salary_excision/'.$staff_info->id."/".$salary_info->salary_id;?>" class="btn btn-warning btn-xs pull-left"> <?=lang('salary_excision')?> <?=lang('action_edit')?> </a>
					  				<?php endif;                                     
									}
									?>
                                    <a href="<?php echo base_url().'staff/staff/view_staff_salary/'.$staff_info->id."/".$salary_info->salary_id;?>" class="btn btn-success btn-xs pull-left"> <?=lang('action_view')?> </a>
                                    </td>
								</tr>
								<?php
								endforeach; 
								}	//end if
								?>
						  </table>   
					  </div>
	  

<div class="clearfix"></div>
</div>

</div>

</div>
<?php echo $this->load->view('footer'); ?>