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
	 	if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
		



		// ini_set('display_errors',1);
		// error_reporting(-1);
		// $this->db->debug = TRUE;
    }


////////////////////////////////// FOR MPAYONLINE FUNCTIONS ////////////////////////////////


	public function FetchPlans()
	{
		$response = "str_replace"("'","\"",file_get_contents('php://input'));
		$json_obj = json_decode($response);
		if(isset($json_obj->operatorid) and isset($json_obj->circleid))
		{
			$operatorid = $json_obj->operatorid;
			$circleid = $json_obj->circleid;
			$rsltoptr = $this->db->query("
				select 
				a.*,
				b.OpParam1 
				from tblcompany a 
				left join tbloperatorcodes b on a.company_id = b.company_id
				left join api_configuration c on b.api_id = c.Id
				where a.company_id = ? and c.api_name = 'MPLAN'",array($operatorid));
			//print_r($rsltoptr->result());exit;
			if($rsltoptr->num_rows() == 1)
			{
			
				$operator_code = $rsltoptr->row(0)->OpParam1;
				$url = 'http://manpay.in/appapi1/getPlan?key=akjsdfajsdfoiu7234&circle='.rawurlencode($circleid).'&operator='.trim($operator_code).'&wwe=sdf&username=&pwd=4';
				$resp =  $this->common->callurl($url);
				echo $resp;exit;
			}
			
		}

		

		

	}



	public function FetchMobilePlansRoffer()
	{

		$response = "str_replace"("'","\"",file_get_contents('php://input'));
		$json_obj = json_decode($response);
		
		
		if(isset($json_obj->operatorid) and isset($json_obj->number))
		{
			$operator = intval($json_obj->operatorid);
			$number = intval($json_obj->number);
			$rsltoptr = $this->db->query("
				select 
				a.*,
				b.OpParam1 
				from tblcompany a 
				left join tbloperatorcodes b on a.company_id = b.company_id
				left join api_configuration c on b.api_id = c.Id
				where a.company_id = ? and c.api_name = 'MPLAN'",array($operator));
			//print_r($rsltoptr->result());exit;
			if($rsltoptr->num_rows() == 1)
			{
			
				$operator_code = $rsltoptr->row(0)->OpParam1;
				$url = 'http://manpay.in/appapi1/getPlan?key=akjsdfajsdfoiu7234&number='.$number.'&operator='.$operator_code.'&wwe=sdf&username=&pwd=4';
				
				$resp =  $this->common->callurl($url);
				echo $resp;exit;	
			}
			
			else
			{
				echo "optr not found";exit;
			}
		}
		
		
		
	}


	public function GetDTHCustInfo()
	{

		$response = "str_replace"("'","\"",file_get_contents('php://input'));
		$json_obj = json_decode($response);
		
		
		if(isset($json_obj->operatorid) and isset($json_obj->number))
		{
			$operator = intval($json_obj->operatorid);
			$number = intval($json_obj->number);
			$rsltoptr = $this->db->query("
				select 
				a.*,
				b.OpParam1 
				from tblcompany a 
				left join tbloperatorcodes b on a.company_id = b.company_id
				left join api_configuration c on b.api_id = c.Id
				where a.company_id = ? and c.api_name = 'MPLAN'",array($operator));
			//print_r($rsltoptr->result());exit;
			if($rsltoptr->num_rows() == 1)
			{
			
				$operator_code = $rsltoptr->row(0)->OpParam1;
				$url = 'http://manpay.in/appapi1/getCustomerName?key=akjsdfajsdfoiu7234&number='.$number.'&mcode='.$operator_code.'&wwe=sdf';
				$resp =  $this->common->callurl($url);
				echo $resp;exit;	
			}
			
			else
			{
				echo "optr not found";exit;
			}
		}
		
		
		
	}








 	public function getBalance()
	{		
		
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("SdId"));	
		echo $balance;
	}






		public function dispute()
		{
			if(isset($_POST["id"]))
			{
				$user_id = $this->session->userdata("SdId");
				$recharge_id = intval($this->input->post("id"));
				$hidmsg = "NOT";
				$rsltrecharge = $this->db->query("select recharge_id,add_date from tblrecharge where recharge_id = ? and recharge_status != 'Pending' and user_id = ? ",array($recharge_id,$user_id));
				if($rsltrecharge->num_rows() == 1)
				{
				
				
					$rsltcheckcomplain = $this->db->query("select * from tblcomplain where recharge_id = ? and complain_status = 'Pending'",array($recharge_id));
					if($rsltcheckcomplain->num_rows() == 1)
					{
						echo "Complain Already In Pending Process";exit;
					}
					else
					{
						$txtToDate = date_format(date_create($rsltrecharge->row(0)->add_date),'y-m-d');
					$date = $this->common->getMySqlDate();
					$date1= strtotime($txtToDate);
					$date2= strtotime($date);
					$secs = $date2 - $date1;// == return sec in difference
					$days = $secs / 86400;
				
					
						$this->db->query("insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)",array($user_id,$this->common->getDate(),'Pending',$hidmsg,'Recharge',$recharge_id));
						echo "Complain Submitted Successfully";exit;
					
					}
				}
				else
				{
					echo "Invalid Recharge";exit;
				}
			}
		}


	public function Show_commsion()
	{

		$str = '<table id="showoptcomm" class="table table-striped table-bordered" style="width:100%;border-top: 1px solid #aaa4a4;">
    <tbody><tr class="operator-showoptcomm">
        <th>Operator </th>
        <th>Status </th>
        <th>Offer</th>
    </tr>';

		$scheme_id = $this->session->userdata("AgentSchemeId");

		if(isset($_GET["type"]))
		{
			$type = $this->input->get("type");
			if($type == "Prepaid")
			{
				$service_id = 1;
			}
			else if($type == "DTH")
			{
				$service_id = 2;
			}
			else if($type == "Landline")
			{
				$service_id = 8;
			}
			else if($type == "Electricity")
			{
				$service_id = 16;
			}
			else if($type == "Gas")
			{
				$service_id = 17;
			}
			
			else
			{
				$service_id = 8;
			}



			$mycomm = $this->db->query("
		select 
		    a.company_name,
		    IFNULL(b.commission,0) as commission,
		    CASE b.commission_type
		        WHEN 'PER' THEN '%'
		        WHEN 'AMOUNT' THEN ''
		        END commission_type
		     
		    from tblcompany a 
		    left join tbluser_commission b on a.company_id = b.company_id  and b.user_id=?
		    where   a.service_id = ?  order by a.service_id,a.company_name",array($this->session->userdata("SdId"),$service_id));
		    foreach($mycomm->result() as $rw)
		    {

                $str .='<tr class="tableimgsecond">
                    <td>'.$rw->company_name.'</td>
                    <td class="img-rightss"><i class="fa fa-thumbs-o-up up-beforen" style="font-size:13px;color:green;"></i>&nbsp;&nbsp;Live!</td>
                    <td>'.$rw->commission.'&nbsp;'.$rw->commission_type.'</td>
                </tr>';
                
    
		    }


		}
		$str .= '</tbody></table>';
		echo $str;exit;
	}

	public function viewbill()
	{
		//OperatorName,OptCode,mobileno,Amount,optional1,optional2,optional3,optional4
		if(isset($_POST["OperatorName"]) and isset($_POST["OptCode"]) and isset($_POST["mobileno"]) and isset($_POST["optional1"]))
		{
			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
			$OperatorName = $this->input->post("OperatorName");
			$company_id = $this->input->post("OptCode");
			$service_no = $this->input->post("mobileno");
			$option1 = $this->input->post("optional1");
			//echo '{"Response":"SUCCESS","Price":"292","billduedate":"2020-11-14","DisplayValues":"[{\"label\":\"Customer Name : \",\"value\":\"DILIPBHAI PATEL\"}]"}';
			$CustomerMobile = "8238232303";

			$this->load->model("Swift");
			echo $this->Swift->fetchbill_swift($userinfo,$company_id,$service_no,$CustomerMobile,$option1);exit;
		}
	}

	
	public function showrecentrecharge()
	{
	
		//type=DTH
		if(isset($_GET["type"]))
		{
			$type = $this->input->get("type");
			if(true)
			{
				if($type == "Prepaid")
				{
					$service_id = 1;
				}
				else if($type == "DTH")
				{
					$service_id = 2;
				}
				else if($type == "Gas")
				{
					$service_id = 17;
				}
				else if($type == "Electricity")
				{
					$service_id = 16;
				}
				else if($type == "Landline")
				{
					$service_id = 8;
				}
				else
				{
					$service_id = 8;
				}
				

				$STR = '<div class="body" style="padding:0px;">
				<div class="body table-responsive" style="position:inherit;">
					<table id="example" class="table table-bordered example-recharge" cellspacing="0" style="width:100%;">
						<thead class="navbar" style="color:white;position:inherit;">
							<tr class="recharge-tableoperator">
								<th>Operator&nbsp;Name</th>
								<th>REQ ID</th>
								<th>Recharge&nbsp;No</th>

								<th>Amount</th>
							
								<th>Operator&nbsp;ID</th>
								<th>Req&nbsp;Time</th>
							</tr>
						</thead>
						<tbody>';
//echo $this->session->userdata("SdId");exit;
				$lasttxns = $this->db->query("select a.recharge_id,a.mobile_no,a.amount,a.operator_id,a.recharge_status,a.add_date,b.company_name from tblrecharge a
                    left join tblcompany b on a.company_id = b.company_id where a.user_id = ? and b.service_id = ? order by a.recharge_id desc limit 10",array($this->session->userdata("SdId"),intval($service_id)));
				
				//print_r($lasttxns->result());exit;

					foreach($lasttxns->result() as $rwtxns)
				
					{


					
					$STR .= '<tr style="color:green;">
										<td>';

										if($rwtxns->recharge_status == 'Success')
							        	{
							        		$STR .= '<img style="height:20px;width:20px;margin-right:3px;float:left; background-color:green;" src="'.base_url().'/ashok-images/correct.svg">';
							                

							        	}
							        	
							        	else if($rwtxns->recharge_status == 'Failure' )
							        	{
							        		
							                   
							                    $STR .= '<img style="height: 20px;width: 18px;margin-right:5px;max-width: 100%;padding: 0; border-radius:50%; background-color:red" src="'.base_url().'ashok-images/closes.svg">';
										}

										$STR.='<i class=""></i>&nbsp;'.$rwtxns->company_name;



										$STR.='</td>
										<td><i class="fa fa-globe" style="font-size:14px;"></i>&nbsp;'.$rwtxns->recharge_id.' </td>
										<td>'.$rwtxns->mobile_no.'</td>

										<td>'.$rwtxns->amount.'</td>
										
										<td style="font-size:14px;">'.$rwtxns->operator_id.'</td>
										<td>
											<p style="font-size:14px;">
											'.$rwtxns->add_date.'

											</p>
										</td>
									</tr>';

			}		
				

				$STR .= '</tbody>

				</table>
			</div>

		</div>';


		echo $STR;exit;

			}
		}

	}



	public function getoperatorname()
	{
		if(isset($_GET["mobile_no"]))
		{
			$mobile = $this->input->get("mobile_no");
			$url = 'http://planapi.in/api/Mobile/OperatorFetch?apimember_id=3489&api_password=dilip2612&Mobileno='.$mobile;
			$resp = $this->common->callurl($url);
			//echo $resp;exit;
			$jsonresp = json_decode($resp);
			if(isset($jsonresp->Operator))
			{
				$operator_name = $jsonresp->Operator;
				$operatorrslt = $this->db->query("select company_id from tblcompany where sortname = ? order by company_id limit 1",array($operator_name));
				if($operatorrslt->num_rows() == 1)
				{
					echo $operatorrslt->row(0)->company_id;exit;
				}
			}
		}
		
	}

	public function RechargeBestofferplan()
	{

		if(isset($_POST["optname"]) and isset($_POST["mobileno"]))
		{
				$operator_name = $_POST["optname"];
				$mobileno = $_POST["mobileno"];
		}
		else
		{
			$operator_name = $_GET["optname"];
			$mobileno = $_GET["mobileno"];	
		}


		$is_prepaid = true;
		if($operator_name == 13)
		{
			$mcode = 23;
		}
		else if($operator_name == 12)
		{
			$mcode = 2;
		}
		else if($operator_name == 23)
		{
			$mcode = 6;
		}
		else if($operator_name == 16)//bsnl topup
		{
			$mcode = 4;
		}
		else if($operator_name == 35)//bsnl stv
		{
			$mcode = 5;
		}
		else if($operator_name == 57)// jio 
		{
			$mcode = 11;
		}


		else if($operator_name == 29)// airtel tv
		{
			$is_prepaid = false;
			$mcode = 24;
		}
		else if($operator_name == 30)// sun  tv
		{
			$is_prepaid = false;
			$mcode = 27;
		}
		else if($operator_name == 31)// tata sky tv
		{
			$is_prepaid = false;
			$mcode = 28;
		}
		else if($operator_name == 32)// big tv
		{
			$is_prepaid = false;
			$mcode = 26;
		}
		else if($operator_name == 33)// videocon tv
		{
			$is_prepaid = false;
			$mcode = 24;
		}
		else if($operator_name == 37)// dish tv
		{
			$is_prepaid = false;
			$mcode = 25;
		}

		if($is_prepaid == true)
		{
			$url = 'http://planapi.in/api/Mobile/RofferCheck?apimember_id=3489&api_password=dilip2612&mobile_no='.$mobileno.'&operator_code='.$mcode;
			$response = $this->common->callurl($url);
			$json_obj = json_decode($response);
			if(isset($json_obj->ERROR) and isset($json_obj->STATUS) )
			{
				$ERROR = $json_obj->ERROR;
				$STATUS = $json_obj->STATUS;


				$resp_array = array();
				$resp_array["status"] = "SUCCESS";
				$data_array = array();

				if($STATUS == "1")
				{
					$RDATA = $json_obj->RDATA;
					foreach($RDATA as $rw)
					{
						$price = $rw->price;
						$commissionUnit = $rw->commissionUnit;
						$ofrtext = $rw->ofrtext;
						$logdesc = $rw->logdesc;
						$commissionAmount = $rw->commissionAmount;
						$temparray = array(
							"price"=>$price,
							"offer"=>$ofrtext,
							"offerDetails"=>$logdesc,
							"commAmount"=>$commissionAmount,
							"commType"=>$commissionUnit,
						);
						array_push($data_array,$temparray);
					}
					$resp_array["Response"] = $data_array;
				}
			}

			echo json_encode($resp_array);exit;
		}
		else
		{
			$url = 'http://planapi.in/api/Mobile/DTHINFOCheck?apimember_id=3489&api_password=dilip2612&Opcode=28&mobile_no=1140267020';
			$url = 'http://planapi.in/api/Mobile/DTHINFOCheck?apimember_id=3489&api_password=dilip2612&mobile_no='.$mobileno.'&Opcode='.$mcode;
			$response = $this->common->callurl($url);
			$json_obj = json_decode($response);
			if(isset($json_obj->ERROR) and isset($json_obj->STATUS) )
			{
				$ERROR = $json_obj->ERROR;
				$STATUS = $json_obj->STATUS;


				$resp_array = array();
				$resp_array["status"] = "SUCCESS";
				$data_array = array();

				if($STATUS == "1")
				{
					$RDATA = $json_obj->RDATA;
					foreach($RDATA as $rw)
					{
						$price = $rw->price;
						$commissionUnit = $rw->commissionUnit;
						$ofrtext = $rw->ofrtext;
						$logdesc = $rw->logdesc;
						$commissionAmount = $rw->commissionAmount;
						$temparray = array(
							"price"=>$price,
							"offer"=>$ofrtext,
							"offerDetails"=>$logdesc,
							"commAmount"=>$commissionAmount,
							"commType"=>$commissionUnit,
						);
						array_push($data_array,$temparray);
					}
					$resp_array["Response"] = $data_array;
				}
			}

			echo json_encode($resp_array);exit;
		}
		



	}


	public function testdata()
	{
	    /*
	    hidELECTRICITYSubmitRecharge: Success
hidUtilAction: PAYBILL
hidParticulars: 
{"statuscode":"TXN","status":"0","message":"BILL FETCH SUCCESSFUL","particulars":{"dueamount":1500,"duedate":"2020-03-11","customername":"JASHVANTBHAI BALUBHAI PARMAR","billnumber":"307331803","billdate":"2020-02-19","billperiod":"NA","reference_id":493195}}
txtMobileNo: 500001373305
ddlOperator: 137
txtCustMobile: 8238232303
txtCustName: JASHVANTBHAI BALUBHAI PARMAR
txtAmount: 1500
	    */
	   // error_reporting(-1);
	   // $this->db->db_debug = TRUE;
	   // ini_set('display_errors',1);
	    $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
	    $mcode="";
	    $company_id = 137;
	    $Amount = 1500;
	    $Mobile = "500001373305";
	    $CustomerMobile="8238232303";
	    $remark = "";
	    $option1="";
	    $particulars = '{"statuscode":"TXN","status":"0","message":"BILL FETCH SUCCESSFUL","particulars":{"dueamount":1500,"duedate":"2020-03-11","customername":"JASHVANTBHAI BALUBHAI PARMAR","billnumber":"307331803","billdate":"2020-02-19","billperiod":"NA","reference_id":493195}}';
	    $particulars = json_decode($particulars);
	    $particulars  = $particulars->particulars;
	    
	    $this->load->model("Instapay");
		$response = $this->Instapay->recharge_transaction2($user_info,$mcode,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$particulars);
	    echo $response;exit;
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
			$user=$this->session->userdata('SdUserType');			
			if(trim($user) == 'MasterDealer')
			{


			//	print_r($this->input->post());exit;
				if(isset($_POST["OperatorName"]) and isset($_POST["OptCode"]) and isset($_POST["mobileno"]) and isset($_POST["Amount"]) and isset($_POST["optional1"]) and isset($_POST["optional2"]) and isset($_POST["optional3"]) and isset($_POST["optional4"]) and isset($_POST["comm"])  and isset($_POST["BillRefId"]))				
				{
				   
				
					$MobileNo =	$this->input->post("mobileno",true);
					$Amount = $this->input->post("Amount",true);
					$custname = "";
					$company_id = $this->input->post("OptCode",true);	
					$mobileTPIN = $this->input->post("mobileTPIN",true);	

					$optional1 =$this->input->post("optional1",true);
					$optional2 =$this->input->post("optional2",true);
					$optional3 =$this->input->post("optional3",true);
					$optional4 =$this->input->post("optional4",true);
				


					//echo $MobileNo." ".$Amount."   ".$company_id;exit;
					$company_info = $this->db->query("select * from tblcompany where company_id = ?",$company_id);
					if($company_info == false)
					{
						$resp_array = array(
										"Message"=>"Configuration Missing, Contact Service Provider.",
										"Response"=>"FAILED",
										"message"=>"Configuration Missing, Contact Service Provider.",
										"status"=>"1",
										"statuscode"=>"ERR"
									);
						echo json_encode($resp_array);exit;	
					}
					$user_id= $this->session->userdata('SdId');
					$scheme_id = $this->session->userdata("AgentSchemeId");
					$recharge_type = "";
					$rechargeBy = "WEB";
					$remark = "Bill Payment";


					$CustomerMobile = "1234567898";
					$current_bal = $this->Common_methods->getAgentBalance($user_id);
					if($Amount < 10)
					{	
						$resp_array = array(
										"Message"=>"Minimum amount 10 INR For Recharge.",
										"Response"=>"FAILED",
										"message"=>"Minimum amount 10 INR For Recharge.",
										"status"=>"1",
										"statuscode"=>"ERR"
									);
						echo json_encode($resp_array);exit;	
					}
				    if($company_info->row(0)->service_id == 1 or $company_info->row(0)->service_id == 2)
				    {
				    	$user_info = $this->Userinfo_methods->getUserInfo($user_id);
				    	if($current_bal >= $Amount)
				    	{
				    		$this->load->model("Do_recharge_model");
							
							$ref_id = 0;
							$particulars = false;

							$response = $this->Do_recharge_model->ProcessRecharge($user_info,"*",$company_id,$Amount,$MobileNo,$recharge_type,$company_info->row(0)->service_id,$rechargeBy,$custname);
							echo $response;exit;
				    	}	
				    	else
				    	{
				    		$resp_array = array(
											"Message"=>"Insufficient Balance",
											"Response"=>"FAILED"
										);
							echo json_encode($resp_array);exit;
				    	}
				    		
				    }
				    else
				    {
				    	$user_info = $this->Userinfo_methods->getUserInfo($user_id);	
						if($current_bal >= $Amount)
						{									

							//$this->load->model("Do_recharge_model");
							$this->load->model("Swift");
							$ref_id = 0;
							$particulars = false;

							$response = $this->Swift->recharge_transaction2($user_info,$company_id,$Amount,$MobileNo,$CustomerMobile,$remark,$optional1,$ref_id,$particulars);
							//$response = $this->Do_recharge_model->ProcessRecharge($user_info,"*",$company_id,$Amount,$MobileNo,$recharge_type,$company_info->row(0)->service_id,$rechargeBy,$custname);
							echo $response;exit;
						
						}
						else
						{
							$resp_array = array(
											"Message"=>"Insufficient Balance",
											"Response"=>"FAILED"
										);
							echo json_encode($resp_array);exit;
						}
				    }
				
				}
				else if($this->input->post("hidSubmitRecharge") == "LOAN")				
				{
				//print_r($this->input->post());exit;
				//You Will Receive Call On Your Mobile Number Within 48 Hours
					if($this->session->userdata('ReadOnly') == true)
					{
						echo "Read Only Mode Enabled";exit;
					}
					$user_id= $this->session->userdata('SdId');
					$userinfo  = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
					$txtLoanEnqName =	$this->input->post("txtLoanEnqName",true);
					$txtLoanEnqContactNo = $this->input->post("txtLoanEnqContactNo",true);
					$txtLoanEnqAadharNo = $this->input->post("txtLoanEnqAadharNo",true);
					$txtLoanEnqAreaPincode=$this->input->post("txtLoanEnqAreaPincode",true);
					$txtLoanEnqPanNo = $this->input->post("txtLoanEnqPanNo",true);
					
					$this->load->model("Loan");
					$response = $this->Loan->loan_enquiry($txtLoanEnqContactNo,$txtLoanEnqAadharNo,$txtLoanEnqPanNo,$txtLoanEnqName,$txtLoanEnqAreaPincode,$userinfo);
					echo $response;exit;
				
				}
				else if($this->input->post("hidELECTRICITYSubmitRecharge"))
				{
				
				    $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
				    $hidUtilAction = $this->input->post("hidUtilAction");
				    
				    if($hidUtilAction == "GETBILL")
				    {
				        
				        error_reporting(-1);
				        ini_set('display_errors',1);
				        $this->db->db_debug = TRUE;
				        $ddlOperator = $this->input->post("ddlOperator");
				        $company_info = $this->db->query("select * from tblcompany where company_id = ?",array($ddlOperator));
    					if($company_info->num_rows() == 1)
    					{
    					   $company_id = $company_info->row(0)->company_id;
    					   $mcode = $company_info->row(0)->mcode;
    					   $serviceno = $this->input->post("txtMobileNo");
    					   $customer_mobile = $this->input->post("txtCustMobile");
    					   $option1 = $this->input->post("txtOption1");
    					   $Amount = 0;
    					   $Mobile = $serviceno ;
    					   $CustomerMobile =  $customer_mobile;
    					   if($mcode == "UGE" or $mcode == "PGE" or $mcode == "DGE" or $mcode == "MGE")
    					   {
    					       if($mcode == "UGE"){$spkey = "UGVCL"; }
    					       if($mcode == "PGE"){$spkey = "PGVCL"; }
    					       if($mcode == "DGE"){$spkey = "DGVCL"; }
    					       if($mcode == "MGE"){$spkey = "MGVCL"; }
    					       
    					     
    					       
    					       $url = 'https://www.mplan.in/api/electricinfo.php?apikey=efa9cf5f4490bfe114ec634d6e91179a&offer=roffer&operator='.$spkey.'&tel='.$serviceno;
                               $url = 'http://manpay.in/appapi1/getPlan/getBill?mcode='.$mcode.'&serviceno='.$serviceno;
    					      //  echo $url;exit;
    					      // $this->logentry2($url);
                        	   $buffer = $this->common->callurl($url);
                        		$json_obj = json_decode($buffer);
                        	//	print_r($buffer);exit;
                        		
                        		/*
                        		{"tel":"12972041127","operator":"DGVCL",
                        		"records":[{"CustomerName":"NILESHBHAI JASWANTBHAI ADESARA ","Billamount":"1,631.49","Billdate":"24\/01\/2020","Duedate":null}],
                        		"status":1}
                        		*/
                        	   // $this->logentry2($buffer);
                        		if(isset($json_obj->records))
                        		{
                        		    $records = $json_obj->records;
                        		   if(isset($records[0]))
                        		   {
                        		       
                        		       $resparr = array();
                        		       $resparr["status"] = "0";
                        		       $resparr["message"] = "Bill Fetch Successful";
                        		       $resparr_data = array();
                        		       $record = $records[0];
                        		      // print_r($record);exit;
                        		       if(isset($record->CustomerName))
                        		       {
                        		           $customername = $record->CustomerName;
                        		           $Billamount = str_replace(",","",$record->Billamount);
                        		           $Billdate = $record->Billdate;
                        		           $Duedate  = $record->Duedate;
                        		           $resparr["particulars"] = array(
                        		                "dueamount"=>$Billamount,
                                    	        "duedate"=>"",
                                    	        "customername"=>$customername,
                                    	        "billnumber"=>"",
                                    	        "billdate"=>$Billdate,
                                    	        "billperiod"=>"NA",
                                    	        "billdetails"=>[],
                                    	        "customerparamsdetails"=>"",
                                    	        "additionaldetails"=>"",
                                    	        "reference_id"=>0
                        		               );
                        		               //$this->logentry2(json_encode($resparr));
                        		              $response= json_encode($resparr);
                        		       }
                        		       else
                        		       {
                        		           $resparr = array();
                            		       $resparr["statuscode"] = "ERR";
                            		       $resparr["message"] = "Bill Fetch Failed.Please Enter Amount Manually";
                            		       $resparr["status"] = "Please Enter Amount Manually";
                            		     //   $this->logentry2(json_encode($resparr));
                            		       echo json_encode($resparr);exit;
                        		       }
                        		   }
                        		}
    					   }
    					   else
    					   {
    					       $this->load->model("Mastermoney");
    						    $response = $this->Mastermoney->fetchbill($user_info,$mcode,$company_id,$Mobile,$CustomerMobile,$option1);
                                //recharge_transaction_validate2($user_info,$mcode,$company_id,$Amount,$Mobile,$CustomerMobile,$option1);
    					   }
    					   
    					   
    					   
    						
    						$json_resp = json_decode($response);
    						if(isset($json_resp->statuscode))
    						{
    						    $statuscode = $json_resp->statuscode;
    						    if($statuscode == "TXN")
    						    {
    						        $resparray = array(
    						                "message"=>$json_resp->status,
    						                "status"=>0,
    						                "statuscode"=>$json_resp->statuscode,
    						                "particulars"=>$json_resp->data
    						            );
    						       echo json_encode($resparray);exit;
    						    }
    						    else
    						    {
    						        $resparray = array(
    						                "message"=>$json_resp->status,
    						                "status"=>1,
    						                "statuscode"=>$json_resp->statuscode,
    						            );
    						       echo json_encode($resparray);exit;
    						    }
    						}
    						echo $response;exit;
    					}
    					else
    					{
    						$resp_arr = array(
    									"message"=>"Operator Configuration Missing",
    									"status"=>1,
    									"statuscode"=>"CONF",
    								);
    						$json_resp =  json_encode($resp_arr);
    						echo $json_resp;exit;
    					}   
				    }
					else if($hidUtilAction == "PAYBILL")
				    {
				        error_reporting(-1);
						ini_set('display_errors',1);
						$this->db->db_debug = TRUE;
				        $ddlOperator = $this->input->post("ddlOperator");
				        $company_info = $this->db->query("select * from tblcompany where company_id = ?",array($ddlOperator));
    					if($company_info->num_rows() == 1)
    					{
    					   $mcode = $company_info->row(0)->mcode;
						   $company_id = $company_info->row(0)->company_id;
    					   $Mobile = $this->input->post("txtMobileNo");
    					   $CustomerMobile = $this->input->post("txtCustMobile");
						   $Amount = $this->input->post("txtAmount");


						   $option1 = "";
						   if(isset($_POST["txtOption1"]))
						   {
						   	$option1 = $this->input->post("txtOption1");
						   }

    					   
						   $custname = $this->input->post("txtCustomerName");
							$hidParticulars = $this->input->post("hidParticulars");
							
							$json_particulars = json_decode($hidParticulars);
							$particulars  = $json_particulars->particulars;
							
							$remark = "Bill";
						
							$option2 = "";
						
						      $ref_id = 0;
                            $this->load->model("Mastermoney");
                            //$response = $this->Mastermoney->fetchbill($user_info,$mcode,$company_info->row(0)->company_id,$serviceno,$customer_mobile,$option1);
                            $response = $this->Mastermoney->recharge_transaction2($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$Mobile,$CustomerMobile,"BillPayment",$option1,$ref_id,false,$option2,"ANDROID");
                
                            echo $response;exit;
						
    					}
    					else
    					{
    						$resp_arr = array(
    									"message"=>"Operator Configuration Missing",
    									"status"=>1,
    									"statuscode"=>"CONF",
    								);
    						$json_resp =  json_encode($resp_arr);
    						echo $json_resp;exit;
    					}   
				    }
				}
				else
				{		
						
					
										 
										 
                        
                        
                        
                        										 
						$this->view_data['message'] ="";
				
					
						$this->load->view('SuperDealer_new/recharge_home_view',$this->view_data);
				}
			} 
		}
	}
	public function getcusname()
	{
		$mob = $_GET["mob"];
		$rslt = $this->db->query("select custname from tblrecharge where mobile_no = ? and user_id = ? order by recharge_id desc limit 1",array($mob,$this->session->userdata('SdId')));
		if($rslt->num_rows() > 0)
		{
			echo $rslt->row(0)->custname;
		}
	}
}	