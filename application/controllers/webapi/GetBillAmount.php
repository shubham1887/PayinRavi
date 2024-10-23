
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetBillAmount extends CI_Controller {
	function __construct()
    {
        parent:: __construct();
    	$this->clear_cache();
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
		//http://master.maharshimulti.in/webapi/getBillAmount?username=&pwd=&mcode=UGE&serviceno=&customer_mobile=&option1=
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{

			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['mcode']) && isset($_GET['serviceno']) && isset($_GET['customer_mobile']) && isset($_GET['option1'])  && isset($_GET['option2']))
			{

				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$mcode = $_GET['mcode'];
				$serviceno =  $_GET['serviceno'];
				$customer_mobile = $_GET['customer_mobile'];
				$option1 = $_GET['option1'];
				$option2 = $_GET['option2'];
			 	
				$user_info = $this->db->query("select * from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
				if($user_info->num_rows() == 1)
				{

				    if($user_info->row(0)->usertype_name == "APIUSER")
					{
						
						$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
						if($company_info->num_rows() == 1)
						{
							$this->load->model("Mastermoney");
							$response = $this->Mastermoney->fetchbill($user_info,$mcode,$company_info->row(0)->company_id,$serviceno,$customer_mobile,$option1);
	    					echo $response;exit;
						}
						else
						{
							$resp_arr = array(
										"message"=>"Invalid Operator Code",
										"status"=>1,
										"statuscode"=>"ERR",
									);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
					}	
					else
					{
						$resp_arr = array(
										"message"=>"Unauthorised Access",
										"status"=>1,
										"statuscode"=>"AUTH",
									);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
					}
				}
				else
				{
				    $resp_arr = array(
									"message"=>"Invalid UserId Or Password",
									"status"=>1,
									"statuscode"=>"AUTH",
								);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
				}
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
	}	
}