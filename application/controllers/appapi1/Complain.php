<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends CI_Controller {
	
	
	
	public function logentry($data)
	{
		
	}
	public function index() 
	{
	    $this->logentry(json_encode($this->input->get()));
		if(isset($_GET["recharge_id"]) and isset($_GET["username"]) and isset($_GET["password"]))
		{
		    
			$recharge_id = trim($_GET["recharge_id"]);
			$message = trim($_GET["remark"]);
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select * from tblusers where username = ? and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				if(true)
				{
					$rslt = $this->db->query("
					select 
					b.company_name,
					a.recharge_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.operator_id,
					a.recharge_status 
					from tblrecharge a
					left join tblcompany b on a.company_id = b.company_id 
					where a.recharge_id = ? and a.user_id = ?",array($recharge_id,$user_id));	
					if($rslt->num_rows() == 1)
					{
						$recharge_status = $rslt->row(0)->recharge_status;
						if($recharge_status == "Pending")
						{
						    $resparr = array(
							    "status"=>1,
							    "message"=>"Don't Complain For Pending Recharges"
							    );
							    echo json_encode($resparr);exit;
						//	echo "Don't Complain For Pending Recharges";exit;
						}
						$rsltcomplain = $this->db->query("select * from tblcomplain where complain_status = 'Pending' and recharge_id = ?",array($recharge_id));
						if($rsltcomplain->num_rows() >= 1)
						{
						    $resparr = array(
							    "status"=>1,
							    "message"=>"Your Complain Already In Pending Process"
							    );
							    echo json_encode($resparr);exit;
							//echo "Your Complain Already In Pending Process";exit;
						}
						else
						{
						
							$add_date = $this->common->getDate();
							$this->db->query("insert into tblcomplain(recharge_id,complain_date,user_id,message,complain_status) values(?,?,?,?,?)",array($recharge_id,$add_date,$user_id,$message,"Pending"));
							
							$resparr = array(
							    "status"=>0,
							    "message"=>"Your Complain Submit Successfully"
							    );
							    echo json_encode($resparr);exit;
							
							//echo "Your Complain Submit Successfully";exit;
						}
					}
					else
					{
					     $resparr = array(
							    "status"=>1,
							    "message"=>"Invalid Recharge Id"
							    );
			    echo json_encode($resparr);exit;
					}
				}
				else if($userinfo->row(0)->usertype_name == "WLAgent")
				{
					
						
						$rsltrecharge = $this->db->query("select recharge_id,add_date,recharge_status from WLtblrecharge where recharge_id = ? and user_id = ? and hostname = ?",array($recharge_id,$user_id,$hostname));
						
						if($rsltrecharge->num_rows() == 1)
						{
							$recharge_status = $rsltrecharge->row(0)->recharge_status;
							if($recharge_status == "Pending")
							{
							    	$resparray = array(
                    				'Error'=>1,
                    				'Message'=>"InvalidDon't Complain For Pending Recharges"
                    				);
                    				echo json_encode($resparray);exit;
								
							}
							$rsltcheckcomplain = $this->db->query("select * from WLtblcomplain where recharge_id = ? and complain_status = 'Pending'",array($recharge_id));
							if($rsltcheckcomplain->num_rows() == 1)
							{
							    $resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Your Complain Already In Pending Process'
                    				);
                    				echo json_encode($resparray);exit;
							
							}
							else
							{
								$txtToDate = date_format(date_create($rsltrecharge->row(0)->add_date),'y-m-d');
								$date = $this->common->getMySqlDate();
								$date1= strtotime($txtToDate);
								$date2= strtotime($date);
								$secs = $date2 - $date1;// == return sec in difference
								$days = $secs / 86400;
							
								//if($days <= 5)
								if(true)
								{
									$this->db->query("insert into WLtblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id,hostname) values(?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),'Pending',$message,'Recharge',$recharge_id,$hostname));
									$resparray = array(
                    				'Error'=>0,
                    				'Message'=>'Your Complain Accepted'
                    				);
                    				echo json_encode($resparray);exit;
								}
								else
								{
    								$resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Invalid Recharge Id'
                    				);
                    				echo json_encode($resparray);exit;
								}
								
							}
						}
						else
						{
						    	$resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Invalid Recharge Id'
                    				);
                    				echo json_encode($resparray);exit;
						}
					
					
				}
				
				
			}
			else
			{
			    $resparr = array(
							    "status"=>1,
							    "message"=>"Invalid User Id or Password"
							    );
			    echo json_encode($resparr);exit;
			
			}
			
			
		}
		else if(isset($_POST["recharge_id"]) and isset($_POST["username"]) and isset($_POST["password"]))
		{
			$recharge_id = trim($_POST["recharge_id"]);
			$message = trim($_POST["remark"]);
			$username = trim($_POST["username"]);
			$password = trim($_POST["password"]);
			$userinfo = $this->db->query("select * from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				
				if(true)
				{
					$rslt = $this->db->query("select company_name,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ? and tblrecharge.user_id = ?",array($recharge_id,$user_id));	
					if($rslt->num_rows() == 1)
					{
						$recharge_status = $rslt->row(0)->recharge_status;
						if($recharge_status == "Pending")
						{
						$resparr = array(
							    "status"=>1,
							    "message"=>"Don't Complain For Pending Recharges"
							    );
							    echo json_encode($resparr);exit;
						}
						$rsltcomplain = $this->db->query("select * from tblcomplain where complain_status = 'Pending' and recharge_id = ?",array($recharge_id));
						if($rsltcomplain->num_rows() >= 1)
						{
							$resparr = array(
							    "status"=>1,
							    "message"=>"Your Complain Already In Pending Process"
							    );
							    echo json_encode($resparr);exit;
						}
						else
						{
						
							$add_date = $this->common->getDate();
							$this->db->query("insert into tblcomplain(recharge_id,complain_date,user_id,message,complain_status) values(?,?,?,?,?)",array($recharge_id,$add_date,$user_id,$message,"Pending"));
						$resparr = array(
							    "status"=>0,
							    "message"=>"Your Complain Submit Successfully"
							    );
							    echo json_encode($resparr);exit;
						}
					}
					else
					{
					    $resparray = array(
                    				'status'=>1,
                    				'message'=>"Invalid Recharge Id"
                    				);
                    				echo json_encode($resparray);exit;
					}
				}
				else if($userinfo->row(0)->usertype_name == "WLAgent")
				{
					
						
						$rsltrecharge = $this->db->query("select recharge_id,add_date,recharge_status from WLtblrecharge where recharge_id = ? and user_id = ? and hostname = ?",array($recharge_id,$user_id,$hostname));
						
						if($rsltrecharge->num_rows() == 1)
						{
							$recharge_status = $rsltrecharge->row(0)->recharge_status;
							if($recharge_status == "Pending")
							{
							    	$resparray = array(
                    				'Error'=>1,
                    				'Message'=>"InvalidDon't Complain For Pending Recharges"
                    				);
                    				echo json_encode($resparray);exit;
								
							}
							$rsltcheckcomplain = $this->db->query("select * from WLtblcomplain where recharge_id = ? and complain_status = 'Pending'",array($recharge_id));
							if($rsltcheckcomplain->num_rows() == 1)
							{
							    $resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Your Complain Already In Pending Process'
                    				);
                    				echo json_encode($resparray);exit;
							
							}
							else
							{
								$txtToDate = date_format(date_create($rsltrecharge->row(0)->add_date),'y-m-d');
								$date = $this->common->getMySqlDate();
								$date1= strtotime($txtToDate);
								$date2= strtotime($date);
								$secs = $date2 - $date1;// == return sec in difference
								$days = $secs / 86400;
							
								//if($days <= 5)
								if(true)
								{
									$this->db->query("insert into WLtblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id,hostname) values(?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),'Pending',$message,'Recharge',$recharge_id,$hostname));
									$resparray = array(
                    				'Error'=>0,
                    				'Message'=>'Your Complain Accepted'
                    				);
                    				echo json_encode($resparray);exit;
								}
								else
								{
    								$resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Invalid Recharge Id'
                    				);
                    				echo json_encode($resparray);exit;
								}
								
							}
						}
						else
						{
						    	$resparray = array(
                    				'Error'=>1,
                    				'Message'=>'Invalid Recharge Id'
                    				);
                    				echo json_encode($resparray);exit;
						}
					
					
				}
				
				
			}
			else
			{
				$resparr = array(
							    "status"=>1,
							    "message"=>"Data Not Found"
							    );
							    echo json_encode($resparr);exit;
			}
			
			
		}
		
	
		

	}
	public function getcomplainList()
	{
		
		
		if(isset($_GET["username"]) and isset($_GET["password"]))
		{
		
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ? and password = ?",array($username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;	
				$usertype_name = $userinfo->row(0)->usertype_name;	
				if(true)
				{
				    	$resparray = array();
	            	    $resparray["data"] = array();
					$complain_rslt = $this->db->query("select * from tblcomplain where user_id = ? order by complain_id desc limit 20",array($user_id));
					foreach($complain_rslt->result() as $row)
					{
					
					$rsltrecharge = $this->db->query("select company_name,mcode,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.user_id = ? and recharge_id = ?",array($user_id,$row->recharge_id));
					if($rsltrecharge->num_rows() == 1)
					{
					    
					    $data = array(
				'id'=>$row->recharge_id,
				'mcode'=>$rsltrecharge->row(0)->mcode,
				'operator'=>$rsltrecharge->row(0)->company_name,
				'mobile'=>$rsltrecharge->row(0)->mobile_no,
				'amount'=>$rsltrecharge->row(0)->amount,
				'recstatus'=>$rsltrecharge->row(0)->recharge_status,
				'operator_id'=>$rsltrecharge->row(0)->operator_id,
				'recDate'=>$rsltrecharge->row(0)->add_date,
				'complain_id'=>$row->complain_id,
				'remark'=>$row->message,
				'complain_date'=>$row->complain_date,
				'solv_date'=>$row->complainsolve_date,
				'response_message'=>$row->response_message,
				
				);
				array_push($resparray["data"],$data);
					}
				}
				
				}
				else if($usertype_name == 'WLAgent')
				{
				    	$resparray = array();
	            	    $resparray["data"] = array();
					$complain_rslt = $this->db->query("select * from WLtblcomplain where user_id = ? order by complain_id desc limit 20",array($user_id));
					foreach($complain_rslt->result() as $row)
					{
					
					$rsltrecharge = $this->db->query("select company_name,mcode,imageurl,recharge_id,WLtblrecharge.mobile_no,WLtblrecharge.amount,WLtblrecharge.add_date,WLtblrecharge.operator_id,WLtblrecharge.recharge_status from WLtblrecharge,tblcompany where tblcompany.company_id = WLtblrecharge.company_id and WLtblrecharge.user_id = ? and recharge_id = ?",array($user_id,$row->recharge_id));
					if($rsltrecharge->num_rows() == 1)
					{
					    
					     $data = array(
				'id'=>$row->recharge_id,
			
				'operator'=>$rsltrecharge->row(0)->company_name,
				'mobile'=>$rsltrecharge->row(0)->mobile_no,
				'amount'=>$rsltrecharge->row(0)->amount,
				'recstatus'=>$rsltrecharge->row(0)->recharge_status,
				'operator_id'=>$rsltrecharge->row(0)->operator_id,
				'recDate'=>$rsltrecharge->row(0)->add_date,
				
				'complain_id'=>$row->complain_id,
				'remark'=>$row->message,
				'complain_date'=>$row->complain_date,
				'solv_date'=>$row->complainsolve_date,
				'response_message'=>$row->response_message,
				
				);
				array_push($resparray["data"],$data);
					}
				}
				
				
				}
				
				
			}
			
		}
		
		
		
		echo json_encode($resparray);exit;
		

	}

}