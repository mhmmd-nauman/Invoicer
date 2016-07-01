<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url', 'dompdf_helper', 'string'));
		$this->load->model(array('currency_model', 'client_model', 'invoice_model', 'payment_model', 'settings_model', 'api_model','package_model'));
		$this->load->library(array('ion_auth', 'form_validation'));

		if( $this->ion_auth->logged_in() ) {

			$this->data['user'] = $this->ion_auth->user()->row();
			$this->user = $this->ion_auth->user()->row();

			$this->data['clients'] = $this->client_model->getAll( $this->data['user']->id );
			$this->data['invoices'] = $this->invoice_model->getAll( $this->data['user']->id );
			$this->data['settings'] = $this->settings_model->getAll( $this->data['user']->id );
			$this->data['keys'] = $this->api_model->getKeys();

		} else {

		}


		$this->data['currencies'] = $this->currency_model->getAll();
		$this->data['allCurrencies'] = $this->data['currencies'];
		$this->data['paymentTypes'] = $this->payment_model->getPaymentTypes();


	}

	public function index() {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		$this->data['page'] = 'invoices';

		$this->load->view('invoices', $this->data);

	}

	public function get($invoiceID) {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		$theInvoice = $this->invoice_model->getInvoice($invoiceID, $this->data['user']->id);

		if( !$theInvoice ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_get_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices', 'location');

		}

		$this->data['page'] = 'invoices';
		$this->data['theInvoice'] = $theInvoice;
		$this->data['payments'] = $this->payment_model->getForInvoice($invoiceID, $this->data['user']->id);
                // pass the package info
                $user = $this->ion_auth->user()->row();
                $package = $this->package_model->getPackageInfo($user->package_id);
                $this->data['package'] = $package;
                //
		$this->load->view('invoices', $this->data);

	}

	public function getPublic($invoiceID) {

		$theInvoice = $this->invoice_model->getInvoice($invoiceID, false, true);

		if( !$theInvoice ) {

			show_404();

		} else {

			//security hash

			$hash = random_string('md5');

			$this->session->set_flashdata('hash', $hash);

			$this->data['hash'] = $hash;

			$this->data['page'] = 'invoices';
			$this->data['theInvoice'] = $theInvoice;

            //get the settings
            $this->data['settings'] = $this->settings_model->getAll( $theInvoice->user_id );

			$this->data['payments'] = $this->payment_model->getForInvoice($invoiceID, false);

			$this->load->view('partials/invoice_public', $this->data);

		}

	}

	public function getPDF($invoiceID, $inside = false) {

		if( $inside ) {//called from witin the app

			$theInvoice = $this->invoice_model->getInvoice($invoiceID);

		} else {

			$theInvoice = $this->invoice_model->getInvoice($invoiceID, false, true);

		}

		if( !$theInvoice ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_getPDF_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices', 'location');

		}

		$this->data['theInvoice'] = $theInvoice;
                $user = $this->ion_auth->user()->row();
                $package = $this->package_model->getPackageInfo($user->package_id);
                $this->data['package'] = $package;

		$this->load->helper(array('dompdf', 'file'));

		$html = $this->load->view('partials/invoice_pdf', $this->data, true);

		pdf_create($html, $this->config->item('export_filename_prepend').$theInvoice->invoice_number);

		//$this->load->view('partials/invoice_pdf', $this->data);

	}

	public function create($clientID) {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		//check the clientID

		if( !$this->client_model->getClient($clientID) ) {//error

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_create_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices', 'location');

		}

		//client ID is good

		$invoiceID = $this->invoice_model->createNew($clientID, $this->data['user']->id);

		$alert = array();
		$alert['alertHeading'] = $this->lang->line('success');
		$alert['alertContent'] = $this->lang->line('invoices_create_success');

		$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

		redirect('invoices/'.$invoiceID, 'location');

	}


	/*
		ajax function
	*/

	public function update($invoiceID = '') {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		$return = array();

		if( $invoiceID == '' || $invoiceID == 'undefined' || !$this->invoice_model->getInvoice($invoiceID) || !$this->invoice_model->getInvoice($invoiceID, $this->data['user']->id) ) {

			$return['code'] = 0;

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_update_error1');

			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

			die( json_encode( $return ) );

		}

		//all good :)

		//validate the form

		$this->form_validation->set_rules('invoice_client', $this->lang->line('client'), 'required|integer');
		$this->form_validation->set_rules('invoice_id', $this->lang->line('invoice_number'), 'required');
		$this->form_validation->set_rules('invoice_issueDate', $this->lang->line('issue_date'), 'required');
		$this->form_validation->set_rules('invoice_duedate', $this->lang->line('due_date'), 'required');
		$this->form_validation->set_rules('invoice_currenyName', $this->lang->line('currency'), 'required');

		if ($this->form_validation->run() == FALSE) {//validation failed

			$return['code'] = 0;

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_update_erorr2').validation_errors();

			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

			die( json_encode( $return ) );

		} else {

			$this->invoice_model->update($invoiceID, $_POST, $this->data['user']->id);

			$return['code'] = 1;

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('invoices_update_success1');

			$return['content'] = $this->load->view('alerts/alert_success', $alert, true);

			die( json_encode( $return ) );


		}

	}


	public function uploadData() {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = 'csv';
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if( $this->upload->do_upload('field_file') ) {//all good with the uploaded image

			$this->load->library('csvreader');

			//grab file data
			$fileData = $this->upload->data();

			$dilimiter = $this->csvreader->guessDelimiter(base_url()."/tmp/".$fileData['file_name']);
			$enclosure = '"';

			$file = fopen(base_url()."/tmp/".$fileData['file_name'],"r");

			$firstRow = fgetcsv($file, 1000, $dilimiter, $enclosure);

	    	$this->csvreader->separator = $dilimiter;
	    	$this->csvreader->enclosure = $enclosure;

			$res = $this->csvreader->parse_file($fileData['full_path'], $firstRow);

			//print_r($res);

			//we'll need to test the parsed data and make sure the last column contains only numeric values

			for( $x=2; $x<=count($res); $x++ ) {

				$length = count($res[$x])-1;

				if( !is_numeric( $res[$x][$length] ) ) {

					$return['code'] = 0;

					$alert = array();
					$alert['alertHeading'] = $this->lang->line('error');
					$alert['alertContent'] = $this->lang->line('invoices_uploadData_error1');

					$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

					die( json_encode( $return ) );

				}

			}


			$return['code'] = 1;

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('invoices_uploadData_success1');

			$return['content'] = $this->load->view('alerts/alert_success', $alert, true);

			$return['data'] = $res;

			//delete the file
			unlink($fileData['full_path']);

			die( json_encode( $return ) );


		} else {

			$return['code'] = 0;

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_uploadData_error2').$this->upload->display_errors();

			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

			die( json_encode( $return ) );

		}

	}


	public function delete($invoiceID = '') {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		$return = array();

		if( $invoiceID == '' || $invoiceID == 'undefined' || !$this->invoice_model->getInvoice($invoiceID) || !$this->invoice_model->getInvoice($invoiceID, $this->data['user']->id) ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_delete_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices', 'location');

		}

		//all good, delete the invoice

		if( $this->invoice_model->deleteInvoice($invoiceID) ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('invoices_delete_success1');

			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

			redirect('invoices', 'location');

		} else {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_delete_error2');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices', 'location');

		}

	}


	public function send() {

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}

		//validate the form

		$this->form_validation->set_rules('invoiceID', $this->lang->line('invoice_id'), 'required|integer');
		$this->form_validation->set_rules('clientID', $this->lang->line('client_id'), 'required|integer');
		$this->form_validation->set_rules('field_emailAddress', $this->lang->line('email_address'), 'required|valid_email');
		$this->form_validation->set_rules('field_emailSubject', $this->lang->line('email_subject'), 'required');
		$this->form_validation->set_rules('field_emailContent', $this->lang->line('email_content'), 'required');

		if ($this->form_validation->run() == FALSE) {//validation failed

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_send_error1').validation_errors();

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoices/'.$_POST['invoiceID'], 'location');

		} else {

			//make sure the invoice belongs to this user

			if( !$this->invoice_model->getInvoice($_POST['invoiceID'], $this->data['user']->id )) {

				$alert = array();
				$alert['alertHeading'] = $this->lang->line('error');
				$alert['alertContent'] = $this->lang->line('invoices_send_error2');

				$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

				redirect('invoices/'.$_POST['invoiceID'], 'location');

			}


			//create the PDF invoice first

			$theInvoice = $this->invoice_model->getInvoice($_POST['invoiceID'], false, false);
			$theClient = $this->client_model->getClient($_POST['clientID'], $this->data['user']->id);

			if( $theInvoice && $theClient ) {

				$this->data['theInvoice'] = $theInvoice;

				$this->load->helper(array('dompdf', 'file'));
				$html = $this->load->view('partials/invoice_pdf', $this->data, true);

				$output = pdf_create($html, $this->config->item('export_filename_prepend').$theInvoice->invoice_number, false);

				file_put_contents("./tmp/".$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf", $output);


				//send the email

				$this->load->library('email');

				$this->email->from($this->config->item('email_from_address'), $this->data['user']->company_name);
				$this->email->to( $_POST['field_emailAddress'] );

				if( isset($_POST['checkbox_sendcc']) && $_POST['checkbox_sendcc'] == 1 ) {
					$this->email->cc( $this->data['user']->email );
				}

				$this->email->subject( $_POST['field_emailSubject'] );
				$this->email->message( $_POST['field_emailContent'] );

				$this->email->attach('./tmp/'.$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf", 'attachment');

				if( $this->email->send() ) {

					$alert = array();
					$alert['alertHeading'] = $this->lang->line('success');
					$alert['alertContent'] = $this->lang->line('invoices_send_success1').$theClient->client_name." (".$_POST['field_emailAddress'].")";

					$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

					redirect('invoices/'.$_POST['invoiceID'], 'location');


				} else {

					$alert = array();
					$alert['alertHeading'] = $this->lang->line('error');
					$alert['alertContent'] = $this->lang->line('invoices_send_error3')."<br><br><b>Please see the debugging information below:</b><br>".$this->email->print_debugger();

					$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

					redirect('invoices/'.$_POST['invoiceID'], 'location');

				}

				unlink('./tmp/'.$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf");

				//echo $this->email->print_debugger(array('headers'));

			}

		}

	}


	public function addPayment() {

		//check the hash

		if( !isset($_POST['invoiced_hash']) || $_POST['invoiced_hash'] == '' || $_POST['invoiced_hash'] != $this->session->flashdata('hash') ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_addPayment_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoice/'.$_POST['invoiceCode'], 'location');

		}

		//all good I guess :)

		$this->form_validation->set_rules('field_paymentAmount', $this->lang->line('payment_amount_label'), 'required');
		$this->form_validation->set_rules('invoiceID', $this->lang->line('invoice_id'), 'required|integer');
		$this->form_validation->set_rules('invoiceCode', $this->lang->line('invoice_code'), 'required');

		if ($this->form_validation->run() == FALSE) {//validation failed

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_addPayment_error2').validation_errors();

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('invoice/'.$_POST['invoiceCode'], 'location');

		} else {

			$fileName = random_string('alnum', 25);

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|pdf|tiff|tif|html|htm|txt|doc|docx|zip';
			$config['max_size'] = 20480;
			$config['file_name'] = $fileName;

			$this->load->library('upload', $config);

			if( $this->upload->do_upload('field_file') ) {//all good with the uploaded image

				//all good, yay!

				$theFile = $this->upload->data('file_name');

				if( $this->payment_model->addPayment('bank', $_POST, $theFile) ) {


					//get invoice data from db
					$invoice = $this->invoice_model->getInvoice($_POST['invoiceCode'], false, true);

					if( $invoice ) {

						//send out email to self
						$this->load->library('email');

						$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
						$this->email->to( $invoice->email );

						$this->email->subject( $this->config->item('email_payment_company_subject') );

						$data = array(
							'name' => $invoice->first_name." ".$invoice->last_name,
							'amount' => $_POST['field_paymentAmount'],
							'currency' => $invoice->currency_sign,
							'method' => 'Bank',
							'invoice_number' => $invoice->invoice_number
						);

						$this->email->message( $this->load->view('emails/payment_self', $data, true) );

						$this->email->send();


						//send out email to client
						$this->load->library('email');

						$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
						$this->email->to( $invoice->client_email );

						$this->email->subject( $this->config->item('email_payment_client_subject') );

						$data = array(
							'name' => $invoice->client_name,
							'amount' => $_POST['field_paymentAmount'],
							'currency' => $invoice->currency_sign,
							'method' => 'Bank',
							'invoice_number' => $invoice->invoice_number,
							'paidtodate' => $invoice->invoice_paidtodate,
							'balance' => $invoice->invoice_balance,
							'email' => $invoice->email
						);

						$this->email->message( $this->load->view('emails/payment_client', $data, true) );

						$this->email->send();


					}


					$alert = array();
					$alert['alertHeading'] = $this->lang->line('success');
					$alert['alertContent'] = $this->lang->line('invoices_addPayment_success1');

					$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

					redirect('invoice/'.$_POST['invoiceCode'], 'location');

				}

			} else {//error

				$alert = array();
				$alert['alertHeading'] = $this->lang->line('error');
				$alert['alertContent'] = $this->lang->line('invoices_addPayment_error3').$this->upload->display_errors();

				$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

				redirect('invoice/'.$_POST['invoiceCode'], 'location');

			}

		}

	}


	public function paypalNotify($code) {

		define("DEBUG", 0);

		// Set to 0 once you're ready to go live
		define("USE_SANDBOX", 0);
		define("LOG_FILE", "./ipn.log");

		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();

		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}

		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}

		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}

		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}

		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}

		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}

		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;
		} else {

			curl_close($ch);

		}
		// Inspect IPN validation result and act accordingly
		// Split response headers and payload, a better way for strcmp
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];

			//retrieve the invoice

			$invoice = $this->invoice_model->getInvoice($code, false, true);

			if( $invoice && $_POST['payment_status'] == 'Completed' ) {

				//add payment to database as Paypal payment

				/*$message = "
				item name: ".$_POST['item_name']."\n
				payment amount: ".$_POST['mc_gross']."\n
				payment status: ".$_POST['payment_status'];

				mail('mjnaus@gmail.com', 'IPN stuff', $message);*/

				$data = array(
					'invoiceID' => $invoice->invoice_id,
					'field_paymentAmount' => $_POST['mc_gross']
				);

				$this->payment_model->addPayment('paypal', $data);


				//get the updated invoice data from db
				$invoice = $this->invoice_model->getInvoice($code, false, true);


				//send out email to self
				$this->load->library('email');

				$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
				$this->email->to( $invoice->email );

				$this->email->subject( $this->config->item('email_payment_company_subject') );

				$data = array(
					'name' => $invoice->first_name." ".$invoice->last_name,
					'amount' => $_POST['mc_gross'],
					'currency' => $invoice->currency_sign,
					'method' => 'Paypal',
					'invoice_number' => $invoice->invoice_number
				);

				$this->email->message( $this->load->view('emails/payment_self', $data, true) );

				$this->email->send();



				//send out email to client
				$this->load->library('email');

				$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
				$this->email->to( $invoice->client_email );

				$this->email->subject( $this->config->item('email_payment_client_subject') );

				$data = array(
					'name' => $invoice->client_name,
					'amount' => $_POST['mc_gross'],
					'currency' => $invoice->currency_sign,
					'method' => 'Paypal',
					'invoice_number' => $invoice->invoice_number,
					'paidtodate' => $invoice->invoice_paidtodate,
					'balance' => $invoice->invoice_balance,
					'email' => $invoice->email
				);

				$this->email->message( $this->load->view('emails/payment_client', $data, true) );

				$this->email->send();


			}


		}

	}


	public function pay( $code ) {

		$theInvoice = $this->invoice_model->getInvoice($code, false, true);

		$paypalUrl = 'https://www.paypal.com/cgi-bin/webscr?business='.$theInvoice->paypal_email.'&cmd=_xclick&currency_code='.$theInvoice->currency_shortname.'&amount='.urlencode($theInvoice->invoice_balance).'&item_name=Payment%20for%20invoice%20'.urlencode($theInvoice->invoice_number)."&return=".urlencode(site_url('invoice/'.$theInvoice->invoice_code))."&notify_url=".urlencode(site_url('invoices/paypalNotify/'.$theInvoice->invoice_code));

		//echo $paypalUrl;

		redirect($paypalUrl, 'location');

	}


	public function stripeProcess( $code ) {

		$theInvoice = $this->invoice_model->getInvoice($code, false, true);

		if( $theInvoice ) {

			require_once(APPPATH.'libraries/stripe-php-2.3.0/init.php');

			\Stripe\Stripe::setApiKey( $theInvoice->stripe_secret );

			$token  = $_POST['id'];

			$customer = \Stripe\Customer::create(array(
				'email' => $_POST['email'],
				'card'  => $token
			));

			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $theInvoice->invoice_balance*100,
				'currency' => $theInvoice->currency_shortname
			));

			$return = array();
			$return['status'] = $charge->status;

			if( $charge->status == 'paid' || $charge->status == 'succeeded' ) {

				//all good

				//process payment into the system

				$data = array(
					'invoiceID' => $theInvoice->invoice_id,
					'field_paymentAmount' => $charge->amount/100,
				);

				$this->payment_model->addPayment('stripe', $data);


				//grab updated invoice data from db
				$theInvoice = $this->invoice_model->getInvoice($code, false, true);


				$alert['alertHeading'] = $this->lang->line('success');
				$alert['alertContent'] = $this->lang->line('invoices_stripeProcess_success1');

				$return['content'] = $this->load->view('alerts/alert_success', $alert, true);


				//send out email to self
				$this->load->library('email');

				$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
				$this->email->to( $theInvoice->email );

				$this->email->subject( $this->config->item('email_payment_company_subject') );

				$data = array(
					'name' => $theInvoice->first_name." ".$theInvoice->last_name,
					'amount' => $charge->amount/100,
					'currency' => $theInvoice->currency_sign,
					'method' => 'Stripe',
					'invoice_number' => $theInvoice->invoice_number
				);

				$this->email->message( $this->load->view('emails/payment_self', $data, true) );

				$this->email->send();


				//send out email to client
				$this->load->library('email');

				$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
				$this->email->to( $theInvoice->client_email );

				$this->email->subject( $this->config->item('email_payment_client_subject') );

				$data = array(
					'name' => $theInvoice->client_name,
					'amount' => $charge->amount/100,
					'currency' => $theInvoice->currency_sign,
					'method' => 'Stripe',
					'invoice_number' => $theInvoice->invoice_number,
					'paidtodate' => $theInvoice->invoice_paidtodate,
					'balance' => $theInvoice->invoice_balance,
					'email' => $theInvoice->email
				);

				$this->email->message( $this->load->view('emails/payment_client', $data, true) );

				$this->email->send();


			} else {

				//not good

				$alert = array();
				$alert['alertHeading'] = $this->lang->line('error');
				$alert['alertContent'] = $this->lang->line('invoices_stripeProcess_error1');

				$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

			}

		} else {

			//invoice does not exist

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('invoices_stripeProcess_error2');

			$return['content'] = $this->load->view('alerts/alert_error', $alert, true);

		}

		echo json_encode( $return );

	}

}
