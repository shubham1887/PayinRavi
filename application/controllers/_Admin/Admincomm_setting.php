<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admincomm_setting extends CI_Controller {
	
	
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
		$this->load->view('_Admin/admincomm_setting_view',$this->view_data);
	
	}
	
	
	public function getresult()
	{
		$api_id = $_GET["groupid"];
		$api_info = $this->db->query("select * from tblapi where api_id = ?",array($api_id));
		$str = '<div>Commission Structure of '.$api_info->row(0)->api_name.'</div><input type="hidden" id="uid" name="uid" value="'.$api_id.'"><table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
				<tr>  
				<th>Sr No.</th>
				<th>Network</th>
				<th>Commission (%)</th>
				<th></th>
				<th></th>
				</tr>';
    	$i = 0;
		$result_company = $this->db->query("select * from tblcompany");
		foreach($result_company->result() as $row) 	
		{
		
					$rsltadmincomm  = $this->db->query("select * from tbladmincommission where api_id = ? and company_id = ?",array($api_id,$row->company_id));
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
					<td >'.$row->company_name.'</td>
					
					
					<td >';
					
					if($rsltadmincomm->num_rows() > 0)
					{
							$str.= '<input style="width:150px;" class="form-control-sm" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value="'.$rsltadmincomm->row(0)->comm_per.'"/>';
					}
					else
					{
						$str.= '<input style="width:150px;" class="form-control-sm" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
					}
					
					$str.='</td>
					
					<td >';
					
					
				
					
					$str.='</td>
					<td ><input class="btn btn-primary btn-xs" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$api_id.'\')"/></td>
					</tr>
					';
					$i++;
				
		} 
       $str.='</table>';
				echo $str;
	}
	public function index() 
	{
			$this->pageview();		
	}
	public function changecommission()
	{
		$comm = $_GET["com"];
		$api_id = $_GET["api_id"];
		$company_id = $_GET["company_id"];
		$rslt = $this->db->query("select * from tbladmincommission where api_id = $api_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			$str_qry ="update tbladmincommission set comm_per=$comm where api_id = $api_id and company_id = $company_id";
			$insertgroupapi = $this->db->query($str_qry);
			echo true;
		}
		else
		{
			$this->db->query("delete from tbladmincommission  where api_id = $api_id and company_id = $company_id");
			$this->db->query("insert into tbladmincommission(company_id,comm_per,api_id,add_date) values(?,?,?,?)",array($company_id,$comm,$api_id,$this->common->getDate()));
			echo true;
		}
		
	}
	
	
	
	
}