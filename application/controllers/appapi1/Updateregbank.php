<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updateregbank extends CI_Controller {
	
	public function index()
	{ 
	   error_reporting(-1);
	   ini_set('display_errors',1);
	   $this->db->db_debug = TRUE;
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				$acno=  $_POST['acno']; 
				$acifsc =  $_POST['acifsc'];  
				$acname  =  $_POST['acname'];


				if($acname == null)
				{
					$acname = "";
				}
				

			}
			else if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = $_GET['username'];$pwd =  $_GET['pwd'];$acno=  $_GET['acno']; $acifsc =  $_GET['acifsc'];  $acname  =  $_GET['acname'];
			}
			else
			{	
				$infomsg='Something going wrong!!';
						    $resparray = array(
                    				'status' => 'failure',
                    				'infomsg' => $infomsg
                				);
                			echo json_encode($resparray);exit;
            }			
		
			$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? ",array($username,$pwd));
			if($userinfo->num_rows() == 1)
			{
			
			    $user_id = $userinfo->row(0)->user_id;

			    $bank_detail = $this->db->query("select a.account_number,a.ifsc,b.bank_name from payout_banks a left join dmr_banks b on a.bank_id = b.Id where a.user_id = ?",array($user_id));
				if($bank_detail->num_rows() == 1)
				{
					$this->db->query("update payout_banks set account_number = ?,ifsc = ?,bank_id = ? where user_id = ?",array($acno,$acifsc,$acname,$user_id));
				}
				else
				{
					$this->db->query("insert into payout_banks(account_name,account_number,ifsc,bank_id,add_date,ipaddress,user_id) values(?,?,?,?,?,?,?)",array($acname,$acno,$acifsc,"",$this->common->getDate(),$this->common->getRealIpAddr(),$user_id));
				}



			 	

			 	$bank_detail = $this->db->query("select a.account_number,a.ifsc,b.bank_name from payout_banks a left join dmr_banks b on a.bank_id = b.Id where a.user_id = ?",array($user_id));
				if($bank_detail->num_rows() == 1)
				{
					$acno = $bank_detail->row(0)->account_number;
				    $acifsc = $bank_detail->row(0)->ifsc;
				    $acname = $bank_detail->row(0)->bank_name;
				    $infomsg='Bank infomation Updated successfully!!';
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
			    {}
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