<?php 
class Subscription{

	public $db;
	public $payments;
	public $wallet_transactions;
	public $wallet_transaction_meta;
	

	function __construct(){
		global $wpdb;
		$this->db = $wpdb;
		$this->payments = $this->db->prefix.'ms_payments';
		$this->wallet_transactions = $this->db->prefix.'woo_wallet_transactions';
		$this->wallet_transaction_meta = $this->db->prefix.'woo_wallet_transaction_meta';
		
	}


	function _save_payment_info($savedata){

	update_option('miraculous_paypal_testing', $savedata);
		if (is_array($savedata)) {
			$m = $savedata['plan_validity'];

			$payment = $this->db->insert( 
				$this->payments, 
				array(
					'user_id' => $savedata['user_id'], 
					'txnid' => $savedata['txn_id'], 
					'payment_amount' => $savedata['payment_amount'],
					'payment_status' => $savedata['payment_status'],
					'itemid' => $savedata['plan_number'],
					'monthly_download' => $savedata['monthly_download'],
					'monthly_upload' => $savedata['monthly_upload'],
					'createdtime' => date('Y-m-d H:i:s'),
					'expiretime' => date("Y-m-d H:i:s", strtotime("+$m months")),
					'remains_download' => $savedata['monthly_download'],
					'remains_upload' => $savedata['monthly_upload'],
					'extra_data' => json_encode($savedata),
				), 
				array(
					'%d', 
					'%s', 
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s'
				) 
			);
			if($payment){
				return $this->db->insert_id;
			}else{
				return false;
			}
			
		}
	}

	function _update_wallet($savedata){

		if (is_array($savedata)) {
			
			$wallet = $this->db->insert($this->wallet_transactions,$savedata);
			if($wallet){
				return $this->db->insert_id;
			}else{
				return false;
			}
			
		}
	}

	function _generate_string($input, $strength = 16) {
	    $input_length = strlen($input);
	    $random_string = '';
	    for($i = 0; $i < $strength; $i++) {
	        $random_character = $input[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	    }
	 
	    return $random_string;
	}

	function _verifyTransaction($data,$paypalUrl) {
		//global $paypalUrl;
		

		$raw_post_array = explode('&', $data);
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
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);
		if (!$res) {
			$errno = curl_errno($ch);
			$errstr = curl_error($ch);
			curl_close($ch);
			throw new Exception("cURL error: [$errno] $errstr");
		}

		$info = curl_getinfo($ch);

		// Check the http response
		$httpCode = $info['http_code'];
		if ($httpCode != 200) {
			throw new Exception("PayPal responded with http code $httpCode");
		}

		curl_close($ch);
		echo 'res '.$res;
		die();
		return $res === 'VERIFIED';
	}

	function _checkTxnid($txnid) {
		$results = $this->db->get_results("SELECT * FROM $this->payments WHERE txnid = '$txnid'");
	    
	    if(!empty($results)){
	        return $results->num_rows;
	    }else{
	        return true;
	    }
		
	}

	function _getUserSebscription($user_id) {
		$results = $this->db->get_row("SELECT * FROM $this->payments WHERE user_id = '$user_id'");
	    
	    if(!empty($results)){
	        return $results;
	    }else{
	        return false;
	    }
		
	}

	function _addPayment($data) {
		
		
	    update_option('miraculous_paypal_testing', $data);
		if (is_array($data)) {
			$m = $data['plan_validity'];

			$this->db->insert( 
				$this->payments, 
				array(
					'user_id' => $data['user_id'], 
					'txnid' => $data['txn_id'], 
					'payment_amount' => $data['payment_amount'],
					'payment_status' => $data['payment_status'],
					'itemid' => $data['plan_number'],
					'monthly_download' => $data['monthly_download'],
					'monthly_upload' => $data['monthly_upload'],
					'createdtime' => date('Y-m-d H:i:s'),
					'expiretime' => date("Y-m-d H:i:s", strtotime("+$m months")),
					'remains_download' => $data['monthly_download'],
					'remains_upload' => $data['monthly_upload'],
					'extra_data' => json_encode($data),
				), 
				array(
					'%d', 
					'%s', 
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s'
				) 
			);

			return $wpdb->insert_id;
		}

		return false;
	}
	
}