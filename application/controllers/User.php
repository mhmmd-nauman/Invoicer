<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('url', 'form'));
		
		$this->load->library(array('ion_auth', 'form_validation'));
		
		$this->load->model('company_model');
		$this->load->model('user_model');
                $this->load->model('package_model');
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
	}
	
	/*
		
	*/
        public function createEmployee($userID=0){
            
            // need to check the package and then restrict if user can add more employees
            
            if( $this->ion_auth->in_group(array(2)) && !$this->ion_auth->is_admin()){
                $userID = $this->ion_auth->user()->row()->id;
            }
            $theUser = $user = $this->ion_auth->user($userID)->row();
            $package = $this->package_model->getPackageInfo($user->package_id);
            if($package['employees_max'] <= count($this->user_model->getEmployee($theUser->id))){
               // over limits in adding employee
                $alert = array();
                $alert['alertHeading'] = $this->lang->line('error');
                $alert['alertContent'] = "Please upgrate your package to add more employees";

                //$alert ="Please upgrate your package to add more employees.";
                $this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
                redirect('users/', 'location');
            } 
            
            $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
            //$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
            $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required');
            //$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required');
            $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
            
            if ($this->form_validation->run() == FALSE) {//validation failed
			
                    
                    $alert = array();
                    $alert['alertHeading'] = $this->lang->line('error');
                    $alert['alertContent'] = $this->lang->line('user_updateaccount_error2').validation_errors();
                    
                    $this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));


                    redirect('users/'.$userID, 'location');

		} else {
                        
                        $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');
                        $additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
                                'owner'      => $userID,
			);
			$change = $this->ion_auth->register($username, $password, $email, $additional_data,array(3));
			
                        
                        
                        if( $change ) {
				
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('successfully');
				$alert['alertContent'] = $this->ion_auth->messages();
                                $this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
				redirect('users/'.$userID.'/active_employee', 'location');
				
			} else {
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('error');
				$alert['alertContent'] = $this->ion_auth->errors();
                                $this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
				redirect('users/'.$userID, 'location');
				
			}
                }
            
        }
	public function updateAccount($userID = 0) {
		
		$return = array();//return array
		
		//userID check
		if( $userID == 0  ) {
			
			$return['code'] = 0;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('user_updateaccount_error1');
			
			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			$this->session->set_flashdata('message', $alert );
			redirect('/users/'.$userID, 'refresh');
			
		}
		
		//validate the form
		
		$this->form_validation->set_rules('field_email', $this->lang->line('username_label'), 'required|valid_email');
		$this->form_validation->set_rules('field_first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('field_last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		
                //$this->form_validation->set_rules('field_newpassword', $this->lang->line('new_password_label'), 'required');
		//$this->form_validation->set_rules('field_newpassword2', $this->lang->line('new_password_confirmation_label'), 'required|matches[field_newpassword]');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$return['code'] = 0;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('user_updateaccount_error2').validation_errors();
			
			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			$this->session->set_flashdata('message', $alert );
			redirect('/users/'.$userID, 'refresh');

		} else {//validation successfull
			
			//update details
			
			$data = array(
				'email' => $_POST['field_email'],
				'first_name' => $_POST['field_first_name'],
                                'last_name' => $_POST['field_last_name'],
                                'phone' => $_POST['field_phone'],
                                'company' => $_POST['field_company'],
                                'webaddress' => $_POST['field_web_address']
			);
			
			$change = $this->ion_auth->update($userID, $data);
			
			if( $change ) {
				
				$return['code'] = 1;
			
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('successfully');
				$alert['alertContent'] = $this->ion_auth->messages();
			
				$return['content'] = $this->load->view('alerts/alert_success', $alert, true);
			
				$this->session->set_flashdata('message', $alert );
                                redirect('/users/'.$userID, 'refresh');
				
			} else {
				
				$return['code'] = 0;
			
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('error');
				$alert['alertContent'] = $this->ion_auth->errors();
			
				$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			
				$this->session->set_flashdata('message', $alert );
                                redirect('/users/'.$userID, 'refresh');
				
			}
			
			
		                
		}
		
	}
	
	
	/*
		ajax function
	*/
	
	public function updateDetails($userID) {
		
		$return = array();//return array
		
		//userID check
		if( $userID == 0 || $userID != $this->user->id ) {
			
			$return['code'] = 0;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('user_updatedetails_error1');
			
			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			
			die( json_encode( $return ) );
			
		}
		
		
		//validate the form
		
		$this->form_validation->set_rules('field_firstName', $this->lang->line('first_name_label'), 'required');
		$this->form_validation->set_rules('field_lastName', $this->lang->line('last_name_label'), 'required');
		$this->form_validation->set_rules('field_companyName', $this->lang->line('company_name_label'), 'required');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$return['code'] = 0;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('user_updatedetails_error2').validation_errors();
			
			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			
			die( json_encode( $return ) );

		} else {//validation successfull
			
			$ret = $this->company_model->saveDetails($this->user->company_id, $this->user->id, $_POST);
			
			if( $ret['val'] ) {
			
				$return['code'] = 1;
			
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('success');
				$alert['alertContent'] = $this->lang->line('user_updatedetails_success1');
				
				if( isset( $ret['logo'] ) ) {
					$return['logo'] = $ret['logo'];
				}
				$return['content'] = $this->load->view('alerts/alert_success', $alert, true);
			
				die( json_encode( $return ) );
			
			} else {
				
				$return['code'] = 0;
			
				$alert = array();
				$alert['alertHeading'] = $this->lang->line('success');
				$alert['alertContent'] = $ret['error'];
			
				$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			
				die( json_encode( $return ) );
				
			}
		                
		}
				
	}
	
}
