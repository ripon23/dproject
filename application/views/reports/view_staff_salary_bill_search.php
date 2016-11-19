<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
tr td{
padding:3px;	
}
</style>
</head>
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
    	<div class="print_button">
		<a onClick="printContent('firstDiv');" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> <?=lang('action_print')?>	</a>
    
    	<div id="firstDiv">

            <div style="font-size:14px; color:#000; font-weight:bold; text-align:center; width:100%"> সংস্থাপন কর্মচারীগণের বেতনের বিল </div>
            
            <table style="padding:2px; width:100%;  font-size:10px; padding:1px;" border="0px">
              <tr>
                <td>মাসের নামঃ </td>
                <td colspan="4" align="left"></td>
              </tr>
              <tr>
                <td>দপ্তরের নামঃ </td>
                <td colspan="4" align="left"></td>
              </tr>
              <tr>
                <td>কোড নং-</td>
                <td colspan="4" align="left"> 
                <div class="btn-group" aria-label="Third group" role="group">
				<button class="btn btn-default btn-sm" type="button">&nbsp;</button>
				</div>
                
                <div class="btn-group" aria-label="Third group" role="group">
				<button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
				</div>
                <div class="btn-group" aria-label="Third group" role="group">
				<button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
				</div>
                <div class="btn-group" aria-label="Third group" role="group">
				<button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
                <button class="btn btn-default btn-sm" type="button">&nbsp;</button>
				</div>
</td>
              </tr>
              <tr>
                <td colspan="2" align="left">টোকেন নং......................</td>
                <td align="left">তারিখ.........................</td>
                <td align="left">ভাউচার নং ......................</td>
                <td align="left">তারিখ........................</td>
              </tr>
            </table>
            <br>

            <table  style="padding:2px; width:100%; border:#999 solid 1px; font-size:10px; padding:2px;" border="1px">
              <tr>
                <td align="center"><h6>নির্দেশাবলী</h6></td>
                <td align="center"><h6>বিবরণ</h6></td>
                <td align="right"><h6>টাকা</h6></td>
                <td align="right"><h6>পঃ</h6></td>
              </tr>
              <tr>
                <td rowspan="46" align="left" valign="top" width="35%">
