<?php
class Designation extends CI_Controller {	
	
	
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
	
	
	public function create_designation()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('designation_management'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('designation_name', 'Designation name', 'required');
				$this->form_validation->set_rules('designation_name_bn', 'Sector name bangla', 'required');
				$this->form_validation->set_rules('designation_status', 'Sector status', 'required');				
				
				
				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_create')." ".lang('menu_designation');					
				
				$this->load->view('designation/view_create_designation.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_designation')." ".lang('menu_designation');
				
			
				
					if(!$this->general_model->is_exist_in_a_table('bgb_designation','designation_name',$this->input->post('designation_name')))
					{
					if($this->input->post('designation_status')==1)
					$designation_status=1;
					else
					$designation_status=0;
					
					$designation_data=array(
							'designation_name'=>$this->input->post('designation_name'),
							'designation_name_bn'=>$this->input->post('designation_name_bn'),												
							'designation_status'=>$designation_status,
							'create_user_id'=>$data['account']->id,
							'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
					
					$success_or_fail=$this->general_model->save_into_table('bgb_designation', $designation_data);
					
					if($success_or_fail)
						$data['success_msg']=lang('saveed_successfully');
					else
						$data['error_msg']=lang('save_unsuccessfull');
					}
					else
					{
						$data['error_msg']='Designation already exist';
					}
					
				$this->load->view('designation/view_create_designation.php', isset($data) ? $data : NULL);		
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
	
	
	public function edit_single_designation($designation_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('designation_management'))
			{
								
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('designation_name', 'Designation name', 'required');
				$this->form_validation->set_rules('designation_name_bn', 'Sector name bangla', 'required');
				$this->form_validation->set_rules('designation_status', 'Sector status', 'required');	
				
				
				
				if ($this->form_validation->run() == FALSE)
				{
				$data['title'] = lang('action_edit')." ".lang('menu_designation');	
				$data['designation_info']= $this->general_model->get_all_table_info_by_id('bgb_designation', 'designation_id', $designation_id);
				
				$this->load->view('designation/edit_single_designation.php', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('action_edit')." ".lang('menu_designation');
				
					if($this->input->post('designation_status')==1)
					$designation_status=1;
					else
					$designation_status=0;
					
					$designation_data=array(
							'designation_name'=>$this->input->post('designation_name'),
							'designation_name_bn'=>$this->input->post('designation_name_bn'),													
							'designation_status'=>$designation_status,
							'update_user_id'=>$data['account']->id,
							'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
							);
					
					$success_or_fail=$this->general_model->update_table('bgb_designation', $designation_data,'designation_id', $designation_id);
					
					if($success_or_fail)
						$data['success_msg']="updated successfully";
					else
						$data['error_msg']="updated unsuccessfully";
				$data['designation_info']= $this->general_model->get_all_table_info_by_id('bgb_designation', 'designation_id', $designation_id);
				$this->load->view('designation/edit_single_designation.php', isset($data) ? $data : NULL);		
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
	
	
	
	public function designation_list()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('designation_management'))
			{
			
			$this->load->helper("url");	
			$data['title'] = lang('action_view')." ".lang('menu_designation');	
			
			//$data['all_registration'] = $this->registration_model->get_all_registration();	
			$this->load->library('pagination');
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "designation/designation/designation_list/";
			$config["total_rows"] = $this->general_model->number_of_total_rows_in_a_table('bgb_designation');
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
			$data['all_designation'] = $this->general_model->get_all_result_by_limit('bgb_designation','designation_name','asc',$config["per_page"], $page);							
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$this->load->view('designation/view_designation_list.php', isset($data) ? $data : NULL);				
				
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
	
	
	public function search_designation_list()
	{
		if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('designation_management'))
			{
				
				// assign posted valued
				$data['designation_name']    		= $this->input->post('designation_name');
				$data['designation_status']     		= $this->input->post('designation_status');
						
				
				if($this->input->post("search_submit"))
				{
				$query_string="SELECT * FROM   bgb_designation";	
		
				$query_string=$query_string." WHERE ( bgb_designation.designation_id > 0)";
			
				if($this->input->post("designation_name"))	
				{
					$designation_name=$this->input->post("designation_name"); 
					$query_string=$query_string." AND (bgb_designation.designation_name Like '%$designation_name%')";
				}								
				
				
				if($this->input->post("designation_status"))	
				{
					if($this->input->post("designation_status")==1)
						$designation_status=1;
					else
						$designation_status=0;
					
					$query_string=$query_string." AND(bgb_designation.designation_status = $designation_status)";
				}
				
			
				$query_string=$query_string." ORDER BY bgb_designation.designation_name ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
				
				//echo $searchterm;
				
				$data['title'] = lang('action_view')." ".lang('menu_sector');	
				$this->load->helper("url");
				$this->load->library('pagination');
				//pagination
				$config = array();
				$config["base_url"] = base_url() . "designation/designation/search_designation_list/";
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
				$data['all_designation'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);				
				$data["links"] = $this->pagination->create_links();
				$data["page"]=$page;
				
				$this->load->view('designation/view_designation_list.php', isset($data) ? $data : NULL);	
				
			
			
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
	
	
	public function delete_designation()
	{
	if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('delete_designation_staff_salary_month'))
			{
			$designation_id=$this->input->post('designation_id');
				if($this->general_model->is_exist_in_a_table('bgb_staff','designation_id',$designation_id))
				{
					$success_or_fail="There is some staff with this designation. You can not delete this designation. First delete those user";
					echo $success_or_fail;
					
				}
				else
				{
					$success_or_fail=$this->general_model->delete_from_table('bgb_designation','designation_id',$designation_id);
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
	
	public function unit_wise_designation()
	{
	if($this->authentication->is_signed_in())
		{
				$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
				if($this->authorization->is_permitted('unit_wise_designation'))
				{
				$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);				
				
			
				$this->load->view('designation/unit_wise_designation', isset($data) ? $data : NULL);
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
		
		
		
	public function unit_wise_designation_search()
	{
	if($this->authentication->is_signed_in())
		{
				$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
				if($this->authorization->is_permitted('unit_wise_designation'))
				{
				$data['battalion_id']     	= $this->input->post('battalion_id');
				
				$query_string='SELECT bgb_designation.designation_name,
				 bgb_designation.designation_name_bn,
       bgb_designation.designation_id,
       COUNT(bgb_designation.designation_id) AS count_designation,
       bgb_user_battalion_map.battalion_id
  FROM (bgb_staff bgb_staff
        INNER JOIN bgb_user_battalion_map bgb_user_battalion_map
           ON (bgb_staff.account_id = bgb_user_battalion_map.account_id))
       INNER JOIN bgb_designation bgb_designation
          ON (bgb_staff.designation_id = bgb_designation.designation_id)
 WHERE (bgb_user_battalion_map.battalion_id = '.$data['battalion_id'].')
GROUP BY bgb_designation.designation_id';
				$data['unit_wise_designation'] = $this->general_model->get_all_querystring_result($query_string);
					
				//print_r($data['unit_wise_designation']);
				//exit();
				
				$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);											
				$this->load->view('designation/unit_wise_designation', isset($data) ? $data : NULL);
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
	
	
	public function save_unit_wise_designation_quota()
	{
		if($this->authentication->is_signed_in())
		{
				$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
				if($this->authorization->is_permitted('unit_wise_designation'))
				{	
				$battalion_id=$this->input->post('battalion_id');
				$designation_id=$this->input->post('designation_id');
				$designation_quota=$this->input->post('designation_quota');
				//echo "battalion_id=".$battalion_id.", designation_id=".$designation_id,",designation_quota=".$designation_quota;
				$searchterm="Select * FROM bgb_unit_wise_designation_quota Where battalion_id=".$battalion_id." AND designation_id=".$designation_id;
					if($this->general_model->is_exist_in_a_table_querystring($searchterm))
					{
					//update
					$query="UPDATE bgb_unit_wise_designation_quota SET designation_quota=".$designation_quota." WHERE battalion_id=".$battalion_id." AND designation_id=".$designation_id;
					}
					else
					{
					//insert
					$query="INSERT INTO bgb_unit_wise_designation_quota (battalion_id,designation_id,designation_quota) VALUES ($battalion_id,$designation_id,$designation_quota)";					
					}
					$success_or_fail=$this->general_model->update_querystring($query);
					if($success_or_fail)
					{
					echo "Successfull";								
					}
					else
					{
					echo "Unsuccessfull";
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
		
}

/* End of file battalion.php */
/* Location: ./system/application/controllers/designation/designation.php */