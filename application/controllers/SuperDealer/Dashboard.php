<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
    public function getBalance()

		{
			echo $this->Common_methods->getAgentBalance($this->session->userdata("SdId"))."#".$this->Ew2->getAgentBalance($this->session->userdata("SdId"));
		}
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
	    $this->viewdata["message"]= "";
		$this->load->view('SuperDealer/dashboard_view',$this->viewdata);		 		 
	}


	public function getTotalSuccessRecahrge()
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total,recharge_status from tblrecharge where Date(add_date) = ? and host_id = ? group by recharge_status",array($this->common->getMySqlDate(),$this->session->userdata("SdId")));
		foreach($rslt->result() as $rw)
		{
			if($rw->recharge_status == "Success")
			{
				$total_success += $rw->total;
			}
			else if($rw->recharge_status == "Pending")
			{
				$total_pending += $rw->total;
			}
			else if($rw->recharge_status == "Failure")
			{
				$total_failure += $rw->total;
			}
		}
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
			);
		echo json_encode($arr);exit;
	}
	
	public function getTotalDMRValues()
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		$total_hold = 0;
		
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		$total_hold_count = 0;
		
		
		$rslt = $this->db->query("select IFNULL(Sum(Amount),0) as total,count(Id) as totalcount,Status from mt3_transfer where Date(add_date) = ? and host_id = ? group by Status",array($this->common->getMySqlDate(),$this->session->userdata("SdId")));
		
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->Status == "SUCCESS")
			{
				$total_success += $rw->total;
				$total_success_count += $rw->totalcount;
			}
			else if($rw->Status == "FAILURE")
			{
				$total_failure += $rw->total;
				$total_failure_count += $rw->totalcount;
			}
			else if($rw->Status == "PENDING")
			{
				$total_pending += $rw->total;
				$total_pending_count += $rw->totalcount;
			}
			else if($rw->Status  == "HOLD")
			{
				$total_hold += $rw->total;
				$total_hold_count += $rw->totalcount;
			}
		}
		//echo $total_success;exit;
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				"hold"=>$total_hold,
				"Success_Count"=>$total_success_count,
				"Failure_Count"=>$total_failure_count,
				"Pending_Count"=>$total_pending_count,
				"hold_Count"=>$total_hold_count,
			);
		echo json_encode($arr);exit;
	}
	
	public function getLoad()
	{

		

	    $strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>
                                                <th>Usertype</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>';
		$w1_agent = 0;
		$w1_dist = 0;
		$w1_md = 0;
		$w1_sd = 0;
		$w1_api = 0;
		$w1_total = 0;
		$clossing_balance_rslt = $this->db->query("SELECT a.user_id,a.usertype_name from tblusers a
		where  a.host_id = ? ",array($this->session->userdata("SdId")));
		foreach($clossing_balance_rslt->result() as $closing)
		{
			$live_balance = $this->Common_methods->getAgentBalance($closing->user_id);
			$w1_total += $live_balance;
			if($closing->usertype_name == "Agent")
			{
				$w1_agent += $live_balance;
			}
			if($closing->usertype_name == "Distributor")
			{
				$w1_dist += $live_balance;
			}
			if($closing->usertype_name == "MasterDealer")
			{
				$w1_md += $live_balance;
			}
			if($closing->usertype_name == "SuperDealer")
			{
				$w1_sd += $live_balance;
			}
			if($closing->usertype_name == "APIUSER")
			{
				$w1_api += $live_balance;
			}
			
			
			

		}

		$strresp .= '<tr>
                            <td><h5>Agent</h5></td>
                            <td><h5>'.number_format($w1_agent,0,'.',',').'</h5></td>   
                        </tr>';
		$strresp .= '<tr>
                            <td><h5>Distributor</h5></td>
                            <td><h5>'.number_format($w1_dist,0,'.',',').'</h5></td>   
                        </tr>';
        $strresp .= '<tr>
                            <td><h5>MasterDealer</h5></td>
                            <td><h5>'.number_format($w1_md,0,'.',',').'</h5></td>   
                        </tr>';
        $strresp .= '<tr>
                            <td><h5>SuperDealer</h5></td>
                            <td><h5>'.number_format($w1_sd,0,'.',',').'</h5></td>   
                        </tr>';
        $strresp .= '<tr>
                            <td><h5>APIUSER</h5></td>
                            <td><h5>'.number_format($w1_api,0,'.',',').'</h5></td>   
                        </tr>';
		
		$hostlimit = 0;
		$usedlimit = 0;
		$hostlimitrslt = $this->db->query("select hostlimit,usedlimit from tblhostlimit where host_id = ?",array($this->session->userdata("SdId")));
	    if($hostlimitrslt->num_rows() == 1)
	    {
	       
	        $hostlimit = $hostlimitrslt->row(0)->hostlimit;
	        $usedlimit = $hostlimitrslt->row(0)->usedlimit;
	    }
		
		
			$strresp .= '<tr>
                            <td><h5>TOTAL</h5></td>
                            <td><h5>'.number_format($w1_total,0,'.',',').'</h5></td>   
                        </tr>';
            $strresp .= '<tr>
                <td><h5>Virtual Limit</h5></td>
                <td><h5>'.number_format($hostlimit,0,'.',',').'</h5></td>   
            </tr>';
            
            
            $strresp .= '<tr>
                <td><h5>Actual Balance</h5></td>
                <td><h5>'.number_format(($w1_total - $hostlimit),0,'.',',').'</h5></td>   
            </tr>';
            
		$strresp .= '</table>';
			echo $strresp;exit;
	
	}
	public function getLoad2()
	{
	   
	    $strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>
                                                <th>Usertype</th>
                                                <th>DMT Balance</th>
                                            </tr>
                                        </thead>';
		$w2_agent = 0;
		$w2_dist = 0;
		$w2_md = 0;
		$w2_sd = 0;
		$w2_api = 0;
		$w2_total = 0;
		$clossing_balance_rslt = $this->db->query("select user_id,usertype_name from tblusers where host_id = ?",array($this->session->userdata("SdId")));
		foreach($clossing_balance_rslt->result() as $user)
		{
		    $balance = $this->Ew2->getAgentBalance($user->user_id);
			$w2_total += $balance;
			if($user->usertype_name == "Agent")
			{
				$w2_agent += $balance;
			}
			if($user->usertype_name == "Distributor")
			{
				$w2_dist += $balance;
			}
			if($user->usertype_name == "MasterDealer")
			{
				$w2_md += $balance;
			}
			if($user->usertype_name == "SuperDealer")
			{
				$w2_sd += $balance;
			}
			if($user->usertype_name == "APIUSER")
			{
				$w2_api += $balance;
			}
		    

		}
		
		$strresp .= '<tr>
                            <td><h5>Agent</h5></td>
                            <td><h5>'.number_format($w2_agent,0,'.',',').'</h5></td>   
                        </tr>';	
        $strresp .= '<tr>
                            <td><h5>Distributor</h5></td>
                            <td><h5>'.number_format($w2_dist,0,'.',',').'</h5></td>   
                        </tr>';	
        $strresp .= '<tr>
                            <td><h5>MasterDealer</h5></td>
                            <td><h5>'.number_format($w2_md,0,'.',',').'</h5></td>   
                        </tr>';	
        $strresp .= '<tr>
                            <td><h5>Your Balance</h5></td>
                            <td><h5>'.number_format($w2_sd,0,'.',',').'</h5></td>   
                        </tr>';	
		
		
		$strresp .= '<tr>
                        <td><h5>TOTAL</h5></td>
                        <td><h5>'.number_format($w2_total,0,'.',',').'</h5></td>   
                    </tr>';
                    $strresp .= '</table>';
			echo $strresp;exit;
	
	}
	
	public function getLastRecharges()
	{
	    $strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>

                                                <th>Recharge Id</th>
                                                <th>DateTime</th>
                                                <th>Agent</th>
												<th>Operator Name</th>
												<th>Mobile Number</th>
												<th>Amount</th>
												<th>Status</th>
                                            </tr>
                                        </thead>';
	        $lastrecharges = $this->db->query("SELECT a.recharge_id,a.add_date,a.recharge_status,a.amount,a.mobile_no,b.company_name,c.businessname,c.username
	        from tblrecharge a
	        left join tblcompany b on a.company_id = b.company_id
	        left join tblusers c on a.user_id = c.user_id
	        where a.host_id = ? order by recharge_id desc limit 10
	        ",array($this->session->userdata("SdId")));
			foreach($lastrecharges->result() as $rw)
			{
				$company_name = $rw->company_name;
				$recharge_id = $rw->recharge_id;
				$mobile_no = $rw->mobile_no;
				$recharge_status = $rw->recharge_status;
				$add_date = $rw->add_date;
				$businessname = $rw->businessname;
				$username = $rw->username;
				$amount = $rw->amount;
				
				$strresp .= '<tr>
                                            <td><h5>'.$recharge_id.'</h5></td>
                                            <td><h5>'.$add_date.'</h5></td>
                                            <td><h5>'.$businessname.'</h5></td>
                                            <td><h5>'.$company_name.'</h5></td>
                                            <td><h5>'.$mobile_no.'</h5></td>    
                                            <td><h5>'.$amount.'</h5></td>    
                                            <td><h5>'.$recharge_status.'</h5></td>    
                                        </tr>';
			}
			$strresp .= '</table>';
			echo $strresp;exit;
	}
	
	
	public function getpqyreq_count()
	{
		$rsltpayreq = $this->db->query("select count(Id) as total from tblautopayreq where status = 'Pending'");
		if($rsltpayreq->num_rows() == 1)
		{
			echo $rsltpayreq->row(0)->total;
		}
		else{
			echo "";exit;
		}
	}

}

