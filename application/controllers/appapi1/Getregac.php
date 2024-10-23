<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getregac extends CI_Controller {
	
	public function index()
	{ 
	    
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{
				$username = trim($_POST['username']);
				$pwd =  trim($_POST['pwd']); 
				$dvcid = trim($_POST['dvcid']);
			}
			else if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['pwd']); 
				$dvcid = trim($_GET['dvcid']);
			}
			else
			{	$infomsg='Something going wrong!!';
						    $resparray = array(
                    				'status' => 'failure',
                    				'infomsg' => $infomsg
                				);
                			echo json_encode($resparray);exit;
            }			
		
			


			$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ? ",array($username,$pwd));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$bank_detail = $this->db->query("select a.account_number,a.ifsc,b.bank_name from payout_banks a left join dmr_banks b on a.bank_id = b.Id where a.user_id = ?",array($user_id));
				if($bank_detail->num_rows() == 1)
				{
					$acno = $bank_detail->row(0)->account_number;
				    $acifsc = $bank_detail->row(0)->ifsc;
				    $acname = $bank_detail->row(0)->bank_name;
				    $infomsg='Bank infomation load successfully!!';
								    $resparray = array(
		                    				'status' => 'success',
		                    				'infomsg' => $infomsg,
		                    				'acno'=> $acno,
		                    				'acifsc'=>$acifsc,
		                    				'acname'=> $acname
		                    					);
		                			echo json_encode($resparray);exit;	
				}
				else
				{
					$infomsg='No Banks Found';
							    $resparray = array(
	                    				'status' => 'failure',
	                    				'infomsg' => $infomsg
	                				);
	                			echo json_encode($resparray);exit;
				}
			    
			  
			}
			else
			{
			    
					$infomsg='Invalid UserId or Password';
							    $resparray = array(
	                    				'status' => 'failure',
	                    				'infomsg' => $infomsg
	                				);
	                			echo json_encode($resparray);exit;
			}
	}
	
}