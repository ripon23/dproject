<?php
class Gallery extends CI_Controller {

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
			redirect('account/sign_in/?continue='.urlencode(base_url().'cms/gallery'));
		}
		// Check if they are allowed to Update Users
		if ( ! $this->authorization->is_permitted('cms_view_gallery'))
		{
			$this->session->set_flashdata('parmission', 'You have no permission to access gallery list');
		  	redirect(base_url().'dashboard');		  
		}
		
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		
		// Paginations
		$this->load->library('pagination');	
		$config = array();
		$config['base_url'] = base_url().'cms/gallery/index/';
		$config['total_rows'] = $this->general_model->number_of_total_rows_in_a_table('gallery');
		$config['num_links'] = 3;
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		
		$config['full_tag_open'] = '<nav><ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul></nav><!--pagination-->';
		
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		
		$select = "`gallery_id`, `gallery_name_en`, `gallery_name_bn`, `create_user_id`, `create_date`, `enable` ";
		$data['galleries'] = $this->general_model->get_list_view('gallery', $field_name=NULL, $gallery_id=NULL, $select, 'gallery_id', 'desc', $page, $config['per_page']);
		
		$data["links"] = $this->pagination->create_links();
		$this->load->view('cms/gallery_list', $data);
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
			  'field' => 'gallery_id',
			  'label' => 'lang:cms_gallery_id',
			  'rules' => 'trim')
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


    // Setup form validation
    $this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
    $this->form_validation->set_rules(
      array(
        array(
          'field' => 'gallery_name_en',
          'label' => 'lang:gallery_title_en',
          'rules' => 'trim|required|max_length[255]'),
        array(
          'field' => 'gallery_name_bn', 
          'label' => 'lang:gallery_title_bn', 
          'rules' => 'trim|max_length[255]')
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
				'gallery_image'=> $upload_data['file_name'],
				'thumbnail' => $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'],
			);
		}
		// Add gallery
        if( empty($id) ) {
			$now = gmt_to_local(now(), 'UP5', TRUE);
			$gallery_data = array(
					'gallery_name_en' => $this->input->post('gallery_name_en', TRUE), 
					'gallery_name_bn' => $this->input->post('gallery_name_bn', TRUE), 
					'enable' => $this->input->post('enable', TRUE),
					'create_user_id' => $data['account']->username,
					'create_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$gallery_data = array_merge($gallery_data,$images_data);
				
			}
			$site_id = $this->general_model->save_into_table_and_return_insert_id('gallery', $gallery_data);
			$data['success'] = lang('gallery_success_add');
			
        }
        // Update existing gallery
        else 
        {
      		$now = gmt_to_local(now(), 'UP5', TRUE);
			$gallery_data = array(
					'gallery_name_en' => $this->input->post('gallery_name_en', TRUE), 
					'gallery_name_bn' => $this->input->post('gallery_name_bn', TRUE), 
					'enable' => $this->input->post('enable', TRUE),
					'update_user_id' => $data['account']->username,
					'update_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$gallery_data = array_merge($gallery_data,$images_data);				
			}
			$this->general_model->update_table('gallery', $gallery_data,'gallery_id',$id);
			$data['success'] = lang('gallery_success_update');
		}
	}
	// Get the account to update
    if( ! $is_new )
    {
      $data['update_gallery_details'] = $this->general_model->get_all_table_info_by_id('gallery', 'gallery_id', $id);
      $data['action'] = 'update';
    }
    $this->load->view('cms/gallery_save', $data);
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
	
	if($this->general_model->delete_from_table('gallery', 'gallery_id', $id))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
	//redirect('cms/gallery');
  }
  // Gallery Image list
  function images($gallery_id)
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
				
		$select = "`image_id`, `image_caption_en`, `image_caption_bn`, `image_thumb`, `create_user_id`, `create_date`, `enable`, `gallery_id`";
		$data['gallery_images'] = $this->general_model->get_list_view('gallery_image', $field_name='gallery_id', $gallery_id, $select, 'image_id', 'asc', $page=NULL,NULL);
				
		$this->load->view('cms/gallery_image_list', $data);	  
  }
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */