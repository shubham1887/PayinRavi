<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Success_payu extends CI_Controller {

	public function resplog($data)
	{
		$date = $this->common->getMySqlDate();
		$filename = $date."payu.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()." >> ".$data."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()." >> \n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function index()
	{	
	    	error_reporting(1);
	    	ini_set('display_errors',1);
	    	$this->db->db_debug = TRUE;
	        //	echo "Stopped By Admin";exit;
		    $res = '';
		 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			
			
			
			$this->resplog(json_encode($this->input->post()));
			
		

            $salt = "ywsZBgg1"; # salt value need to be picked from your database
            
            
            $amount = $_POST["amount"]; # amount need to be picked up from your database
            
            
            $reverseHash = $this->generateReverseHash();
           // echo  $_POST["hash"]."<br>".$reverseHash;exit;
            if ($_POST["hash"] == $reverseHash)
            {
                # transaction Succeeded
                # do the required javascript task
                echo ("Transaction Succeeded & Verified");
                $this->successCallbackToApp($_POST);
            }
            else
            {
                # transaction is tempered
                # handle it as required
                echo ("<br>");
                echo "\nInvalid transaction--";
            }

            # For iOS Success

      
	}
	public function successCallbackToApp($payuResponse)
    {
	$appResponse->response = http_build_query($payuResponse);
    $appResponseInJSON = json_encode($appResponse);

    
    $res= "" . http_build_query($payuResponse);
    $res= strval($res);

    echo '<script type="text/javascript">';
    // For WKWebview
    echo'if (typeof window.webkit.messageHandlers.observe.postMessage == "function")';
    echo "{ window.webkit.messageHandlers.observe.postMessage({'onSuccess':JSON.stringify($appResponseInJSON)}); }";
    // For UIWebView
    echo 'else { function payu_merchant_js_callback() { PayU.onSuccess("' .$res.'");  } }';
    echo '</script>';
}

    # Function to generate reverse hash
    public function generateReverseHash()
    {
        global $salt;
        global $amount;
        if ($_POST["additional_charges"] != null)
        {
    
            $reversehash_string = $_POST["additional_charges"] . "|" . $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"];
    
        }
        else
        {
            $reversehash_string = $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"];
    
        }
        $status = $_POST["status"];
        $salt = "ywsZBgg1";
        $MERCHANT_KEY = $_POST["key"];
        $txnid = $_POST["txnid"];
        $amount = $_POST["amount"];
        $productinfo = $_POST["productinfo"];
        $business_name = $_POST["firstname"];
        $email = $_POST["email"];
        
        
        //$hash_string = "$MERCHANT_KEY|$txnid|$amount|$productinfo|$business_name|$email|||||||||||";
        
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$business_name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$MERCHANT_KEY;
        //echo $hash_string;exit;
        //  echo($reversehash_string);
        //$reverseHash = strtolower(hash("sha512", $hash_string));
        $hash = strtolower(hash('sha512', $retHashSeq));
    
        return $hash;
    }

}