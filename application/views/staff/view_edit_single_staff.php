<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
<script>    
function getAge(dateString) {
  var today = new Date();
  var birthDate = new Date(dateString);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  //return age;
  document.getElementById("age").value=age;
}


function SubtractDays(toAdd) {
			toAdd=toAdd*365;
            if (!toAdd || toAdd == '' || isNaN(toAdd)) return;
            var d = new Date();
			var e = new Date();
            d.setDate(d.getDate() - parseInt(toAdd));
			document.getElementById("date_of_birth").value = d.getFullYear() + "-" + e.getMonth() + "-" + e.getDate();
            //document.getElementById("date_of_birth").value = d.getDate() + "/" + d.getMonth() + "/" + d.getFullYear();
        }
		
function js_same_as_barcode()
{
	if(document.getElementById('same_as_barcode').checked) {
    var input = $('#staff_id');
	$('#username').val(input.val());
	
	} else {
		var clear;
		$("#username").val(clear);
		//alert("clear");
	}
}

function js_default_password()
{
	if(document.getElementById('default_password').checked) {
    var input = '123456';
	$('#password').val(input);
	
	} else {
		var clear;
		$("#password").val(clear);
		//alert("clear");
	}
}

function check()
	{
	var letters = document.getElementById('mobile2').value.length +1;
	//alert(letters);
	if (letters <= 5)
	{
		document.getElementById('mobile2').focus()}
	else
	{
		document.getElementById('mobile3').focus()}
	}
	
	<!-- This code makes the jump from textbox two to text box three -->
	function check2()
	{
	var letters2 = document.getElementById('mobile3').value.length +1;
	if (letters2 <= 6)
	{document.getElementById('mobile3').focus()}
	else
	{document.getElementById('blood').focus()}
	}
	
function js_default_email()
{
	if(document.getElementById('default_email').checked) {
    var input = $('#staff_id');
	var email=input.val()+'@domain.com';
	$('#email').val(email);
	
	} else {
		var clear;
		$("#email").val(clear);
		//alert("clear");
	}
}

function set_username_email()
{
	var input = $('#staff_id');
	
	$('#username').val(input.val());
	
	var email=input.val()+'@domain.com';
	$('#email').val(email);
}

