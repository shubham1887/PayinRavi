<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_report extends CI_Controller {
	
	
	private $msg='';	
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 			
		else if($this->input->post('btnSearch'))
		{
			$from = $this->input->post('txtFrom',true);
			$date = str_replace('/', '-', $from);
			$fromf = date_format(date_create($date),'Y-m-d');
			//$fromf = date_format(date_create($from),'Y-m-d');
			
			
			
			$to = $this->input->post('txtTo',true);
			$date_to = str_replace('/', '-', $to);
			$tof = date_format(date_create($date_to),'Y-m-d');
			
			
		//	echo $fromf."   ".$tof;exit;
			$ddldb = $this->input->post('ddldb',true);
			$status = $this->input->post('ddlType',true);
			$txtUserId = $this->input->post('txtUserId',true);
			$user_id = $this->session->userdata('MdId');			
			
			
    		 
    			    $this->view_data['result_all'] = $this->db->query("
    			SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
    a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
    a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
    a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock
    
    
    FROM `mt3_transfer` a where a.user_id = ? and 
    Date(a.add_date) >= ? and 
    Date(a.add_date) <= ? and
    if( ? != '',(a.RemiterMobile = ? or a.AccountNumber = ?),true)
    order by Id desc",array($user_id,$fromf,$tof,$txtUserId,$txtUserId,$txtUserId));
    			
    		
			
			
			
			
		
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['type'] =$status;
			$this->view_data['txtUserId'] =$txtUserId;
			$this->view_data['ddldb'] =$ddldb;
			$this->load->view('MasterDealer/dmr_report_view',$this->view_data);								
		}
		else 
		{ 						
				$user=$this->session->userdata('MdUserType');
				if(trim($user) == 'MasterDealer')
				{										
					$from = date_format(date_create($this->common->getMySqlDate()),'d/m/Y');
					$date = str_replace('/', '-', $from);
					$fromf = date_format(date_create($date),'Y-m-d');
					$to = $from;
					$tof = $fromf;
					$status = "ALL";
					$ddldb =  "LIVE";
					$user_id = $this->session->userdata('MdId');			
				    
    				    $this->view_data['result_all'] = $this->db->query("SELECT a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
    a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
    a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
    a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock
    
    
    FROM `mt3_transfer` a where a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc",array($user_id,$fromf,$tof));
    				
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =$from;
					$this->view_data['to'] =$to;
					$this->view_data['type'] =$status;
					$this->view_data['txtUserId'] ="";
					$this->view_data['ddldb'] =$ddldb;
					$this->load->view('MasterDealer/dmr_report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
		
	}	


	public function dataexport()
	{
	   
		
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$date = str_replace('/', '-', $from);
			$fromf = date_format(date_create($date),'Y-m-d');
			
			
			
			$to = trim($_GET["to"]);
			$date_to = str_replace('/', '-', $to);
			$tof = date_format(date_create($date_to),'Y-m-d');
			
			$data = array();
			
			
			
			$rslt = $this->db->query("SELECT 
			(select 'RetailerExport') as act,
			a.ccf,a.cashback,a.tds,
			a.unique_id,
			a.Id,
			a.add_date,
			a.ipaddress,
			a.user_id,
			a.DId,
			a.MdId,
			a.Charge_type,
			a.charge_value,
			a.Charge_Amount,
			a.RemiterMobile,
			a.debit_amount,
			a.credit_amount,
			a.remitter_id,
			a.BeneficiaryId,
			a.AccountNumber,
			a.IFSC,
			a.Amount,
			a.Status,
			a.debited, 
			a.ewallet_id,
			a.balance,
			a.remark,
			a.mode,
			a.RESP_statuscode,
			a.RESP_status,
			a.RESP_ipay_id,
			a.RESP_ref_no,
			a.RESP_opr_id,
			a.RESP_name,
			a.RESP_opening_bal,
			b.businessname,
			b.username,
			b.mobile_no,
			parent.businessname as parent_businessname,
			parent.username as parent_username,
			parent.mobile_no as parent_mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where Date(a.add_date) >= ? and Date(a.add_date) <= ?  and a.user_id = ?
 
 order by Id desc",array($fromf,$tof,$this->session->userdata("MdId")));
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"unique_id" => $rw->unique_id, 
									"Id" => $rw->Id, 
									"add_date" =>$rw->add_date, 
									
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"AgentMobileNo" =>$rw->mobile_no, 
									
				
									"RESP_name" =>$rw->RESP_name, 
									"AccountNumber" =>$rw->AccountNumber, 
									"IFSC" =>$rw->IFSC, 
									"mode" =>$rw->mode, 
									"Amount" =>$rw->Amount, 
									"Status" =>$rw->Status, 
									"CCF"=>$rw->ccf,
									"Cashback"=>$rw->cashback,
									"TDS"=>$rw->tds,
									"Charge_Amount" =>$rw->Charge_Amount, 
									"RemiterMobile" =>$rw->RemiterMobile, 
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
									"RESP_ref_no" =>$rw->RESP_ref_no, 
									"RESP_opr_id" =>$rw->RESP_opr_id, 
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
    $fileName = "DMR REPORT From ".$from." To  ".$to.".xls";
    
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