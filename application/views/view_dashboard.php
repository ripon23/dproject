<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>
<div class="cl-md-12">
	<?php if ($this->session->flashdata('parmission')):?>
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-info-sign"></span>
        	<strong>Warning!</strong>
			<?php
            echo  $this->session->flashdata('parmission');
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <?php endif;?>
</div>
<div class="row">
<div class="col-md-9">
<div class="well well-lg" style="overflow:hidden;">

<?php
if($this->authorization->is_permitted('manage_region'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_region_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./region/region/create_region"><?=lang('action_create')?> <?=lang('menu_region')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./region/region/region_list"><?=lang('action_view')?> <?=lang('menu_region')?> </a></li>
            <li>&nbsp;</li>
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>

<?php
if($this->authorization->is_permitted('manage_sector'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_sector_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./sector/sector/create_sector"><?=lang('action_create')?> <?=lang('menu_sector')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./sector/sector/sector_list"><?=lang('action_view')?> <?=lang('menu_sector')?> </a></li>
            <li>&nbsp;</li>
        </ul>               
      </div>
    </div>
</div>
<?php 
}
?>

<?php
if($this->authorization->is_permitted('manage_battalion_licence'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_battalion_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./battalion/battalion/create_battalion"><?=lang('action_create')?> <?=lang('menu_battalion')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./battalion/battalion/battalion_list"><?=lang('action_view')?> <?=lang('menu_battalion')?> </a></li>
            <?php
			if($this->authorization->is_permitted('battalion_user_access_management'))
			{
			?>
            <li><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> <a href="./battalion/battalion/user_battalion_mgt"><?=lang('menu_access_management')?></a></li>
            <?php
			}
			else
			{
			?>
            <li>&nbsp;</li>            
            <?php
			}
			?>
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>



<?php
if($this->authorization->is_permitted('designation_management'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_designation_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./designation/designation/create_designation"><?=lang('action_create')?> <?=lang('menu_designation')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./designation/designation/designation_list"><?=lang('action_view')?> <?=lang('menu_designation')?> </a></li>            
            <li><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> <a href="./designation/designation/unit_wise_designation"><?=lang('action_view')?> <?=lang('unit_wise_designation')?> </a></li>            
            
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>


<?php
if($this->authorization->is_permitted('staff_management'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_staff_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./staff/staff/create_staff"><?=lang('action_create')?> <?=lang('menu_staff')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./staff/staff/staff_details_list"><?=lang('action_view')?> <?=lang('menu_staff')?> </a></li>            
            <li>&nbsp;</li>            
            
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>


<?php
if($this->authorization->is_permitted('salary_month_management'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_salary_month_management')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="./season/season/create_season"><?=lang('action_create')?> <?=lang('menu_salary_month')?> </a></li>
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./season/season/season_list"><?=lang('action_view')?> <?=lang('menu_salary_month')?> </a></li>            
            <li>&nbsp;</li>            
            
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>	


<?php
if($this->authorization->is_permitted('can_see_salary_report'))
{
?> 
<div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_salary_report')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">        	
        	<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./reports/report/salary_report"> <?=lang('menu_salary_report')?> </a></li>  
            <li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./reports/report/salary_report_payroll"> <?=lang('menu_salary_report')?>(<?=lang('payroll')?>) </a></li>            
            <li><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> <a href="./reports/report/staff_salary_bill"> <?=lang('menu_staff_salary_bill')?> </a></li> 
            <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="./reports/report/salary_summary"> <?=lang('menu_salary_summary')?> </a></li>                    
        </ul>       
        
      </div>
    </div>
</div>
<?php 
}
?>	



<?php
if($this->authorization->is_permitted('cms_view_news'))
{
?>
<div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading ">
        <h3 class="panel-title"><?php echo lang('menu_news_mangement')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/news"><?php echo lang('menu_news_list')?> </a></li>
            <li><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/news/save"> <?php echo lang('menu_news_add')?> </a></li>
            <li>&nbsp;</li>           
            
        </ul>
      </div>
    </div>
</div>
<?php 
}
?>

<?php
if($this->authorization->is_permitted('cms_view_page'))
{
?>
<div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('menu_page_mangement')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/pages"><?php echo lang('menu_page_list')?> </a></li>
            <li><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/pages/save"> <?php echo lang('menu_page_add')?> </a></li>
            <li>&nbsp;</li>         
            
        </ul>
      </div>
    </div>
</div>
<?php 
}
?>

<?php
if($this->authorization->is_permitted('cms_view_gallery'))
{
?>
<div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading ">
        <h3 class="panel-title"><?php echo lang('menu_gallery_mangement')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/gallery"><?php echo lang('menu_gallery_list')?> </a></li>
            <li><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/gallery/save"> <?php echo lang('menu_gallery_add')?> </a></li>
            <li>&nbsp;</li>           
            
        </ul>
      </div>
    </div>
</div>
<?php 
}
?>
<?php
if($this->authorization->is_permitted('cms_view_slide'))
{
?>
<div class="col-md-4">
    <div class="panel panel-success">
      <div class="panel-heading ">
        <h3 class="panel-title"><?php echo lang('menu_slide_mangement')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
            <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/slider"><?php echo lang('menu_slide_list')?> </a></li>
            <li><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/slider/save"> <?php echo lang('menu_slide_add')?> </a></li>
            <li>&nbsp;</li>           
            
        </ul>
      </div>
    </div>
</div>
<?php 
}
?>

</div>
</div>


<div class="col-md-3">
<div class="well well-lg">

    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_staff_search')?></h3>
      </div>
      <div class="panel-body">
                <form class="navbar-form navbar-right" role="search" id="search-form"  name="search-form" action="./dashboard/staff_search" method="post">             
                <div class="input-group">                        
                    <input type="text" class="form-control input-sm" name="search_param" placeholder="<?=lang('staff_id')?>" value="<?=set_value('search_param')?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>            
                </form>
      </div>
    </div>
    
    

</div>
</div>
</div>

<?php echo $this->load->view('footer'); ?>
