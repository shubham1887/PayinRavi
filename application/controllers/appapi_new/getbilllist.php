<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getbilllist extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET["username"]) and isset($_GET["password"]))
			{
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$host_id = 1;
				$userinfo = $this->db->query("select user_id,status from tblusers where username = ?  and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$resultbills = $this->db->query("SELECT 
					a.Id,
					a.user_id,
					a.add_date,
					a.service_no,
					a.customer_mobile,
					a.customer_name,
					a.dueamount,
					a.duedate,
					a.billnumber,
					a.billdate,
					a.billperiod,
					a.company_id,
					a.bill_amount,
					a.status,
					a.opr_id,
					a.charged_amt,
					a.resp_status,
					a.res_code,
					a.debit_amount,
					a.credit_amount,
					a.option1,
					b.company_name,
					b.mcode,
					c.businessname,
					c.username 
					FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where a.user_id = ?  order by a.Id desc limit 50",array($user_id));
					$resparray = array();
					$resparray["data"] = array();
					foreach($resultbills->result() as $row)
					{
					    $recdt = $row->add_date;
						 $recdatetime =date_format(date_create($recdt),'Y-m-d H:i:s');
						 $cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
						 $this->load->model("Update_methods");
						 $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
						 $dtfr = date_format(date_create($this->common->getDate()),'YmdHis');
						 //$operator_trans_id = "MP".$dtfr.$row->transaction_id;
						 $status = $row->status;
						 
						 if($row->status == 'Pending')
						 {
							if($diff > 5)
							{
								$status = "Success";
							}
						 }
						$customer_name = $row->customer_name;
						if($row->customer_name == "")
						{
							$customer_name = "--";
						}
						
					$data = array(
							'id'=>$row->Id,
							'company_name'=>$row->company_name,
							'mcode'=>$row->mcode,
							'customer_name'=>$customer_name,
							'customer_mobile'=>$row->customer_mobile,
							'service_no'=>$row->service_no,
							'status'=>$status,
							'bill_amount'=>$row->bill_amount,
							'opr_id'=>$row->opr_id,
							'DateTime'=>$row->add_date,
							);
							array_push($resparray["data"],$data);

					}
					echo json_encode($resparray);exit;
				}
				else
				{
					$resparr = array(
    							    "status"=>"1",
    							    "message"=>"Invalid UserId Or Password"
    							    );
    				echo json_encode($resparr);exit;
				}
			}
			
			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST["username"]) and isset($_POST["password"]))
			{
				$username = trim($_POST["username"]);
				$password = trim($_POST["password"]);
				$userinfo = $this->db->query("select user_id,status from tblusers where username = ?  and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$resultbills = $this->db->query("SELECT 
					a.Id,
					a.user_id,
					a.add_date,
					a.service_no,
					a.customer_mobile,
					a.customer_name,
					a.dueamount,
					a.duedate,
					a.billnumber,
					a.billdate,
					a.billperiod,
					a.company_id,
					a.bill_amount,
					a.status,
					a.opr_id,
					a.charged_amt,
					a.resp_status,
					a.res_code,
					a.debit_amount,
					a.credit_amount,
					a.option1,
					b.company_name,
					b.mcode,
					c.businessname,
					c.username 
					FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where a.user_id = ?  order by a.Id desc limit 50",array($user_id));
					$resparray = array();
					$resparray["data"] = array();
					foreach($resultbills->result() as $row)
					{
						$customer_name = $row->customer_name;
						if($row->customer_name == "")
						{
							$customer_name = "--";
						}
						
					$data = array(
							'id'=>$row->Id,
							'company_name'=>$row->company_name,
							'mcode'=>$row->mcode,
							'customer_name'=>$customer_name,
							'customer_mobile'=>$row->customer_mobile,
							'service_no'=>$row->service_no,
							'status'=>$row->status,
							'bill_amount'=>$row->bill_amount,
							'opr_id'=>$row->opr_id,
							'DateTime'=>$row->add_date,
							);
							array_push($resparray["data"],$data);

					}
					echo json_encode($resparray);exit;
				}
				else
				{
					$resparr = array(
    							    "status"=>"1",
    							    "message"=>"Invalid UserId Or Password"
    							    );
    				echo json_encode($resparr);exit;
				}
			}
			else
			{
			    $resparr = array(
    							    "status"=>"1",
    							    "message"=>"Parameter Missing"
    							    );
    			echo json_encode($resparr);exit;
			}
			
			
		}
		
		
	

	}
	
}