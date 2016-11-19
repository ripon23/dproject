<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('action_view')." ".lang('menu_salary_report')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('action_view')." ".lang('menu_salary_report')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./reports/report/salary_report_search" method="post">   
    <div class="col-md-12">
    <table class="table table-bordered">
      <tr class="warning">     
      	<td><?=lang('season_name')?></td>
        <td><?=lang('designation_name')?></td>  
        <td><?=lang('company')?></td>       
        <td><?=lang('menu_battalion')?></td>       
        <td><?=lang('action')?></td>
      </tr>
      <tr>                 
        <td>
        <?php 
		$language = $this->session->userdata('site_lang'); ?>
        <select name="season_id" class="form-control input-sm">
            <option value=""><?php echo lang('select'); ?></option>
            <?php foreach ($season_info as $season) : ?>
            <option value="<?=$season->season_id?>" <?php if($season->current_season=="Yes")  echo "selected"; ?>><?php if($language=='bangla') echo $season->season_name_bn; else echo $season->season_name; ?></option>
            <?php endforeach; ?>
        </select> 
        </td>
        <td>
        <?php $language = $this->session->userdata('site_lang'); ?>
        <select name="designation_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_designation as $designation) : ?>
          <option value="<?=$designation->designation_id?>"><?php if($language=='bangla') echo $designation->designation_name_bn; else echo $designation->designation_name; ?></option>
          <?php endforeach; ?>
        </select> 
        </td>
        <td>
        <select name="company_id" class="form-control input-sm">
          <option value=""><?php echo lang('select'); ?></option>
          <?php foreach ($all_company as $company) : ?>
          <option value="<?=$company->company_id?>"><?php if($language=='bangla') echo $company->company_name_bn; else echo $company->company_name; ?></option>
          <?php endforeach; ?>
        </select> 
        
        </td>   
        <td>
        <select name="battalion_id" class="form-control col-md-1 input-sm" id="user_role">
            <option value=""><?php echo lang('select_all'); ?></option>            
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
        
       
    
    </div> <!-- col-md-12 -->
    </form>

    <div class="col-md-12">
    
    </div> <!-- col-md-12-->
    
</div><!-- well well-lg-->


<?php echo $this->load->view('footer'); ?>
