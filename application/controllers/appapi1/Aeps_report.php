<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_report extends CI_Controller {
	
	 
	public function index() 
	{
	    //echo "";exit;
	    error_reporting(-1);
	    ini_set('display_errors',1);
	    $this->db->db_debug = TRUE;
	    
	    //http://streampayonline.in/appapi1/getDmrList?from=2019-01-01&to=2019-03-31&username=&password=
	    
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
		    if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["username"]) and isset($_GET["password"]))
			{
				$from = trim($_GET["from"]);
				$to = trim($_GET["to"]);
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				
				
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');								
				$from = date_format(date_create($from),'Y-m-d');
				$to = date_format(date_create($to),'Y-m-d');
				
				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ? and password = ? and host_id = ?",array($username,$password,$host_id));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$usertype_name = $userinfo->row(0)->usertype_name;	
					if($usertype_name == "Distributor")
					{
					    		$rslt = $this->db->query("SELECT a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


FROM `aeps_transactions2` a 
where 
a.user_id = ? and 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ? 

order by Id desc",array($user_id,$from,$to));
					}
					
					else
					{
					    $rslt = $this->db->query("
						SELECT 
						a.Id, a.add_date, a.ipaddress, a.request_id, a.session_id, a.app_id, a.outlet_mobile, a.sp_key, a.amount, a.order_id, a.customer_params, a.user_id, a.response_code, a.response_msg, a.balance, a.cb_ipay_id, a.cb_agent_id, a.cb_opr_id, a.cb_status, a.cb_res_code, a.cb_res_msg, a.debit_amount, a.credit_amount, a.commission, a.tds, a.action_by,
						b.businessname
						FROM aeps_transactions2 a
						left join tblusers b on a.user_id = b.user_id
						where 
						Date(a.add_date) BETWEEN ? and ? and
						
						a.user_id = ?
						order by Id desc",array($from,$to,$user_id));

					}



					$resparray = array();
					$resparray["data"] = array();
					foreach($rslt->result() as $row)
					{
					
						$data = array(
							'id'=>$row->Id,
							'datetime'=>date_format(date_create($row->add_date),'Y-m-d H:i:s'),
							'TransactionId'=>$row->cb_opr_id,
							'MODE'=>$row->sp_key,
							'AadharNo'=>$row->customer_params,
							'MobileNo'=> $row->outlet_mobile,
							'Amount'=>$row->amount,
							'Commission'=>$row->commission
							);
							array_push($resparray["data"],$data);
					
					}
					echo json_encode($resparray);exit;
			         
					
				
				}
				else
				{
					$resp_array = array(
						"message"=>"Invalid User Id Or Password",
						"status"=>1,
						"statuscode"=>"ERR"
					);
					echo json_encode($resp_array);exit;
				}
			}
			
			
		}
	
		

	}
	
}