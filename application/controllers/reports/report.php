<?php

class Report extends CI_Controller {

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
	
	public function salary_report()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
	
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
			$this->load->view('reports/view_salary_report', isset($data) ? $data : NULL);
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
	
	
	public function salary_summary()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
	
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);			
			$this->load->view('reports/view_salary_summary', isset($data) ? $data : NULL);
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
	
	
	public function salary_summary_search()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			$data['battalion_id']     	= $this->input->post('battalion_id');
				$data['season_id']     		= $this->input->post("season_id");
				$data['designation_id']     = $this->input->post("designation_id");
				$data['company_id']     	= $this->input->post("company_id");

						
				
				if($this->input->post("search_submit"))
				{
			
			
				$this->load->helper("url");	
				$data['title'] = lang('action_view')." ".lang('menu_staff');	
				
				$this->load->library('pagination');
				
				$sql='SELECT bgb_user_battalion_map.battalion_id AS battalion_id
						FROM    a3m_account a3m_account
							 INNER JOIN
								bgb_user_battalion_map bgb_user_battalion_map
							 ON (a3m_account.id = bgb_user_battalion_map.account_id)
					   WHERE (a3m_account.id = '.$data['account']->id.')';
				$all_site_list=$this->general_model->get_all_querystring_result($sql);	   
				foreach($all_site_list as $result) 
				{
				$ids[]=$result->battalion_id;
				}
				$comma_separated = implode(",", $ids);
				//echo $comma_separated;
				
				$query_string='SELECT bgb_staff.company_id as company_id,
       bgb_user_battalion_map.battalion_id,
       bgb_main_salary.season_id,
       SUM(bgb_main_salary.main_salary) as main_salary,
       SUM(bgb_main_salary.house_rent) as house_rent,
       SUM(bgb_main_salary.treatment_allowance) as treatment_allowance,
       SUM(bgb_main_salary.transportation_allowance) as transportation_allowance,
       SUM(bgb_main_salary.border_allowance) as border_allowance,
       SUM(bgb_main_salary.tiffin_allowance) as tiffin_allowance,
       SUM(bgb_main_salary.mountains_allowance) as mountains_allowance,
       SUM(bgb_main_salary.education_help_allowance) as education_help_allowance,
       SUM(bgb_main_salary.costly_allowance) as costly_allowance,
       SUM(bgb_main_salary.servant_allowance) as servant_allowance,
       SUM(bgb_main_salary.employee_allowance) as employee_allowance,
       SUM(bgb_main_salary.washed_allowance) as washed_allowance,
       SUM(bgb_main_salary.barber_allowance) as barber_allowance,
       SUM(bgb_main_salary.fuller_allowance) as fuller_allowance,
       SUM(bgb_main_salary.leave_allowance) as leave_allowance,
       SUM(bgb_main_salary.ration_allowance) as ration_allowance,
       SUM(bgb_main_salary.time_scale) as time_scale,
       SUM(bgb_main_salary.earn_leave) as earn_leave,
       SUM(bgb_main_salary.festival_allowance) as festival_allowance,
       SUM(bgb_main_salary.entertainment_allowance) as entertainment_allowance,
       SUM(bgb_main_salary.gpf_advanced) as gpf_advanced,
       SUM(bgb_main_salary.subsidiary_salary_or_allowance) as subsidiary_salary_or_allowance,
       SUM(bgb_main_salary.honorary_allowance) as honorary_allowance,
       SUM(bgb_main_excision.gpf_excision) as gpf_excision,
       SUM(bgb_main_excision.gpf_payment) as gpf_payment,
       SUM(bgb_main_excision.house_building_excision) as house_building_excision,
       SUM(bgb_main_excision.house_building_interest) as house_building_interest,
       SUM(bgb_main_excision.miscellaneous_excision) as miscellaneous_excision,
       SUM(bgb_main_excision.motorcycle_excision) as motorcycle_excision,
       SUM(bgb_main_excision.additional_house_rent_excision) as additional_house_rent_excision,
       SUM(bgb_main_excision.income_tax) as income_tax,
       SUM(bgb_main_excision.extra_salary_excision) as extra_salary_excision
  FROM ((bgb_main_excision bgb_main_excision
         INNER JOIN bgb_user_battalion_map bgb_user_battalion_map
            ON (bgb_main_excision.account_id =
                   bgb_user_battalion_map.account_id))
        INNER JOIN bgb_main_salary bgb_main_salary
           ON     (bgb_main_salary.account_id =
                      bgb_user_battalion_map.account_id)
              AND (bgb_main_salary.season_id = bgb_main_excision.season_id))
       INNER JOIN bgb_staff bgb_staff
          ON (bgb_staff.account_id = bgb_user_battalion_map.account_id)
 WHERE  (bgb_user_battalion_map.battalion_id IN ('.$comma_separated.'))';
			
			
				
				if($this->input->post("season_id"))	
				{
					$season_id=$this->input->post("season_id"); 
					$query_string=$query_string." AND (bgb_main_salary.season_id = '$season_id')";
				}
								
				
				if($this->input->post("battalion_id"))	
				{
					$battalion_id=$this->input->post("battalion_id");	
					$query_string=$query_string." AND(bgb_user_battalion_map.battalion_id = $battalion_id)";
				}
				
			
				$query_string=$query_string." GROUP BY bgb_staff.company_id ORDER BY bgb_staff.company_id ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
			//echo $searchterm;
			
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "reports/report/salary_summary_search/";
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
			$data['company_salary_info'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);					
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);			
			//$data['searchterm']=$searchterm;
			
			$this->load->view('reports/view_salary_summary_search', isset($data) ? $data : NULL);
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
	
	
	
	public function salary_report_payroll()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
	
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
			$this->load->view('reports/view_salary_report_payroll', isset($data) ? $data : NULL);
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
	
	
	
	public function salary_report_search()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			// assign posted valued

				$data['battalion_id']     	= $this->input->post('battalion_id');
				$data['season_id']     		= $this->input->post("season_id");
				$data['designation_id']     = $this->input->post("designation_id");
				$data['company_id']     	= $this->input->post("company_id");

						
				
				if($this->input->post("search_submit"))
				{						
				$this->load->helper("url");	
				$data['title'] = lang('action_view')." ".lang('menu_staff');	
				
				$this->load->library('pagination');				
				$sql='SELECT bgb_user_battalion_map.battalion_id AS battalion_id
						FROM    a3m_account a3m_account
							 INNER JOIN
								bgb_user_battalion_map bgb_user_battalion_map
							 ON (a3m_account.id = bgb_user_battalion_map.account_id)
					   WHERE (a3m_account.id = '.$data['account']->id.')';
				$all_site_list=$this->general_model->get_all_querystring_result($sql);	   
				foreach($all_site_list as $result) 
				{
				$ids[]=$result->battalion_id;
				}
				$comma_separated = implode(",", $ids);				
				
				$query_string='SELECT bgb_main_salary.*, bgb_main_excision.*,
				a3m_rel_account_role.account_id,
				   a3m_rel_account_role.role_id,
				   bgb_user_battalion_map.battalion_id,
				   a3m_account.id,
				   a3m_account.username,
				   bgb_staff.staff_id,
				   bgb_staff.designation_id,
				   bgb_staff.company_id,
				   a3m_account_details.fullname,
				   a3m_account_details.dateofbirth,
				   a3m_account_details.gender,
				   a3m_account_details.picture,
				   FLOOR(DATEDIFF (NOW(), dateofbirth)/365) AS age,
				   bgb_staff.staff_name_bangla,
				   bgb_staff.mobile,
				   bgb_staff.blood_group,
				   bgb_staff.address,
				   bgb_staff.joining_date
			  FROM    (   (   (   a3m_account a3m_account
							   INNER JOIN
								  a3m_account_details a3m_account_details
							   ON (a3m_account.id = a3m_account_details.account_id))
						   INNER JOIN
							  a3m_rel_account_role a3m_rel_account_role
						   ON (a3m_rel_account_role.account_id = a3m_account.id))
					   INNER JOIN
						  bgb_user_battalion_map bgb_user_battalion_map
					   ON (a3m_rel_account_role.account_id = bgb_user_battalion_map.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
				   INNER JOIN 
				   		bgb_main_salary bgb_main_salary
					ON 	(a3m_account.id = bgb_main_salary.account_id)
					INNER JOIN 
				   		bgb_main_excision bgb_main_excision
					ON 	(bgb_main_salary.salary_id = bgb_main_excision.salary_id)
			 WHERE (a3m_rel_account_role.role_id = '.$this->config->item("staff_role_id").')
				   AND(bgb_user_battalion_map.battalion_id IN
							 ('.$comma_separated.'))';
			
			
				
				if($this->input->post("season_id"))	
				{
					$season_id=$this->input->post("season_id"); 
					$query_string=$query_string." AND (bgb_main_salary.season_id = '$season_id')";
				}
				
				if($this->input->post("designation_id"))	
				{
					$designation_id=$this->input->post("designation_id"); 
					$query_string=$query_string." AND (bgb_staff.designation_id = '$designation_id')";
				}
				
				if($this->input->post("company_id"))	
				{
					$company_id=$this->input->post("company_id"); 
					$query_string=$query_string." AND (bgb_staff.company_id = '$company_id')";
				}
				
				if($this->input->post("battalion_id"))	
				{
					$battalion_id=$this->input->post("battalion_id");	
					$query_string=$query_string." AND(bgb_user_battalion_map.battalion_id = $battalion_id)";
				}
				
			
				$query_string=$query_string." ORDER BY a3m_account.id ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
			//echo $searchterm;
			
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "reports/report/salary_report_search/";
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
			$data['all_staff_user'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);					
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');
			//$data['searchterm']=$searchterm;			
			$this->load->view('reports/view_salary_report_search', isset($data) ? $data : NULL);
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
		
	
	public function salary_report_payroll_search()
	{
	if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			// assign posted valued

				$data['battalion_id']     	= $this->input->post('battalion_id');
				$data['season_id']     		= $this->input->post("season_id");
				$data['designation_id']     = $this->input->post("designation_id");
				$data['company_id']     	= $this->input->post("company_id");

						
				
				if($this->input->post("search_submit"))
				{
			
			
				$this->load->helper("url");	
				$data['title'] = lang('action_view')." ".lang('menu_staff');	
				
				$this->load->library('pagination');
				
				$sql='SELECT bgb_user_battalion_map.battalion_id AS battalion_id
						FROM    a3m_account a3m_account
							 INNER JOIN
								bgb_user_battalion_map bgb_user_battalion_map
							 ON (a3m_account.id = bgb_user_battalion_map.account_id)
					   WHERE (a3m_account.id = '.$data['account']->id.')';
				$all_site_list=$this->general_model->get_all_querystring_result($sql);	   
				foreach($all_site_list as $result) 
				{
				$ids[]=$result->battalion_id;
				}
				$comma_separated = implode(",", $ids);
				
				
				$query_string='SELECT bgb_main_salary.*, bgb_main_excision.*,
				a3m_rel_account_role.account_id,
				   a3m_rel_account_role.role_id,
				   bgb_user_battalion_map.battalion_id,
				   a3m_account.id,
				   a3m_account.username,
				   bgb_staff.staff_id,
				   bgb_staff.designation_id,
				   bgb_staff.company_id,
				   a3m_account_details.fullname,
				   a3m_account_details.dateofbirth,
				   a3m_account_details.gender,
				   a3m_account_details.picture,
				   FLOOR(DATEDIFF (NOW(), dateofbirth)/365) AS age,
				   bgb_staff.staff_name_bangla,
				   bgb_staff.mobile,
				   bgb_staff.blood_group,
				   bgb_staff.address,
				   bgb_staff.joining_date
			  FROM    (   (   (   a3m_account a3m_account
							   INNER JOIN
								  a3m_account_details a3m_account_details
							   ON (a3m_account.id = a3m_account_details.account_id))
						   INNER JOIN
							  a3m_rel_account_role a3m_rel_account_role
						   ON (a3m_rel_account_role.account_id = a3m_account.id))
					   INNER JOIN
						  bgb_user_battalion_map bgb_user_battalion_map
					   ON (a3m_rel_account_role.account_id = bgb_user_battalion_map.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
				   INNER JOIN 
				   		bgb_main_salary bgb_main_salary
					ON 	(a3m_account.id = bgb_main_salary.account_id)
					INNER JOIN 
				   		bgb_main_excision bgb_main_excision
					ON 	(bgb_main_salary.salary_id = bgb_main_excision.salary_id)
			 WHERE (a3m_rel_account_role.role_id = '.$this->config->item("staff_role_id").')
				   AND(bgb_user_battalion_map.battalion_id IN
							 ('.$comma_separated.'))';
			
			
				
				if($this->input->post("season_id"))	
				{
					$season_id=$this->input->post("season_id"); 
					$query_string=$query_string." AND (bgb_main_salary.season_id = '$season_id')";
				}
				
				if($this->input->post("designation_id"))	
				{
					$designation_id=$this->input->post("designation_id"); 
					$query_string=$query_string." AND (bgb_staff.designation_id = '$designation_id')";
				}
				
				if($this->input->post("company_id"))	
				{
					$company_id=$this->input->post("company_id"); 
					$query_string=$query_string." AND (bgb_staff.company_id = '$company_id')";
				}
				
				if($this->input->post("battalion_id"))	
				{
					$battalion_id=$this->input->post("battalion_id");	
					$query_string=$query_string." AND(bgb_user_battalion_map.battalion_id = $battalion_id)";
				}
				
			
				$query_string=$query_string." ORDER BY a3m_account.id ASC";													
				
				$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				else
				{
				$searchterm = $this->session->userdata('searchterm');
				}
			//echo $searchterm;
			
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "reports/report/salary_report_search/";
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
			$data['all_staff_user'] = $this->general_model->get_all_result_by_limit_querystring($searchterm,$config["per_page"], $page);					
			$data["links"] = $this->pagination->create_links();
			$data["page"]=$page;
			
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');
			//$data['searchterm']=$searchterm;
			
			$this->load->view('reports/view_salary_report_payroll_search', isset($data) ? $data : NULL);
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
	
	public function staff_salary_bill()
	{
		if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
			$this->load->view('reports/view_staff_salary_bill', isset($data) ? $data : NULL);
			
			}
			else
			{
			redirect('./dashboard');  // if not permitted "can_see_salary_report" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	}
	
	
	public function staff_salary_bill_search()
	{
		if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			
			// assign posted valued

				$data['battalion_id']     	= $this->input->post('battalion_id');
				$data['season_id']     		= $this->input->post("season_id");
				$data['designation_id']     = $this->input->post("designation_id");
				$data['company_id']     	= $this->input->post("company_id");

						
				
				if($this->input->post("search_submit"))
				{
			
			
				$this->load->helper("url");	
				$data['title'] = lang('action_view')." ".lang('menu_staff');	
				
				$this->load->library('pagination');
				
				$sql='SELECT bgb_user_battalion_map.battalion_id AS battalion_id
						FROM    a3m_account a3m_account
							 INNER JOIN
								bgb_user_battalion_map bgb_user_battalion_map
							 ON (a3m_account.id = bgb_user_battalion_map.account_id)
					   WHERE (a3m_account.id = '.$data['account']->id.')';
				$all_site_list=$this->general_model->get_all_querystring_result($sql);	   
				foreach($all_site_list as $result) 
				{
				$ids[]=$result->battalion_id;
				}
				$comma_separated = implode(",", $ids);
				
				
				$query_string='SELECT  SUM(bgb_main_salary.main_salary) AS main_salary, 
				SUM(costly_allowance) AS costly_allowance , SUM(fuller_allowance) AS fuller_allowance, SUM(barber_allowance) AS barber_allowance, SUM(ration_allowance) as ration_allowance, SUM(house_rent) as house_rent, SUM(treatment_allowance) as treatment_allowance, SUM(tiffin_allowance) AS  tiffin_allowance, SUM(education_help_allowance) AS education_help_allowance, SUM(border_allowance) AS border_allowance, SUM(mountains_allowance) AS mountains_allowance 
			  FROM    (   (   (   a3m_account a3m_account
							   INNER JOIN
								  a3m_account_details a3m_account_details
							   ON (a3m_account.id = a3m_account_details.account_id))
						   INNER JOIN
							  a3m_rel_account_role a3m_rel_account_role
						   ON (a3m_rel_account_role.account_id = a3m_account.id))
					   INNER JOIN
						  bgb_user_battalion_map bgb_user_battalion_map
					   ON (a3m_rel_account_role.account_id = bgb_user_battalion_map.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
				   INNER JOIN 
				   		bgb_main_salary bgb_main_salary
					ON 	(a3m_account.id = bgb_main_salary.account_id)
					INNER JOIN 
				   		bgb_main_excision bgb_main_excision
					ON 	(bgb_main_salary.salary_id = bgb_main_excision.salary_id)
			 WHERE (a3m_rel_account_role.role_id = '.$this->config->item("staff_role_id").')
				   AND(bgb_user_battalion_map.battalion_id IN
							 ('.$comma_separated.'))';
			
			
				
				if($this->input->post("season_id"))	
				{
					$season_id=$this->input->post("season_id"); 
					$query_string=$query_string." AND (bgb_main_salary.season_id = '$season_id')";
				}
				
				if($this->input->post("designation_id"))	
				{
					$designation_id=$this->input->post("designation_id"); 
					$query_string=$query_string." AND (bgb_staff.designation_id = '$designation_id')";
				}
				
				if($this->input->post("company_id"))	
				{
					$company_id=$this->input->post("company_id"); 
					$query_string=$query_string." AND (bgb_staff.company_id = '$company_id')";
				}
				
				if($this->input->post("battalion_id"))	
				{
					$battalion_id=$this->input->post("battalion_id");	
					$query_string=$query_string." AND(bgb_user_battalion_map.battalion_id = $battalion_id)";
				}
				
			
				$query_string=$query_string." ORDER BY a3m_account.id ASC";													
				
				//$searchterm = $this->general_model->searchterm_handler($query_string);
				}
				
			//echo $query_string;
						
			$data['salary_info'] = $this->general_model->get_all_single_row_querystring($query_string);
			//print_r($data['salary_info']);
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
			$this->load->view('reports/view_staff_salary_bill_search', isset($data) ? $data : NULL);

			
			}
			else
			{
			redirect('./dashboard');  // if not permitted "can_see_salary_report" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	}
	
	
	
	public function download_excel($season=NULL,$company=NULL,$unit=NULL)
	{
		
		if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			$data['battalion_id']     	= $unit;
			$data['season_id']     		= $season;			
			$data['company_id']     	= $company;	
			
			$searchterm=$this->session->userdata('searchterm');
			$data['all_staff_user'] = $this->general_model->get_all_querystring_result($searchterm);								
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');
			$this->load->view('reports/view_export_salary', isset($data) ? $data : NULL);
			}
			else
			{
			redirect('./dashboard');  // if not permitted "can_see_salary_report" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	}
	
	public function download_salary_summary($season=NULL,$unit=NULL)
	{
		if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			$data['battalion_id']     	= $unit;
			$data['season_id']     		= $season;						
			
			$searchterm=$this->session->userdata('searchterm');
			$data['company_salary_info'] = $this->general_model->get_all_querystring_result($searchterm);								
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$this->load->view('reports/view_export_salary_summary', isset($data) ? $data : NULL);
			}
			else
			{
			redirect('./dashboard');  // if not permitted "can_see_salary_report" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	}
	
	public function download_excel_payroll($season=NULL,$company=NULL,$unit=NULL)
	{
		
		if ($this->authentication->is_signed_in())
		{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_salary_report'))
			{
			$data['battalion_id']     	= $unit;
			$data['season_id']     		= $season;			
			$data['company_id']     	= $company;
			
			$searchterm=$this->session->userdata('searchterm');
			$data['all_staff_user'] = $this->general_model->get_all_querystring_result($searchterm);								
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');
			$this->load->view('reports/view_export_salary_payroll', isset($data) ? $data : NULL);
			}
			else
			{
			redirect('./dashboard');  // if not permitted "can_see_salary_report" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}	
	}

}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */