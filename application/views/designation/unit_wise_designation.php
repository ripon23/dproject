<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
    <script>
function saveclick_id(battalion_id,designation_id)
{
	var designation_quota = $("#designation_quota_"+battalion_id+"_"+designation_id).val();    
	//alert(designation_quota);
	$.ajax({
           type: "POST",
           url: "designation/designation/save_unit_wise_designation_quota",
		   data: "battalion_id="+battalion_id+"&designation_id="+designation_id+"&designation_quota="+designation_quota,
           success: function(msg)
           {               	
			   	if(msg=="Successfull")
				{
					//removeTableRow(button_id);					
				}
			alert(msg); // show response from the php script.			      	
           }
         });

    return false; // avoid to execute the actual submit of the form.
	
			
}// END deleteclick_id
</script>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_view')." ".lang('menu_salary_report')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')." ".lang('unit_wise_designation')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./designation/designation/unit_wise_designation_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">                  
        <td><?=lang('menu_battalion')?></td>       
        <td><?=lang('action')?></td>
      </tr>
      <tr>                 
          
        <td>
        <select name="battalion_id" class="form-control col-md-1 input-sm" id="user_role">            
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
        
     
     <table class="table table-bordered">
      <tr class="warning">                  
        <td><?=lang('menu_battalion')?></td>       
        <td><?=lang('designation_name')?></td>
        <td><?=lang('designation_name_bn')?></td>
        <td><?=lang('count')?></td>
        <td><?=lang('quota')?></td>
      </tr>
      <?php
	  if(isset($unit_wise_designation))
	  {
	  	foreach($unit_wise_designation as $count_designation)
	  	{
	  	?>
        <tr>  
            <td><?=$this->site_model->get_battalion_name_by_id($count_designation->battalion_id)?></td>  
            <td><?=$count_designation->designation_name?></td>  
            <td><?=$count_designation->designation_name_bn?></td> 
            <td><?=$this->general_model->en2bnNumber($count_designation->count_designation)?></td>
            <td nowrap>
            <?php 
			$designation_quota=$this->site_model->get_unit_wise_designation_quota($count_designation->battalion_id,$count_designation->designation_id);
			?>
            <input class="form-control input-sm" name="designation_quota" id="designation_quota_<?=$count_designation->battalion_id?>_<?=$count_designation->designation_id?>" style="width:80px; display:inline;" type="text" placeholder="<?=lang('quota')?>" value="<?php echo $designation_quota;?>">&nbsp;&nbsp;<input type="button" name="save" id="save" value="<?=lang('action_save')?>" onClick="saveclick_id(<?=$count_designation->battalion_id?>,<?=$count_designation->designation_id?>)" class="btn btn-success btn-sm" /></td>  
        </tr>
        <?php
	  	}
	  }
	  ?>
    </table>  
    
    </div> <!-- col-md-12 -->
    </form>

    <div class="col-md-12">
    
    </div> <!-- col-md-12-->
    
</div><!-- well well-lg-->


<?php echo $this->load->view('footer'); ?>
