<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetAdminBank extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if(isset($_GET["username"]) and isset($_GET["password"]))
	     {
			$username = trim($_GET["username"]);
			$password = trim($_GET["password"]);
			$host_id = 1;
	         $userinfo = $this->db->query("select user_id,usertype_name from tblusers where username = ? and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$rsltbanks = $this->db->query("select 
				a.Id,
				'' as ImageUrl,
				CONCAT(b.bank_name,'-',a.account_number,'-',a.ifsc,'-',a.account_name) as BankDetails,
				b.bank_name as BankName,
				a.account_name as HolderName,
				a.account_number as AccountNo,
				a.ifsc as IFSCCode,
				a.branch as BranchName,
				'' as BankImage
				 from creditmaster_banks a left join tblbank b on a.bank_id = b.bank_id order by a.Id");
				echo json_encode($rsltbanks->result());exit;
			}
		}


	}
	
}