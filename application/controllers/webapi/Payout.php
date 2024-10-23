<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payout extends CI_Controller 
{

  function __construct()
  {
      parent:: __construct();
      $this->load->model("ValidationModel");
  }
  public function aeps_loging($request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1) values(?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1));
  }
  public function custom_response($status,$statuscode,$message)
  {
      $resparray = array(
        "status"=>$status,
        "statuscode"=>$statuscode,
        "message"=>$message
      );
      echo json_encode($resparray);exit;
  }

  public function index()
	{

      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;


    $json = file_get_contents('php://input');
    $this->aeps_loging($json,"","PAYOUT");
    $json_obj = json_decode($json);

        if(isset($json_obj->username) && isset($json_obj->password) && isset($json_obj->apitoken) && isset($json_obj->request) )
        {
            $username = $json_obj->username;
            $pwd = $json_obj->password;
            $apitoken = $json_obj->apitoken;
            $request = $json_obj->request;
            if(isset($request->account_number) and isset($request->account_name) and isset($request->ifsc)  and isset($request->amount) and isset($request->mode))
            {
            
                $account_number = trim($request->account_number);
                $account_name = trim($request->account_name);
                $ifsc = trim($request->ifsc);
                $amount = trim($request->amount);
                $mode = trim($request->mode);
                $order_id = trim($request->order_id);



                if($this->ValidationModel->validateMobile($username) == false)
                {
                  
                  $status = "1";
                  $statuscode = "ERR";
                  $message = "Invalid Username";
                  $this->custom_response($status,$statuscode,$message);
                }
                if($this->ValidationModel->validatePassword($pwd) == false)
                {
                  $status = "1";
                  $statuscode = "ERR";
                  $message = "Invalid Password Entered";
                  $this->custom_response($status,$statuscode,$message);
                }


                $userinfo = $this->db->query("select * from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
                if($userinfo->num_rows() == 1)
                {
                    $user_id = $userinfo->row(0)->user_id;
                    $user_status = $userinfo->row(0)->status;
                    $developer_key = $userinfo->row(0)->developer_key;
                    $usertype_name = $userinfo->row(0)->usertype_name;
                    if($usertype_name == "APIUSER")
                    {
                        if($user_status == "1")
                        {
                            
                           
                                
                                if($developer_key ==  $apitoken )
                                {

                                 // if($this->checkduplicate($user_id,$order_id) == true)
                                  if(true)
                                  {
                                    $bank_id = 0;
                                      $this->load->model("Payout_model");
                                      $response = $this->Payout_model->payout($account_number,$account_name,$ifsc,$bank_id,$amount,$mode,$order_id,$userinfo);
                                      echo $response;exit;
                                  }
                                  else
                                  {
                                      $status = "1";
                                      $statuscode = "ERR";
                                      $message = "Please Pass Unique Order Id.";
                                      $this->custom_response($status,$statuscode,$message);                   
                                  }
                                }
                                else
                                {
                                    $status = "1";
                                    $statuscode = "ERR";
                                    $message = "Request From Invalid Ip [".$this->common->getRealIpAddr()."]";
                                    $this->custom_response($status,$statuscode,$message);                   
                                }
                               
                        }
                        else
                        {
                            $status = "1";
                            $statuscode = "ERR";
                            $message = "Account Deactive.";
                            $this->custom_response($status,$statuscode,$message);          
                        }
                    }
                    else
                    {
                        $status = "1";
                        $statuscode = "ERR";
                        $message = "Invalid Access";
                        $this->custom_response($status,$statuscode,$message);     
                    }
                }
                else
                {
                    $status = "1";
                    $statuscode = "ERR";
                    $message = "Invalid Username or Password";
                    $this->custom_response($status,$statuscode,$message);
                }
            }
            else
            {
              $status = "1";
              $statuscode = "ERR";
              $message = "Parameter Missing In Request";
              $this->custom_response($status,$statuscode,$message);
            }
	    	}
			
			else
			{
			    $resparray = array(
   	            'infomsg'=>'Something Went Wrong',
   	            'status'=>'failure'
   	           );
   		echo json_encode($resparray);exit;
			    
			}
	}
    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function checkduplicate($user_id,$order_id)
    {
        $rslt = $this->db->query("insert into payout_order_id_locking(user_id,order_id,add_date,ipaddress) values(?,?,?,?)",array($user_id,$order_id,$this->common->getDate(),$this->common->getRealIpAddr()));
      	if($rslt == true)
        {
      		  return true;
      	}
        else
        {
        	return false;
        }
    }
}