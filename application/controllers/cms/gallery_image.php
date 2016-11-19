<?php
class Gallery_image extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl','date'));
		$this->load->library(array('account/authentication', 'account/authorization', 'form_validation'));
		$this->load->model(array('account/account_model','general_model'));		
		
		date_default_timezone_set('Asia/Dhaka');  // set the time zone UTC+6
		
		$language = $this->session->userdata('site_lang');
		if(!$language)
		{
			$this->lang->load('general', $this->config->item("default_language"));
			$this->lang->load('menu', $this->config->item("default_language"));
			$this->lang->load('cms', $this->config->item("default_language"));
		}
		else
		{
			$this->lang->load('general', $language);
			$this->lang->load('menu', $language);
			$this->lang->load('cms', $language);
		}
		
	}

	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
	
		// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in())
		{
		  redirect('account/sign_in/?continue='.urlencode(base_url().'cms/gallery/save'));
		}
	
	
		// Retrieve sign in user
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
	
		$data['action'] = 'create';
		$data['galleries'] = $this->general_model->get_list_search_view('gallery', $search_fields=NULL,$select=NULL);
		
		$this->load->view('cms/gallery_image_save', $data);
	}
	function search_gallery()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in())
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'cms/gallery'));
		}
		// Check if they are allowed to Update Users
		if ( ! $this->authorization->is_permitted('cms_view_gallery'))
		{
			$this->session->set_flashdata('parmission', 'You have no permission to access gallery list');
		  	redirect(base_url().'dashboard');		  
		}
		
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
				
		$field_name=NULL; 
		$gallery_id=NULL;		
		$this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		$this->form_validation->set_rules(
		  array(
			array(
			  'field' => 'gallery',
			  'label' => 'lang:cms_select_gallery',
			  'rules' => 'trim|required'),
			array(
			  'field' => 'gallery',
			  'label' => 'lang:cms_select_gallery',
			  'rules' => 'trim|required'),
			array(
			  'field' => 'gallery',
			  'label' => 'lang:cms_select_gallery',
			  'rules' => 'trim|required')
		  ));
		// Search Fields
		$gallery_id = trim($this->input->post('gallery_id'));
		$enable = trim($this->input->post('enable'));
		$search_fields = NULL;
		if (isset($gallery_id) && $this->form_validation->run())
    	{
			$field_name=NULL; 
			$gallery_id=$gallery_id;
			$select = "`gallery_id`, `gallery_name_en`, `gallery_name_bn`, `create_user_id`, `create_date`, `enable` ";
			if($enable!="" && $gallery_id!="")
			{
				$search_fields = array('gallery_id'=>$gallery_id, 'enable'=>$enable);
			}
			if($enable=="" && $gallery_id!="")
			{
				$search_fields = array('gallery_id'=>$gallery_id);
			}
			if($enable!="" && $gallery_id=="")
			{
				$search_fields = array('enable'=>$enable);
			}
			$data['galleries'] = $this->general_model->get_list_search_view('gallery', $search_fields,$select);			
		}
		//print_r($search_fields);	
		$this->load->view('cms/gallery_list', $data);
	}
	
	
	// Search gallery
	
	
	/**
   * Add/Update gallery
   */
  function save($id=null)
  {
    // Keep track if this is a new user
    $is_new = empty($id);

    // Enable SSL?
    maintain_ssl($this->config->item("ssl_enabled"));

    // Redirect unauthenticated users to signin page
    if ( ! $this->authentication->is_signed_in())
    {
      redirect('account/sign_in/?continue='.urlencode(base_url().'cms/gallery/save'));
    }

    // Check if they are allowed to Update Users
    if ( ! $this->authorization->is_permitted('cms_gallery_update') && ! empty($id) )
    {
		$this->session->set_flashdata('parmission', 'You have no permission to update gallery');
      	redirect(base_url().'dashboard');
    }

    // Check if they are allowed to Create Users
    if ( ! $this->authorization->is_permitted('cms_add_gallery') && empty($id) )
    {
      $this->session->set_flashdata('parmission', 'You have no permission to add gallery');
      redirect(base_url().'dashboard');
    }

    // Retrieve sign in user
    $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));

    $data['action'] = 'create';

	$data['galleries'] = $this->general_model->get_list_search_view('gallery', $search_fields=NULL,$select=NULL);
    // Setup form validation
    $this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
    $this->form_validation->set_rules(
      array(
        array(
          'field' => 'image_caption_en',
          'label' => 'lang:image_caption_en',
          'rules' => 'trim|required|max_length[255]'),
        array(
          'field' => 'gallery', 
          'label' => 'lang:cms_select_gallery', 
          'rules' => 'trim|required')
      ));

    // Run form validation
    if ($this->form_validation->run())
    {
		// gallery Uploaded Photo
		$images_data = array();
		$filename = "";
		$config['upload_path'] = './resource/img/gallery/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '1024';
		$config['file_name']  = md5(time());
		//$config['max_height']  = '768';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload())
		{
			//[ THUMB IMAGE ]
			$config2 = array();
			$config2['image_library'] = 'gd2';
			$config2['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config2['new_image'] = './resource/img/gallery/';
			$config2['maintain_ratio'] = TRUE;
			$config2['create_thumb'] = TRUE;
			$config2['overwrite'] = TRUE;
			$config2['encrypt_name'] = TRUE;
			$config2['thumb_marker'] = '_thumb';
			$config2['height'] = 200;
			$config2['width'] = 260;
			
			$this->load->library('image_lib',$config2); 
			
			$this->image_lib->resize();
			$upload_data = $this->upload->data();
			$images_data = array(
				'image_file'=> $upload_data['file_name'],
				'image_thumb' => $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'],
			);
		}
		// Add gallery
        if( empty($id) ) {
			$now = gmt_to_local(now(), 'UP5', TRUE);
			$gallery_data = array(
					'image_caption_en' => $this->input->post('image_caption_en', TRUE), 
					'image_caption_bn' => $this->input->post('image_caption_bn', TRUE), 
					'enable' => $this->input->post('enable', TRUE),
					'gallery_id' => $this->input->post('gallery', TRUE),
					'create_user_id' => $data['account']->username,
					'create_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$gallery_data = array_merge($gallery_data,$images_data);
				
			}
			$site_id = $this->general_model->save_into_table_and_return_insert_id('gallery_image', $gallery_data);
			$data['success'] = lang('gallery_success_add');
			
			
        }
        // Update existing gallery image
        else 
        {
      		$now = gmt_to_local(now(), 'UP5', TRUE);
			$gallery_data = array(
					'image_caption_en' => $this->input->post('image_caption_en', TRUE), 
					'image_caption_bn' => $this->input->post('image_caption_bn', TRUE), 
					'enable' => $this->input->post('enable', TRUE),
					'gallery_id' => $this->input->post('gallery', TRUE),
					'update_user_id' => $data['account']->username,
					'update_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$gallery_data = array_merge($gallery_data,$images_data);				
			}
			$this->general_model->update_table('gallery_image', $gallery_data,'image_id',$id);
			$data['success'] = lang('gallery_success_update');
		}
	}
	// Get the account to update
    if( ! $is_new )
    {
      $data['update_gallery_details'] = $this->general_model->get_all_table_info_by_id('gallery_image', 'image_id', $id);
      $data['action'] = 'update';
    }
    $this->load->view('cms/gallery_image_save', $data);
  }
  
  function delete($id)
  {	
	// Enable SSL?
	maintain_ssl($this->config->item("ssl_enabled"));
	
	// Redirect unauthenticated users to signin page
	if ( ! $this->authentication->is_signed_in())
	{
	  redirect('account/sign_in/?continue='.urlencode(base_url().'cms/gallery'));
	}
	
	// Check if they are allowed to Update Users
	if ( ! $this->authorization->is_permitted('cms_gallery_delete') && ! empty($id) )
	{
		$this->session->set_flashdata('parmission', 'You have no permission to update gallery');
		redirect(base_url().'dashboard');
	}
	
	if($this->general_model->delete_from_table('gallery_image', 'image_id', $id))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
	//redirect('cms/gallery');
  }
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */