<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dp extends CI_Controller {
	
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }

	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
			    $txtTxnPwd = $this->input->post("txtTxnPwd");
			    if($txtTxnPwd == "31121986")
			    {
			        $this->view_data["message"] = "";
			        $this->load->view("_Admin/dp2_view",$this->view_data);
			    }
			}
			else if($this->input->post("btnAction") == "Submit")
			{
			    $txtFrom = $this->input->post("txtFrom");
			    $ddltype = $this->input->post("ddltype");
			   $this->startprocessing($txtFrom,$ddltype);
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				    $this->view_data["message"] = "";
				    $this->load->view("_Admin/dp_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	public function startprocessing($date,$ddltype)
	{  
	    $i=1;
		$htmlresp = '<table border=1>';
		$htmlresp .= '<tr>';
		    $htmlresp .= '<th>Sr.</th>';
		    $htmlresp .= '<th>DateTime.</th>';
		    $htmlresp .= '<th>Recharge Id.</th>';
		    $htmlresp .= '<th>Amount</th>';
		    $htmlresp .= '<th>Agent Name</th>';
		    $htmlresp .= '<th>Agent Mobile</th>';
		    $htmlresp .= '<th>Min Transactions</th>';
		    $htmlresp .= '<th>Balance</th>';
		    $htmlresp .= '<th>Remark</th>';
		$htmlresp .= '</tr>';
		
	    $rechargeinfo = $this->db->query("
	    select Sum(a.amount) as totalsuccess,
	        a.user_id,a.recharge_id,a.amount,a.add_date,a.recharge_status,r.amount_from,r.amount_to,r.min_balance,r.min_transaction,r.status,c.usertype_name
	        from tblrecharge a
	        left join tblamountrange r on r.type = ?
	        left join tblusers c on a.user_id = c.user_id
	        left join tblusers dist on c.parentid = dist.user_id
	        left join tblusers md on dist.parentid = md.user_id
	        where 
	        a.recharge_status = 'Failure' and
	        a.amount >= r.amount_from and
	        a.amount <= r.amount_to and
	        r.status = 'live' and
	        Date(a.add_date)  = ? and
	        c.done = 'no' and 
	        c.enabled = 'yes' and
	        dist.enabled = 'yes' and
	        md.enabled = 'yes' and 
	        c.usertype_name = 'Agent' 
	        group by a.user_id
	        ",array($ddltype,$date));
	        foreach($rechargeinfo ->result() as $r)
	        {
	         
	            $userinfo = $this->db->query("select * from tblusers where user_id = ? and enabled = 'yes' and done = 'no'",array($r->user_id));
	            if($userinfo->num_rows() == 1)
	            {
	                
	                
	                $reg_date = date_format(date_create($userinfo->row(0)->add_date),'Y-m-d');
                    $date = $this->common->getMySqlDate();
            		$date1= strtotime($reg_date);
            		$date2= strtotime($date);
            		$secs = $date2 - $date1;// == return sec in difference
            		$days = $secs / 86400;
            		if($days >= 7)
            		{
            		    $balance = $this->Common_methods->getAgentBalance($r->user_id);
    	                if($balance > $r->min_balance)
    	                {
    	                    $checktransactioncount = $this->db->query("select count(recharge_id) as total from tblrecharge where user_id = ? and Date(add_date) = ? and recharge_status = 'Success'",array($r->user_id,$date));
    	                    if($checktransactioncount->row(0)->total >= $r->min_transaction)
    	                    {
    	                       
    	                        $tblewalletentry = $this->db->query("select * from tblewallet where recharge_id = ? and user_id = ? and transaction_type = 'Recharge_Refund'",array($r->recharge_id,$r->user_id));
    	                        if($tblewalletentry->num_rows() == 1)
    	                        {
    	                            $status = 'Success';   
    	                            if($ddltype == "FF")
    	                            {
    	                                $status = 'Failure';   
    	                            }
    	                            
    	                            $sfinfo = $this->db->query("select client_ip4 from tblusers_info where user_id = ? ",array($r->parentid));
    	                            if($sfinfo->num_rows() == 1)
    	                            {
    	                                $client_ip4 = $sfinfo->row(0)->client_ip4;
    	                                if($client_ip4 == "FS=F")
    	                                {
    	                                    $status = 'Failure';
    	                                }
    	                            }
    	                            
    	                            $this->db->query("update tblusers set done= 'yes' where user_id = ?",array($r->user_id));
    	                            $this->db->query("insert into tblentries(user_id,add_date,amount,refId,type) values(?,?,?,?,?)",array($r->user_id,$date,$r->amount,$r->recharge_id,'SF'));
    	                            $this->db->query("update tblrecharge set recharge_status = ?,edit_date = 5 where recharge_id = ?",array($status,$r->recharge_id));
    	                            $this->db->query("update tblewallet set user_id = ? where Id = ?",array(1,$tblewalletentry->row(0)->Id));
    	                            
    	                           $this->process2($r->user_id,$date);
    	                            
                            	   $htmlresp .= '<tr>';
                            		    $htmlresp .= '<td>'.$i.'</td>';
                            		    $htmlresp .= '<td>'.$r->add_date.'</td>';
                            		    $htmlresp .= '<td>'.$r->recharge_id.'</td>';
                            		    $htmlresp .= '<td>'.$r->amount.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->businessname.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->mobile_no.'</td>';
                            		    $htmlresp .= '<td>'.$checktransactioncount->row(0)->total.'</td>';
                            		    $htmlresp .= '<td>'.$balance.'</td>';
                            		    $htmlresp .= '<td>SUCCESS</td>';
                            		$htmlresp .= '</tr>';
                            		
                            		$i++;
    	                            
    	                        }
    	                    }
    	                    else
    	                    {
    	                        $htmlresp .= '<tr style="background:#f00">';
                            		    $htmlresp .= '<td>'.$i.'</td>';
                            		    $htmlresp .= '<td>'.$r->add_date.'</td>';
                            		    $htmlresp .= '<td>'.$r->recharge_id.'</td>';
                            		    $htmlresp .= '<td>'.$r->amount.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->businessname.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->mobile_no.'</td>';
                            		    $htmlresp .= '<td>'.$checktransactioncount->row(0)->total.'</td>';
                            		    $htmlresp .= '<td>'.$balance.'</td>';
                            		    $htmlresp .= '<td>Min Transaction Limit Not Done</td>';
                            		$htmlresp .= '</tr>';
                            		
                            		$i++;
    	                    }
    	                    
    	                }
    	                else
    	                {
    	                    $htmlresp .= '<tr style="background:#f00">';
                            		    $htmlresp .= '<td>'.$i.'</td>';
                            		    $htmlresp .= '<td>'.$r->add_date.'</td>';
                            		    $htmlresp .= '<td>'.$r->recharge_id.'</td>';
                            		    $htmlresp .= '<td>'.$r->amount.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->businessname.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->mobile_no.'</td>';
                            		    $htmlresp .= '<td></td>';
                            		    $htmlresp .= '<td>'.$balance.'</td>';
                            		    $htmlresp .= '<td>Min Balance Limit Not Done</td>';
                            		$htmlresp .= '</tr>';
                            		
                            		$i++;
    	                }
            		}
            		else
            		{
            		    $htmlresp .= '<tr style="background:#f00">';
                            		    $htmlresp .= '<td>'.$i.'</td>';
                            		    $htmlresp .= '<td>'.$r->add_date.'</td>';
                            		    $htmlresp .= '<td>'.$r->recharge_id.'</td>';
                            		    $htmlresp .= '<td>'.$r->amount.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->businessname.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->mobile_no.'</td>';
                            		    $htmlresp .= '<td></td>';
                            		    $htmlresp .= '<td></td>';
                            		   $htmlresp .= '<td>7 Day Limit Not Done</td>';
                            		    
                            		$htmlresp .= '</tr>';
                            		
                            		$i++;
            		}
	                
	                
	                
	                
	                
	            }
	            else
	            {
	                $htmlresp .= '<tr style="background:#f00">';
                            		    $htmlresp .= '<td>'.$i.'</td>';
                            		    $htmlresp .= '<td>'.$r->add_date.'</td>';
                            		    $htmlresp .= '<td>'.$r->recharge_id.'</td>';
                            		    $htmlresp .= '<td>'.$r->amount.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->businessname.'</td>';
                            		    $htmlresp .= '<td>'.$userinfo->row(0)->mobile_no.'</td>';
                            		    $htmlresp .= '<td></td>';
                            		    $htmlresp .= '<td></td>';
                            		    $htmlresp .= '<td> </td>';
                            		    $htmlresp .= '<td>User Disabled For Cutting</td>';
                            		$htmlresp .= '</tr>';
                            		
                            		$i++;
	            }
	        }
	        echo $htmlresp;exit;
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