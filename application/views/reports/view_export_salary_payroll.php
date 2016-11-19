<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=bgb_salary_report_payroll.xls");
header("Pragma: no-cache");
header("Expires: 0");
if($season_id)
$season_name=$this->site_model->get_season_name_by_id($season_id);
else
$season_name='';

if($battalion_id)
$battalion_name=$this->site_model->get_battalion_name_by_id($battalion_id);
else
$battalion_name='';

if($company_id)
$company_name=$this->site_model->get_company_name_by_id($company_id);
else
$company_name='';
?>
<table> 	
	<tr>
        <td colspan="3">টি, আর ফরম নং ১৫/এ <br />[এস, আর ১৫০ (১) দ্রষ্টব্য]</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"><?=lang('border_guard_battalion_salary')?><br /><?php echo 'অফিসের  নাম:'.$battalion_name.', '.$company_name.', '.$season_name;?></td>    
    </tr>        
<table>  

<table border="1"> 	
    	<tr class="warning">
        	<td><?=lang('serial_no')?></td>
            <td><?=lang('reg_no')?></td>
            <td><?=lang('designation_name')?></td>  
            <td><?=lang('fullname')?></td>                                 
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
            <td><?=lang('income_tax')?></td>
            <td><?=lang('extra_salary_excision')?></td>
            <td><strong><?=lang('total_excision')?></strong></td>
            <td><strong><?=lang('net_claims')?></strong></td> 
            
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
			echo $user->staff_id?>
            </td>
            
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
            </td><td><?php 
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
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->income_tax);
			else
			echo $user->income_tax;
			$total_excision=$total_excision+$user->income_tax;
			?></td>                        
            <td><?php 
			if($language=='bangla')
			echo $this->general_model->en2bnNumber($user->extra_salary_excision);
			else
			echo $user->extra_salary_excision;
			$total_excision=$total_excision+$user->extra_salary_excision;
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
    <table> 	
	<tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>        
        <td colspan="5"> * ৪ অংক অর্থনৈতিক কোড বুঝায় ।<br/>
 বাঃসঃমুঃ৯৭/৯৮-১৮০৭৩এফ ৪০ লক্ষ কপি (সি৮৮) ১৯৯৮ ।</td>
	</tr>        
<table>