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
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{
				
					$today_date = $this->common->getMySqlDate();
					
				    $this->session->set_userdata("FromDate",$today_date);
				    $this->session->set_userdata("ToDate",$today_date);
				    $this->session->set_userdata("ddldb","LIVE");
			    
			    	$this->view_data['result_all'] = "";
					$this->view_data['message'] =$this->msg;
					$this->load->view('SuperDealer_new/Statement2_view',$this->view_data);			
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
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("SdId")));
				

				if($result->num_rows() > 0)
				{
						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"Total"=>0,
							"Success"=>0,
							"Pending"=>0,
							"Failure"=>0,
							"Reversal"=>0,
							"Data"=>$result->result()
					);
					echo json_encode($resp_array);exit;
				}
				else
				{
					$resp_array = array(
			"StatusCode"=>2,
			"Message"=>"Data Not Found.",
			"Total"=>0,
			"Success"=>0,
			"Pending"=>0,
			"Failure"=>0,
			"Reversal"=>0,
			"Data"=>null
		);
		echo json_encode($resp_array);exit;
				}



		
	}
	}


	
	public function dataexport()
	{
	   
	
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
		    error_reporting(-1);
		    ini_set('display_errors',1);
		    $this->db->db_debug = TRUE;
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
		
			$data = array();
			
		
		
			    $str_query = "select 
		
        		a.Id,
        		a.add_date,
        		a.description,
        		a.remark,
        		a.credit_amount,
        		a.debit_amount,
        		a.balance,
        		a.payment_id,
        		a.user_id,
				pay.cr_user_id,
				pay.dr_user_id,
				cr.businessname as cr_businessname,
				cr.username as cr_username,
				cr.usertype_name  as cr_usertype_name,
				dr.businessname as dr_businessname,
				dr.username as dr_username,
				dr.usertype_name  as dr_usertype_name,
				p.businessname as parent_name,
				p.username as parent_username,
				p.mobile_no as parent_mobile,
				p.usertype_name as parent_type
				
        		from tblewallet a 
        		left join tblusers b on a.user_id = b.user_id 
        		
        		
				left join tblpayment pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				left join tblusers p on cr.parentid = p.user_id
				
				
				
				 where 
				 a.user_id = ? and
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				 order by Id";
		$rslt = $this->db->query($str_query,array($this->session->userdata("SdId"),$from,$to));
			
			
				
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