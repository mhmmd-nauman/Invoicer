<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model(array('client_model', 'currency_model', 'settings_model', 'api_model'));
		$this->load->library('ion_auth');
		
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
		
		$this->data['page'] = 'documentation';
		
		$this->load->view('documentation', $this->data);
		
	}
}
