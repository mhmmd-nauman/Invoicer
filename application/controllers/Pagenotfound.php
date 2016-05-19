<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagenotfound extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('url', 'form'));
		
		$this->load->library(array('ion_auth', 'form_validation'));
		
	}
	
	public function index() { 
	
		show_404();
		
	} 
	
}
