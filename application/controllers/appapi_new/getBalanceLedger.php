<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetBalanceLedger extends CI_Controller {
	
	
	
    public function index()
    {
        
        if(isset($_GET["username"]) and isset($_GET["password"]))
        {
           $username =  trim($_GET["username"]);
           $password =  trim($_GET["password"]);
           $host_id = 1;
           $userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? ",array($username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				 $rslt = $this->db->query('
				 select a.recharge_id,a.mobile_no,a.amount,a.recharge_status,a.add_date,a.balance,b.company_name,b.mcode   
				 from tblrecharge a 
				 left join tblcompany b on a.company_id = b.company_id 
				 left join tblrecharge r on a.recharge_id = r.recharge_id
				 where a.user_id = ? and Date(a.add_date) = ? 
				 order by a.recharge_id desc
				 
				 ',array($user_id,$this->common->getMySqlDate()));
                $resparray = array();
        		$resparray["data"] = array();
        		foreach($rslt->result() as $row)
        		{
        		
        		
        		$data = array(
        				'id'=>$row->Id,
        				'mcode'=>$row->mcode,
        				'operator'=>$row->company_name,
        				'mobile'=>$row->mobile_no,
        				'amount'=>$row->amount,
        				'status'=>$row->recharge_status,
        				'recDate'=>$row->add_date,
        				'balance'=>str_replace(",","",$row->balance),
        				);
        				array_push($resparray["data"],$data);
        		
        		}
        		echo json_encode($resparray);exit;
			}
           
          
        }
        
    }
	
	
}