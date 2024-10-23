<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetDistributorLedger extends CI_Controller
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
	public function index() 
	{	
	  
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['fromdate'])  && isset($_GET['todate'])  && isset($_GET['wtype']))
			{	
			
		
			        $username = $_GET['username'];
				    $pwd =  $_GET['pwd'];
					$from = trim($_GET["fromdate"]);
					$to = trim($_GET["todate"]);
					putenv("TZ=Asia/Calcutta");
					date_default_timezone_set('Asia/Calcutta');
					$fromdate = date_format(date_create($from),'Y-m-d');	
					$todate = date_format(date_create($to),'Y-m-d');	
			
				
				    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
    				$userinfo = $this->db->query("select user_id,username from tblusers where username = ?  and password = ? and (usertype_name = 'Distributor' or usertype_name = 'MasterDealer') and host_id = ?",array($username,$pwd,$host_id));
    				if($userinfo->num_rows() == 1)
    				{
    					$user_id = $userinfo->row(0)->user_id;
    					$resparray = array();
    					$resparray["data"] = array();
    
    					if($_GET["wtype"] == "Wallet2")
    					{   
    						$str = $this->Ew2->getAgentBalance($user_id).'xxx';
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
    														Date(a.add_date) <= ?  order by Id",array($user_id,$fromdate,$todate));
    						
                            foreach($payment_info->result() as $row)
    						{
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
															Date(a.add_date) <= ? order by a.Id",array($user_id,$fromdate,$todate));
    						
    
    
    
    						
    						foreach($payment_info->result() as $row)
    						{
    							
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
            						'credit_amount'=>round($row->credit_amount,2),
            						'debit_amount'=>round($row->debit_amount,2),
            						'balance'=>round($row->balance,2),
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