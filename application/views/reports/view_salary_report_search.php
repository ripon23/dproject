<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_view')." ".lang('menu_salary_report')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')." ".lang('menu_salary_report')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./reports/report/salary_report_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">     
      	<td><?=lang('season_name')?></td>
        <td><?=lang('designation_name')?></td>  
        <td><?=lang('company')?></td>       
        <td><?=lang('menu_battalion')?></td>       
        <td><?=lang('action')?></td>
      </tr>
      <tr>                 
        <td>
        <?php 
		$language = $this->session->userdata('site_lang'); ?>
        <select name="season_id" class="form-control input-sm">
            <option value=""><?php echo lang('select'); ?></option>
            <?php foreach ($season_info as $season) : ?>
            <option value="<?=$season->season_id?>"  <?php if(set_value('season_id')==$season->season_id) echo "selected";?>><?php if($language=='bangla') echo $season->season_name_bn; else echo $season->season_name; ?></option>
            <?php endforeach; ?>
        </select> 
        </td>
        <td>
        <?php $language = $this->session->userdata('site_lang'); ?>
        <select name="designation_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_designation as $designation) : ?>
          <option value="<?=$designation->designation_id?>" <?php if(set_value('designation_id')==$designation->designation_id) echo "selected";?>><?php if($language=='bangla') echo $designation->designation_name_bn; else echo $designation->designation_name; ?></option>
          <?php endforeach; ?>
        </select> 
        </td>
        <td>
        <select name="company_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_company as $company) : ?>
          <option value="<?=$company->company_id?>" <?php if(set_value('company_id')==$company->company_id) echo "selected";?>><?php if($language=='bangla') echo $company->company_name_bn; else echo $company->company_name; ?></option>
          <?php endforeach; ?>
        </select> 
        
        </td>   
        <td>
        <select name="battalion_id" class="form-control col-md-1 input-sm" id="user_role">
            <option value=""><?php echo lang('select_all'); ?></option>            
            <?php foreach ($all_battalion as $battalion) : ?>
            <option value="<?php echo $battalion->battalion_id; ?>" <?php if(set_value('battalion_id')==$battalion->battalion_id) echo "selected";?>><?php echo $this->site_model->get_battalion_name_by_id($battalion->battalion_id); ?></option>
            <?php endforeach; ?>
        </select>	
        </td>        
        <td>
        <input type="submit" name="search_submit" id="search_submit" value="<?=lang('action_search')?>" class="btn btn-primary btn-sm" />
        </td>
      </tr>
    </table>
        
       
    
    </div> <!-- col-md-12 -->
    </form>
	
    <div class="col-md-12">
    <div id="export-menu" style="width:100%; margin-bottom:10px; text-align:right;"> 
		
        <a href="reports/report/download_excel/<?=$season_id?>/<?=$company_id?>/<?=$battalion_id?>" id="export-to-excel" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> <?=lang('download_in_excel')?></a>      
                            
    </div>
    </div>
    
    
    <div class="col-md-12" style="overflow: scroll;">
    
    <table class="table table-bordered table-striped">
    	<tr class="warning">
        	<td><?=lang('serial_no')?></td>
            <td><?=lang('reg_no')?></td>
            <td><?=lang('designation_name')?></td>  
            <td><?=lang('fullname')?></td>                      
            <td><?=lang('menu_battalion')?></td>             
            <td><?=lang('company')?></td>
            <td><?=lang('season_name')?></td>
            <td><?=lang('main_salary')?></td>
            <td><?=lang('house_rent')?></td>
            <td><?=lang('treatment_allowance')?></td>
            <td><?=lang('transportation_allowance')?></td>
            <td><?=lang('border_allowance')?></td>                                  
            <td><?=lang('tiffin_allowance')?></td>
            <td><?=lang('mountains_allowance')?></td>
            <td><?=lang('education_help_allowance')?></td>
            <td><?=lang('costly_allowance')?></td>
            <td><?=lang('servant_allowance')?></td>
            <td><?=lang('employee_allowance')?></td>                                  
            <td><?=lang('washed_allowance')?></td>
            <td><?=lang('barber_allowance')?></td>
            <td><?=lang('fuller_allowance')?></td>
            <td><?=lang('leave_allowance')?></td>
            <td><?=lang('ration_allowance')?></td>
            <td><?=lang('new_year_allowance')?></td>
            <td><?=lang('time_scale')?></td>
            <td><?=lang('earn_leave')?></td>
            <td><?=lang('festival_allowance')?></td>
            <td><?=lang('entertainment_allowance')?></td>
            <td><?=lang('gpf_number')?></td>            
            <td><?=lang('gpf_advanced')?></td>
            <td><?=lang('subsidiary_salary_or_allowance')?></td>
            <td><?=lang('honorary_allowance')?></td>
            
            <td><?=lang('extra_field_1')?></td>
            <td><?=lang('extra_field_2')?></td>
            <td><?=lang('extra_field_3')?></td>
            <td><strong><?=lang('total_salary')?></strong></td>
            
            
            <td><?=lang('gpf_excision')?></td>
            <td><?=lang('gpf_payment')?></td>
            <td><?=lang('house_building_excision')?></td>
            <td><?=lang('house_building_interest')?></td>
            <td><?=lang('miscellaneous_excision')?></td>
            <td><?=lang('motorcycle_excision')?></td>
            <td><?=lang('additional_house_rent_excision')?></td>
            <td><strong><?=lang('total_excision')?></strong></td>
            <td><strong><?=lang('net_claims')?></strong></td> 
            <td><?=lang('ration_subsidy')?></td>
            <td><?=lang('spice_excision')?></td>
            <td><?=lang('rc_fresh')?></td>
            <td><?=lang('rc_dry')?></td>
            <td><?=lang('battalion_loan')?></td>
            <td><?=lang('barber_excision')?></td>
            <td><?=lang('fuller_excision')?></td>            
            <td><?=lang('washed_allowance_excision')?></td>
            <td><?=lang('rc_bgb_fresh')?></td>
            <td><?=lang('rc_bgb_dry')?></td>
            <td><?=lang('bgb_health_support_subscription')?></td>
            <td><?=lang('extra_field_1')?></td>
            <td><?=lang('extra_field_2')?></td>
            <td><?=lang('extra_field_3')?></td>
            <td><?=lang('extra_field_4')?></td>
            <td><?=lang('extra_field_5')?></td>
            <td><?=lang('extra_field_6')?></td>
            <td><strong><?=lang('total_excision')?></strong></td>
            <td><strong><?=lang('net_salary')?></strong></td>
      	</tr>
     	<?php 
        $page = (isset($page))? $page:0;
        $i=$page+1;
		if( !empty($all_staff_user) ) {
			foreach ($all_staff_user as $user) : 
			
			$total_allowance=0;
			$total_excision=0;
			$net_salary=0;
		?>
        <tr>
        	
            <td>
			<?php 
			$language = $this->session->userdata('site_lang');
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($i);
			else
			echo $i;			
			?>
            
            </td>
            <td><?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->staff_id);
			else
			echo $user->staff_id?></td>
            <td>
			<?php 			
			echo $this->site_model->get_designation_name_by_id($user->designation_id);
            ?>			
            </td>             
            <td>
			<?php
            $language = $this->session->userdata('site_lang');
			if($language=='bangla')
			echo $user->staff_name_bangla;
			else
			echo $user->fullname;			
			?>            
            </td>
                       
             <td>
            <?php			
			$all_user_battalion=$this->site_model->get_all_user_battalion($user->id);
			foreach ($all_user_battalion as $user_battalion) :
				echo '<span class="label label-primary">'.$this->site_model->get_battalion_name_by_id($user_battalion->battalion_id).'</span> ';
			endforeach; 
			?>
            </td>
            
            <td>
			<?php 			
			echo $this->site_model->get_company_name_by_id($user->company_id);
            ?>			
            </td>
            <td> 
            <?php 			
			echo $this->site_model->get_season_name_by_id($user->season_id);
            ?>
            </td>
            <td>
			<?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->main_salary);
			else
			echo $user->main_salary;
			
			$total_allowance=$user->main_salary;
			?>            
            </td>
            <td><?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->house_rent);
			else
			echo $user->house_rent;
			$total_allowance=$total_allowance+$user->house_rent;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->treatment_allowance);
			else
			echo $user->treatment_allowance;
			$total_allowance=$total_allowance+$user->treatment_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->transportation_allowance);
			else
			echo $user->transportation_allowance;
			$total_allowance=$total_allowance+$user->transportation_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->border_allowance);
			else
			echo $user->border_allowance;
			$total_allowance=$total_allowance+$user->border_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->tiffin_allowance);
			else
			echo $user->tiffin_allowance; 
			$total_allowance=$total_allowance+$user->tiffin_allowance;
			?></td>            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->mountains_allowance);
			else
			echo $user->mountains_allowance; 
			$total_allowance=$total_allowance+$user->mountains_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->education_help_allowance);
			else
			echo $user->education_help_allowance; 
			$total_allowance=$total_allowance+$user->education_help_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->costly_allowance);
			else
			echo $user->costly_allowance; 
			$total_allowance=$total_allowance+$user->costly_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->servant_allowance);
			else
			echo $user->servant_allowance; 
			$total_allowance=$total_allowance+$user->servant_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->employee_allowance);
			else
			echo $user->employee_allowance; 
			$total_allowance=$total_allowance+$user->employee_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->washed_allowance);
			else
			echo $user->washed_allowance; 
			$total_allowance=$total_allowance+$user->washed_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->barber_allowance);
			else
			echo $user->barber_allowance; 
			$total_allowance=$total_allowance+$user->barber_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->fuller_allowance);
			else
			echo $user->fuller_allowance; 
			$total_allowance=$total_allowance+$user->fuller_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->leave_allowance);
			else
			echo $user->leave_allowance; 
			$total_allowance=$total_allowance+$user->leave_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->ration_allowance);
			else
			echo $user->ration_allowance; 
			$total_allowance=$total_allowance+$user->ration_allowance;
			?></td>
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->new_year_allowance);
			else
			echo $user->new_year_allowance; 
			$total_allowance=$total_allowance+$user->new_year_allowance;
			?></td>
            
            <td>
            <?php
            if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->time_scale);
			else
			echo $user->time_scale; 
			$total_allowance=$total_allowance+$user->time_scale;
			?>            
            </td>
            <td>
            <?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->earn_leave);
			else
			echo $user->earn_leave; 
			$total_allowance=$total_allowance+$user->earn_leave;			
            ?>
            </td>                                    
            <td>			
            <?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->festival_allowance);
			else
			echo $user->festival_allowance; 
			$total_allowance=$total_allowance+$user->festival_allowance;			
            ?>            
            </td>
            <td>
			<?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->entertainment_allowance);
			else
			echo $user->entertainment_allowance; 
			$total_allowance=$total_allowance+$user->entertainment_allowance;
			?>                        
            </td> 
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->gpf_number);
			else
			echo $user->gpf_number; ?>
            </td>
                                   
            <td>
			<?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->gpf_advanced);
			else
			echo $user->gpf_advanced;
			$total_allowance=$total_allowance+$user->gpf_advanced;			
			?>            
            </td>
            <td>
			<?php 
            if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->subsidiary_salary_or_allowance);
			else
			echo $user->subsidiary_salary_or_allowance; 
			$total_allowance=$total_allowance+$user->subsidiary_salary_or_allowance;	
			?>
            </td>
            <td><?php 						
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->honorary_allowance);
			else
			echo $user->honorary_allowance; 
			$total_allowance=$total_allowance+$user->honorary_allowance;			
			?>            
            </td>                                                          
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_1);
			else
			echo $user->extra_field_1; 
			$total_allowance=$total_allowance+$user->extra_field_1;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_2);
			else
			echo $user->extra_field_2; 
			$total_allowance=$total_allowance+$user->extra_field_2;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_3);
			else
			echo $user->extra_field_3; 
			$total_allowance=$total_allowance+$user->extra_field_3;
			?></td>
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_allowance);
			else
			echo $total_allowance?></strong></td>
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->gpf_excision);
			else
			echo $user->gpf_excision;
			$total_excision=$total_excision+$user->gpf_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->gpf_payment);
			else
			echo $user->gpf_payment;
			$total_excision=$total_excision+$user->gpf_payment;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->house_building_excision);
			else
			echo $user->house_building_excision;
			$total_excision=$total_excision+$user->house_building_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->house_building_interest);
			else
			echo $user->house_building_interest;
			$total_excision=$total_excision+$user->house_building_interest;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->miscellaneous_excision);
			else
			echo $user->miscellaneous_excision;
			$total_excision=$total_excision+$user->miscellaneous_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->motorcycle_excision);
			else
			echo $user->motorcycle_excision;
			$total_excision=$total_excision+$user->motorcycle_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->additional_house_rent_excision);
			else
			echo $user->additional_house_rent_excision;
			$total_excision=$total_excision+$user->additional_house_rent_excision;
			?></td>
            
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_excision);
			else
			echo $total_excision?></strong></td>
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_allowance-$total_excision);
			else
			echo $total_allowance-$total_excision?></strong>
            <?php $total_excision=0;?>
            </td>
                        
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->ration_subsidy);
			else
			echo $user->ration_subsidy;
			$total_excision=$total_excision+$user->ration_subsidy;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->spice_excision);
			else
			echo $user->spice_excision;
			$total_excision=$total_excision+$user->spice_excision;
			?></td>            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->rc_fresh);
			else
			echo $user->rc_fresh;
			$total_excision=$total_excision+$user->rc_fresh;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->rc_dry);
			else
			echo $user->rc_dry;
			$total_excision=$total_excision+$user->rc_dry;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->battalion_loan);
			else
			echo $user->battalion_loan;
			$total_excision=$total_excision+$user->battalion_loan;
			?></td>                        
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->barber_excision);
			else
			echo $user->barber_excision;
			$total_excision=$total_excision+$user->barber_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->fuller_excision);
			else
			echo $user->fuller_excision;
			$total_excision=$total_excision+$user->fuller_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->washed_allowance_excision);
			else
			echo $user->washed_allowance_excision;
			$total_excision=$total_excision+$user->washed_allowance_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->rc_bgb_fresh);
			else
			echo $user->rc_bgb_fresh;
			$total_excision=$total_excision+$user->rc_bgb_fresh;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->rc_bgb_dry);
			else
			echo $user->rc_bgb_dry;
			$total_excision=$total_excision+$user->rc_bgb_dry;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->bgb_health_support_subscription);
			else
			echo $user->bgb_health_support_subscription;
			$total_excision=$total_excision+$user->bgb_health_support_subscription;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_1);
			else
			echo $user->extra_field_1;
			$total_excision=$total_excision+$user->extra_field_1;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_2);
			else
			echo $user->extra_field_2;
			$total_excision=$total_excision+$user->extra_field_2;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_3);
			else
			echo $user->extra_field_3;
			$total_excision=$total_excision+$user->extra_field_3;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_4);
			else
			echo $user->extra_field_4;
			$total_excision=$total_excision+$user->extra_field_4;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_5);
			else
			echo $user->extra_field_5;
			$total_excision=$total_excision+$user->extra_field_5;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_field_6);
			else
			echo $user->extra_field_6;
			$total_excision=$total_excision+$user->extra_field_6;
			?></td>
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_excision);
			else
			echo $total_excision?></strong></td>
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_allowance-$total_excision);
			else
			echo $total_allowance-$total_excision?></strong></td>
        </tr>
        <?php
		$i=$i+1;
			endforeach; 
		}	//end if
		?>     
    </table>
    
    <div style="text-align:left"><?php echo $links; ?></div>
    
    </div> <!-- col-md-12-->
    
</div><!-- well well-lg-->


<?php echo $this->load->view('footer'); ?>
