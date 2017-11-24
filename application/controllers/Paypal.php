<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends MY_Controller {

	
	public function process()
	{

		log_message('debug', 'Paypal!');
		
				$this->debug_post();
		
		// STEP 1: read POST data
		// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
		// Instead, read raw POST data from the input stream.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
		    $myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
		$req = 'cmd=_notify-validate';
		if (function_exists('get_magic_quotes_gpc')) {
		  $get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
		  if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		    $value = urlencode(stripslashes($value));
		  } else {
		    $value = urlencode($value);
		  }
		  $req .= "&$key=$value";
		}

		// Step 2: POST IPN data back to PayPal to validate
		$ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
		//$ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		// In wamp-like environments that do not come bundled with root authority certificates,
		// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
		// the directory path of the certificate as shown below:
		// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		if ( !($res = curl_exec($ch)) ) {
		  // error_log("Got " . curl_error($ch) . " when processing IPN data");
		  curl_close($ch);
		  log_message('debug', 'Paypal: Got '.curl_error($ch).' when processing IPN data');
		  exit;
		}
		curl_close($ch);


		// inspect IPN validation result and act accordingly
			if (strcmp ($res, "VERIFIED") == 0) {
			 
				$update= array();
				$email = trim($_POST['custom']);
				$plan = intval(trim($_POST['item_number']));
				$update['plan'] = $plan;
				$user       = $this->Admin->getTable("users",array("email" => $email))->row();


				$event 	= array();
				$log 	= array();
				if(!$user)
				{
					log_message('debug', 'Paypal: User no found: '.$email);

				}


				if($_POST['txn_type'] == 'subscr_signup')
				{
					// Set plan => $plan
					
					
				}

				if($_POST['txn_type'] == 'subscr_cancel')
				{
					// Set plan => 1
					$plan = 1;
					$update['plan'] = 1;
				}
				if($_POST['txn_type'] == 'subscr_modify')
				{
					// Set plan => $plan
					
				}
				if($_POST['txn_type'] == 'subscr_failed')
				{
					// Set plan => 1
					$plan = 1;
					$update['plan'] = 1;
				}
				if($_POST['txn_type'] == 'subscr_payment')
				{
					// Set plan => $plan
					$update['last_payment'] = date("Y-m-d");
					
				}
				if($_POST['txn_type'] == 'subscr_eot')
				{
					// Set plan => 1
					$plan = 1;
					$update['plan'] = 1;
				}

				$event['txn_type'] 		= $_POST['txn_type'];
				$event['subscr_id'] 	= $_POST['subscr_id'];
				$event['custom'] 		= $_POST['email'];
				$event['ipn_track_id'] 	= $_POST['ipn_track_id'];
				$event['item_name'] 	= $_POST['item_name'];
				$event['period3'] 		= $_POST['period3'];
				$event['mc_amount3'] 	= $_POST['mc_amount3'];


				$log['transaction_subject'] = $_POST['transaction_subject'];
				$log['payment_date'] 		= $_POST['payment_date'];
				$log['txn_type'] 			= $_POST['txn_type'];
				$log['subscr_id'] 			= $_POST['subscr_id'];
				$log['last_name'] 			= $_POST['last_name'];
				$log['residence_country'] 	= $_POST['residence_country'];
				$log['item_name'] 			= $_POST['item_name'];
				$log['payment_gross'] 		= $_POST['payment_gross'];
				$log['mc_currency'] 		= $_POST['mc_currency'];
				$log['business'] 			= $_POST['business'];
				$log['payment_type'] 		= $_POST['payment_type'];
				$log['protection_eligibility'] = $_POST['protection_eligibility'];
				$log['verify_sign'] 		= $_POST['verify_sign'];
				$log['payer_status'] 		= $_POST['payer_status'];
				$log['test_ipn'] 			= $_POST['test_ipn'];
				$log['payer_email'] 		= $_POST['payer_email'];
				$log['txn_id'] 				= $_POST['txn_id'];
				$log['receiver_email'] 		= $_POST['receiver_email'];
				$log['first_name'] 			= $_POST['first_name'];
				$log['payer_id'] 			= $_POST['payer_id'];
				$log['receiver_id'] 		= $_POST['receiver_id'];
				$log['item_number'] 		= $_POST['item_number'];
				$log['payment_status'] 		= $_POST['payment_status'];
				$log['payment_fee'] 		= $_POST['payment_fee'];
				$log['mc_fee']				= $_POST['mc_fee'];
				$log['mc_gross'] 			= $_POST['mc_gross'];
				$log['custom'] 				= $_POST['custom'];
				$log['charset'] 			= $_POST['charset'];
				$log['notify_version'] 		= $_POST['notify_version'];
				$log['ipn_track_id']		= $_POST['ipn_track_id'];


				$this->Admin->updateTable("users",$update,array("id" => $user->id));


				$this->Admin->setTableIgnore("paypal_event",$event);
				$this->Admin->setTableIgnore("paypal_log",$log);

				log_message('debug', 'Paypal: VERIFIED');
			
			} else if (strcmp ($res, "INVALID") == 0) {
			  // IPN invalid, log for manual investigation
				log_message('debug', 'Paypal: The response from IPN was: '.$res);
			  
			}


		        
		
	}
}