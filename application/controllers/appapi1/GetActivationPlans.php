<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetActivationPlans extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if(isset($_GET["mcode"]))
		{
			$company_id = trim($_GET["mcode"]);
			$rsltdthplans = $this->db->query("SELECT tbldthplans.*,company_name,mcode FROM tbldthplans,tblcompany where tblcompany.company_id = tbldthplans.company_id and tblcompany.mcode = ? order by amount",array($company_id));
			
		$resparray = array();
		$resparray["data"] = array();
			foreach($rsltdthplans->result() as $row)
			{
			
				$data = array(
				'company_id'=>$row->company_id,
				'company_name'=>$row->company_name,
				'mcode'=>$row->mcode,
				'Id'=>$row->Id,
				'plan_name'=>$row->plan_name,
				'amount'=>$row->amount,
				'commission'=>$row->commission,
				);
				array_push($resparray["data"],$data);
		
			}
			echo json_encode($resparray);exit;
		}
	}
	
}