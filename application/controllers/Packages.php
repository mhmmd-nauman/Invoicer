<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model(array('package_model'));
		$this->load->library(array('ion_auth', 'form_validation'));
		
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
		
		
	}

	public function index() {
		
		$this->data['page'] = 'packages';
		$this->data['packages'] = $this->package_model->getActive();
                //print_r($this->data['packages']);
		$this->load->view('packages', $this->data);
		
	}
	
	
	public function update() {
		
		//validate the form
				
		$this->form_validation->set_rules('package', $this->lang->line('package_label'), 'required|integer');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = validation_errors();
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('packages', 'location');
			
		} else {
			
			//update settings
			$data = array(
					'package_id' => $this->input->post('package'),
					
				);
			$user = $this->ion_auth->user()->row();
			$this->ion_auth->update($user->id, $data);
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = "Package updated.";
			
			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
			
			redirect('packages', 'location');
			
		}
		
	}
	
	
	public function updateintegrations() {
		
		$return = array();
		
		$this->form_validation->set_rules('field_paypalEmail', $this->lang->line('paypal_email_address'), 'valid_email');
		//$this->form_validation->set_rules('field_stripeAPIKey', 'Invoice Number', 'required');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$return['code'] = 0;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('settings_updateintegrations_error1').validation_errors();
			
			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);
			
			die( json_encode( $return ) );
		
		} else {
			
			$this->settings_model->update_paymentIntegrations($this->data['user']->id, $_POST);
				
			$return['code'] = 1;
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('settings_updateintegrations_success1');
			
			$return['content'] = $this->load->view('alerts/alert_success', $alert, true);
			
			die( json_encode( $return ) );
				
			
		}
		
	}
	
	
	public function newapikey() {
		
		$key = $this->api_model->generateKey( $this->data['user']->id );
		
		$return = array();
		$return['key'] = $key;
		
		echo json_encode( $return );
		
	}
	
	public function deleteapikey() {
		
		$this->api_model->deleteKey($_POST['id'], $this->data['user']->id);
		
		$return = array();
		$return['code'] = 1;
		
		echo json_encode( $return );
		
	}
	
}
