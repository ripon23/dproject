<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=bgb_salary_summary.xls");
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
        <td colspan="5"><?=lang('border_guard_battalion_salary')?><br /><?php echo 'অফিসের  নাম:'.$battalion_name.' '.$season_name;?></td>    
    </tr>        
<table>    

<table border="1"> 	
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
    
<table> 	
	<tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>        
        <td colspan="5"> * ৪ অংক অর্থনৈতিক কোড বুঝায় ।<br/>
 বাঃসঃমুঃ৯৭/৯৮-১৮০৭৩এফ ৪০ লক্ষ কপি (সি৮৮) ১৯৯৮ ।</td>
	</tr>        
<table>    