</script>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_edit')?> <?=lang('menu_staff')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_edit')?> <?=lang('menu_staff')?></legend>
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
			if(validation_errors())
			{					 
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?=validation_errors()?>
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
            	
            <!-- Patient  input-->
            <table class="table table-bordered table-striped">
            	<tr>
                	<td><?=lang('menu_battalion')?> *</td>
                    <td>
                    <div class="col-md-8">
                      <?php
					  if($number_of_site>1)
					  {
					  ?>
                      <select name="user_battalion" class="form-control">
                      	<option value=""><?php echo lang('select'); ?></option>
                        <?php foreach ($all_site as $site_info) : ?>
                        <option value="<?=$site_info->battalion_id?>" <?php if($staff_info->battalion_id==$site_info->battalion_id) echo "selected";?>><?php echo $this->site_model->get_battalion_name_by_id($site_info->battalion_id); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php
					  }
					  else if($number_of_site==1)
					  {
                      ?>
                      <select name="user_battalion" class="form-control">                      	                        
                        <option value="<?=$user_site->battalion_id?>"><?php echo $this->site_model->get_battalion_name_by_id($user_site->battalion_id); ?></option>                      </select>
                      <?php
                      }
					  else
					  {
						echo '<div class="alert alert-danger" role="alert"> You have not attach to a site. Contact to Admin to assign a site for you</div>';  
					  }
					  ?>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td>
                    <?=lang('menu_designation')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <?php $language = $this->session->userdata('site_lang'); ?>
                      <select name="designation_id" class="form-control">
                      	<option value=""><?php echo lang('select'); ?></option>
                        <?php foreach ($all_designation as $designation) : ?>
                        <option value="<?=$designation->designation_id?>" <?php if($staff_info->designation_id==$designation->designation_id) echo "selected";?>><?php if($language=='bangla') echo $designation->designation_name_bn; else echo $designation->designation_name; ?></option>
                        <?php endforeach; ?>
                      </select> 
                      </div>
                    </td>
            	</tr>                
               
               <tr>   
                    <td>
                    <?=lang('company')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      
                      <select name="company_id" class="form-control">
                      	<option value=""><?php echo lang('select'); ?></option>
                        <?php foreach ($all_company as $company) : ?>
                        <option value="<?=$company->company_id?>" <?php if($staff_info->company_id==$company->company_id) echo "selected";  ?>><?php if($language=='bangla') echo $company->company_name_bn; else echo $company->company_name; ?></option>
                        <?php endforeach; ?>
                      </select> 
                      </div>
                    </td>
            	</tr>
                 
                <tr>   
                    <td>
                    <?=lang('staff_id')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <input id="staff_id" name="staff_id" type="text" value="<?=$staff_info->staff_id?>" placeholder="<?=lang('staff_id')?>" onKeyUp="set_username_email()" class="form-control" />
                      </div>
                    </td>
            	</tr>                
                <tr>
                	<td><?=lang('user_name')?> *</td>
                    <td>
                    <div class="col-md-8">
                    <input id="username" name="username" type="text" value="<?=$staff_info->username?>" placeholder="<?=lang('user_name')?>" class="form-control"/>
                    </div>
                    <label><input name="same_as_barcode" id="same_as_barcode" type="checkbox" value="1" onClick="js_same_as_barcode()"> Same as Barcode</label>
                    </td>
                </tr>                            	
                
                <tr>   
                    <td>
                    <?=lang('email')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                        <input id="email" name="email" type="text" value="<?=$staff_info->email?>" placeholder="<?=lang('email')?>" class="form-control"/>
                      </div>
                      <label><input name="default_email" id="default_email" type="checkbox" value="1" onClick="js_default_email()"> Default Email</label>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('staff_name')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <input id="fullname" name="fullname" type="text" value="<?=$staff_info->fullname?>" placeholder="<?=lang('fullname')?>" class="form-control"/>
                      </div>
                    </td>
            	</tr>
                
                
                 <tr>   
                    <td>
                    <?=lang('staff_name_bangla')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                      <input id="fullname_bangla" name="fullname_bangla" type="text" value="<?=$staff_info->staff_name_bangla?>" placeholder="<?=lang('fullname_bangla')?>" class="form-control"/>
                      </div>
                    </td>
            	</tr>
                
                <tr>   
                    <td>
                    <?=lang('date_of_birth')?> <?=lang('or')?> <?=lang('age')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-3">
                      <input id="date_of_birth" name="date_of_birth" type="text" value="<?=$staff_info->dateofbirth?>" placeholder="YYYY-MM-DD" class="form-control" onBlur="getAge(this.value)"/>
                      </div>
                      <div class="col-md-2">
					  <?=lang('or')?>
                      </div>
                      <div class="col-md-3">
                       <input id="age" name="age" type="text" value="<?=set_value('age')?>" placeholder="<?=lang('age')?>"  class="form-control" />
                      </div>
                    </td>
            	</tr>
                
                
                <tr>   
                    <td>
                    <?=lang('gender')?> *
                    </td>                    
                    <td>             
                      <div class="col-md-8">                                         
                      <label><input type="radio" name="gender" id="gender" value="m" <?php if($staff_info->gender=="m") echo "checked";?>> <?php echo lang('gender_male'); ?></label>
                      <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" id="gender" value="f" <?php if($staff_info->gender=="f") echo "checked";?>> <?php echo lang('gender_female'); ?></label>
                      </div>
                    </td>
            	</tr>
                
               <tr>   
                    <td>
                    <?=lang('joining_date')?>  
                    </td>                    
                    <td>             
                      <div class="col-md-3">
                      <input id="joining_date" name="joining_date" type="text" value="<?=$staff_info->joining_date?>" placeholder="YYYY-MM-DD" class="form-control" />
                      </div>                      
                      
                    </td>
            	</tr>
                
                
                <tr>
                	<td>
               		<?=lang('address')?>  
    				</td>
    				<td>
      	              	<div class="col-md-8">
                		<textarea class="form-control" id="profile_address" name="profile_address" placeholder="<?=lang('address')?>" rows="5"><?=$staff_info->address?></textarea>
              			</div>                
                    </td>
                 <tr>   
                    <td>
                    <?=lang('mobile_no')?> 
                    </td>                    
                    <td>             
                      <div class="col-md-8">
                    		<div class="input-group">
                            <input type="text" name="mobile1" value="+88" required id="mobile1" readonly class="input-group-addon form-control" style="width:50px"  />
                            <span id="autojump">
                            <input type="text" name="mobile2" value="<?=substr($staff_info->mobile,3,5)?>"  id="mobile2" class="mobile2 form-control" style="width:70px" onKeyUp="check()" maxlength="5" placeholder="01XXX" onKeyPress="return isNumberKey(event)"  />
                            <input type="text" name="mobile3" value="<?=substr($staff_info->mobile,8,6)?>"  id="mobile3" class="mobile2 form-control" style="width:90px" onKeyUp=="check2()" maxlength="6" placeholder="XXXXXX" onKeyPress="return isNumberKey(event)"  />
                            </span>
                            <span class="help-block"></span> 
                    		</div>

                 	</div>
                
                    </td>
            	</tr>
                
                <tr>   
                    <td><?=lang('national_id')?> </td>
            		<td>
                    <div class="col-md-8">                        
                        <input id="national_id" name="national_id" type="text" value="<?=$staff_info->national_id?>" placeholder="<?=lang('national_id')?>" class="form-control" />
                    </div>
                    </td>
                </tr>
                                
            	<tr>   
                    <td><?=lang('blood_group')?> </td>
            		<td>
                    <div class="col-md-8">                        
                        <select name="profile_blood_group" id="profile_blood_group" class="form-control">
                        <option value=""><?php echo lang('select'); ?></option>
                    	<option value="A+" <?php if($staff_info->blood_group=="A+") echo "selected";?> >A+</option>            
                       	<option value="A-" <?php if($staff_info->blood_group=="A-") echo "selected";?>>A-</option>
                        <option value="B+" <?php if($staff_info->blood_group=="B+") echo "selected";?>>B+</option>
                        <option value="B-" <?php if($staff_info->blood_group=="B-") echo "selected";?>>B-</option>
                        <option value="AB+" <?php if($staff_info->blood_group=="AB+") echo "selected";?>>AB+</option>
                        <option value="AB-" <?php if($staff_info->blood_group=="AB-") echo "selected";?>>AB-</option>
                        <option value="O+" <?php if($staff_info->blood_group=="O+") echo "selected";?>>O+</option>
                        <option value="O-" <?php if($staff_info->blood_group=="O-") echo "selected";?>>O-</option>                        
	                	</select>
                    </div>
                    </td>
                </tr>     
            	
                <tr>   
                    <td><?=lang('main_salary')?> </td>
            		<td>
                    <div class="col-md-8">                        
                        <input id="main_salary" name="main_salary" type="text" value="<?=$staff_info->main_salary?>" placeholder="<?=lang('main_salary')?>" class="form-control" />
                    </div>
                    </td>
                </tr>
                
                
                <tr>   
                    <td><?=lang('educational_qualification')?></td>
            		<td>
                    <div class="col-md-8">
                        <input class="form-control" id="educational_qualification" name="educational_qualification" placeholder="<?=lang('educational_qualification')?>" value="<?=$staff_info->educational_qualification?>"/>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td><?=lang('successor')?></td>
            		<td>
                    <div class="col-md-8">
                        <input class="form-control" id="successor" name="successor" placeholder="<?=lang('successor')?>" value="<?=$staff_info->successor?>"/>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td><?=lang('bank_account_no')?></td>
            		<td>
                    <div class="col-md-8">
                        <input class="form-control" id="bank_account_no" name="bank_account_no" placeholder="<?=lang('bank_account_no')?>"  value="<?=$staff_info->bank_account_no?>"/>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td><?=lang('marital_status')?> </td>
            		<td>
                    <div class="col-md-8">                        
                        <select name="marital_status" id="marital_status" class="form-control">
                        <option value=""><?php echo lang('select'); ?></option>
                    	<option value="single" <?php if($staff_info->marital_status=="single") echo "selected";?> ><?=lang('single')?></option>            
                       	<option value="married" <?php if($staff_info->marital_status=="married") echo "selected";?>><?=lang('married')?></option>
                        <option value="divorced" <?php if($staff_info->marital_status=="divorced") echo "selected";?>><?=lang('divorced')?></option>
                        <option value="widowed" <?php if($staff_info->marital_status=="widowed") echo "selected";?>><?=lang('widowed')?></option>
	                	</select>
                    </div>
                    </td>
                </tr>
                
                <tr>   
                    <td><?=lang('gpf_number')?></td>
            		<td>
                    <div class="col-md-8">
                        <input class="form-control" id="gpf_number" name="gpf_number" placeholder="<?=lang('gpf_number')?>" value="<?=set_value('gpf_number')?>"/>
                    </div>
                    </td>
                </tr>
                
                
            	<tr>   
                    <td><?=lang('note')?></td>
            		<td>
                    <div class="col-md-8">
                        <textarea class="form-control" id="profile_note" name="profile_note" placeholder="<?=lang('note')?>" rows="5"><?=$staff_info->note?></textarea>
                    </div>
                    </td>
                </tr>                             
        		
                <tr>   
                    <td><?=lang('staff_picture')?></td>
            		<td>
                    <?php
					if($staff_info->picture){
					?>
                    <img src="<?=RES_DIR?>/user/profile/<?=$staff_info->picture?>" title="<?=$staff_info->fullname?>" alt="<?=$staff_info->fullname?>"/>
                    
                    <?php
					}
					?>
                    <div class="col-md-8">
                        <input type="file" class="input-large" name="staff_picture" /> <small>Maximum Width x Height =400 x 500 Pixel</small>
                    </div>
                    </td>
                </tr>                             
                              
            </table>
                                        
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-warning btn-lg"><?=lang('action_update')?></button>
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
