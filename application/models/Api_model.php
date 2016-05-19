<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getKeys() {
    	
		$q = $this->db->from('keys')->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
    }
	
	public function getKey( $key ) {
		
		$q = $this->db->from('keys')->where('key', $key)->get();
		
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			return $res[0];
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function generateKey( $userID ) {
		
		$this->load->helper('string');
		
		$newKey = random_string('md5');
		
		$data = array(
			'user_id' => $userID,
			'key' => $newKey
		);
		
		$this->db->insert('keys', $data);
		
		return $newKey;
		
	}
	
	
	public function deleteKey($id, $userID) {
		
		$this->db->where('id', $id);
		$this->db->where('user_id', $userID);
		$this->db->delete('keys');
		
	}
	
	
    
}