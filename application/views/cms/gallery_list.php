<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head',array('title'=>lang('cms_gallery_page_title'))); ?>
    <script>
	$(document).ready(function(){
		$(".delete").click(function(e){
			e.preventDefault(); 
			var href = $(this).attr("href");
			var btn=this;
				
			if(confirm("Do you really want to delete this gallery?"))
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
    <li class="active"><?php echo lang('cms_gallery_page_title')?></li>
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
        <legend class="text-center"><?=lang('cms_gallery_page_title')?> </legend>          
            <form class="form-horizontal" role="form" id="create-site-form"  name="create-site-form" action="cms/gallery/search_gallery" method="post">   
            <table class="table table-bordered">
              <tr class="warning">
                	<td><?=lang('cms_gallery_id')?></td>
                    <td><?=lang('cms_news_status')?></td>
                    <td><?=lang('action')?></td>
              </tr>
              <tr>
              		<td><input id="site_name" name="gallery_id" type="text" placeholder="<?=lang('cms_gallery_id')?>" value="<?php echo set_value('gallery_id');?>" class="form-control input-sm"></td>
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
                        <th><?=lang('cms_gallery_title_name')?></th>
                        <th><?=lang('cms_news_status')?></th>
                        <th><?=lang('cms_news_added')?></th>
                        <th><?=lang('cms_news_actions')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
				$language = ($this->session->userdata('site_lang')=='bangla')? 'bn':'en';
				//$this->session->userdata('site_lang');
				if (isset($galleries) && count($galleries)>0):
					$i=1;
					foreach ($galleries as $gallery):?>
					<tr>
                    	<td><?php echo $i;?></td>
                        <td><a href="<?php echo base_url().'cms/gallery/images/'.$gallery->gallery_id;?>"><?php echo ($language=='bn')? ($gallery->gallery_name_bn==NULL || $gallery->gallery_name_bn=='')?$gallery->gallery_name_en:					$gallery->gallery_name_bn : $gallery->gallery_name_en?></a></td>
                        <td><span class="label <?php echo ($gallery->enable==0)? 'label-warning':'label-primary'?>">
							<?php echo ($gallery->enable==NULL || $gallery->enable==0)? lang('cms_inactive') :lang('cms_active')?>
                        	</span>    
                        </td>
                        <td><?php echo $gallery->create_user_id?></td>
                        <td>
                        	<?php if ( $this->authorization->is_permitted('cms_gallery_update') ):?>
                        	<a href="<?php echo base_url().'cms/gallery/save/'.$gallery->gallery_id;?>" class="btn btn-info btn-sm"><?=lang('action_edit')?> </a> 
                            <?php endif ;
							if ( $this->authorization->is_permitted('cms_gallery_delete') ):
							?>
                        	<a href="<?php echo base_url().'cms/gallery/delete/'.$gallery->gallery_id;?>" id="delete" class="btn btn-danger btn-sm delete"> <?=lang('action_delete')?></a>
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
                    <li><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/gallery"><?php echo lang('menu_gallery_list')?> </a></li>
            <li><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <a href="<?php echo base_url();?>cms/gallery/save"> <?php echo lang('menu_gallery_add')?> </a></li>
                </ul>
              </div>
            </div>
        
        </div>
    </div>
</div>


<?php echo $this->load->view('footer'); ?>
