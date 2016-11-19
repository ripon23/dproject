<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
</head>
<body>
<?php echo $this->load->view('header'); ?>

<div class="row">
<div class="col-md-9">
<div class="well well-lg" style="overflow:hidden;">




<div class="col-md-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_staff_profile')?></h3>
      </div>
      <div class="panel-body">
      <ul class="list-unstyled"> 
      		<li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <a href="./staff/staff/view_single_staff_profile/<?=$account->id?>"><?=lang('action_view')?> <?=lang('menu_staff_profile')?> </a></li>
            <li>&nbsp;</li>
      </ul>
      </div>
    </div>
</div>


</div>
</div>


<div class="col-md-3">
<div class="well well-lg">

    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled">
        	<li><a href="./patients/patient/view_single_patient_profile/<?=$account->id?>"><?=lang('action_view')?> <?=lang('menu_patient_profile')?> </a></li>
            <li><a href="./patients/patient/edit_single_patient_profile/<?=$account->id?>"><?=lang('action_edit')?> <?=lang('menu_patient_profile')?> </a></li>
        </ul>
      </div>
    </div>

</div>
</div>
</div>

<?php echo $this->load->view('footer'); ?>
