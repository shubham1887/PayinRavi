<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class CommissionUserWise extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
	public function index()
	{						
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		}  
		else 
		{ 



		$data['message']='';	

			if(isset($_POST["txtscheme"]) and isset($_POST["txtschemDesc"]) and isset($_POST["txtamount"]) and isset($_POST["addtype"]) and isset($_POST["ddlschemType"]))
			{
		
					$user_id =  $this->session->userdata("MdId");	
					$txtscheme = $this->input->post("txtscheme",TRUE);
					$txtschemDesc = $this->input->post("txtschemDesc",TRUE);	
					$txtamount = $this->input->post("txtamount",TRUE);	
					$addtype = $this->input->post("addtype",TRUE);	
					//$ddlschemType = $this->input->post("ddlschemType",TRUE);	
					$ddlschemType = "Agent";


					$check_group = $this->db->query("select Id from tblgroup where user_id = ? and group_name = ?",array($user_id,$txtscheme));
					if($check_group->num_rows() == 1)
					{
						$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
						$this->session->set_flashdata('MESSAGEBOX', "Group Already Exist. Please Try Different Name");
						redirect("MasterDealer_new/CreateScheme");
					}
					else
					{
						$insert_rslt = $this->db->query("insert into tblgroup(group_name,description,groupfor,min_balance,add_date,ipaddress,user_id) values(?,?,?,?,?,?,?)",
						array($txtscheme,$txtschemDesc,$ddlschemType,$txtamount,$this->common->getDate(),$this->common->getRealIpAddr(),$user_id));
						if($insert_rslt == true)
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
							$this->session->set_flashdata('MESSAGEBOX', "Group Created Successfully");
							redirect("MasterDealer_new/CreateScheme");
						}
						else
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
							$this->session->set_flashdata('MESSAGEBOX',"Failure. Please Try Again");
							redirect("MasterDealer_new/CreateScheme");
						}
					}
				}
			else if(isset($_GET["trackwind"]))
			{
				$group_id = trim($this->input->get("trackwind"));
				$user_id = $this->session->userdata("MdId");
				$rslt_delete = $this->db->query("delete from tblgroup where user_id = ? and Id = ?",array($user_id,$group_id));
				if($rslt_delete == true)
				{
					$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
					$this->session->set_flashdata('MESSAGEBOX', "Group Deleted Successfully");
					redirect("MasterDealer_new/CreateScheme");
				}
				else
				{
					$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
					$this->session->set_flashdata('MESSAGEBOX',"Failure. Please Try Again");
					redirect("MasterDealer_new/CreateScheme");
				}
			}
			else
			{
				$user_id = $this->session->userdata("MdId");
				$data['result_scheme']=$this->db->query("select Id,group_name,description,add_date,groupfor,min_balance,service,user_id from tblgroup where user_id = ?",array($user_id));
				$data['message']='';
				$this->load->view('MasterDealer_new/CommissionUserWise_view',$data);
			}
		} 			
	}


	public function GetUserTypeWiseScheme()
	{
		header("Content-Type:application/json");


		$data_array = array();
		$group_info = $this->db->query("select Id,group_name from tblgroup where user_id = ? order by group_name",array($this->session->userdata("MdId")));
		foreach($group_info->result() as $rw)
		{
			$temparray = array(
						"Disabled"=>false,
						"Group"=>null,
						"Selected"=>false,
						"Text"=>$rw->group_name,
						"Value"=>$rw->Id,
			);
			array_push($data_array,$temparray);
		}
		echo json_encode($data_array);exit;
	}
	public function GetAllServices()
	{
		header("Content-Type:application/json");


		$data_array = array();
		$service_info = $this->db->query("select service_id,service_name from tblservice order by service_id");
		foreach($service_info->result() as $rw)
		{
			$temparray = array(
						"Disabled"=>false,
						"Group"=>null,
						"Selected"=>false,
						"Text"=>$rw->service_name,
						"Value"=>$rw->service_id,
			);
			array_push($data_array,$temparray);
		}
		echo json_encode($data_array);exit;
	}
	public function GetcommissiondetailsthroughPartial()
	{
		if(isset($_POST["schemetype"]))
		{


			$parent_info = $this->db->query("select scheme_id from tblusers where user_id = ?",array($this->session->userdata("MdId")));
			if($parent_info->num_rows() == 1)
			{
				$parent_scheme_id = $parent_info->row(0)->scheme_id;

				$schemetype = trim($this->input->post("schemetype"));
				$service_id = trim($this->input->post("serviceId"));

				$downline_group_info = $this->db->query("select Id,group_name from tblgroup where Id = ? and user_id = ?",array($schemetype,$this->session->userdata("MdId")));
				if($downline_group_info->num_rows() == 1)
				{
					$str = "<div class='section'>
						<div class='containertable'>
						<table class='tablefreeze table-transaction'>
						<thead>
							<tr>
								<th>Sr.No.<div>Sr.No.</div></th>
								<th>Description<div>Description</div></th>
								<th>Comm. In Per.<div>Comm. In Per.</div></th>
								<th>Comm. In Rs.<div>Comm. In Rs.</div></th>
								<th>Surcharge. In Per.<div>Surcharge. In Per.</div></th>
								<th>Surcharge. In Rs.<div>Surcharge. In Rs.</div></th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>"; 


						$rsltcommission = $this->db->query("
								select
								a.company_id,
								a.company_name,
								a.service_id,
								com.group_id,
								IFNULL(com.commission_per,0) as commission_per,
								IFNULL(com.CommissionAmount,0) as CommissionAmount,
								IFNULL(com.Charge_per,0) as Charge_per,
								IFNULL(com.Charge_amount,0) as Charge_amount,


								IFNULL(mycom.commission_per,0) as mycom_commission_per,
								IFNULL(mycom.CommissionAmount,0) as mycom_CommissionAmount,
								IFNULL(mycom.Charge_per,0) as mycom_Charge_per,
								IFNULL(mycom.Charge_amount,0) as mycom_Charge_amount,
								com.commission_type
								from tblcompany a
								left join tblgroupapi com on a.company_id = com.company_id and com.group_id = ? 
								left join tblgroupapi mycom on a.company_id = mycom.company_id and mycom.group_id = ?
								where 

								if(? >0,a.service_id = ?,true)

							",array($schemetype,$parent_scheme_id,$service_id,$service_id));
								$i=1;
								foreach($rsltcommission->result() as $rw)
								{

								$str .= "<tr>
									<td style='width:3%;'>".$i."</td>
									<td style='white-space:initial;width:20%;'> | ".$rw->company_name."</td>
									<td style='width:18%;'>
										<div class='parentdiv'>
											<span class='spantype'>Parent : </span>
											<input type='text' id='txtParentCommPer".$rw->company_id."' name='txtParentCommPer".$rw->company_id."' readonly='True' class='inputsetting' value='".$rw->mycom_commission_per."' />
											<span style='float:left'>&nbsp;%<label class='setting'>&nbsp;Set</label></span>
										</div>
										<div class='parentdiv'>
											<span class='spantype'>User : </span>
											<input type='text' id='txtUserCommPer".$rw->company_id."' name='txtUserCommPer".$rw->company_id."' class='inputsetting' value='".$rw->commission_per."' />
											<span style='float:left'>&nbsp;%<label class='setting'>&nbsp;Set</label></span>
										</div>

									</td>
									<td style='width:18%;'>
										<div class='parentdiv'>
											<span class='spantype'>Parent : </span>
											<input type='text' id='txtParentCommVal".$rw->company_id."' name='txtParentCommVal".$rw->company_id."' readonly='True' class='inputsetting' value='".$rw->mycom_CommissionAmount."' />
											<span style='float:left'>&nbsp;&#8377;<label class='setting'>&nbsp;Set</label></span>
											</div>
											<div class='parentdiv'>
											<span class='spantype'>User : </span>
											<input type='text' id='txtUserCommVal".$rw->company_id."' name='txtUserCommVal".$rw->company_id."' class='inputsetting' value='".$rw->CommissionAmount."' />
											<span style='float:left'>&nbsp;&#8377;<label  class='setting'>&nbsp;Set</label></span>
											</div>
									</td>
									<td style='width:18%;'>
										<div class='parentdiv'>
											<span class='spantype'>Parent : </span>
											<input type='text' id='txtParentSurPer".$rw->company_id."' name='txtParentSurPer".$rw->company_id."' readonly='True' class='inputsetting' value='".$rw->mycom_Charge_per."' />
											<span style='float:left'>&nbsp;%<label class='setting'>&nbsp;Set</label></span>
										</div>
										<div class='parentdiv'>
											<span class='spantype'>User : </span>
											<input type='text' id='txtUserSurPer".$rw->company_id."' name='txtUserSurPer".$rw->company_id."' class='inputsetting' value='".$rw->Charge_per."' />
											<span style='float:left'>&nbsp;%<label class='setting'>&nbsp;Set</label></span>
										</div>
									</td>
									<td style='width:18%;'>
										<div class='parentdiv'>
											<span class='spantype'>Parent : </span>
											<input type='text' id='txtParentSurVal".$rw->company_id."' name='txtParentSurVal".$rw->company_id."' readonly='True' class='inputsetting' value='".$rw->mycom_Charge_amount."' />
											<span style='float:left'>&nbsp;&#8377;<label class='setting'>&nbsp;Set</label></span>
										</div>
										<div class='parentdiv'>
											<span class='spantype'>User : </span>
											<input type='text' id='txtUserSurVal".$rw->company_id."' name='txtUserSurVal".$rw->company_id."' class='inputsetting' value='".$rw->Charge_amount."' />
											<span style='float:left'>&nbsp;&#8377;<label class='setting'>&nbsp;Set</label></span>
										</div>
									</td>
									<td style='width:5%;text-align:center;'>
										<a href='Javascript:void(0);' onclick='return SetcommissionopWise(".$rw->company_id.",".$downline_group_info->row(0)->Id.");'>
											<i class='fa fa-edit editicon'></i>
										</a>
									</td>
								</tr>";
								$i++;
								}

								$str .= "</tbody></table></div></div>";
								echo $str;exit;
				}
			}
		}
	}
	public function CommissionSetting()
	{

		header("Content-Type:application/json");
		/*
		commID=12&commPer=2.00&commVal=0.00&chargePer=0.00&chargeVal=0.00
		*/
		if(isset($_POST["commID"]) and isset($_POST["commPer"]) and isset($_POST["commVal"]) and isset($_POST["chargePer"]) and isset($_POST["chargeVal"]) and isset($_POST["pattern"]))
		{
			$company_id = intval(trim($this->input->post("commID")));
			$pattern = intval(trim($this->input->post("pattern")));
			$commPer = floatval(trim($this->input->post("commPer")));
			$commVal = floatval(trim($this->input->post("commVal")));
			$chargePer = floatval(trim($this->input->post("chargePer")));
			$chargeVal = floatval(trim($this->input->post("chargeVal")));

			$parent_info = $this->db->query("select scheme_id from tblusers where user_id = ?",array($this->session->userdata("MdId")));
			if($parent_info->num_rows() == 1)
			{
				$parent_scheme_id = $parent_info->row(0)->scheme_id;
				$parent_commission_rslt = $this->db->query("select commission_per,CommissionAmount,Charge_per,Charge_amount from tblgroupapi where group_id = ? and company_id = ?",array($parent_scheme_id,$company_id));
				if($parent_commission_rslt->num_rows() == 1)
				{
					$parent_commission_per = floatval($parent_commission_rslt->row(0)->commission_per);
					$parent_CommissionAmount = floatval($parent_commission_rslt->row(0)->CommissionAmount);
					$parent_Charge_per = floatval($parent_commission_rslt->row(0)->Charge_per);
					$parent_Charge_amount = floatval($parent_commission_rslt->row(0)->Charge_amount);


					$downline_group_info = $this->db->query("select Id,group_name from tblgroup where Id = ? and user_id = ?",array($pattern,$this->session->userdata("MdId")));
					if($downline_group_info->num_rows() == 1)
					{

						if($parent_commission_per > 0)
						{
							if($parent_commission_per >= $commPer)
							{
								$downline_commission_rslt = $this->db->query("select Id,commission_per,CommissionAmount,Charge_per,Charge_amount from tblgroupapi where group_id = ? and company_id = ?",array($downline_group_info->row(0)->Id,$company_id));
								if($downline_commission_rslt->num_rows() == 1)
								{
									$this->db->query("update tblgroupapi set commission_per = ? where Id = ?",array($commPer,$downline_commission_rslt->row(0)->Id));
									$reap_array = array(
										"StatusCode"=>1,
										"Message"=>"Request submitted successfully.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}
								else if($downline_commission_rslt->num_rows() == 0)
								{
									$this->db->query("insert into tblgroupapi(group_id,company_id,api_id,commission_per,CommissionAmount,Charge_per,Charge_amount,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?)",
									array($downline_group_info->row(0)->Id,$company_id,0,$commPer,0,0,0,$this->common->getDate(),$this->common->getRealIpAddr()));

									/*{"StatusCode":1,"Message":"Request submitted successfully.","Data":null}*/
									$reap_array = array(
										"StatusCode"=>1,
										"Message"=>"Request submitted successfully.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}
								else
								{
									$reap_array = array(
										"StatusCode"=>0,
										"Message"=>"Something Went Wrong.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}

							}
						}
						else if($parent_CommissionAmount > 0)
						{
							if($parent_CommissionAmount >= $commVal)
							{
								$downline_commission_rslt = $this->db->query("select Id,commission_per,CommissionAmount,Charge_per,Charge_amount from tblgroupapi where group_id = ? and company_id = ?",array($downline_group_info->row(0)->Id,$company_id));
								if($downline_commission_rslt->num_rows() == 1)
								{
									$this->db->query("update tblgroupapi set CommissionAmount = ? where Id = ?",array($commVal,$downline_commission_rslt->row(0)->Id));
									$reap_array = array(
										"StatusCode"=>1,
										"Message"=>"Request submitted successfully.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}
								else if($downline_commission_rslt->num_rows() == 0)
								{
									$this->db->query("insert into tblgroupapi(group_id,company_id,api_id,commission_per,CommissionAmount,Charge_per,Charge_amount,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?)",
									array($downline_group_info->row(0)->Id,$company_id,0,0,$commVal,0,0,$this->common->getDate(),$this->common->getRealIpAddr()));

									/*{"StatusCode":1,"Message":"Request submitted successfully.","Data":null}*/
									$reap_array = array(
										"StatusCode"=>1,
										"Message"=>"Request submitted successfully.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}
								else
								{
									$reap_array = array(
										"StatusCode"=>0,
										"Message"=>"Something Went Wrong.",
										"Data"=>""
									);
									echo json_encode($reap_array);exit;
								}

							}
						}



						
					}
				}
			}


			

		}
	}

	public function SetFullCommissions()
	{

		header("Content-Type:application/json");
		/*
		commID=12&commPer=2.00&commVal=0.00&chargePer=0.00&chargeVal=0.00
		*/
		if(isset($_POST["pattern"]) and isset($_POST["value"]))
		{
			$pattern = intval(trim($this->input->post("pattern")));
			$commPer = floatval(trim($this->input->post("value")));
			
			$parent_info = $this->db->query("select scheme_id from tblusers where user_id = ?",array($this->session->userdata("MdId")));
			if($parent_info->num_rows() == 1)
			{
				$parent_scheme_id = $parent_info->row(0)->scheme_id;
				$parent_commission_rslt = $this->db->query("select company_id,commission_per,CommissionAmount,Charge_per,Charge_amount from tblgroupapi where group_id = ?",array($parent_scheme_id));
				foreach($parent_commission_rslt->result() as $prw)
				{
					$company_id = $prw->company_id;
					$parent_commission_per = floatval($prw->commission_per);
					$parent_CommissionAmount = floatval($prw->CommissionAmount);
					$parent_Charge_per = floatval($prw->Charge_per);
					$parent_Charge_amount = floatval($prw->Charge_amount);


					$downline_group_info = $this->db->query("select Id,group_name from tblgroup where Id = ? and user_id = ?",array($pattern,$this->session->userdata("MdId")));
					if($downline_group_info->num_rows() == 1)
					{

						if($parent_commission_per > 0)
						{
							if($parent_commission_per >= $commPer)
							{
								$downline_commission_rslt = $this->db->query("select Id,commission_per,CommissionAmount,Charge_per,Charge_amount from tblgroupapi where group_id = ? and company_id = ?",array($downline_group_info->row(0)->Id,$company_id));
								if($downline_commission_rslt->num_rows() == 1)
								{
									$this->db->query("update tblgroupapi set commission_per = ? where Id = ?",array($commPer,$downline_commission_rslt->row(0)->Id));
								}
								else if($downline_commission_rslt->num_rows() == 0)
								{
									$this->db->query("insert into tblgroupapi(group_id,company_id,api_id,commission_per,CommissionAmount,Charge_per,Charge_amount,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?)",
									array($downline_group_info->row(0)->Id,$company_id,0,$commPer,0,0,0,$this->common->getDate(),$this->common->getRealIpAddr()));
								}
								else
								{
								}

							}
						}



						
					}
				}

				$reap_array = array(
										"StatusCode"=>1,
										"Message"=>"Request submitted successfully.",
										"Data"=>""
									);
				echo json_encode($reap_array);exit;
			}
		}
	}
}
?>