<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('menu_salary_summary')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')." ".lang('menu_salary_summary')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./reports/report/salary_summary_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">     
      	<td><?=lang('season_name')?></td>     
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
		
        <a href="reports/report/download_salary_summary/<?=$season_id?>/<?=$battalion_id?>" id="export-to-excel" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> <?=lang('download_in_excel')?></a>      
                            
    </div>
    </div>
    
    
    <div class="col-md-12" style="overflow: scroll;">
    
    <table class="table table-bordered table-striped">
    	<tr class="warning">
        	<td><?=lang('serial_no')?></td>                         
            <td><?=lang('company')?></td>
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
            <td><?=lang('time_scale')?></td>
            <td><?=lang('earn_leave')?></td>
            <td><?=lang('festival_allowance')?></td>
            <td><?=lang('entertainment_allowance')?></td>
            <td><?=lang('gpf_advanced')?></td>
            <td><?=lang('subsidiary_salary_or_allowance')?></td>
            <td><?=lang('honorary_allowance')?></td>                                 
            <td><strong><?=lang('total_salary')?></strong></td>                        
            <td><?=lang('gpf_excision')?></td>
            <td><?=lang('gpf_payment')?></td>
            <td><?=lang('house_building_excision')?></td>
            <td><?=lang('house_building_interest')?></td>
            <td><?=lang('miscellaneous_excision')?></td>
            <td><?=lang('motorcycle_excision')?></td>
            <td><?=lang('additional_house_rent_excision')?></td>
            <td><?=lang('income_tax')?></td>
            <td><?=lang('extra_salary_excision')?></td>
            <td><strong><?=lang('total_excision')?></strong></td>
            <td><strong><?=lang('net_claims')?></strong></td>             
      	</tr>
     	<?php 
        $page = (isset($page))? $page:0;
        $i=$page+1;
		if( !empty($company_salary_info) ) {
			foreach ($company_salary_info as $company_salary) : 
			
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
                        
            <td>
			<?php 			
			echo $this->site_model->get_company_name_by_id($company_salary->company_id);
			//echo "id:".$company_salary->company_id;
            ?>			
            </td>
            
            <td>
			<?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->main_salary);
			else
			echo $company_salary->main_salary;
			$total_allowance=$company_salary->main_salary;						
			?>            
            </td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->house_rent);
			else
			echo $company_salary->house_rent;
			$total_allowance=$total_allowance+$company_salary->house_rent;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->treatment_allowance);
			else
			echo $company_salary->treatment_allowance;
			$total_allowance=$total_allowance+$company_salary->treatment_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->transportation_allowance);
			else
			echo $company_salary->transportation_allowance;
			$total_allowance=$total_allowance+$company_salary->transportation_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->border_allowance);
			else
			echo $company_salary->border_allowance;
			$total_allowance=$total_allowance+$company_salary->border_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->tiffin_allowance);
			else
			echo $company_salary->tiffin_allowance; 
			$total_allowance=$total_allowance+$company_salary->tiffin_allowance;
			?></td>            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->mountains_allowance);
			else
			echo $company_salary->mountains_allowance; 
			$total_allowance=$total_allowance+$company_salary->mountains_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->education_help_allowance);
			else
			echo $company_salary->education_help_allowance; 
			$total_allowance=$total_allowance+$company_salary->education_help_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->costly_allowance);
			else
			echo $company_salary->costly_allowance; 
			$total_allowance=$total_allowance+$company_salary->costly_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->servant_allowance);
			else
			echo $company_salary->servant_allowance; 
			$total_allowance=$total_allowance+$company_salary->servant_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->employee_allowance);
			else
			echo $company_salary->employee_allowance; 
			$total_allowance=$total_allowance+$company_salary->employee_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->washed_allowance);
			else
			echo $company_salary->washed_allowance; 
			$total_allowance=$total_allowance+$company_salary->washed_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->barber_allowance);
			else
			echo $company_salary->barber_allowance; 
			$total_allowance=$total_allowance+$company_salary->barber_allowance;
			?></td>                                  
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->fuller_allowance);
			else
			echo $company_salary->fuller_allowance; 
			$total_allowance=$total_allowance+$company_salary->fuller_allowance;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->leave_allowance);
			else
			echo $company_salary->leave_allowance; 
			$total_allowance=$total_allowance+$company_salary->leave_allowance;
			?></td>           
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->ration_allowance);
			else
			echo $company_salary->ration_allowance; 
			$total_allowance=$total_allowance+$company_salary->ration_allowance;
			?></td>           
            
            <td>
            <?php
            if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->time_scale);
			else
			echo $company_salary->time_scale; 
			$total_allowance=$total_allowance+$company_salary->time_scale;
			?>            
            </td>
            <td>
            <?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->earn_leave);
			else
			echo $company_salary->earn_leave; 
			$total_allowance=$total_allowance+$company_salary->earn_leave;			
            ?>
            </td>                                    
            <td>			
            <?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->festival_allowance);
			else
			echo $company_salary->festival_allowance; 
			$total_allowance=$total_allowance+$company_salary->festival_allowance;			
            ?>            
            </td>
            <td>
			<?php
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->entertainment_allowance);
			else
			echo $company_salary->entertainment_allowance; 
			$total_allowance=$total_allowance+$company_salary->entertainment_allowance;
			?>                        
            </td> 
                                                          
            <td>
			<?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->gpf_advanced);
			else
			echo $company_salary->gpf_advanced; 
			$total_allowance=$total_allowance+$company_salary->gpf_advanced;			
			?>            
            </td>
            <td>
			<?php 
            if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->subsidiary_salary_or_allowance);
			else
			echo $company_salary->subsidiary_salary_or_allowance; 
			$total_allowance=$total_allowance+$company_salary->subsidiary_salary_or_allowance;	
			?>
            </td>
            <td><?php 						
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->honorary_allowance);
			else
			echo $company_salary->honorary_allowance; 
			$total_allowance=$total_allowance+$company_salary->honorary_allowance;			
			?>            
            </td>
            
            <td><strong><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($total_allowance);
			else
			echo $total_allowance?></strong></td>
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->gpf_excision);
			else
			echo $company_salary->gpf_excision;
			$total_excision=$total_excision+$company_salary->gpf_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->gpf_payment);
			else
			echo $company_salary->gpf_payment;
			$total_excision=$total_excision+$company_salary->gpf_payment;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->house_building_excision);
			else
			echo $company_salary->house_building_excision;
			$total_excision=$total_excision+$company_salary->house_building_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->house_building_interest);
			else
			echo $company_salary->house_building_interest;
			$total_excision=$total_excision+$company_salary->house_building_interest;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->miscellaneous_excision);
			else
			echo $company_salary->miscellaneous_excision;
			$total_excision=$total_excision+$company_salary->miscellaneous_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->motorcycle_excision);
			else
			echo $company_salary->motorcycle_excision;
			$total_excision=$total_excision+$company_salary->motorcycle_excision;
			?></td>
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->additional_house_rent_excision);
			else
			echo $company_salary->additional_house_rent_excision;
			$total_excision=$total_excision+$company_salary->additional_house_rent_excision;
			?></td>
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->income_tax);
			else
			echo $company_salary->income_tax;
			$total_excision=$total_excision+$company_salary->income_tax;
			?></td>
            
            
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($company_salary->extra_salary_excision);
			else
			echo $company_salary->extra_salary_excision;
			$total_excision=$total_excision+$company_salary->extra_salary_excision;
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
