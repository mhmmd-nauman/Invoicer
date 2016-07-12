<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('url', 'form'));
		$this->load->library('ion_auth');
		$this->load->model(array('client_model', 'currency_model', 'invoice_model', 'settings_model', 'api_model','company_model'));
		
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
		$this->data['keys'] = $this->api_model->getKeys();
				
		$this->data['settings'] = $this->settings_model->getAll( $this->data['user']->id );
		
		$this->data['allCurrencies'] = $this->currency_model->getAll();
		$defaullt_currency_temp =$this->company_model->get($this->user->company_id);
                
                //;
		$this->data['default_currency'] = $this->currency_model->get($defaullt_currency_temp->default_currency);
		
                $this->data['total_paid'] = number_format($this->invoice_model->getTotalPaid( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		$this->data['total_due'] = number_format($this->invoice_model->getTotalDue( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		$this->data['total_pastdue'] = number_format($this->invoice_model->getTotalPastDue( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		
		$this->data['clients'] = $this->client_model->getAll( $this->data['user']->id );
		$this->data['clientsWithTotals'] = $this->client_model->getAllWithTotals( $this->data['default_currency']->currency_shortname, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id );
		
		$this->data['totalsCurrentYear'] = $this->invoice_model->getPaidForYear( date('Y'), $this->data['default_currency']->currency_shortname, $this->data['user']->id);
		$this->data['totalsLastYear'] = $this->invoice_model->getPaidForYear( date('Y')-1, $this->data['default_currency']->currency_shortname, $this->data['user']->id);
		
	}

	public function index() {
				
		$this->data['page'] = 'dashboard';
		
		$this->data['currencies'] = $this->currency_model->getUsed($this->data['user']->id);
		
		$this->load->view('dashboard', $this->data);
		
	}
	
	
	/*
		
		ajax function
		
	*/
	
	public function udata($currencyID) {
		
		$return = array();//main array
		
		$return = array();
		
		$return['code'] = 1;
		
		$data['total_paid'] = number_format($this->invoice_model->getTotalPaid( $currencyID, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		$data['total_due'] = number_format($this->invoice_model->getTotalDue( $currencyID, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		$data['total_pastdue'] = number_format($this->invoice_model->getTotalPastDue( $currencyID, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id), 2);
		
		$data['totalsCurrentYear'] = $this->invoice_model->getPaidForYear( date('Y'), $currencyID, $this->data['user']->id );
		$data['totalsLastYear'] = $this->invoice_model->getPaidForYear( date('Y')-1, $currencyID, $this->data['user']->id );
		
		$data['clientsWithTotals'] = $this->client_model->getAllWithTotals( $currencyID, strtotime('1 Jan '.date('Y')), strtotime('31 Dec '.date('Y')), $this->data['user']->id );
		
		$return['data'] = $data;
				
		echo json_encode( $return );
		
	}
	
}
