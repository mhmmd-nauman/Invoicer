<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getAll() {
    	
		$q = $this->db->from('currencies')->order_by('currency_fullname', 'ASC')->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
    }
	
	
	public function get($currencyShortname) {
		
		$q = $this->db->from('currencies')->where('currency_shortname', $currencyShortname)->get();
		
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			return $res[0];
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	
	public function getUsed($userID = false) {
		
		if( $userID ) {
			
			$q = $this->db->query("SELECT DISTINCT currency_sign, currency_shortname FROM `currencies` JOIN `invoices` ON `invoices`.`currency_id` = `currencies`.`currency_shortname` WHERE `user_id` = ".$this->db->escape($userID)." && `invoice_active` = '1'");
			
		} else {
		
			$q = $this->db->query("SELECT DISTINCT currency_sign, currency_shortname FROM `currencies` JOIN `invoices` ON `invoices`.`currency_id` = `currencies`.`currency_shortname` WHERE `invoice_active` = '1'");
		
		}
				
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
	}
    
}