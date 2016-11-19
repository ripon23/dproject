<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(account_id)
{

	var agree=confirm("Are you sure you want to delete this user? All record will be deleted");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "staff/staff/delete_staff",
		   data: "account_id="+account_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + account_id).addClass('error');			  
					$('#row_' + account_id).fadeOut(4000, function(){   				
					$('#row_' + account_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')." ".lang('menu_staff_profile')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')." ".lang('menu_staff_profile')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./staff/staff/staff_details_list_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <!--<tr class="warning">
        <td><?=lang('user_name')?></td>
        <td><?=lang('staff_id')?></td>
        <td><?=lang('fullname')?></td>
        <td><?=lang('mobile_no')?></td>
        <td><?=lang('gender')?></td>
        <td><?=lang('joining_date')?></td>
        <td><?=lang('designation_name')?></td>  
        <td><?=lang('company')?></td>       
        <td><?=lang('menu_battalion')?></td>       
        <td><?=lang('action')?></td>
      </tr>-->
      <tr>
        <td><input id="bank_account_no" name="bank_account_no" type="text" placeholder="<?=lang('bank_account_no')?>" value="<?php echo isset($bank_account_no)?$bank_account_no:'';?>" class="form-control input-sm"></td>
		<td><input id="staff_id" name="staff_id" type="text" placeholder="<?=lang('staff_id')?>" value="<?php echo isset($staff_id)?$staff_id:'';?>" class="form-control input-sm"></td>
        <td><input id="fullname" name="fullname" type="text" placeholder="<?=lang('fullname')?>" value="<?php echo isset($fullname)?$fullname:'';?>" class="form-control input-sm"></td>
        <td><input id="mobile" name="mobile" type="text" placeholder="<?=lang('mobile_no')?>" value="<?php echo isset($mobile)?$mobile:'';?>" class="form-control input-sm"></td>
               
        <td>
        	<select name="gender" id="gender" class="form-control col-md-1 input-sm">
                <option value=""><?php echo lang('select'); ?></option>
                <option value="m" <?php if(set_value('gender')=="m") echo "selected";?>><?php echo lang('gender_male'); ?></option>
                <option value="f" <?php if(set_value('gender')=="f") echo "selected";?>><?php echo lang('gender_female'); ?></option>
        	</select>
        </td>
        <td>
        <input id="joining_date" name="joining_date" type="text" value="<?php echo isset($joining_date)?$joining_date:'';?>" placeholder="YYYY-MM-DD" class="form-control input-sm" />
        </td>         
        <td>
        <?php $language = $this->session->userdata('site_lang'); ?>
        <select name="designation_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_designation as $designation) : ?>
          <option value="<?=$designation->designation_id?>"><?php if($language=='bangla') echo $designation->designation_name_bn; else echo $designation->designation_name; ?></option>
          <?php endforeach; ?>
        </select> 
        </td>
        <td>
        <select name="company_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_company as $company) : ?>
          <option value="<?=$company->company_id?>"><?php if($language=='bangla') echo $company->company_name_bn; else echo $company->company_name; ?></option>
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
    <table class="table table-bordered table-striped">
    	<tr class="warning">
        	<td>#</td>
        	<td><?=lang('user_name')?></td>
            <td><?=lang('staff_id')?></td>
            <td><?=lang('fullname')?></td>
            <td><?=lang('designation_name')?></td>            
            <td><?=lang('menu_battalion')?></td>             
            <td><?=lang('company')?></td>
            <td><?=lang('gender')?></td>
            <td><?=lang('joining_date')?></td>
            <td><?=lang('bank_account_no')?></td>
            <td><?=lang('mobile_no')?></td>
            <td><?=lang('age')?></td>
            <td><?=lang('profile_image')?></td>            
                      
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
        $page = (isset($page))? $page:0;
        $i=$page+1;
		if( !empty($all_staff_user) ) {
			foreach ($all_staff_user as $user) : 
		?>
        <tr id="row_<?=$user->id?>">
        	
            <td><?php echo $i?></td>
            <td><?=$user->username?></td>
            <td><?=$user->staff_id?></td>
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
			echo $this->site_model->get_designation_name_by_id($user->designation_id);
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
			if($user->gender=='m')
			echo lang('gender_male');
			else if($user->gender=='f')
			echo lang('gender_female');
			else
			echo '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>';
			?>            
            </td>
            <td><?=$user->joining_date?></td>
            <td><?=$user->bank_account_no?></td>
            <td><?=$user->mobile?></td>
           
            <td><?=$user->age?></td>
            <td align="center">
			<?php
            if($user->picture)
			{
				
				if(preg_match('/gravatar.com/',$user->picture)) //gravatar.com
				{
					echo '<img src="'.$user->picture.'" alt="'.$user->fullname.'" title="'.$user->fullname.'" class="img-circle" width="50px" height="50px" />';	
				}
				else	//Uploded image
				{					
					echo '<img src="'.base_url().RES_DIR.'/user/profile/'.$user->picture.'" alt="'.$user->fullname.'" title="'.$user->fullname.'" class="img-circle" width="50px" height="50px" />';	
				}
			
			}
			else
			{
			//Deafult pic
			if($user->gender=='m')
			echo '<img src="'.base_url().RES_DIR.'/img/user_male.png" alt="'.$user->fullname.'" title="'.$user->fullname.'" class="img-circle" width="48px" height="48px" />';
			else if($user->gender=='f')
			echo '<img src="'.base_url().RES_DIR.'/img/user_female.png" alt="'.$user->fullname.'" title="'.$user->fullname.'" class="img-circle" width="48px" height="48px" />';
			else                                        
			echo '<img src="'.base_url().RES_DIR.'/img/default-person.png" alt="'.$user->fullname.'" title="'.$user->fullname.'" class="img-circle" width="48px" height="48px" />';
													
			}
			?>              
            </td>                                   
            <td align="center">
            <a href="<?php echo base_url().'staff/staff/view_single_staff_profile/'.$user->id;?>" class="btn btn-primary btn-xs"><?=lang('action_view')?></a>
            <a href="<?php echo base_url().'staff/staff/edit_single_staff_profile/'.$user->id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            <?php
            if($this->authorization->is_permitted('delete_designation_staff_salary_month'))
            {
            ?>
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$user->id?>)" class="btn btn-danger btn-xs" />
            <?php
			}
			?>
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