১. অবিলিকৃত/স্থগিত টাকা যথাযথ কলামে লাল কালিতে লিখিতে হইবে এবং যোগ দেয়ার সময় উহা বাদ রাখিতে হইবে ।</br></br>
২. বেতন বৃদ্ধির সার্টিফিকেট বা অনুপস্থিত কর্মীগণের তালিকায় স্থান পায় নাই এমন ঘটনা সমূহ যথা- মৃত্যু ,অবসর গ্রহন, স্থায়ী বদলী ও প্রথম নিয়োগ ‘মন্তব্য’ কলামে লিখিতে হইবে ।</br></br>
৩. কোন দাবিকৃ্ত বেতন বৃ্দ্ধি সরকারী কর্মচারীর দক্ষতার সীমা অতিক্রম করার আওতায় পড়িলে সংশ্লিষ্ট কর্মচারী উক্ত সীমা অতিক্রম করার উপযুক্ত এই মর্মে উপযুক্ত কতৃপক্ষের প্রত্যায়ন দ্বারা সমর্থিত হইতে হইবে । (এস,আর,১৫৬)</br></br>
৪. অধঃস্তন সরকারী কর্মচারী এবং এস,আর,১৫২-তে উল্লেখিত সরকারী কর্মচারীদের নাম বেতনের বিলে নাম বাদ দেওয়া যাইতে পারে ।</br></br>
৫. সেরেস্তার প্রত্যেক শাখার পর পাতায় আড়াআড়ি লাল কালিতে রেখা টানিতে হইবে এবং উহার নীচে বেতন ও ভাতার সমষ্টি বেতন ও ভাতার কলামে লাল কালিতে প্রদর্শন করিতে হইবে ।</br></br>
৬. স্থায়ী পদে নিযুক্ত ব্যাক্তিদের নাম স্থায়ী পদের বেতন গ্রহণের মাপ কাঠিতে জে্যষ্ঠত্বের ক্রম অনুসারে লিখিতে হইবে এবং খালি পদসমূহ স্থানাপন্ন লোকদিগকে দেখাইতে হইবে ।</br></br>
৭. বেতন বিলে কর্তন ও আদায়ের পৃথক পৃথক িসডিউল বেতন বিলে সংযুক্ত করিতে হইবে । </br>

                
                </td>
                <td align="left">* ৪৬০১ - সংস্থাপন কর্মচারীগণের বেতন</td>
                <td align="right"><?php
				$language = $this->session->userdata('site_lang');
				
                $main_salary=$salary_info->main_salary;
				$main_salary_poisa = $main_salary - floor($main_salary);
				
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($main_salary-$main_salary_poisa);
				else
				echo $main_salary-$main_salary_poisa;
				
			?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($main_salary_poisa,2)));
				else
				echo str_replace('0.','',round($main_salary_poisa,2))?></td>
              </tr>
              <tr>
                <td align="left">৪৭০১ - মহার্ঘ ভাতা</td>
                <td align="right">
				<?php
                $costly_allowance=$salary_info->costly_allowance;
				$costly_allowance_poisa = $costly_allowance - floor($costly_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($costly_allowance-$costly_allowance_poisa);
				else
				echo $costly_allowance-$costly_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($costly_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($costly_allowance_poisa,2))?></td>
              </tr>
              <tr>
                <td align="left">৪৭২৫ - ধোপা ভাতা</td>
                <td align="right">
				<?php
                $fuller_allowance=$salary_info->fuller_allowance;
				$fuller_allowance_poisa = $fuller_allowance - floor($fuller_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($fuller_allowance-$fuller_allowance_poisa);
				else
				echo $fuller_allowance-$fuller_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($fuller_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($fuller_allowance_poisa,2))?></td>
              </tr>
              <tr>
                <td align="left">৪৭২৬ - চুলকাটা ভাতা</td>
                <td align="right">
				<?php
                $barber_allowance=$salary_info->barber_allowance;
				$barber_allowance_poisa = $barber_allowance - floor($barber_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($barber_allowance-$barber_allowance_poisa);
				else
				echo $barber_allowance-$barber_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($barber_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($barber_allowance_poisa,2))?></td>
              </tr>
              <tr>
                <td align="left">৪৭৪৯ - রেশন ভাতা</td>
                <td align="right">
				<?php
                $ration_allowance=$salary_info->ration_allowance;
				$ration_allowance_poisa = $ration_allowance - floor($ration_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($ration_allowance-$ration_allowance_poisa);
				else
				echo $ration_allowance-$ration_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($ration_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($ration_allowance_poisa,2))?></td>
              </tr>
              
              <tr>
                <td align="left">৪৭০৫ - বাড়ি ভাড়া ভাতা</td>
                <td align="right">
				<?php
                $house_rent=$salary_info->house_rent;
				$house_rent_poisa = $house_rent - floor($house_rent);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($house_rent-$house_rent_poisa);
				else
				echo $house_rent-$house_rent_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($house_rent_poisa,2)));
				else
				echo str_replace('0.','',round($house_rent_poisa,2))?></td>
              </tr>
              
              <tr>
                <td align="left">৪৭১৭ - চিকিত্সা ভাতা</td>
                <td align="right">
				<?php
                $treatment_allowance=$salary_info->treatment_allowance;
				$treatment_allowance_poisa = $treatment_allowance - floor($treatment_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($treatment_allowance-$treatment_allowance_poisa);
				else
				echo $treatment_allowance-$treatment_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($treatment_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($treatment_allowance_poisa,2))?></td>
              </tr>
              
              <tr>
                <td align="left">৪৭৫৫ - টিফিন ভাতা</td>
                <td align="right">
				<?php
                $tiffin_allowance=$salary_info->tiffin_allowance;
				$tiffin_allowance_poisa = $tiffin_allowance - floor($tiffin_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($tiffin_allowance-$tiffin_allowance_poisa);
				else
				echo $tiffin_allowance-$tiffin_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($tiffin_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($tiffin_allowance_poisa,2))?></td>
              </tr>
              
              <tr>
                <td align="left">৪৭৭৩ - শিক্ষা সহায়ক ভাতা</td>
                <td align="right">
				<?php
                $education_help_allowance=$salary_info->education_help_allowance;
				$education_help_allowance_poisa = $education_help_allowance - floor($education_help_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($education_help_allowance-$education_help_allowance_poisa);
				else
				echo $education_help_allowance-$education_help_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($education_help_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($education_help_allowance_poisa,2))?></td>
              </tr>
              
              <tr>
                <td align="left">৪৭৯৫ - অন্যান্য ভাতা</td>
                <td align="right">
				<?php
                $others_allowance=($salary_info->mountains_allowance+$salary_info->border_allowance);
				$others_allowance_poisa= $others_allowance - floor($others_allowance);
				if($language=='bangla')
				echo $this->general_model->en2bnNumber($others_allowance-$others_allowance_poisa);
				else
				echo $others_allowance-$others_allowance_poisa;
				?></td>
                <td align="right"><?php 
				if($language=='bangla')
				echo $this->general_model->en2bnNumber(str_replace('0.','',round($others_allowance_poisa,2)));
				else
				echo str_replace('0.','',round($others_allowance_poisa,2))?></td>
              </tr>
              <tr>
                <td align="left">মোট দাবী (ক)</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">কর্তন ও আদায়</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ৬-০৯৩৭-০০০০-৮১০১ সাধারন ভবিষ্যৎ তহবিল</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              
              <tr>
                <td align="left">** ৬-০৯৩৭-০০০০-৮১০১ সাধারন ভবিষ্যৎ তহবিলের অগ্রিম ও সুদ পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ৬-০৭৭১-০০০১-৮২৪১ সরকারি কর্মচারীগণের কল্যাণ তহবিল</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ৬-০৭৭১-০০০০-৮২৪৬ সরকারি কর্মচারীগণের গোষ্টি বীমা</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ৬-৫৪৩১-০০০০-৮০৪১ ডাক জীবন বীমা কিস্তি</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              
              <tr>
                <td align="left">** ১-৩২৩৭-০০০১-২১১১ বাড়ি ভাড়া</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-৩২৩৭-০০০১-২১২১ গ্যাস</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-৩২৩৭-০০০১-২১২৩ পানি ও পয়ঃপ্রণালী</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-০৯৬৫-০০০১-৩৯০১ গৃহ নির্মাণ অগ্রিমের কিস্তি পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">সুদ</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-০৯৬৫-০০০১-৩৯১১ মোটর গাড়ীর অগ্রিমের কিস্তি পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-০৯৬৫-০০০১-৩৯২১ মোটর সাইকেলের অগ্রিমের কিস্তি পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-০৯৬৫-০০০১-৩৯৩১ বাইসাইকেলের অগ্রিমের কিস্তি পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">** ১-০৯৬৫-০০০১-১৬৩১ কর্মচারীদেরকে প্রদত্ত ঋণের সুদ পরিশোধ</td>
                <td>&nbsp;
				<?php
                
				?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">মোট কর্তন ও আদায় (খ)</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">নীট দাবী (ক-খ)</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">প্রদানের জন্য নীট টাকার প্রয়োজন</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
<div class="pull-left" style="text-align:left; font-size:9px; padding:2px;">            
* কেবল মাত্র অর্থনৈতিক কোড বোঝায়<br>
** সংস্পর্শ ১৩ অংকের কোড দেওয়া হইয়াছে।</div>

        </div> <!-- END firstDiv -->
        
	</div>
    
    
    
    
    </div> <!-- col-md-12-->
    
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
