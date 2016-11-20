<?php

class Aponjon_register extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl','date'));
		$this->load->library(array('account/authentication', 'account/authorization','form_validation','account/recaptcha'));
		$this->load->model(array('account/account_model'));
		
		date_default_timezone_set('Asia/Dhaka');  // set the time zone UTC+6
		
		$language = $this->session->userdata('site_lang');
		if(!$language)
		{
		$this->lang->load('general', 'english');
		$this->lang->load('menu', 'english');
		$this->lang->load('contact', 'english');
		$this->lang->load('email/contact_us', 'english');

		}
		else
		{
		$this->lang->load('general', $language);
		$this->lang->load('menu', $language);
		$this->lang->load('contact', $language);
		$this->lang->load('email/contact_us', $language);
		}
		
	}

	function index()
	{
		maintain_ssl();

		//$recaptcha_result = $this->recaptcha->check();

		// Store recaptcha pass in session so that users only needs to complete captcha once
		//if ($recaptcha_result === TRUE) $this->session->set_userdata('sign_up_recaptcha_pass', TRUE);
		
		/*if ($this->authentication->is_signed_in())
		{
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		}*/
		
	
		
		
		$this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		$this->form_validation->set_rules(
		  array(
			array(
			  'field' => 'subscriber_type',
			  'label' => 'Subscriber type',
			  'rules' => 'required'),
			array(
			  'field' => 'name', 
			  'label' => 'Name', 
			  'rules' => 'trim|required|max_length[100]'), 
			array(
			  'field' => 'cell_no', 
			  'label' => 'Cell No', 
			  'rules' => 'trim|required|min_length[11]|max_length[11]')
		  ));
		  
		// Run form validation
		if ($this->form_validation->run())
		{			
			// Load email library
			//$this->load->library('email');

			
			//$email_setting  = array('mailtype'=>'html');
			//$this->email->initialize($email_setting);
			
			/*$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);*/
	
			/*if ( ! ($this->session->userdata('sign_up_recaptcha_pass') == TRUE || $recaptcha_result === TRUE))
			{
				$data['sign_up_recaptcha_error'] = $this->input->post('recaptcha_response_field') ? "Recaptcha incorrect" : "recaptcha required";
			}
			else
			{*/
				
			// Remove recaptcha pass
			//$this->session->unset_userdata('sign_up_recaptcha_pass');
			// Send reset password email
			/*$this->email->from($this->input->post('email', TRUE));
			$this->email->reply_to($this->input->post('email', TRUE));
			$this->email->to('riponmailbox@gmail.com');
			$this->email->subject($this->input->post('subject', TRUE));
			$this->email->message($this->load->view('email/contact_us_email', array(
				'name' => $this->input->post('name', TRUE),
				'message' => $this->input->post('message', TRUE)), TRUE));			
			if($this->email->send())
			{
				$data['success'] = 'success';
				$this->load->view('aponjon_register', isset($data) ? $data : NULL);
			}
			else
			{
				$data['error'] = 'error';
				$this->load->view('aponjon_register', isset($data) ? $data : NULL);
			}
			return;*/
			$table_data=array(
						'subscriber_type'=>$this->input->post('subscriber_type'),
						'name'=>$this->input->post('name'),
						'cell_no'=>$this->input->post('cell_no'),
						'services_model'=>$this->input->post('services_model'),
						'gatekeeper_cell_no'=>$this->input->post('gatekeeper_cell_no'),
						'relationship_with_gatekeeper'=>$this->input->post('relationship_with_gatekeeper'),						
						'create_date_time'=>mdate('%Y-%m-%d %H:%i:%s', now())					
						);
			
			$success_or_fail=$this->general_model->save_into_table('aponjon_member', $table_data);	
			
			if($success_or_fail)
					$data['success_msg']=lang('saveed_successfully');
				else
					$data['error_msg']=lang('save_unsuccessfull');
					
			//$data['recaptcha'] = $this->recaptcha->load($recaptcha_result, $this->config->item("ssl_enabled"));
			$this->load->view('aponjon_register', isset($data) ? $data : NULL);		
			//}
		}
		else
		{
		//$data['recaptcha'] = $this->recaptcha->load($recaptcha_result, $this->config->item("ssl_enabled"));
		$this->load->view('aponjon_register', isset($data) ? $data : NULL);	
		}
		
		
	}

}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */