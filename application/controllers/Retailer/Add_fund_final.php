<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_fund_final extends CI_Controller {

    function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	    if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
	//	echo "";exit;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
     
        
    }
	public function index()
	{	
	   $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	   $this->output->set_header("Pragma: no-cache"); 
	   
			if($this->input->post("txtAmount"))				
			{
				$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,b.emailid,a.mobile_no from tblusers a left join tblusers_info b on a.user_id = b.user_id where a.user_id = ?",array($this->session->userdata("AgentId")));
			    if($userinfo->num_rows() == 1)
			    {
			        $user_id = $userinfo->row(0)->user_id;
			        $business_name = $userinfo->row(0)->businessname;
			        $username = $userinfo->row(0)->username;
			        $emailid = $userinfo->row(0)->emailid;
			        $mobile_no = $userinfo->row(0)->mobile_no;
			        
			        
			        $amount = trim($this->input->post("txtAmount"));
			        $remark = trim($this->input->post("txtRemark"));
			        
			        if($amount > 0 and $amount <= 200000)
			        {
			         //   $MERCHANT_KEY = "FZRzqjqG";
            // 			$SALT = "zgxgvQw3ex";
            
            
                        $MERCHANT_KEY = "eogjmx";
            			$SALT = "k3pLinh0";
            			
            			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    			        
    			        $insertdata = $this->db->query("
    			                                        insert into cashfree_order
    			                                        (user_id,add_date,ipaddress,business_name,emaild,Amount,remark,status) 
    			                                        values(?,?,?,?,?,?,?,?)",
    			                                        array(
    			                                            $user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$business_name,
    			                                            $emailid,$amount,$remark,"pending"));
    			        if($insertdata == true)
    			        {
    			            $insert_id = $this->db->insert_id();
    			            //$MERCHANT_KEY = "rjQUPktU";
            				//$SALT = "e5iIg1jwi8";
            				//$PAYU_BASE_URL = "https://test.payu.in";
            			
    			            $appId = "18854088a696011c79d3101540045881";

    			            $secretKey = "51491cf0cf26081fdf422052d674204708f5fbaf";
    			            $signatureData = 'appId'.$appId.'customerEmail'.$emailid.'customerName'.urlencode($userinfo->row(0)->businessname).'customerPhone'.$mobile_no.'notifyUrlhttps://payin.live/service/Cashfree_callbackorderAmount'.$amount.'orderCurrencyINRorderIdORDER'.$insert_id.'orderNotereturnUrlhttps://payin.live/cashfree/response.php';
    			            $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
							$signature = base64_encode($signature);

							//echo $signatureData."<br><br>";
							//echo $signature;exit;





            				$this->view_data["appId"] = $appId;
            				$this->view_data["signature"] = $signature;
            				$this->view_data["orderNote"] = "";
            				$this->view_data["orderCurrency"] = "INR";
            				$this->view_data["customerName"] = urlencode($userinfo->row(0)->businessname);
            				$this->view_data["customerEmail"] = $emailid;
            				$this->view_data["customerPhone"] = $mobile_no;
            				$this->view_data["orderAmount"] =$amount;
            				$this->view_data["phone"] = $userinfo->row(0)->mobile_no;
            				$this->view_data["notifyUrl"] = "https://payin.live/service/Cashfree_callback";
            				$this->view_data["returnUrl"] = "https://payin.live/cashfree/response.php";
            				$this->view_data["orderId"] = "ORDER".$insert_id;
            				
            				$this->load->view("Retailer/paynow_view",$this->view_data); 
    			        }  
			        }
			        
			        
			    }
			}
		
			else
			{		$this->view_data['amount'] =$this->input->post("hidAmount");
		            $this->view_data['remark'] =$this->input->post("hidRemark");;
					$this->view_data['message'] ="";
					$this->load->view('Retailer/add_fund_final_view',$this->view_data);
			}
		
	
	}
}	