<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Home extends CI_Controller 
{
        
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('WebUserType') != "WEBSITE") 
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
		public function index()  
    	{
    			$rsltdue = $this->db->query("SELECT * FROM duepayments where user_id = ?",array($this->session->userdata("WebId")));

    		    $this->view_data["duepayments"]  = $rsltdue;	
				$this->view_data["message"]  = ""; 
				$this->load->view("WEB/home_view",$this->view_data);
		}
		public function dopayment()
		{

			error_reporting(-1);
			ini_set('display_errors',1);
			$this->db->db_debug = TRUE;
				$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,b.emailid,a.mobile_no from tblusers a left join tblusers_info b on a.user_id = b.user_id where a.user_id = ?",array($this->session->userdata("WebId")));
			    if($userinfo->num_rows() == 1)
			    {
			        $user_id = $userinfo->row(0)->user_id;
			        $business_name = $userinfo->row(0)->businessname;
			        $username = $userinfo->row(0)->username;
			        $emailid = "newrcname@gmail.com";
			        $mobile_no = $userinfo->row(0)->mobile_no;
			        $PAYU_MerchantId = "7255028";
			       $merchant_id = $PAYU_MerchantId;
			       

			      

			      $rsltdue = $this->db->query("SELECT * FROM duepayments where Id = ?",array($this->input->post("hidid")));
			      if($rsltdue->num_rows() == 1)
			      {
			      	 $amount = $rsltdue->row(0)->amount;
			         $remark = "Online Payment";
			      }
			       
			        
			       
			        
			        if($amount > 0 and $amount <= 200000)
			        {
			            $MERCHANT_KEY = "og3VPkah";
            			$SALT = "XOP387AvHy";
            			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    			        
    			        $insertdata = $this->db->query("
    			                                        insert into payu_transactions
    			                                        (user_id,add_date,ipaddress,business_name,emaild,PAYU_MerchantId,Amount,remark,MERCHANT_KEY,SALT,txnid,status) 
    			                                        values(?,?,?,?,?,?,?,?,?,?,?,?)",
    			                                        array(
    			                                            $user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$business_name,
    			                                            $emailid,$PAYU_MerchantId,$amount,$remark,
    			                                            $MERCHANT_KEY,$SALT,$txnid,"pending"
    			                                        ));
    			        if($insertdata == true)
    			        {
    			            $insert_id = $this->db->insert_id();
    			            //$MERCHANT_KEY = "rjQUPktU";
            				//$SALT = "e5iIg1jwi8";
            				//$PAYU_BASE_URL = "https://test.payu.in";
            				
            				//live
            				
            				$PAYU_BASE_URL = "https://secure.payu.in/_payment";
            				$action = '';
            				//dezire  merchange id 6576792,champion 6938310
            				
            				$firstSplitArr = 
            				                array
            				                (
            				                    "name"=>$userinfo->row(0)->businessname, 
            				                    "value"=>$amount, 
            				                    
            				                    "description"=>"Recharge", 
            				                    "commission"=>"0",
            				                    "UID"=>$insert_id,
            				                    "AgentId"=>$user_id
            				                );
            
                            $paymentPartsArr = array($firstSplitArr);	
                            $finalInputArr = array("paymentParts" => $paymentPartsArr);
                            $Prod_info = json_encode($finalInputArr);
            				
            			
            				$hash = '';
            				//rjQUPktU|a459dac7f2d07d759515|10|recharge|ravikant|newrcname@gmail.com|||||||||||
            				$hash_string = "$MERCHANT_KEY|$txnid|$amount|$Prod_info|$business_name|$emailid|||||||||||";
            			
            				$hash_string .= $SALT;
            				
            			//	echo $hash_string;exit;
            				$hash = strtolower(hash('sha512', $hash_string));
            				
            				$this->db->query("update payu_transactions set Prod_info = ?,hash_string=?,hash=? where Id = ?",array($Prod_info,$hash_string,$hash,$insert_id));
            				
            				
            				$action = $PAYU_BASE_URL . '/_payment';
            				$this->view_data["action"] = $action;
            				$this->view_data["MERCHANT_KEY"] = $MERCHANT_KEY;
            				$this->view_data["hash"] = $hash;
            				$this->view_data["txnid"] = $txnid;
            				$this->view_data["amount"] = $amount;
            				$this->view_data["firstname"] = $business_name;
            				$this->view_data["email"] =$emailid;
            				$this->view_data["phone"] = $userinfo->row(0)->mobile_no;
            				$this->view_data["productinfo"] = $Prod_info;
            				$this->view_data["surl"] = "http://master.maharshimulti.in/cust/success";
            				$this->view_data["furl"] = "http://master.maharshimulti.in/cust/failure";
            				$this->load->view("cust/paynow_view",$this->view_data); 
    			        }  
			        }
			        
			        
			    }
			
		}
		
	}