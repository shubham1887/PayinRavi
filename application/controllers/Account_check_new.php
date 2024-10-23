<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account_check_new extends CI_Controller {


	public function index()
	{ 
		$rsltuser = $this->db->query("select user_id from tblusers where user_id != 1");
		//$rsltuser = $this->db->query("select user_id from tblusers where user_id = 4796");
		foreach($rsltuser->result() as $row)
		{
			$this->process($row->user_id);
		}
	}
	public function process($user_id)
	{	
	//17602
	
	 
		$oldbal = 0;
		$i=0;
		$rsltchecked = $this->db->query("select Id,user_id,credit_amount,debit_amount,balance from tblewallet where user_id = ? and checkpoint ='checked' order by Id desc limit 1",array($user_id));
		if($rsltchecked->num_rows() == 1)
		{
			$oldbal = $rsltchecked->row(0)->balance;
		}
		
		
		$rslt = $this->db->query("select Id,user_id,credit_amount,debit_amount,balance from tblewallet where user_id = ? and checkpoint !='checked' order by Id limit 15000",array($user_id));
		echo $rslt->num_rows();
		foreach($rslt->result() as $row)
		{
		   // echo "<br>";
		
			$cr = $row->credit_amount;
			$dr = $row->debit_amount;
			$bal = $row->balance;
			
			//echo $oldbal."    ".$row->credit_amount."   ".$row->debit_amount;exit;
			
			$oldbal += $row->credit_amount;
			$oldbal -= $row->debit_amount;
			$date = $this->common->getDate();
			$ip = $this->common->getRealIpAddr();
			$this->db->query("update tblewallet set checkpoint = 'checked',checkpoing_bal = ?, balance = ? where Id = ? ",array($row->balance,$oldbal,$row->Id));
			$i++;
		
		
		}
	
	}
}

