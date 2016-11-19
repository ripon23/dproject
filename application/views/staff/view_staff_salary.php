<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>

</head>
<body>
<?php echo $this->load->view('header'); ?>

<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_view')?> <?=lang('staff_salary')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('staff_salary')?> </legend>
<div class="print_button">
<a onClick="printContent('firstDiv');" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> <?=lang('action_print')?></a>
</div>

<div id="firstDiv">
<div class="col-xs-12">
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
        <td><?=lang('season_name')?>:  <?=$this->site_model->get_season_name_by_id($salary_allowance->season_id)?> </td>
      </tr>
    </table>
</div>

<div class="col-xs-6">
	
            	
            <!-- Patient  input-->
            <table class="table table-bordered table-striped">                         
                
                <tr>
                	<td><?=lang('main_salary')?></td>
                    <td>
                    <div class="col-md-8">
                    <?=$salary_allowance->main_salary?>
                    <?php $total_salary=$salary_allowance->main_salary ?>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('house_rent')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                       	<?=$salary_allowance->house_rent?>
                        <?php $total_salary=$total_salary+$salary_allowance->house_rent ?>
                      </div>
                    </td>
            	</tr>                
               
               <tr>   
                    <td>
                    <?=lang('treatment_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?=$salary_allowance->treatment_allowance?>
                      <?php $total_salary=$total_salary+$salary_allowance->treatment_allowance ?>
                      </div>
                    </td>
            	</tr>
                 
                <tr>   
                    <td>
                    <?=lang('transportation_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?=$salary_allowance->transportation_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->transportation_allowance; ?>
                      </div>
                    </td>
            	</tr>                
                <tr>
                	<td><?=lang('border_allowance')?></td>
                    <td>
                    <div class="col-md-8">
                    	<?=$salary_allowance->border_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->border_allowance; ?>
                    </div>                    
                    </td>
                </tr>
                <tr>
                	<td><?=lang('tiffin_allowance')?></td>
                    <td>
                    <div class="col-md-8">
                    <?=$salary_allowance->tiffin_allowance?>
                    <?php $total_salary=$total_salary+$salary_allowance->tiffin_allowance; ?>
                    </div>                   
                    </td>
                </tr>
            	
                
                <tr>   
                    <td>
                    <?=lang('mountains_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?=$salary_allowance->mountains_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->mountains_allowance; ?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('education_help_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?=$salary_allowance->education_help_allowance?>
                      <?php $total_salary=$total_salary+$salary_allowance->education_help_allowance; ?>
                      </div>
                    </td>
            	</tr>
                
                
                 <tr>   
                    <td>
                    <?=lang('costly_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?=$salary_allowance->costly_allowance?>
                      <?php $total_salary=$total_salary+$salary_allowance->costly_allowance; ?>
                      </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('servant_allowance')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?=$salary_allowance->servant_allowance?>
                      <?php $total_salary=$total_salary+$salary_allowance->servant_allowance; ?>
                      </div>

                    </td>
            	</tr>
                
                
                <tr>   
                    <td>
                    <?=lang('employee_allowance')?>
                    </td>                    
                    <td>             
                     <div class="col-md-8">
                     <?=$salary_allowance->employee_allowance?>
                     <?php $total_salary=$total_salary+$salary_allowance->employee_allowance; ?>
                     </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('washed_allowance')?>  
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?=$salary_allowance->washed_allowance?>
                      <?php $total_salary=$total_salary+$salary_allowance->washed_allowance; ?>
                      </div>                      
                      
                    </td>
            	</tr>
               
                <tr>
                	<td>
               		<?=lang('barber_allowance')?>  
    				</td>
    				<td>
      	              	<div class="col-md-8">
                		<?=$salary_allowance->barber_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->barber_allowance; ?>
                        </div>                
                    </td>
                 <tr>   
                    <td>
                    <?=lang('fuller_allowance')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?=$salary_allowance->fuller_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->fuller_allowance; ?>
                      </div>
                
                    </td>
            	</tr>                
            	<tr>   
                    <td><?=lang('leave_allowance')?> </td>
            		<td>
                    <div class="col-md-8">                        
                        <?=$salary_allowance->leave_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->leave_allowance; ?>
                    </div>
                    </td>
                </tr>     
            
            	<tr>   
                    <td><?=lang('ration_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->ration_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->ration_allowance; ?>
                    </div>
                    </td>
                </tr>
                <tr>   
                    <td><?=lang('family_ration_allowance')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->family_ration_allowance?>
                        <?php $total_salary=$total_salary+$salary_allowance->family_ration_allowance; ?>
                    </div>
                    </td>
                </tr>
                <tr>   
                    <td><?=lang('gpf_number')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->gpf_number?>
                    </div>
                    </td>
                </tr>
                <tr>   
                    <td><?=lang('extra_field_1')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->extra_field_1?>
                        <?php $total_salary=$total_salary+$salary_allowance->extra_field_1; ?>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('extra_field_2')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->extra_field_2?>
                        <?php $total_salary=$total_salary+$salary_allowance->extra_field_2; ?>
                    </div>
                    </td>
                </tr> 
                
                <tr>   
                    <td><?=lang('extra_field_3')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$salary_allowance->extra_field_3?>
                        <?php $total_salary=$total_salary+$salary_allowance->extra_field_3; ?>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td><?=lang('total_salary')?></td>
            		<td>
                    <div class="col-md-8">
                        <?=$total_salary?>
                    </div>
                    </td>
                </tr>
                               
            </table>

</div> <!-- col-md-6 -->

<div class="col-xs-6">
<table class="table table-bordered table-striped">
            	
                
                
                <tr>
                	<td><?=lang('gpf_excision')?> </td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info){
					echo $salary_excision_info->gpf_excision;
                    $total_excision=$salary_excision_info->gpf_excision;  
					}
					?>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('house_building_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?php 
						if($salary_excision_info){
						echo $salary_excision_info->house_building_excision;
                        $total_excision=$total_excision+$salary_excision_info->house_building_excision;  
						}
						?>
                      </div>
                    </td>
            	</tr>                
               
               <tr>   
                    <td>
                    <?=lang('house_building_interest')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->house_building_interest;
                      	$total_excision=$total_excision+$salary_excision_info->house_building_interest;  
						}
					  ?>
                      </div>
                    </td>
            	</tr>
                 
                <tr>   
                    <td>
                    <?=lang('miscellaneous_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->miscellaneous_excision;
                        $total_excision=$total_excision+$salary_excision_info->miscellaneous_excision;  
						}
						?>
                      </div>
                    </td>
            	</tr>                
                <tr>
                	<td><?=lang('motorcycle_excision')?></td>
                    <td>
                    <div class="col-md-8">
                    	<?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->motorcycle_excision;
                        $total_excision=$total_excision+$salary_excision_info->motorcycle_excision;  
						}
						?>
                    </div>                    
                    </td>
                </tr>
                <tr>
                	<td><?=lang('additional_house_rent_excision')?></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->additional_house_rent_excision;
					$total_excision=$total_excision+$salary_excision_info->additional_house_rent_excision;  
					}
					?>
                    </div>                   
                    </td>
                </tr>
            	
                <tr>
                	<td><?=lang('income_tax')?></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->income_tax;
					$total_excision=$total_excision+$salary_excision_info->income_tax;  
					}
					?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('extra_salary_excision')?></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_salary_excision;
					$total_excision=$total_excision+$salary_excision_info->extra_salary_excision;  
					}
					?>
                    </div>                   
                    </td>
                </tr>
                
                
                <tr>
                	<td><strong><?=lang('total_excision')?></strong></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					
					echo '<strong>'.$total_excision.'</strong>';
					
					?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><strong><?=lang('net_claims')?></strong></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					$net_claims=$total_salary-$total_excision;
					echo '<strong>'.($total_salary-$total_excision).'</strong>';
					
					?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>
                	<td><?=lang('ration_subsidy')?></td>
                    <td>
                    <div class="col-md-8">
                    <?php 
					$total_excision=0;
					if($salary_excision_info)
					{
					echo $salary_excision_info->ration_subsidy;
					$total_excision=$total_excision+$salary_excision_info->ration_subsidy;  
					}
					?>
                    </div>                   
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('spice_excision')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->spice_excision;
                        $total_excision=$total_excision+$salary_excision_info->spice_excision;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                
                <tr>   
                    <td>
                    <?=lang('rc_fresh')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->rc_fresh;
                        $total_excision=$total_excision+$salary_excision_info->rc_fresh;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('rc_dry')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->rc_dry;
                        $total_excision=$total_excision+$salary_excision_info->rc_dry;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('battalion_loan')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->battalion_loan;
                        $total_excision=$total_excision+$salary_excision_info->battalion_loan;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                
                <tr>   
                    <td>
                    <?=lang('barber_excision')?> 
                    </td>                    
                    <td>             
                       <div class="col-md-8">
                       <?php 
					    if($salary_excision_info)
					    {
						echo $salary_excision_info->barber_excision;
                        $total_excision=$total_excision+$salary_excision_info->barber_excision;  
						}
						?>
                      </div>
                    </td>
            	</tr>
                
                
                 <tr>   
                    <td>
                    <?=lang('fuller_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      	<?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->fuller_excision;                      	
                        $total_excision=$total_excision+$salary_excision_info->fuller_excision;  
                        }
                        ?>
                      </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('washed_allowance_excision')?>
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      	<?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->washed_allowance_excision;
                       	$total_excision=$total_excision+$salary_excision_info->washed_allowance_excision; 
						}
						?>
                      </div>

                    </td>
            	</tr>
                <tr>   
                    <td>
                    <?=lang('rc_bgb_fresh')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->rc_bgb_fresh;
                        $total_excision=$total_excision+$salary_excision_info->rc_bgb_fresh;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('rc_bgb_dry')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->rc_bgb_dry;
                        $total_excision=$total_excision+$salary_excision_info->rc_bgb_dry;  
						}
						?>
                      </div>                      
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('bgb_health_support_subscription')?>
                    </td>                    
                    <td>             
                     <div class="col-md-8">
                     	<?php 
						if($salary_excision_info)
						{
						echo $salary_excision_info->bgb_health_support_subscription;
                     	$total_excision=$total_excision+$salary_excision_info->bgb_health_support_subscription;  
						}
						?>
                     </div>
                    </td>
            	</tr>
                
                
                <tr>   
                    <td><?=lang('extra_field_1')?></td>
            		<td>
                    <div class="col-md-8">
					<?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_1;
                    $total_excision=$total_excision+$salary_excision_info->extra_field_1;  
					}
					?>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('extra_field_2')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_2;
					$total_excision=$total_excision+$salary_excision_info->extra_field_2;  
					}
					?>
                    </div>
                    </td>
                </tr> 
                
                <tr>   
                    <td><?=lang('extra_field_3')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_3;
                    $total_excision=$total_excision+$salary_excision_info->extra_field_3;  
					}
					?>
                    </div>
                    </td>
                </tr>
                <!--<tr>   
                    <td><?=lang('extra_field_4')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_4;
                    $total_excision=$total_excision+$salary_excision_info->extra_field_4;  
					}
					?>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('extra_field_5')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_5;
                    $total_excision=$total_excision+$salary_excision_info->extra_field_5;  
					}
					?>
                    </div>
                    </td>
                </tr> 
                
                <tr>   
                    <td><?=lang('extra_field_6')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $salary_excision_info->extra_field_6;
					$total_excision=$total_excision+$salary_excision_info->extra_field_6;  
					}
					?>
                    </div>
                    </td>
                </tr>-->
                
                <tr>   
                    <td><?=lang('total_excision')?></td>
            		<td>
                    <div class="col-md-8">
                    <?php 
					if($salary_excision_info)
					{
					echo $total_excision;
					}
					
					?>                    
                    </div>
                    </td>
                </tr>  
                               
            </table>
            
            <table class="table table-bordered table-striped">
            <tr>   
                    <td><strong><?=lang('net_salary')?></strong></td>
            		<td>
                    <div class="col-md-8">
                    <strong><?php
                    if($salary_excision_info)
					{					
					echo ($net_claims-$total_excision);
					}
					?> 
                    
                    </strong>                   
                    </div>
                    </td>
                </tr>
            </table>
