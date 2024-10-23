<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorapiwisereport extends CI_Controller {
	
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
			$from = $this->input->post("txtFromDate");
			$to = $this->input->post("txtToDate");
			
				$str_query = "SELECT a.recharge_id,a.ExecuteBy,b.company_name,IFNULL(Sum(a.amount),0) as totalrecharge,count(a.recharge_id)  as totalcount FROM `tblrecharge` a 
left join tblcompany b on a.company_id = b.company_id
where Date(a.add_date) >= ? and Date(a.add_date) <= ?  group by a.ExecuteBy,a.company_id";
		$rslt = $this->db->query($str_query,array($from,$to));
		
			$data = array();
			$apis = array();
			$company = array();
			foreach($rslt->result() as $rwop)
			{
				$data[$rwop->ExecuteBy][$rwop->company_name]["total"] = $rwop->totalrecharge;
				$data[$rwop->ExecuteBy][$rwop->company_name]["count"] = $rwop->totalcount;
				array_push($apis,$rwop->ExecuteBy);
				array_push($company,$rwop->company_name);
			}
			
			
		$this->view_data["apis"] = array_unique($apis);
		$this->view_data["companys"] = array_unique($company);
		$this->view_data["from"] = $from;
		$this->view_data["result_recharge"] = $data;
		$this->view_data["from"] = $from;
		$this->view_data["to"] = $to;
		$this->view_data["ddlapi"] = $ddlapi;
		$this->load->view("_Admin/operatorapi_wise_report_view",$this->view_data);
		
		}
		else
		{
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["apis"] = false;
			$this->view_data["companys"] = false;
			$this->view_data["ddlapi"] = "";
			$this->view_data["result_recharge"] = false;
			$this->load->view("_Admin/operatorapi_wise_report_view",$this->view_data);
		}
	}	
	
	public function dataexport()
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
		$rslt = $this->db->query($str_query,array($from,$to));
						
				return $rslt;
			}
			else
			{
			$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(commission_amount) as Commission,Sum(MdComm) as MdComm,Sum(DComm) as DComm,Sum(AdminComm) as AdminComm,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where Date(add_date) >=? and Date(add_date) <=? and tblrecharge.recharge_status = 'Success' and ExecuteBy = ? group by company_id";
		$rslt = $this->db->query($str_query,array($from,$to,$api));
				
		return $rslt;
			}
			
			
				
			
			
			
		}
}