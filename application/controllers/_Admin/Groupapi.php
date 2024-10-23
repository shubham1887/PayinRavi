<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupapi extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {

       if($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function pageview()
	{ 
		$rslt = $this->db->query("select company_id,company_name from tblcompany");
		$this->view_data['result_company'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/groupapi_view',$this->view_data);		
	}
	
	
	public function getresult()
	{
	    $str_company_id = "";
		$group_id = $_GET["groupid"];
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$group_info = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
		$str = '<div>Commission Structure of '.$group_info->row(0)->group_name.'</div><input type="hidden" id="uid" name="uid" value="'.$group_id.'">
		<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
				<tr>  
    				<th>Sr No.</th>
    				<th>Network</th>
    				<th>Client Commission %</th>
    				<th>Min Commission</th>
    				<th>Max Commission</th>
    				<th>Commission Type</th>
    				<th></th>
				</tr>';
    	$i = 0;
		$result_company = $this->db->query("select * from tblcompany order by service_id,company_name");
		foreach($result_company->result() as $row) 	
		{
		$str_company_id.=$row->company_id.",";
					$rslt  = $this->db->query("select * from tblgroupapi where group_id = ? and company_id = ?",array($group_id,$row->company_id));
					$adm_com_rslt  = $this->db->query("select * from tblcompany where company_id = ?",array($row->company_id));
				if($i % 2 == 0)
				{
					$str .='<tr class="row1">';
				}
				else
				{
					$str .='<tr class="row2">';
				}
					$str.='
			
					<td >'.$i.'</td>
					<td >'.$row->company_name.'</td>';
					
					
					
					
					if($rslt->num_rows() > 0)
					{
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value="'.$rslt->row(0)->commission_per.'"/>';
							$str.= '</td>';
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMinCom'.$row->company_id.'" name="txtMinCom'.$row->company_id.'" value="'.$rslt->row(0)->min_com_limit.'"/>';
							$str.= '</td>';
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMaxCom'.$row->company_id.'" name="txtMaxCom'.$row->company_id.'" value="'.$rslt->row(0)->max_com_limit.'"/>';
							$str.= '</td>';
							$str.= '<td>';
							if($rslt->row(0)->commission_type == "PER")
							{
								$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
								<option value="PER">Percentage</option>
								<option value="AMOUNT">Amount</option>';
								$str.= '</select>';
							}
							else
							{
								$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
								<option value="AMOUNT">Amount</option>
								<option value="PER">Percentage</option>';
								$str.= '</select>';
							}
							$str.= '</td>';
					}
					else
					{
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMinCom'.$row->company_id.'" name="txtMinCom'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						$str.= '<td><input style="width:150px;" class="form-control" type="text" width="30" id="txtMaxCom'.$row->company_id.'" name="txtMaxCom'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						
						
						
						$str.= '<td>';
							
						$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
						<option value="PER">Percentage</option>
						<option value="AMOUNT">Amount</option>';
						$str.= '</select>';
							
							$str.= '</td>';
						
					}
					$str.='
					<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$group_id.'\')"/></td>
					</tr>
					';
					$i++;
				
		} 
		
		
		$str.='<tr>
    <td></td>
 
    <td colspan=3 align="center">
        <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeall()">
        <input type="hidden" id="hidcompany_ids" value="'.$str_company_id.'">
    </td>
</tr>';
		
       $str.='</table>';
				echo $str;
	}
	public function index() 
	{
					$this->pageview();		
	}
	function ChangeCommission()
	{
		if($this->session->userdata("ausertype") != "Admin")
		{
			"UN Authorized Access";exit;
		}
		
		$comm = trim($_GET["com"]);
		$mincom = trim($_GET["mincom"]);
		$maxcom = trim($_GET["maxcom"]);
		$comtype = $_GET["comtype"];
		$group_id = $_GET["groupid"];
		$company_id = $_GET["company_id"];
		
		

		
		
		$groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
		if($groupinfo->num_rows() == 1)
		{
				if($maxcom >= 0 and $mincom >= 0)
				{
					if($maxcom > $mincom)
					{
						if($comm <= $maxcom and $comm >= $mincom)
						{
							$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
							if($rslt->num_rows() > 0)
							{

								$insertgroupapi = $this->db->query("update tblgroupapi set commission_per=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));

								echo "OK";exit;
							}
							else
							{
								$this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
								$this->db->query("insert into tblgroupapi(company_id,commission_per,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
								echo "OK";exit;
							}	


						}
						else
						{
							echo "Commission Not In Range";exit;
						}
					}
					else
					{
						echo "Max Commission Must Be Gragter Than Or Equal to Min Commission";exit;
					}


				}
				else
				{
					echo "Minus Value Not Allowed";exit;
				}
		}




		


	}
	public function changecommissionodl()
	{
		$comm = $_GET["com"];
		$mincom = $_GET["mincom"];
		$maxcom = $_GET["maxcom"];
		$comtype = $_GET["comtype"];
		$group_id = $_GET["groupid"];
		$company_id = $_GET["company_id"];
		$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			
			$insertgroupapi = $this->db->query("update tblgroupapi set commission_per=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));
			
			echo true;
		}
		else
		{
			$this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
			$this->db->query("insert into tblgroupapi(company_id,commission_per,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
			echo true;
		}
		
	}
	public function changeapi()
	{
		$company_id = $_GET["company_id"];
		$api_id = $_GET["api_id"];
		$group_id = $_GET["group_id"];
		$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			$str_qry ="update tblgroupapi set api_id=? where group_id = $group_id and company_id = ?";
			$insertgroupapi = $this->db->query($str_qry,array($api_id,$company_id));
			echo true;
		}
		
	}
	private function changeusercommission($group_id,$commission,$company_id)
	{
	
			
			$rsltusers = $this->db->query("select user_id from tblusers where scheme_id = ?",array($group_id));
			foreach($rsltusers->result() as $user)
			{
				$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
				if($check_rslt->num_rows()  == 1)
				{
				
					$rslt = $this->db->query("update tbluser_commission set commission = ? where Id = ?",array($commission,$check_rslt->row(0)->Id));
				}
				else
				{
					$this->db->query("delete from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
					$add_date = $this->common->getDate();
					$str_qry = "insert into tbluser_commission(user_id,company_id,commission,add_date) values( ? , ?, ? , ?)";
					$rslt_in = $this->db->query($str_qry,array($user->user_id,$company_id,$commission,$add_date));
				}	
			}	
		}
	
	
}