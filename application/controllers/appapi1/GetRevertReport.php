<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetRevertReport extends CI_Controller
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
	    //http://www.mypaymall.in/appapi1/GetRevertReprot?username=&pwd=&from=&to=&wtype=
	    $data = json_encode($this->input->get());
	     $this->logentry($data);
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
		    if(isset($_GET['username']) && isset($_GET['pwd']) and isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["wtype"]))
			{	
			    
    			    $username = $_GET['username'];
    				$pwd =  $_GET['pwd'];
			    	$from = trim($_GET["from"]);
					$to = trim($_GET["to"]);
					$wtype = trim($_GET["wtype"]);
					
					putenv("TZ=Asia/Calcutta");
    				date_default_timezone_set('Asia/Calcutta');
    				$fromdate = date_format(date_create($from),'Y-m-d')	;	
    				$todate = date_format(date_create($to),'Y-m-d');
			
			
    				$host_id = 1;
    				$userinfo = $this->db->query("select user_id,username,usertype_name from tblusers where username = ?  and password = ? ",array($username,$pwd));
    				if($userinfo->num_rows() == 1)
    				{
    					$user_id = $userinfo->row(0)->user_id;
    					$usertype_name = $userinfo->row(0)->usertype_name;
    					
    					
                		   
    					
    					
    					$resparray = array();
    					$resparray["data"] = array();
    
    					if($wtype == "Wallet2")
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
    															a.user_id = ? and  
    															a.debit_amount > 0 and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    														    a.transaction_type = 'DEBIT'
    						    order by Id",array($user_id,$fromdate,$todate));
    						
    
    
    
    						
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
    															a.user_id = ? and  a.debit_amount > 0 and
    															Date(a.add_date) >= ? and 
    															Date(a.add_date) <= ? and
    															a.transaction_type = 'DEBIT'
    						  order by Id",array($user_id,$fromdate,$todate));
    						     
    						    
    						
    						foreach($payment_info->result() as $row)
    						{
    							//$description = str_replace("Direct Payment By","From",$row->description);
    
    							//$payfrom = $this->get_string_between($description, "From ","(");
    							//$payto = $this->get_string_between($description, "To ","(");
    
    							
    							if($row->transaction_type == "DEBIT")
    							{
    								$description = "Payment From ".$row->payfrom." To ".$row->payto;
    							}
    							else
    							{
    							    $description = $row->description;
    							}
    							if($row->transaction_type != "DEBIT")
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
    				else
    				{
    				    $resparray = array(
    				            "status"=>1,
    				            "statuscode"=>"ERR",
    				            "message"=>"Invalid UserId Or Password"
    				        );
    				    echo json_encode($resparray);exit;
    				}
			}
		
			else
			{
				echo 'Paramenter is missing';exit;
			}		
		}	
	}
	
}