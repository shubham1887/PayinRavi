<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rechargemaster extends CI_Controller {
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
			        
			            	$str_query = "select 
						
    					
    						
    						a.update_time,
    						a.recharge_id,
    						a.ewallet_id,
    						a.transaction_id,
    						a.add_date,
    						b.businessname,
    						b.username,
    						
    						c.company_name,
    						c.company_id,
    						b.parentid,
    						a.mobile_no,
    						a.amount,
    						a.commission_amount,
    						a.commission_per,
    						a.DComPer,
    						a.DComm,
    						a.MdComPer,
    						a.MdComm,
    						a.ExecuteBy,
    						a.recharge_by,
    						a.recharge_status,
    						dist.username as dist_userid,
    						dist.businessname as dist_businessname,
    						md.username as md_userid,
    						md.businessname as md_businessname
    						
    						from tblrecharge a
    						left join tblcompany c on a.company_id = c.company_id
    						left join tblusers b on a.user_id = b.user_id
    						left join tblusers dist on a.DId = dist.user_id
    						left join tblusers md on a.MdId = md.user_id
    						where 
    						Date(a.add_date) =?  order by a.recharge_id";
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
												"company_id" => $rw->company_id, 
												"mobile_no" =>$rw->mobile_no, 
												"Amount" =>$rw->amount,
												"RetailerCommissionPer" =>$rw->commission_per, 
												"RetailerCommissionAmount" =>$rw->commission_amount,
												
												"DistCommissionPer" =>$rw->DCommPer, 
												"DistCommissionAmount" =>$rw->DComm, 
												
												"MdCommissionPer" =>$rw->MdCommPer, 
												"MdCommissionAmount" =>$rw->MdComm, 
												
												"DebitAmount" =>($rw->amount - $rw->commission_amount), 
												"ExecuteBy" =>$rw->ExecuteBy, 
											    "Recharge Status" =>$rw->recharge_status, 
												
												
											
											
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
