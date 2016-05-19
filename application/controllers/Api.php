<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		
		$this->load->database();
		$this->load->model(array('client_model', 'invoice_model', 'currency_model', 'payment_model', 'settings_model', 'api_model'));
		$this->load->helper(array('url'));
		$this->load->library(array('form_validation', 'ion_auth'));

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['clients_get']['limit'] = 100; // 500 requests per hour per user/key
        $this->methods['clients_put']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['clients_post']['limit'] = 100; // 50 requests per hour per user/key
		$this->methods['clients_post']['limit'] = 100; // 50 requests per hour per user/key
		
		if( $this->get( $this->config->item('rest_key_name')) !== null ) {
			
			$keyData = $this->api_model->getKey( $this->get($this->config->item('rest_key_name')) );
			
		} elseif( $this->post( $this->config->item('rest_key_name')) !== null ) {
			
			$keyData = $this->api_model->getKey( $this->post($this->config->item('rest_key_name')) );
			
		} elseif( $this->put( $this->config->item('rest_key_name')) !== null ) {
			
			$keyData = $this->api_model->getKey( $this->put($this->config->item('rest_key_name')) );
			
		} elseif( $this->delete( $this->config->item('rest_key_name')) !== null ) {
			
			$keyData = $this->api_model->getKey( $this->delete($this->config->item('rest_key_name')) );
			
		}
				
		//make sure the API is turned on
		
		$settings = $this->settings_model->getAll( $keyData->user_id );
		
		if( $settings[0]->api == 0 ) {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => "API is not activated"
            ], REST_Controller::HTTP_UNAUTHORIZED); 
			
		}
		
    }
	
	
	/*
		CLIENT section
	*/
	
	public function clients_get() {
		
		$id = $this->get('id');
		
		//return all clients
        if ($id === NULL) {
			            
			$clients = $this->client_model->getAll();
			
			if( $clients ) {
			
				$this->response($clients, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			} else {
				
                $this->response([
                    'status' => FALSE,
                    'message' => 'No clients were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
				
			}
			
        }
		
		//return individual client
		
		$id = (int) $id;
		
		$user = $this->client_model->getClient( $id );
		
		if( $user ) {
			
			$this->response($user, REST_Controller::HTTP_OK);
			
		} else {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'This client does not exist'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
		}
		
	}
	
	public function clients_put() {
						
		$keyData = $this->api_model->getKey( $this->put('X-API-KEY') );
		
		$this->form_validation->set_data($this->put());
				
		$this->form_validation->set_rules('field_clientName', 'field_clientName', 'required');
		$this->form_validation->set_rules('field_clientEmail', 'field_clientEmail', 'required|valid_email');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
									
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => strip_tags(validation_errors())
            ], REST_Controller::HTTP_BAD_REQUEST); 
		
		} else {
			
			$clientID = $this->client_model->create($this->put(), $keyData->user_id);
			
			if( $clientID ) {
			
				$client = $this->client_model->getClient( $clientID );
			
				$this->set_response($client, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
			
			} else {
				
	            $this->response([
	                'status' => FALSE,
	                'message' => "The client could not be created"
	            ], REST_Controller::HTTP_BAD_REQUEST); 
				
			}
			
		}
		
	}
	
	public function clients_post($clientID) {
		
		//verify clientID
		
		$client = $this->client_model->getClient($clientID);
		
		if( !$client ) {
			
            $this->response([
                'status' => FALSE,
                'message' => "The client does not exist"
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
								
		$this->form_validation->set_rules('field_clientName', 'Client name', 'required');
		$this->form_validation->set_rules('field_clientEmail', 'Client email', 'required|valid_email');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
									
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => strip_tags(validation_errors())
            ], REST_Controller::HTTP_BAD_REQUEST); 
		
		} else {
												
			$this->client_model->update($clientID, $this->post());
			
			$client = $this->client_model->getClient($clientID);
						
			$this->set_response($client, REST_Controller::HTTP_ACCEPTED);
			
		}
		
	}
	
	public function clients_delete($clientID) {
				
		$clientID = (int) $clientID;
		
		$client = $this->client_model->getClient( $clientID );
		
		if( $client ) {
			
			$this->client_model->delete($clientID);
			
	        // $this->some_model->delete_something($id);
	        $message = [
	            'id' => $clientID,
	            'message' => 'Deleted the resource'
	        ];
			
	        $this->response($message, REST_Controller::HTTP_OK);
			
		} else {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Client was not found'
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
	}
	
	
	
	/*
		INVOICE section
	*/
	
	public function invoices_get() {
		
		$id = $this->get('id');
		
		//return all invoices
        if ($id === NULL) {
			            
			$invoices = $this->invoice_model->getAll();
			
			if( $invoices ) {
			
				$this->response($invoices, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			} else {
				
                $this->response([
                    'status' => FALSE,
                    'message' => 'No invoices were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
				
			}
			
        }
		
		
		//return individual invoices
		
		$id = (int) $id;
		
		$invoice = $this->invoice_model->getInvoice( $id );
		
		if( $invoice ) {
			
			$this->response($invoice, REST_Controller::HTTP_OK);
			
		} else {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'This invoice does not exist'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
		}
		
	}
	
	public function invoices_put() {
		
		$keyData = $this->api_model->getKey( $this->put('X-API-KEY') );
		
		$this->form_validation->set_data($this->put());
				
		$this->form_validation->set_rules('clientID', 'Client ID', 'required|integer');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => strip_tags(validation_errors())
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		} else {
			
			$invoiceID = $this->invoice_model->createNew($this->put('clientID'), $keyData->user_id);
			
			$invoice = $this->invoice_model->getInvoice($invoiceID);
			
			$this->set_response($invoice, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
			
		}
		
	}
	
	public function invoices_post($invoiceID) {
		
		$keyData = $this->api_model->getKey( $this->post('X-API-KEY') );
		
		//verify the invoiceID
		
		$invoice = $this->invoice_model->getInvoice($invoiceID);
		
		if( !$invoice ) {
			
            $this->response([
                'status' => FALSE,
                'message' => "The invoice does not exist"
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
		$this->form_validation->set_rules('invoice_client', 'invoice_client', 'required|integer');
		$this->form_validation->set_rules('invoice_id', 'invoice_id', 'required|integer');
		$this->form_validation->set_rules('invoice_issueDate', 'invoice_issueDate', 'required');
		$this->form_validation->set_rules('invoice_duedate', 'invoice_duedate', 'required');
		$this->form_validation->set_rules('invoice_currenyName', 'invoice_currenyName', 'required');
		
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => strip_tags(validation_errors())
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		} else {
			
			$this->invoice_model->update($invoiceID, $this->post(), $keyData->user_id);
			
			$invoice = $this->invoice_model->getInvoice($invoiceID);
			
			$this->set_response($invoice, REST_Controller::HTTP_ACCEPTED);
			
		}
		
	}
	
	public function invoices_delete($invoiceID) {
		
		$invoiceID = (int) $invoiceID;
		
		$invoice = $this->invoice_model->getInvoice($invoiceID);
		
		if( $invoice ) {
			
			$this->invoice_model->deleteInvoice($invoiceID);
			
	        // $this->some_model->delete_something($id);
	        $message = [
	            'id' => $invoiceID,
	            'message' => 'Deleted the invoice'
	        ];
		
	        $this->response($message, REST_Controller::HTTP_OK);
			
		} else {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Invoice was not found'
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
	}
    
    
    /*
        Email section
    */
    public function email_post($invoiceID) {
        
        ini_set('MAX_EXECUTION_TIME', -1);
        
        $keyData = $this->api_model->getKey( $this->post('X-API-KEY') );
        
        //verify the invoiceID
		
		$theInvoice = $this->invoice_model->getInvoice($invoiceID, false, false);
        $theClient = $this->client_model->getClient($theInvoice->client_id, $keyData->user_id);
		
		if( !$theInvoice ) {
			
            $this->response([
                'status' => FALSE,
                'message' => "The invoice does not exist"
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
        
        $this->data['theInvoice'] = $theInvoice;
        $this->data['settings'] = $this->settings_model->getAll( $keyData->user_id );
        $this->data['user'] = $this->ion_auth->user($keyData->user_id)->row();
        
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('partials/invoice_pdf', $this->data, true);
						
        $output = pdf_create($html, $this->config->item('export_filename_prepend').$theInvoice->invoice_number, false);
			        
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/tmp/".$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf", $output);
        
        $this->load->library('email');

        $this->email->from($this->config->item('email_from_address'), $this->data['user']->company_name);
        $this->email->to( $theInvoice->client_email );
        
		//prep subject line
        $find = array('%invoice_number%', '%company_name%');
        $replace = array($theInvoice->invoice_number, $this->data['user']->company_name);
							
        $this->email->subject( str_replace($find, $replace, $this->config->item('email_default_subject')) );
        
        //prep subject line
        $invoiceUrl = '<a href="'.site_url('invoice/'.$theInvoice->invoice_code).'">'.site_url('invoice/'.$theInvoice->invoice_code).'</a>';
							
        $find = array('%client%', '%invoice_number%', '%invoice_link%', '%company_name%');
        $replace = array( ($theInvoice->client_contact != '')? $theInvoice->client_contact : $theInvoice->client_name, $theInvoice->invoice_number, $invoiceUrl, $this->data['user']->company_name);
							        
        $this->email->message( str_replace($find, $replace, $this->config->item('email_default_content')) );
				
        $this->email->attach('./tmp/'.$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf", 'attachment');
        
        unlink('./tmp/'.$this->config->item('export_filename_prepend').$theInvoice->invoice_number.".pdf");
        
        if( $this->email->send() ) {
        
            $message = [
                'id' => $invoiceID,
                'status' => true,
                'message' => 'Invoice sent to client ('.$theInvoice->client_email.')'
            ];
        
            $this->response($message, REST_Controller::HTTP_OK);
            
        } else {
            
            $message = [
                'id' => $invoiceID,
                'status' => true,
                'message' => 'Invoice could not be send to '.$theInvoice->client_email,
                'debug' => $this->email->print_debugger()
            ];
            
        }
        
    }
	
	
	
	/*
		PAYMENT section
	*/
	
	public function payments_get() {
		
		$keyData = $this->api_model->getKey( $this->get('X-API-KEY') );
		
		$getFor = $this->get('getFor');
		
		if( $getFor === null ) {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => "Please use the 'getFor' paramater to specify which invoices to retrieve"
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
		if( $this->get('getFor') == 'client' ) {
			
			$clientID = $this->get('client_id');
			
			if( $clientID === null ) {
				
	            // Set the response and exit
	            $this->response([
	                'status' => FALSE,
	                'message' => "Please supply a client ID using the 'client_id' parameter"
	            ], REST_Controller::HTTP_BAD_REQUEST); 
				
			} else {
				
				$client = $this->client_model->getClient($clientID);
				
				if( $client ) {
					
					$payments = $this->payment_model->getForClient($clientID, false, $keyData->user_id);
					
					if( !$payments ) {
						
			            // Set the response and exit
			            $this->response([
			                'status' => FALSE,
			                'message' => "No payments for this client"
			            ], REST_Controller::HTTP_NOT_FOUND); 
						
					} else {
					
						$this->response($payments, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					
					}
					
				} else {
					
		            // Set the response and exit
		            $this->response([
		                'status' => FALSE,
		                'message' => "Client does not exist"
		            ], REST_Controller::HTTP_BAD_REQUEST); 
					
				}
				
			}
			
		} elseif( $this->get('getFor') == 'invoice' ) {
			
			$invoiceID = $this->get('invoice_id');
			
			if( $invoiceID === null ) {
				
	            // Set the response and exit
	            $this->response([
	                'status' => FALSE,
	                'message' => "Please supply an invoice ID using the 'invoice_id' parameter"
	            ], REST_Controller::HTTP_BAD_REQUEST); 
				
			} else {
				
				$invoice = $this->invoice_model->getInvoice($invoiceID);
				
				if( $invoice ) {
					
					$payments = $this->payment_model->getForInvoice($invoiceID, $keyData->user_id);
					
					if( !$payments ) {
						
			            // Set the response and exit
			            $this->response([
			                'status' => FALSE,
			                'message' => "No payments for this invoice"
			            ], REST_Controller::HTTP_NOT_FOUND); 
						
					} else {
					
						$this->response($payments, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					
					}
					
				} else {
					
		            // Set the response and exit
		            $this->response([
		                'status' => FALSE,
		                'message' => "Invoice does not exist"
		            ], REST_Controller::HTTP_BAD_REQUEST); 
					
				}
				
			}
			
		} else {
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => "Wrong value for 'getFor', should be either 'client' or 'invoice'"
            ], REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
		/*
		$this->form_validation->set_data($this->get());
		
		$this->form_validation->set_rules('invoice_id', 'Invoice ID', 'required|integer');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => strip_tags(validation_errors())
            ], REST_Controller::HTTP_BAD_REQUEST); 
		
		} else {
			
			//make sure invoice exists
			
			$invoice = $this->invoice_model->getInvoice($this->get('invoice_id'));
			
			if( $invoice ) {
				
				
			} else {
				
	            // Set the response and exit
	            $this->response([
	                'status' => FALSE,
	                'message' => "Invoice does not exist"
	            ], REST_Controller::HTTP_BAD_REQUEST); 
				
			}
			
		}*/
		
	}

}
