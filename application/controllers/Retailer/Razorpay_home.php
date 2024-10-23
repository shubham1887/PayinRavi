<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Razorpay_home extends CI_Controller 
{
	function __construct()
	{
		parent:: __construct();
		$this->is_logged_in();
        $this->clear_cache();
		$CI=& get_instance();
        $this->load->model("Razorpay");



        //$this->_service_down();
	}
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }





	private function _service_down()
    {
		$this->session->set_flashdata("message","Service is temporarily unavailable.") ;
		redirect(base_url('Retailer/Recharge_home'));
		exit;
	}
	public function index()
	{
		//die('in');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

		if ($this->session->userdata('AgentUserType') != "Agent")
		{
			redirect(base_url().'login');
		}
		else
		{	
            if($this->session->userdata("AgentId")!='4' && $this->session->userdata("AgentId")!='34627')
            {
                $this->session->set_flashdata("message","Service is temporarily unavailable.") ;
            }

            $RAZOR_KEY_ID = $this->Razorpay->getRAZOR_KEY_ID();
            $RAZOR_KEY_SECRET = $this->Razorpay->getRAZOR_KEY_SECRET();


			$this->view_data['message'] ="";


            $this->view_data['RAZOR_KEY_ID'] =$RAZOR_KEY_ID;
			$this->view_data['return_url'] = site_url().'Retailer/Razorpay_home/callback';
    		$this->view_data['surl'] = site_url().'Retailer/Razorpay_home/success';
    		$this->view_data['furl'] = site_url().'Retailer/Razorpay_home/failed';
    		$this->view_data['currency_code'] = 'INR';
			$this->load->view('Retailer/Razorpay_home_view',$this->view_data);
		}
	}
  /***************************** Log file ******************************/
    public function razorPGlogs_entry($data)
    {
        $filename ='razorpayPG_logs/razorpayPG_logs'.date("j.n.Y").'.txt';
        if (!file_exists($filename))
        {
            file_put_contents($filename, '');
        }
        $this->load->helper('file');
        $sapretor = "------------------------------------------------------------------------------------";
        write_file($filename." .\n", 'a+');
        write_file($filename, $data."\n", 'a+');
        write_file($filename, date("Y-m-d h:i:s A")."\n", 'a+');
        //write_file($filename, $this->_get_client_ip()."\n", 'a+');
        write_file($filename, $sapretor."\n", 'a+');
    }
    /********************************* End Log ********************************************/
	public function callback()
	{
		//die('in');
     // print_r('<pre>');
     // print_r($_POST);
     // print_r('<br>');

     // var_dump($this->input->post('razorpay_payment_id'));
     // var_dump($this->input->post('merchant_order_id'));
     // var_dump($this->input->post('merchant_trans_id'));
     // var_dump($this->input->post('merchant_product_info_id'));
     // var_dump($this->input->post('merchant_total'));
     // die();
    


     $user_id = $this->session->userdata("AgentId");



     $this->db->query("insert into tbl_razorpay_logs(user_id,add_date,ipaddress,response) values(?,?,?,?)",array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),json_encode($this->input->post())));






    $my_razorpay_payment_id = $this->input->post('razorpay_payment_id');
    $my_merchant_order_id = $this->input->post('merchant_order_id');
    $my_merchant_trans_id = $this->input->post('merchant_trans_id');
    $my_merchant_product_info_id = $this->input->post('merchant_product_info_id');
    $my_merchant_total = $this->input->post('merchant_total');

    if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                    $this->db->query("insert into tbl_razorpay_logs(user_id,add_date,ipaddress,response) values(?,?,?,?)",array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$result));
                    $this->razorPGlogs_entry($result."\n user id = ".$user_id);
                        // echo "<pre>";print_r($response_array);exit;
                        //Check success response
                        // if ($http_status === 200 and isset($response_array['error']) === false) {
                        if ($http_status === 200 && $response_array['status'] == 'captured'
                            && $my_razorpay_payment_id == $response_array['id']
                            && $my_merchant_order_id == $response_array['notes']['soolegal_order_id']
                            && ($my_merchant_total*100) == $response_array['amount']
                            ) {
                            $success = true;

                        $status = $response_array['status'];
                        $method = $response_array['method'];
                        $email = $response_array['email'];
                        $phone = $response_array['contact'];
                        
                        $card_type = "";
                        $card_last4 = "";
                        $card_name = "";
                        $card_network = "";
                        if(isset($response_array['card']))
                        {
                          $card_type = $response_array['card']['type'];
                          $card_last4 = $response_array['card']['last4'];
                          $card_name = $response_array['card']['name'];
                          $card_network = $response_array['card']['network'];  
                        }
                        
                        
                      $bank = $response_array['bank'];
                      if($bank == NULL or $bank == null)
                      {
                        $bank = "";
                      }

                      $wallet = $response_array['wallet'];
                      if($wallet == NULL or $wallet == null)
                      {
                        $wallet = "";
                      }

                      $vpa = $response_array['vpa'];
                      if($vpa == NULL or $vpa == null)
                      {
                        $vpa = "";
                      }


                        $usrDetails = $this->db->query("SELECT * FROM tblusers where user_id = ?",array(intval($user_id)));
                        $unm = $usrDetails->row(0)->username;

                         // var_dump($user_id);
                        // var_dump($razorpay_payment_id);
                        // var_dump($my_merchant_order_id);
                        // var_dump($my_merchant_trans_id);
                        // var_dump($my_merchant_total);
                        // var_dump($status);
                        //  var_dump($method);
                        //  var_dump($email);
                        //  var_dump($phone);
                        // var_dump($card_type);
                        // var_dump($card_last4);
                        // var_dump($card_name);
                        // var_dump($card_network);
                        // var_dump($bank);
                        // var_dump($wallet);

                $credit_amount = $my_merchant_total;
                if($method == 'card' && $card_type == 'debit' && $card_network == 'rupay'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt * 18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method == 'card' && $card_type == 'debit' && $card_network != 'rupay'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method == 'card' && $card_type == 'credit'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method=='upi'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt * 18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method=='netbanking' && $bank=='HDFC'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }else if($method=='netbanking' && $bank=='ICIC'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }else if($method=='netbanking'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method == 'wallet'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt*18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }
                if($method == 'emi'){
                    $perAmt = ($my_merchant_total * 2)/100;
                    $gstAmt = 0;//($perAmt * 18)/100;
                    $minusAmt = $perAmt + $gstAmt;
                    $credit_amount = $my_merchant_total - $minusAmt;
                }



                if($credit_amount <= 100000)
                {
                    // Balance Credit From User
                    $Description = "Wallet Topup Through Rozarpay , Balace Credited : ".$credit_amount." , Transaction Id : ".$my_merchant_trans_id." , Order Id: ".$my_merchant_order_id;
                    $remark = "Wallet Topup Through Rozarpay , Balace Credited :  ".$credit_amount." , Transaction Id : ".$my_merchant_trans_id." , Order Id: ".$my_merchant_order_id;
                  //  $wallet_id = $this->PAYMENT_CREDIT_ENTRY($user_id,"PAYMENT",abs($credit_amount),$Description,$remark);

                // Balance Debit From Admin
                    $payment_id= $wallet_id ;
                    $Description_debit="Wallet Topup Through Rozarpay  to: ".$unm.", Balace Credited :  ".$credit_amount." , Transaction Id : ".$my_merchant_trans_id." , Order Id : ".$my_merchant_order_id;
                    $remark_debit="Wallet Topup Through Rozarpay  to: ".$unm.", Balace Credited :  ".$credit_amount." , Transaction Id : ".$my_merchant_trans_id." , Order Id : ".$my_merchant_order_id;
                 //   $wallet_id_admin= $this->PAYMENT_DEBIT_ENTRY('1',"PAYMENT",abs($credit_amount),$Description_debit,$remark_debit,$payment_id);    
                }
                

                // Razorpay Add in DB //
                     $str_query= "INSERT INTO  tbl_razorpay(user_id,razorpay_payment_id,order_id,txnid,amount,credit_amount,charges,gst,status,method,card_type,card_last4,card_name,card_network,vpa,bank,wallet,email,phone,payment_from,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $reslut = $this->db->query($str_query,array($user_id,$razorpay_payment_id,$my_merchant_order_id,$my_merchant_trans_id,$my_merchant_total,$credit_amount,$perAmt,$gstAmt,$status,$method,$card_type,$card_last4,$card_name,$card_network,$vpa,$bank,$wallet,$email,$phone,'WEB',$this->common->getDate(),$this->common->getRealIpAddr()));

                       // var_dump($str_query);
                       // print_r($this->db->last_query());
                       // die();
                       //print_r($phone);exit();

                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }

            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                 }
                if (!$order_info['order_status_id']) {
                    redirect($this->input->post('merchant_surl_id'));
                } else {
                    redirect($this->input->post('merchant_surl_id'));
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
         } else {
            //echo 'An error occured. Contact site administrator, please!';
            $this->session->set_flashdata('errors','An error occured. Contact site administrator, please!.');
            redirect('Retailer/Razorpay_home');
        }
	}

	public function success() {




		$this->session->set_flashdata('MESSAGEBOX_MESSAGETYPE','SUCCESS');
		$this->session->set_flashdata('MESSAGEBOX_MESSAGEBODY','Your payment has been processed successfully');
      	$this->session->set_flashdata('success','Your payment has been processed successfully');
        redirect('Retailer/Razorpay_home');
    }
    public function failed() {
    	$this->session->set_flashdata('MESSAGEBOX_MESSAGETYPE','FAILURE');
		$this->session->set_flashdata('MESSAGEBOX_MESSAGEBODY','Payment is failed, Please try again!');
      $this->session->set_flashdata('errors','Payment is failed, Please try again!');
      redirect('Retailer/Razorpay_home');
    }
    private function get_curl_handle($payment_id,$amount){
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $amount=$amount*100;
        $key_id = $this->Razorpay->getRAZOR_KEY_ID();
        $key_secret = $this->Razorpay->getRAZOR_KEY_SECRET();
        $fields_string = "amount=$amount&currency=INR";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }


    private function PAYMENT_CREDIT_ENTRY($user_id,$transaction_type,$cr_amount,$Description,$remark)
    {
        return "";
        //$this->_service_down();
       $this->load->library("common");
       $add_date = $this->common->getDate();
       $date = $this->common->getMySqlDate();
       $ip = $this->common->getRealIpAddr();
       $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
       $this->db->query("BEGIN;");

       $old_balance = 0;
       $result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet` where user_id = ? order by Id desc limit 1",array($user_id));
       if($result_oldbalance->num_rows() > 0)
       {
           $old_balance =  $result_oldbalance->row(0)->balance;
       }
       
       $this->db->query("COMMIT;");

       $current_balance = $old_balance + $cr_amount;
       $tds = 0.00;
       $stax = 0.00;
       if($transaction_type == "PAYMENT")
       {
            // For Payment
            $payment_master_id = 0;
            $credit_user_id = $user_id;
            $debit_user_id = 1;
            $payment_type = 'cash';
            $t_type = '';
            $payment_date=date('Y-m-d',strtotime($add_date));
            $payment_time=date('h:i:s',strtotime($add_date));
            $payment_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type,   payment_date,payment_time)
            values(?,?,?,?,?,?,?,?,?,?,?)";
            $payment_reslut = $this->db->query($payment_query,array($payment_master_id,$credit_user_id,$cr_amount,$payment_type,$debit_user_id,$remark,$add_date,$ip,$t_type,$payment_date,$payment_time));
            $payment_id = $this->db->insert_id();

           $str_query = "insert into tblewallet(user_id,payment_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)values(?,?,?,?,?,?,?,?,?)";
           $reslut = $this->db->query($str_query,array($user_id,$payment_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date,$ip,$remark));

           if($reslut == true)
           {
               $ewallet_id = $this->db->insert_id();
               if($ewallet_id > 10)
               {
                // return $ewallet_id;
                return $payment_id;
               }
               else
               {
                       $resparray = array(
                       "status"=>"1",
                       "message"=>"Payment Error"
                       );
                   return $resparray;
               }
           }
           else
           {
               $resparray = array(
                   "status"=>"1",
                   "message"=>"Internal Server Error"
                   );
               return $resparray;
           }
       }
       else
       {
               $resparray = array(
                   "status"=>"1",
                   "message"=>"Invalid Action"
                   );
               return $resparray;
       }
    }

    private function PAYMENT_DEBIT_ENTRY($user_id,$transaction_type,$dr_amount,$Description,$remark,$payment_id)
    {
        return "";
        //$this->_service_down();
       $this->load->library("common");
       $add_date = $this->common->getDate();
       $date = $this->common->getMySqlDate();
       $ip = $this->common->getRealIpAddr();
       $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
       $this->db->query("BEGIN;");

       $result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet` where user_id = ? order by Id desc limit 1",array($user_id));
       if($result_oldbalance->num_rows() > 0)
       {
           $old_balance =  $result_oldbalance->row(0)->balance;
       }
       else
       {
           $result_oldbalance2 = $this->db->query("SELECT balance FROM masterpa_archive.tblewallet where user_id = ? order by Id desc limit 1",array($user_id));
           if($result_oldbalance2->num_rows() > 0)
           {
               $old_balance =  $result_oldbalance2->row(0)->balance;
           }
           else
           {

               $old_balance =  0;

           }

       }
       $this->db->query("COMMIT;");
       $current_balance = $old_balance - $dr_amount;
       $tds = 0.00;
       $stax = 0.00;
       if($transaction_type == "PAYMENT")
       {

           $str_query = "insert into tblewallet(user_id,payment_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)values(?,?,?,?,?,?,?,?,?)";
           $reslut = $this->db->query($str_query,array($user_id,$payment_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));

           if($reslut == true)
           {
               $ewallet_id = $this->db->insert_id();
               if($ewallet_id > 10)
               {
                   return $ewallet_id;
               }
               else
               {
                       $resparray = array(
                       "status"=>"1",
                       "message"=>"Payment Error"
                       );
                   return $resparray;
               }
           }
           else
           {
               $resparray = array(
                   "status"=>"1",
                   "message"=>"Internal Server Error"
                   );
               return $resparray;
           }
       }
       else
       {
               $resparray = array(
                   "status"=>"1",
                   "message"=>"Invalid Action"
                   );
               return $resparray;
       }
   }

    /// Not working
    private function get_curl_handle_1($payment_id, $amount) 
     {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id;
        $key_id = $this->Razorpay->getRAZOR_KEY_ID();
        $key_secret = $this->Razorpay->getRAZOR_KEY_SECRET();
        // $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
try{
$captureresp = $this->payment_capture($payment_id,$amount);
}catch(Exception $e){

}
        return $ch;
    }

}