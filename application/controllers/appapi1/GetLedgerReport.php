<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetLedgerReport extends CI_Controller
{
	public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	private function logentry($data)
	{
		/*$filename = "ledger.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
	}
	public function index() 
	{	
	    $data = json_encode($this->input->get());
	     $this->logentry($data);
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) and isset($_GET["from"]) and isset($_GET["to"])  and isset($_GET["transaction_type"])  and isset($_GET["wtype"]))
			{	
			    
    			    $username = $_GET['username'];
    				$pwd =  $_GET['pwd'];
			    	$from = trim($_GET["from"]);
					$to = trim($_GET["to"]);
					$transaction_type = trim($_GET["transaction_type"]);
					$wtype = trim($_GET["wtype"]);
					
					putenv("TZ=Asia/Calcutta");
    				date_default_timezone_set('Asia/Calcutta');
    				$fromdate = date_format(date_create($from),'Y-m-d')	;	
    				$todate = date_format(date_create($to),'Y-m-d');
			
			
    				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
    				$userinfo = $this->db->query("select user_id,username,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
    				if($userinfo->num_rows() == 1)
    				{
    					$user_id = $userinfo->row(0)->user_id;
    					$usertype_name = $userinfo->row(0)->usertype_name;
    					
    					
    					
    					
    					
    					$resparray = array();
    					$resparray["data"] = array();
    
    					if($wtype == "Wallet2")
    					{
    						if($transaction_type == "ALL")
    						{
    							$payment_info = $this->db->query("select 
    																a.Id,
    																a.payment_id,
    																a.dmr_id,
    																a.bill_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																cr.businessname as payto,
    																dr.businessname as payfrom 
    																from tblewallet2 a 
    																left join tblpayment2 pay on a.payment_id = pay.payment_id
    																left join tblusers cr on pay.cr_user_id = cr.user_id
    																left join tblusers dr on pay.dr_user_id = dr.user_id
    															where 
    															a.user_id = ? and 
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    															(a.credit_amount > 0 or a.debit_amount > 0) 
    						  order by Id",array($user_id,$fromdate,$todate));
    						}
    						else
    						{
    							$payment_info = $this->db->query("select 
    																a.Id,
    																a.payment_id,
    																a.dmr_id,
    																a.bill_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																(select '') as payfrom,
    																(select '') as payto
    																from tblewallet2 a 
    															where 
    															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    															if(? != 'ALL',a.transaction_type = ?,true)
    						    order by Id",array($user_id,$fromdate,$todate,$transaction_type,$transaction_type));
    						}
    
    
    
    						
    						foreach($payment_info->result() as $row)
    						{
    							//$description = str_replace("Direct Payment By","From",$row->description);
    
    							//$payfrom = $this->get_string_between($description, "From ","(");
    							//$payto = $this->get_string_between($description, "To ","(");
    
    							if($row->transaction_type == "BILL")
    							{
    								$row->payment_id = $row->bill_id;
    							}
    							if($row->transaction_type == "DMR")
    							{
    								$row->payment_id = $row->dmr_id;
    							}
    								$data = array(
    										'payment_id'=>$row->payment_id,
    										'date'=>$row->date,
    										'add_date'=>$row->add_date,
    										'transaction_type'=>$row->transaction_type,
    										'credit_amount'=>$row->credit_amount,
    										'debit_amount'=>$row->debit_amount,
    										'balance'=>$row->balance,
    										'description'=>$row->description,
    										'payfrom'=>$row->payfrom,
    										'payto'=>$row->payto,
    										);
    							array_push($resparray["data"],$data);
    						}
    						echo json_encode($resparray);exit;
    					}
    					else
    					{
    					    
    
    
    						if($transaction_type == "ALL")
    						{
    							$payment_info = $this->db->query("select 
    																a.Id,
    																a.dmr_id,
    																a.remark,
    																a.bill_id,
    																a.payment_id,
    																a.recharge_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																cr.businessname as payto,
    																dr.businessname as payfrom 
    																from tblewallet a 
    																left join tblpayment pay on a.payment_id = pay.payment_id
    																left join tblusers cr on pay.cr_user_id = cr.user_id
    																left join tblusers dr on pay.dr_user_id = dr.user_id
    															where 
    															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? 
    						  order by Id",array($user_id,$fromdate,$todate));
    						}
    						else
    						{
    						     if($transaction_type == "Balance_Transfer" )
    						     {
    						         
    						         $payment_info = $this->db->query("select 
    																a.Id,
    																a.remark,
    																a.payment_id,
    																a.dmr_id,
    																a.bill_id,
    																a.recharge_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																cr.businessname as payto,
    																dr.businessname as payfrom 
    																from tblewallet a 
    																left join tblpayment pay on a.payment_id = pay.payment_id
    																left join tblusers cr on pay.cr_user_id = cr.user_id
    																left join tblusers dr on pay.dr_user_id = dr.user_id
    															where 
    															a.user_id = ? and  a.debit_amount > 0 and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    															a.transaction_type = 'PAYMENT'
    						  order by Id",array($user_id,$fromdate,$todate));
    						     }
    						     else if($transaction_type == "Balance_Topup")
    						     {
    						        
    						         $payment_info = $this->db->query("select 
    																a.Id,
    																a.remark,
    																a.payment_id,
    																a.dmr_id,
    																a.bill_id,
    																a.recharge_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																cr.businessname as payto,
    																dr.businessname as payfrom 
    																from tblewallet a 
    																left join tblpayment pay on a.payment_id = pay.payment_id
    																left join tblusers cr on pay.cr_user_id = cr.user_id
    																left join tblusers dr on pay.dr_user_id = dr.user_id
    															where 
    															a.user_id = ? and  a.credit_amount > 0 and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    															a.transaction_type = 'PAYMENT'
    						  order by Id",array($user_id,$fromdate,$todate));
    						     }
    						     else
    						     {
    						        $payment_info = $this->db->query("select 
    																a.Id,
    																a.remark,
    																a.payment_id,
    																a.dmr_id,
    																a.bill_id,
    																a.recharge_id,
    																a.credit_amount,
    																a.debit_amount,
    																a.balance,
    																Date(a.add_date) as date,
    																a.add_date,
    																a.transaction_type,
    																a.description,
    																cr.businessname as payto,
    																dr.businessname as payfrom 
    																from tblewallet a 
    																left join tblpayment pay on a.payment_id = pay.payment_id
    																left join tblusers cr on pay.cr_user_id = cr.user_id
    																left join tblusers dr on pay.dr_user_id = dr.user_id
    															where 
    															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? 
    						  order by Id",array($user_id,$fromdate,$todate)); 
    						     }
    							
    						}
    
    
    
    						
    						foreach($payment_info->result() as $row)
    						{
    							
                                $payto = $row->payto;
    							$payment_id = $row->payment_id;
    							if($row->transaction_type == "PAYMENT")
    							{
    								$description = "Payment From ".$row->payfrom." To ".$row->payto."  By". $row->description;
    							}
    							else
    							{
    							    $description = $row->description;
    							}
    							
    							
    							if($row->transaction_type == "Recharge")
    							{
    								$payment_id = $row->recharge_id;
    								$payto = $row->remark;
    							}
    							if($row->transaction_type == "Recharge_Refund")
    							{
    								$payment_id = $row->recharge_id;
    								$payto = $row->remark;
    							}
    							if($row->transaction_type == "DMR")
    							{
    								$payment_id = $row->dmr_id;
    								$payto = $row->remark;
    							}
    							if($row->transaction_type == "BILL")
    							{
    								$payment_id = $row->bill_id;
    								$payto = $row->remark;
    							}
    							$data = array(
            						'payment_id'=>$payment_id,
            						'date'=>$row->date,
            						'add_date'=>$row->add_date,
            						'transaction_type'=>$row->transaction_type,
            						'credit_amount'=>round($row->credit_amount,2),
            						'debit_amount'=>round($row->debit_amount,2),
            						'balance'=>round($row->balance,2),
            						'description'=>$description,
            						'payfrom'=>$row->payfrom,
            						'payto'=>$payto,
    						);
    						array_push($resparray["data"],$data);
    						}
    						echo json_encode($resparray);exit;
    					}
    				}
			}
			else if(isset($_GET['username']) && isset($_GET['pwd']))
			{	
			   
				$fromdate = "ALL";
				$todate = "ALL";
				if(isset($_GET["from"]) and isset($_GET["to"]))
				{
					$from = trim($_GET["from"]);
					$to = trim($_GET["to"]);
					putenv("TZ=Asia/Calcutta");
					date_default_timezone_set('Asia/Calcutta');
					$fromdate = date_format(date_create($from),'Y-m-d')	;	
					$todate = date_format(date_create($to),'Y-m-d');
					
					
					
					
					
					
				}
				$type = "ALL";
				if(isset($_GET["type"]))
				{
					$type = trim($_GET["type"]);
				}
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$userinfo = $this->db->query("select user_id,username,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					
					$current_date = $this->common->getMySqlDate();
            		$diff = $this->gethoursbetweentwodates($current_date,$fromdate);
            		
					$resparray = array();
					$resparray["data"] = array();

					if($_GET["wtype"] == "Wallet2")
					{
						$str = $this->Ew2->getAgentBalance($user_id).'xxx';
						if($fromdate =="ALL" and $todate =="ALL")
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.dmr_id,
																a.bill_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																a.add_date,
																Date(a.add_date) as date,
																a.transaction_type,
																a.description,
																(select '') as payfrom,
																(select '') as payto
																from tblewallet2 a 
															where 
															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
															 if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id desc",array($user_id,$type,$type));
						}
						else
						{


						if($type == "PAYMENT")
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.dmr_id,
																a.bill_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																Date(a.add_date) as date,
																a.add_date,
																a.transaction_type,
																a.description,
																cr.business_name as payto,
																dr.business_name as payfrom 
																from tblewallet2 a 
																left join tblpayment2 pay on a.payment_id = pay.payment_id
																left join tblusers cr on pay.cr_user_id = cr.user_id
																left join tblusers dr on pay.dr_user_id = dr.user_id
															where 
															a.user_id = ? and 
															Date(a.add_date) >= ? and 
															Date(a.add_date) <= ? and
															(a.credit_amount > 0 or a.debit_amount > 0) and
															if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id",array($user_id,$fromdate,$todate,$type,$type));
						}
						else
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.dmr_id,
																a.bill_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																Date(a.add_date) as date,
																a.add_date,
																a.transaction_type,
																a.description,
																(select '') as payfrom,
																(select '') as payto
																from tblewallet2 a 
															where 
															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
															Date(a.add_date) >= ? and 
															Date(a.add_date) <= ? and
															if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id",array($user_id,$fromdate,$todate,$type,$type));
						}



						}
						foreach($payment_info->result() as $row)
						{
							//$description = str_replace("Direct Payment By","From",$row->description);

							//$payfrom = $this->get_string_between($description, "From ","(");
							//$payto = $this->get_string_between($description, "To ","(");

							if($row->transaction_type == "BILL")
							{
								$row->payment_id = $row->bill_id;
							}
							if($row->transaction_type == "DMR")
							{
								$row->payment_id = $row->dmr_id;
							}
								$data = array(
										'payment_id'=>$row->payment_id,
										'date'=>$row->date,
										'add_date'=>$row->add_date,
										'transaction_type'=>$row->transaction_type,
										'credit_amount'=>$row->credit_amount,
										'debit_amount'=>$row->debit_amount,
										'balance'=>$row->balance,
										'description'=>$row->description,
										'payfrom'=>$row->payfrom,
										'payto'=>$row->payto,
										);
							array_push($resparray["data"],$data);
						}
						echo json_encode($resparray);exit;
					}
					else
					{
						$str = $this->Common_methods->getAgentBalance($user_id).'xxx';
						if($fromdate =="ALL" and $todate =="ALL")
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.recharge_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																	a.add_date,
																Date(a.add_date) as date,
																a.transaction_type,
																a.description,
																cr.businessname as payto,
																dr.businessname as payfrom 
																from tblewallet a 
																left join tblpayment pay on a.payment_id = pay.payment_id
																left join tblusers cr on pay.cr_user_id = cr.user_id
																left join tblusers dr on pay.dr_user_id = dr.user_id
															where 
														
															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
															 if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id desc",array($user_id,$type,$type));
						}
						else
						{


						if($type == "PAYMENT")
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.recharge_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																Date(a.add_date) as date,
																a.add_date,
																a.transaction_type,
																a.description,
																cr.businessname as payto,
																dr.businessname as payfrom 
																from tblewallet a 
																left join tblpayment pay on a.payment_id = pay.payment_id
																left join tblusers cr on pay.cr_user_id = cr.user_id
																left join tblusers dr on pay.dr_user_id = dr.user_id
															where 
															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
															Date(a.add_date) >= ? and 
															Date(a.add_date) <= ? and
															if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id",array($user_id,$fromdate,$todate,$type,$type));
						}
						else
						{
							$payment_info = $this->db->query("select 
																a.Id,
																a.payment_id,
																a.recharge_id,
																a.credit_amount,
																a.debit_amount,
																a.balance,
																Date(a.add_date) as date,
																a.add_date,
																a.transaction_type,
																a.description,
																cr.businessname as payto,
																dr.businessname as payfrom 
																from tblewallet a 
																left join tblpayment pay on a.payment_id = pay.payment_id
																left join tblusers cr on pay.cr_user_id = cr.user_id
																left join tblusers dr on pay.dr_user_id = dr.user_id
															where 
															a.user_id = ? and  (a.credit_amount > 0 or a.debit_amount > 0) and
															Date(a.add_date) >= ? and 
															Date(a.add_date) <= ? and
															if(? != 'ALL',a.transaction_type = ?,true)
						  order by Id",array($user_id,$fromdate,$todate,$type,$type));
						}



						}
						foreach($payment_info->result() as $row)
						{
							//$description = str_replace("Direct Payment By","From",$row->description);

							//$payfrom = $this->get_string_between($description, "From ","(");
							//$payto = $this->get_string_between($description, "To ","(");

							
							if($row->transaction_type == "PAYMENT")
							{
								$description = "Payment From ".$row->payfrom." To ".$row->payto;
							}
							else
							{
							    $description = $row->description;
							}
							if($row->transaction_type != "PAYMENT")
							{
								$row->payment_id = $row->recharge_id;
							}
							$data = array(
						'payment_id'=>$row->payment_id,
						'date'=>$row->date,
						'add_date'=>$row->add_date,
						'transaction_type'=>$row->transaction_type,
						'credit_amount'=>$row->credit_amount,
						'debit_amount'=>$row->debit_amount,
						'balance'=>$row->balance,
						'description'=>$description,
						'payfrom'=>$row->payfrom,
						'payto'=>$row->payto,
						);
						array_push($resparray["data"],$data);
						}
						echo json_encode($resparray);exit;
					}
				}
			}
			
			else
			{
				echo 'Paramenter is missing';exit;
			}		
		}	
	}
	
}