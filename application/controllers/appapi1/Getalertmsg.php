<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getalertmsg extends CI_Controller {
	
	
	
	
	public function index() 
	{
		 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{$username = $_POST['username'];$pwd =  $_POST['pwd'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
	
		if($userinfo->num_rows() == 1)
		{
			$user_id = $userinfo->row(0)->user_id;
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->businessname;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$username = $userinfo->row(0)->username;
			if($status == '1')
			{
				
				$CustomerCare_rslt = $this->db->query("select value from admininfo where param = 'CustomerCare' and host_id = ?",array($host_id));
        		$EmailId_rslt = $this->db->query("select value from admininfo where param = 'EmailId'  and host_id = ?",array($host_id));
        		$OfficeAddress_rslt = $this->db->query("select value from admininfo where param = 'OfficeAddress'  and host_id = ?",array($host_id));
        		$CompanyInfo_rslt = $this->db->query("select value from admininfo where param = 'CompanyInfo'  and host_id = ?",array($host_id));
        		$Message_rslt = $this->db->query("select value from admininfo where param = 'Message'  and host_id = ?",array($host_id));
        		$CustomerCare = $CustomerCare_rslt->row(0)->value;
        		$EmailId = $EmailId_rslt->row(0)->value;
        		$OfficeAddress = $OfficeAddress_rslt->row(0)->value;
        		$CompanyInfo = $CompanyInfo_rslt->row(0)->value;
        		$Message = $Message_rslt->row(0)->value;
				
				
				$data = array(
						'Message'=>$Message,
						'CustomerCare'=>$CustomerCare,
						'EmailId'=>$EmailId,
						'OfficeAddress'=>$OfficeAddress,
						"CompanyInfo"=>$CompanyInfo,
						
						);
				
				echo json_encode($data);exit;
			}
			else
			{
				$resparray = array(
				'Error'=>1,
				'Message'=>'Your account is deactivated. contact your Administrator'
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
		    $host_id = 1;
			$CustomerCare_rslt = $this->db->query("select value from admininfo where param = 'CustomerCare' and host_id = ?",array($host_id));
        		$EmailId_rslt = $this->db->query("select value from admininfo where param = 'EmailId'  and host_id = ?",array($host_id));
        		$OfficeAddress_rslt = $this->db->query("select value from admininfo where param = 'OfficeAddress'  and host_id = ?",array($host_id));
        		$CompanyInfo_rslt = $this->db->query("select value from admininfo where param = 'CompanyInfo'  and host_id = ?",array($host_id));
        		$Message_rslt = $this->db->query("select value from admininfo where param = 'Message'  and host_id = ?",array($host_id));
        		$CustomerCare = $CustomerCare_rslt->row(0)->value;
        		$EmailId = $EmailId_rslt->row(0)->value;
        		$OfficeAddress = $OfficeAddress_rslt->row(0)->value;
        		$CompanyInfo = $CompanyInfo_rslt->row(0)->value;
        		$Message = $Message_rslt->row(0)->value;
				
				
				$data = array(
						'Message'=>$Message,
						'CustomerCare'=>$CustomerCare,
						'EmailId'=>$EmailId,
						'OfficeAddress'=>$OfficeAddress,
						"CompanyInfo"=>$CompanyInfo,
						
						);
				
				echo json_encode($data);exit;
		}
	
	
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
      
	}
	
}