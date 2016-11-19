<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head',array('title'=>lang('cms_news_page_title'))); ?>
    <script>
	$(document).ready(function(){
		$(".delete").click(function(e){
			e.preventDefault(); 
			var href = $(this).attr("href");
			var btn=this;
				
			if(confirm("Do you really want to delete this news?"))
			{
				$.ajax({
					type: "POST",
					url: href,
					success: function(response){
						if(response ==1 || response !=0 ){
							$(btn).parents('tr').fadeOut("slow");					
						}
						else
						{
							alert('Not Delete');						
						}
					}
				});
			
			}
			return false;
		});
	});
	</script>
</head>
<body>
<?php echo $this->load->view('header'); ?>
<ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><?=lang('menu_home')?></a></li>
    <li class="active"><?php echo lang('cms_news_page_title')?></li>
</ol>
<div class="row">   
    <div class="col-md-12">
        <?php if (isset($success)):?>
        <div class="alert alert-success"><strong><span class="glyphicon glyphicon-send"></span> <?php echo lang('contact_success_message')?> </strong></div>	  
        <?php endif;?>
        <?php if (isset($error)):?>
        <div class="alert alert-danger"><span class="glyphicon glyphicon-alert"></span><strong>  <?php echo lang('contact_error_message')?> </strong></div>
        <?php endif;?>
    </div>
    <div class="col-md-9"> 
    	<div class="well well-lg" style="overflow:hidden;">  
        <legend class="text-center"><?=lang('cms_news_page_title')?></legend>	       
            <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="cms/news/search_news" method="post">   
            <table class="table table-bordered">
              <tr class="warning">
                	<td><?=lang('cms_news_id')?></td>
                    <td><?=lang('cms_news_status')?></td>
                    <td><?=lang('action')?></td>
              </tr>
              <tr>
              		<td><input id="site_name" name="news_id" type="text" placeholder="<?=lang('cms_news_id')?>" value="<?php echo set_value('news_id');?>" class="form-control input-sm"></td>
                    <td>
                        <select name="enable" class="form-control col-md-1 input-sm" id="user_role">
                            <option value=""><?php echo lang('select_all'); ?></option>
                            <option value="0"><?php echo lang('cms_inactive') ?></option>
                            <option value="1"><?php echo lang('cms_active') ?></option>
                        </select>
                    </td>
                    <td><button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search"></i> <?=lang('action_search')?> </button></td>
              </tr>
            </table>      
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30"><?=lang('cms_news_sl')?></th>
                        <th><?=lang('cms_news_title')?></th>
                        <th><?=lang('cms_news_status')?></th>
                        <th><?=lang('cms_news_added')?></th>
                        <th><?=lang('cms_news_actions')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
				$language = ($this->session->userdata('site_lang')=='bangla')? 'bn':'en';
				//$this->session->userdata('site_lang');
				if (isset($news) && count($news)>0):
					$i=1;
					foreach ($news as $new):?>
					<tr>
                    	<td><?php echo $i;?></td>
                        <td><?php echo ($language=='bn')? ($new->news_title_bn==NULL || $new->news_title_bn=='')?$new->news_title_en:$new->news_title_bn : $new->news_title_en?></td>
                        <td><span class="label <?php echo ($new->enable==0)? 'label-warning':'label-info'?>">
							<?php echo ($new->enable==NULL || $new->enable==0)? lang('cms_inactive') :lang('cms_active')?>
                        	</span>    
                        </td>
                        <td><?php echo $new->create_user_id?></td>
                        <td>
                        	<?php if ( $this->authorization->is_permitted('cms_news_update') ):?>
                        	<a href="<?php echo base_url().'cms/news/save/'.$new->news_id;?>" class="btn btn-warning btn-sm"><?=lang('action_edit')?> </a> 
                            <?php endif ;
							if ( $this->authorization->is_permitted('cms_news_delete') ):
							?>
                        	<a href="<?php echo base_url().'cms/news/delete/'.$new->news_id;?>" id="delete" class="btn btn-danger btn-sm delete"> <?=lang('action_delete')?></a>
                            <?php endif;?>
                        </td>
                    </tr>	
                 <?php 
				 $i++;
				 endforeach; 
				 else:?>
				 <tr>
                    	<th colspan="5"><?=lang('cms_empty')?></th>
                 </tr>	
				 <?php
				 endif;
                    //end if
                ?> 
                </tbody>   
            </table>    
           <div style="text-align:left"><?php echo (isset($links))? $links: ""; ?></div>
        </div>
    </div> <!-- col-md-9-->
    
    <div class="col-md-3">
        <div class="well well-lg">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title"><?=lang('menu_quick_link')?></h3>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled">                
                    <li><a href="<?php echo base_url();?>cms/news/save"><?=lang('cms_news_add')?> </a></li>
                    <li><a href="<?php echo base_url();?>cms/news"> <?php echo lang('cms_news_page_title')?> </a></li>
                </ul>
              </div>
            </div>
        
        </div>
    </div>
</div>


<?php echo $this->load->view('footer'); ?>
