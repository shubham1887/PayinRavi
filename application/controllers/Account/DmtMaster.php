<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DmtMaster extends CI_Controller {
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
			    error_reporting(-1);
			    ini_set('display_errors',1);
			    $this->db->db_debug = TRUE;
			
				$recorddate = 
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$date = date_format(date_create($date),'Y-m-d');		
				$data = array();
			        
			            	$str_query = "
						
    					
    						SELECT bank.bank_name,a.unique_id,a.retry,a.API,a.Id,a.order_id,a.add_date,a.edit_date,
					a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,a.ccf,a.cashback,a.tds,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name,
b.businessname,b.mobile_no,b.username,
dist.username as dist_userid,
dist.businessname as dist_businessname,
md.username as md_userid,
md.businessname as md_businessname


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers dist on b.parentid = dist.user_id
left join tblusers md on dist.parentid = md.user_id
left join dezire_banklist bank on a.bank_id = bank.Id
 where Date(a.add_date) = ?  order by Id";
    					$rslt = $this->db->query($str_query,array($date));
			        
					
				
					$i = 0;
					foreach($rslt->result() as $rw)
					{
						
						
						
						
						$temparray = array(
						
												"Sr" =>  $i, 
												"Id" => $rw->Id, 
												"add_date" =>$rw->add_date, 
												"businessname" =>$rw->businessname, 
												"userid" =>$rw->username, 
											    
											    
										    	"RESP_name" =>$rw->RESP_name, 
            									"AccountNumber" =>$rw->AccountNumber, 
            									"IFSC" =>$rw->IFSC, 
            									"mode" =>$rw->mode, 
            									"Amount" =>$rw->Amount, 
            									"Status" =>$rw->Status, 
            									"Charge_Amount" =>$rw->Charge_Amount, 
            									"RemiterMobile" =>$rw->RemiterMobile, 
            									"debit_amount" =>$rw->debit_amount, 
            									"credit_amount" =>$rw->credit_amount, 
            									
            									
            									"RESP_statuscode" =>$rw->RESP_statuscode, 
            									"RESP_status" =>$rw->RESP_status, 
            									
            									"RESP_opr_id" =>$rw->RESP_opr_id,
											    
												
											
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
