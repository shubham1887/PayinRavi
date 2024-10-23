<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_password extends CI_Controller {
	

	public function index()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_REQUEST['username']) && isset($_REQUEST['pwd']) && isset($_REQUEST['OthersId']))
			{
				$username = $_REQUEST['username'];
				$pwd =  $_REQUEST['pwd'];
				$othersId = $_REQUEST['OthersId'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['OthersId']) )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$othersId = $_GET['OthersId'];
				
				}
			else
			{echo 'Paramenter is missing';exit;}			
		}	
		if($amount < 0)
		{
			$resparray = array(
		            "status"=>1,
		            "message"=>"Invalid Amount"
		        );
		        echo json_encode($resparray);exit;
		}
		$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd));
		if($userinfo->num_rows() == 1)
		{
			//$hostname = $userinfo->row(0)->hostname;
			$usertype_name = $userinfo->row(0)->usertype_name;
			
			if($usertype_name == "MasterDealer" or $usertype_name == "Distributor")
			{
				$cruserinfo = $this->db->query("select * from tblusers where username = ?  and parentid = ?",array($othersId,$userinfo->row(0)->user_id));
				if($cruserinfo->num_rows() == 1)
				{
					$cr_usertype = $cruserinfo->row(0)->usertype_name;
					if($cr_usertype == "Agent" or $cr_usertype == "Distributor")
					{
					    if(true)
						{
							$password = $this->common->GetPassword();
    						$this->db->query("update tblusers set status = 1,password = ? where user_id = ?",array($password,$cruserinfo->row(0)->user_id));
    						$this->load->model('Sms');
    						$this->Sms->passwordreset($cruserinfo->row(0)->username,$password,$cruserinfo->row(0)->mobile_no,$cruserinfo->row(0)->emailid,$cruserinfo->row(0)->businessname);
    						$resparray = array(
        		            "status"=>0,
        		            "message"=>"Action Submitted Successfully"
            		        );
            		        echo json_encode($resparray);exit;
						}
						
					}
					else
					{
					    $resparray = array(
    		            "status"=>1,
    		            "message"=>"Invalid User"
        		        );
        		        echo json_encode($resparray);exit;
					}
					
				}
				else
				{
				    $resparray = array(
		            "status"=>1,
		            "message"=>"Invalid User"
    		        );
    		        echo json_encode($resparray);exit;
				
				}	
			}
			
				else
				{
    				    $resparray = array(
    				'Error'=>1,
    				'Message'=>'Invalid User'
    				);
    				echo json_encode($resparray);exit;
				}	
			
			
		}
		else
		{
		     $resparray = array(
				'Error'=>1,
				'Message'=>'Invalid Access'
				);
				echo json_encode($resparray);exit;
			echo "Invalid Access";exit;
		}
		
	}
	
	
}
