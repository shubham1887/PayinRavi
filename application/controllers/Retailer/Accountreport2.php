<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountreport2 extends CI_Controller {
	
	
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

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
			
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddlpaymenttype = $this->input->post("ddlpaymenttype",TRUE);
				//echo $ddlpaymenttype;exit;
				$user_id = $this->session->userdata("AgentId");
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($this->session->userdata("AgentId"),$from_date,$to_date,$ddlpaymenttype);
				$this->view_data['message'] =$this->msg;
				
				$rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ?",array($this->session->userdata("AgentId"),$from_date,$to_date));
				$this->view_data['totalcredit'] =$this->gettotalcredit($user_id,$from_date,$to_date);
				$this->view_data['totaldebit'] =$this->gettotaldebit($user_id,$from_date,$to_date);
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['ddlpaymenttype']  = $ddlpaymenttype;
				$this->load->view('Retailer/accountreport2_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{
				$from_date = $to_date  = $this->common->getMySqlDate();

				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($this->session->userdata("AgentId"),$from_date,$to_date,"ALL");
				$this->view_data['message'] =$this->msg;
				$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
				$rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
				$this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
				$this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['ddlpaymenttype']  = "ALL";
				$this->load->view('Retailer/accountreport2_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddlpaymenttype)
	{
	
	
			$str_query = "select a.Id,
        		a.add_date,
        		a.description,
        		a.remark,
        		a.credit_amount,
        		a.debit_amount,
        		a.balance,
        		a.payment_id,
        		a.transaction_type,
        		a.user_id,
				pay.cr_user_id,
				pay.dr_user_id,
				cr.businessname as cr_businessname,
				cr.username as cr_username,
				cr.usertype_name  as cr_usertype_name,
				dr.businessname as dr_businessname,
				dr.username as dr_username,
				dr.usertype_name  as dr_usertype_name
				
        		from tblewallet2 a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblpayment2 pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				
				
				
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				 order by Id";
			$rslt = $this->db->query($str_query,array($from_date,$to_date,$user_id));
		//	print_r($rslt->num_rows());exit;
			return $rslt;
		
	}
	
	private function gettotalcredit($user_id,$from_date,$to_date)
	{
	
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from_date <= $archivdate and $to_date <= $archivdate)
		{
	
			$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from gofullrc_archiv.tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
			return $rsltcredit->row(0)->total;	

		}
		else if($from_date <= $archivdate and $to_date > $archivdate)
		{
		}
		else if($from_date > $archivdate and $to_date > $archivdate)
		{
			$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
			return $rsltcredit->row(0)->total;
		}
		
	}
	private function gettotaldebit($user_id,$from_date,$to_date)
	{
	
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from_date <= $archivdate and $to_date <= $archivdate)
		{
	
			$rsltcredit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from gofullrc_archiv.tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
			return $rsltcredit->row(0)->total;	

		}
		else if($from_date <= $archivdate and $to_date > $archivdate)
		{
		}
		else if($from_date > $archivdate and $to_date > $archivdate)
		{
			$rsltcredit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($this->session->userdata("AgentId"),$from_date,$to_date));
			return $rsltcredit->row(0)->total;
		}
		
	}
	public function dataexport()
	{
	   
	
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
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
				dr.usertype_name  as dr_usertype_name
				
        		from tblewallet2 a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblpayment pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				
				
				
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				 order by Id";
		$rslt = $this->db->query($str_query,array($from,$to,$this->session->userdata("AgentId")));
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"payment_id" => $rw->payment_id, 
									"add_date" => $rw->add_date, 
									"payment_from" =>$rw->dr_businessname, 
									"payment_from_UserId" =>$rw->dr_username, 
								
									"blank"=>"",
									"payment_to" =>$rw->cr_businessname, 
									"payment_to_UserId" =>$rw->cr_username, 
										
									"blank2"=>"",
									"CreditAmount" => $rw->credit_amount, 
									"DebitAmount" =>$rw->debit_amount, 
									"Balance" =>$rw->balance, 
									"Description" =>$rw->description, 
									"Remark" =>$rw->remark, 
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