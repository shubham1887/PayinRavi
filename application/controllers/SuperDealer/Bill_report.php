<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_report extends CI_Controller {
	
	
	private $msg='';	
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
        //error_reporting(E_ALL);
        //ini_set('display_errors',1);
        //$this->db->db_debug = TRUE;
    }
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}			
		else if($this->input->post('btnSearch'))
		{
			$from = $this->input->post('txtFrom',true);
			$to = $this->input->post('txtTo',true);
			$host_id = $this->session->userdata("SdId");
			
			
		//	echo $fromf."   ".$tof;exit;
			
			$status = $this->input->post('ddlType',true);			
			
			
			$this->view_data['result_all'] = $this->db->query("SELECT a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where Date(a.add_date) >= ? and Date(a.add_date) <= ? and c.host_id = ? order by a.Id desc ",array($from,$to,$host_id));
		
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['type'] =$status;
			$this->load->view('SuperDealer/bill_report_view',$this->view_data);								
		}
	
		else 
		{ 						
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{		
				    $host_id = $this->session->userdata("SdId");
					$from = $this->common->getMySqlDate();
					$to = $from;
					$status = "ALL";
					$user_id = $this->session->userdata('AgentId');			
					
					$this->view_data['result_all'] = $this->db->query("SELECT a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where Date(a.add_date) >= ? and Date(a.add_date) <= ? and c.host_id = ? order by a.Id desc",array($from,$to,$host_id));
					
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =$from;
					$this->view_data['to'] =$to;
					$this->view_data['type'] =$status;
					$this->load->view('SuperDealer/bill_report_view',$this->view_data);		
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
			
			$host_id = $this->session->userdata("SdId");
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			
			$data = array();
			
			
			
				$str_query = "SELECT 
				a.Id,
				a.user_id,
				a.add_date,
				a.service_no,
				a.customer_mobile,
				a.customer_name,
				a.dueamount,
				a.duedate,
				a.billnumber,
				a.billdate,
				a.billperiod,
				a.company_id,
				a.bill_amount,
				a.status,
				a.opr_id,
				a.ipay_id,
				a.charged_amt,
				a.resp_status,
				a.res_code,
				a.debit_amount,
				a.credit_amount,
				a.option1,
				b.company_name,
				c.businessname,c.username,c.mobile_no as AgentMobileNo,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				parent.mobile_no as parent_mobile_no,
    			fos.businessname as fos_businessname,
    			fos.username as fos_username,
    			fos.mobile_no as fos_mobile_no
				FROM `tblbills` a 
				left join tblcompany b on a.company_id = b.company_id
				left join tblusers c on a.user_id = c.user_id
				left join tblusers parent on c.parentid = parent.user_id
				left join tblusers fos on c.fos_id = fos.user_id
				where 
				Date(a.add_date) >= ? and 
				Date(a.add_date) <= ? and
				c.host_id = ?
				order by a.Id";
				
			$rslt = $this->db->query($str_query,array($from,$to,$host_id));
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"Id" => $rw->Id, 
									"add_date" =>$rw->add_date, 
									"AgentMobile" =>$rw->AgentMobileNo, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"service_no" =>$rw->bill_amount, 
									"Amount" =>$rw->dueamount, 
									"dueamount" =>$rw->dueamount, 
									"duedate"=>$rw->duedate, 
									"billnumber"=>$rw->billnumber, 
									"billdate"=>$rw->billdate, 
									"billperiod"=>$rw->billperiod, 
									"customer_mobile" =>$rw->customer_mobile, 
									"customer_name" =>$rw->customer_name, 
									"status"=>$rw->status, 
									"opr_id"=>$rw->opr_id, 
									"ipay_id"=>$rw->ipay_id, 
									"resp_status"=>$rw->resp_status,
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
									
									"ParentName" =>$rw->parent_businessname, 
									"ParentUserId" =>$rw->parent_username, 
									"ParentMobile" =>$rw->parent_mobile_no, 
										
									"FOSName" =>$rw->fos_businessname, 
									"FOSusername" =>$rw->fos_username, 
									"FOSMobileNo" =>$rw->fos_mobile_no, 
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
    $fileName = "billreport From ".$from." To  ".$to.".xls";
    
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