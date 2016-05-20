<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library(array('ion_auth', 'form_validation'));
		
		$this->load->model(array('client_model', 'invoice_model', 'currency_model', 'payment_model', 'settings_model', 'api_model'));
		
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
		$this->data['clients'] = $this->client_model->getAll( $this->data['user']->id, $this->data['user']->owner );
		//$this->output->enable_profiler(FALSE);
                $this->data['allCurrencies'] = $this->currency_model->getAll();
		$this->data['settings'] = $this->settings_model->getAll( $this->data['user']->id );
		$this->data['keys'] = $this->api_model->getKeys();
		
	}

	public function index() {
		//$this->output->enable_profiler(TRUE);
		$this->data['page'] = 'clients';
				
		$this->load->view('clients', $this->data);
		
	}
	
	public function get($clientID) {
		
		//verify clientID
		
		$theClient = $this->client_model->getClient($clientID, $this->data['user']->id);
		
		if( !$theClient ) {
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('clients_get_error1');
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('clients', 'location');
			
		}
				
		$this->data['page'] = 'clients';
		
		$this->data['theClient'] = $theClient;
		$this->data['invoices'] = $this->invoice_model->getForClient($clientID, $this->data['user']->id);
		$this->data['payments'] = $this->payment_model->getForClient($clientID, $theClient->currency_shortname, $this->data['user']->id);
		
		$this->data['default_currency'] = $this->currency_model->get( $this->data['theClient']->client_default_currency );
		$this->data['currencies'] = $this->currency_model->getUsed($this->data['user']->id);
		
		$this->data['total_paid'] = number_format($this->invoice_model->getTotalPaid( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id, $clientID), 2);
		$this->data['total_due'] = number_format($this->invoice_model->getTotalDue( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id, $clientID), 2);
		$this->data['total_pastdue'] = number_format($this->invoice_model->getTotalPastDue( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id, $clientID), 2);
		
		$this->data['totalsCurrentYear'] = $this->invoice_model->getPaidForYear( date('Y'), $this->data['default_currency']->currency_shortname, $this->data['user']->id, $clientID);
		$this->data['totalsLastYear'] = $this->invoice_model->getPaidForYear( date('Y')-1, $this->data['default_currency']->currency_shortname, $this->data['user']->id, $clientID);
		
		$this->load->view('clients', $this->data);
		
	}
	
	public function update($clientID = '') {
		
		//check the clientID
		if( $clientID == '' || $clientID == 'undefined' ) {
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('clients_update_error1');
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('clients', 'location');
			
		}
		
		
		//validate the form
		
		$this->form_validation->set_rules('field_clientName', $this->lang->line('client_name_label'), 'required');
		$this->form_validation->set_rules('field_clientEmail', $this->lang->line('client_email_label'), 'required|valid_email');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('clients_update_error2').validation_errors();
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('clients/'.$clientID, 'location');
			
		} else {//all good :)
			
			//update client info
			
			$this->client_model->update($clientID, $_POST);
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('clients_update_success1');
			
			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
			
			redirect('clients/'.$clientID, 'location');
			
		}
		
	}
	
	
	public function create() {
		
		//validate form
		$this->form_validation->set_rules('field_clientName', $this->lang->line('client_name_label'), 'required');
		$this->form_validation->set_rules('field_clientEmail', $this->lang->line('client_email_label'), 'required|valid_email');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
						
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('clients_create_error1').validation_errors();
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
						
			redirect('clients', 'location');
		
		} else {
			
			//create new client
			
			$clientID = $this->client_model->create($_POST, $this->data['user']->id);
						
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('clients_create_success1');
			
			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
			
			redirect('clients/'.$clientID, 'location');
			
		}
		
	}
	
	
	public function delete($clientID = '') {
		
		$client = $this->client_model->getClient($clientID, $this->data['user']->id);
		
		if( !$client ) {
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('clients_delete_error1');
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
						
			redirect('clients', 'location');
			
		} else {
			
			$this->client_model->delete($clientID);
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('clients_delete_success1');
			
			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
						
			redirect('clients', 'location');
			
		}
		
	}
	
}
