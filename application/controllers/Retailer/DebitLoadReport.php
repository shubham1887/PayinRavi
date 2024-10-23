<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DebitLoadReport extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
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
		
		
		$this->view_data['result_all'] = "";
		$this->view_data['message'] ="";
		$this->load->view('Retailer/DebitLoadReport_view',$this->view_data);			
	}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
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
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
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
	public function SubPaymentLoad()
	{
		header('Content-Type: application/json');


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		 $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->fromDate) and isset($json_obj->toDate))
          {

            $from =  date_format(date_create(trim((string)$json_obj->fromDate)),'Y-m-d');
            $to =  date_format(date_create(trim((string)$json_obj->toDate)),'Y-m-d');
/*
		{"StatusCode":1,"Message":"Success","TotalAmount":225860.000,
		"Data":[
		{
			"OrderId1":0,
			"OrderID":"1760808",
			"TransactionType":"Credit",
			"CreditUser":"8080801887-sai-sai prasad",
			"DebitUser":"7666075076-peher-sai prasad",
			"TxnDate":"20-03-2021",
			"TxnTime":"11:19:23",
			"OpeningBalance":20179.690,
			"Amount":200.000,
			"ClosingBalnce":20379.690,
			"PaymentType":"Credit",
			"remarks":"Balance transfer from:7666075076-peher-sai prasad To:8080801887-sai-sai prasad ##d"}
			]}
		*/
		$str_query ="
				select 
				'0' as OrderId1,
				a.Id as OrderID,
				'Credit' as TransactionType,
				CONCAT_WS('-', cr.username, cr.businessname) as CreditUser,
				CONCAT_WS('-', dr.username, dr.businessname) as DebitUser,
				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBalance,
				

				CASE
			        WHEN a.credit_amount > 0 THEN a.credit_amount
			        WHEN a.debit_amount > 0 THEN a.debit_amount
			        ELSE 0
			    END AS Amount,

				
				a.balance as ClosingBalnce,
				a.payment_type as PaymentType,
				CONCAT_WS('-', a.description, a.remark) as remarks
				from tblewallet a
				left join tblpayment2 p on a.payment_id = p.payment_id
				left join tblusers cr on p.cr_user_id = cr.user_id 
				left join tblusers dr on p.dr_user_id = dr.user_id 
				where 
				a.debit_amount > 0 and
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=? and
				a.transaction_type = 'DEBIT' 
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("AgentId")));
				

				if($result->num_rows() > 0)
				{
					$totalDebit = 0;
					$rsltsummary = $this->db->query("select IFNULL(Sum(a.debit_amount),0) as totalDebit from tblewallet a where a.user_id = ? and a.transaction_type = 'PAYMENT' and Date(a.add_date) BETWEEN ? and ?",array($this->session->userdata("AgentId"),$from,$to));
					if($rsltsummary->num_rows() == 1)
					{
						$totalDebit = round($rsltsummary->row(0)->totalDebit,2);
					}


						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"TotalAmount"=>$totalDebit,
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
	   
	
		if(isset($_GET["fromDate"]) and isset($_GET["toDate"]))
		{
		    error_reporting(-1);
		    ini_set('display_errors',1);
		    $this->db->db_debug = TRUE;
			ini_set('memory_limit', '-1');
			$from = date_format(date_create(trim($_GET["fromDate"])),'Y-m-d');
			$to = date_format(date_create(trim($_GET["toDate"])),'Y-m-d');
		
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
				 a.transaction_type = 'PAYMENT' and
				 a.debit_amount > 0 and
				 a.user_id = ? and
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				 order by Id";
		$rslt = $this->db->query($str_query,array($this->session->userdata("AgentId"),$from,$to));
			
			
				
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
    $fileName = "Debit Load Report From ".$from." To  ".$to.".xls";
    
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