</div>

</div>

</div>

<script type="text/javascript">
<!--
function printContent(id){
str=document.getElementById(id).innerHTML
newwin=window.open('','printwin','left=100,top=100,width=800,height=900')
newwin.document.write('<html>\n<head>\n <link rel=\"stylesheet\" type=\"text/css\"  href=\"<?php echo base_url().RES_DIR; ?>/dist/css/bootstrap.min.css\">\n<link rel=\"stylesheet\" type=\"text/css\"  href=\"<?php echo base_url().RES_DIR; ?>/css/style.css\">\n</head><body><div style=\"firstDiv\">\n</div>\n</body>\n</html>');
newwin.document.write('<TITLE>Print Page</TITLE>\n')
newwin.document.write('<script>\n')
newwin.document.write('function chkstate(){\n')
newwin.document.write('if(document.readyState=="complete"){\n')
newwin.document.write('window.close()\n')
newwin.document.write('}\n')
newwin.document.write('else{\n')
newwin.document.write('setTimeout("chkstate()",2000)\n')
newwin.document.write('}\n')
newwin.document.write('}\n')
newwin.document.write('function print_win(){\n')
newwin.document.write('window.print();\n')
newwin.document.write('chkstate();\n')
newwin.document.write('}\n')
newwin.document.write('<\/script>\n')
newwin.document.write('</HEAD>\n')
newwin.document.write('<BODY onload="print_win()">\n')
newwin.document.write(str)
newwin.document.write('</BODY>\n')
newwin.document.write('</HTML>\n')
newwin.document.close()
}
//-->
</script>
<?php echo $this->load->view('footer'); ?>
