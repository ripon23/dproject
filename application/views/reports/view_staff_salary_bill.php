<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php echo $this->load->view('header'); ?>


<ol class="breadcrumb">
  <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
  <li class="active"><?=lang('menu_staff_salary_bill')?></li>
</ol>

<div class="well well-lg" style="overflow:hidden">
<legend class="text-center"><?=lang('menu_staff_salary_bill')?> </legend>  
    <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="./reports/report/staff_salary_bill_search" method="post">   
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
    	
        
	</div>
            
    
</div><!-- well well-lg-->

<script type="text/javascript">
<!--
function printContent(id){
str=document.getElementById(id).innerHTML
newwin=window.open('','printwin','left=100,top=100,width=800,height=900')
newwin.document.write('<html>\n<head>\n <link rel=\"stylesheet\" type=\"text/css\"  href=\"<?php echo base_url().RES_DIR; ?>/dist/css/bootstrap.min.css\">\n<link rel=\"stylesheet\" type=\"text/css\"  href=\"<?php echo base_url().RES_DIR; ?>/css/style.css\">\n</head><body><div style=\"firstDiv\">\n</div>\n</body>\n</html>');
newwin.document.write('<TITLE>Print Page</TITLE>\n')
newwin.document.write('<script>\n')
newwin.document.write('function chkstate(){\n')
newwin.document.write('if(document.readyState=="complete"){\n')
newwin.document.write('window.close()\n')
newwin.document.write('}\n')
newwin.document.write('else{\n')
newwin.document.write('setTimeout("chkstate()",2000)\n')
newwin.document.write('}\n')
newwin.document.write('}\n')
newwin.document.write('function print_win(){\n')
newwin.document.write('window.print();\n')
newwin.document.write('chkstate();\n')
newwin.document.write('}\n')
newwin.document.write('<\/script>\n')
newwin.document.write('</HEAD>\n')
newwin.document.write('<BODY onload="print_win()">\n')
newwin.document.write(str)
newwin.document.write('</BODY>\n')
newwin.document.write('</HTML>\n')
newwin.document.close()
}
//-->
</script>
<?php echo $this->load->view('footer'); ?>
