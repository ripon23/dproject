<?php
class Region extends CI_Controller {	
	
	
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
	
	
	public function create_region()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_region'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('region_name', 'Region name', 'required');
				$this->form_validation->set_rules('region_name_bn', 'Region name bangla', 'required');
				$this->form_validation->set_rules('region_address', 'Region address');				
				$this->form_validation->set_rules('region_status', 'Region status', 'required');
				
				
				
				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_create')." ".lang('menu_region');				
				$this->load->view('region/view_create_region.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_create')." ".lang('menu_region');
				
			
				
					if(!$this->general_model->is_exist_in_a_table('bgb_region','region_name',$this->input->post('region_name')))
					{
					if($this->input->post('region_status')==1)
					$region_status=1;
					else
					$region_status=0;
					
					$region_and_licence_data=array(
							'region_name'=>$this->input->post('region_name'),
							'region_name_bn'=>$this->input->post('region_name_bn'),
							'region_address'=>$this->input->post('region_address'),							
							'region_status'=>$region_status,
							'create_user_id'=>$data['account']->id,
							'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
					
					$success_or_fail=$this->general_model->save_into_table('bgb_region', $region_and_licence_data);
					
					if($success_or_fail)
						$data['success_msg']=lang('saveed_successfully');
					else
						$data['error_msg']=lang('save_unsuccessfull');
					}
					else
					{
						$data['error_msg']='region already exist';
					}
					
				$this->load->view('region/view_create_region.php', isset($data) ? $data : NULL);		
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
	
	
	public function edit_single_region($region_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_region'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('region_name', 'Region name', 'required');
				$this->form_validation->set_rules('region_name_bn', 'Region name bangla', 'required');
				$this->form_validation->set_rules('region_address', 'Region address');				
				$this->form_validation->set_rules('region_status', 'Region status', 'required');
				
				
				
				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_create')." ".lang('menu_region');	
				$data['region_info']= $this->general_model->get_all_table_info_by_id('bgb_region', 'region_id', $region_id);
				$this->load->view('region/edit_single_region.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_create')." ".lang('menu_region');
				
					if($this->input->post('region_status')==1)
					$region_status=1;
					else
					$region_status=0;
					
					$region_data=array(
							'region_name'=>$this->input->post('region_name'),
							'region_name_bn'=>$this->input->post('region_name_bn'),
							'region_address'=>$this->input->post('region_address'),							
							'region_status'=>$region_status,
							'update_user_id'=>$data['account']->id,
							'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
					
					$success_or_fail=$this->general_model->update_table('bgb_region', $region_data,'region_id', $region_id);
					
					if($success_or_fail)
						$data['success_msg']="updated successfully";
					else
						$data['error_msg']="updated unsuccessfully";
				$data['region_info']= $this->general_model->get_all_table_info_by_id('bgb_region', 'region_id', $region_id);	
				$this->load->view('region/edit_single_region.php', isset($data) ? $data : NULL);		
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
	
	
	
	public function region_list()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('manage_region'))
			{
			
			$this->load->helper("url");	
			$data['title'] = lang('action_view')." ".lang('menu_region');	
			
			//$data['all_registration'] = $this->registration_model->get_all_registration();	
			$this->load->library('pagination');
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "region/region/region_list/";
			$config["total_rows"] = $this->general_model->number_of_total_rows_in_a_table('bgb_region');
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
			$data['all_region'] = $this->general_model->get_all_result_by_limit('bgb_region','region_name','asc',$config["per_page"], $page);				
			
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$this->load->view('region/view_region_list.php', isset($data) ? $data : NULL);				
				
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
	
	
	public function search_region_list()
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('manage_region'))
			{
				
				// assign posted valued
				$data['region_name']    		= $this->input->post('region_name');
				$data['region_status']     	= $this->input->post('region_status');
						
				
				if($this->input->post("search_submit"))
				{
				$query_string="SELECT * FROM   bgb_region";	
		
				$query_string=$query_string." WHERE ( bgb_region.region_id > 0)";
			
				if($this->input->post("region_name"))	
				{
					$region_name=$this->input->post("region_name"); 
					$query_string=$query_string." AND (bgb_region.region_name Like '%$region_name%')";
				}
				
				
				if($this->input->post("region_status"))	
				{
					if($this->input->post("region_status")==1)
						$region_status=1;
					else
						$region_status=0;
					
					$query_string=$query_string." AND(bgb_region.region_status = $region_status)";
				}
				
			
				$query_string=$query_string." ORDER BY bgb_region.region_name ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
				
				//echo $searchterm;
				
				$data['title'] = lang('action_view')." ".lang('menu_region');	
				$this->load->helper("url");
				$this->load->library('pagination');
				//pagination
				$config = array();
				$config["base_url"] = base_url() . "region/region/search_region_list/";
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
				$data['all_region'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);	
				$data["links"] = $this->pagination->create_links();
				$data["page"]=$page;
				
				$this->load->view('region/view_region_list.php', isset($data) ? $data : NULL);	
				
			
			
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
	
	
	
	
	public function view_single_site($site_id)
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('view_project_site'))
			{
				
				$data['title'] = lang('action_view')." ".lang('menu_project_site');									
				$data['single_site'] = $this->general_model->get_all_table_info_by_id('eh_project_site','project_id',$site_id);	
				$this->load->view('project_site/view_view_single_site', isset($data) ? $data : NULL);						
			
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
	public function delete_region()
	{
	if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('delete_region_sector_battalion'))
			{
			$region_id=$this->input->post('region_id');
				if($this->general_model->is_exist_in_a_table('bgb_sector','region_id',$region_id))
				{
					$success_or_fail="There is some sector against this region. You can not delete this region. First delete those sector";
					echo $success_or_fail;
					
				}
				else
				{
					$success_or_fail=$this->general_model->delete_from_table('bgb_region','region_id',$region_id);
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
	
	
	
}

/* End of file battalion.php */
/* Location: ./system/application/controllers/battalion/battalion.php */