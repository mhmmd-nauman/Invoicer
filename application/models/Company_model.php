<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    public function get($companyID) {
		
            $q = $this->db->from('companies')->where('company_id', $companyID)->get();

            if( $q->num_rows() > 0 ) {

                    $res = $q->result();

                    return $res[0];

            } else {

                    return false;

            }

    }
    public function create($data){
        $this->db->insert('companies', $data);
	return $this->db->insert_id();
    }
    public function saveDetails($companyID, $userID, $data) {
    	
		//update the first_name and last_name first
		
		$udata = array(
		 	'first_name' => $data['field_firstName'],
                        'last_name' => $data['field_lastName']
		);

		$this->db->where('id', $userID);
		$this->db->update('users', $udata);
		
		
		//update company deails
		
		$cdata = array(
			'company_name' => $data['field_companyName'],
			'company_phone' => $data['field_companyPhone'],
			'company_fax' => $data['field_companyFax'],
			'company_address' => $data['field_companyAddress'],
			'company_additionalinfo' => $data['field_companyInfo'],
                        'default_currency' => $data['field_defaultCurrency']
 		);
		
		$this->db->where('company_id', $companyID);
		$this->db->update('companies', $cdata);
		
				
		if( isset($_FILES['field_companyLogo']) && $_FILES['field_companyLogo']['name'] != '' ) {
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 1000;
			$config['max_width'] = 1024;
			$config['max_height'] = 768;
			$config['overwrite'] = true;
			$config['file_name'] = $userID."_logo";

			$this->load->library('upload', $config);
			
			$ret = array();
			
			if( $this->upload->do_upload('field_companyLogo') ) {//all good with the uploaded image
				
				$ret['val'] = true;
								
				$cdata = array(
					'company_logo' => "uploads/".$this->upload->data('file_name')
		 		);
		
				$this->db->where('company_id', $companyID);
				$this->db->update('companies', $cdata);
				
				
				//resize the image if needed
				if( $this->upload->data('image_width') > 200 ) {
										
					$this->load->library('image_lib');
				    $this->image_lib->clear();
					
					$config['image_library'] = 'gd2';
					$config['source_image'] = $this->upload->data('full_path');
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 200;

					$this->image_lib->initialize($config);

					if ( ! $this->image_lib->resize()) {
												
						$ret['val'] = false;
						$ret['error'] = $this->image_lib->display_errors();
				
						return $ret;
					
					} else {
						
						$ret['val'] = true;
						$ret['logo'] = base_url('uploads/'.$this->upload->data('file_name'));
						return $ret;
						
					}
					
				}
				
				
			} else {
				
				$ret['val'] = false;
				$ret['error'] = $this->upload->display_errors();
				
				return $ret;
				
			}
						
		} else {
			
			//remove company logo
			$cdata = array(
				'company_logo' => ""
	 		);
	
			$this->db->where('company_id', $companyID);
			$this->db->update('companies', $cdata);
			
			$ret['val'] = true;
			return $ret;
			
		}
		
		return $ret;
		
    }
    
}