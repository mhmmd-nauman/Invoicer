<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
  	public function setLastCron() {
  		
		$data = array(
			'lastcron' => time()
		);
		
		$this->db->where('id', 1);
		$this->db->update('application', $data);
		
  	}
	
	
	public function getLastCronTime() {
		
		$q = $this->db->from('application')->where('id', 1)->get();
		
		$temp = $q->result();
		
		return $temp[0]->lastcron;
		
	}
    
}