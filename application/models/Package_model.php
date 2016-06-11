<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getAll($packageID = false) {
		
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->order_by('name', 'ASC');
		if( $packageID ) {
			
			$this->db->where('id', $packageID);
			
		}
		
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
    }
	
	
	public function getActive( ) {
		
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->order_by('name', 'ASC');
                $this->db->where('status', 1);
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
	}
	
        public function getPackageInfo($packageID){
            $package[1]['employees_min'] =  1;
            $package[1]['employees_max'] =  2;
            $package[1]['collect_payment_online'] =  0;
            $package[1]['whitelabel'] =  0;
            ////
            $package[2]['employees_min'] =  1;
            $package[2]['employees_max'] =  3;
            $package[2]['collect_payment_online'] =  1;
            $package[2]['whitelabel'] =  1;
            ////
            $package[3]['employees_min'] =  4;
            $package[3]['employees_max'] =  9;
            $package[3]['collect_payment_online'] =  0;
            $package[3]['whitelabel'] =  0;
            switch($packageID){
                case 1:
                    return $package[1];
                    break;
                case 2:
                    return $package[2];
                    break;
                case 3:
                    return $package[3];
                    break;
            }
            
            
        }
        
	public function update($packageID, $data) {
		
		$cdata = array(
			'name' => $data['field_name'],
			'description' => $data['field_description'],
			'status' => $data['field_status'],
			);

		$this->db->where('id', $packageID);
		$this->db->update('packages', $cdata);
		
	}
	
	
	public function create($data, $packageID) {
		
		$cdata = array(
			'name' => $data['field_name'],
			'description' => $data['field_description'],
                        'date'=> date("Y-m-d h:i:s"),
			'status' => $data['field_status'],
			);
		
		$this->db->insert('packages', $cdata);
				
		return $this->db->insert_id();
		
	}
	
	
	public function delete( $packageID ) {
		
		$this->db->where('id', $packageID);
		$this->db->delete('packages');
		
		
	}
    
}