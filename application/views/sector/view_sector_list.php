<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(sector_id)
{

	var agree=confirm("Are you sure you want to delete this sector?");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "sector/sector/delete_sector",
		   data: "sector_id="+sector_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + sector_id).addClass('error');			  
					$('#row_' + sector_id).fadeOut(4000, function(){   				
					$('#row_' + sector_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')?> <?=lang('menu_sector')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('menu_sector')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./sector/sector/search_sector_list" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('sector_name')?></td>
        <td><?=lang('region_name')?></td>
        <td><?=lang('status')?></td>
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="sector_name" name="sector_name" type="text" placeholder="<?=lang('sector_name')?>" value="<?php echo isset($sector_name)?$sector_name:'';?>" class="form-control"></td>        
         
         <td>
         <?php  $language = $this->session->userdata('site_lang');?>
                <select name="sector_region" id="sector_region" class="form-control">
          			<option value=""><?php echo '--'.lang('select').'--'; ?></option>            
                	<?php foreach ($region_info as $region) : ?>
            		<option value="<?php echo $region->region_id; ?>"><?php  if($language=='bangla') echo $region->region_name_bn; else echo $region->region_name; ?></option>
					<?php endforeach; ?>
       			</select>
         
         </td>
         <td>
        <label class="radio-inline">
        	<input type="radio" name="sector_status" id="sector_status" value="1" <?php if(isset($sector_status)) {if($sector_status==1) echo 'checked';}?>> <?=lang('active')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="sector_status" id="sector_status" value="zero" <?php if(isset($sector_status)) {if($sector_status==0) echo 'checked';}?>> <?=lang('inactive')?>
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
        	<td><?=lang('sector_name')?></td>
            <td><?=lang('sector_name_bn')?></td>
            <td><?=lang('region_name')?></td>
            <td><?=lang('sector_address')?></td>
            <td><?=lang('status')?></td>            
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_sector) ) {
			foreach ($all_sector as $sector_info) : 
		?>
        <tr id="row_<?=$sector_info->sector_id?>">
        	<td><?=$sector_info->sector_name?></td>
            <td><?=$sector_info->sector_name_bn?></td>
            <td>
			<?php
			$region=$this->general_model->get_all_table_info_by_id('bgb_region', 'region_id', $sector_info->region_id);
            $language = $this->session->userdata('site_lang');			
			if($language=='bangla') echo $region->region_name_bn; else echo $region->region_name;
			?>
            </td>
            <td>
			<?php 
			echo $sector_info->sector_address;
			?>
            </td>
            <td> 
             <?php 
			if($sector_info->sector_status==1)
            echo '<span class="label label-success">'.lang('active').'</span>';
			else
			echo '<span class="label label-danger">'.lang('inactive').'</span>';
			?>
            </td>                       
            
            <td>
                       
            <!-- Edit Button -->
            <a href="<?php echo base_url().'sector/sector/edit_single_sector/'.$sector_info->sector_id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>	
           
            <?php
            if($this->authorization->is_permitted('delete_region_sector_battalion'))
            {
            ?> 
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$sector_info->sector_id?>)" class="btn btn-danger btn-xs" />

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
