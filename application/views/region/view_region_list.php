<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(region_id)
{

	var agree=confirm("Are you sure you want to delete this region?");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "region/region/delete_region",
		   data: "region_id="+region_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + region_id).addClass('error');			  
					$('#row_' + region_id).fadeOut(4000, function(){   				
					$('#row_' + region_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')?> <?=lang('menu_region')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('menu_region')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./region/region/search_region_list" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('region_name')?></td>
        <td><?=lang('status')?></td>
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="region_name" name="region_name" type="text" placeholder="<?=lang('region_name')?>" value="<?php echo isset($region_name)?$region_name:'';?>" class="form-control"></td>        
         <td>
        <label class="radio-inline">
        	<input type="radio" name="region_status" id="region_status" value="1" <?php if(isset($region_status)) {if($region_status==1) echo 'checked';}?>> <?=lang('active')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="region_status" id="region_status" value="zero" <?php if(isset($region_status)) {if($region_status==0) echo 'checked';}?>> <?=lang('inactive')?>
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
        	<td><?=lang('region_name')?></td>
            <td><?=lang('region_name_bn')?></td>
            <td><?=lang('region_address')?></td>
            <td><?=lang('status')?></td>            
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_region) ) {
			foreach ($all_region as $region_info) : 
		?>
        <tr id="row_<?=$region_info->region_id?>">
        	<td><?=$region_info->region_name?></td>
            <td><?=$region_info->region_name_bn?></td>
            <td>
			<?php 
			echo $region_info->region_address;
			?>
            </td>
            <td> 
             <?php 
			if($region_info->region_status==1)
            echo '<span class="label label-success">'.lang('active').'</span>';
			else
			echo '<span class="label label-danger">'.lang('inactive').'</span>';
			?>
            </td>                       
            
            <td>            
            <!-- Edit Button -->
            <a href="<?php echo base_url().'region/region/edit_single_region/'.$region_info->region_id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            <?php
            if($this->authorization->is_permitted('delete_region_sector_battalion'))
            {
            ?>
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$region_info->region_id?>)" class="btn btn-danger btn-xs" />
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
