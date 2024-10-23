<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetActivationReqList extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if(isset($_GET["username"]) and isset($_GET["password"]))
		{
			
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$userinfo = $this->db->query("select user_id from tblusers where username = ? and password = ?",array($username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$rslt = $this->db->query("select tblactivation.*,businessname,tbldthplans.plan_name,tbldthplans.amount as plan_amount,tbldthplans.commission as plan_commission,company_name,mcode from tblactivation,tblcompany,tblusers,tbldthplans where tblcompany.company_id = tblactivation.company_id and tblusers.user_id = tblactivation.user_id and tbldthplans.Id =  tblactivation.plan_id and tblactivation.user_id=? order by tblactivation.Id desc",array($user_id));	
			
		$resparray = array();
		$resparray["data"] = array();
				foreach($rslt->result() as $row)
				{
				$id=$this->managestring($row->Id);
				$company_id=$this->managestring($row->company_id);
				$plan_id=$this->managestring($row->plan_id);
				$name=$this->managestring($row->name);
				$number=$this->managestring($row->number);
				$address=$this->managestring($row->address);
				$pincode=$this->managestring($row->pincode);
				$amount=$this->managestring($row->amount);
				$commission=$this->managestring($row->commission);
				$add_date=$this->managestring($row->add_date);
				$status=$this->managestring($row->status);
				$remark=$this->managestring($row->remark);
				$plan_name=$this->managestring($row->plan_name);
				$plan_amount=$this->managestring($row->plan_amount);
				$plan_commission=$this->managestring($row->plan_commission);
				$company_name=$this->managestring($row->company_name);
				$mcode=$this->managestring($row->mcode);
				
				
				
				
					$data = array(
				'Id'=>$id,
				'DateTime'=>$add_date,
				'mcode'=>$mcode,
				'company_name'=>$company_name,
				'plan_amount'=>$plan_amount,
				'plan_name'=>$plan_name,
				'plan_commission'=>$plan_commission,
				'CustName'=>$name,
				'CustMobile'=>$number,
				'address'=>$address,
				'Status'=>$status,
				'Remark'=>$remark,
				);
				array_push($resparray["data"],$data);
				}
				echo json_encode($resparray);exit;
			}	
		}
	}
	private function managestring($data)
	{
			return $data;	
	}
	
}