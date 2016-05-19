<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
                
    }
    
	public function createNew($clientID, $userID) {
		
		$this->load->helper('string');
		
		$invoiceNr = $this->settings_model->nextInvoiceNr($userID);
				
		$data = array(
			'client_id' => $clientID,
			'user_id' => $userID,
			'invoice_number' => $invoiceNr,
			'invoice_date' => time(),
			'invoice_duedate' => time(),
			'invoice_items_head' => $this->config->item('invoice_itemtable_default_head'),
			'invoice_code' => random_string('alnum', 30)
		);

		$this->db->insert('invoices', $data);
		
		$insertID = $this->db->insert_id();
		
		//get the default currency for this client
		$client = $this->client_model->getClient( $clientID );
		
		//update stuff
		
		$data = array(
			'invoice_title' => $this->lang->line('invoice_number').' '.$invoiceNr,
			'currency_id' => $client->client_default_currency
		);
		
		$this->db->where('invoice_id', $insertID);
		$this->db->update('invoices', $data);
		
		return $insertID;
		
	}
	
	
	public function getInvoice($invoiceID, $userID = false, $public = false) {
		
		if( $public ) {//get for public viewing
			
			$q = $this->db->from('invoices')->where('invoice_code', $invoiceID)->where('invoice_active', 1)->where('invoice_public', 1)->join('currencies', 'invoices.currency_id = currencies.currency_shortname')->join('clients', 'invoices.client_id = clients.client_id')->join('users', 'users.id = invoices.user_id')->join('companies', 'users.company_id = companies.company_id')->join('config', 'config.user_id = users.id')->get();
						
		} else {//in-apps
			
			if( $userID ) {
			
				$q = $this->db->from('invoices')->where('invoice_id', $invoiceID)->where('invoices.user_id', $userID)->where('invoice_active', 1)->join('currencies', 'invoices.currency_id = currencies.currency_shortname')->join('clients', 'invoices.client_id = clients.client_id')->join('users', 'users.id = invoices.user_id')->join('companies', 'users.company_id = companies.company_id')->get();
						
			} else {
		
				$q = $this->db->from('invoices')->where('invoice_id', $invoiceID)->where('invoice_active', 1)->join('currencies', 'invoices.currency_id = currencies.currency_shortname')->join('clients', 'invoices.client_id = clients.client_id')->join('users', 'users.id = invoices.user_id')->join('companies', 'users.company_id = companies.company_id')->get();
								
			}
			
		}
		
		
		if( $q->num_rows() > 0 ) {
			
			$res = $q->result();
			
			return $res[0];
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function getForClient($clientID, $userID) {
		
		$q = $this->db->from('invoices')->where('client_id', $clientID)->where('user_id', $userID)->where('invoice_active', 1)->join('currencies', 'invoices.currency_id = currencies.currency_shortname')->order_by('invoice_date', 'DESC')->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
	}
    
	
	public function getAll($userID = false) {
		
		$this->db->from('invoices');
		$this->db->where('invoice_active', 1);
		$this->db->join('currencies', 'invoices.currency_id = currencies.currency_shortname');
		$this->db->join('clients', 'invoices.client_id = clients.client_id');
		$this->db->order_by('invoice_number', 'DESC');
		
		if( $userID ) {
			
			$this->db->where('invoices.user_id', $userID);
						
		}
		
		$q = $this->db->get();
		
		if( $q->num_rows() > 0 ) {
			
			return $q->result();
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function update($invoiceID, $data, $userID) {
		
		//die( "date: ".$data['invoice_issueDate'].", stamp: ".strtotime("27-1-2019") );
		
		//bank?		
		if( isset($data['invoice_paymentbank']) && $data['invoice_paymentbank'] == 1 ) {
			$bank = 1;
		} else {
			$bank = 0;
		}
		
		//stripe?
		if( isset($data['invoice_paymentstripe']) && $data['invoice_paymentstripe'] == 1 ) {
			$stripe = 1;
		} else {
			$stripe = 0;
		}
		
		//paypal?
		if( isset($data['invoice_paymentpaypal']) && $data['invoice_paymentpaypal'] == 1 ) {
			$paypal = 1;
		} else {
			$paypal = 0;
		}
				
		$cdata = array(
			'client_id' => $data['invoice_client'],
			'currency_id' => $data['invoice_currenyName'],
			'invoice_title' => (isset($data['invoice_title']))? $data['invoice_title'] : "",
			'invoice_status' => (isset($data['invoice_status']))? $data['invoice_status'] : "",
			'invoice_number' => $data['invoice_id'],
			'invoice_po' => (isset($data['invoice_po']))? $data['invoice_po'] : "",
			'invoice_date' => strtotime($data['invoice_issueDate']),
			'invoice_public' => (isset($data['invoice_public']))? $data['invoice_public'] : "",
			'invoice_recurring' => (isset($data['invoice_recurring']))? $data['invoice_recurring'] : "",
			'invoice_duedate' => strtotime($data['invoice_duedate']),
			'invoice_discount' => (isset($data['invoice_discountPercentage']))? $data['invoice_discountPercentage'] : "",
			'invoice_paymentbank' => $bank,
			'invoice_paymentstripe' => $stripe,
			'invoice_paymentpaypal' => $paypal,
			'invoice_taxtype' => (isset($data['invoice_taxType']))? $data['invoice_taxType'] : "",
			'invoice_taxamount' => (isset($data['invoice_taxPercentage']))? $data['invoice_taxPercentage'] : "",
			'invoice_topnote' => (isset($data['invoice_topNote']))? $data['invoice_topNote'] : "",
			'invoice_bottomnote' => (isset($data['invoice_bottomNote']))? $data['invoice_bottomNote'] : "",
			'invoice_notes' => (isset($data['invoice_notes']))? $data['invoice_notes'] : "",
			'invoice_items_head' => (isset($data['invoice_items_head']))? trim($data['invoice_items_head']) : "",
			'invoice_items_body' => (isset($data['invoice_items_body']))? trim($data['invoice_items_body']) : "",
			'invoice_subtotal' => (isset($data['invoice_subTotal']))? $data['invoice_subTotal'] : "",
			'invoice_paidtodate' => (isset($data['invoice_paidToDate']))? $data['invoice_paidToDate'] : "",
			'invoice_balance' => (isset($data['invoice_balanceDue']))? $data['invoice_balanceDue'] : ""
		);
		
		$this->db->where('invoice_id', $invoiceID);
		$this->db->where('invoice_active', 1);
		$this->db->update('invoices', $cdata);
							
		//do we have payments?
					
		if( isset($data['payments']) ) {
			
			$this->load->model('payment_model');
				
			$payments = json_decode($data['payments'], true);
			
			//delete old payments
			
			$this->payment_model->deleteForInvoice($invoiceID, $userID);
			
			$this->payment_model->addBatch( $payments, $invoiceID );
				
		} else {
			
			//no payments, delete old ones to be sure
			
			$this->payment_model->deleteForInvoice($invoiceID, $userID);
			
		}
			
		return true;
		
		
	}
	
	
	public function deleteInvoice($invoiceID) {
		
		//start by de-activating payments
		
		$data = array(
			'payment_active' => 0
		);
		
		$this->db->where('invoice_id', $invoiceID);
		$this->db->update('payments', $data);
		
		
		//moving on the invoice
		
		$data = array(
			'invoice_active' => 0
		);
		
		$this->db->where('invoice_id', $invoiceID);
		$this->db->update('invoices', $data);
		
		if( $this->db->affected_rows() > 0 ) {
			
			return true;
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function getTotalPaid( $currencyID, $dateFrom, $dateUntil, $userID = false, $clientID = false) {
	
		$this->db->from('invoices')->select_sum('invoice_paidtodate')->where('invoice_date >=', $dateFrom)->where('invoice_date <=', $dateUntil)->where('currency_id', $currencyID)->where('invoice_active', 1);
	
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
						
		}
		
		if( $clientID ) {
			
			$this->db->where('client_id', $clientID);
			
		}
		
		$q = $this->db->get();
						
		$res = $q->result();
		
		if( $res[0]->invoice_paidtodate != NULL ) {
		
			return $res[0]->invoice_paidtodate;
		
		} else {
		
			return 0.00;
		
		}
		
	}
	
	
	public function getTotalDue( $currencyID, $dateFrom, $dateUntil, $userID = false, $clientID = false) {
		
		$this->db->from('invoices')->select_sum('invoice_balance')->where('invoice_date >=', $dateFrom)->where('invoice_date <=', $dateUntil)->where('currency_id', $currencyID)->where('invoice_status', 'due')->where('invoice_active', 1);
				
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
				
		}
		
		if( $clientID ) {
			
			$this->db->where('client_id', $clientID);
			
		}
		
		$q = $this->db->get();
				
		$res = $q->result();
		
		if( $res[0]->invoice_balance != NULL ) {
		
			return $res[0]->invoice_balance;
		
		} else {
		
			return 0.00;
		
		}
		
	}
	
	
	public function getTotalPastDue( $currencyID, $dateFrom, $dateUntil, $userID = false, $clientID = false) {
		
		$this->db->from('invoices')->select_sum('invoice_balance')->where('invoice_date >=', $dateFrom)->where('invoice_date <=', $dateUntil)->where('currency_id', $currencyID)->where('invoice_status', 'past due')->where('invoice_active', 1);
		
		if( $userID ) {
			
			$this->db->where('user_id', $userID);
			
		}
		
		if( $clientID ) {
			
			$this->db->where('client_id', $clientID);
			
		}
		
		$q = $this->db->get();
				
		$res = $q->result();
		
		if( $res[0]->invoice_balance != NULL ) {
		
			return $res[0]->invoice_balance;
		
		} else {
						
			return 0.00;
		
		}
		
	}
	
	
	public function getPaidForYear($year, $currencyID, $userID = false, $clientID = false) {
		
		if( $userID ) {
			
			if( $clientID ) {
				
				$q = $this->db->query("
					SELECT
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jan '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Feb '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jan`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Feb '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Mar '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Feb`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Mar '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Apr '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Mar`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Apr '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 May '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Apr`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 May '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jun '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `May`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jun '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jul '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jun`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jul '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Aug '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jul`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Aug '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Sep '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Aug`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Sep '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Oct '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Sep`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Oct '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Nov '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Oct`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Nov '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Nov`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Dec '.$year))." && `payment_date` < ".$this->db->escape(strtotime('31 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Dec`
					FROM `payments`
					JOIN `invoices` ON `payments`.`invoice_id` = `invoices`.`invoice_id`
					WHERE `user_id` = ".$this->db->escape($userID)." && `invoice_active` = '1'
				");
				
			} else {
			
				$q = $this->db->query("
					SELECT
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jan '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Feb '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jan`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Feb '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Mar '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Feb`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Mar '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Apr '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Mar`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Apr '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 May '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Apr`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 May '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jun '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `May`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jun '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jul '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jun`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jul '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Aug '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jul`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Aug '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Sep '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Aug`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Sep '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Oct '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Sep`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Oct '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Nov '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Oct`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Nov '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Nov`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Dec '.$year))." && `payment_date` < ".$this->db->escape(strtotime('31 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Dec`
					FROM `payments`
					JOIN `invoices` ON `payments`.`invoice_id` = `invoices`.`invoice_id`
					WHERE `user_id` = ".$this->db->escape($userID)." && `invoice_active` = '1'
				");
			
			}
			
		} else {
			
			if( $clientID ) {
				
				$q = $this->db->query("
					SELECT
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jan '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Feb '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jan`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Feb '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Mar '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Feb`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Mar '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Apr '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Mar`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Apr '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 May '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Apr`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 May '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jun '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `May`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jun '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jul '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jun`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jul '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Aug '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Jul`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Aug '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Sep '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Aug`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Sep '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Oct '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Sep`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Oct '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Nov '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Oct`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Nov '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Nov`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Dec '.$year))." && `payment_date` < ".$this->db->escape(strtotime('31 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID)." && `client_id` = ".$this->db->escape($clientID).", payment_amount, 0)) as `Dec`
					FROM `payments`
					JOIN `invoices` ON `payments`.`invoice_id` = `invoices`.`invoice_id`
					WHERE `user_id` = ".$this->db->escape($userID)." && `invoice_active` = '1'
				");
				
			} else {
			
				$q = $this->db->query("
					SELECT
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jan '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Feb '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jan`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Feb '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Mar '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Feb`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Mar '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Apr '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Mar`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Apr '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 May '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Apr`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 May '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jun '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `May`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jun '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Jul '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jun`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Jul '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Aug '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Jul`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Aug '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Sep '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Aug`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Sep '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Oct '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Sep`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Oct '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Nov '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Oct`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Nov '.$year))." && `payment_date` < ".$this->db->escape(strtotime('1 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Nov`,
					SUM(IF(`payment_date` > ".$this->db->escape(strtotime('1 Dec '.$year))." && `payment_date` < ".$this->db->escape(strtotime('31 Dec '.$year))." && `currency_id` = ".$this->db->escape($currencyID).", payment_amount, 0)) as `Dec`
					FROM `payments`
					JOIN `invoices` ON `payments`.`invoice_id` = `invoices`.`invoice_id`
					WHERE `user_id` = ".$this->db->escape($userID)." && `invoice_active` = '1'
				");
			
			}
			
		}
		
		$res = $q->result();
		
		return $res[0];
		
	}
	
	
	public function checkStatus() {
		
		$q = $this->db->from('invoices')->get();
		
		if( $q->num_rows() > 0 ) {
			
			foreach( $q->result() as $invoice ) {
			
				if( time() > $invoice->invoice_duedate && $invoice->invoice_status == 'due' ) {
					
					$data = array(
						'invoice_status' => 'past due'
					);
					
					$this->db->where('invoice_id', $invoice->invoice_id);
					$this->db->update('invoices', $data);
					
				}
				
			}
			
		} else {
			
			return false;
			
		}
		
	}
	
	
	public function checkRecurring() {
		
		$q = $this->db->from('invoices')->where('invoice_recurring !=', 0)->get();
		
		if( $q->num_rows() > 0 ) {
			
			foreach( $q->result() as $invoice ) {
			
				if( $invoice->invoice_recurring == 1 ) {
					
					$nextInvoiceDate = date('Y-m-d', strtotime('+1 month', $invoice->invoice_date));
										
				} elseif( $invoice->invoice_recurring == 3 ) {
					
					$nextInvoiceDate = date('Y-m-d', strtotime('+3 months', $invoice->invoice_date));
										
				} elseif( $invoice->invoice_recurring == 6 ) {
				
					$nextInvoiceDate = date('Y-m-d', strtotime('+6 months', $invoice->invoice_date));
														
				} elseif( $invoice->invoice_recurring == 12 ) {
				
					$nextInvoiceDate = date('Y-m-d', strtotime('+12 months', $invoice->invoice_date));
														
				}
				
				
				//do we do a new invoice today?
				
				if( date('Y-m-d') == $nextInvoiceDate ) {
					
					$newInvoiceID = $this->createNew($invoice->client_id, $invoice->user_id);
					
					//copy stuff from original invoice to the new invoice
					$data = array(
						'currency_id' => $invoice->currency_id,
						'invoice_title' => $invoice->invoice_title,
						'invoice_status' => 'due',
						'invoice_po' => $invoice->invoice_po,
						'invoice_public' => $invoice->invoice_public,
						'invoice_recurring' => $invoice->invoice_recurring,
						'invoice_duedate' => strtotime( '+'.$invoice->invoice_recurring." months", $invoice->invoice_duedate),
						'invoice_discount' => $invoice->invoice_discount,
						'invoice_paymentbank' => $invoice->invoice_paymentbank,
						'invoice_paymentstripe' => $invoice->invoice_paymentstripe, 
						'invoice_paymentpaypal' => $invoice->invoice_paymentpaypal,
						'invoice_taxtype' => $invoice->invoice_taxtype,
						'invoice_taxamount' => $invoice->invoice_taxamount,
						'invoice_topnote' => $invoice->invoice_topnote,
						'invoice_bottomnote' => $invoice->invoice_bottomnote,
						'invoice_notes' => $invoice->invoice_notes,
						'invoice_items_head' => $invoice->invoice_items_head,
						'invoice_items_body' => $invoice->invoice_items_body,
						'invoice_subtotal' => $invoice->invoice_subtotal,
						'invoice_paidtodate' => $invoice->invoice_paidtodate,
						'invoice_balance' => $invoice->invoice_balance,
						'invoice_code' => random_string('alnum', 30),
						'invoice_autogenerated' => 1,
						'invoice_active' => $invoice->invoice_active
					);
					
					$this->db->where('invoice_id', $newInvoiceID);
					$this->db->update('invoices', $data);
					
					
					//notify user
					
					$theInvoice = $this->getInvoice($newInvoiceID);
					
					//echo $newInvoiceID;
					
					//echo "<br><br>";
					
					//print_r($theInvoice);
					
					//send out email to client
					$this->load->library('email');
			
					$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
					$this->email->to( $theInvoice->client_email );
			
					$this->email->subject( $this->config->item('email_new_recurring_subject') );
			
					$data = array(
						'name' => $theInvoice->first_name." ".$theInvoice->last_name,
						'title' => $theInvoice->invoice_title,
						'createdon' => date($this->config->item('date_format_php'), $theInvoice->invoice_date),
						'dueon' => date($this->config->item('date_format_php'), $theInvoice->invoice_duedate),
						'currency' => $theInvoice->currency_sign,
						'amount' => $theInvoice->invoice_balance,
						'url' => site_url('invoice/'.$theInvoice->invoice_code),
						'email' => $theInvoice->email
					);
			
					$this->email->message( $this->load->view('emails/new_recurring', $data, true) );
			
					$this->email->send();
										
				}
				
			}
			
		} else {
			
			return false;
			
		}
		
	}
 	
	
}