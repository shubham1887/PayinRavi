<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Failure extends CI_Controller {

	
	public function index()
	{	
		
		 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			//$salt="e5iIg1jwi8";
			$salt="YYTBtl5hDI";
			
			If (isset($_POST["additionalCharges"])) {
				   $additionalCharges=$_POST["additionalCharges"];
					$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
					
							  }
				else {	  
			
					$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			
					 }
					 $hash = hash("sha512", $retHashSeq);
			  
				   if ($hash != $posted_hash) {
					   echo "Invalid Transaction. Please try again";
					   }
				   else {
			
					 echo "<h3>Your order status is ". $status .".</h3>";
					 echo "<h4>Your transaction id for this transaction is ".$txnid.". You may try making the payment by clicking the link below.</h4>";
					  
					 } 
	}

}	