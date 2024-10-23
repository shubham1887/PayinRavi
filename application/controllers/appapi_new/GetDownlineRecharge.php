<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetDownlineRecharge extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["username"]) and isset($_GET["password"]) )
			{
				$from = trim($_GET["from"]);
				$to = trim($_GET["to"]);
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$number = '';
			
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');								
				$from = date_format(date_create($from),'Y-m-d');
				$to = date_format(date_create($to),'Y-m-d');
				
				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? and host_id = ?",array($username,$password,$host_id));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$rslt = $this->db->query("select 
					b.company_name,
					b.mcode,
					a.recharge_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.operator_id,
					a.commission_amount,
					a.recharge_status ,
					c.businessname,
					c.username
					from 
					tblrecharge a
					left join tblcompany b on a.company_id = b.company_id 
					left join tblusers c on a.user_id = c.user_id
					left join tblusers p on c.parentid = p.user_id
					where  
					a.amount > 0 and
					(a.edit_date != '60' and a.edit_date != '5') and
					(Date(a.add_date) >= ? and 
					Date(a.add_date) <= ?) and 
					(c.parentid = ?  or p.parentid = ?)
				
					order by a.recharge_id",array($from,$to,$user_id,$user_id));	
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
		
			
			
		}
	
		
	if((isset($_POST["username"]) and isset($_POST["password"])) or (isset($_GET["username"]) and isset($_GET["password"])))
        {
		$resparray = array();
		$resparray["data"] = array();
		foreach($rslt->result() as $row)
		{
		
		$data = array(
				'id'=>$row->recharge_id,
				'mcode'=>$row->mcode,
				'businessname'=>$row->businessname,
				'username'=>$row->username,
				'operator'=>$row->company_name,
				'mobile'=>$row->mobile_no,
				'amount'=>$row->amount,
				'commission'=>$row->commission_amount,
				'status'=>$row->recharge_status,
				'operator_id'=>$row->operator_id,
				'recDate'=>$row->add_date,
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