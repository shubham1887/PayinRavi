<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testrf extends CI_Controller {
	//http://www.himachalpay.com/appapi1/balance?username=&pwd=
	public function index()
	{ 
	    exit;
		$htmlresp = '<table border=1>';
		$htmlresp .= '<tr>';
		    $htmlresp .= '<th>Sr.</th>';
		$htmlresp .= '</tr>';
	    $rechargeinfo = $this->db->query("
	    select Sum(a.amount) as totalsuccess,
	        a.user_id,a.recharge_id,a.amount,a.add_date,a.recharge_status,r.amount_from,r.amount_to,r.min_balance,r.min_transaction,r.status,c.usertype_name
	        from tblrecharge a
	        left join tblamountrange r on r.type = 'FS'
	        left join tblusers c on a.user_id = c.user_id
	        where 
	        a.recharge_status = 'Failure' and
	        a.amount >= r.amount_from and
	        a.amount <= r.amount_to and
	        r.status = 'live' and
	        Date(a.add_date)  = '2019-05-17' and
	        c.done = 'no' and c.enabled = 'yes' and c.usertype_name = 'Agent'
	        group by a.user_id
	        ");
	        foreach($rechargeinfo ->result() as $r)
	        {
	         
	            $userinfo = $this->db->query("select * from tblusers where user_id = ? and enabled = 'yes' and done = 'no'",array($r->user_id));
	            if($userinfo->num_rows() == 1)
	            {
	                $balance = $this->Common_methods->getAgentBalance($r->user_id);
	                if($balance > $r->min_balance)
	                {
	                    $checktransactioncount = $this->db->query("select count(recharge_id) as total from tblrecharge where user_id = ? and Date(add_date) = '2019-05-17'",array($r->user_id));
	                    if($checktransactioncount->row(0)->total >= $r->min_transaction)
	                    {
	                        $tblewalletentry = $this->db->query("select * from tblewallet where recharge_id = ? and user_id = ? and transaction_type = 'Recharge_Refund'",array($r->recharge_id,$r->user_id));
	                        if($tblewalletentry->num_rows() == 1)
	                        {
	                            $date = '2019-05-17';
	                            $this->db->query("update tblusers set done= 'yes' where user_id = ?",array($r->user_id));
	                            $this->db->query("insert into tblentries(user_id,add_date,amount,refId,type) values(?,?,?,?,?)",array($r->user_id,$date,$r->amount,$r->recharge_id,'SF'));
	                            $this->db->query("update tblrecharge set recharge_status = 'Success',edit_date = 5 where recharge_id = ?",array($r->recharge_id));
	                            $this->db->query("update tblewallet set user_id = ? where Id = ?",array(1,$tblewalletentry->row(0)->Id));
	                            
	                            $this->process2($r->user_id,$date);
	                        }
	                    }
	                    
	                }
	            }
	        }
	
	}
	private function process2($user_id,$date)
	{	
	    
	    $this->db->query("update tblewallet set checkpoint = '' where user_id = ? and Date(add_date) >= ?",array($user_id,$date));
		$oldbal = 0;
		$i=0;
		$rsltchecked = $this->db->query("select Id,user_id,credit_amount,debit_amount,balance from tblewallet where user_id = ? and checkpoint ='checked' order by Id desc limit 1",array($user_id));
		if($rsltchecked->num_rows() == 1)
		{
			$oldbal = $rsltchecked->row(0)->balance;
		}
		else
		{
		   $oldbal = 0;
		}
		
		
		$rslt = $this->db->query("select Id,user_id,credit_amount,debit_amount,balance from tblewallet where user_id = ? and checkpoint !='checked' order by Id",array($user_id));
		if($rslt->num_rows() > 0)
		{
		    echo $user_id."  -- ".$rslt->num_rows()."<br>";    
		}
		
		foreach($rslt->result() as $row)
		{
			
			$cr = $row->credit_amount;
			$dr = $row->debit_amount;
			$bal = $row->balance;
			
			
			
			$oldbal += $row->credit_amount;
			$oldbal -= $row->debit_amount;
			$date = $this->common->getDate();
			$ip = $this->common->getRealIpAddr();
			$this->db->query("update tblewallet set checkpoint = 'checked',checkpoing_bal = ?,balance = ? where Id = ?",array($row->balance,$oldbal,$row->Id));
			$i++;
		}
	}
}
