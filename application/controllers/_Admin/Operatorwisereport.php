<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorwisereport extends CI_Controller {

	public function index() 
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		else if($this->input->post("btnSearch"))
		{
			$api_name = "ALL";
			$from = $this->input->post("txtFromDate");
			$to = $this->input->post("txtToDate");
			$ddlapi = intval($this->input->post("ddlapi"));
			$api_info = $this->db->query("select Id,api_name from api_configuration where Id = ?",array($ddlapi));
			if($api_info->num_rows() == 1)
			{
				$api_name = $api_info->row(0)->api_name;
			}

			$str_query = "
			select 
			count(recharge_id) as totalcount, 
			Sum(amount) as Total,
			Sum(commission_amount) as Commission,
			Sum(MdComm) as MdComm,
			Sum(DComm) as DComm,
			Sum(AdminComm) as AdminComm,
			b.company_name 
			from tblrecharge a 
			left join tblcompany b on a.company_id = b.company_id
			where 
			Date(a.add_date) >=? and 
			Date(a.add_date) <=? and 
			a.recharge_status = 'Success' and 
			if(? > 0,a.ExecuteBy = ?,true) 
			group by a.company_id";
			$rslt = $this->db->query($str_query,array($from,$to,$ddlapi,$api_name));



			$this->view_data["result_recharge"] = $rslt;
			$this->view_data["from"] = $from;
			$this->view_data["to"] = $to;
			$this->view_data["ddlapi"] = $ddlapi;
			$this->load->view("_Admin/operator_wise_report_view",$this->view_data);

		}
		else
		{
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["ddlapi"] = "";
			$this->view_data["result_recharge"] = false;
			$this->load->view("_Admin/operator_wise_report_view",$this->view_data);
		}
	}	

	public function dataexport1()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo false; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["ddlapi"]))
		{
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$ddlapi = trim($_GET["ddlapi"]);


			$result_all = $this->get_recharge_all($from,$to,$ddlapi);
			
			echo '<table border="1" class="table"><tr> <th >API</th> <th >Date</th><th >Operator_name</th><th >Success Count</th><th >Success Recharge</th>  <th >Commission Given</th></tr>';

			if($result_all->num_rows() > 0)
			{
				$i = 0;
				$totalsuccesscount= 0; $i = 0;$TotalRecharge=0;$TotalCommission=0; 
				foreach($result_all->result() as $result) 	
				{
					echo '<tr>
					<td>.'.$ddlapi.'</td>
					<td>.'.$from.'   To   '.$to.'</td>
					<td >'.$result->company_name.'</td>
					<td >'.$result->totalcount.'</td>
					<td >'.$result->Total.'</td>
					<td >'.$result->Commission.'</td>
					</tr>';
					$TotalCommission += $result->Commission;
					$TotalRecharge += $result->Total;
					$totalsuccesscount += $result->totalcount;
					$i++;
				} 	
			} 	
			echo ' <tr>
			<td></td>
			<td></td>
			<td></td>
			<td><b>Total : &nbsp;&nbsp;&nbsp; '.$totalsuccesscount.'</b></td>
			<td>'.$TotalRecharge.'</td>
			<td>'.$TotalCommission.'</td>
			</tr>
			</table>';
		}
		else
		{
			echo "parameter missing";exit;
		}
	}
	private function get_recharge_all($from,$to,$api)
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo false; exit;
		}
		if($api == "")
		{	
			$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(commission_amount) as Commission,Sum(MdComm) as MdComm,Sum(DComm) as DComm,Sum(AdminComm) as AdminComm,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where Date(add_date) >=? and Date(add_date) <=? and tblrecharge.recharge_status = 'Success' group by company_id";
			$rslt = $this->db->query($str_query,array($from,$to,$api));

			return $rslt;
		}
		else
		{
			$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(commission_amount) as Commission,Sum(MdComm) as MdComm,Sum(DComm) as DComm,Sum(AdminComm) as AdminComm,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where Date(add_date) >=? and Date(add_date) <=? and tblrecharge.recharge_status = 'Success' and ExecuteBy = ? group by company_id";
			$rslt = $this->db->query($str_query,array($from,$to,$api));
			
			return $rslt;
		}	
	}
	public function dataexport()
	{

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$ddlapi = intval($_GET["ddlapi"]);
			$api_name = "ALL";
			$api_info = $this->db->query("select Id,api_name from api_configuration where Id = ?",array($ddlapi));
			if($api_info->num_rows() == 1)
			{
				$api_name = $api_info->row(0)->api_name;
			}
			$data = array();

			if($db == "ARCHIVE")
			{
				$str_query = "

				select 
			count(recharge_id) as totalcount, 
			Sum(amount) as Total,
			Sum(commission_amount) as Commission,
			Sum(MdComm) as MdComm,
			Sum(DComm) as DComm,
			Sum(AdminComm) as AdminComm,
			b.company_name 
			from tblrecharge a 
			left join tblcompany b on a.company_id = b.company_id
			where 
			Date(a.add_date) >=? and 
			Date(a.add_date) <=? and 
			a.recharge_status = 'Success' and 
			if(? > 0,a.ExecuteBy = ?,true) 
			group by a.company_id";
				$rslt = $this->db->query($str_query,array($from,$to,$ddlapi,$api_name));
			}
			else
			{
				$str_query = "select 
			count(recharge_id) as totalcount, 
			Sum(amount) as Total,
			Sum(commission_amount) as Commission,
			Sum(MdComm) as MdComm,
			Sum(DComm) as DComm,
			Sum(AdminComm) as AdminComm,
			b.company_name 
			from tblrecharge a 
			left join tblcompany b on a.company_id = b.company_id
			where 
			Date(a.add_date) >=? and 
			Date(a.add_date) <=? and 
			a.recharge_status = 'Success' and 
			if(? > 0,a.ExecuteBy = ?,true) 
			group by a.company_id";

				$rslt = $this->db->query($str_query,array($from,$to,$ddlapi,$api_name));
			}
			$i = 0;

			foreach($rslt->result() as $rw)
			{
				$AdmiRecive = ($rw->AdminComm)-($rw->MdComm  + $rw->DComm + $rw->Commission);
				$temparray = array(			
					"Sr" =>  $i,
					"FROM DATE" => $from,
					"TO DATE" => $to, 	
					"Api Name" => $api_name, 	
					"company_name" => $rw->company_name, 
					"Success Count" => $rw->totalcount, 
					"Success Recharge" => $rw->Total,
					"Admin Comm" =>$rw->Commission, 
					"MD Comm" =>$rw->MdComm, 
					"Dist Comm" =>$rw->DComm, 
					"Agent+Api Comm" =>$rw->Commission,  
					"Admin Receive" => $AdmiRecive							
				);
				
				array_push( $data,$temparray);
				$i++;

			}
			function filterData(&$str)
			{
				$str = preg_replace("/\t/", "\\t", $str);
				$str = preg_replace("/\r?\n/", "\\n", $str);
				if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
			}

// file name for download
			$fileName = "Operatorwise Report From ".$from." To  ".$to.".xls";

// headers for download
			header("Content-Disposition: attachment; filename=\"$fileName\"");
			header("Content-Type: application/vnd.ms-excel");

			$flag = false;
			foreach($data as $row) {
				if(!$flag) {
        // display column names as first row
					echo implode("\t", array_keys($row)) . "\n";
					$flag = true;
				}
    // filter data
				array_walk($row, 'filterData');
				echo implode("\t", array_values($row)) . "\n";
			}

			exit;				
		}
		else
		{
			echo "parameter missing";exit;
		}
	}	
}