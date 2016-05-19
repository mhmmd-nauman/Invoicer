<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
	
	
	public function getAll($userID = false) {
		
		$this->db->from('reports');
		
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
	
    
    public function create($data, $userID) {
    	
		//start by adding the report itself
		
		$rdata = array();
		$rdata['report_title'] = $_POST['field_reportTitle'];
		$rdata['report_date'] = time();
		$rdata['user_id'] = $userID;
		$rdata['report_from'] = strtotime($_POST['field_reportFrom']);
		$rdata['report_untill'] = strtotime($_POST['field_reportTo']);
		$rdata['report_currency'] = $_POST['field_reportCurrency'];
			
		if( in_array('due', $_POST['field_reportStatus']) ) {
			$rdata['report_included_due'] = 1;
		}
		
		if( in_array('past-due', $_POST['field_reportStatus']) ) {
			$rdata['report_included_pastdue'] = 1;
		}
		
		if( in_array('paid', $_POST['field_reportStatus']) ) {
			$rdata['report_included_paid'] = 1;
		}
		
		$this->db->insert('reports', $rdata);
		
		$reportID = $this->db->insert_id();
		
		
		//insert clients stuff for this report
		
		foreach( $_POST['field_reportClients'] as $k => $clientID ) {
			
			$cdata = array(
				'report_id' => $reportID,
				'client_id' => $clientID
			);
			
			$this->db->insert('reports_clients', $cdata);
			
		}
		
		
		//invoice part, grab first and then insert
						
		
		/* clients */
		foreach( $_POST['field_reportClients'] as $k => $clientID ) {
			
			$this->db->from('invoices');
			
			$this->db->group_start();
			
			$this->db->where('client_id', $clientID);
			$this->db->where('currency_id', $_POST['field_reportCurrency']);
			$this->db->where('invoice_date >', strtotime($_POST['field_reportFrom']));
			$this->db->where('invoice_date <', strtotime($_POST['field_reportTo']));
			
			$this->db->group_end();
			
			$this->db->group_start();
			
			/* status */
			foreach( $_POST['field_reportStatus'] as $k => $status ) {
			
				$this->db->or_where('invoice_status', $status);
			
			}
			
			$this->db->group_end();
			
			$q = $this->db->get();
			
			//echo $this->db->last_query()."<br>";
				
			if( $q->num_rows() > 0 ) {
			
				$res = $q->result();
			
				foreach( $res as $invoice ) {
				
					$idata = array(
						'report_id' => $reportID,
						'invoice_id' => $invoice->invoice_id
					);
				
					$this->db->insert('reports_invoices', $idata);
				
				}
			
			}
			
		}
		
		return $reportID;
		
    }
	
	
	public function get($reportID, $userID = false) {
		
		$return = array();
		
		
		$this->db->from('reports');
		$this->db->where('report_id', $reportID);
		$this->db->join('currencies', 'reports.report_currency = currencies.currency_shortname');
		
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
			
		}
		
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			$report = $res[0];
			
			$return['report'] = $report;
			
			//grab the clients
			
			$this->db->from('reports_clients');
			$this->db->where('report_id', $report->report_id);
			$this->db->join('clients', 'reports_clients.client_id = clients.client_id');
			
			$y = $this->db->get();
			
			if( $y->num_rows() > 0 ) {
				
				$return['clients'] = $y->result();
				
			}
			
			
			//grab the invoices
			
			$this->db->from('reports_invoices');
			$this->db->where('report_id', $reportID);
			$this->db->join('invoices', 'reports_invoices.invoice_id = invoices.invoice_id');
			
			$z = $this->db->get();
			
			$return['invoices'] = $z->result();
			
			return $return;
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function delete($reportID) {
		
		//delete from reports table first
		$this->db->where('report_id', $reportID);
		$this->db->delete('reports');
		
		
		//delete from reports_clients
		$this->db->where('report_id', $reportID);
		$this->db->delete('reports_clients');
		
		
		//delete from reports_invoices
		$this->db->where('report_id', $reportID);
		$this->db->delete('reports_invoices');
		
		
	}
    
}