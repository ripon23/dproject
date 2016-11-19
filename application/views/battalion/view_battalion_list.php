<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(battalion_id)
{

	var agree=confirm("Are you sure you want to delete this battalion?");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "battalion/battalion/delete_battalion",
		   data: "battalion_id="+battalion_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + battalion_id).addClass('error');			  
					$('#row_' + battalion_id).fadeOut(4000, function(){   				
					$('#row_' + battalion_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')?> <?=lang('menu_battalion')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('menu_battalion')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./battalion/battalion/search_battalion_list" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('battalion_name')?></td>
        <td><?=lang('district')?></td>
        <td><?=lang('status')?></td>
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="battalion_name" name="battalion_name" type="text"  value="<?php echo isset($battalion_name)?$battalion_name:'';?>" class="form-control"></td>
        <td><select name="battalion_district" id="battalion_district" class="form-control">
          			<option value=""><?php echo '--'.lang('select').'--'; ?></option>            
                	<?php foreach ($all_district as $district) : ?>
            		<option value="<?php echo $district->district; ?>"><?php echo $district->loc_name_en?></option>
					<?php endforeach; ?>
       			</select>
        </td>
         <td>
        <label class="radio-inline">
        	<input type="radio" name="battalion_status" id="battalion_status" value="1" <?php if(isset($battalion_status)) {if($battalion_status==1) echo 'checked';}?>> <?=lang('active')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="battalion_status" id="battalion_status" value="zero" <?php if(isset($battalion_status)) {if($battalion_status==0) echo 'checked';}?>> <?=lang('inactive')?>
        </label>
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
        	<td><?=lang('battalion_name')?></td>
            <td><?=lang('battalion_name_bn')?></td>
            <td><?=lang('district')?></td>
            <td><?=lang('status')?></td>
            <td><?=lang('latitude')?>, <?=lang('longitude')?></td>
            
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_battalion) ) {
			foreach ($all_battalion as $battalion_info) : 
		?>
        <tr id="row_<?=$battalion_info->battalion_id?>">
        	<td><?=$battalion_info->battalion_name?></td>
            <td><?=$battalion_info->battalion_name_bn?></td>
            <td>
			<?php 
			echo $this->ref_location_model->get_district_name_from_id($battalion_info->battalion_district);
			?>
            </td>
            <td> 
             <?php 
			if($battalion_info->battalion_status==1)
            echo '<span class="label label-success">'.lang('active').'</span>';
			else
			echo '<span class="label label-danger">'.lang('inactive').'</span>';
			?>
            </td>
            <td>
			<?php if($battalion_info->battalion_latitude)
			echo $battalion_info->battalion_latitude." ,".$battalion_info->battalion_longitude;			
            ?>
            </td>
            
            
            <td>            
            <!-- Edit Button -->
            <a href="<?php echo base_url().'battalion/battalion/edit_single_battalion/'.$battalion_info->battalion_id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            
            <?php
            if($this->authorization->is_permitted('delete_region_sector_battalion'))
            {
            ?>
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$battalion_info->battalion_id?>)" class="btn btn-danger btn-xs" />
			<?php
			}
			?>

            
            </td>
        </tr>
        <?php 			
			endforeach; 
		}	//end if
		?>     
    </table>
    
    <div style="text-align:left"><?php echo $links; ?></div>
    </div> <!-- col-md-12-->
    
</div><!-- well well-lg-->


<?php echo $this->load->view('footer'); ?>
