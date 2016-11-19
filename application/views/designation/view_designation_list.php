<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function deleteclick_id(designation_id)
{

	var agree=confirm("Are you sure you want to delete this designation?");
	if(agree)
	{	

    $.ajax({
           type: "POST",
           url: "designation/designation/delete_designation",
		   data: "designation_id="+designation_id,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);
					$('#row_' + designation_id).addClass('error');			  
					$('#row_' + designation_id).fadeOut(4000, function(){   				
					$('#row_' + designation_id).removeClass('error');
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
  <li class="active"><?=lang('action_view')?> <?=lang('menu_designation')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')?> <?=lang('menu_designation')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./designation/designation/search_designation_list" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('designation_name')?></td>
        <td><?=lang('status')?></td>
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="designation_name" name="designation_name" type="text"  value="<?php echo isset($designation_name)?$designation_name:'';?>" class="form-control"></td>        
         <td>
        <label class="radio-inline">
        	<input type="radio" name="designation_status" id="designation_status" value="1" <?php if(isset($designation_status)) {if($designation_status==1) echo 'checked';}?>> <?=lang('active')?>
        </label>
        <label class="radio-inline">
          	<input type="radio" name="designation_status" id="designation_status" value="zero" <?php if(isset($designation_status)) {if($designation_status==0) echo 'checked';}?>> <?=lang('inactive')?>
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
        	<td><?=lang('designation_name')?></td>
            <td><?=lang('designation_name_bn')?></td>
            <td><?=lang('status')?></td>            
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_designation) ) {
			foreach ($all_designation as $designation_info) : 
		?>
        <tr id="row_<?=$designation_info->designation_id?>">
        	<td><?=$designation_info->designation_name?></td>
            <td><?=$designation_info->designation_name_bn?></td>            
            <td> 
             <?php 
			if($designation_info->designation_status==1)
            echo '<span class="label label-success">'.lang('active').'</span>';
			else
			echo '<span class="label label-danger">'.lang('inactive').'</span>';
			?>
            </td>                       
            
            <td>            
            <!-- Edit Button -->
            <a href="<?php echo base_url().'designation/designation/edit_single_designation/'.$designation_info->designation_id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            
            <?php
            if($this->authorization->is_permitted('delete_designation_staff_salary_month'))
            {
            ?>
            <!-- Delete Button -->
            <input type="button" name="delete" id="delete" value="<?=lang('action_delete')?>" onClick="deleteclick_id(<?=$designation_info->designation_id?>)" class="btn btn-danger btn-xs" />
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
