<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_home extends CI_Controller {
 	public function getBalance()
	{		
		$this->load->model('Recharge_home_model');
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("SdId"));	
		echo "<span id='spanbal' style='text-align:center;vertical-align:central;padding-top:10px;padding-left:0px;float:left;position:absolute;color:#F00;font-size:16px;'>  Bal : ".$balance."</span>";
	}
	public function get_ajax_transaction()
	{
	echo '<table class="table" border="1">
    <tr>  
    <th>Sr No</th>
    <th>Rec.Id</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     
     <th >Company Name</th>
	 <th >Mobile No</th>    
	 <th >Amt</th>    
   	
	 <th >Rec.By</th>
   	 <th>Status</th> 
               
    </tr>';
		$rsltrecharge = $this->db->query("select recharge_id,mobile_no,amount,recharge_status,recharge_by,company_name,operator_id,tblrecharge.add_date from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.user_id = ?  order by recharge_id desc limit 7",array($this->session->userdata("SdId")));
	 $totalRecharge = 0;	$i = count($rsltrecharge->result());foreach($rsltrecharge->result() as $result) 	{ 
			echo '<tr>';
           echo  '<td >'.$i.'</td>
 <td >'.$result->recharge_id.'</td>
 
  
  
  
  <td>'.$result->operator_id.'</td>
  
  
  
 <td>'.$result->add_date.'</td>
 

 <td>'.$result->company_name.'</td>
 <td>'.$result->mobile_no.'</td>
 <td>'.$result->amount.'</td>
 
 <td>'.$result->recharge_by.'</td>
 <td>';
	if($result->recharge_status == 'Pending')
	{
		echo "<span class='orange'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Pending</a></span>";
	}
	 if($result->recharge_status == 'Success')
	 {
		$totalRecharge += $result->amount;echo "<span class='green'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Success</a></span>";
	 }
 if($result->recharge_status == 'Failure')
 {
 	echo "<span class='red'>
 <a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Failure</a></span>";
 }
 if($result->recharge_status == 'succes')
 {
 	echo $result->recharge_status;
 }
 
 echo '</td>
  
 </tr>';
		
		$i--;
		} 
        
		echo '</table>';

	}	
	public function getMobileCompany()
	{
		$str_query = "select * from tblcompany where service_id='1' and company_id != 34 and company_id != 39 order by company_name";
		$result_mobile = $this->db->query($str_query);		
		echo '<option>--Select--</option>';
		for($i=0; $i<$result_mobile->num_rows(); $i++)
		{
			echo "<option serviceid='".$result_mobile->row($i)->service_id."'   value='".$result_mobile->row($i)->company_id."'>".    $result_mobile->row($i)->company_name."</option>";
	}
	}
	public function getDTHCompany()
	{		
		$str_query = "select * from tblcompany where service_id='2' order by company_name";
		$result_dth = $this->db->query($str_query);		
		echo '<option>--Select--</option>';
		for($i=0; $i<$result_dth->num_rows(); $i++)
		{
			echo "<option serviceid='".$result_dth->row($i)->service_id."' value='".$result_dth->row($i)->company_id."'>".$result_dth->row($i)->company_name."</option>";
		}
	}

	
	public function index()
	{	
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('DistUserType');			
			if(trim($user) == 'Distributor')
			{
				if($this->input->post("hidSubmitRecharge") == "Success")				
				{
					$this->load->model("Tblcompany_methods");
					$this->load->model("Do_recharge_model");	
					$this->load->model("Recharge_home_model");
					$MobileNo =	$this->input->post("txtMobileNo",true);
					$Amount = $this->input->post("txtAmount",true);
					$company_id=$this->input->post("ddlOperator",true);	
					$company_info = $this->Tblcompany_methods->getCompany_info($company_id);
					if($company_info == false)
					{
						echo 'Configuration Missing, Contact Service Provider.';exit;
					}
					$user_id= $this->session->userdata('MdId');
					$scheme_id = $this->session->userdata("MdSchemeId");
					$recharge_type = $this->Common_methods->getRechargeType($company_info->row(0)->service_id);
					$rechargeBy = "WEB";
					$current_bal = $this->Common_methods->getAgentBalance($user_id);
					if($Amount < 10)
					{	
						echo 'Minimum amount 10 INR For Recharge.';exit;		
					}
				
					$user_info = $this->Userinfo_methods->getUserInfo($user_id);	
					if($current_bal >= $Amount)
					{																
					
						$response = $this->Do_recharge_model->ProcessRecharge($user_info,"*",$company_id,$Amount,$MobileNo,$recharge_type,$company_info->row(0)->service_id,$rechargeBy);
						echo $response;exit;
					
					}
					else
					{
						echo 'Insufficient Balance';exit;
					}
				
				}
				else
				{		$lastrec = $this->db->query("select recharge_id,company_name,mobile_no,amount,recharge_status,recharge_by,ExecuteBy,operator_id,tblrecharge.add_date from tblrecharge,tblcompany where tblrecharge.company_id = tblcompany.company_id and tblrecharge.user_id = ? order by recharge_id desc limit 1",array($this->session->userdata("SdId")));			
						$this->view_data['message'] ="";
						$this->view_data['lastrec'] =$lastrec;
						$this->load->view('SuperDealer/recharge_home_view',$this->view_data);
				}
			} 
		}
	}
}	