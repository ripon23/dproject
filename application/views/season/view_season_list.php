<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(season_id)
{

	var agree=confirm("Are you sure you want to delete this salary month?");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "season/season/delete_season",
		   data: "season_id="+season_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + season_id).addClass('error');			  
					$('#row_' + season_id).fadeOut(4000, function(){   				
					$('#row_' + season_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')?> <?=lang('menu_season')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('menu_season')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./season/season/search_season_list" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('season_name')?></td>
        <td><?=lang('status')?></td>
        <td><?=lang('current_season')?></td>
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="season_name" name="season_name" type="text" placeholder="<?=lang('season_name')?>" value="<?php echo isset($season_name)?$season_name:'';?>" class="form-control"></td>        
         <td>
        <label class="radio-inline">
        	<input type="radio" name="season_status" id="season_status" value="1" <?php if(isset($season_status)) {if($season_status==1) echo 'checked';}?>> <?=lang('active')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="season_status" id="season_status" value="zero" <?php if(isset($season_status)) {if($season_status=='zero') echo 'checked';}?>> <?=lang('inactive')?>
        </label>
        </td>
        <td>
        <label class="radio-inline">
        	<input type="radio" name="current_season" id="current_season" value="Yes" <?php if(isset($current_season)) {if($current_season=='Yes') echo 'checked';}?>> <?=lang('yes')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="current_season" id="current_season" value="No" <?php if(isset($current_season)) {if($current_season='No') echo 'checked';}?>> <?=lang('no')?>	
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
        	<td><?=lang('season_name')?></td>
            <td><?=lang('season_name_bn')?></td>
            <td><?=lang('current_season')?></td>
            <td><?=lang('status')?></td>            
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_season) ) {
			foreach ($all_season as $season_info) : 
		?>
        <tr id="row_<?=$season_info->season_id?>">
        	<td><?=$season_info->season_name?></td>
            <td><?=$season_info->season_name_bn?></td>
            <td>
			<?php 
			if($season_info->current_season=='Yes')
            echo '<span class="label label-success">'.lang('yes').'</span>';
			else
			echo '<span class="label label-danger">'.lang('no').'</span>';
			?>
            </td>
            <td> 
            <?php 
			if($season_info->season_status==1)
            echo '<span class="label label-success">'.lang('active').'</span>';
			else
			echo '<span class="label label-danger">'.lang('inactive').'</span>';
			?>
            </td>                       
            
            <td>            
            <!-- Edit Button -->
            <a href="<?php echo base_url().'season/season/edit_single_season/'.$season_info->season_id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            <?php
            if($this->authorization->is_permitted('delete_designation_staff_salary_month'))
            {
            ?>
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$season_info->season_id?>)" class="btn btn-danger btn-xs" />
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
