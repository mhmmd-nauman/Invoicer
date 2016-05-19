<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getAll($userID = false) {
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('first_name', 'ASC');
                $this->db->where('owner', 0);
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
			
		}
		
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
    }
	
	
	public function getEmployee( $ownerID = false) {
		
		$this->db->from('users');
		$this->db->select("*");
		
		//$this->db->join('currencies', 'clients.client_default_currency = currencies.currency_shortname');
		
		if( $ownerID ) {
			
			$this->db->where('owner', $ownerID);
			
		}
		
		$q = $this->db->get();
				
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			return $res;
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function update($userID, $data) {
		
		$cdata = array(
			'client_name' => $data['field_clientName'],
			'client_contact' => (isset($data['field_clientContact']))? $data['field_clientContact'] : "",
			'client_email' => $data['field_clientEmail'],
			'client_phone' => (isset($data['field_clientPhone']))? $data['field_clientPhone'] : "",
			'client_fax' => (isset($data['field_clientFax']))? $data['field_clientFax'] : "",
			'client_website' => (isset($data['field_clientWebsite']))? $data['field_clientWebsite'] : "",
			'client_address' => (isset($data['field_clientAddress']))? $data['field_clientAddress'] : "",
			'client_additionalInfo' => (isset($data['field_clientAdditionalinfo']))? $data['field_clientAdditionalinfo'] : "",
			'client_notes' => (isset($data['field_clientNotes']))? $data['field_clientNotes'] : "",
			'client_default_currency' => (isset($data['field_defaultCurrency']))? $data['field_defaultCurrency'] : $this->config->item('default_currency')
		);

		$this->db->where('id', $userID);
		$this->db->update('users', $cdata);
		
	}
	
	
	public function create($data, $userID) {
		
		$cdata = array(
			'first_name' => $data['first_name'],
			'last_name' => (isset($data['last_name']))? $data['last_name'] : "",
			'company' => $data['company'],
			'phone' => (isset($data['phone']))? $data['phone'] : "",
			'client_fax' => (isset($data['field_clientFax']))? $data['field_clientFax'] : "",
			'client_website' => (isset($data['field_clientWebsite']))? $data['field_clientWebsite'] : "",
			'client_address' => (isset($data['field_clientAddress']))? $data['field_clientAddress'] : "",
			'client_default_currency' => (isset($data['field_defaultCurrency']))? $data['field_defaultCurrency'] : $this->config->item('default_currency')
		);
		
		$this->db->insert('users', $cdata);
				
		return $this->db->insert_id();
		
	}
	
	
	public function delete( $clientID ) {
		
		//start by removing all payments connected this clients invoices
		
		$q = $this->db->from('invoices')->where('client_id', $clientID)->get();
		
		if( $q->num_rows() > 0 ) {
			
			foreach( $q->result() as $invoice ) {
				
				$invoiceID = $invoice->invoice_id;
				
				//delete all connected payments
				
				$this->db->where('invoice_id', $invoiceID);
				$this->db->delete('payments');
				
				
				//deal with reports
				
				$z = $this->db->from('reports_invoices')->join('reports', 'reports.report_id = reports_invoices.report_id')->where('reports_invoices.invoice_id', $invoiceID)->get();
				
				if( $z->num_rows() > 0 ) {
					
					foreach( $z->result() as $report ) {
						
						$reportID = $report->report_id;
						
						$this->db->where('report_id', $reportID);
						$this->db->delete('reports');
						
					}
					
				}				
				
			}
			
		}
		
		
		/* delete invoices */
		$this->db->where('client_id', $clientID);
		$this->db->delete('invoices');
		
		
		
		/* delete reports */
		
		$z = $this->db->from('reports_clients')->join('reports', 'reports.report_id = reports_clients.report_id')->where('reports_clients.client_id', $clientID)->get();
		
		if( $z->num_rows() > 0 ) {
			
			foreach( $z->result() as $report ) {
				
				$reportID = $report->report_id;
				
				$this->db->where('report_id', $reportID);
				$this->db->delete('reports');
				
			}
			
		}
		
		
		//delete the client
		$this->db->where('client_id', $clientID);
		$this->db->delete('clients');
		
	}
    
}