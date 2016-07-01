<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
date_default_timezone_set('America/Los_Angeles');

define("AUTHORIZENET_LOG_FILE", "phplog");
class Packages extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model(array('package_model'));
		$this->load->library(array('ion_auth', 'form_validation'));
		
		if( !$this->ion_auth->logged_in() ) {
			
			redirect('login');
			
		}
		
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();
		
		include APPPATH . 'third_party/vendor/autoload.php';
		
	}

	public function index() {
		
		$this->data['page'] = 'packages';
		$this->data['packages'] = $this->package_model->getActive();
                //print_r($this->data['packages']);
		$this->load->view('packages', $this->data);
		
	}
	
	
	public function update() {
		//process the subscription 
                $package_confirmation = $this->input->post('package_confirmation');
                if($package_confirmation){
                    // now process subscription
                    $_POST = $this->session->userdata('posted_data');
                    $data = array(
				'package_id' => $_POST['package'],
				);
                    $user = $this->ion_auth->user()->row();
                    
                    $response = $this->create_recurring_order(30,$_POST);
                    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
                    {
                        $this->ion_auth->update($user->id, $data);
                        $SubscriptionID = $response->getSubscriptionId();
                        $_POST['user_id']=$user->id;
                        $package_data = $this->package_model->getAll($_POST['package']);
                        $amount = 1.00;
                        if($package_data){
                            $amount = $package_data[0]->price;
                        }
                        $_POST['amount']=$amount;
                        $old_subs_data = $this->package_model->getsubscription($user->id);
                        if($old_subs_data){
                            $oldsubscription = $old_subs_data->subscription_id;
                            $this->cancelSubscription($oldsubscription);
                            $this->package_model->updatesubscription($oldsubscription->id,array("status"=>0));
                        }
                        // create new subscription 
                        $this->package_model->createsubscription($_POST,$SubscriptionID);
                        // cancel the old subscription
                        
                        $alert = array();
                        $alert['alertHeading'] = $this->lang->line('success');
                        $alert['alertContent'] = "Package updated.";

                        $this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));
                        // send the customer email
                        $this->load->library('email');
                        $from_email = 'mhmmd.nauman@gmail.com';
                        $this->email->from($from_email, 'Muhammad Nauman'); 
                        $this->email->to($user->email);
                        $this->email->subject('Inovicer Package Updated');
                        $message = "Hi, <br> Your package has been updated sucessfully.<br><br>Thank you";
                        $this->email->message($message); 
                        $this->email->send();
                        redirect('packages', 'location');
                    }else
                    {
                        $errorMessages = $response->getMessages()->getMessage();
                        $error_text  = $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                        $alert = array();
                        $alert['alertHeading'] = $this->lang->line('error');
                        $alert['alertContent'] = $error_text;

                        $this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

                        redirect('packages', 'location');
                    }
                    
                } 
		//validate the form
		$this->form_validation->set_rules('package', $this->lang->line('package_label'), 'required|integer');
		
		if ($this->form_validation->run() == FALSE) {//validation failed
			
			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = validation_errors();
			
			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));
			
			redirect('packages', 'location');
			
		} else {
			
			//update settings
			$data = array(
					'package_id' => $this->input->post('package'),
					
				);
			$user = $this->ion_auth->user()->row();
                       
                        if(empty($package_confirmation)){
                            // show the confirmation message
                            $this->data['page'] = 'packages';
                            $this->data['packages'] = $this->package_model->getActive();
                            $this->data['package_confirmation'] = 1;
                            $this->session->set_userdata(array(
                            'posted_data' => $_POST,
                            ));
                            $this->date['posted_data'] = $_POST; 
                            $package_data = $this->package_model->getAll($_POST['package']);
                            $this->data['package_data'] = $package_data[0];
                            $amount = 1.00;
                            if($package_data){
                                $amount = $package_data[0]->price;
                            }
                            $this->load->view('packages', $this->data);
                        } 
		}
		
	}
	function cancelSubscription($subscriptionId) {

            // Common Set Up for API Credentials
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName('45Gr3m4Nqa');
            $merchantAuthentication->setTransactionKey('9256gZQPq2Wwh77s');
            $refId = 'ref' . time();

            $request = new AnetAPI\ARBCancelSubscriptionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($subscriptionId);

            $controller = new AnetController\ARBCancelSubscriptionController($request);

            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
            {
                $successMessages = $response->getMessages()->getMessage();
                //echo "SUCCESS : " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText() . "\n";

             }
            else
            {
                //echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                //echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";

            }

            return $response;

        }
        public function create_recurring_order($days,$data) {
            //echo "dd";
            return $this->createSubscription($days,$data);
        }
	function createSubscription($intervalLength,$data) {
            
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName('45Gr3m4Nqa');
            $merchantAuthentication->setTransactionKey('9256gZQPq2Wwh77s');
            $refId = 'ref' . time();

            // Subscription Type Info
            $subscription = new AnetAPI\ARBSubscriptionType();
           $subscription->setName($data['field_firstName']." ".$data['field_lastName']."Package Subscription");

            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength($intervalLength);
            $interval->setUnit("days");

            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            $paymentSchedule->setInterval($interval);
            $paymentSchedule->setStartDate(new DateTime(date("Y-m-d")));
            $paymentSchedule->setTotalOccurrences("9999");
            //9999 for unlimmited 
            $paymentSchedule->setTrialOccurrences("1");
            $package_data = $this->package_model->getAll($data['package']);
            $amount = 1.00;
            if($package_data){
                 $amount = $package_data[0]->price;
            }
            $subscription->setPaymentSchedule($paymentSchedule);
            $subscription->setAmount($amount);
            $subscription->setTrialAmount("0.00");

            $creditCard = new AnetAPI\CreditCardType();
            //$creditCard->setCardNumber("4111111111111111");
            //$creditCard->setExpirationDate("2020-12");
            $creditCard->setCardNumber($data['field_CC']);
            $creditCard->setExpirationDate($data['field_expYearMonth']);
            $payment = new AnetAPI\PaymentType();
            $payment->setCreditCard($creditCard);

            $subscription->setPayment($payment);

            $billTo = new AnetAPI\NameAndAddressType();
            $billTo->setFirstName($data['field_firstName']);
            $billTo->setLastName($data['field_lastName']);

            $subscription->setBillTo($billTo);

            $request = new AnetAPI\ARBCreateSubscriptionRequest();
            $request->setmerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBCreateSubscriptionController($request);

            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
            {
                //echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
             }
            else
            {
                //echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                //echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            }
           // exit;
            return $response;
      }

	
}