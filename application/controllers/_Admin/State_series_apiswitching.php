<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_series_apiswitching extends CI_Controller {
	
	
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
		
		$rslt = $this->db->query("select company_id,company_name from tblcompany where service_id <= 3");
		$this->view_data['result_company'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->view_data['api'] ="ALL";
		$this->view_data['operator'] ="ALL";
		$this->load->view('_Admin/state_series_apiswitching_view',$this->view_data);	
	}
	
	
	public function getresult()
	{
		$allapi_object = $this->db->query("select * from tblapi order by api_name");
		$company_id = $_GET["groupid"];
		$company_info = $this->db->query("select company_name from tblcompany where company_id = ?",array($company_id));
	
		$state_info = $this->db->query("select a.*,b.api_id from tblstate a left join statewiseseries b on a.state_id = b.state_id and b.company_id = ? order by b.api_id desc",array($company_id));
		$str = '<input type="hidden" id="company_id" name="company_id" value="'.$company_id.'">
		<table class="table table-striped table-bordered bootstrap-datatable" style="color:#000000">
				<tr>  
				<th>Sr No.</th>
				<th>Operator</th>
				<th>State Name</th>
				<th>Api</th>
				<th>Series</th>
				<th>Amounts</th>
				<th>Code</th>
				<th>Change Api</th>
				<th></th>
				</tr>';
    	$i = 0;
		
		foreach($state_info->result() as $state_object) 	
		{
				$selected_api_id = 0;
				$selected_api_name = "";
				if($i % 2 == 0)
				{
					$str .='<tr class="row1">';
				}
				else
				{
					$str .='<tr class="row2">';
				}
				
				$str.='<td >'.$i.'</td>
					   <td>'.$company_info->row(0)->company_name.'</td>
					   <td>'.$state_object->state_name.'</td>
				';
				
		
					$rsltstatewiseapiswitfhing  = $this->db->query("select 
					a.company_id,a.api_id,a.state_id,a.series,a.code,a.amounts,
					b.api_name
					 from statewiseseries a
					left join tblapi b on a.api_id = b.api_id
					 where a.company_id = ? and a.state_id = ?",array($company_id,$state_object->state_id));
					if($rsltstatewiseapiswitfhing->num_rows() == 1)
					{
						$selected_api_id = $rsltstatewiseapiswitfhing->row(0)->api_id;
						$selected_api_name = $rsltstatewiseapiswitfhing->row(0)->api_name;
						$str.='<td>'.$rsltstatewiseapiswitfhing->row(0)->api_name.'</td>
						       <td><textarea style="width:200px;height:150px;" row=20 col=40 id="txtarea'.$company_id.'-'.$state_object->state_id.'">'.$rsltstatewiseapiswitfhing->row(0)->series.'</textarea></td>
							   <td><textarea style="width:200px;height:150px;" row=20 col=40 id="txtamounts'.$company_id.'-'.$state_object->state_id.'">'.$rsltstatewiseapiswitfhing->row(0)->amounts.'</textarea></td>
						
						';
						$str.='<td><input type="text" style="width:40px;" id="txtcode'.$company_id.'-'.$state_object->state_id.'" value="'.$rsltstatewiseapiswitfhing->row(0)->code.'"></td>
						
						';
					}
					else
					{
						$str.='<td>Default</td>
						 <td><textarea style="width:200px;height:150px;" row="20" col="40" id="txtarea'.$company_id.'-'.$state_object->state_id.'"></textarea></td>
						 <td><textarea style="width:200px;height:150px;" row="20" col="40" id="txtamounts'.$company_id.'-'.$state_object->state_id.'"></textarea></td>
						 ';
						 $str.='<td><input type="text" style="width:40px;" id="txtcode'.$company_id.'-'.$state_object->state_id.'"></td>';
					}
					$str.='<td>
						<select id="ddlapi'.$company_id.'-'.$state_object->state_id.'" class="form-control" style="width:80px;">
						<option value="'.$selected_api_id.'">'.$selected_api_name.'</option>
						<option value="0">Default</option>';
						foreach($allapi_object->result() as $obj_api)
						{
							$str.='<option value="'.$obj_api->api_id.'">'.$obj_api->api_name.'</option>';
						}
						$str.='</select>
					</td>';
					$str.='
					<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changeseriesandapi('.$state_object->state_id.',\''.$company_id.'\')"/></td>
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
	public function updateseriesanaapi()
	{
		$company_id = $_GET["company_id"];
		$state_id = $_GET["state_id"];
		$api_id = $_GET["api_id"];
		$series_string = $_GET["series_string"];
		$amount_string = $_GET["amount_string"];
		$code = $_GET["code"];
		
		$rsltstateseriesinfo = $this->db->query("select * from statewiseseries where company_id = ? and state_id = ?",array($company_id,$state_id));
		if($rsltstateseriesinfo->num_rows() > 0)
		{
			
			$insertgroupapi = $this->db->query("update statewiseseries set series=?,amounts = ?,api_id = ?,code = ? where company_id = ? and state_id = ?",array($series_string,$amount_string,$api_id,$code,$company_id,$state_id));
			echo true;
		}
		else
		{
			$this->db->query("delete from statewiseseries  where company_id = ? and state_id = ?",array($company_id,$state_id));
			$this->db->query("insert into statewiseseries(company_id,state_id,api_id,series,amounts,code,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$state_id,$api_id,$series_string,$amount_string,$code,$this->common->getDate(),$this->common->getRealIpAddr()));
			echo true;
		}
		
	}
	
}