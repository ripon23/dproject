<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('user')?> <?=lang('menu_user_battalion_access_management')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('user')?> <?=lang('menu_user_battalion_access_management')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./battalion/battalion/user_battalion_mgt_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">
        <td><?=lang('user_name')?></td>
        <td><?=lang('user_role')?></td>
        <td><?=lang('menu_region')?></td>       
        <td><?=lang('menu_sector')?></td>       
        <td><?=lang('action')?></td>
      </tr>
      <tr>
        <td><input id="user_name" name="user_name" type="text" placeholder="<?=lang('user_name')?>" value="<?php echo isset($user_name)?$user_name:'';?>" class="form-control input-sm"></td>
        <td>
        <select name="user_role" class="form-control col-md-1 input-sm" id="user_role">
            <option value=""><?php echo lang('select_all'); ?></option>            
            <?php foreach ($roles as $role) : ?>
            <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
            <?php endforeach; ?>
        </select>
        
        </td>
        <td>
        <select name="region_id" class="form-control col-md-1 input-sm" id="user_role">
            <option value=""><?php echo lang('select_all'); ?></option>            
            <?php foreach ($all_region as $region) : ?>
            <option value="<?php echo $region->region_id; ?>"><?php echo $region->region_name; ?></option>
            <?php endforeach; ?>
        </select>	
        </td>  
        <td>
        <select name="sector_id" class="form-control col-md-1 input-sm" id="user_role">
            <option value=""><?php echo lang('select_all'); ?></option>            
            <?php foreach ($all_sector as $sector) : ?>
            <option value="<?php echo $sector->sector_id; ?>"><?php echo $sector->sector_name; ?></option>
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
        	<td><?=lang('user_name')?></td>
            <td><?=lang('user_role')?></td>
            <td><?=lang('menu_battalion')?></td>                       
            <td><?=lang('menu_sector')?></td> 
            <td><?=lang('menu_region')?></td>          
            <td align="center"><?=lang('action')?></td>
      	</tr>
     	<?php 
		if( !empty($all_user) ) {
			
			$battalion_region;
			$battalion_sector;
				
			foreach ($all_user as $user) : 
		?>
        <tr>
        	<td><?=$user->username?></td>
            <td>
			<?php 			
			$all_user_role=$this->site_model->get_all_user_role($user->id);
			foreach ($all_user_role as $user_role) :
				echo '<span class="label label-primary">'.$this->site_model->get_role_name_by_id($user_role->role_id).'</span> ';
			endforeach; 
            ?>			
            </td>
            <td>
            <?php
			$all_user_battalion=$this->site_model->get_all_user_battalion($user->id);
			if($all_user_battalion)
			{
				
				$i=0;
				foreach ($all_user_battalion as $user_battalion) :
					echo '<span class="label label-info">'.$this->site_model->get_battalion_name_by_id($user_battalion->battalion_id).'</span> ';
					$battalion_region[$i]= $this->site_model->get_battalion_region_by_id($user_battalion->battalion_id);
					$battalion_sector[$i]= $this->site_model->get_battalion_sector_by_id($user_battalion->battalion_id);
				$i++;	
				endforeach; 
			}
			?>
			
            </td>
            
            <td>
            <?php 
			if($all_user_battalion)
			{
				$battalion_sector=array_unique($battalion_sector);	
				$battalion_sector=array_values($battalion_sector);
				//print_r($battalion_sector);
				
				for($j=0;$j<count($battalion_sector);$j++)
				{								
				echo '<span class="label label-primary">'.$this->site_model->get_sector_name_by_id($battalion_sector[$j]).'</span><br>';		
				}
			}
			?>
            </td>
            
            <td>
            <?php  
			if($all_user_battalion)
			{
				$battalion_region=array_unique($battalion_region);
				$battalion_region=array_values($battalion_region);
				for($j=0;$j<count($battalion_region);$j++)
				{					
				echo '<span class="label label-warning">'.$this->site_model->get_region_name_by_id($battalion_region[$j]).'</span><br>';		
				}
			}
			
			?>
            </td>
            
            <td>            
            <!-- Edit Button -->
			<?php if ($this->authorization->is_permitted('battalion_user_access_management')) : ?> 
            <a href="<?php echo base_url().'battalion/battalion/edit_user_battalion/'.$user->id;?>" class="btn btn-warning btn-xs"><?=lang('action_edit')?></a>
            <?php endif; ?>
            
            
            </td>
        </tr>
        <?php 
		
			unset($battalion_region);
			unset($battalion_sector);
			
			endforeach; 
		}	//end if
		?>     
    </table>
    
    <div style="text-align:left"><?php echo $links; ?></div>
    </div> <!-- col-md-12-->
    
</div><!-- well well-lg-->


<?php echo $this->load->view('footer'); ?>
