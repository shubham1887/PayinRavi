<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard extends CI_Controller 
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
	public function getBalance()
	{
	    $rslt = $this->db->query("select balance from tblewallet where user_id = 1 order by Id desc limit 1");
	    if($rslt->num_rows() == 1)
	    {
	        echo round($rslt->row(0)->balance);
	    }
	    else
	    {
	        echo 0;
	    }
	}
    public function index()  
    {
    	    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    	    $this->output->set_header("Pragma: no-cache"); 		
    		if ($this->session->userdata("aloggedin") != TRUE) 
    		{ 
    			redirect(base_url()."login"); 
    		}			
					
    		else 		
    		{	

				
				$this->view_data["message"]  = "";	
				$this->view_data["message"]  = ""; 
				$this->load->view("My_Admin/Dashboard_view",$this->view_data);
			
			}
		}
		public function getTodaysHourSale()
		{
			$hours = '';
			$total = 0;
			$totalcount = 0;
			$totalcharge = 0;
			$dbrslt = $this->db->query("SELECT count(Id) as totalcount,Sum(Amount) as sale,Sum(Charge_Amount) as totalcharge,add_date FROM `mt3_transfer` where Date(add_date) = ? and status = 'SUCCESS' group by hour(add_date)  order by Id",array($this->common->getMySqlDate()));
			foreach($dbrslt->result() as $rw)
			{
				$hours .=$rw->sale.",";
				$total +=floatval($rw->sale);
				$totalcount +=floatval($rw->totalcount);
				$totalcharge += floatval($rw->totalcharge);
			}
			$reaparray = array(
				"hourlysale"=>$hours,
				"totalsale"=>$total,
				"totalcount"=>$totalcount,
				"totalcharge"=>round($totalcharge,2),
			);
			echo json_encode($reaparray);exit;
		}
		
		
		public function getCurrentMOnth_average_recharge()
		{
			
			
			$totalcount = 0;
			$totalcharge = 0;
			$dbrslt = $this->db->query("select avg(totalrecharge) as recavg,avg(totalrecharge_count) as recavg_count FROM
(
SELECT Date(a.add_date) as date,IFNULL(Sum(a.amount),0) as totalrecharge,IFNULL(count(a.recharge_id),0) as totalrecharge_count from tblrecharge a where MONTH(a.add_date) = MONTH(CURRENT_DATE()) 
AND YEAR(a.add_date) = YEAR(CURRENT_DATE()) and a.recharge_status = 'Success' group by date) b");
			if($dbrslt->num_rows() == 1)
			{
				
				$totalcount +=floatval($dbrslt->row(0)->recavg_count);
				$totalcharge += floatval($dbrslt->row(0)->recavg);
			}
			$reaparray = array(
				"totalcount"=>$totalcount,
				"totalcharge"=>round($totalcharge,2),
			);
			echo json_encode($reaparray);exit;
		}
		
		
		public function getPreviousMonth_success_recharge()
		{
		    error_reporting(-1);
		    ini_set('display_errors',1);
		    $this->db->db_debug = TRUE;
		    $field_1 = "Admin";
			$field_2 = $previous_month =  date('m', strtotime("last month"));
			$field_3 = $previous_year =  date('Y', strtotime("last month"));
			$fixedvalues_rslt = $this->db->query("select * from fixed_previous_data_values_for_dashboard where param = 'MONTHLY_SUCCESS_RECHARGE' and field_1 = ? and field_2 = ?  and field_3 = ?",
			array($field_1,$field_2,$field_3));
			if($fixedvalues_rslt->num_rows() == 1)
			{
			    echo $fixedvalues_rslt->row(0)->value;
			}
			else
			{
			    $dbrslt = $this->db->query("select IFNULL(Sum(amount),0) as totalrecharge from tblrecharge where MONTH(add_date) = ? and YEAR(add_date) = ? and recharge_status = 'Success'",array($field_2,$field_3));
    			if($dbrslt->num_rows() == 1)
    			{
    			   
    				$totalcharge = $dbrslt->row(0)->totalrecharge;
    				$this->db->query("insert into fixed_previous_data_values_for_dashboard(param,value,field_1,field_2,field_3) values(?,?,?,?,?)",array("MONTHLY_SUCCESS_RECHARGE",$totalcharge,$field_1,$field_2,$field_3));
    				echo $totalcharge;exit;
    			}
			}
			echo 0;exit;
		}
		
		
		
	public function getLoad()
	{
	    $strresp = '<table class="table color-table success-table">
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
		$clossing_balance_rslt = $this->db->query("SELECT Sum(a.balance) as totalbalance,a.usertype_name from tblusers a where a.usertype_name != 'Admin'
		  GROUP By a.usertype_name");
		foreach($clossing_balance_rslt->result() as $closing)
		{
		    $pageurl = "";
			$w1_total += $closing->totalbalance;
			if($closing->usertype_name == "Agent")
			{
			    $pageurl = base_url()."My_Admin/agent_list";
				$w21gent += $closing->totalbalance;
			}
			if($closing->usertype_name == "Distributor")
			{
			    $pageurl = base_url()."My_Admin/distributor_list";
				$w1_dist += $closing->totalbalance;
			}
			if($closing->usertype_name == "MasterDealer")
			{
			    $pageurl = base_url()."My_Admin/md_list";
				$w1_md += $closing->totalbalance;
			}
			if($closing->usertype_name == "SuperDealer")
			{
			    $pageurl = base_url()."My_Admin/sd_list";
				$w1_sd += $closing->totalbalance;
			}
			if($closing->usertype_name == "APIUSER")
			{
			    $pageurl = base_url()."My_Admin/UserList";
				$w1_api += $closing->totalbalance;
			}
			
			
			$strresp .= '<tr>
                            <td><a href="'.$pageurl.'" class="link">'.$closing->usertype_name.'</a></td>
                            <td><h6>'.number_format($closing->totalbalance,0,'.',',').'</h6></td>   
                        </tr>';

		}
		
	
		
			$strresp .= '<tr>
                            <td><h5>TOTAL</h5></td>
                            <td><h5>'.number_format($w1_total,0,'.',',').'</h5></td>   
                        </tr>';
            
            
		$strresp .= '</table>';
			echo $strresp;exit;
	
	}
		
		/*	public function getLoad()
	{
		$w2_agent = 0;
		$w2_dist = 0;
		$w2_md = 0;
		$w2_api = 0;
		$w2_total = 0;
		$clossing_balance_rslt = $this->db->query("SELECT b.usertype_name,a.balance as balance FROM (select user_id,Id,balance,add_date from tblewallet ORDER BY Id DESC) AS a
		left join tblusers b on a.user_id = b.user_id
		where  b.usertype_name != 'Admin' GROUP By b.usertype_name",array($this->common->getMySqlDate()));
		foreach($clossing_balance_rslt->result() as $closing)
		{
			$w2_total += $closing->balance;
			if($closing->usertype_name == "Agent")
			{
				$w2_agent += $closing->balance;
			}
			if($closing->usertype_name == "Distributor")
			{
				$w2_dist += $closing->balance;
			}
			if($closing->usertype_name == "MasterDealer")
			{
				$w2_md += $closing->balance;
			}
			if($closing->usertype_name == "APIUSER")
			{
				$w2_api += $closing->balance;
			}

		}
		$arr = array(
			"Agent"=>$w2_agent,
			"Distributor"=>$w2_dist,
			"MasterDealer"=>$w2_md,
			"APIUSER"=>$w2_api,
			"Total"=>$w2_total,
		);
		echo json_encode($arr);exit;
	}*/
	public function getLoad2()
	{
	    $strresp = '<table class="table color-table success-table">
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
		$clossing_balance_rslt = $this->db->query("SELECT a.user_id,a.usertype_name from tblusers a where a.usertype_name != 'Admin'");
		foreach($clossing_balance_rslt->result() as $closing)
		{
		    $balance = $this->Ew2->getAgentBalance($closing->user_id);
			$w1_total += $balance;
			if($closing->usertype_name == "Agent")
			{
				$w21gent += $balance;
			}
			if($closing->usertype_name == "Distributor")
			{
				$w1_dist += $balance;
			}
			if($closing->usertype_name == "MasterDealer")
			{
				$w1_md += $balance;
			}
			if($closing->usertype_name == "SuperDealer")
			{
				$w1_sd += $balance;
			}
			if($closing->usertype_name == "APIUSER")
			{
				$w1_api += $balance;
			}
			
			
			

		}
		
		
		    $strresp .= '<tr>
                            <td><a href="javascropt:void(0)" class="link">MasterDealer</a></td>
                            <td><h6>'.$w1_md.'</h6></td>   
                        </tr>';
            $strresp .= '<tr>
                            <td><a href="javascropt:void(0)" class="link">Distributor</a></td>
                            <td><h6>'.$w1_dist.'</h6></td>   
                        </tr>';
            $strresp .= '<tr>
                            <td><a href="javascropt:void(0)" class="link">Agent</a></td>
                            <td><h6>'.$w21gent.'</h6></td>   
                        </tr>';
            $strresp .= '<tr>
                            <td><a href="javascropt:void(0)" class="link">APIUSER</a></td>
                            <td><h6>'.$w1_api.'</h6></td>   
                        </tr>';
	
		
			$strresp .= '<tr>
                            <td><h5>TOTAL</h5></td>
                            <td><h5>'.$w1_total.'</h5></td>   
                        </tr>';
            
            
		$strresp .= '</table>';
			echo $strresp;exit;
	
	}
	
	
	public function getpqyreq_count()
	{
		$rsltpayreq = $this->db->query("select count(Id) as total,IFNULL(Sum(amount),0) as totalamount   from tblautopayreq where status = 'Pending'");
		if($rsltpayreq->num_rows() == 1)
		{
			echo $rsltpayreq->row(0)->totalamount." | ".$rsltpayreq->row(0)->total;
		}
		else{
			echo "0 | 0";exit;
		}
	}
	public function getcomplain_count()
	{
		$rsltcomplain = $this->db->query("select count(complain_id) as total  from tblcomplain where complain_status = 'Pending'");
		if($rsltcomplain->num_rows() == 1)
		{
			echo $rsltcomplain->row(0)->total;
		}
		else{
			echo "0";exit;
		}
	}

	public function getMastermoneyBalance()
	{
		$this->load->model("Mastermoney");
		echo $this->Mastermoney->getBalance();
	}
	
	public function getAllBalance()
	{
	    if(isset($_GET["api_name"]))
	    {
			$totalcount = 0;
			$totalamount = 0;
	        $api_name = trim($_GET["api_name"]);
	        $countpending = $this->db->query("select count(recharge_id) as totalcount,IFNULL(Sum(amount),0) as totalamount from tblpendingrechares where api_id = (select api_id from tblapi where api_name = ? )",array($api_name));
			if($countpending->num_rows() == 1)
			{
				$totalcount = $countpending->row(0)->totalcount;
				$totalamount = $countpending->row(0)->totalamount;
			}
			
	        $total_balance = 0.00;
	        if($api_name == "PRIMEPAY")
	        {
	            $this->load->model("Mastermoney");
		        $balance =  $this->Mastermoney->getBalance();
		        $balance = round($balance);
		        echo  $balance."^-^".$totalcount."^-^".$totalamount;exit;
	        }
	        if($api_name == "PAYTM")
	        {
	            $this->load->model("Paytm");
		        $balance =  $this->Paytm->getBalance();
		        $balance = round($balance);
		         echo  $balance."^-^".$totalcount."^-^".$totalamount;
	        }
	        if($api_name == "AIRTEL")
	        {
	            $this->load->model("Airtel_model");
		        $balance =  $this->Airtel_model->getBalance();
		        $balance = round($balance);
		         echo  $balance."^-^".$totalcount."^-^".$totalamount;
	        }

    		$ApiInfo = $this->db->query("select a.Id,a.api_name from api_configuration a   where a.api_name = ? and a.enable_balance_check = 'yes'",array($api_name));
    	
    		if($ApiInfo->num_rows()  == 1)
    		{
    		    
    		   
    		    $balance = $this->Api_model->getBalance($ApiInfo->row(0)->Id);
    		    if(preg_match("/|/", $balance) == 1)
		        {
		        	$balance = explode("|",$balance)[0];
		        }
		        $balance = round($balance);
    		    echo $balance."^-^".$totalcount."^-^".$totalamount;
    		}
	    }
	    else
	    {
	        echo "0^-^".$totalcount."^-^".$totalamount;
	    }
		
	}
	public function getOperatorPendings()
	{
	    
			$strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>

                                                <th>Operator Name</th>
                                                <th>Pending</th>
                                               
												<th>Amount</th>
                                            </tr>
                                        </thead>';
	        $countpending = $this->db->query("SELECT count(a.recharge_id) as pendingcount,IFNULL(sum(a.amount),0) as totalpendingamount,b.company_name,(select count(e.recharge_id) from tblpendingrechares e where e.company_id = a.company_id and e.api_id = 8) as hold  FROM `tblpendingrechares`  a left join tblcompany b on a.company_id = b.company_id group by a.company_id");
			foreach($countpending->result() as $rw)
			{
				$company_name = $rw->company_name;
				$pendingcount = $rw->pendingcount;
				$hold = $rw->hold;
				$totalpendingamount = $rw->totalpendingamount;
				$strresp .= '<tr>
                                            <td>
                                                <h6><a href="javascript:void(0)" class="link">'.$rw->company_name.'</a></h6>
                                                </td>
                                                
                                                <td>
                                                <h5>'.$pendingcount.'</h5>
                                                </td>
                                                
                                                <td>
                                                <h5>'.$totalpendingamount.'</h5>
                                                </td>
                                                
                                                
                                        </tr>';
			}
			$strresp .= '</table>';
			echo $strresp;exit;
	}
	
	
	public function getNewUsers()
	{
	    
			$strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>

                                                <th>Agent Name</th>
                                                <th>Agen Type</th>
                                                <th>Mobile</th>
                                                <th>Parent Name</th>
                                            </tr>
                                        </thead>';
	        $countpending = $this->db->query("SELECT a.user_id,a.businessname,a.mobile_no,a.usertype_name,p.businessname as parent_name from tblusers a left join tblusers p on a.parentid = p.user_id where Date(a.add_date) = ? order by a.businessname",array($this->common->getMySqlDate()));
			foreach($countpending->result() as $rw)
			{
				
				$strresp .= '<tr>
                                            <td>
                                                <a>'.$rw->businessname.'</a>
                                                </td>
                                                
                                                <td>
                                                <a>'.$rw->usertype_name.'</a>
                                                </td>
                                                
                                                <td>
                                                <a>'.$rw->mobile_no.'</a>
                                                </td>
                                                 <td>
                                                <a>'.$rw->parent_name.'</a>
                                                </td>
                                                
                                        </tr>';
			}
			$strresp .= '</table>';
			echo $strresp;exit;
	}
	
	public function getapirouting()
	{
	    	$data = array();
			$apis = array();
			$company = array();	
		$rsltapisoperators = $this->db->query("SELECT a.api_id,a.company_id,a.pendinglimit,a.priority,a.status,a.totalpending,a.multi_threaded,a.reroot,a.reroot_api_id,a.statewise,b.api_name,c.company_name
FROM `operatorpendinglimit` a
left join tblapi b on a.api_id = b.api_id
left join tblcompany c on a.company_id = c.company_id
where a.status = 'active'");
        foreach($rsltapisoperators->result() as $opirw)
        {
            $data[$opirw->api_name][$opirw->company_name]["pendinglimit"] = $opirw->pendinglimit;
			$data[$opirw->api_name][$opirw->company_name]["priority"] = $opirw->priority;
			$data[$opirw->api_name][$opirw->company_name]["totalpending"] = $opirw->totalpending;
			
			
			array_push($apis,$opirw->api_name);
			array_push($company,$opirw->company_name);
        }
        
        
        $apis = array_unique($apis);
        $company = array_unique($company);
			$strresp = '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>
                                               <th>Company Name</th>';             
                                                foreach($apis as $api_row)
                                                {
                                                    $strresp.='<th>'.$api_row.'</th>';
                                                }
		
			
		
                                            $strresp.='</tr>
                                        </thead>';
                                        
	        foreach($company as $company_row) 
			{
				$strresp.='<tr>';
    	        $strresp.='<td>'.$company_row.'</td>';
	            foreach($apis as $api_row)
		        {
        			$strresp.='<td>';
				
    				if(isset($data[$api_row][$company_row]))
    				{
    					$strresp.=$data[$api_row][$company_row]["pendinglimit"].' ( '.$data[$api_row][$company_row]["priority"].' )  ';
    					if($data[$api_row][$company_row]["totalpending"] > 0)
    					{
    					    $strresp.= ' , <span style="color:#f00">'.$data[$api_row][$company_row]["totalpending"].'<span>';    
    					}
    					
    				}
    				else
    				{
    					$strresp.='';
    				}
                    $strresp.='</td>';
        	    }
	
	             $strresp.='</tr>';
			
			}
			$strresp .= '</table>';
			echo $strresp;exit;
	}
	
	
	
	public function getTotalSuccessRecahrge()
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		
		$rslt = $this->db->query("select count(recharge_id) as totalcount,IFNULL(Sum(amount),0) as total,recharge_status from tblrecharge where Date(add_date) = ? group by recharge_status",array($this->common->getMySqlDate()));
		foreach($rslt->result() as $rw)
		{
			if($rw->recharge_status == "Success")
			{
				$total_success += $rw->total;
				
				$total_success_count += $rw->totalcount;
			}
			else if($rw->recharge_status == "Pending")
			{
				$total_pending += $rw->total;
				$total_pending_count += $rw->totalcount;
			}
			else if($rw->recharge_status == "Failure")
			{
				$total_failure += $rw->total;
				$total_failure_count += $rw->totalcount;
			}
		}
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				"Success_Count"=>$total_success_count,
				"Failure_Count"=>$total_failure_count,
				"Pending_Count"=>$total_pending_count,
			);
		echo json_encode($arr);exit;
	}
	
	
	public function getYesterdayTotalSuccessRecahrge()
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		
		$rslt = $this->db->query("select count(recharge_id) as totalcount,IFNULL(Sum(amount),0) as total,recharge_status from tblrecharge where Date(add_date) = ? group by recharge_status",array($this->common->getpreviousdate($this->common->getMySqlDate()) ));
		foreach($rslt->result() as $rw)
		{
			if($rw->recharge_status == "Success")
			{
				$total_success += $rw->total;
				
				$total_success_count += $rw->totalcount;
			}
			else if($rw->recharge_status == "Pending")
			{
				$total_pending += $rw->total;
				$total_pending_count += $rw->totalcount;
			}
			else if($rw->recharge_status == "Failure")
			{
				$total_failure += $rw->total;
				$total_failure_count += $rw->totalcount;
			}
		}
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				"Success_Count"=>$total_success_count,
				"Failure_Count"=>$total_failure_count,
				"Pending_Count"=>$total_pending_count,
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
		
		
		$rslt = $this->db->query("select IFNULL(Sum(Amount),0) as total,count(Id) as totalcount,Status from mt3_transfer where Date(add_date) = ? group by Status",array($this->common->getMySqlDate()));
		
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
	public function getDuePayments()
	{

		$strresp = '
		<div class="row row-sm mg-t-20">
		<div class="col-lg-8 mg-t-20 mg-lg-t-0">
            <div class="widget-2">
              <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                  <h4 class="card-title">Due Payments</h4>
                    <a style="padding-left:50px;" href="javascript:void(0)" onClick="getDuePayments()"><i class="fas fa-sync"></i></a>
                </div><!-- card-header -->
                
                <div class="card-body pd-0">';



		$strresp .= '<table class="table color-table primary-table  table-striped color-bordered-table mytable-border" style="border-color:#000000;color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
                                        <thead>
                                            <tr>

                                                <th>Id</th>
                                                <th>DueDate</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Remark</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>';



		$url = 'http://backuputilities.in/Due_payments?mobile_no=';
		$response = $this->common->callurl($url);
		$jsonobj = json_decode($response);
		if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
		{
			$message = $jsonobj->message;
			$status = $jsonobj->status;
			$statuscode = $jsonobj->statuscode;
			if($statuscode == "TXN")
			{
				$data = $jsonobj->data;
				foreach($data as $rwp)
				{
					$Id = $rwp->Id;
					$charge_type = $rwp->charge_type;
					$description = $rwp->description;
					$remark = $rwp->remark;
					$status = $rwp->status;
					$due_date = $rwp->due_date;
					$amount = $rwp->amount;



					$strresp.='<tr>

	                                                <td>'.$Id.'</td>
	                                                <td>'.$due_date.'</td>
	                                                <td>'.$charge_type.'</td>
	                                                <td>'.$description.'</td>
	                                                <td>'.$remark.'</td>
	                                                <td>'.$amount.'</td>
	                                                <td>'.$status.'</td>
	                                                <td><a href="http://backuputilities.in/Due_payments?mobile_no=&paymentfor='.$Id.'" target="_blank">Pay</a></td>
	                                            </tr>';
				}
				$strresp.='</table>';
				
				$strresp .= '</div><!-- card-body -->
              </div><!-- card -->
            </div><!-- widget-2 -->
          </div><!-- col-6 -->


          </div><!-- row -->';


				echo $strresp;exit;
			}
		}
	}
	
	
	}