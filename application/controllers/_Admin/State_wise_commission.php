<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_wise_commission extends CI_Controller {
	
	
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
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/state_wise_commission_view',$this->view_data);		
	}
	
	
	public function getresult()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
	    $str_circle_id = "";
		$company_id = intval($_GET["groupid"]);
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$company_info = $this->db->query("select company_name from tblcompany where company_id = ?",array($company_id));
		$str = '<div>Commission Structure of '.$company_info->row(0)->company_name.'</div><input type="hidden" id="uid" name="uid" value="'.$company_id.'">
		<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
				<tr>  
    				<th>Sr No.</th>
    				<th>Circle</th>
    				<th>Client Commission %</th>
    				<th>Commission Type</th>
    				<th></th>
				</tr>';
    	$i = 0;
		$result_circle = $this->db->query("SELECT a.circleMasterId,a.circleName,IFNULL(b.commission,0) as commission,b.commission_type FROM freecharge_circlemaster a left join statewise_commission b on a.circleMasterId = b.circle_id and b.company_id = ? order by a.circleName",array($company_id));
		foreach($result_circle->result() as $row) 	
		{
				$str_circle_id.=$row->circleMasterId.",";
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
					<td >'.$row->circleName.'</td>';
					
					
					
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->circleMasterId.'" name="txtComm'.$row->circleMasterId.'" value="'.$row->commission.'"/>';
							$str.= '</td>';
							
							$str.= '<td>';
							if($row->commission_type == "AMOUNT")
							{
								$str.= '<select id="ddlcommission_type'.$row->circleMasterId.'" name="ddlcommission_type'.$row->circleMasterId.'" class="form-control" >
								<option value="AMOUNT">Amount</option>
								<option value="PER">Percentage</option>
								';
								$str.= '</select>';
							}
							else
							{
								$str.= '<select id="ddlcommission_type'.$row->circleMasterId.'" name="ddlcommission_type'.$row->circleMasterId.'" class="form-control" >
								<option value="PER">Percentage</option>
								<option value="AMOUNT">Amount</option>
								';
								$str.= '</select>';
							}
							$str.= '</td>';
					
					$str.='
					<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->circleMasterId.',\''.$company_id.'\')"/></td>
					</tr>
					';
					$i++;
				
		} 
		
		
		$str.='<tr>
    <td></td>
 
    <td colspan=3 align="center">
        <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeall()">
        <input type="hidden" id="hidcircle_ids" value="'.$str_circle_id.'">
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
		$comtype = $_GET["comtype"];
		$company_id = intval($_GET["company_id"]);
		$circle_id = intval($_GET["circle_id"]);
		
		

		
		
		$companyinfo = $this->db->query("select * from tblcompany where company_id = ?",array($company_id));
		if($companyinfo->num_rows() == 1)
		{
		
			$rslt = $this->db->query("select * from statewise_commission where circle_id = ? and company_id = ?",array($circle_id,$company_id));
			if($rslt->num_rows() > 0)
			{

				$insertgroupapi = $this->db->query("update statewise_commission set commission=?,commission_type=? where circle_id = ? and company_id = ?",array($comm,$comtype,$circle_id,$company_id));

				echo "OK";exit;
			}
			else
			{
				$this->db->query("delete from statewise_commission  where circle_id = ? and company_id = ?",array($circle_id,$company_id));
				$this->db->query("insert into statewise_commission(company_id,commission,commission_type,circle_id,add_date,ipaddress) values(?,?,?,?,?,?)",array($company_id,$comm,$comtype,$circle_id,$this->common->getDate(),$this->common->getRealIpAddr()));
				echo "OK";exit;
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
			
			$insertgroupapi = $this->db->query("update tblgroupapi set commission=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));
			
			echo true;
		}
		else
		{
			$this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
			$this->db->query("insert into tblgroupapi(company_id,commission,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
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