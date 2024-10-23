<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator_code extends CI_Controller {
	
	
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
		$this->load->view('_Admin/operator_code_view',$this->view_data);		
	}
	
	
	public function getresult()
	{
		$api_id = $_GET["api_id"];
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$api_info = $this->db->query("select * from tblapi where api_id = ?",array($api_id));
		$str = '<div>Operator Codes FOR API '.$api_info->row(0)->api_name.'</div>
		<input type="hidden" id="uid" name="uid" value="'.$api_id.'">
		<table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="width:700px;">
				<tr>  
				<th>Sr No.</th>
				<th>Network</th>
				<th>Operator Code</th>
				<th></th>
				</tr>';
    	$i = 0;
		$result_company = $this->db->query("select * from tblcompany");
		foreach($result_company->result() as $row) 	
		{
		
					$rslt  = $this->db->query("select * from tbloperatorcodes where api_id = ? and company_id = ?",array($api_id,$row->company_id));
					
					$str .='<tr class="row1">';
				
					$str.='
			
					<td >'.$i.'</td>
					<td >'.$row->company_name.'</td>';
					
					
					
					
					if($rslt->num_rows() > 0)
					{
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtCode'.$row->company_id.'" name="txtCode'.$row->company_id.'" value="'.$rslt->row(0)->code.'"/>';
							$str.= '</td>';
							
					}
					else
					{
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtCode'.$row->company_id.'" name="txtCode'.$row->company_id.'" value=""/>';
						$str.= '</td>';
					}
					
					$str.='</td>';
					
					
					
					
					
					
					$str.='<td >
					<input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$api_id.'\')"/></td>
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
	public function changecode()
	{
		$code = $_GET["code"];
		$api_id = $_GET["api_id"];
		$company_id = $_GET["company_id"];
		$rslt = $this->db->query("select * from tbloperatorcodes where api_id = $api_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			
			 $this->db->query("update tbloperatorcodes set code=? where api_id = ? and company_id = ?",array($code,$api_id,$company_id));
			echo true;
		}
		else
		{
			$this->db->query("delete from tbloperatorcodes  where api_id = $api_id and company_id = $company_id");
			$this->db->query("insert into tbloperatorcodes(company_id,api_id,code) values(?,?,?)",array($company_id,$api_id,$code));
			//$this->changeusercommission($group_id,$comm,$company_id);
			echo true;
		}
		
	}

	
	
}