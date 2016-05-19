<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('url', 'string'));
		$this->load->model(array('invoice_model', 'cron_model', 'settings_model', 'client_model'));
								
	}
	
	
	public function index() {
		
		$lastCronTime = $this->cron_model->getLastCronTime();
		
		//only run if difference is more then 24 hours
		
		if( time() - $lastCronTime >= 86400 ) {
		
		//if(1) {
		
			//update due/past-due if needed
			$this->invoice_model->checkStatus();
			
			//sort out recurring invoices
			$this->invoice_model->checkRecurring();
		
			//update last cron time
			$this->cron_model->setLastCron();
		
		}
		
	}

	
}
