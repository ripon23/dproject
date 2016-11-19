<?php
class News extends CI_Controller {

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
			redirect('account/sign_in/?continue='.urlencode(base_url().'cms/news'));
		}
		// Check if they are allowed to Update Users
		if ( ! $this->authorization->is_permitted('cms_view_news'))
		{
			$this->session->set_flashdata('parmission', 'You have no permission to access news list');
		  	redirect(base_url().'dashboard');		  
		}
		
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		
		// Paginations
		$this->load->library('pagination');	
		$config = array();
		$config['base_url'] = base_url().'cms/news/index/';
		$config['total_rows'] = $this->general_model->number_of_total_rows_in_a_table('eh_news');
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
		
		$select = "`news_id`, `news_title_en`, `news_title_bn`, `news_details_en`, `news_details_bn`, `news_publish_date`, `news_image`, `create_user_id`, `enable`";
		$data['news'] = $this->general_model->get_list_view('eh_news', $field_name=NULL, $news_id=NULL, $select, 'news_id', 'desc', $page, $config['per_page']);
		
		$data["links"] = $this->pagination->create_links();
		$this->load->view('cms/news_list', $data);
	}
	function search_news()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in())
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'cms/news'));
		}
		// Check if they are allowed to Update Users
		if ( ! $this->authorization->is_permitted('cms_view_news'))
		{
			$this->session->set_flashdata('parmission', 'You have no permission to access news list');
		  	redirect(base_url().'dashboard');		  
		}
		
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
				
		$field_name=NULL; 
		$news_id=NULL;		
		$this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		$this->form_validation->set_rules(
		  array(
			array(
			  'field' => 'news_id',
			  'label' => 'lang:cms_news_id',
			  'rules' => 'trim')
		  ));
		// Search Fields
		$news_id = trim($this->input->post('news_id'));
		$enable = trim($this->input->post('enable'));
		$search_fields = NULL;
		if (isset($news_id) && $this->form_validation->run())
    	{
			$field_name=NULL; 
			$news_id=$news_id;
			$select = "`news_id`, `news_title_en`, `news_title_bn`, `news_details_en`, `news_details_bn`, `news_publish_date`, `news_image`, `create_user_id`, `enable`";
			if($enable!="" && $news_id!="")
			{
				$search_fields = array('news_id'=>$news_id, 'enable'=>$enable);
			}
			if($enable=="" && $news_id!="")
			{
				$search_fields = array('news_id'=>$news_id);
			}
			if($enable!="" && $news_id=="")
			{
				$search_fields = array('enable'=>$enable);
			}
			$data['news'] = $this->general_model->get_list_search_view('eh_news', $search_fields,$select);			
		}
		//print_r($search_fields);	
		$this->load->view('cms/news_list', $data);
	}
	
	
	// Search News
	
	
	/**
   * Add/Update News
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
      redirect('account/sign_in/?continue='.urlencode(base_url().'cms/news/save'));
    }

    // Check if they are allowed to Update Users
    if ( ! $this->authorization->is_permitted('cms_news_update') && ! empty($id) )
    {
		$this->session->set_flashdata('parmission', 'You have no permission to update news');
      	redirect(base_url().'dashboard');
    }

    // Check if they are allowed to Create Users
    if ( ! $this->authorization->is_permitted('cms_add_news') && empty($id) )
    {
      $this->session->set_flashdata('parmission', 'You have no permission to add news');
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
          'field' => 'news_title_en',
          'label' => 'lang:news_title_en',
          'rules' => 'trim|required|max_length[255]'),
        array(
          'field' => 'news_title_bn', 
          'label' => 'lang:news_title_bn', 
          'rules' => 'trim|max_length[255]'), 
        array(
          'field' => 'news_details_en', 
          'label' => 'lang:news_details_en', 
          'rules' => 'required'), 
        array(
          'field' => 'news_details_bn', 
          'label' => 'lang:news_details_bn', 
          'rules' => '')
      ));

    // Run form validation
    if ($this->form_validation->run())
    {
		// News Uploaded Photo
		$images_data = array();
		$filename = "";
		$config['upload_path'] = './resource/img/news/';
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
			$config2['new_image'] = './resource/img/news/';
			$config2['maintain_ratio'] = TRUE;
			$config2['create_thumb'] = TRUE;
			$config2['overwrite'] = TRUE;
			$config2['encrypt_name'] = TRUE;
			$config2['thumb_marker'] = '_thumb';
			$config2['height'] = 130;
			$config2['width'] = 100;
			
			$this->load->library('image_lib',$config2); 
			
			$this->image_lib->resize();
			$upload_data = $this->upload->data();
			$images_data = array(
				'news_image'=> $upload_data['file_name'],
				'thumbnail' => $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'],
			);
		}
		// Add News
        if( empty($id) ) {
			$now = gmt_to_local(now(), 'UP5', TRUE);
			$news_data = array(
					'news_title_en' => $this->input->post('news_title_en', TRUE), 
					'news_title_bn' => $this->input->post('news_title_bn', TRUE), 
					'news_details_en' => $this->input->post('news_details_en'), 
					'news_details_bn' => $this->input->post('news_details_bn'),
					'enable' => $this->input->post('enable', TRUE),
					'create_user_id' => $data['account']->username,
					'create_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$news_data = array_merge($news_data,$images_data);
				
			}
			$site_id = $this->general_model->save_into_table_and_return_insert_id('eh_news', $news_data);
			$data['success'] = lang('news_success_add');
			
        }
        // Update existing News
        else 
        {
      		$now = gmt_to_local(now(), 'UP5', TRUE);
			$news_data = array(
					'news_title_en' => $this->input->post('news_title_en', TRUE), 
					'news_title_bn' => $this->input->post('news_title_bn', TRUE), 
					'news_details_en' => $this->input->post('news_details_en'), 
					'news_details_bn' => $this->input->post('news_details_bn'),
					'enable' => $this->input->post('enable', TRUE),
					'update_user_id' => $data['account']->username,
					'update_date' => mdate('%Y-%m-%d %H:%i:%s', $now)					
				);
			if(count($images_data)>0)
			{
				$news_data = array_merge($news_data,$images_data);				
			}
			/*echo "<code>"; print_r($news_data);echo "</code>"; 
			exit;*/
			$this->general_model->update_table('eh_news', $news_data,'news_id',$id);
			$data['success'] = lang('news_success_update');
		}
	}
	// Get the account to update
    if( ! $is_new )
    {
      $data['update_news_details'] = $this->general_model->get_all_table_info_by_id('eh_news', 'news_id', $id);
      $data['action'] = 'update';
    }	
    // Load manage users view
    $this->load->view('cms/news_save', $data);
  }
  
  function delete($id)
  {	
	// Enable SSL?
	maintain_ssl($this->config->item("ssl_enabled"));
	
	// Redirect unauthenticated users to signin page
	if ( ! $this->authentication->is_signed_in())
	{
	  redirect('account/sign_in/?continue='.urlencode(base_url().'cms/news'));
	}
	
	// Check if they are allowed to Update Users
	if ( ! $this->authorization->is_permitted('cms_news_delete') && ! empty($id) )
	{
		$this->session->set_flashdata('parmission', 'You have no permission to update news');
		redirect(base_url().'dashboard');
	}
	
	if($this->general_model->delete_from_table('eh_news', 'news_id', $id))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
	//redirect('cms/news');
  }
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */