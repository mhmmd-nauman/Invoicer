<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getAll( $userID ) {
    	
		$q = $this->db->from('config')->where('user_id', $userID)->get();
		
		return $q->result();
		
    }
	
	
	public function nextInvoiceNr($userID) {
		
		//grab the latest invoice number (from counter), adds 1 and returns it
		
		$q = $this->db->from('config')->where('user_id', $userID)->get();
		
		$res = $q->result();
		
		$nr = $res[0]->invoice_nr_counter+1;
		
		$data = array(
			'invoice_nr_counter' => $nr
		);
		
		$this->db->where('user_id', $userID);
		$this->db->update('config', $data);
				
		return $nr;
		
	}
	
	
	public function update($data) {
		
		$user = $this->ion_auth->user()->row();
		
		if( isset($data['field_api']) && $data['field_api'] == 'On' ) {
			$api = 1;
		} else {
			$api = 0;
		}
		
		$data = array(
			'invoice_nr_counter' => $data['setting_invoicecounter'],
			'paypal_email' => $data['field_paypalemail'],
			'stripe_secret' => $data['field_stripesecret'],
			'stripe_public' => $data['field_stripepublic'],
			'api' => $api,
            'currency_placement' => $data['setting_currencyPlacement']
		);
		
		$this->db->where('user_id', $user->id);
		$this->db->update('config', $data);
		
	}
	
	
	public function update_paymentIntegrations( $userID, $data ) {
		
		$ddata = array(
			'paypal_email' => $data['field_paypalEmail'],
			'stripe_secret' => $data['field_stripeSecretKey'],
			'stripe_public' => $data['field_stripePublishableKey']
		);
		
		$this->db->where('user_id', $userID);
		$this->db->update('config', $ddata);
		
	}
    
}