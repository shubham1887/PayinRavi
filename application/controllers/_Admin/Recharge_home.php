<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_home extends CI_Controller 
{
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
 	public function getBalance()
	{		
		$this->load->model('Recharge_home_model');
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("AgentId"));	
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
		$rsltrecharge = $this->db->query("
		select 
			a.user_id, 	
			a.recharge_id,
			a.company_id,
			a.mobile_no,
			a.amount,
			a.recharge_by,
			b.company_name,
			a.commission_amount,
			a.commission_per,
			a.add_date,
			a.edit_date,
			a.update_time,
			a.operator_id,
			a.recharge_status,
			c.businessname,
			c.username 
			from tblrecharge a
			left join tblcompany b on a.company_id = b.company_id
			left join tblusers c on a.user_id = c.user_id
			where
			a.user_id = ?  order by a.recharge_id desc limit 7",array($this->session->userdata("AgentId")));
		
	 	$totalRecharge = 0;	
		$i = 1;
		foreach($rsltrecharge->result() as $result) 	
		{ 
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
				echo "<span class='btn btn-warning'>Pending</span>";
			}
			if($result->recharge_status == 'Success')
			{
				$totalRecharge += $result->amount;echo "<span class='btn btn-success'>Success</span>";
			}
			if($result->recharge_status == 'Failure')
			{
				if($result->edit_date == 3)
				{
					echo "<span class='btn btn-primary'>Reverse</span>";
				}
				else
				{
					echo "<span class='btn btn-danger'>Failure</span>";	
				}
				
			}
 
 
 echo '</td>
  
 </tr>';
		
		$i--;
		} 
        
		echo '</table>';

	}	
	
	
	public function index()
	{	
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('AgentUserType');			
			if(trim($user) == 'Agent')
			{
				
				if($this->input->post("hidSubmitRecharge") == "Success")				
				{
				//print_r($this->input->post());exit;
				
					if($this->session->userdata('ReadOnly') == true)
					{
						echo "Read Only Mode Enabled";exit;
					}
					$this->load->model("Tblcompany_methods");
					$this->load->model("Do_recharge_model");	
					$this->load->model("Recharge_home_model");
					$MobileNo =	$this->input->post("txtMobileNo",true);
					$Amount = $this->input->post("txtAmount",true);
					$custname = $this->input->post("txtCustName",true);
					$company_id=$this->input->post("ddlOperator",true);	
					$company_info = $this->Tblcompany_methods->getCompany_info($company_id);
					if($company_info == false)
					{
						echo 'Configuration Missing, Contact Service Provider.';exit;
					}
					$user_id= $this->session->userdata('AgentId');
					$scheme_id = $this->session->userdata("AgentSchemeId");
					$recharge_type = $this->Common_methods->getRechargeType($company_info->row(0)->service_id);
					$rechargeBy = "WEB";
					$user_info = $this->db->query("select * from tblusers where user_id = ? order by user_id",array($user_id));	
					if($company_info->row(0)->service_id == 23 or $company_info->row(0)->service_id == 24 or $company_info->row(0)->service_id == 14)
					{
						if($Amount < 10)
						{	
							echo 'Minimum amount 10 INR For Recharge.';exit;		
						}
						$current_bal = $this->Common_methods->getAgentBalance($user_id);
						
						if($current_bal >= $Amount)
						{																

							$response = $this->Do_recharge_model->ProcessRecharge($user_info,"*",$company_id,$Amount,$MobileNo,$recharge_type,$company_info->row(0)->service_id,$rechargeBy,$custname);
							echo $response;exit;

						}
						else
						{
							echo 'Insufficient Balance';exit;
						}
					}
					else
					{
						
						$CustomerMobile = $this->input->post("txtCustMobile");
						$payment_mode = "CASH";
						$payment_channel = "AGT";
						$user_info = $this->Userinfo_methods->getUserInfo($user_id);	
						$remark = "Bill Payment";
						$spkey = $company_info->row(0)->provider; 
						$company_id = $company_info->row(0)->company_id; 
						
						$BillAction = $this->input->post("hidGasAction");
						if($BillAction == "GETBILL")
						{
							$this->load->model("Instapay");
							$response = $this->Instapay->recharge_transaction_validate($user_info,$spkey,0,0,$MobileNo,$CustomerMobile);
							echo $response;exit;
						}
						else
						{
							if($Amount < 10)
							{	
								echo 'Minimum amount 10 INR For Recharge.';exit;		
							}
							$this->load->model("Instapay");
							$response = $this->Instapay->recharge_transaction($user_info,$spkey,$company_id,$Amount,$MobileNo,$CustomerMobile,$remark,$payment_mode,$payment_channel,$custname);
							echo $response;exit;
						}
						
						
					}
					
				
				}
				else
				{		$lastrec = $this->db->query("select 	recharge_id,company_name,mobile_no,amount,recharge_status,recharge_by,ExecuteBy,operator_id,tblrecharge.add_date from tblrecharge,tblcompany where tblrecharge.company_id = tblcompany.company_id and tblrecharge.user_id = ? order by recharge_id desc limit 1",array($this->session->userdata("AgentId")));			
						$this->view_data['message'] ="";
						$this->view_data['lastrec'] =$lastrec;
						$this->load->view('Retailer/recharge_home_view',$this->view_data);
				}
			} 
		}
	}
	public function getcusname()
	{
		$mob = $_GET["mob"];
		$rslt = $this->db->query("select custname from tblrecharge where mobile_no = ? and user_id = ? order by recharge_id desc limit 1",array($mob,$this->session->userdata('AgentId')));
		if($rslt->num_rows() > 0)
		{
			echo $rslt->row(0)->custname;
		}
	}
	public function getOperatorbyNumber()
	{
		$mob = $_GET["mob"];
		$this->load->model("Planinfo");
		$resp = $this->Planinfo->getPlaninfo($mob);
		echo $resp;exit;
	}
	public function getOffer()
	{
	
		$Number = $_GET["mobile"];
		$company_id = $_GET["operator"];
		
		$this->load->model("Planinfo");
		//echo $Number."  ".$company_id;exit;
		echo $this->Planinfo->getROffer($company_id,$Number);
	}
}	