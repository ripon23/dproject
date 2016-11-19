<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_edit')?> <?=lang('user')?> <?=lang('menu_user_battalion_access_management')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_edit')?> <?=lang('user')?> <?=lang('menu_user_battalion_access_management')?> </legend> 
<form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="" method="post">   
<div class="col-md-9">
	
    
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
            <table class="table table-striped table-bordered">
                <tr>
                	<td><?=lang('user_name')?></td>
                    <td><?=$user_info->username?></td>
            	</tr>
                <tr>
                	<td><?=lang('menu_battalion')?></td>
                    <td>
                    <?php
					foreach ($all_region as $region) :
					?>
                    
                    <div class="col-md-6">                    
                    	<?php 
						echo '<span class="label label-warning">'.$this->site_model->get_region_name_by_id($region->region_id).'</span>';
						$sector_info=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'region_id', $region->region_id, 'sector_name', 'ASC');
						foreach ($sector_info as $sector) :
							echo '<div class="col-md-12"> <span class="label label-primary">'.$this->site_model->get_sector_name_by_id($sector->sector_id).'</span></div>';				
							$battalion_info=$this->general_model->get_all_table_info_by_id_asc_desc('battalion_and_licence', 'sector_id', $sector->sector_id, 'battalion_name', 'ASC');	
							foreach ($battalion_info as $battalion) :
								//echo '<div class="col-md-12"> <span class="label label-info">'.$this->site_model->get_battalion_name_by_id($battalion->battalion_id).'</span></div>';				
								?>
                                <div class="checkbox"><label><input type="checkbox" name="user_battalion[]" value="<?=$battalion->battalion_id?>" <?=$this->site_model->check_if_user_in_the_battalion($user_info->id,$battalion->battalion_id)?> ><?=$battalion->battalion_name?></label></div>
                                <?php
							endforeach;	
						endforeach;
						?>                        
                    </div>
                    
					<?php
					//echo $site->project_title."<br/>";
					endforeach;
					?>
                    <input type="hidden" name="always_true_form_submit" value="1" />
                    </td>
            	</tr>
            </table>
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg"><?=lang('action_update')?></button>
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
            <li><a href="./battalion/battalion/create_battalion"><?=lang('action_create')?> <?=lang('menu_battalion')?> </a></li>
        	<li><a href="./battalion/battalion/battalion_list"><?=lang('action_view')?> <?=lang('menu_battalion')?> </a></li>
            <li><a href="./battalion/battalion/user_battalion_mgt"><?=lang('menu_user_battalion_access_management')?>  </a></li>            
        </ul>
      </div>
    </div>


</div>


</div>


<?php echo $this->load->view('footer'); ?>
