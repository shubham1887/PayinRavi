<?php
class Rollback_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
	public function recharge_Rollback_rollback($recharge_id,$operator_id,$status)
	{
		$recharge_info = $this->db->query("
		select 
		
		a.order_id,
		a.recharge_by,
		a.user_id, 
		a.add_date,
		a.ExecuteBy,
		a.recharge_status,
		a.company_id,
		a.mobile_no,
		a.amount,
		a.commission_amount,
		a.user_id,
		b.company_name,
		c.mobile_no as sendermobile,
		d.call_back_url as respurl 
		from tblrecharge a
		left join tblusers_info d on a.user_id = d.user_id
		left join tblcompany b on a.company_id = b.company_id
		left join tblusers c on a.user_id = c.user_id 
		where 
		a.recharge_id = ?",array($recharge_id));
		if($recharge_info->num_rows() == 1)
		{
			
			$rec_datetime = $recharge_info->row(0)->add_date;
			putenv("TZ=Asia/Calcutta");
			date_default_timezone_set('Asia/Calcutta');
			$recdatetime =date_format(date_create($rec_datetime),'Y-m-d H:i:s');
			$cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
			
			$user_id = $recharge_info->row(0)->user_id;
			$uniqueid = $recharge_info->row(0)->order_id;
			$amount = $recharge_info->row(0)->amount;
			$company_id = $recharge_info->row(0)->company_id;
			$ExecuteBy = $recharge_info->row(0)->ExecuteBy;
			$respurl = $recharge_info->row(0)->respurl;
			$recharge_by = $recharge_info->row(0)->recharge_by;
			$mobile_no = $recharge_info->row(0)->mobile_no;
			$recharge_status = $recharge_info->row(0)->recharge_status;
			
			$date = $this->common->getDate();
			$ip = $this->common->getRealIpAddr();
		    $diff = $this->gethoursbetweentwodates($recdatetime,$cdate);
		    $commission_amount = $recharge_info->row(0)->commission_amount;
		    
		    $possible_debit_amount = $amount - $commission_amount;
		    
		    $total_credit = 0;
		    $total_debit = 0;
		    $tblewallet_entries = $this->db->query("select IFNULL(Sum(credit_amount),0) as credit_amount,IFNULL(Sum(debit_amount),0) as debit_amount from tblewallet where recharge_id = ? and user_id = ?",array($recharge_id,$user_id));
		    if($tblewallet_entries->num_rows() > 0)
		    {
		        foreach($tblewallet_entries->result() as $ew)
		        {
		            $total_credit += $ew->credit_amount;
		            $total_debit += $ew->debit_amount;
		        }
		        
		        
		        if($total_debit > 0)
		        {
		            if($total_debit == $total_credit )
		            {
		               //get rolback here
		                $date = $this->common->getDate();
        				$dr_amount = $recharge_info->row(0)->amount - $recharge_info->row(0)->commission_amount;
        				$transaction_type = "Recharge";
        				
        				$Description = "Rollback : Mobile : ".$recharge_info->row(0)->mobile_no." Amount : ".$recharge_info->row(0)->amount." | Rollback Date = ".$date;
        				
        				// debit process start
        				$add_date = $this->common->getDate();
        				$date = $this->common->getMySqlDate();
        				$old_balance = $this->Common_methods->getCurrentBalance($recharge_info->row(0)->user_id);
        				$current_balance = $old_balance - $dr_amount;
        				
        				$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,debit_amount,balance,description,add_date)
        				values(?,?,?,?,?,?,?)";
        				$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
        				//debit process end
        				$ewallet_id = $this->db->insert_id();
        				$this->db->query("update tblrecharge set recharge_status = ?,operator_id = ?,reverted = 'no',debited = 'yes',ewallet_id = CONCAT_WS(',',ewallet_id,?) where recharge_id = ?",array($status,$operator_id,$ewallet_id,$recharge_id));
		                $resparray = array(
		                                    "message"=>"Recharge Rollback Successfully",
		                                    "status"=>0
		                                   );
		                return json_encode($resparray);
		            }
		            else if($total_debit > $total_credit)
		            {
		               $diff = $total_debit - $total_credit;
		               if($possible_debit_amount == $diff)
		               {
		                   //payment already debited for this recharge
		                   	$this->db->query("update tblrecharge set recharge_status = ?,operator_id  = ?,reverted = 'no',debited = 'yes' where recharge_id = ?",array($status,$operator_id,$recharge_id));
		                    $resparray = array(
		                                    "message"=>"Recharge Updated To Success",
		                                    "status"=>0
		                                   );
		                    return json_encode($resparray);
		               }
		            }
		            else if($total_credit > $total_debit)
		            {
		                $resparray = array(
		                                    "message"=>"Something Went Wrong For This Recharge.Check Credit And Debit Entries",
		                                    "status"=>1
		                                   );
	                    return json_encode($resparray);
		            }
		        }
		        else
		        {
		            $resparray = array(
		                                    "message"=>"No Amount Debited For This Recharge",
		                                    "status"=>1
		                                   );
		           return json_encode($resparray);
		        }  
		    }
		    
	 	}
	}
	public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function ExecuteAPI($url)
	{	
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		
		$this->db->query("insert into tblreqresp(user_id,request,response,add_date,ipaddress,recharge_id,mobile_no,amount,company_id) values(?,?,?,?,?,?,?,?,?)",array(0,$url,$buffer,$this->common->getDate(),$this->common->getRealIpAddr(),0,0,0,0));
		
		
		return $buffer;
	}
	public function logentry($data)
	{
		$filename = "responseurls.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function refundOfAcountReportEntry($recharge_id,$status,$operator_id,$company_id,$user_id,$lapubalance,$lapunumber,$recharge_info,$date,$ip,$recharge_by,$callback,$respurl,$uniqueid)
	{
	   
	    
	    
		$rsltrecstatus = $recharge_info;
		$mobile_no = $rsltrecstatus->row(0)->mobile_no;
		$amount = $rsltrecstatus->row(0)->amount;
		$ExecuteBy = $recharge_info->row(0)->ExecuteBy;
		$this->db->query("update tblrecharge set recharge_status = ?, operator_id = ?,update_time=?,update_ip=?,lapubalance = ?,lapunumber = ? where recharge_id = ?",array($status,$operator_id,$date,$ip,$lapubalance,$lapunumber,$recharge_id));
		$this->db->query("update operatorpendinglimit set failurecount = failurecount + 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$ExecuteBy));
								
		//if($rsltrecstatus->row(0)->reverted == "no")
		if(true)
		{
		
		    
        
		    if(true)
		    {
		        $this->db->query("update tblrecharge set reverted = 'yes' where recharge_id = ?",array($recharge_id));
    			if($this->recharge_refund_remove_duplicate($recharge_id) == true)
    			{
    				$date = $this->common->getDate();
    				$cr_amount = $rsltrecstatus->row(0)->amount - $rsltrecstatus->row(0)->commission_amount;
    				$transaction_type = "Recharge_Refund";
    				
    				$Description = "Refund : Mobile : ".$rsltrecstatus->row(0)->mobile_no." Amount : ".$rsltrecstatus->row(0)->amount." | Revert Date = ".$date;
    				
    				// debit process start
    				$add_date = $this->common->getDate();
    				$date = $this->common->getMySqlDate();
    				$old_balance = $this->Common_methods->getCurrentBalance($user_id);
    				$current_balance = $old_balance + $cr_amount;
    				
    				$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,credit_amount,balance,description,add_date)
    				values(?,?,?,?,?,?,?)";
    				$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
    				//debit process end
    				$ewallet_id = $this->db->insert_id();
    				$this->db->query("update tblrecharge set reverted = 'yes',debited = 'no',ewallet_id = CONCAT_WS(',',ewallet_id,?) where recharge_id = ?",array($ewallet_id,$recharge_id));
    			}    
		    }
			
		}
		if($recharge_by == "API" and $callback == true)
		{
		
			$resptosend = $respurl."?uniqueid=".trim($uniqueid)."&status=Failure&operator_id=".rawurlencode($operator_id)."&transaction_id=".$recharge_id."&number=".$mobile_no."&amount=".$amount;
			$this->common->callurl($resptosend);
		}
		
		
	}
	private function loging($recharge_id,$actionfrom,$remark)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
	}
}

?>