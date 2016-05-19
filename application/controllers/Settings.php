<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model(array('client_model', 'currency_model', 'settings_model', 'settings_model', 'api_model'));
		$this->load->library(array('ion_auth', 'form_validation'));
		
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
		$this->data['clients'] = $this->client_model->getAll( $this->data['user']->id );
		$this->data['allCurrencies'] = $this->currency_model->getAll();
		$this->data['settings'] = $this->settings_model->getAll( $this->data['user']->id );
		$this->data['keys'] = $this->api_model->getKeys();
		
	}

	public function index() {
		
		$this->data['page'] = 'settings';
		
		$this->load->view('settings', $this->data);
		
	}
	
	
	public function update() {
		
		//validate the form
				
		$this->form_validation->set_rules('setting_invoicecounter', $this->lang->line('client_name_label'), 'required|integer');
		$this->form_validation->set_rules('field_paypalemail', $this->lang->line('paypal_email_address'), 'valid_email');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('settings_update_error1').validation_errors();
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('settings', 'location');
			
		} else {
			
			//update settings
			
			$this->settings_model->update($_POST);
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('settings_update_success1');
			
			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
			
			redirect('settings', 'location');
			
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
