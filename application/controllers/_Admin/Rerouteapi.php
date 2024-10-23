<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rerouteapi extends CI_Controller {
	
	
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
	
	public function getresult()
	{
		$api_id = $_GET["api_id"];
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$api_info = $this->db->query("select * from tblapi where api_id = ?",array($api_id));
		$str = '<div>Re-Route Api For API '.$api_info->row(0)->api_name.'</div>
		<input type="hidden" id="uid" name="uid" value="'.$api_id.'">
		<table class="table table-responsive table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
				<tr>  
				<th>Sr No.</th>
				<th>Operator</th>
				<th>Re-Route To</th>
				<th>Select Api</th>
				<th></th>
				</tr>';
    	$i = 0;
		$rslallapi = $this->db->query("select api_id,api_name from tblapi order by api_name");
		$result_company = $this->db->query("select company_id,company_name from tblcompany order by service_id,company_name");
		foreach($result_company->result() as $row) 	
		{
		
				$rslt  = $this->db->query("select a.api_id,a.second_api,b.api_name as secondapi_name from tblrerouteapi a left join tblapi b on a.second_api = b.api_id where a.api_id = ? and a.company_id = ?",array($api_id,$row->company_id));
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
					if($rslt->num_rows() == 1)					
					{
						$str.='<td >'.$rslt->row(0)->secondapi_name.'</td>';
					}
					else
					{
						$str.='<td></td>';
					}
					$str.='
					<td>
					<select id="ddlapi'.$row->company_id.'" name="ddlapi" class="form-control-sm" >
						<option value="0"></option>';
						
						foreach($rslallapi->result() as $rw)
						{
						$str.='<option value="'.$rw->api_id.'">'.$rw->api_name.'</option>';
						}
					$str.='</select>
					</td>';
					$str.='
					<td ><input class="btn btn-primary btn-sm" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changeapi('.$row->company_id.',\''.$api_id.'\')"/></td>
					</tr>
					';
					$i++;
				
		} 
       $str.='</table>';
				echo $str;
	}
	public function index() 
	{
	
		$rslt = $this->db->query("select company_id,company_name from tblcompany");
		$this->view_data['result_company'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/rerouteapi_view',$this->view_data);	
	}
	
	
	public function changeapi()
	{

		$company_id = $_GET["company_id"];
		$api_id = $_GET["api_id"];
		$second_api = $_GET["second_api"];
		$rslt = $this->db->query("select * from tblrerouteapi where api_id = ? and company_id = ?",array($api_id,$company_id));
		if($rslt->num_rows() > 0)
		{
			$insertgroupapi = $this->db->query("update tblrerouteapi set second_api=? where api_id = ? and company_id = ?",array($second_api,$api_id,$company_id));
			echo true;
		}
		else
		{
		
			$this->db->query("insert into tblrerouteapi(api_id,company_id,second_api,add_date,ipaddress) values(?,?,?,?,?)",array($api_id,$company_id,$second_api,$this->common->getDate(),$this->common->getRealIpAddr()));
			echo true;
		}
		
	}
	
}