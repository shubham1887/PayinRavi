<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Refundmaster extends CI_Controller {
	public function index()
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if(isset($_GET["apikey"]) and isset($_GET["date"]))
		{
			//84712451862593066122
			$apikey = trim($_GET["apikey"]);
			$date = trim($_GET["date"]);
			if($apikey == "84712451862593066122")
			{
			
				$recorddate = 
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$date = date_format(date_create($date),'Y-m-d');		
				$data = array();
			        if($date >= "2017-07-28")
			        {
			            	$str_query = "SELECT 
							a.recharge_id,
							a.Id as ewallet_id,
							a.user_id,
							b.business_name,
							b.username,
							c.company_name,
							
							r.add_date as rec_date,
							r.update_time as update_time,
							r.retry as retry,
							r.operator_id as operator_id,
							r.mobile_no,
							r.company_id,
							r.amount,
							r.recharge_status,
							r.ExecuteBy,
							r.recharge_by,
							r.commission_amount,
							r.totalCommissionPer,
							(select api_id from tblapi  where api_name = r.ExecuteBy) as api_id
							FROM 
							tblewallet a
							left join tblusers b on a.user_id = b.user_id
							left join tblrecharge r on a.recharge_id = r.recharge_id
							left join tblcompany c on r.company_id = c.company_id
							
							
							
							where  
							a.transaction_type = 'Recharge_Refund' and 
							Date(a.add_date) >= '$date' and Date(a.add_date) <= '$date' and Date(r.add_date) != Date(a.add_date)";
    					$rslt = $this->db->query($str_query,array($date));
			        }
			        else
			        {
			            
							$str_query = "SELECT 
							a.recharge_id,
							a.Id as ewallet_id,
							a.user_id,
							b.business_name,
							b.username,
							c.company_name,
							
							r.add_date as rec_date,
							r.update_time as update_time,
							r.retry as retry,
							r.operator_id as operator_id,
							r.mobile_no,
							r.company_id,
							r.amount,
							r.recharge_status,
							r.ExecuteBy,
							r.recharge_by,
							r.commission_amount,
							r.totalCommissionPer,
							(select api_id from tblapi  where api_name = r.ExecuteBy) as api_id
							FROM 
							pankajtr_archivedb.tblewallet a
							left join tblusers b on a.user_id = b.user_id
							left join pankajtr_archivedb.tblrecharge r on a.recharge_id = r.recharge_id
							left join tblcompany c on r.company_id = c.company_id
							
							
							
							where  
							a.transaction_type = 'Recharge_Refund' and 
							Date(a.add_date) >= '$date' and Date(a.add_date) <= '$date' and Date(r.add_date) != Date(a.add_date)";
    					$rslt = $this->db->query($str_query,array($date));
						
						
			        }
			
					
					
					
					
					
				
					$i = 0;
					foreach($rslt->result() as $rw)
					{
						
						$admincommission = (($rw->amount * $rw->totalCommissionPer)/100);
						$debit_amount = $rw->amount - $rw->commission_amount;
						
						
						
						$temparray = array(
						
												"Sr" =>  $i, 
												"RechargeID" => $rw->recharge_id, 
												"RechargeDate" => $rw->rec_date, 
												"UpdateDate" =>$rw->update_time, 
												"UserID" =>$rw->username, 
												"CompanyID" =>$rw->company_id, 
												"MobileNo" =>$rw->mobile_no, 
												"APIID" =>$rw->api_id, 
												"RechargeAmount" => $rw->amount, 
												"DebitAmount" => $debit_amount, 
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
