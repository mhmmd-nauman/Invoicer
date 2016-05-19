<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
    
    public function getForInvoice($invoiceID, $userID = false) {
		
		if( !$userID ) {
			
			$q = $this->db->from('payments')->join('payment_types', 'payments.payment_type = payment_types.payment_type_id')->join('invoices', 'payments.invoice_id = invoices.invoice_id')->where('payments.invoice_id', $invoiceID)->where('user_id', $userID)->where('payment_active', 1)->get();
			
		} else {
    	
			$q = $this->db->from('payments')->join('payment_types', 'payments.payment_type = payment_types.payment_type_id')->where('invoice_id', $invoiceID)->where('payment_active', 1)->get();
		
		}
				
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
    }
	
	
	public function getForClient($clientID, $currency = false, $userID = false) {
		
		$this->db->from('payments');
		$this->db->join('invoices', 'payments.invoice_id = invoices.invoice_id');
		$this->db->join('payment_types', 'payments.payment_type = payment_types.payment_type_id');
		$this->db->where('invoices.client_id', $clientID);
		$this->db->order_by('payment_date', 'DESC');
		
		if( $userID ) {
			
			$this->db->where('invoices.user_id', $userID);
			
		}
		
		if( $currency ) {
			
			$this->db->where('invoices.currency_id', $currency);
			
		}
		
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function getPaymentTypes() {
		
		$q = $this->db->from('payment_types')->get();
		
		return $q->result();
		
	}
	
	
	public function deleteForInvoice($invoiceID, $userID = false) {
		
		if( !$userID ) {
			
			//check if this user owns the invoice
			
			$q = $this->db->from('invoices')->where('invoice_id', $invoiceID)->where('user_id', $userID)->get();
			
			if( $q->num_rows() == 0 ) {
				
				return false;
				
			}
			
		}
		
		//delete attachments
		
		$q = $this->db->from('payments')->where('invoice_id', $invoiceID)->where('payment_proof !=', '')->get();
		
		if( $q->num_rows() > 0 ) {
			
			foreach( $q->result() as $row ) {
				
				unlink('./uploads/'.$row->payment_proof);
				
			}
			
		}
		
		
		$this->db->where('invoice_id', $invoiceID);
		$this->db->delete('payments');
		
	}
	
	
	public function addBatch( $payments, $invoiceID ) {
		
		foreach( $payments as $payment ) {
			
			$data = array(
				'invoice_id' => $invoiceID,
				'payment_amount' => $payment['amount'],
				'payment_date' => strtotime($payment['date']),
				'payment_type' => $payment['type']
			);
			
			$this->db->insert('payments', $data);
			
		}
		
	}
	
	
	public function addPayment($type, $data, $fileName = false) {
		
		if( $type == 'bank' ) {
			
			//grab the invoice first
			$theInvoice = $this->invoice_model->getInvoice($_POST['invoiceID']);
			
			if( !$theInvoice ) {
				
				return false;
				
			}
			
			//insert payment
			$pdata = array(
				'invoice_id' => $data['invoiceID'],
				'payment_amount' => $data['field_paymentAmount'],
				'payment_date' => time(),
				'payment_proof' => $fileName,
				'payment_type' => 1,
				'payment_active' => 1
			);
			
			$this->db->insert('payments', $pdata);
			
			//update invoice numbers
			$newPaidtodate = $theInvoice->invoice_paidtodate += $data['field_paymentAmount'];
			$newBalance = $theInvoice->invoice_balance -= $data['field_paymentAmount'];
			
			if( $newBalance <= 0 ) {
				$newStatus = 'paid';
			} else {
				$newStatus = $theInvoice->invoice_status;
			}
			
			$idata = array(
				'invoice_paidtodate' => $newPaidtodate,
				'invoice_balance' => $newBalance,
				'invoice_status' => $newStatus
			);
			
			$this->db->where('invoice_id', $theInvoice->invoice_id);
			$this->db->update('invoices', $idata);
			
			return true;
				
		} elseif( $type == 'paypal' ) {
			
			//grab the invoice first
			$theInvoice = $this->invoice_model->getInvoice($data['invoiceID']);
			
			if( !$theInvoice ) {
				
				return false;
				
			}
						
			//insert payment
			$pdata = array(
				'invoice_id' => $data['invoiceID'],
				'payment_amount' => $data['field_paymentAmount'],
				'payment_date' => time(),
				'payment_type' => 3,
				'payment_active' => 1
			);
			
			$this->db->insert('payments', $pdata);
						
			//update invoice numbers
			$newPaidtodate = $theInvoice->invoice_paidtodate += $data['field_paymentAmount'];
			$newBalance = $theInvoice->invoice_balance -= $data['field_paymentAmount'];
			
			if( $newBalance <= 0 ) {
				$newStatus = 'paid';
			} else {
				$newStatus = $theInvoice->invoice_status;
			}
			
			$idata = array(
				'invoice_paidtodate' => $newPaidtodate,
				'invoice_balance' => $newBalance,
				'invoice_status' => $newStatus
			);
			
			$this->db->where('invoice_id', $theInvoice->invoice_id);
			$this->db->update('invoices', $idata);
			
			return true;
			
		} elseif( $type == 'stripe' ) {
			
			//grab the invoice first
			$theInvoice = $this->invoice_model->getInvoice($data['invoiceID']);
			
			if( !$theInvoice ) {
				
				return false;
				
			}
						
			//insert payment
			$pdata = array(
				'invoice_id' => $data['invoiceID'],
				'payment_amount' => $data['field_paymentAmount'],
				'payment_date' => time(),
				'payment_type' => 2,
				'payment_active' => 1
			);
			
			$this->db->insert('payments', $pdata);
						
			//update invoice numbers
			$newPaidtodate = $theInvoice->invoice_paidtodate += $data['field_paymentAmount'];
			$newBalance = $theInvoice->invoice_balance -= $data['field_paymentAmount'];
			
			if( $newBalance <= 0 ) {
				$newStatus = 'paid';
			} else {
				$newStatus = $theInvoice->invoice_status;
			}
			
			$idata = array(
				'invoice_paidtodate' => $newPaidtodate,
				'invoice_balance' => $newBalance,
				'invoice_status' => $newStatus
			);
			
			$this->db->where('invoice_id', $theInvoice->invoice_id);
			$this->db->update('invoices', $idata);
			
			return true;
			
		}
		
	}
     
}