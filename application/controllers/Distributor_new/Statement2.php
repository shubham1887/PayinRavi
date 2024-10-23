<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statement2 extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
		redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	public function pageview()
	{
		$word = "";
		$user_id = $this->session->userdata("DistId");
		
	
		$ddldb  = $this->session->userdata("ddldb");
		$fromdate = $this->session->userdata("FromDate");
	    $todate = $this->session->userdata("ToDate");    
		
		
		//echo $fromdate."   ".$todate."   ".$ddlwallet."   ".$ddldb;exit;
		
		$start_row = $this->uri->segment(4);
	//	echo $start_row;exit;
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		
		$total_row = $this->AccountLedger_getReport_rows($user_id,$fromdate,$todate,$ddldb);
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Retailer/Transaction/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['from'] =$fromdate;
		$this->view_data['to'] =$todate;
		$this->view_data['ddldb'] =$ddldb;
	
		
		$rows = $this->AccountLedger_getReport($user_id,$fromdate,$todate,$ddldb,$start_row,$per_page);
		
		$this->view_data['result_all'] = $rows;
		$this->view_data['message'] =$this->msg;
		$this->load->view('Distributor_new/Statement2_view',$this->view_data);			
	}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if(isset($_POST["txt_frm_date"]) and isset($_POST["txt_to_date"]))
			{
			
				$from = $this->input->post('txt_frm_date',true);
				$to = $this->input->post('txt_to_date',true);
			
    			$ddldb = $this->input->post("ddldb",TRUE);
			    
			    $this->session->set_userdata("FromDate",$from);
			    $this->session->set_userdata("ToDate",$to);
			    $this->session->set_userdata("ddldb",$ddldb);
			    
			    $this->pageview();	
			}					
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				
				$today_date = $this->common->getMySqlDate();
				
			    $this->session->set_userdata("FromDate",$today_date);
			    $this->session->set_userdata("ToDate",$today_date);
			    $this->session->set_userdata("ddldb","LIVE");
			    
			    $this->pageview();		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function SubStateTransaction()
	{
		header('Content-Type: application/json');


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		 $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->Fromdate) and isset($json_obj->Todate))
          {

            $from =  date_format(date_create(trim((string)$json_obj->Fromdate)),'Y-m-d');
            $to =  date_format(date_create(trim((string)$json_obj->Todate)),'Y-m-d');
/*
{"StatusCode":1,"Message":"Success","TotalCredit":240922.330,"TotalDebit":240702.650,
"Data":[
{
"TxnStatus":"Success",
"OrderId1":100589872,
"OrderID":"PAYB2B100589872",
"ServiceType":"Money",
"TxnDate":"03/20/2021",
"TxnTime":"11:19:49",
"OpeningBal":20379.690,
"Debit":"20055.440",
"Credit":"-",
"Amount":20055.440,
"ClosingBal":324.250,
"Provider":"R Money 5001-25000",
"NarrationText":"Number: 9004822166 |R Money 5001-25000| Amount: 19,999.00 | Comm Per.: 00.88 | Comm Val.: 00.00 | Charg Per.: 01.00 | Charg Val.: 00.00 Ref Id = PAYB2B100589872 | GST: 26.85 | TDS: 05.59","TxnType":"Debit","UserDetails":"8080801887-sai"
}]}
*/
		$str_query ="
				select 
				b.recharge_status as TxnStatus,
				b.recharge_id as OrderId1,
				a.Id as OrderID,

				CASE a.transaction_type 
				  	WHEN 'PAYMENT' THEN 'PAYMENT'
				 	ELSE 'OTHER'
				END as ServiceType,
				CONCAT(u.businessname,'~',u.username) as  UserDetails,

				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBal,
				a.debit_amount as Debit,
				a.credit_amount as Credit,
				a.balance as ClosingBal,
				c.company_name as Provider,

				a.description as NarrationText
				from tblewallet2 a
				left join tblrecharge b on a.recharge_id = b.recharge_id
				left join tblcompany c on b.company_id = c.company_id
				left join tblusers u on a.user_id = u.user_id 

				


				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=?  
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("DistId")));
				

				if($result->num_rows() > 0)
				{
					$Credit = 0;
					$Debit = 0;
					$summary_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as Credit,IFNULL(Sum(debit_amount),0) as Debit from tblewallet2 where transaction_type = 'PAYMENT' and user_id = ? and Date(add_date) BETWEEN ? and ? order by Id",array($this->session->userdata("DistId"),$from,$to));
					if($summary_rslt->num_rows() == 1)
					{
						$Credit = $summary_rslt->row(0)->Credit;
						$Debit = $summary_rslt->row(0)->Debit;
					}

						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"TotalCredit"=>round($Credit,2),
							"TotalDebit"=>round($Debit,2),
							"Data"=>$result->result()
					);
					echo json_encode($resp_array);exit;
				}
				else
				{
					$resp_array = array(
						"StatusCode"=>2,
						"Message"=>"Data Not Found.",
						"TotalCredit"=>0,
						"TotalDebit"=>0,
						"Data"=>null
					);
					echo json_encode($resp_array);exit;
				}



		
	}
	}


	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddldb,$start_row,$per_page)
	{
	    
	      
    		//echo $from_date."   ".$to_date;exit;
    		  
    			$str_query = "
    			select 
				b.recharge_status as TxnStatus,
				b.recharge_id as OrderId1,
				a.Id as OrderID,

				CASE a.transaction_type 
				  	WHEN 'PAYMENT' THEN 'PAYMENT'
				 	ELSE 'OTHER'
				END as ServiceType,
				CONCAT(u.businessname,'~',u.username) as  UserDetails,

				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBal,
				a.debit_amount as Debit,
				a.credit_amount as Credit,
				a.balance as ClosingBal,
				c.company_name as Provider,
				a.description as NarrationText
				from tblewallet2 a
				left join tblrecharge b on a.recharge_id = b.recharge_id
				left join tblcompany c on b.company_id = c.company_id
				left join tblusers u on a.user_id = u.user_id 
				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=?  
				order by a.Id  limit ?,? ";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date,intval($start_row),intval($per_page)));
        	
        		return $rslt;
    		
	    
		
	}
	private function AccountLedger_getReport_rows($user_id,$from_date,$to_date,$ddldb)
	{
	    
	   
	      
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from tblewallet2 a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		  
	    
		
	}
	public function StatementExport()
	{
	   
	
		if(isset($_GET["fromDate"]) and isset($_GET["toDate"]))
		{
		    error_reporting(-1);
		    ini_set('display_errors',1);
		    $this->db->db_debug = TRUE;
			ini_set('memory_limit', '-1');
			$from = date_format(date_create(trim($_GET["fromDate"])),'Y-m-d');
			$to = date_format(date_create(trim($_GET["toDate"])),'Y-m-d');
			$userName = trim($_GET["userName"]);
		
			$data = array();
			
		
		
			    $str_query = "select 

				CASE a.transaction_type
				  	WHEN 'BILL' THEN UPPER(bill.status)
				  	WHEN 'DMR' THEN b.Status
				  	WHEN 'PAYMENT' THEN 'PAYMENT'
				 	ELSE ''
				END as TxnStatus,
				b.Id as OrderId1,
				a.Id as OrderID,
				a.transaction_type as ServiceType,
				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBal,
				a.debit_amount as Debit,
				a.credit_amount as Credit,
				a.balance as ClosingBal,
				b.RemiterMobile as Provider,
				a.description as NarrationText
				from tblewallet2 a
				left join mt3_transfer b on a.dmr_id = b.Id
				left join tblbills bill on a.bill_id = bill.Id
				left join tblusers u on a.user_id = u.user_id 
				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=?  
				order by a.Id desc";
		$rslt = $this->db->query($str_query,array($this->session->userdata("DistId"),$from,$to));
			
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"add_date" => date_format(date_create($rw->add_date),'d-m-Y h:i:s A'), 
								    "Description" =>$rw->description, 
									"Remark" =>$rw->remark,
								    "CreditAmount" => $rw->credit_amount, 
									"DebitAmount" =>$rw->debit_amount, 
									"Balance" =>$rw->balance, 
									
								);
					
					
					
					array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "Account Ledger Report From ".$from." To  ".$to.".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";
    }
    
    exit;				
		}
		else
		{
			echo "parameter missing";exit;
		}
	}
}