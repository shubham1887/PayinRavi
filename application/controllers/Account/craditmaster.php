<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Craditmaster extends CI_Controller {
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
			            	$str_query = "select 
									a.Id,
									a.payment_id,
									a.payment_type,
									a.remark,
									a.credit_amount,
									a.debit_amount,
									a.balance,
									a.user_id,
									a.add_date,
									cr.username as cr_user_id ,
									dr.username as dr_user_id
								
								
								 from tblewallet a
								 left join tblpayment b on a.payment_id = b.payment_id
								 left join tblusers cr on cr.user_id = b.cr_user_id
								 left join tblusers dr on dr.user_id = b.dr_user_id
								 where a.user_id = 1 and DATE(a.add_date) >= '$date' and DATE(a.add_date) <= '$date'
								 order by a.Id desc";
							$rslt = $this->db->query($str_query);
			        }
			        else
			        {
			            	$str_query = "select 
									a.Id,
									a.payment_id,
									a.payment_type,
									a.remark,
									a.credit_amount,
									a.debit_amount,
									a.balance,
									a.user_id,
									a.add_date,
									cr.username as cr_user_id ,
									dr.username as dr_user_id
									
									 from pankajtr_archivedb.tblewallet a
									 left join tblpayment b on a.payment_id = b.payment_id
									 left join tblusers cr on cr.user_id = b.cr_user_id
									 left join tblusers dr on dr.user_id = b.dr_user_id
									 where a.user_id = 1 and DATE(a.add_date) >= '$date' and DATE(a.add_date) <= '$date' and
									 order by a.Id desc ";
								$rslt = $this->db->query($str_query);
			        }
			
					
					
					
					
					
				
					$i = 1;
					foreach($rslt->result() as $rw)
					{
						
						$temparray = array(
						
												"Sr" =>  $i, 
												"PaymentID" => $rw->payment_id, 
												"CrUserID" => $rw->cr_user_id, 
												"DrUserID" => $rw->dr_user_id, 
												"PaymentType" => $rw->payment_type, 
												"Remarks" =>$rw->remark, 
												"Credit" =>$rw->credit_amount, 
												"Debit" =>$rw->debit_amount, 
												"DateTime" =>$rw->add_date, 
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
