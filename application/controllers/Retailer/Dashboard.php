<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard extends CI_Controller 
{
        
    private $msg='';
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
	public function index()  
	{

			$postparam = '{"token": "232612cff9f1ea3c6dfaaee8e37772ef","request": {"account": ""}}';
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        //
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,'https://www.instantpay.in/ws/utilities/banks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postparam);
        $buffer = curl_exec($ch);
        curl_close($ch);
        
        //echo $buffer;exit;
        $json_obj = json_decode($buffer);

        $this->db->query("truncate instantpay_banklist");
		foreach($json_obj->data as $bkarr)	
		{
			 $this->db->insert('instantpay_banklist',$bkarr);
		}
					//print_r($json_obj);exit;
					$this->view_data['data_result']  = $json_obj->data;

			$this->view_data["message"]  = "";	
			$this->view_data["message"]  = ""; 
			$this->load->view("Retailer/Dashboard_view",$this->view_data);
		
		
	}

public function getBalance()
	{
	    echo round($this->Common_methods->getAgentBalance($this->session->userdata("AgentId")))."#".round($this->Ew2->getAgentBalance($this->session->userdata("AgentId")));
	    
	}
	public function ShowRetailerprofile1()
	{

		if(isset($_POST["retailerid"]))
		{
			$user_id = $this->session->userdata("AgentId");

			//echo $this->input->post();exit;

			$retailerid = $this->Common_methods->decrypt(trim($this->input->post("retailerid")));
			if($retailerid == $user_id)
			{
				$rsltuserinfo = $this->db->query("SELECT a.user_id,a.parentid,a.businessname,a.mobile_no,a.usertype_name,a.add_date,b.emailid,b.postal_address,b.pincode ,
				state.state_name,city.city_name
				FROM 
				tblusers a 
				left join tblusers_info b on a.user_id = b.user_id 
				left join tblstate state on a.state_id = state.state_id
				left join tblcity city on a.city_id = city.city_id
				where a.user_id = ?",array($retailerid));	
				if($rsltuserinfo->num_rows() == 1)
				{
					$businessname = $rsltuserinfo->row(0)->businessname;
					$mobile_no = $rsltuserinfo->row(0)->mobile_no;
					$emailid = $rsltuserinfo->row(0)->emailid;
					$postal_address = $rsltuserinfo->row(0)->postal_address;
					$pincode = $rsltuserinfo->row(0)->pincode;
					$state_name = $rsltuserinfo->row(0)->state_name;
					$city_name = $rsltuserinfo->row(0)->city_name;


					$ersparray = array(
								"RetailerId"=>$retailerid,
								"Frm_Name"=>$businessname,
								"city"=>$city_name,
								"Address"=>$postal_address,
								"Pincode"=>$pincode,
								"State"=>$State,
								"District"=>1,
					);
					echo json_encode($ersparray);exit;

				}
			}
			
		}
		$ersparray = array(
								"RetailerId"=>$retailerid,
								"Frm_Name"=>"",
								"city"=>"",
								"Address"=>"",
								"Pincode"=>"",
								"State"=>"",
								"District"=>1,
					);
		echo json_encode($ersparray);exit;	

		

		/*
			{"RetailerId":"c3e92f06-c833-44e6-b3a1-6ede18ec6607","Frm_Name":"RAVIKANT","city":null,"Address":"HIMATNAGAR TA HIMATNAGAR DSABARKANMTHAGDFGDFGDFG","Pincode":0,"State":12,"District":1}
		*/
	}

	public function AddressFieldcheck()
	{
		/*
		{
			"pancardPath":"\\Retailer_image\\d2caa6e7-4c14-43b3-a94e-89f5f261c8e2_download.jpg",
			"aadharcardPath":"\\Retailer_image\\72fdb1c0-04f8-4094-8700-a92ef7fae928_download.jpg",
			"PSAStatus":"Y",
			"AadhaarStatus":"Y"
		}
		*/



		$rsltuserprofile = $this->db->query("select pancardPath,aadharcardPath,PSAStatus,AadhaarStatus,soapselfiePath,gstcertificatePath,service_agreementPath,AddressProofPath from tblusersprofile where user_id = ?",array($this->session->userdata("AgentId")));
		if($rsltuserprofile->num_rows() == 1)
		{
			$PSAStatus = "N";
			$AadhaarStatus = "N";
			if($rsltuserprofile->row(0)->PSAStatus == "yes")
			{
				$PSAStatus = "Y";
			}
			if($rsltuserprofile->row(0)->aadharcardPath == "yes")
			{
				$AadhaarStatus = "Y";
			}


			$resparray = array(

				"pancardPath"=>$rsltuserprofile->row(0)->pancardPath,
				"aadharcardPath"=>$rsltuserprofile->row(0)->aadharcardPath,
				"PSAStatus"=>$PSAStatus,
				"AadhaarStatus"=>$AadhaarStatus,
			);
			echo json_encode($resparray);exit;
		}
		else
		{
			$resparray = array(

				"pancardPath"=>"",
				"aadharcardPath"=>"",
				"PSAStatus"=>"N",
				"AadhaarStatus"=>"N",
			);
			echo json_encode($resparray);exit;
		}
	}






		public function getTodaysHourSale()
		{
			$user_id = $this->session->userdata("AgentId");
			$hours = '';
			$total = 0;
			$totalcount = 0;
			$totalcharge = 0;
			$dbrslt = $this->db->query("SELECT count(Id) as totalcount,Sum(Amount) as sale,Sum(Charge_Amount) as totalcharge,add_date FROM `mt3_transfer` where Date(add_date) = ? and status = 'SUCCESS' and user_id = ? group by hour(add_date)  order by Id",array($this->common->getMySqlDate(),$user_id));
			foreach($dbrslt->result() as $rw)
			{
				$hours .=$rw->sale.",";
				$total +=floatval($rw->sale);
				$totalcount +=floatval($rw->totalcount);
				$totalcharge += floatval($rw->totalcharge);
			}
			$reaparray = array(
				"hourlysale"=>$hours,
				"totalsale"=>$total,
				"totalcount"=>$totalcount,
				"totalcharge"=>round($totalcharge,2),
			);
			echo json_encode($reaparray);exit;
		}
		public function getSummary2()
		{
			$user_id = $this->session->userdata("AgentId");
			$hours = '';
			$totalsuccess = 0;
			$totalpending = 0;
			$totalfailure = 0;
			$dbrslt = $this->db->query("SELECT count(recharge_id) as totalcount,Sum(Amount) as sale,recharge_status as Status,Sum(commission_amount) as totalcommission,add_date FROM `tblrecharge` where Date(add_date) = ?  and user_id = ? group by recharge_status  order by recharge_id",array($this->common->getMySqlDate(),$user_id));
			foreach($dbrslt->result() as $rw)
			{
				if($rw->Status == "Success")
				{
					$totalsuccess += floatval($rw->sale);
				}	
				if($rw->Status == "Failure")
				{
					$totalfailure += floatval($rw->sale);
				}
				if($rw->Status == "Pending")
				{
					$totalpending += floatval($rw->sale);
				}
			}
			$reaparray = array(
				"SUCCESS"=>$totalsuccess,
				"PENDING"=>$totalpending,
				"FAILURE"=>$totalfailure,
				"BALANCE"=>$this->Common_methods->getAgentBalance($user_id)
			);
			echo json_encode($reaparray);exit;
		}
		
				public function getLastTransactionsdmt()
		{
			$resp = '<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                  <tr class="tx-0">
                   
					<th class="pd-y-5">DateTime</th>
					<th class="pd-y-5">Mobile</th>
                    <th class="pd-y-5">Details</th>
                    <th class="pd-y-5">Amount</th>
					<th class="pd-y-5">Status</th>
					
                  </tr>
                </thead>
                <tbody>';
			$user_id = $this->session->userdata("AgentId");
			$rsltreport = $this->db->query('
				 SELECT bank.BankName,a.unique_id,a.Id,a.add_date,a.edit_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join bank_master bank on a.bank_id = bank.Id
where Date(a.add_date) = ?  and a.user_id = ? order by a.add_date desc limit 10',array($this->common->getMySqlDate(),$user_id));
			
			
			
			
		/*	$rsltreport = $this->db->query("SELECT a.recharge_id,a.add_date,b.company_name,a.mobile_no,a.amount,a.recharge_status,a.operator_id
                                                        FROM `tblrecharge` a
                                                        left join tblcompany b on a.company_id = b.company_id
                                            where a.user_id = ? order by recharge_id desc limit 10",array($user_id));*/
			foreach($rsltreport->result() as $rw)
			{
			
				if($rw->Status == "SUCCESS")
				{
					$sclass = "success";
				}
				if($rw->Status == "FAILURE")
				{
					$sclass = "danger";
				}
				if($rw->Status == "PENDING")
				{
					$sclass = "warning";
				}
				$resp.= '<tr>
                   
					<td class="pd-l-10">
                      '.date_format(date_create($rw->add_date),'d-m h:i ').'
                    </td>
					<td class="pd-l-10">
                      '.$rw->RemiterMobile.'

                    </td>
                    <td class="pd-l-10" style="">
                      '.$rw->BankName.'
                      <br>
                      '.$rw->AccountNumber.'

                    </td>
                    <td class="pd-l-10">
                      '.$rw->Amount.'
                    </td>
                    <td class="pd-l-10">
                      <span class="btn btn-sm btn-'.$sclass.'">'.$rw->Status.'</span>
                    </td>';
                    
                  
                  $resp.= '</tr>';	
			}
			$resp.= '</table>';
			echo $resp;exit;
		}

		public function getLastTransactions()
		{
			$resp = '<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                  <tr class="tx-0">
                   
					<th class="pd-y-5">DateTime</th>
					<th class="pd-y-5">Operator</th>
                    <th class="pd-y-5">Mobile</th>
                    <th class="pd-y-5">Amount</th>
					<th class="pd-y-5">Status</th>
					
                  </tr>
                </thead>
                <tbody>';
			$user_id = $this->session->userdata("AgentId");
		/*	$rsltreport = $this->db->query('
				 select Id,number,amount, company_name,status,add_date,mcode,type,transaction_id,operator_id,customer_mobile,customer_name
               
                    select  
                        t.recharge_id as Id,t.mobile_no as number,t.amount as amount,
                        t.add_date,t.recharge_status as status, o.company_name,
                        o.mcode,
                        (select "RECHARGE") as type,
                        (select "") as customer_name,
                        (select "") as customer_mobile,
                        t.transaction_id,t.operator_id
                    from  tblrecharge  t
                    left join tblcompany o on t.company_id = o.company_id
                    where t.user_id = ?  
                    
                
                order by add_date desc limit 15',array($user_id,$user_id));
			
			*/
			
			
				$rsltreport = $this->db->query("SELECT a.recharge_id,a.add_date,b.company_name,a.mobile_no,a.amount,a.recharge_status,a.operator_id
                                                        FROM `tblrecharge` a
                                                        left join tblcompany b on a.company_id = b.company_id
                                            where Date(a.add_date) = ? and a.user_id = ? order by recharge_id desc limit 6",array($this->common->getMySqlDate(),$user_id));
			foreach($rsltreport->result() as $rw)
			{
			
				if($rw->recharge_status == "Success")
				{
					$sclass = "success";
				}
				if($rw->recharge_status == "Failure")
				{
					$sclass = "danger";
				}
				if($rw->recharge_status == "Pending" or $rw->recharge_status == "InProcess")
				{
					$sclass = "warning";
				}
				$resp.= '<tr>
                   
					<td class="pd-l-10">
                      '.date_format(date_create($rw->add_date),'d-m h:i ').'
                    </td>
					<td class="pd-l-10">
                      '.$rw->company_name.'
					

                    </td>
                    <td class="pd-l-10" style="">
                      '.$rw->mobile_no.'
                     
                    </td>
                    <td class="pd-l-10">
                      '.$rw->amount.'
                    </td>
                    <td class="pd-l-10">
                      <span class="btn btn-sm btn-'.$sclass.'">'.$rw->recharge_status.'</span>
                    </td>';
                    
                  
                  $resp.= '</tr>';	
			}
			$resp.= '</table>';
			echo $resp;exit;
		}
		public function getLastTransactions2()
		{
			$resp = '<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                  <tr class="tx-10">
                    <th class="pd-y-5">RechargeId</th>
					<th class="pd-y-5">DateTime</th>
					<th class="pd-y-5">Operator Name</th>
                    <th class="pd-y-5">Mobile Numer</th>
                    <th class="pd-y-5">Amount</th>
					<th class="pd-y-5">Status</th>
					<th class="pd-y-5">Transaction Id</th>
                  </tr>
                </thead>
                <tbody>';
			$user_id = $this->session->userdata("AgentId");
			$rsltreport = $this->db->query("SELECT a.recharge_id,a.add_date,b.company_name,a.mobile_no,a.amount,a.recharge_status,a.operator_id
                                                        FROM `tblrecharge` a
                                                        left join tblcompany b on a.company_id = b.company_id
                                            where a.user_id = ? order by recharge_id desc limit 10",array($user_id));
			foreach($rsltreport->result() as $rw)
			{
			
				if($rw->recharge_status == "Success")
				{
					$sclass = "success";
				}
				if($rw->recharge_status == "Failure")
				{
					$sclass = "danger";
				}
				if($rw->recharge_status == "Pending")
				{
					$sclass = "warning";
				}
				$resp.= '<tr>
                    <td class="pd-l-20">
                      '.$rw->recharge_id.'
                    </td>
					<td class="pd-l-20">
                      '.date_format(date_create($rw->add_date),'d-m-Y h:i:s A').'
                    </td>
					<td class="pd-l-20">
                      '.$rw->company_name.'
                    </td>
                    <td class="pd-l-20">
                      '.$rw->mobile_no.'
                    </td>
                    <td class="pd-l-20">
                      '.$rw->amount.'
                    </td>
                    <td class="pd-l-20">
                      <span class="btn btn-sm btn-'.$sclass.'">'.$rw->recharge_status.'</span>
                    </td>
                   
					<td class="tx-12">
						'.$rw->operator_id.'
                    </td>
                    
                  </tr>';	
			}
			$resp.= '</table>';
			echo $resp;exit;
		}
		
		
		// public function getBalance()
		// {
		// 	echo $this->Common_methods->getAgentBalance($this->session->userdata("AgentId"))."#".$this->Ew2->getAgentBalance($this->session->userdata("AgentId"));
		// }



		public function getsummary()
	{

		$from = $to = $this->common->getMySqlDate();
		/////openging balance code
		$opening_balance = 0;
		$user_id = $this->session->userdata("AgentId");
		$opening_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($user_id,$from));
		if($opening_rslt->num_rows() == 1)
		{
			$opening_balance = $opening_rslt->row(0)->balance;
		}
		$opening_rslt = $this->db->query("select balance from tblewallet2 where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($user_id,$from));
		if($opening_rslt->num_rows() == 1)
		{
			$opening_balancedmt = $opening_rslt->row(0)->balance;
		}


		/////clossing balance code
		$clossing_balance = 0;
		$user_id = $this->session->userdata("AgentId");
		$clossing_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$to));
		if($clossing_rslt->num_rows() == 1)
		{
			$clossing_balance = $clossing_rslt->row(0)->balance;
		}
		$clossing_rslt = $this->db->query("select balance from tblewallet2 where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$to));
		if($clossing_rslt->num_rows() == 1)
		{
			$clossing_balancedmt = $clossing_rslt->row(0)->balance;
		}


		/////purchase
		$total_purchase = 0;
		$total_transfer = 0;
		$user_id = $this->session->userdata("AgentId");
		$purchase_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as total_purchase,IFNULL(Sum(debit_amount),0) as total_transfer from tblewallet where (transaction_type = 'PAYMENT' or transaction_type = 'CRADIT'  or transaction_type = 'DEBIT') and user_id = ? and Date(add_date) BETWEEN  ? and ?  order by Id desc limit 1",array($user_id,$from,$to));
		if($purchase_rslt->num_rows() == 1)
		{
			$total_purchasewl1 = $purchase_rslt->row(0)->total_purchase;
			$total_transferwl1 = $purchase_rslt->row(0)->total_transfer;
		}
		$purchase_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as total_purchase,IFNULL(Sum(debit_amount),0) as total_transfer from tblewallet2 where (transaction_type = 'PAYMENT' or transaction_type = 'CRADIT' or transaction_type = 'DEBIT') and user_id = ? and Date(add_date) BETWEEN  ? and ?  order by Id desc limit 1",array($user_id,$from,$to));
		if($purchase_rslt->num_rows() == 1)
		{
			$total_purchasewl2 = $purchase_rslt->row(0)->total_purchase;
			$total_transferwl2 = $purchase_rslt->row(0)->total_transfer;
		}


$total_purchase = $total_purchasewl1 + $total_purchasewl2;
$total_transfer = $total_transferwl1 + $total_transferwl2;
 


		////dmt transaction
		$total_dmt = 0;
		$totalcharge = 0;
		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(Amount),0) as total,IFNULL(Sum(Charge_Amount),0) as totalcharge,count(Id) as totalcount,Status from mt3_transfer 
					where 
					user_id = ? and
					(Status = 'SUCCESS' ) and
					Date(add_date) BETWEEN ? and ? ",array($user_id,$from,$to));
		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmt = $rslt_dmt->row(0)->total;
			$totalcharge = $rslt_dmt->row(0)->totalcharge;
		}

		$total_dmtcharge = 0;

		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(debit_amount),0) as total_dmtcharge from mt3_account_validate 
					where 
					user_id = ? and
					(verification_status = 'VERIFIED' ) and
					Date(add_date) BETWEEN ? and ? ",array($user_id,$from,$to));
		

		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmtcharge = $rslt_dmt->row(0)->total_dmtcharge;
			
		}
		// pending
		$total_dmtpending = 0;

		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(Amount),0) as total_dmtpending,IFNULL(Sum(Charge_Amount),0) as totalcharge,count(Id) as totalcount,Status from mt3_transfer 
					where 
					user_id = ? and
					(Status = 'PENDING' or Status = 'HOLD' )  ",array($user_id));
		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmtpending = $rslt_dmt->row(0)->total_dmtpending;
		
		}
		// failed
		$total_dmtfailed = 0;

		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(Amount),0) as total_dmtfailed,IFNULL(Sum(Charge_Amount),0) as totalcharge,count(Id) as totalcount,Status from mt3_transfer 
					where 
					user_id = ? and
					(Status = 'FAILURE')  and
					Date(add_date) BETWEEN ? and ? ",array($user_id,$from,$to));
		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmtfailed = $rslt_dmt->row(0)->total_dmtfailed;
		
		}



		////recharge query

		$totalrecharge = 0;
		$totalcommission = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalrecharge,IFNULL(Sum(commission_amount),0) as totalcommission from tblrecharge where user_id = ? and Date(add_date) BETWEEN ? and ? and (recharge_status = 'Success')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalrecharge = 	$recharge_rslt->row(0)->totalrecharge;
			$totalcommission = 	$recharge_rslt->row(0)->totalcommission;
		}
		//// dmtfailed
		$totalfailed = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as totalfailed from tblewallet2 where user_id = ? and Date(add_date) BETWEEN ? and ? and (remark = 'Transaction Charge R' or remark = 'Money Remittance Rev' or remark = 'Money Remittance Rev')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalfailed = 	$recharge_rslt->row(0)->totalfailed;
		
		}

		//// pending
		$totalPending1 = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalPending1,IFNULL(Sum(commission_amount),0) as totalcommission from tblrecharge where user_id = ? and Date(add_date) BETWEEN ? and ? and (recharge_status = 'Pending')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalPending1 = 	$recharge_rslt->row(0)->totalPending1;
			
		}
		//// failer
		$totalfailure = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalfailure from tblrecharge where user_id = ? and Date(add_date) BETWEEN ? and ? and (recharge_status = 'Failure')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalfailure = 	$recharge_rslt->row(0)->totalfailure;
			
		}
			////indo-nepal query

		$totalnepal = 0;
		$totalnepalchre =0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(SendAmount),0) as totalnepal,IFNULL(Sum(Charge_Amount),0) as totalnepalchre from indonepal_transaction where user_id = ? and Date(add_date) BETWEEN ? and ? and (status = 'Success')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalnepal = 	$recharge_rslt->row(0)->totalnepal;
			$totalnepalchre = 	$recharge_rslt->row(0)->totalnepalchre;
			
			
		}
				////aeps query

		$totalaeps = 0;
		
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalaeps from aeps_transactions2 where user_id = ? and Date(add_date) BETWEEN ? and ? and (cb_status = 'SUCCESS' and sp_key = 'WAP')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalaeps = 	$recharge_rslt->row(0)->totalaeps;
			
		}



		$purchase = 0;
    $totalsuccess =  $totalrecharge + $total_dmt + $totalnepal;
    $totalPending =  $totalPending1 + $total_dmtpending;
   $totalcharge = $totalcharge + $total_dmtcharge;
    $totalfailed = $totalfailed +$totalfailure;

		$resp_array = array(

			"OPENING"=>$opening_balance,
			"OPENINGdmt"=>$opening_balancedmt,
			"PURCHASE"=>$total_purchase,
			"PURCHASEWL1"=>$total_purchasewl1,
			"PURCHASEWL2"=>$total_purchasewl2,
			"DEBITWL1"=>$total_transferwl1,
			"DEBITWL2"=>$total_transferwl2,
			"REVERT"=>$total_transfer,
			"RECHARGE"=>$totalrecharge,
			"RECHARGE_COMMISSION"=>$totalcommission,
			"DMT"=>$total_dmt,
			"DMT_CHARGE"=>$totalcharge,
			"CLOSSING"=>$clossing_balance,
			"CLOSSINGdmt"=>$clossing_balancedmt,
			"totalsuccess"=>$totalsuccess,
			"totalfailed"=>$totalfailed,
			"totalPending"=>$totalPending,
			"totalreversal"=>0,
			"totalnepal"=>$totalnepal,
			"totalaeps"=>$totalaeps,
			"totalnepalchre"=>$totalnepalchre,
			


		);
		
			echo json_encode($resp_array);exit;


		}
	}