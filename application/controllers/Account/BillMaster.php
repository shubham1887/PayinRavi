<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BillMaster extends CI_Controller {
	public function index()
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if(isset($_GET["apikey"]) and isset($_GET["date"]))
		{
			//84712451862593066122
			$apikey = trim($_GET["apikey"]);
			$date = trim($_GET["date"]);
			if($apikey == "89629056192963652575")
			{
			
				$recorddate = 
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$date = date_format(date_create($date),'Y-m-d');		
				$data = array();
			        
			            	$str_query = "SELECT 
				a.Id,
				a.user_id,
				a.add_date,
				a.service_no,
				a.customer_mobile,
				a.customer_name,
				a.dueamount,
				a.duedate,
				a.billnumber,
				a.billdate,
				a.billperiod,
				a.company_id,
				a.bill_amount,
				a.status,
				a.opr_id,
				a.ipay_id,
				a.charged_amt,
				a.resp_status,
				a.res_code,
				a.debit_amount,
				a.credit_amount,
				a.option1,
				b.company_name,
				c.businessname,c.username,c.mobile_no as AgentMobileNo,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				parent.mobile_no as parent_mobile_no,
    			fos.businessname as fos_businessname,
    			fos.username as fos_username,
    			fos.mobile_no as fos_mobile_no
				FROM `tblbills` a 
				left join tblcompany b on a.company_id = b.company_id
				left join tblusers c on a.user_id = c.user_id
				left join tblusers parent on c.parentid = parent.user_id
				left join tblusers fos on c.fos_id = fos.user_id
				where 
				Date(a.add_date) = ?
				order by a.Id";
    					$rslt = $this->db->query($str_query,array($date));
			        
					
				
					$i = 0;
					foreach($rslt->result() as $rw)
					{
						
						
						
						
						$temparray = array(
						
												"Sr" =>  $i, 
												"recharge_id" => $rw->recharge_id, 
												"add_date" =>$rw->add_date, 
												"businessname" =>$rw->businessname, 
												"userid" =>$rw->username, 
											    "company_name" => $rw->company_name, 
									"service_no" =>$rw->service_no, 
									"Amount" =>$rw->bill_amount, 
									"dueamount" =>$rw->dueamount, 
									"duedate"=>$rw->duedate, 
									"billnumber"=>$rw->billnumber, 
									"billdate"=>$rw->billdate, 
									"billperiod"=>$rw->billperiod, 
									"customer_mobile" =>$rw->customer_mobile, 
									"customer_name" =>$rw->customer_name, 
									"status"=>$rw->status, 
									"opr_id"=>$rw->opr_id, 
									"ipay_id"=>$rw->ipay_id, 
									"resp_status"=>$rw->resp_status,
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
												
												
											
											
												);
								
								
								
								array_push( $data,$temparray);
								$i++;
				}
				
				
				
				echo json_encode($data);
	
			}		
		}
		else
		{
			echo "parameter missing";exit;
		}
		
		
	}
	
}
