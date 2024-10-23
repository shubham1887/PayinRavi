<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetLedger extends CI_Controller {
	
	
	
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
		if(isset($_GET["from"]) and isset($_GET["to"])  and  isset($_GET["type"]) and  isset($_GET["username"]) and isset($_GET["pwd"]))
		{ 
		
			$date = trim($_GET["from"]);
			$todate = trim($_GET["to"]);
			$type = trim($_GET["type"]);
			$username = trim($_GET["username"]);
			$password = trim($_GET["pwd"]);
			putenv("TZ=Asia/Calcutta");
			date_default_timezone_set('Asia/Calcutta');								
			$date = date_format(date_create($date),'Y-m-d');
			$todate = date_format(date_create($todate),'Y-m-d');


            $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$userinfo = $this->db->query("select * from tblusers where username = ? and password = ? and host_id = ?",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				if($usertype_name == "Agent" or $usertype_name == "Distributor" or $usertype_name == "MasterDealer")
				{
						if($type == "ALL")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ? and Date(tblewallet.add_date) >= ? and Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						
							
						}
						else if($type == "REFUND")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ? and tblewallet.transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) >= ? and Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						}
						else if($type == "PAYMENT")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ?  and tblewallet.transaction_type = 'PAYMENT' and Date(tblewallet.add_date) >= ? and  Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						}
						
						
						echo '<?xml version="1.0" encoding="utf-8"?><rss>';
		
						foreach($rslt->result() as $row)
						{
							$remark = $row->remark;
							
							if($row->remark == "" or $row->remark == null)
							{
								$remark = "no remark";
							}
							$payment_id = $row->payment_id;
							if($row->payment_id == "" or $row->payment_id == null)
							{
								$payment_id = $row->recharge_id;
							}
							if($row->transaction_type == "PAYMENT")
							{
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$row->description.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>PAY</mcode>
								</item>
								';
							}
							if($row->transaction_type == "Recharge_Refund")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amount : ".$amount." ,Date : ".$add_date;
								}
								else
								{
									$desc = "Recharge REFUND";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>REF</mcode>
								</item>
								';
							}
							if($row->transaction_type == "RECHARGE" or $row->transaction_type == "Recharge")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amt :".$amount." , Date : ".$add_date;
								}
								else
								{
									$desc = "RECHARGE";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>'.$mcode.'</mcode>
								</item>
								';
							}
						
						
						
						}
						echo '</rss>';
				}
				if($usertype_name == "WLAgent" or $usertype_name == "WLDistributor" or $usertype_name == "WLMasterDealer")
				{
						if($type == "ALL")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ? and Date(WLtblewallet.add_date) >= ? and Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						
							
						}
						else if($type == "REFUND")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ? and WLtblewallet.transaction_type = 'Recharge_Refund' and Date(WLtblewallet.add_date) >= ? and Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						}
						else if($type == "PAYMENT")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ?  and WLtblewallet.transaction_type = 'PAYMENT' and Date(WLtblewallet.add_date) >= ? and  Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						}
						
						
						$resparray = array();
						$resparray["data"] = array();
		
						foreach($rslt->result() as $row)
						{
							$remark = $row->remark;
							
							if($row->remark == "" or $row->remark == null)
							{
								$remark = "no remark";
							}
							$payment_id = $row->payment_id;
							if($row->payment_id == "" or $row->payment_id == null)
							{
								$payment_id = $row->recharge_id;
							}
							if($row->transaction_type == "PAYMENT")
							{
							$payfrom = $this->get_string_between($row->description, "From ","(");
							$payto = $this->get_string_between($row->description, "To ","(");
							
								$data = array(
									'payment_id'=>$row->payment_id,
									'add_date'=>$row->add_date,
									'transaction_type'=>$row->transaction_type,
									'credit_amount'=>$row->credit_amount,
									'debit_amount'=>$row->debit_amount,
									'balance'=>$row->balance,
									'description'=>$row->description,
									'payfrom'=>$payfrom,
									'payto'=>$payto,
									);
									array_push($resparray["data"],$data);
							
							}
							if($row->transaction_type == "Recharge_Refund")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,WLtblrecharge.mobile_no,WLtblrecharge.amount,WLtblrecharge.add_date,WLtblrecharge.recharge_status from WLtblrecharge,tblcompany where tblcompany.company_id = WLtblrecharge.company_id and WLtblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amount : ".$amount." ,Date : ".$add_date;
								}
								else
								{
									$desc = "Recharge REFUND";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>REF</mcode>
								</item>
								';
							}
							if($row->transaction_type == "RECHARGE" or $row->transaction_type == "Recharge")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,WLtblrecharge.mobile_no,WLtblrecharge.amount,WLtblrecharge.add_date,WLtblrecharge.recharge_status from WLtblrecharge,tblcompany where tblcompany.company_id = WLtblrecharge.company_id and WLtblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amt :".$amount." , Date : ".$add_date;
								}
								else
								{
									$desc = "RECHARGE";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>'.$mcode.'</mcode>
								</item>
								';
							}
						
						
						
						}
							echo json_encode($resparray);exit;
				}
				
				
				
				
			}
			
			
		}
		else if(isset($_POST["from"]) and isset($_POST["to"])  and  isset($_POST["type"]) and  isset($_POST["username"]) and isset($_POST["pwd"]))
		{ 
		
			$date = trim($_POST["from"]);
			$todate = trim($_POST["to"]);
			$type = trim($_POST["type"]);
			$username = trim($_POST["username"]);
			$password = trim($_POST["pwd"]);
			putenv("TZ=Asia/Calcutta");
			date_default_timezone_set('Asia/Calcutta');								
			$date = date_format(date_create($date),'Y-m-d');
			$todate = date_format(date_create($todate),'Y-m-d');

			$userinfo = $this->db->query("select * from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$password));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				if($usertype_name == "Agent" or $usertype_name == "Distributor" or $usertype_name == "MasterDealer")
				{
						if($type == "ALL")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ? and Date(tblewallet.add_date) >= ? and Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						
							
						}
						else if($type == "REFUND")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ? and tblewallet.transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) >= ? and Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						}
						else if($type == "PAYMENT")
						{
							$rslt = $this->db->query("select tblewallet.user_id,tblewallet.payment_id,tblewallet.recharge_id,tblewallet.transaction_type,tblewallet.remark,tblewallet.description,tblewallet.add_date,tblewallet.credit_amount,tblewallet.debit_amount,tblewallet.balance,tblewallet.cr_user_id,tblewallet.dr_user_id from tblewallet where tblewallet.user_id = ?  and tblewallet.transaction_type = 'PAYMENT' and Date(tblewallet.add_date) >= ? and  Date(tblewallet.add_date) <= ? order by tblewallet.Id",array($user_id,$date,$todate));	
						}
						
						
						echo '<?xml version="1.0" encoding="utf-8"?><rss>';
		
						foreach($rslt->result() as $row)
						{
							$remark = $row->remark;
							
							if($row->remark == "" or $row->remark == null)
							{
								$remark = "no remark";
							}
							$payment_id = $row->payment_id;
							if($row->payment_id == "" or $row->payment_id == null)
							{
								$payment_id = $row->recharge_id;
							}
							if($row->transaction_type == "PAYMENT")
							{
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$row->description.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>PAY</mcode>
								</item>
								';
							}
							if($row->transaction_type == "Recharge_Refund")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amount : ".$amount." ,Date : ".$add_date;
								}
								else
								{
									$desc = "Recharge REFUND";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>REF</mcode>
								</item>
								';
							}
							if($row->transaction_type == "RECHARGE" or $row->transaction_type == "Recharge")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amt :".$amount." , Date : ".$add_date;
								}
								else
								{
									$desc = "RECHARGE";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>'.$mcode.'</mcode>
								</item>
								';
							}
						
						
						
						}
						echo '</rss>';
				}
				if($usertype_name == "WLAgent" or $usertype_name == "WLDistributor" or $usertype_name == "WLMasterDealer")
				{
						if($type == "ALL")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ? and Date(WLtblewallet.add_date) >= ? and Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						
							
						}
						else if($type == "REFUND")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ? and WLtblewallet.transaction_type = 'Recharge_Refund' and Date(WLtblewallet.add_date) >= ? and Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						}
						else if($type == "PAYMENT")
						{
							$rslt = $this->db->query("select WLtblewallet.user_id,WLtblewallet.payment_id,WLtblewallet.recharge_id,WLtblewallet.transaction_type,WLtblewallet.remark,WLtblewallet.description,WLtblewallet.add_date,WLtblewallet.credit_amount,WLtblewallet.debit_amount,WLtblewallet.balance,WLtblewallet.cr_user_id,WLtblewallet.dr_user_id from WLtblewallet where WLtblewallet.user_id = ?  and WLtblewallet.transaction_type = 'PAYMENT' and Date(WLtblewallet.add_date) >= ? and  Date(WLtblewallet.add_date) <= ? order by WLtblewallet.Id",array($user_id,$date,$todate));	
						}
						
						
						$resparray = array();
						$resparray["data"] = array();
		
						foreach($rslt->result() as $row)
						{
							$remark = $row->remark;
							
							if($row->remark == "" or $row->remark == null)
							{
								$remark = "no remark";
							}
							$payment_id = $row->payment_id;
							if($row->payment_id == "" or $row->payment_id == null)
							{
								$payment_id = $row->recharge_id;
							}
							if($row->transaction_type == "PAYMENT")
							{
							$payfrom = $this->get_string_between($row->description, "From ","(");
							$payto = $this->get_string_between($row->description, "To ","(");
							
								$data = array(
									'payment_id'=>$row->payment_id,
									'add_date'=>$row->add_date,
									'transaction_type'=>$row->transaction_type,
									'credit_amount'=>$row->credit_amount,
									'debit_amount'=>$row->debit_amount,
									'balance'=>$row->balance,
									'description'=>$row->description,
									'payfrom'=>$payfrom,
									'payto'=>$payto,
									);
									array_push($resparray["data"],$data);
							
							}
							if($row->transaction_type == "Recharge_Refund")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,WLtblrecharge.mobile_no,WLtblrecharge.amount,WLtblrecharge.add_date,WLtblrecharge.recharge_status from WLtblrecharge,tblcompany where tblcompany.company_id = WLtblrecharge.company_id and WLtblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amount : ".$amount." ,Date : ".$add_date;
								}
								else
								{
									$desc = "Recharge REFUND";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>REF</mcode>
								</item>
								';
							}
							if($row->transaction_type == "RECHARGE" or $row->transaction_type == "Recharge")
							{
								$recinfo = $this->db->query("select company_name,mcode,imageurl,recharge_id,WLtblrecharge.mobile_no,WLtblrecharge.amount,WLtblrecharge.add_date,WLtblrecharge.recharge_status from WLtblrecharge,tblcompany where tblcompany.company_id = WLtblrecharge.company_id and WLtblrecharge.recharge_id = ?",array($row->recharge_id));
								if($recinfo->num_rows() == 1)
								{
									$company_name = $recinfo->row(0)->company_name;
									$mobile_no = $recinfo->row(0)->mobile_no;
									$amount = $recinfo->row(0)->amount;
									$status = $recinfo->row(0)->recharge_status;
									$add_date = $recinfo->row(0)->add_date;
									$mcode = $recinfo->row(0)->mcode;
									$desc = "".$company_name." , ".$mobile_no." , Amt :".$amount." , Date : ".$add_date;
								}
								else
								{
									$desc = "RECHARGE";
								}
								if($row->remark == "" or $row->remark == null)
								{
									$remark = "no remark";
								}
								$payment_id = $row->payment_id;
								if($row->payment_id == "" or $row->payment_id == null)
								{
									$payment_id = $row->recharge_id;
								}
								echo '
								<item>
								<transaction_type>'.$row->transaction_type.'</transaction_type>
								<add_date>'.$row->add_date.'</add_date>
								<payment_id>'.$payment_id.'</payment_id>
								<remark>'.$remark.'</remark>
								<description>'.$desc.'</description>
								<credit_amount>'.$row->credit_amount.'</credit_amount>
								<debit_amount>'.$row->debit_amount.'</debit_amount>
								<balance>'.$row->balance.'</balance>
								<mcode>'.$mcode.'</mcode>
								</item>
								';
							}
						
						
						
						}
							echo json_encode($resparray);exit;
				}
				
				
				
				
			}
			
			
		}
		
		
		

	}
	
}