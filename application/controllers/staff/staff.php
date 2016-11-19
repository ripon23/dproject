<?php
class Staff extends CI_Controller {	
	
	
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
	
	
	public function create_staff()
	{
		if ($this->authentication->is_signed_in())
			{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
			{
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('user_battalion', 'User battalion', 'required');
				$this->form_validation->set_rules('designation_id', 'User designation', 'required');
				$this->form_validation->set_rules('company_id', 'User company', 'required');
				$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash|min_length[6]|max_length[20]|callback_username_check|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]');
				$this->form_validation->set_rules('staff_id', 'Staff id', 'required|callback_barcode_no_check');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
				$this->form_validation->set_rules('fullname', 'Fullname', 'required');
				$this->form_validation->set_rules('fullname_bangla', 'Fullname Bangla', 'required');
				$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'regex_match[^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])$^]');
				$this->form_validation->set_rules('age', 'Age', 'is_natural');
				$this->form_validation->set_rules('gender', 'Gender', 'required');	
				$this->form_validation->set_rules('joining_date', 'Joining date');
				$this->form_validation->set_rules('national_id', 'National Id', 'min_length[13]|max_length[17]');
				$this->form_validation->set_rules('profile_address', 'Address');
				$this->form_validation->set_rules('mobile2', 'Mobile Number(Part1)', 'min_length[5]|max_length[5]');
				$this->form_validation->set_rules('mobile3', 'Mobile Number(Part2)', 'min_length[6]|max_length[6]');
				$this->form_validation->set_rules('profile_blood_group', 'Blood Group');
				$this->form_validation->set_rules('main_salary', 'Main Salary');
				$this->form_validation->set_rules('profile_note', 'Note');				
				$this->form_validation->set_rules('gpf_number', 'GPF Number');
				$this->form_validation->set_rules('educational_qualification', 'Educational Qualification');
				$this->form_validation->set_rules('successor', 'Successor');
				$this->form_validation->set_rules('bank_account_no', 'Bank Account No');
				$this->form_validation->set_rules('marital_status', 'Marital Status');
				
				
			
				$data['number_of_site']=$this->general_model->number_of_total_rows_in_a_table_where('bgb_user_battalion_map','account_id',$data['account']->id);
				
				if($data['number_of_site']==1)
				{
				$data['user_site']=$this->general_model->get_all_table_info_by_id(' bgb_user_battalion_map', 'account_id', $data['account']->id);
				}
				else if($data['number_of_site']>1)
				{
				$data['all_site'] = $this->site_model->get_all_user_battalion($data['account']->id);	
				}
				
				$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
				$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
				
				if ($this->form_validation->run() == FALSE)
				{				
				$data['title'] = lang('menu_new_staff_registration');
				$this->load->view('staff/view_new_staff_registration', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('menu_new_staff_registration');
				
				$this->load->helper('account/phpass');
				$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
				$new_hashed_password = $hasher->HashPassword($this->input->post('password'));
		
				$a3m_account_data=array(
						'username'=>$this->input->post('username'),
						'email'=>$this->input->post('email'),
						'password'=>$new_hashed_password,						
						'createdon'=>mdate('%Y-%m-%d %H:%i:%s', now())					
						);
			
				$a3m_account_id=$this->general_model->save_into_table_and_return_insert_id('a3m_account', $a3m_account_data);				
				
				$fullname=ucwords(strtolower($this->input->post('fullname')));   // camelcase to words
				$pieces = explode(" ", $fullname);
				//var_dump($pieces);
				$length = count($pieces);
				
				for($i=1;$i<=$length-1;$i++)
				{
					if($i==1)
					$lastname=$pieces[$i];	
					else
					$lastname=$lastname." ".$pieces[$i];
				}
				
				$age=$this->input->post('age');
				//$dob = strtotime(date("Y-m-d").' -'.$age.' year');
				
				$time = strtotime("-$age year", time());
  				$dob = date("Y-m-d", $time);
				//$current_year=date("Y")
				//$dob=$current_year-$this->input->post('age');
				//$dob=$dob."-".date("M")."-".date("D");
				
				$a3m_account_details_data=array(
						'account_id'=>$a3m_account_id,
						'fullname'=>$fullname,
						'firstname'=>$pieces[0],
						'lastname'=>$lastname,
						'dateofbirth'=>$dob,
						'gender'=>$this->input->post('gender')						
						);
				
				$success_or_fail1=$this->general_model->save_into_table('a3m_account_details', $a3m_account_details_data);
				
				$eh_staff_data=array(
						'account_id'=>$a3m_account_id,
						'staff_id'=>$this->input->post('staff_id'),
						'designation_id'=>$this->input->post('designation_id'),
						'company_id'=>$this->input->post('company_id'),
						'staff_name_bangla'=>$this->input->post('fullname_bangla'),
						'joining_date'=>$this->input->post('joining_date'),
						'address'=>$this->input->post('profile_address'),
						'mobile'=>"+88".$this->input->post('mobile2').$this->input->post('mobile3'),
						'national_id'=>$this->input->post('national_id'),
						'blood_group'=>$this->input->post('profile_blood_group'),
						'main_salary'=>$this->input->post('main_salary'),
						'gpf_number'=>$this->input->post('gpf_number'),
						'educational_qualification'=>$this->input->post('educational_qualification'),
						'successor'=>$this->input->post('successor'),
						'bank_account_no'=>$this->input->post('bank_account_no'),
						'marital_status'=>$this->input->post('marital_status'),
						'note'=>$this->input->post('profile_note'),						
						'create_user_id'=>$data['account']->id,
						'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);												
				
				$success_or_fail2=$this->general_model->save_into_table('bgb_staff', $eh_staff_data);
				
				$a3m_rel_account_role_data=array(
						'account_id'=>$a3m_account_id,
						'role_id'=>$this->config->item("staff_role_id")												
						);
				
				$success_or_fail3=$this->general_model->save_into_table('a3m_rel_account_role', $a3m_rel_account_role_data);
				
				$battalion_info=$this->general_model->get_all_table_info_by_id('battalion_and_licence', 'battalion_id', $this->input->post('user_battalion'));
				
				$bgb_user_battalion_map_data=array(
						'account_id'=>$a3m_account_id,
						'battalion_id'=>$this->input->post('user_battalion'),
						'region_id'=>$battalion_info->region_id,
						'sector_id'=>$battalion_info->sector_id,
						'update_user_id'=>$data['account']->id,
						'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
						);
				
				$success_or_fail4=$this->general_model->save_into_table('bgb_user_battalion_map', $bgb_user_battalion_map_data); // insert in to  bgb_user_battalion_map
					
				
				/********** Image upload	********************/
				if(isset($_FILES['staff_picture']) && $_FILES['staff_picture']['size'] > 0)		
				{

				$config['upload_path'] = RES_DIR."/user/profile/";
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '500';
				$config['overwrite'] = 'TRUE';
				$config['maintain_ratio'] = FALSE;
				$config['quality'] = '100%';
				$config['max_width']  = '400';
				$config['max_height']  = '500';
				$config['file_name']  = $a3m_account_id;
			
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('staff_picture'))
					{
						
						$data['error'] = $this->upload->display_errors();								
					}
					else
					{
						$image_data = $this->upload->data();												
						$original_image= $image_data['raw_name'].$image_data['file_ext'];
						
						$config2 = array(
						'source_image' => $image_data['full_path'],
						'new_image' => RES_DIR."/user/profile/",
						'image_name'=> $a3m_account_id,
						'maintain_ratio' => false,
						'overwrite' => true,
						'maintain_ratio' => FALSE,
						'quality' => '100%',
						'width' => 100,
						'height' => 100
						);
						$this->load->library('image_lib');
						$this->image_lib->initialize($config2);
						if ( !$this->image_lib->resize()){
							$data['error'] = $this->image_lib->display_errors('', '');
              				}																		
						
						
						$data['upload_data'] = $this->upload->data();
						
						$image_table=array(						
						'picture'=>$original_image						
						);				
		
					$success_or_fail2=$this->general_model->update_table('a3m_account_details',$image_table,'account_id', $a3m_account_id);	
						
					}							
				}
				
				
				if($success_or_fail1 && $success_or_fail2 && $success_or_fail3 && $success_or_fail4)
					$data['success_msg']=lang('saveed_successfully');
				else
					$data['error_msg']=lang('save_unsuccessfull');
				$this->load->view('staff/view_new_staff_registration', isset($data) ? $data : NULL);
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
	
	
	function view_single_staff_profile($staff_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('can_see_staff_profile'))
			{
				
			if($this->general_model->have_access($data['account']->id,$staff_id))
				{	
				$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
				
				$data['staff_info']=$this->general_model->get_all_single_row_querystring($query);
				$data['bgb_main_salary']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_main_salary', 'account_id', $staff_id, 'season_id ', 'desc');
			
			
				$this->load->view('staff/view_single_staff_profile', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = "No Access";	
				$data['msg'] = lang('no_access_permission');
				$this->load->view('view_no_access', isset($data) ? $data : NULL);
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
	
	function edit_single_staff_profile($staff_id)
	{
		
		if ($this->authentication->is_signed_in())
			{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
			{
				
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('user_battalion', 'User battalion', 'required');
				$this->form_validation->set_rules('designation_id', 'User designation', 'required');
				$this->form_validation->set_rules('company_id', 'User company', 'required');				
				$this->form_validation->set_rules('staff_id', 'Staff id', 'required|callback_barcode_no_check_edit['.$staff_id.']');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check_edit['.$staff_id.']');
				$this->form_validation->set_rules('fullname', 'Fullname', 'required');
				$this->form_validation->set_rules('fullname_bangla', 'Fullname Bangla', 'required');
				$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'regex_match[^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])$^]');
				$this->form_validation->set_rules('age', 'Age', 'is_natural');
				$this->form_validation->set_rules('joining_date', 'Joining date');
				$this->form_validation->set_rules('national_id', 'National Id', 'min_length[13]|max_length[17]');
				$this->form_validation->set_rules('gender', 'Gender', 'required');				
				$this->form_validation->set_rules('profile_address', 'Address');
				$this->form_validation->set_rules('mobile2', 'Mobile Number(Part1)', 'min_length[5]|max_length[5]');
				$this->form_validation->set_rules('mobile3', 'Mobile Number(Part2)', 'min_length[6]|max_length[6]');
				$this->form_validation->set_rules('profile_blood_group', 'Blood Group');
				$this->form_validation->set_rules('profile_note', 'Note');
				$this->form_validation->set_rules('main_salary', 'Main Salary');
				$this->form_validation->set_rules('gpf_number', 'GPF Number');
				$this->form_validation->set_rules('educational_qualification', 'Educational Qualification');
				$this->form_validation->set_rules('successor', 'Successor');
				$this->form_validation->set_rules('bank_account_no', 'Bank Account No');
				$this->form_validation->set_rules('marital_status', 'Marital Status');
				
				
			
				$data['number_of_site']=$this->general_model->number_of_total_rows_in_a_table_where('bgb_user_battalion_map','account_id',$data['account']->id);
				
				if($data['number_of_site']==1)
				{
				$data['user_site']=$this->general_model->get_all_table_info_by_id(' bgb_user_battalion_map', 'account_id', $data['account']->id);
				}
				else if($data['number_of_site']>1)
				{
				$data['all_site'] = $this->site_model->get_all_user_battalion($data['account']->id);	
				}
				
				$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
				$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
				
				if ($this->form_validation->run() == FALSE)
				{				
				$data['title'] = lang('menu_new_staff_registration');
				
				$query='SELECT a3m_account.*,
       a3m_account_details.*,
       bgb_staff.*,
       a3m_account.id,
       bgb_user_battalion_map.*
  FROM    (   (   a3m_account a3m_account
               INNER JOIN
                  bgb_user_battalion_map bgb_user_battalion_map
               ON (a3m_account.id = bgb_user_battalion_map.account_id))
           INNER JOIN
              a3m_account_details a3m_account_details
           ON (a3m_account.id = a3m_account_details.account_id))
       INNER JOIN
          bgb_staff bgb_staff
       ON (a3m_account.id = bgb_staff.account_id)
 WHERE (a3m_account.id ='.$staff_id.')';
				
				$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
				$this->load->view('staff/view_edit_single_staff', isset($data) ? $data : NULL);
				}
				else
				{
				$data['title'] = lang('menu_new_staff_registration');
				
		
				$a3m_account_data=array(
						'email'=>$this->input->post('email')					
						);										
				$success_or_fail1=$this->general_model->update_table('a3m_account', $a3m_account_data,'id', $staff_id);
				
				
			/*	if(!$success_or_fail1)
				{
				echo "1";
				
				exit();
				}*/
				
				$fullname=ucwords(strtolower($this->input->post('fullname')));   // camelcase to words
				$pieces = explode(" ", $fullname);
				//var_dump($pieces);
				$length = count($pieces);
				
				for($i=1;$i<=$length-1;$i++)
				{
					if($i==1)
					$lastname=$pieces[$i];	
					else
					$lastname=$lastname." ".$pieces[$i];
				}
				
				$age=$this->input->post('age');

				
				$time = strtotime("-$age year", time());
  				$dob = date("Y-m-d", $time);
				
				$a3m_account_details_data=array(
						'fullname'=>$fullname,
						'firstname'=>$pieces[0],
						'lastname'=>$lastname,
						'dateofbirth'=>$dob,
						'gender'=>$this->input->post('gender')						
						);
				
				
				$success_or_fail2=$this->general_model->update_table('a3m_account_details', $a3m_account_details_data,'account_id', $staff_id);
				
				/*if(!$success_or_fail2)
				{
				echo "2";
				
				exit();
				}*/
				
				$eh_staff_data=array(
						'staff_id'=>$this->input->post('staff_id'),
						'designation_id'=>$this->input->post('designation_id'),
						'company_id'=>$this->input->post('company_id'),
						'staff_name_bangla'=>$this->input->post('fullname_bangla'),
						'joining_date'=>$this->input->post('joining_date'),
						'address'=>$this->input->post('profile_address'),
						'mobile'=>"+88".$this->input->post('mobile2').$this->input->post('mobile3'),
						'national_id'=>$this->input->post('national_id'),
						'blood_group'=>$this->input->post('profile_blood_group'),
						'main_salary'=>$this->input->post('main_salary'),
						'gpf_number'=>$this->input->post('gpf_number'),
						'educational_qualification'=>$this->input->post('educational_qualification'),
						'successor'=>$this->input->post('successor'),
						'bank_account_no'=>$this->input->post('bank_account_no'),
						'marital_status'=>$this->input->post('marital_status'),
						'note'=>$this->input->post('profile_note'),						
						'update_user_id'=>$data['account']->id,
						'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);
				
				$success_or_fail3=$this->general_model->update_table('bgb_staff', $eh_staff_data,'account_id', $staff_id);
				
				
				/*if(!$success_or_fail3)
				{
				echo "3";
				
				exit();
				}*/
				
				$battalion_info=$this->general_model->get_all_table_info_by_id('battalion_and_licence', 'battalion_id', $this->input->post('user_battalion'));
				
				$bgb_user_battalion_map_data=array(
						'battalion_id'=>$this->input->post('user_battalion'),
						'region_id'=>$battalion_info->region_id,
						'sector_id'=>$battalion_info->sector_id,
						'update_user_id'=>$data['account']->id,
						'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())					
						);
				
				$success_or_fail4=$this->general_model->update_table('bgb_user_battalion_map', $bgb_user_battalion_map_data,'account_id', $staff_id);// Update  bgb_user_battalion_map
				 	
				/*if(!$success_or_fail4)
				{
				echo "4";
				
				exit();
				}	*/
				/********** Image upload	********************/
				if(isset($_FILES['staff_picture']) && $_FILES['staff_picture']['size'] > 0)		
				{

				$config['upload_path'] = RES_DIR."/user/profile/";
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '500';
				$config['overwrite'] = 'TRUE';
				$config['maintain_ratio'] = FALSE;
				$config['quality'] = '100%';
				$config['max_width']  = '400';
				$config['max_height']  = '500';
				$config['file_name']  = $staff_id;
			
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('staff_picture'))
					{
						
						$data['error'] = $this->upload->display_errors();								
					}
					else
					{
						$image_data = $this->upload->data();												
						$original_image= $image_data['raw_name'].$image_data['file_ext'];
						
						$config2 = array(
						'source_image' => $image_data['full_path'],
						'new_image' => RES_DIR."/user/profile/",
						'image_name'=> $staff_id,
						'maintain_ratio' => false,
						'overwrite' => true,
						'maintain_ratio' => FALSE,
						'quality' => '100%',
						'width' => 100,
						'height' => 100
						);
						$this->load->library('image_lib');
						$this->image_lib->initialize($config2);
						if ( !$this->image_lib->resize()){
							$data['error'] = $this->image_lib->display_errors('', '');
              				}																		
						
						
						$data['upload_data'] = $this->upload->data();
						
						$image_table=array(						
						'picture'=>$original_image						
						);				
		
					$success_or_fail2=$this->general_model->update_table('a3m_account_details',$image_table,'account_id', $staff_id);	
						
					}															
				
				}
				
				
				
				if($success_or_fail1 || $success_or_fail2 || $success_or_fail3 || $success_or_fail4)
					$data['success_msg']=lang('update_successfully');
				else
					$data['error_msg']=lang('update_unsuccessfull');
					
				$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
				
				$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);	
				$this->load->view('staff/view_edit_single_staff', isset($data) ? $data : NULL);
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
	
	
	public function staff_details_list()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
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
			
			
 		  	$searchterm='SELECT a3m_rel_account_role.account_id,
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
			   bgb_staff.joining_date,
			   bgb_staff.bank_account_no
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
		 WHERE (a3m_rel_account_role.role_id = '.$this->config->item("staff_role_id").')
			   AND(bgb_user_battalion_map.battalion_id IN
						 ('.$comma_separated.')) Order BY create_date desc';
			
			
			//echo $searchterm;
			
			//pagination
			$config = array();
			$config["base_url"] = base_url() . "staff/staff/staff_details_list/";
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
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');	
			$this->load->view('staff/view_staff_user_list_details', isset($data) ? $data : NULL);				
				
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
	
	
	public function staff_details_list_search()
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
			{
			
			
				// assign posted valued
				$data['bank_account_no']    = $this->input->post('bank_account_no');
				$data['battalion_id']     	= $this->input->post('battalion_id');
				$data['staff_id']     		= $this->input->post("staff_id");
				$data['fullname']     		= $this->input->post("fullname");
				$data['gender']     		= $this->input->post("gender");
				$data['mobile']     		= $this->input->post("mobile");
				$data['designation_id']     = $this->input->post("designation_id");
				$data['company_id']     	= $this->input->post("company_id");
				$data['joining_date']     	= $this->input->post("joining_date");
						
				
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
				
				
				$query_string='SELECT a3m_rel_account_role.account_id,
				   a3m_rel_account_role.role_id,
				   bgb_user_battalion_map.battalion_id,
				   a3m_account.id,
				   a3m_account.username,
				   bgb_staff.staff_id,
				   bgb_staff.designation_id,
				   bgb_staff.company_id,
				   bgb_staff.bank_account_no,
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
			 WHERE (a3m_rel_account_role.role_id = '.$this->config->item("staff_role_id").')
				   AND(bgb_user_battalion_map.battalion_id IN
							 ('.$comma_separated.'))';
			
			if($this->input->post("bank_account_no"))	
				{
					$bank_account_no=$this->input->post("bank_account_no"); 
					$query_string=$query_string." AND (bgb_staff.bank_account_no Like '%$bank_account_no%')";
				}				
				
				if($this->input->post("staff_id"))	
				{
					$staff_id=$this->input->post("staff_id"); 
					$query_string=$query_string." AND (bgb_staff.staff_id Like '%$staff_id%')";
				}
				
				if($this->input->post("fullname"))	
				{
					$fullname=$this->input->post("fullname"); 
					$query_string=$query_string." AND (a3m_account_details.fullname Like '%$fullname%')";
				}
				
				if($this->input->post("mobile"))	
				{
					$mobile=$this->input->post("mobile"); 
					$query_string=$query_string." AND (bgb_staff.mobile Like '%$mobile%')";
				}
				
				if($this->input->post("gender"))	
				{
					$gender=$this->input->post("gender"); 
					$query_string=$query_string." AND (a3m_account_details.gender = '$gender')";
				}
				
				if($this->input->post("joining_date"))	
				{
					$joining_date=$this->input->post("joining_date"); 
					$query_string=$query_string." AND (bgb_staff.joining_date = '$joining_date')";
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
			$config["base_url"] = base_url() . "staff/staff/staff_details_list/";
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
			$data['all_battalion'] = $this->site_model->get_all_user_battalion($data['account']->id);
			$data['all_designation'] =$this->general_model->get_all_table_info_asc_desc('bgb_designation', 'designation_name', 'asc');	
			$data['all_company'] =$this->general_model->get_all_table_info_asc_desc('bgb_company', 'company_id', 'asc');			
			$this->load->view('staff/view_staff_user_list_details', isset($data) ? $data : NULL);				
				
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
	
	
	public function edit_staff_salary_allowance($staff_id,$salary_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
			{
			$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
			$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$data['salary_allowance']=$this->general_model->get_all_table_info_by_id('bgb_main_salary', 'salary_id', $salary_id);
			$staff_id_and_salary_id = $staff_id.','.$salary_id;
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
		$this->form_validation->set_rules('season_id',lang('season_name'),'required|callback_account_and_same_season_check_edit['.$staff_id_and_salary_id.']');
			$this->form_validation->set_rules('main_salary', lang('main_salary'), 'required|numeric');	
			$this->form_validation->set_rules('house_rent', lang('house_rent'), 'numeric');
			$this->form_validation->set_rules('treatment_allowance', lang('treatment_allowance'), 'numeric');
			$this->form_validation->set_rules('transportation_allowance', lang('transportation_allowance'), 'numeric');
			$this->form_validation->set_rules('border_allowance', lang('border_allowance'), 'numeric');
			$this->form_validation->set_rules('tiffin_allowance', lang('tiffin_allowance'), 'numeric');
			$this->form_validation->set_rules('mountains_allowance', lang('mountains_allowance'), 'numeric');
			$this->form_validation->set_rules('education_help_allowance', lang('education_help_allowance'), 'numeric');
			$this->form_validation->set_rules('costly_allowance', lang('costly_allowance'), 'numeric');
			$this->form_validation->set_rules('servant_allowance', lang('servant_allowance'), 'numeric');
			$this->form_validation->set_rules('employee_allowance', lang('employee_allowance'), 'numeric');
			$this->form_validation->set_rules('washed_allowance', lang('washed_allowance'), 'numeric');
			$this->form_validation->set_rules('barber_allowance', lang('barber_allowance'), 'numeric');
			$this->form_validation->set_rules('fuller_allowance', lang('fuller_allowance'), 'numeric');
			$this->form_validation->set_rules('leave_allowance', lang('leave_allowance'), 'numeric');
			$this->form_validation->set_rules('ration_allowance', lang('ration_allowance'), 'numeric');
			$this->form_validation->set_rules('new_year_allowance', lang('new_year_allowance'), 'numeric');
			
			$this->form_validation->set_rules('time_scale', lang('time_scale'), 'numeric');
			$this->form_validation->set_rules('earn_leave', lang('earn_leave'), 'numeric');
			$this->form_validation->set_rules('festival_allowance', lang('festival_allowance'), 'numeric');
			$this->form_validation->set_rules('entertainment_allowance', lang('entertainment_allowance'), 'numeric');
			$this->form_validation->set_rules('gpf_advanced', lang('gpf_advanced'), 'numeric');
			$this->form_validation->set_rules('subsidiary_salary_or_allowance', lang('subsidiary_salary_or_allowance'), 'numeric');
			$this->form_validation->set_rules('honorary_allowance', lang('honorary_allowance'), 'numeric');
			
			
				if ($this->form_validation->run() == FALSE)
				{				
				$this->load->view('staff/view_edit_staff_salary_allowance', isset($data) ? $data : NULL);
				}
				else
				{			
				$house_rent=$this->input->post('house_rent'); $house_rent  = empty($house_rent) ? NULL : $house_rent;
				$treatment_allowance=$this->input->post('treatment_allowance'); $treatment_allowance  = empty($treatment_allowance) ? NULL : $treatment_allowance;
				$transportation_allowance=$this->input->post('transportation_allowance'); $transportation_allowance  = empty($transportation_allowance) ? NULL : $transportation_allowance;
				$border_allowance=$this->input->post('border_allowance'); $border_allowance  = empty($border_allowance) ? NULL : $border_allowance;
				$tiffin_allowance=$this->input->post('tiffin_allowance'); $tiffin_allowance  = empty($tiffin_allowance) ? NULL : $tiffin_allowance;
				$mountains_allowance=$this->input->post('mountains_allowance'); $mountains_allowance  = empty($mountains_allowance) ? NULL : $mountains_allowance;								
				$education_help_allowance=$this->input->post('education_help_allowance'); $education_help_allowance  = empty($education_help_allowance) ? NULL : $education_help_allowance;
				$costly_allowance=$this->input->post('costly_allowance'); $costly_allowance  = empty($costly_allowance) ? NULL : $costly_allowance;
				$servant_allowance=$this->input->post('servant_allowance'); $servant_allowance  = empty($servant_allowance) ? NULL : $servant_allowance;
				$employee_allowance=$this->input->post('employee_allowance'); $employee_allowance  = empty($employee_allowance) ? NULL : $employee_allowance;
				$washed_allowance=$this->input->post('washed_allowance'); $washed_allowance  = empty($washed_allowance) ? NULL : $washed_allowance;
				$barber_allowance=$this->input->post('barber_allowance'); $barber_allowance  = empty($barber_allowance) ? NULL : $barber_allowance;
				$fuller_allowance=$this->input->post('fuller_allowance'); $fuller_allowance  = empty($fuller_allowance) ? NULL : $fuller_allowance;
				$leave_allowance=$this->input->post('leave_allowance'); $leave_allowance  = empty($leave_allowance) ? NULL : $leave_allowance;
				$ration_allowance=$this->input->post('ration_allowance'); $ration_allowance  = empty($ration_allowance) ? NULL : $ration_allowance;
				$new_year_allowance=$this->input->post('new_year_allowance'); $new_year_allowance  = empty($new_year_allowance) ? NULL : $new_year_allowance;
				
				$time_scale=$this->input->post('time_scale'); $time_scale  = empty($time_scale) ? NULL : $time_scale;
				$earn_leave=$this->input->post('earn_leave'); $earn_leave= empty($earn_leave) ? NULL : $earn_leave;
				$festival_allowance=$this->input->post('festival_allowance'); $festival_allowance=empty($festival_allowance) ? NULL : $festival_allowance;
				$entertainment_allowance=$this->input->post('entertainment_allowance'); $entertainment_allowance=empty($entertainment_allowance) ? NULL : $entertainment_allowance;
				$gpf_advanced=$this->input->post('gpf_advanced'); $gpf_advanced=empty($gpf_advanced) ? NULL : $gpf_advanced;
				$subsidiary_salary_or_allowance=$this->input->post('subsidiary_salary_or_allowance'); $subsidiary_salary_or_allowance=empty($subsidiary_salary_or_allowance) ? NULL : $subsidiary_salary_or_allowance;
				$honorary_allowance=$this->input->post('honorary_allowance'); $honorary_allowance=empty($honorary_allowance) ? NULL : $honorary_allowance;
				$gpf_number=$this->input->post('gpf_number'); $gpf_number=empty($gpf_number) ? NULL : $gpf_number;
				$extra_field_1=$this->input->post('extra_field_1'); $extra_field_1=empty($extra_field_1) ? NULL : $extra_field_1;
				$extra_field_2=$this->input->post('extra_field_2'); $extra_field_2=empty($extra_field_2) ? NULL : $extra_field_2;
				$extra_field_3=$this->input->post('extra_field_3'); $extra_field_3=empty($extra_field_3) ? NULL : $extra_field_3;
				
				$bgb_salary_data=array(
						'account_id'=>$staff_id,
						'season_id'=>$this->input->post('season_id'),
						'main_salary'=>$this->input->post('main_salary'),
						'house_rent'=>$house_rent,
						'treatment_allowance'=>$treatment_allowance,
						'transportation_allowance'=>$transportation_allowance,
						'border_allowance'=>$border_allowance,
						'tiffin_allowance'=>$tiffin_allowance,
						'mountains_allowance'=>$mountains_allowance,
						'education_help_allowance'=>$education_help_allowance,	
						'costly_allowance'=>$costly_allowance,
						'servant_allowance'=>$servant_allowance,
						'employee_allowance'=>$employee_allowance,
						'washed_allowance'=>$washed_allowance,
						'barber_allowance'=>$barber_allowance,
						'fuller_allowance'=>$fuller_allowance,
						'leave_allowance'=>$leave_allowance,
						'ration_allowance'=>$ration_allowance,
						'new_year_allowance'=>$new_year_allowance,						
						'time_scale' => $time_scale,
						'earn_leave' =>$earn_leave,
						'festival_allowance' => $festival_allowance,
						'entertainment_allowance' => $entertainment_allowance,
						'gpf_advanced' => $gpf_advanced,
						'subsidiary_salary_or_allowance' => $subsidiary_salary_or_allowance,
						'honorary_allowance' => $honorary_allowance,												
						'gpf_number'=>$gpf_number,
						'extra_field_1'=>$extra_field_1,
						'extra_field_2'=>$extra_field_2,
						'extra_field_3'=>$extra_field_3,
						'create_user_id'=>$data['account']->id,
						'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);
				
				
				$success_or_fail=$this->general_model->update_table('bgb_main_salary', $bgb_salary_data,'salary_id',$salary_id);
				
				if($success_or_fail)
					$data['success_msg']=lang('update_successfully');
				else
					$data['error_msg']=lang('update_unsuccessfull');
				$data['salary_allowance']=$this->general_model->get_all_table_info_by_id('bgb_main_salary', 'salary_id', $salary_id);	
				$this->load->view('staff/view_edit_staff_salary_allowance', isset($data) ? $data : NULL);	
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "staff_management" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}
	
	
	public function add_staff_salary_allowance($staff_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('staff_management'))
			{
			$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
			$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
			$data['season_info']=$this->general_model->get_all_table_info_by_id_asc_desc('bgb_season', 'season_status', 1, 'season_id', 'desc');
			$current_season_array=$this->general_model->get_all_table_info_by_id('bgb_season', 'current_season', 'Yes');
			$current_season=$current_season_array->season_id; 
			//echo $current_season; 
			if($current_season>1)
			{
			$previous_season=$current_season-1;	
			$query="Select * FROM bgb_main_salary WHERE account_id=".$staff_id." AND season_id=".$previous_season;
			$data['previous_season_salary_info']=$this->general_model->get_all_single_row_querystring($query);
			//print_r($data['previous_season_salary_info']);
			}
			
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');				
			$this->form_validation->set_rules('season_id', lang('season_name'), 'required|callback_account_and_same_season_check['.$staff_id.']');
			$this->form_validation->set_rules('main_salary', lang('main_salary'), 'required|numeric');	
			$this->form_validation->set_rules('house_rent', lang('house_rent'), 'numeric');
			$this->form_validation->set_rules('treatment_allowance', lang('treatment_allowance'), 'numeric');
			$this->form_validation->set_rules('transportation_allowance', lang('transportation_allowance'), 'numeric');
			$this->form_validation->set_rules('border_allowance', lang('border_allowance'), 'numeric');
			$this->form_validation->set_rules('tiffin_allowance', lang('tiffin_allowance'), 'numeric');
			$this->form_validation->set_rules('mountains_allowance', lang('mountains_allowance'), 'numeric');
			$this->form_validation->set_rules('education_help_allowance', lang('education_help_allowance'), 'numeric');
			$this->form_validation->set_rules('costly_allowance', lang('costly_allowance'), 'numeric');
			$this->form_validation->set_rules('servant_allowance', lang('servant_allowance'), 'numeric');
			$this->form_validation->set_rules('employee_allowance', lang('employee_allowance'), 'numeric');
			$this->form_validation->set_rules('washed_allowance', lang('washed_allowance'), 'numeric');
			$this->form_validation->set_rules('barber_allowance', lang('barber_allowance'), 'numeric');
			$this->form_validation->set_rules('fuller_allowance', lang('fuller_allowance'), 'numeric');
			$this->form_validation->set_rules('leave_allowance', lang('leave_allowance'), 'numeric');
			$this->form_validation->set_rules('ration_allowance', lang('ration_allowance'), 'numeric');
			$this->form_validation->set_rules('new_year_allowance', lang('new_year_allowance'), 'numeric');
			
			$this->form_validation->set_rules('time_scale', lang('time_scale'), 'numeric');
			$this->form_validation->set_rules('earn_leave', lang('earn_leave'), 'numeric');
			$this->form_validation->set_rules('festival_allowance', lang('festival_allowance'), 'numeric');
			$this->form_validation->set_rules('entertainment_allowance', lang('entertainment_allowance'), 'numeric');
			$this->form_validation->set_rules('gpf_advanced', lang('gpf_advanced'), 'numeric');
			$this->form_validation->set_rules('subsidiary_salary_or_allowance', lang('subsidiary_salary_or_allowance'), 'numeric');
			$this->form_validation->set_rules('honorary_allowance', lang('honorary_allowance'), 'numeric');
			
				if ($this->form_validation->run() == FALSE)
				{				
				$this->load->view('staff/view_add_staff_salary_allowance', isset($data) ? $data : NULL);
				}
				else
				{			
				$house_rent=$this->input->post('house_rent'); $house_rent  = empty($house_rent) ? NULL : $house_rent;
				$treatment_allowance=$this->input->post('treatment_allowance'); $treatment_allowance  = empty($treatment_allowance) ? NULL : $treatment_allowance;
				$transportation_allowance=$this->input->post('transportation_allowance'); $transportation_allowance  = empty($transportation_allowance) ? NULL : $transportation_allowance;
				$border_allowance=$this->input->post('border_allowance'); $border_allowance  = empty($border_allowance) ? NULL : $border_allowance;
				$tiffin_allowance=$this->input->post('tiffin_allowance'); $tiffin_allowance  = empty($tiffin_allowance) ? NULL : $tiffin_allowance;
				$mountains_allowance=$this->input->post('mountains_allowance'); $mountains_allowance  = empty($mountains_allowance) ? NULL : $mountains_allowance;
				$education_help_allowance=$this->input->post('education_help_allowance'); $education_help_allowance  = empty($education_help_allowance) ? NULL : $education_help_allowance;
				$costly_allowance=$this->input->post('costly_allowance'); $costly_allowance  = empty($costly_allowance) ? NULL : $costly_allowance;
				$servant_allowance=$this->input->post('servant_allowance'); $servant_allowance  = empty($servant_allowance) ? NULL : $servant_allowance;
				$employee_allowance=$this->input->post('employee_allowance'); $employee_allowance  = empty($employee_allowance) ? NULL : $employee_allowance;
				$washed_allowance=$this->input->post('washed_allowance'); $washed_allowance  = empty($washed_allowance) ? NULL : $washed_allowance;
				$barber_allowance=$this->input->post('barber_allowance'); $barber_allowance  = empty($barber_allowance) ? NULL : $barber_allowance;
				$fuller_allowance=$this->input->post('fuller_allowance'); $fuller_allowance  = empty($fuller_allowance) ? NULL : $fuller_allowance;
				$leave_allowance=$this->input->post('leave_allowance'); $leave_allowance  = empty($leave_allowance) ? NULL : $leave_allowance;
				$ration_allowance=$this->input->post('ration_allowance'); $ration_allowance  = empty($ration_allowance) ? NULL : $ration_allowance;
				$new_year_allowance=$this->input->post('new_year_allowance'); $new_year_allowance  = empty($new_year_allowance) ? NULL : $new_year_allowance;
				
				$time_scale=$this->input->post('time_scale'); $time_scale  = empty($time_scale) ? NULL : $time_scale;
				$earn_leave=$this->input->post('earn_leave'); $earn_leave= empty($earn_leave) ? NULL : $earn_leave;
				$festival_allowance=$this->input->post('festival_allowance'); $festival_allowance=empty($festival_allowance) ? NULL : $festival_allowance;
				$entertainment_allowance=$this->input->post('entertainment_allowance'); $entertainment_allowance=empty($entertainment_allowance) ? NULL : $entertainment_allowance;
				$gpf_advanced=$this->input->post('gpf_advanced'); $gpf_advanced=empty($gpf_advanced) ? NULL : $gpf_advanced;
				$subsidiary_salary_or_allowance=$this->input->post('subsidiary_salary_or_allowance'); $subsidiary_salary_or_allowance=empty($subsidiary_salary_or_allowance) ? NULL : $subsidiary_salary_or_allowance;
				$honorary_allowance=$this->input->post('honorary_allowance'); $honorary_allowance=empty($honorary_allowance) ? NULL : $honorary_allowance;
				$gpf_number=$this->input->post('gpf_number'); $gpf_number=empty($gpf_number) ? NULL : $gpf_number;
				$extra_field_1=$this->input->post('extra_field_1'); $extra_field_1=empty($extra_field_1) ? NULL : $extra_field_1;
				$extra_field_2=$this->input->post('extra_field_2'); $extra_field_2=empty($extra_field_2) ? NULL : $extra_field_2;
				$extra_field_3=$this->input->post('extra_field_3'); $extra_field_3=empty($extra_field_3) ? NULL : $extra_field_3;
				
				$bgb_salary_data=array(
						'account_id'=>$staff_id,
						'season_id'=>$this->input->post('season_id'),
						'main_salary'=>$this->input->post('main_salary'),
						'house_rent'=>$house_rent,
						'treatment_allowance'=>$treatment_allowance,
						'transportation_allowance'=>$transportation_allowance,
						'border_allowance'=>$border_allowance,
						'tiffin_allowance'=>$tiffin_allowance,
						'mountains_allowance'=>$mountains_allowance,
						'education_help_allowance'=>$education_help_allowance,	
						'costly_allowance'=>$costly_allowance,
						'servant_allowance'=>$servant_allowance,
						'employee_allowance'=>$employee_allowance,
						'washed_allowance'=>$washed_allowance,
						'barber_allowance'=>$barber_allowance,
						'fuller_allowance'=>$fuller_allowance,
						'leave_allowance'=>$leave_allowance,
						'ration_allowance'=>$ration_allowance,
						'new_year_allowance'=>$new_year_allowance,
						
						'time_scale' => $time_scale,
						'earn_leave' =>$earn_leave,
						'festival_allowance' => $festival_allowance,
						'entertainment_allowance' => $entertainment_allowance,
						'gpf_advanced' => $gpf_advanced,
						'subsidiary_salary_or_allowance' => $subsidiary_salary_or_allowance,
						'honorary_allowance' => $honorary_allowance,
						
						'gpf_number'=>$gpf_number,
						'extra_field_1'=>$extra_field_1,
						'extra_field_2'=>$extra_field_2,
						'extra_field_3'=>$extra_field_3,						
						'create_user_id'=>$data['account']->id,
						'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);
				
				$success_or_fail=$this->general_model->save_into_table('bgb_main_salary', $bgb_salary_data);
				
				if($success_or_fail)
					$data['success_msg']=lang('saveed_successfully');
				else
					$data['error_msg']=lang('save_unsuccessfull');
					
				$this->load->view('staff/view_add_staff_salary_allowance', isset($data) ? $data : NULL);
				redirect('staff/staff/view_single_staff_profile/'.$staff_id."/#checkup");
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "staff_management" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}
	
	
	public function add_staff_salary_excision($staff_id,$salary_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('add_salary_excision'))
			{
			$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
			$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
			$salary_allowance_info=$this->general_model->get_all_table_info_by_id('bgb_main_salary','salary_id', $salary_id);
			$data['season_id']=$salary_allowance_info->season_id;
			
			
			$current_season_array=$this->general_model->get_all_table_info_by_id('bgb_season', 'current_season', 'Yes');
			$current_season=$current_season_array->season_id; 
			//echo $current_season; 
			if($current_season>1)
			{
			$previous_season=$current_season-1;	
			$query="Select * FROM bgb_main_excision WHERE account_id=".$staff_id." AND season_id=".$previous_season;
			$data['previous_season_salary_info']=$this->general_model->get_all_single_row_querystring($query);
			//print_r($data['previous_season_salary_info']);
			}
			
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');				
			
			$this->form_validation->set_rules('gpf_excision', lang('gpf_excision'), 'required|numeric');
			$this->form_validation->set_rules('gpf_payment', lang('gpf_payment'), 'numeric');
			$this->form_validation->set_rules('house_building_excision', lang('house_building_excision'), 'numeric');
			$this->form_validation->set_rules('house_building_interest', lang('house_building_interest'), 'numeric');
			$this->form_validation->set_rules('miscellaneous_excision', lang('miscellaneous_excision'), 'numeric');
			$this->form_validation->set_rules('motorcycle_excision', lang('motorcycle_excision'), 'numeric');
			$this->form_validation->set_rules('additional_house_rent_excision', lang('additional_house_rent_excision'), 'numeric');
			
			$this->form_validation->set_rules('income_tax', lang('income_tax'), 'numeric');
			$this->form_validation->set_rules('extra_salary_excision', lang('extra_salary_excision'), 'numeric');
			
			$this->form_validation->set_rules('ration_subsidy', lang('ration_subsidy'), 'numeric');
			$this->form_validation->set_rules('rc_fresh', lang('rc_fresh'), 'numeric');
			$this->form_validation->set_rules('rc_dry', lang('rc_dry'), 'numeric');
			$this->form_validation->set_rules('battalion_loan', lang('battalion_loan'), 'numeric');
			$this->form_validation->set_rules('rc_bgb_fresh', lang('rc_bgb_fresh'), 'numeric');
			$this->form_validation->set_rules('rc_bgb_dry', lang('rc_bgb_dry'), 'numeric');			
			$this->form_validation->set_rules('spice_excision', lang('spice_excision'), 'numeric');
			$this->form_validation->set_rules('barber_excision', lang('barber_excision'), 'numeric');
			$this->form_validation->set_rules('fuller_excision', lang('fuller_excision'), 'numeric');
			$this->form_validation->set_rules('washed_allowance_excision', lang('washed_allowance_excision'), 'numeric');
			$this->form_validation->set_rules('bgb_health_support_subscription', lang('bgb_health_support_subscription'), 'numeric');
			
			$this->form_validation->set_rules('extra_field_1', lang('extra_field_1'));
			$this->form_validation->set_rules('extra_field_2', lang('extra_field_2'));
			$this->form_validation->set_rules('extra_field_3', lang('extra_field_3'));
			$this->form_validation->set_rules('extra_field_4', lang('extra_field_4'));
			$this->form_validation->set_rules('extra_field_5', lang('extra_field_5'));
			$this->form_validation->set_rules('extra_field_6', lang('extra_field_6'));
			
			
				if ($this->form_validation->run() == FALSE)
				{				
				$this->load->view('staff/view_add_staff_salary_excision', isset($data) ? $data : NULL);
				}
				else
				{			
				
				$gpf_excision=$this->input->post('gpf_excision'); $gpf_excision= empty($gpf_excision) ? NULL : $gpf_excision;
				$gpf_payment=$this->input->post('gpf_payment'); $gpf_payment= empty($gpf_payment) ? NULL : $gpf_payment;
				
				$house_building_excision=$this->input->post('house_building_excision'); $house_building_excision= empty($house_building_excision) ? NULL : $house_building_excision;
				$house_building_interest=$this->input->post('house_building_interest');$house_building_interest= empty($house_building_interest) ? NULL : $house_building_interest;
				$miscellaneous_excision=$this->input->post('miscellaneous_excision'); $miscellaneous_excision= empty($miscellaneous_excision) ? NULL : $miscellaneous_excision;
				$motorcycle_excision=$this->input->post('motorcycle_excision'); $motorcycle_excision= empty($motorcycle_excision) ? NULL : $motorcycle_excision;			 			
				$additional_house_rent_excision=$this->input->post('additional_house_rent_excision'); $additional_house_rent_excision= empty($additional_house_rent_excision) ? NULL : $additional_house_rent_excision;
				
				$income_tax=$this->input->post('income_tax'); $income_tax= empty($income_tax) ? NULL : $income_tax;
				$extra_salary_excision=$this->input->post('extra_salary_excision'); $extra_salary_excision= empty($extra_salary_excision) ? NULL : $extra_salary_excision;
				
				$ration_subsidy=$this->input->post('ration_subsidy'); $ration_subsidy= empty($ration_subsidy) ? NULL : $ration_subsidy;
				$spice_excision=$this->input->post('spice_excision'); $spice_excision= empty($spice_excision) ? NULL : $spice_excision;	 					
				$rc_fresh=$this->input->post('rc_fresh'); $rc_fresh= empty($rc_fresh) ? NULL : $rc_fresh;
				$rc_dry=$this->input->post('rc_dry'); $rc_dry= empty($rc_dry) ? NULL : $rc_dry;
				$battalion_loan=$this->input->post('battalion_loan'); $battalion_loan= empty($battalion_loan) ? NULL : $battalion_loan;
				$barber_excision=$this->input->post('barber_excision'); $barber_excision= empty($barber_excision) ? NULL : $barber_excision;	
				$fuller_excision=$this->input->post('fuller_excision'); $fuller_excision= empty($fuller_excision) ? NULL : $fuller_excision;
				$washed_allowance_excision=$this->input->post('washed_allowance_excision'); $washed_allowance_excision= empty($washed_allowance_excision) ? NULL : $washed_allowance_excision;
				$rc_bgb_fresh=$this->input->post('rc_bgb_fresh'); $rc_bgb_fresh= empty($rc_bgb_fresh) ? NULL : $rc_bgb_fresh;
				$rc_bgb_dry=$this->input->post('rc_bgb_dry'); $rc_bgb_dry= empty($rc_bgb_dry) ? NULL : $rc_bgb_dry;					
				$bgb_health_support_subscription=$this->input->post('bgb_health_support_subscription'); $bgb_health_support_subscription= empty($bgb_health_support_subscription) ? NULL : $bgb_health_support_subscription;
				$extra_field_1=$this->input->post('extra_field_1'); $extra_field_1= empty($extra_field_1) ? NULL : $extra_field_1;
				$extra_field_2=$this->input->post('extra_field_2'); $extra_field_2= empty($extra_field_2) ? NULL : $extra_field_2;
				$extra_field_3=$this->input->post('extra_field_3'); $extra_field_3= empty($extra_field_3) ? NULL : $extra_field_3;	 					
				$extra_field_4=$this->input->post('extra_field_4'); $extra_field_4= empty($extra_field_4) ? NULL : $extra_field_4;
				$extra_field_5=$this->input->post('extra_field_5'); $extra_field_5= empty($extra_field_5) ? NULL : $extra_field_5;
				$extra_field_6=$this->input->post('extra_field_6'); $extra_field_6= empty($extra_field_6) ? NULL : $extra_field_6;
				
				
				
				$bgb_salary_data=array(
						'salary_id'=>$salary_id,			   
						'account_id'=>$staff_id,
						'season_id'=>$data['season_id'],
						'gpf_excision'=>$gpf_excision,
						'gpf_payment'=>$gpf_payment,
						'house_building_excision'=>$house_building_excision,
						'house_building_interest'=>$house_building_interest,
						'miscellaneous_excision'=>$miscellaneous_excision,
						'motorcycle_excision'=>$motorcycle_excision,						
						'additional_house_rent_excision'=>$additional_house_rent_excision,
						'income_tax'=>$income_tax,
						'extra_salary_excision'=>$extra_salary_excision,
						'ration_subsidy'=>$ration_subsidy,
						'spice_excision'=>$spice_excision,						
						'rc_fresh'=>$rc_fresh,
						'rc_dry'=>$rc_dry,
						'battalion_loan'=>$battalion_loan,						
						'barber_excision'=>$barber_excision,	
						'fuller_excision'=>$fuller_excision,
						'washed_allowance_excision'=>$washed_allowance_excision,
						'rc_bgb_fresh'=>$rc_bgb_fresh,
						'rc_bgb_dry'=>$rc_bgb_dry,						
						'bgb_health_support_subscription'=>$bgb_health_support_subscription,
						'extra_field_1'=>$extra_field_1,
						'extra_field_2'=>$extra_field_2,
						'extra_field_3'=>$extra_field_3,						
						'extra_field_4'=>$extra_field_4,
						'extra_field_5'=>$extra_field_5,
						'extra_field_6'=>$extra_field_6,						
						'create_user_id'=>$data['account']->id,
						'create_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);
				
				$success_or_fail=$this->general_model->save_into_table('bgb_main_excision', $bgb_salary_data);
				
				if($success_or_fail)
					$data['success_msg']=lang('saveed_successfully');
				else
					$data['error_msg']=lang('save_unsuccessfull');
					
				$this->load->view('staff/view_add_staff_salary_excision', isset($data) ? $data : NULL);	
				redirect('staff/staff/view_single_staff_profile/'.$staff_id."/#checkup");
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "staff_management" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}



	public function edit_staff_salary_excision($staff_id,$salary_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('add_salary_excision'))
			{
			$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
			$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
			//$salary_allowance_info=$this->general_model->get_all_table_info_by_id('bgb_main_salary','salary_id', $salary_id);
			//$data['season_id']=$salary_allowance_info->season_id;
			
			$data['salary_excision_info']=$this->general_model->get_all_table_info_by_id('bgb_main_excision','salary_id', $salary_id);
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');				
			
			$this->form_validation->set_rules('gpf_excision', lang('gpf_excision'), 'required|numeric');
			$this->form_validation->set_rules('gpf_payment', lang('gpf_payment'), 'numeric');
			$this->form_validation->set_rules('house_building_excision', lang('house_building_excision'), 'numeric');
			$this->form_validation->set_rules('house_building_interest', lang('house_building_interest'), 'numeric');
			$this->form_validation->set_rules('miscellaneous_excision', lang('miscellaneous_excision'), 'numeric');
			$this->form_validation->set_rules('motorcycle_excision', lang('motorcycle_excision'), 'numeric');
			$this->form_validation->set_rules('additional_house_rent_excision', lang('additional_house_rent_excision'), 'numeric');
			$this->form_validation->set_rules('income_tax', lang('income_tax'), 'numeric');
			$this->form_validation->set_rules('extra_salary_excision', lang('extra_salary_excision'), 'numeric');
			$this->form_validation->set_rules('ration_subsidy', lang('ration_subsidy'), 'numeric');
			$this->form_validation->set_rules('rc_fresh', lang('rc_fresh'), 'numeric');
			$this->form_validation->set_rules('rc_dry', lang('rc_dry'), 'numeric');
			$this->form_validation->set_rules('battalion_loan', lang('battalion_loan'), 'numeric');
			$this->form_validation->set_rules('rc_bgb_fresh', lang('rc_bgb_fresh'), 'numeric');
			$this->form_validation->set_rules('rc_bgb_dry', lang('rc_bgb_dry'), 'numeric');
			$this->form_validation->set_rules('spice_excision', lang('spice_excision'), 'numeric');
			$this->form_validation->set_rules('barber_excision', lang('barber_excision'), 'numeric');
			$this->form_validation->set_rules('fuller_excision', lang('fuller_excision'), 'numeric');
			$this->form_validation->set_rules('washed_allowance_excision', lang('washed_allowance_excision'), 'numeric');
			$this->form_validation->set_rules('bgb_health_support_subscription', lang('bgb_health_support_subscription'), 'numeric');
			$this->form_validation->set_rules('extra_field_1', lang('extra_field_1'));
			$this->form_validation->set_rules('extra_field_2', lang('extra_field_2'));
			$this->form_validation->set_rules('extra_field_3', lang('extra_field_3'));
			$this->form_validation->set_rules('extra_field_4', lang('extra_field_4'));
			$this->form_validation->set_rules('extra_field_5', lang('extra_field_5'));
			$this->form_validation->set_rules('extra_field_6', lang('extra_field_6'));
			
			
				if ($this->form_validation->run() == FALSE)
				{				
				$this->load->view('staff/view_edit_staff_salary_excision', isset($data) ? $data : NULL);
				}
				else
				{			
				
				$gpf_excision=$this->input->post('gpf_excision'); $gpf_excision= empty($gpf_excision) ? NULL : $gpf_excision;
				$gpf_payment=$this->input->post('gpf_payment'); $gpf_payment= empty($gpf_payment) ? NULL : $gpf_payment;
				$house_building_excision=$this->input->post('house_building_excision'); $house_building_excision= empty($house_building_excision) ? NULL : $house_building_excision;
				$house_building_interest=$this->input->post('house_building_interest');$house_building_interest= empty($house_building_interest) ? NULL : $house_building_interest;
				$miscellaneous_excision=$this->input->post('miscellaneous_excision'); $miscellaneous_excision= empty($miscellaneous_excision) ? NULL : $miscellaneous_excision;
				$motorcycle_excision=$this->input->post('motorcycle_excision'); $motorcycle_excision= empty($motorcycle_excision) ? NULL : $motorcycle_excision;			 			
				$additional_house_rent_excision=$this->input->post('additional_house_rent_excision'); $additional_house_rent_excision= empty($additional_house_rent_excision) ? NULL : $additional_house_rent_excision;
				
				$income_tax=$this->input->post('income_tax'); $income_tax= empty($income_tax) ? NULL : $income_tax;
				$extra_salary_excision=$this->input->post('extra_salary_excision'); $extra_salary_excision= empty($extra_salary_excision) ? NULL : $extra_salary_excision;
				
				$ration_subsidy=$this->input->post('ration_subsidy'); $ration_subsidy= empty($ration_subsidy) ? NULL : $ration_subsidy;
				$spice_excision=$this->input->post('spice_excision'); $spice_excision= empty($spice_excision) ? NULL : $spice_excision;	 					
				$rc_fresh=$this->input->post('rc_fresh'); $rc_fresh= empty($rc_fresh) ? NULL : $rc_fresh;
				$rc_dry=$this->input->post('rc_dry'); $rc_dry= empty($rc_dry) ? NULL : $rc_dry;
				$battalion_loan=$this->input->post('battalion_loan'); $battalion_loan= empty($battalion_loan) ? NULL : $battalion_loan;
				$barber_excision=$this->input->post('barber_excision'); $barber_excision= empty($barber_excision) ? NULL : $barber_excision;	
				$fuller_excision=$this->input->post('fuller_excision'); $fuller_excision= empty($fuller_excision) ? NULL : $fuller_excision;
				$washed_allowance_excision=$this->input->post('washed_allowance_excision'); $washed_allowance_excision= empty($washed_allowance_excision) ? NULL : $washed_allowance_excision;
				$rc_bgb_fresh=$this->input->post('rc_bgb_fresh'); $rc_bgb_fresh= empty($rc_bgb_fresh) ? NULL : $rc_bgb_fresh;
				$rc_bgb_dry=$this->input->post('rc_bgb_dry'); $rc_bgb_dry= empty($rc_bgb_dry) ? NULL : $rc_bgb_dry;					
				$bgb_health_support_subscription=$this->input->post('bgb_health_support_subscription'); $bgb_health_support_subscription= empty($bgb_health_support_subscription) ? NULL : $bgb_health_support_subscription;
				$extra_field_1=$this->input->post('extra_field_1'); $extra_field_1= empty($extra_field_1) ? NULL : $extra_field_1;
				$extra_field_2=$this->input->post('extra_field_2'); $extra_field_2= empty($extra_field_2) ? NULL : $extra_field_2;
				$extra_field_3=$this->input->post('extra_field_3'); $extra_field_3= empty($extra_field_3) ? NULL : $extra_field_3;	 					
				$extra_field_4=$this->input->post('extra_field_4'); $extra_field_4= empty($extra_field_4) ? NULL : $extra_field_4;
				$extra_field_5=$this->input->post('extra_field_5'); $extra_field_5= empty($extra_field_5) ? NULL : $extra_field_5;
				$extra_field_6=$this->input->post('extra_field_6'); $extra_field_6= empty($extra_field_6) ? NULL : $extra_field_6;
				
				
				$bgb_salary_data=array(							   						
						'gpf_excision'=>$gpf_excision,
						'gpf_payment'=>$gpf_payment,
						'house_building_excision'=>$house_building_excision,
						'house_building_interest'=>$house_building_interest,
						'miscellaneous_excision'=>$miscellaneous_excision,
						'motorcycle_excision'=>$motorcycle_excision,						
						'additional_house_rent_excision'=>$additional_house_rent_excision,
						'income_tax'=>$income_tax,
						'extra_salary_excision'=>$extra_salary_excision,
						'ration_subsidy'=>$ration_subsidy,
						'spice_excision'=>$spice_excision,						
						'rc_fresh'=>$rc_fresh,
						'rc_dry'=>$rc_dry,
						'battalion_loan'=>$battalion_loan,						
						'barber_excision'=>$barber_excision,	
						'fuller_excision'=>$fuller_excision,
						'washed_allowance_excision'=>$washed_allowance_excision,
						'rc_bgb_fresh'=>$rc_bgb_fresh,
						'rc_bgb_dry'=>$rc_bgb_dry,						
						'bgb_health_support_subscription'=>$bgb_health_support_subscription,
						'extra_field_1'=>$extra_field_1,
						'extra_field_2'=>$extra_field_2,
						'extra_field_3'=>$extra_field_3,						
						'extra_field_4'=>$extra_field_4,
						'extra_field_5'=>$extra_field_5,
						'extra_field_6'=>$extra_field_6,						
						'update_user_id'=>$data['account']->id,
						'update_date'=>mdate('%Y-%m-%d %H:%i:%s', now())						
						);
				
				$success_or_fail=$this->general_model->update_table('bgb_main_excision', $bgb_salary_data,'salary_id',$salary_id);
				
				if($success_or_fail)
					$data['success_msg']=lang('update_successfully');
				else
					$data['error_msg']=lang('update_unsuccessfull');
				$data['salary_excision_info']=$this->general_model->get_all_table_info_by_id('bgb_main_excision','salary_id', $salary_id);	
				$this->load->view('staff/view_edit_staff_salary_excision', isset($data) ? $data : NULL);	
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "staff_management" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}

	public function view_staff_salary($staff_id,$salary_id)
	{
		if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			
			if($this->authorization->is_permitted('print_staff_salary'))
			{
			if($this->general_model->have_access($data['account']->id,$staff_id))
				{	
				$query='SELECT a3m_account.*,
				   a3m_account_details.*,
				   bgb_staff.*,
				   a3m_account.id,
				   bgb_user_battalion_map.*
			  FROM    (   (   a3m_account a3m_account
						   INNER JOIN
							  bgb_user_battalion_map bgb_user_battalion_map
						   ON (a3m_account.id = bgb_user_battalion_map.account_id))
					   INNER JOIN
						  a3m_account_details a3m_account_details
					   ON (a3m_account.id = a3m_account_details.account_id))
				   INNER JOIN
					  bgb_staff bgb_staff
				   ON (a3m_account.id = bgb_staff.account_id)
			 WHERE (a3m_account.id ='.$staff_id.')';
				$data['staff_info']=$this->general_model-> get_all_single_row_querystring($query);
			//$salary_allowance_info=$this->general_model->get_all_table_info_by_id('bgb_main_salary','salary_id', $salary_id);
			//$data['season_id']=$salary_allowance_info->season_id;
			
				$data['salary_excision_info']=$this->general_model->get_all_table_info_by_id('bgb_main_excision','salary_id', $salary_id);
				$data['salary_allowance']=$this->general_model->get_all_table_info_by_id('bgb_main_salary', 'salary_id', $salary_id);
							
				$this->load->view('staff/view_staff_salary', isset($data) ? $data : NULL);						
				}
				else
				{
				$data['title'] = "No Access";	
				$data['msg'] = lang('no_access_permission');
				$this->load->view('view_no_access', isset($data) ? $data : NULL);
				}
			}
			else
			{
			redirect('./dashboard');  // if not permitted "staff_management" redirect to home page
			}		
		
		}
		else
		{
		redirect('account/sign_in');
		}
	}


	public function username_check($username)
	{				
		$is_exist=$this->general_model->is_exist_in_a_table('a3m_account','username',$username);
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('username_check', ' The username '.$username .' is already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function email_check($email)
	{				
		$is_exist=$this->general_model->is_exist_in_a_table('a3m_account','email',$email);
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('email_check', ' The email '.$email .' is already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	
	
	public function barcode_no_check($staff_id)
	{				
		$is_exist=$this->general_model->is_exist_in_a_table('bgb_staff','staff_id',$staff_id);
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('barcode_no_check', ' The barcode id '.$staff_id .' is already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function account_and_same_season_check($season_id,$account_id)
	{
		
	$searchterm='select * FROM `bgb_main_salary` WHERE `account_id`='.$account_id.' AND `season_id` ='.$season_id;						
		$is_exist=$this->general_model->is_exist_in_a_table_querystring($searchterm);
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('account_and_same_season_check', ' This month salary is already exist for this person, Need not to add again, If need you can edit this record');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	
	}
	
	public function account_and_same_season_check_edit($season_id,$staff_id_and_salary_id)
	{
	
	$pieces = explode(",", $staff_id_and_salary_id);
	//echo $pieces[0]; // $staff_id
	//echo $pieces[1]; // $salary_id
	
	$searchterm='select * FROM `bgb_main_salary` WHERE `account_id`='.$pieces[0].' AND `season_id` ='.$season_id." AND salary_id!=".$pieces[1] ;
		$is_exist=$this->general_model->is_exist_in_a_table_querystring($searchterm);
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('account_and_same_season_check_edit', ' This month salary is already exist for this person, Need not to update again, If you need you can edit that record');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	
	}
	
	
	public function email_check_edit($post_email,$account_id)
	{				
		
		//$email = $this->input->post('email');
		
		//$account_info=$this->general_model->get_all_table_info_by_id('a3m_account', 'email', $email);
		
		//$is_exist=$this->general_model->is_exist_in_a_table('a3m_account','email',$email);
		
		$searchterm='select * FROM `a3m_account` WHERE `email`="'.$post_email.'" AND `id` !='.$account_id;						
		$is_exist=$this->general_model->is_exist_in_a_table_querystring($searchterm);
		//echo $searchterm;
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('email_check_edit', ' The email '.$post_email .' is used by another person');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function barcode_no_check_edit($post_staff_id, $account_id)
	{	
	
		//echo "field=".$field.",staff_id= ".$staff_id;
		//$staff_id = $this->input->post('staff_id');
   
		//$account_info=$this->general_model->get_all_table_info_by_id('bgb_staff', 'staff_id', $staff_id);
		
		$searchterm='select * FROM `bgb_staff` WHERE `staff_id`="'.$post_staff_id.'" AND `account_id` !='.$account_id;						
		
		$is_exist=$this->general_model->is_exist_in_a_table_querystring($searchterm);
		//echo $searchterm."----".$is_exist;
		
		if ($is_exist > 0)
		{
			$this->form_validation->set_message('barcode_no_check_edit', ' The staff id '.$post_staff_id .' is used by another person');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**** Ajax function *****/
	public function delete_staff()
	{
	if($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));	
			if($this->authorization->is_permitted('delete_designation_staff_salary_month'))
			{
			$account_id=$this->input->post('account_id');
				
				$success_or_fail1=$this->general_model->delete_from_table('a3m_account','id',$account_id);
				$success_or_fail2=$this->general_model->delete_from_table('a3m_account_details','account_id',$account_id);
				$success_or_fail3=$this->general_model->delete_from_table('a3m_rel_account_role','account_id',$account_id);				
				$success_or_fail4=$this->general_model->delete_from_table('bgb_staff','account_id',$account_id);
				$success_or_fail5=$this->general_model->delete_from_table('bgb_main_salary','account_id',$account_id);
				$success_or_fail6=$this->general_model->delete_from_table('bgb_main_excision','account_id',$account_id);
				$success_or_fail7=$this->general_model->delete_from_table('bgb_user_battalion_map','account_id',$account_id);
				
				if($success_or_fail1 && $success_or_fail2 && $success_or_fail3 && $success_or_fail4)
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