<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetDmrList extends CI_Controller {
	
	 
	
	
	public function index() 
	{
	    //echo "";exit;
	    
	    //http://www.PAY91.IN/appapi1/getDmrList?from=2019-01-01&to=2019-03-31&username=&password=
	    
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
					    		$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


FROM `mt3_transfer` a 
where 
a.user_id = ? and 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ? 

order by Id desc",array($user_id,$from,$to));
					}
					else if($usertype_name == "FOS")
					{
					    	$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


    FROM `mt3_transfer` a 
    left join tblusers b on a.user_id = b.user_id
    
    
where 
b.fos_id = ?  and 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ? 
order by Id desc",array($user_id,$from,$to));
					}
					else
					{
					    	$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


FROM `mt3_transfer` a 

where 
a.user_id = ? and 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ?  

order by Id desc",array($user_id,$from,$to));
					}
					
				
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			else if(isset($_GET["username"]) and isset($_GET["password"]))
			{
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ? and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$usertype_name = $userinfo->row(0)->usertype_name;	
					if($usertype_name == "Distributor")
					{
					    	$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


FROM `mt3_transfer` a where a.user_id = ? order by Id desc limit 30",array($user_id));
					}
					else if($usertype_name == "FOS")
					{
					    	$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


    FROM `mt3_transfer` a 
    left join tblusers b on a.user_id = b.user_id
    
    
where b.fos_id = ? order by Id desc limit 30",array($user_id));
					}
					else
					{
					    	$rslt = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock


FROM `mt3_transfer` a where a.user_id = ? order by Id desc limit 30",array($user_id));
					}
				
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			
			
		}
		
		
	if((isset($_GET["username"]) and isset($_GET["password"])))
        {
		$resparray = array();
		$resparray["data"] = array();
		foreach($rslt->result() as $row)
		{
		
		
		    $status = $row->Status;
		    if($status == "HOLD")
		    {
		        $status = "PENDING";
		    }
		    $benificiary_name = $row->RESP_name;
		   
		$data = array(
				'id'=>$row->Id,
				'datetime'=>$row->add_date,
				'RemiterMobile'=>$row->RemiterMobile,
				'AccountNumber'=>$row->AccountNumber,
				'IFSC'=>$row->IFSC,
				'Amount'=>$row->Amount,
				'Status'=> $status,
				'mode'=>$row->mode,
				'oprator_id'=>$row->RESP_opr_id,
				'bene_name'=>$benificiary_name,
				'statuscode'=>$row->RESP_statuscode,
				'response'=>$row->RESP_status,
				);
				array_push($resparray["data"],$data);
		
		}
		echo json_encode($resparray);exit;
         }
         else
         {
               echo "Paramter Missing";exit;
         }
	
		

	}
	
}