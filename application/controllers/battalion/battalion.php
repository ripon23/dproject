<?php
class Battalion extends CI_Controller {
	
	var $keylen= 16;// recommended lengths 8,10,12,14,16,20
	var $basechar='23456789ABCDEFGHJKLMNPQRSTUVWXYZ';//32 symbols
	var $formatstr= '4444'; //characters in each segment, max 5 segments
	var $isvalid="YES"; //returns this value for valid keys
	var $invalid="NO"; //returns this value for invalid keys
	var $software=""; //name of software for which key is to be generated
	
	
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl','date'));
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model','general_model','project_site/site_model','project_site/ref_location_model'));
		
		
		date_default_timezone_set('Asia/Dhaka');  // set the time zone UTC+6
		
		$language = $this->session->userdata('site_lang');
		if(!$language)
		{
		$this->lang->load('general', 'english');
		$this->lang->load('menu', 'english');
		$this->lang->load('site', 'english');
		$this->lang->load('formlabel', 'english');
		}
		else
		{
		$this->lang->load('general', $language);
		$this->lang->load('menu', $language);
		$this->lang->load('site', $language);
		$this->lang->load('formlabel', $language);
		}
		
	}

	function index()
	{
		maintain_ssl();

		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		}

		$this->load->view('home', isset($data) ? $data : NULL);
	}
	
	
	public function create_battalion()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_battalion_licence'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('battalion_name', 'battalion name', 'required');
				$this->form_validation->set_rules('battalion_name_bn', 'battalion name bangla', 'required');
				$this->form_validation->set_rules('battalion_division', 'Division', 'required');
				$this->form_validation->set_rules('battalion_district', 'District', 'required');
				$this->form_validation->set_rules('battalion_license_key', 'battalion license key', 'required');				
				$this->form_validation->set_rules('battalion_address', 'battalion address');
				$this->form_validation->set_rules('battalion_latitude', 'battalion latitude');
				$this->form_validation->set_rules('battalion_longitude', 'battalion longitude');
				$this->form_validation->set_rules('region', 'Region', 'required');
				$this->form_validation->set_rules('sector', 'Sector', 'required');

				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_create')." ".lang('menu_project_site');
				$division_query="SELECT DISTINCT
				location_bbs2011.division,
       location_bbs2011.*,       
       location_bbs2011.loc_type
  FROM location_bbs2011 location_bbs2011
 WHERE (location_bbs2011.loc_type = 'DV') ORDER BY location_bbs2011.loc_name_en ASC";
				$data['all_division'] = $this->general_model->get_all_querystring_result($division_query);
				$data['region_info'] =$this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', 1, 'region_name', 'ASC');
				
				$this->load->view('battalion/view_create_battalion.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_create')." ".lang('menu_battalion');
				
				
				$district_info=$this->ref_location_model->get_district_name_from_id($this->input->post('battalion_district'));
				//echo $district_info;
				//$newkey= $this->codeGenerate($district_info);				
				//echo $newkey;
				
				$validate= $this->codeValidate($this->input->post('battalion_license_key'),$district_info);

			
				if($validate=='YES')
				{
					if(!$this->general_model->is_exist_in_a_table('battalion_and_licence','battalion_district',$this->input->post('battalion_district')))
					{
					
					
					$battalion_and_licence_data=array(
							'battalion_name'=>$this->input->post('battalion_name'),
							'battalion_name_bn'=>$this->input->post('battalion_name_bn'),
							'battalion_address'=>$this->input->post('battalion_address'),
							'region_id'=>$this->input->post('region'),
							'sector_id'=>$this->input->post('sector'),
							'battalion_latitude'=>$this->input->post('battalion_latitude'),
							'battalion_longitude'=>$this->input->post('battalion_longitude'),
							'battalion_division'=>$this->input->post('battalion_division'),
							'battalion_district'=>$this->input->post('battalion_district'),
							'battalion_upazila'=>$this->input->post('battalion_upazila'),
							'battalion_union'=>$this->input->post('battalion_union'),
							'licence_key'=>$this->input->post('battalion_license_key'),
							'create_user_id'=>$data['account']->id,
							'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
					
					$success_or_fail=$this->general_model->save_into_table('battalion_and_licence', $battalion_and_licence_data);
					
					if($success_or_fail)
						$data['success_msg']=lang('saveed_successfully');
					else
						$data['error_msg']=lang('save_unsuccessfull');
					}
					else
					{
						$data['error_msg']='battalion already exist';
					}
				}
				else
				{
					$data['error_msg']='Wrong license key';
				}
				
				$division_query="SELECT DISTINCT
				location_bbs2011.division,
       location_bbs2011.*,       
       location_bbs2011.loc_type
  FROM location_bbs2011 location_bbs2011
 WHERE (location_bbs2011.loc_type = 'DV') ORDER BY location_bbs2011.loc_name_en ASC";
				$data['all_division'] = $this->general_model->get_all_querystring_result($division_query);
				$data['region_info'] =$this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', 1, 'region_name', 'ASC');
				$this->load->view('battalion/view_create_battalion.php', isset($data) ? $data : NULL);				
				}
				
				
				
			}
			else
			{
			redirect('./dashboard');  // if not permitted "create_project_site" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	
	}
	
	
	public function edit_single_battalion($battalion_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_battalion_licence'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('battalion_name', 'battalion name', 'required');
				$this->form_validation->set_rules('battalion_name_bn', 'battalion name bangla', 'required');
				$this->form_validation->set_rules('battalion_division', 'Division', 'required');
				$this->form_validation->set_rules('battalion_district', 'District', 'required');			
				$this->form_validation->set_rules('battalion_address', 'battalion address');
				$this->form_validation->set_rules('battalion_latitude', 'battalion latitude');
				$this->form_validation->set_rules('battalion_longitude', 'battalion longitude');
				$this->form_validation->set_rules('region', 'Region', 'required');
				$this->form_validation->set_rules('sector', 'Sector', 'required');

				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_create')." ".lang('menu_project_site');
				$division_query="SELECT DISTINCT
				location_bbs2011.division,
       location_bbs2011.*,       
       location_bbs2011.loc_type
  FROM location_bbs2011 location_bbs2011
 WHERE (location_bbs2011.loc_type = 'DV') ORDER BY location_bbs2011.loc_name_en ASC";
				$data['all_division'] = $this->general_model->get_all_querystring_result($division_query);
				$data['battalion_info']= $this->general_model->get_all_table_info_by_id('battalion_and_licence', 'battalion_id', $battalion_id);
				$data['region_info'] =$this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', 1, 'region_name', 'ASC');
				$this->load->view('battalion/edit_single_battalion.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_create')." ".lang('menu_battalion');
				
					
					$battalion_and_licence_data=array(
							'battalion_name'=>$this->input->post('battalion_name'),
							'battalion_name_bn'=>$this->input->post('battalion_name_bn'),
							'battalion_address'=>$this->input->post('battalion_address'),
							'region_id'=>$this->input->post('region'),
							'sector_id'=>$this->input->post('sector'),
							'battalion_latitude'=>$this->input->post('battalion_latitude'),
							'battalion_longitude'=>$this->input->post('battalion_longitude'),
							'battalion_division'=>$this->input->post('battalion_division'),
							'battalion_district'=>$this->input->post('battalion_district'),
							'battalion_upazila'=>$this->input->post('battalion_upazila'),
							'battalion_union'=>$this->input->post('battalion_union'),
							'update_user_id'=>$data['account']->id,
							'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
							
					$success_or_fail=$this->general_model->update_table('battalion_and_licence', $battalion_and_licence_data,'battalion_id', $battalion_id);
					
					if($success_or_fail)
						$data['success_msg']=lang('saveed_successfully');
					else
						$data['error_msg']=lang('save_unsuccessfull');
					
				
				$division_query="SELECT DISTINCT
				location_bbs2011.division,
       location_bbs2011.*,       
       location_bbs2011.loc_type
  FROM location_bbs2011 location_bbs2011
 WHERE (location_bbs2011.loc_type = 'DV') ORDER BY location_bbs2011.loc_name_en ASC";
				$data['all_division'] = $this->general_model->get_all_querystring_result($division_query);
				$data['battalion_info']= $this->general_model->get_all_table_info_by_id('battalion_and_licence', 'battalion_id', $battalion_id);
				$data['region_info'] =$this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', 1, 'region_name', 'ASC');
				$this->load->view('battalion/edit_single_battalion.php', isset($data) ? $data : NULL);				
				}
				
				
				
			}
			else
			{
			redirect('./dashboard');  // if not permitted "create_project_site" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}
	
	
	public function battalion_list()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_battalion_licence'))
			{
			
			$this->load->helper("url");	
			$data['title'] = lang('action_view')." ".lang('menu_battalion');	
			
			//$data['all_registration'] = $this->registration_model->get_all_registration();	
			$this->load->library('pagination');
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "battalion/battalion/battalion_list/";
			$config["total_rows"] = $this->general_model->number_of_total_rows_in_a_table('battalion_and_licence');
			$config["per_page"] = $this->config->item("pagination_perpage");
			$config['num_links'] = 3;
			
			$config["uri_segment"] = 4;
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
			
			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';
			
			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
			
			//$config['anchor_class'] = 'follow_link';
			
			//$choice = $config['total_rows']/$config['per_page'];
			//$config['num_links'] = round($choice);
			
			$this->pagination->initialize($config);
			
			$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;		
			$data['all_battalion'] = $this->general_model->get_all_result_by_limit('battalion_and_licence','battalion_name','asc',$config["per_page"], $page);	
			
			$data['all_district']=$this->ref_location_model->get_all_district_info();
			
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$this->load->view('battalion/view_battalion_list.php', isset($data) ? $data : NULL);				
				
			}
			else
			{
			redirect('./dashboard');  // if not permitted "create_project_site" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
		
	}
	
	
	public function search_battalion_list()
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('manage_battalion_licence'))
			{
				
				// assign posted valued
				$data['battalion_name']    		= $this->input->post('battalion_name');
				$data['battalion_district']     = $this->input->post('battalion_district');
				$data['battalion_status']     	= $this->input->post('battalion_status');
						
				
				if($this->input->post("search_submit"))
				{
				$query_string="SELECT * FROM   battalion_and_licence";	
		
				$query_string=$query_string." WHERE ( battalion_and_licence.battalion_id > 0)";
			
				if($this->input->post("battalion_name"))	
				{
					$battalion_name=$this->input->post("battalion_name"); 
					$query_string=$query_string." AND (battalion_and_licence.battalion_name Like '%$battalion_name%')";
				}
				
				if($this->input->post("battalion_district"))	
				{
					$battalion_district=$this->input->post("battalion_district");	
					$query_string=$query_string." AND(battalion_and_licence.battalion_district = $battalion_district)";
				}
	
				
				if($this->input->post("battalion_status"))	
				{
					if($this->input->post("battalion_status")==1)
						$battalion_status=1;
					else
						$battalion_status=0;
					
					$query_string=$query_string." AND(battalion_and_licence.battalion_status = $battalion_status)";
				}
				
			
				$query_string=$query_string." ORDER BY battalion_and_licence.battalion_name ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
				
				//echo $searchterm;
				
				$data['title'] = lang('action_view')." ".lang('menu_battalion');	
				$this->load->helper("url");
				$this->load->library('pagination');
				//pagination
				$config = array();
				$config["base_url"] = base_url() . "battalion/battalion/search_battalion_list/";
				$config["total_rows"] = $this->general_model->total_count_query_string($searchterm);
				$config["per_page"] = $this->config->item("pagination_perpage");
				$config['num_links'] = 3;
				
				$config["uri_segment"] = 4;
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
				
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				
				$config['num_tag_open'] = '<li class="page">';
				$config['num_tag_close'] = '</li>';				
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;		
				$data['all_battalion'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);	
				$data['all_district']=$this->ref_location_model->get_all_district_info();
				$data["links"] = $this->pagination->create_links();
				$data["page"]=$page;
				
				$this->load->view('battalion/view_battalion_list.php', isset($data) ? $data : NULL);	
				
			
			
			}
			else
			{
			redirect('');  // if not permitted "view_registration" redirect to home page
			}	
		
		
		}
		else
		{
			redirect('account/sign_in');
		}
		
	}
	
	
	
	
	
	
	public function user_battalion_mgt()
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('battalion_user_access_management'))
			{
				
				$data['title'] = lang('menu_user_battalion_access_management');		
				
				$data['roles'] = $this->site_model->get_all_role();
				$data['all_region'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', '1', 'region_name', 'ASC');
				$data['all_sector'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'sector_status', '1', 'sector_name', 'ASC');
				//$data['all_user'] = $this->site_model->get_all_user();
				
				$this->load->helper("url");
				$this->load->library('pagination');
				//pagination
				$config = array();
				$config["base_url"] = base_url() . "battalion/battalion/user_battalion_mgt/";
				$config["total_rows"] = $this->general_model->number_of_total_rows_in_a_table('a3m_account');
				$config["per_page"] = $this->config->item("pagination_perpage");
				$config['num_links'] = 3;
				
				$config["uri_segment"] = 4;
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
				
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				
				$config['num_tag_open'] = '<li class="page">';
				$config['num_tag_close'] = '</li>';				
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;		
				$data['all_user'] = $this->general_model->get_all_result_by_limit('a3m_account','id','asc',$config["per_page"], $page);			
				$data["links"] = $this->pagination->create_links();
				$data["page"]=$page;
				
				$this->load->view('battalion/view_user_battalion_access_list', isset($data) ? $data : NULL);						
			
			}
			else
			{
			redirect('./dashboard');  // if not permitted "edit_project_site" redirect to home page
			}			
		
		}
		else
		{
			redirect('account/sign_in');
		}
	}
	
	
	public function user_battalion_mgt_search()
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('battalion_user_access_management'))
			{
				
				// assign posted valued
				$data['user_name']    		= $this->input->post('user_name');
				$data['user_role']     		= $this->input->post('user_role');
				$data['region_id']     		= $this->input->post('region_id');
				$data['sector_id']     		= $this->input->post('sector_id');
						
				
				if($this->input->post("search_submit"))
				{
				$query_string="SELECT DISTINCT a3m_account.id,
								a3m_account.username							  
						  FROM    (   a3m_rel_account_role a3m_rel_account_role
								   LEFT OUTER JOIN
									   bgb_user_battalion_map  bgb_user_battalion_map
								   ON (a3m_rel_account_role.account_id =  bgb_user_battalion_map.account_id))
							   RIGHT OUTER JOIN
								  a3m_account a3m_account
							   ON (a3m_account.id = a3m_rel_account_role.account_id)";	
		
				$query_string=$query_string." WHERE (a3m_account.id > 0)";
			
				if($this->input->post("user_name"))	
				{
					$user_name=$this->input->post("user_name"); 
					$query_string=$query_string." AND (a3m_account.username Like '%$user_name%')";
				}
				
				if($this->input->post("user_role"))	
				{
					$user_role=$this->input->post("user_role");	
					$query_string=$query_string." AND(a3m_rel_account_role.role_id = $user_role)";
				}
				
				if($this->input->post("region_id"))	
				{
					$region_id=$this->input->post("region_id");	
					$query_string=$query_string." AND( bgb_user_battalion_map.region_id = $region_id)";
				}
				
				if($this->input->post("sector_id"))	
				{
					$sector_id=$this->input->post("sector_id");	
					$query_string=$query_string." AND( bgb_user_battalion_map.sector_id = $sector_id)";
				}
			
				$query_string=$query_string." ORDER BY a3m_account.id ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
				
				//echo $searchterm;
				
				$data['title'] = lang('menu_user_battalion_access_management');		
				
				$data['roles'] = $this->site_model->get_all_role();
				$data['all_region'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', '1', 'region_name', 'ASC');
				$data['all_sector'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'sector_status', '1', 'sector_name', 'ASC');
				
				$this->load->helper("url");
				$this->load->library('pagination');
				//pagination
				$config = array();
				$config["base_url"] = base_url() . "battalion/battalion/user_battalion_mgt/";
				$config["total_rows"] = $this->general_model->total_count_query_string($searchterm);
				$config["per_page"] = $this->config->item("pagination_perpage");
				$config['num_links'] = 3;
				
				$config["uri_segment"] = 4;
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
				
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				
				$config['num_tag_open'] = '<li class="page">';
				$config['num_tag_close'] = '</li>';				
				
				$this->pagination->initialize($config);
				
				$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;		
				$data['all_user'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);	
				$data["links"] = $this->pagination->create_links();
				$data["page"]=$page;
				
				$this->load->view('battalion/view_user_battalion_access_list', isset($data) ? $data : NULL);						
			
			}
			else
			{
			redirect('./dashboard');  // if not permitted "edit_project_site" redirect to home page
			}			
		
		}
		else
		{
			redirect('account/sign_in');
		}
	}


	public function edit_user_battalion($user_id)
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('battalion_user_access_management'))
			{
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('user_site', 'Site name');
				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_edit')." ".lang('menu_user_battalion_access_management');		
				
				$data['user_info']=$this->general_model->get_all_table_info_by_id('a3m_account', 'id', $user_id);
				$data['roles'] = $this->site_model->get_all_role();
				$data['all_region'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', '1', 'region_name', 'ASC');
				//$data['all_sector'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'sector_status', '1', 'sector_name', 'ASC');		
								
				$this->load->view('battalion/view_edit_user_battalion', isset($data) ? $data : NULL);	
				}
				else
				{
				//echo print_r($this->input->post('user_site'));
				$data['user_info']=$this->general_model->get_all_table_info_by_id('a3m_account', 'id', $user_id);
				$user_battalion=$this->input->post('user_battalion');											// Take checkbox post value as an Array		
				
				if($this->general_model->is_exist_in_a_table('bgb_user_battalion_map','account_id', $user_id))
				{
				$this->general_model->delete_from_table('bgb_user_battalion_map', 'account_id', $user_id);  	    // First delete all user site
				}
				
				if($this->input->post('user_battalion'))
				{
					
				//print_r($this->input->post('user_battalion'));
				foreach ($user_battalion as $battalion) :
					
					$battalion_info= $this->general_model->get_all_table_info_by_id('battalion_and_licence', 'battalion_id', $battalion);
					$region_id=$battalion_info->region_id;
					$sector_id=$battalion_info->sector_id;
					
					$table_data=array(
						'account_id'=>$user_id,
						'battalion_id'=>$battalion,
						'region_id'=>$region_id,
						'sector_id'=>$sector_id,
						'update_user_id'=>$data['account']->id,
						'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
						);
				
					$success_or_fail=$this->general_model->save_into_table('bgb_user_battalion_map', $table_data); // insert in to  bgb_user_battalion_map
					
					if($success_or_fail)
						$data['success_msg']=lang('saveed_successfully');
					else
						$data['error_msg']=lang('save_unsuccessfull');										
					
				endforeach;
				}
				
				$data['title'] = lang('action_edit')." ".lang('menu_user_site_management');		
				
				$data['roles'] = $this->site_model->get_all_role();
				$data['all_region'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_region', 'region_status', '1', 'region_name', 'ASC');
				//$data['all_sector'] = $this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'sector_status', '1', 'sector_name', 'ASC');		
								
				$this->load->view('battalion/view_edit_user_battalion', isset($data) ? $data : NULL);						
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "edit_project_site" redirect to home page
			}			
		
		}
		else
		{
			redirect('account/sign_in');
		}
	}
	
	
	/**** Ajax function *****/
	function get_all_child_location()
	{
	$dvid=$this->input->post('dvid');				$dvid  = empty($dvid) ? NULL : $dvid;
	$dtid=$this->input->post('dtid');				$dtid  = empty($dtid) ? NULL : $dtid;
	$upid=$this->input->post('upid');				$upid  = empty($upid) ? NULL : $upid;
	$unid=$this->input->post('unid');				$unid  = empty($unid) ? NULL : $unid;
	$maid=$this->input->post('maid');				$maid  = empty($maid) ? NULL : $maid;
	$ltype=$this->input->post('ltype');				$ltype  = empty($ltype) ? NULL : $ltype;
	
	$this->ref_location_model->get_child_location($dvid,$dtid,$upid,$unid,$maid,$ltype);				
	}
	
	/**** Ajax function *****/
	
	public function delete_battalion()
	{
	if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('delete_region_sector_battalion'))
			{
			$battalion_id=$this->input->post('battalion_id');
				if($this->general_model->is_exist_in_a_table('bgb_user_battalion_map','battalion_id',$battalion_id))
				{
					$success_or_fail="There is some user against this battalion. You can not delete this battalion. First delete those user";
					echo $success_or_fail;
					
				}
				else
				{
					$success_or_fail=$this->general_model->delete_from_table('battalion_and_licence','battalion_id',$battalion_id);
					if($success_or_fail)
					{
					echo "Successfull";								
					}
					else
					{
					echo "Unsuccessfull";
					}
				}
			}
			else
			{
			redirect('');  // if not permitted "delete_registration" redirect to home page
			}
		}
		else
		{
			redirect('account/sign_in');
		}	
	}
	
	
	
	function get_all_sector_by_region_id()
	{
	$region_id=$this->input->post('region_id');				$region_id  = empty($region_id) ? NULL : $region_id;
	$sector_info=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_sector', 'region_id', $region_id, 'sector_name', 'ASC');
	echo '<option value="">--'.lang('select').'--</option>';
	foreach ($sector_info as $row)
		{
			$language = $this->session->userdata('site_lang');
			$id=$row->sector_id;
			
			if($language=='bangla')
			$data=$row->sector_name_bn;	
			else
			$data=$row->sector_name;	
			
			echo '<option value="'.$id.'">'.$data.'</option>';
		}	
		
	}
	
	
	/***** License key functions ****************/
	
	
	function codeGenerate($name=""){
		$keylen= $this->keylen;
		$initlen=$this->initLen();
		$initcode=$this->initCode($initlen);
		$fullcode=$this->extendCode($initcode,$name);
		return $this->formatLicense($fullcode);
	}
	
	function codeValidate($serial,$name=""){
		//return false on empty serial
		if(empty($serial)|| $serial=="")return $this->invalid;
		//remove formating to get plain string
		$serial=str_replace("-","",$serial);
		$serial=strtoupper($serial);
		$serial=str_replace(array("0","1","O","I",),
							array("","","","",),
							$serial);
		$keylen= $this->keylen; //default length
		$thislen=strlen($serial);
		//check length of code
		if($keylen<>$thislen)return $this->invalid;
		$initlen=$this->initLen();
		$initcode=substr($serial,0,$initlen);
		$extendedcode=$this->extendCode($initcode,$name);
		$fullcode=substr($extendedcode,0,$keylen);
		if($fullcode==$serial) return $this->isvalid;
		else return $this->invalid;
	}

	function initCode($length=14){
		$list=$this->basechar;
		$lenlist=strlen($list)-1; //count start from 0
		$codestring="";
		$length=max($length,1);
		if($length>0){
			while(strlen($codestring)<$length){
				$codestring.=$list[mt_rand(0,$lenlist)];
			}
		}
		return $codestring;
	}
	
	function extendCode($initcode,$name) {
		$software=$this->software;
		$p1str=$this->sumDigit($initcode);
		$p1str.=$this->add32($initcode,$name."abhishek".$software);
		$p1str=strtoupper($p1str);
		$p1str=str_replace(	array("0","1","O","I",),
							array("","","","",),
							$p1str);
		$p1len=strlen($p1str);
		$extrabit="";$i=0;
		while(strlen($extrabit)<$this->keylen-2) {
			$extrabit.=substr($p1str,$i,1);
			$extrabit.=substr($p1str,$p1len-$i-1,1);
			$i++;
			if (defined('LKM_DEBUG'))echo "$p1str $extrabit<br/>";
		}
		return $initcode.$extrabit."6F75";
	}

	function formatLicense($serial){
		$farray=str_split($this->formatstr);
		$sarray=str_split($serial);
		$s0=$farray[0];
		$s1=$farray[1]+$s0;
		$s2=$farray[2]+$s1;
		$s3=$farray[3]+$s2;
		$s4=$farray[3]+$s3;
		$scount=$this->keylen;$sformated="";
		for ($i=0;$i<$scount;$i++){
			if($i==$s0||$i==$s1||$i==$s2||$i==$s3||$i==$s4)
				$sformated.="-";
			$sformated.=$sarray[$i];
		}
		if (defined('LKM_DEBUG')) echo " $serial FORMATED AS $sformated<br/>";
		
		return $sformated;
	}
	
	function initLen(){
		$keylen=$this->keylen;
		$initlen=intval($keylen/3);
		$initlen=max($initlen,1);
		return $initlen;
	}
	
	function add32($a,$b){		
		$sum=base_convert($a,36,10)+base_convert($b,36,10);
		$sum32=base_convert($sum,10,36);
		$sum32=str_replace(	array("0","1","O","I","o","i"),
							array("","","","","","",),
							$sum32);
		if (defined('LKM_DEBUG'))echo " ADD32 $a + $b = $sum32<br/>";
		return $sum32;
	}
	

	function sumDigit($str){
		$a=str_split($str);$sum=0;
		for($i=0;$i<count($a);$i++)$sum=$sum+base_convert($a[$i],36,10);
		$sum=str_replace(	array("0","1","O","I","o","i"),
							array("AZ","BY","29","38","29","38",),
							$sum);
		if (defined('LKM_DEBUG'))echo " sumDigit  $str = $sum<br/>";
		return $sum;
	}
	
	/***** License key functions END****************/
	
}

/* End of file battalion.php */
/* Location: ./system/application/controllers/battalion/battalion.php */