<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
<script>    
    jQuery(document).ready(function(){
	
	//Start
	$("#battalion_division").change(function()
	{
	var dvid=$(this).val();
	var ltype='DT';
	var dataString = 'dvid='+ dvid+'&ltype='+ltype;
	
	$.ajax
		({
			type: "POST",
			url: "battalion/battalion/get_all_child_location",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#battalion_district").html(html);	
			}
		});
	
	});
	//End
	
	//Start
	$("#battalion_district").change(function()
	{
	var dvid=$("#battalion_division").val();	
	var dtid=$(this).val();
	var ltype='UP';
	var dataString = 'dvid='+ dvid+'&dtid='+ dtid+'&ltype='+ltype;	
	
	$.ajax
		({
			type: "POST",
			url: "battalion/battalion/get_all_child_location",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#battalion_upazila").html(html);			
			
			//$( "span#registration_no_part1" ).text()=dtid;			
			$("#registration_no_part1").html(dtid);
			//document.getElementById('registration_no_part1').value = dtid;
			}
		});		
		
	
	});
	//End
	
	//Start
	$("#battalion_upazila").change(function()
	{
	var dvid=$("#battalion_division").val();	
	var dtid=$("#battalion_district").val();	
	var upid=$(this).val();
	var ltype='UN';
	var dataString = 'dvid='+ dvid+'&dtid='+ dtid+'&upid='+upid+'&ltype='+ltype;			
	
	$.ajax
		({
			type: "POST",
			url: "battalion/battalion/get_all_child_location",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#battalion_union").html(html);
			$("#registration_no_part1").html(dtid);
			$("#registration_no_part1_1").html(upid);
			//document.getElementById('registration_no_part1').value = dtid;
			//var box = $("#registration_no_part1");
   			//box.val(box.val()+upid);
			}
		});
		
	
	});
	//End
	
	//Start
	$("#battalion_union").change(function()
	{
	var dvid=$("#battalion_division").val();	
	var dtid=$("#battalion_district").val();	
	var upid=$("#battalion_upazila").val();
	var unid=$(this).val();
	var ltype='MA';
	var dataString = 'dvid='+ dvid+'&dtid='+ dtid+'&upid='+upid+'&unid='+unid+'&ltype='+ltype;				
	$.ajax
		({
			type: "POST",
			url: "battalion/battalion/get_all_child_location",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#battalion_mouza").html(html);
			$("#registration_no_part1").html(dtid);
			$("#registration_no_part1_1").html(upid);
			$("#registration_no_part1_2").html(unid);
			//document.getElementById('registration_no_part1').value = dtid;
			//var box = $("#registration_no_part1");
			//box.val(box.val()+upid);
			//var box = $("#registration_no_part1");
			//box.val(box.val()+unid);
			}
		});
	
	
	});
	//End
	
	
	
	//Start
	$("#region").change(function()
	{
	var region_id=$("#region").val();	

	var dataString = 'region_id='+ region_id;				
	$.ajax
		({
			type: "POST",
			url: "battalion/battalion/get_all_sector_by_region_id",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#sector").html(html);
			}
		});
	
	
	});
	//End
	
	
	
});
</script>	
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_create')?> <?=lang('menu_battalion')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_create')?> <?=lang('menu_battalion')?> </legend>
<form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="" method="post">   
<div class="col-md-6">
	
   <fieldset>
                		                        
			
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
            	
            <!-- Site Name input-->
            
                
            <div class="form-group <?php echo (form_error('battalion_name')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="battalion_name"><?=lang('battalion_name')?> *</label>
              <div class="col-md-7">              	 
                <input id="battalion_name" name="battalion_name" type="text" placeholder="<?=lang('battalion_name')?>" value="<?=set_value('battalion_name')?>" class="form-control">
                <?php if (form_error('battalion_name')) :?>                                                  
                	<?php echo form_error('battalion_name', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
    		
            <div class="form-group <?php echo (form_error('battalion_name_bn')) ? 'has-error' : ''; ?>">
            	
              <label class="col-md-5 control-label" for="battalion_name_bn"><?=lang('battalion_name_bn')?> *</label>
              <div class="col-md-7">              	 
                <input id="battalion_name_bn" name="battalion_name_bn" type="text" placeholder="<?=lang('battalion_name_bn')?>" value="<?=set_value('battalion_name_bn')?>" class="form-control">
                <?php if (form_error('battalion_name_bn')) :?>                                                  
                	<?php echo form_error('battalion_name_bn', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-5 control-label" for="battalion_address"><?=lang('battalion_address')?></label>
              <div class="col-md-7">
                <textarea class="form-control" id="battalion_address" name="battalion_address" placeholder="<?=lang('battalion_address')?>" rows="5"><?=set_value('battalion_address')?></textarea>
              </div>
            </div> 
            
            <div class="form-group <?php echo (form_error('region')) ? 'has-error' : ''; ?>">
                <label class="col-md-5 control-label" for="region"><?=lang('region_name')?> *</label>
                <div class="col-md-7">
                <?php  $language = $this->session->userdata('site_lang');?>
                <select name="region" id="region" class="form-control">
                    <option value=""><?php echo '--'.lang('select').'--'; ?></option>            
                    <?php foreach ($region_info as $region) : ?>
                    <option value="<?php echo $region->region_id; ?>"><?php  if($language=='bangla') echo $region->region_name_bn; else echo $region->region_name; ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
            
            
             
            <div class="form-group <?php echo (form_error('sector')) ? 'has-error' : ''; ?>">
                <label class="col-md-5 control-label" for="region"><?=lang('sector_name')?> *</label>
                <div class="col-md-7">
            	<select name="sector" id="sector" class="form-control">
          			<option value=""><?php echo '--'.lang('select').'--'; ?></option>                            
        		</select>
            	</div>
            </div>
            
            
            
           <!-- Site Latitude input-->
            <div class="form-group">
              <label class="col-md-5 control-label" for="battalion_latitude"><?=lang('latitude')?> </label>
              <div class="col-md-7">
                <input id="battalion_latitude" name="battalion_latitude" type="text" placeholder="<?=lang('latitude')?>" value="<?=set_value('battalion_latitude')?>" class="form-control">
              </div>
            </div>
            
            
            <!-- Site Longitude input-->
            <div class="form-group">
              <label class="col-md-5 control-label" for="battalion_longitude"><?=lang('longitude')?> </label>
              <div class="col-md-7">
                <input id="battalion_longitude" name="battalion_longitude" type="text" placeholder="<?=lang('longitude')?>"  value="<?=set_value('battalion_longitude')?>"class="form-control">
              </div>
            </div>
    		
            
            
            
            <!-- Site division input-->
            <div class="form-group <?php echo (form_error('battalion_division')) ? 'has-error' : ''; ?>">
              <label class="col-md-5 control-label" for="battalion_longitude"><?=lang('division')?> *</label>
              <div class="col-md-7">
               
                <select name="battalion_division" id="battalion_division" class="form-control">
          			<option value=""><?php echo '--'.lang('select').'--'; ?></option>            
                	<?php foreach ($all_division as $division) : ?>
            		<option value="<?php echo $division->division; ?>"><?php echo $division->loc_name_en?></option>
					<?php endforeach; ?>
       			</select>
                <?php if (form_error('battalion_division')) :?>                                                  
                	<?php echo form_error('battalion_division', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            
            <!-- Site district input-->
            <div class="form-group <?php echo (form_error('battalion_district')) ? 'has-error' : ''; ?>">
              <label class="col-md-5 control-label" for="battalion_district"><?=lang('district')?> *</label>
              <div class="col-md-7">               
                <select name="battalion_district" id="battalion_district" class="form-control">
          			<option value=""><?php echo '--'.lang('select').'--'; ?></option>                            
        		</select>
                <?php if (form_error('battalion_district')) :?>                                                  
                	<?php echo form_error('battalion_district', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            
            <!-- Site upazila input-->
            <div class="form-group">
              <label class="col-md-5 control-label" for="battalion_upazila"><?=lang('upazila')?> </label>
              <div class="col-md-7">
                <select name="battalion_upazila" id="battalion_upazila" class="form-control">
          		<option value=""><?php echo '--'.lang('select').'--'; ?></option>                            
        		</select>
              </div>
            </div>
            
            <!-- Site union input-->
            <div class="form-group">
              <label class="col-md-5 control-label" for="battalion_union"><?=lang('union')?> </label>
              <div class="col-md-7">
                <select name="battalion_union" id="battalion_union" class="form-control">
          		<option value=""><?php echo '--'.lang('select').'--'; ?></option>                            
        		</select>
              </div>
            </div>
            
            <div class="form-group <?php echo (form_error('battalion_license_key')) ? 'has-error' : ''; ?>">
              <label class="col-md-5 control-label" for="battalion_license_key"><?=lang('battalion_license_key')?> *</label>
              <div class="col-md-7">
              
                <input id="battalion_licence_key" name="battalion_license_key" type="text" placeholder="<?=lang('battalion_license_key')?>" value="<?=set_value('battalion_license_key')?>" class="form-control">
                <?php if (form_error('battalion_license_key')) :?>                                                  
                	<?php echo form_error('battalion_license_key', '<p class="text-danger">', '</p>'); ?>                                                  
				<?php endif; ?>
              </div>
            </div>
            
            
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg"><?=lang('action_save')?></button>
              </div>
            </div>
            
          </fieldset>

</div> <!-- col-md-5 -->
</form>

<div class="col-md-3 col-md-offset-3">


    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><a href="./"><?=lang('home')?> </a></li>
        	<li><a href="./battalion/battalion/battalion_list"><?=lang('action_view')?> <?=lang('menu_battalion')?> </a></li>
            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
