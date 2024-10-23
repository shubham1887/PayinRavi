<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downline_dmt_report extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			$this->view_data['pagination'] = "";
			$this->view_data['from'] ="";
			$this->view_data['to'] ="";
			$this->view_data['ddldb'] ="LIVE";
		
			
			
			$this->view_data['result_all'] = false;
			$this->view_data['message'] =$this->msg;
			$this->load->view('SuperDealer_new/Downline_dmt_report_view',$this->view_data);	
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
				a.Id,
				a.add_date,
				a.unique_id,
				a.user_id,
				a.DId,
				a.SdId,
				a.Charge_Amount,
				a.RemiterMobile,
				a.debit_amount,
				a.credit_amount,
				a.AccountNumber,
				a.IFSC,

				a.Amount,
				a.Status,
				a.RESP_opr_id,
				a.RESP_name,
				a.done_by,

				a.ccf,
				a.cashback,
				a.tds,
				a.gst,

				u.username,
				u.usertype_name,
				u.businessname
				from mt3_transfer a
				left join tblusers u on a.user_id = u.user_id 

				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				u.parentid=?  
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("SdId")));
				

				if($result->num_rows() > 0)
				{
					
					$rslt_sf = $this->db->query("SELECT 
										a.Status,
										Sum(a.Amount) as total,
										Sum(a.Charge_Amount) as total_charge,
										Sum(a.dist_charge_amount) as dist_charge_amount
										FROM mt3_transfer a 
										left join tblusers u on a.user_id = u.user_id 
										where 
										u.parentid = ? and
										Date(a.add_date) >= ? and  Date(a.add_date) <= ?
										 group by a.Status ",array($this->session->userdata("SdId"),$from,$to));
		
		
					
					$totalsuccess = 0;
					$totalfailure = 0;
					$totalpending = 0;
					
					$total_retailercomm = 0;
					$total_dcomm = 0;
					
					if($rslt_sf->num_rows() > 0)
					{
						foreach($rslt_sf->result() as $row)
						{
							if($row->Status == "SUCCESS")
							{
								$totalsuccess = $row->total;
								$total_retailercomm = $row->total_charge;
								$total_dcomm = $row->dist_charge_amount;
							
							}
							if($row->Status == "FAILURE")
							{
								$totalfailure = $row->total;	
							}
							if($row->Status == "PENDING")
							{
								$totalpending = $row->total;	
							}
						}
				
					}


					$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"TotalSuccess"=>round($totalsuccess,2),
							"TotalPending"=>round($totalpending,2),
							"TotalFailure"=>round($totalfailure,2),
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
			
		
			$data = array();
			
		
		
			    $str_query ="
				select 
				a.Id,
				a.add_date,
				a.unique_id,
				a.user_id,
				a.DId,
				a.SdId,
				a.Charge_Amount,
				a.RemiterMobile,
				a.debit_amount,
				a.credit_amount,
				a.AccountNumber,
				a.IFSC,

				a.Amount,
				a.Status,
				a.RESP_opr_id,
				a.RESP_name,
				a.done_by,

				a.ccf,
				a.cashback,
				a.tds,
				a.gst,

				u.username,
				u.usertype_name,
				u.businessname
				from mt3_transfer a
				left join tblusers u on a.user_id = u.user_id 

				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				u.parentid=?  
				order by a.Id desc";		
				$rslt = $this->db->query($str_query,array($from,$to,$this->session->userdata("SdId")));
			
				
		$i = 1;
		foreach($rslt->result() as $rw)
		{
			$temparray = array(
			
						"Sr" =>  $i, 

						"AgentName" =>$rw->businessname, 
						"AgentId" =>$rw->username, 

						"add_date" => date_format(date_create($rw->add_date),'d-m-Y h:i:s A'), 
					    "DmtId" =>$rw->Id, 
						"UniqueId" =>$rw->unique_id,
					    "BeneficiaryName" => $rw->RESP_name, 
						"AccountNumber" =>$rw->AccountNumber, 
						"IFSC" =>$rw->IFSC, 
						"Amount" =>$rw->Amount, 
						"TransactionCharge" =>$rw->Charge_Amount, 
						"Status" =>$rw->Status, 
						"DoneBy" =>$rw->done_by, 
						"BankRefNum" =>$rw->RESP_opr_id, 
						"DebitAmount" =>$rw->debit_amount, 
						"CreditAmount" =>$rw->credit_amount, 
						
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
    $fileName = "DMT Report From ".$from." To  ".$to.".xls";
    
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