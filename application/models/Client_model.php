<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getAll($userID = false) {
		
		$this->db->select('*');
		$this->db->select("IFNULL((SELECT SUM(invoices.invoice_paidtodate) FROM invoices WHERE invoices.client_id = clients.client_id && invoices.invoice_active = '1' && invoices.currency_id = clients.client_default_currency), 0) as 'total_paid'");
		$this->db->select("IFNULL((SELECT SUM(invoices.invoice_balance) FROM invoices WHERE invoices.client_id = clients.client_id && invoices.invoice_active = '1' && invoice_status = 'due' && invoices.currency_id = clients.client_default_currency), 0) as 'total_due'");
		$this->db->select("IFNULL((SELECT SUM(invoices.invoice_balance) FROM invoices WHERE invoices.client_id = clients.client_id && invoices.invoice_active = '1' && invoice_status = 'past due' && invoices.currency_id = clients.client_default_currency), 0) as 'total_pastdue'");
		$this->db->from('clients');
		$this->db->order_by('client_name', 'ASC');
		$this->db->join('currencies', 'clients.client_default_currency = currencies.currency_shortname');
		
    	
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
	
	
	public function getAllWithTotals( $currencyID, $dateFrom, $dateTo, $userID = false) {
        		
		if( $userID ) {
			
			$q = $this->db->query("
				SELECT 
				*, 
				IFNULL((SELECT SUM(invoices.invoice_paidtodate) FROM invoices WHERE invoices.client_id = clients.client_id && invoices.invoice_active = '1' && invoices.currency_id = ".$this->db->escape($currencyID)." && invoice_date >= ".$this->db->escape($dateFrom)." && invoice_date <= ".$this->db->escape($dateTo)."), 0) as total_paid
				FROM `clients` 
				WHERE `user_id` = '$userID'
			");
			
		} else {
			
			$q = $this->db->query("
				SELECT 
				*, 
				IFNULL((SELECT SUM(invoices.invoice_paidtodate) FROM invoices WHERE invoices.client_id = clients.client_id && invoices.invoice_active = '1' && invoices.currency_id = ".$this->db->escape($currencyID)."), 0) as total_paid
				FROM `clients` 
			");
			
			
		}
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
				
	}
	
	
	public function getClient($clientID, $userID = false) {
		
		$this->db->from('clients');
		$this->db->select("*");
		//$this->db->select("IFNULL((SELECT SUM(invoices.invoice_paidtodate) FROM invoices WHERE invoices.client_id = clients.client_id), 0) as 'total_paid'");
		//$this->db->select("IFNULL((SELECT SUM(invoices.invoice_balance) FROM invoices WHERE invoices.client_id = clients.client_id && invoice_status = 'due'), 0) as 'total_due'");
		//$this->db->select("IFNULL((SELECT SUM(invoices.invoice_balance) FROM invoices WHERE invoices.client_id = clients.client_id && invoice_status = 'past-due'), 0) as 'total_pastdue'");
		$this->db->where('client_id', $clientID);
		$this->db->join('currencies', 'clients.client_default_currency = currencies.currency_shortname');
		
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
			
		}
		
		$q = $this->db->get();
				
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			return $res[0];
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function update($clientID, $data) {
		
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

		$this->db->where('client_id', $clientID);
		$this->db->update('clients', $cdata);
		
	}
	
	
	public function create($data, $userID) {
		
		$cdata = array(
			'user_id' => $userID,
			'client_name' => $data['field_clientName'],
			'client_contact' => (isset($data['field_clientContact']))? $data['field_clientContact'] : "",
			'client_email' => $data['field_clientEmail'],
			'client_phone' => (isset($data['field_clientPhone']))? $data['field_clientPhone'] : "",
			'client_fax' => (isset($data['field_clientFax']))? $data['field_clientFax'] : "",
			'client_website' => (isset($data['field_clientWebsite']))? $data['field_clientWebsite'] : "",
			'client_address' => (isset($data['field_clientAddress']))? $data['field_clientAddress'] : "",
			'client_default_currency' => (isset($data['field_defaultCurrency']))? $data['field_defaultCurrency'] : $this->config->item('default_currency')
		);
		
		$this->db->insert('clients', $cdata);
				
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