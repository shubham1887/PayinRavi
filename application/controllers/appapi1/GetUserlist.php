<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetUserlist extends CI_Controller {
	
	
	public function logentry($data)
	{
	
	}
	
	public function getDownlineUserlist()
	{
	    if(isset($_GET["username"]) and isset($_GET["password"]))
		{
			
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$distid = trim($_GET["distid"]);
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				
				if($usertype_name == "MasterDealer")
				{
				    $rslt = $this->db->query("select 
				    a.user_id,
				    a.businessname,
				    a.username,
				    a.mobile_no,
				    a.status,
				    Date(a.add_date) as add_date,
				    a.usertype_name
    				from tblusers  a
    				left join tblusers p on a.parentid = p.user_id
    				where  
    				p.parentid = ? and p.username = ? order by a.businessname ",array($user_id,$distid));
    			
    				if($rslt->num_rows() > 0)
    				{
    				
    						$resparray = array();
    					$resparray["data"] = array();
    		
    					foreach($rslt->result() as $row)
    					{
    					$balance = $this->Common_methods->getAgentBalance($row->user_id);
    					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
    				
    					if($row->username == ""){$username = "--";}else {$username = $row->username;}
    					if($row->mobile_no == ""){$mobile_no = "--";}else {$mobile_no = $row->mobile_no;}
    					
    					if($row->status == "1"){$status = "Active";}else {$status = "Deactive";}
    					if($row->add_date == ""){$add_date = "--";}else {$add_date = $row->add_date;}
    					
    					
    						$data = array(
    				'businessname'=>$row->businessname,
    				'username'=>$row->username,
    				'mobile_no'=>$row->mobile_no,
    				'emailid'=>"asdf@gmail.com",
    			    'usertype_name'=>$row->usertype_name,
    				'status'=>$row->status,
    				'add_date'=>$row->add_date,
    				'balance'=>$balance,
    				'balance2'=>$balance2,
    				);
    				array_push($resparray["data"],$data);
    					}
    					echo json_encode($resparray);exit;
    				}   
				}
				else if($usertype_name == "Distributor")
				{
				    $rslt = $this->db->query("select 
				    a.user_id,
				    a.businessname,
				    a.username,
				    a.mobile_no,
				    a.status,
				    Date(a.add_date) as add_date,
				    a.usertype_name
    				from tblusers  a
    				left join tblusers p on a.parentid = p.user_id
    				where  
    				p.parentid = ? and p.fos_id = ? order by a.businessname ",array($user_id,$distid));
    			
    				if($rslt->num_rows() > 0)
    				{
    				
    						$resparray = array();
    					$resparray["data"] = array();
    		
    					foreach($rslt->result() as $row)
    					{
    					$balance = $this->Common_methods->getAgentBalance($row->user_id);
    					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
    				
    					if($row->username == ""){$username = "--";}else {$username = $row->username;}
    					if($row->mobile_no == ""){$mobile_no = "--";}else {$mobile_no = $row->mobile_no;}
    					
    					if($row->status == "1"){$status = "Active";}else {$status = "Deactive";}
    					if($row->add_date == ""){$add_date = "--";}else {$add_date = $row->add_date;}
    					
    					
    						$data = array(
    				'businessname'=>$row->businessname,
    				'username'=>$row->username,
    				'mobile_no'=>$row->mobile_no,
    				'emailid'=>"asdf@gmail.com",
    			    'usertype_name'=>$row->usertype_name,
    				'status'=>$row->status,
    				'add_date'=>$row->add_date,
    				'balance'=>$balance,
    				'balance2'=>$balance2,
    				);
    				array_push($resparray["data"],$data);
    					}
    					echo json_encode($resparray);exit;
    				}   
				}
			}
			else
			{
			    $resparray = array(
		            "status"=>1,
		            "message"=>"Invalid user Id Or Password"
		        );
		        echo json_encode($resparray);exit;
			}
			
			
		}
	}
	
	public function index() 
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$this->logentry("get ".json_encode($this->input->get()));
			$this->logentry("post ".json_encode($this->input->post()));
			$resp2 = file_get_contents("php://input");
			$this->logentry("row : ".json_encode($resp2));
			$resp2 = "username=9287398237&password=12345&";
			
			$jsonobj = json_decode($resp2);
			
		//	print_r($jsonobj);exit;
		if(isset($_GET["number"]) and isset($_GET["username"]) and isset($_GET["password"]))
		{
			$number = trim($_GET["number"]);
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$rslt = $this->db->query("select user_id,businessname,username,mobile_no,emailid,status,Date(add_date) as add_date,usertype_name from tblusers where (mobile_no = ? or username = ?)",array($number,$number));	
				if($rslt->num_rows() > 0)
				{
				    $resparray = array();
					$resparray["data"] = array();
					foreach($rslt->result() as $row)
					{
					$balance = $this->Common_methods->getAgentBalance($row->user_id);
					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
					
				
				
					$data = array(
				'businessname'=>$row->businessname,
				'username'=>$row->username,
				'mobile_no'=>$row->mobile_no,
				'emailid'=>$row->emailid,
				'usertype_name'=>$row->usertype_name,
				'status'=>$row->status,
				'add_date'=>$row->add_date,
				'balance'=>$balance,
				'balance2'=>$balance2,
				);
				array_push($resparray["data"],$data);
					}
					echo json_encode($resparray);exit;
				}
			}
			
			
		}
		else if(isset($_GET["username"]) and isset($_GET["password"]))
		{
			
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				if($usertype_name == "FOS")
				{
				    $rslt = $this->db->query("select user_id,businessname,username,mobile_no,status,Date(add_date) as add_date,usertype_name
				from tblusers where  fos_id = ? order by businessname ",array($user_id));    
				}
				else
				{
				    $rslt = $this->db->query("select user_id,businessname,username,mobile_no,status,Date(add_date) as add_date,usertype_name
				from tblusers where  parentid = ? order by businessname ",array($user_id));    
				}
				
			
				if($rslt->num_rows() > 0)
				{
				
						$resparray = array();
					$resparray["data"] = array();
		
					foreach($rslt->result() as $row)
					{
					$balance = $this->Common_methods->getAgentBalance($row->user_id);
					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
				
					if($row->username == ""){$username = "--";}else {$username = $row->username;}
					if($row->mobile_no == ""){$mobile_no = "--";}else {$mobile_no = $row->mobile_no;}
					
					if($row->status == "1"){$status = "Active";}else {$status = "Deactive";}
					if($row->add_date == ""){$add_date = "--";}else {$add_date = $row->add_date;}
					
					
						$data = array(
				'businessname'=>$row->businessname,
				'username'=>$row->username,
				'mobile_no'=>$row->mobile_no,
				'emailid'=>"asdf@gmail.com",
			    'usertype_name'=>$row->usertype_name,
				'status'=>$row->status,
				'add_date'=>$row->add_date,
				'balance'=>$balance,
				'balance2'=>$balance2,
				);
				array_push($resparray["data"],$data);
					}
					echo json_encode($resparray);exit;
				}
			}
			else
			{
			    $resparray = array(
		            "status"=>1,
		            "message"=>"Invalid user Id Or Password"
		        );
		        echo json_encode($resparray);exit;
			}
			
			
		}
		
		
		
		
		else if(isset($_POST["number"]) and isset($_POST["username"]) and isset($_POST["password"]))
		{
			$number = trim($_POST["number"]);
			$username = trim($_POST["username"]);
			$password = trim($_POST["password"]);
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$rslt = $this->db->query("select user_id,businessname,username,mobile_no,emailid,status,Date(add_date) as add_date from tblusers where (mobile_no = ? or username = ?)",array($number,$number));	
				if($rslt->num_rows() > 0)
				{
				    $resparray = array();
					$resparray["data"] = array();
					foreach($rslt->result() as $row)
					{
					$balance = $this->Common_methods->getAgentBalance($row->user_id);
					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
					
				
				
					$data = array(
				'businessname'=>$row->businessname,
				'username'=>$row->username,
				'mobile_no'=>$row->mobile_no,
				'emailid'=>$row->emailid,
				'emailid'=>$row->amount,
				'status'=>$row->status,
				'add_date'=>$row->add_date,
				'balance'=>$balance,
				'balance2'=>$balance2,
				);
				array_push($resparray["data"],$data);
					}
					echo json_encode($resparray);exit;
				}
			}
			
			
		}
		else if(isset($_POST["username"]) and isset($_POST["password"]))
		{
			
			$username = trim($_POST["username"]);
			$password = trim($_POST["password"]);
			$userinfo = $this->db->query("select user_id from tblusers where username = ? and password = ?",array($username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$rslt = $this->db->query("select user_id,businessname,username,mobile_no,status,Date(add_date) as add_date,usertype_name
				from tblusers where  parentid = ? order by businessname",array($user_id));	
				if($rslt->num_rows() > 0)
				{
				
						$resparray = array();
					$resparray["data"] = array();
		
					foreach($rslt->result() as $row)
					{
					$balance = $this->Common_methods->getAgentBalance($row->user_id);
					$balance2 = $this->Ew2->getAgentBalance($row->user_id);
				
					if($row->username == ""){$username = "--";}else {$username = $row->username;}
					if($row->mobile_no == ""){$mobile_no = "--";}else {$mobile_no = $row->mobile_no;}
					if($row->emailid == ""){$emailid = "--";}else {$emailid = $row->emailid;}
					if($row->status == "1"){$status = "Active";}else {$status = "Deactive";}
					if($row->add_date == ""){$add_date = "--";}else {$add_date = $row->add_date;}
					
					
						$data = array(
				'businessname'=>$row->businessname,
				'username'=>$row->username,
				'mobile_no'=>$row->mobile_no,
				'emailid'=>"abcd@gmail.com",
			    'usertype_name'=>$row->usertype_name,
				'status'=>$row->status,
				'add_date'=>$row->add_date,
				'balance'=>$balance,
				'balance2'=>$balance2,
				);
				array_push($resparray["data"],$data);
					}
					echo json_encode($resparray);exit;
				}
			}
			else
			{
			    $resparray = array(
		            "status"=>1,
		            "message"=>"Invalid user Id Or Password"
		        );
		        echo json_encode($resparray);exit;
			}
			
			
		}
		else 
		{
		    $resparray = array(
		            "status"=>1,
		            "message"=>"Parameter Missing"
		        );
		        echo json_encode($resparray);exit;
		}
		
		
		

	}
	
}