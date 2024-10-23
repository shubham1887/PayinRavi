<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_report2 extends CI_Controller {
	
	 
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
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

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}			
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
				// error_reporting(-1);
				// ini_set('display_errors',1);
				// $this->db->db_debug = TRUE;
				$user_id = $this->session->userdata("ApiId");
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddldb = $this->input->post("ddldb",TRUE);
				$ddlpaymenttype = $this->input->post("ddlpaymenttype",TRUE);
			
				$this->view_data['pagination'] = NULL;
				
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date,$ddlpaymenttype,$ddldb);
				$this->view_data['message'] =$this->msg;
				
				$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ?",array($user_id,$from_date,$to_date));
				$rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($user_id,$from_date,$to_date));
				$this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
				$this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['ddldb']  = $ddldb;
				$this->view_data['ddlpaymenttype']  = $ddlpaymenttype;
				$this->load->view('API/account_report2_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{
					$user_id = $this->session->userdata("ApiId");
					$from_date = $to_date  = $this->common->getMySqlDate();
					$this->view_data['pagination'] = NULL;
					$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date,"ALL","LIVE");
					$this->view_data['message'] =$this->msg;
					$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ?",array($user_id,$from_date,$to_date));
					$rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet2 where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array($user_id,$from_date,$to_date));
					$this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
					$this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['ddldb']  = "LIVE";
					$this->view_data['ddlpaymenttype']  = "ALL";
					$this->load->view('API/account_report2_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddlpaymenttype,$ddldb)
	{
	
	    if($ddldb == "ARCHIVE")
	    {
	        
	        $str_query = "select 
	        a.Id,a.payment_id,a.credit_amount,a.debit_amount,a.balance,a.description,a.remark,a.add_date as payment_date,a.user_id,a.transaction_type,
	        cr.businessname as bname,
	        cr.username,
	        cr.usertype_name as usertype
	        from masterpa_archive.tblewallet2  a
	        left join masterpa_archive.tblpayment b on a.payment_id = b.payment_id
	        left join tblusers cr on b.cr_user_id = cr.user_id
	        where 
	        a.user_id = ? and 
	        Date(a.add_date) >= ? and 
			Date(a.add_date) <= ?  and
			if( ? != 'ALL',a.transaction_type = ?,true)
	        order by a.Id desc ";
			$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date,$ddlpaymenttype,$ddlpaymenttype));
			return $rslt;
	    }
	    else
	    {
	        $str_query = "
			select 
			a.Id,
			a.payment_id,
			a.transaction_type,
			a.add_date,
			a.credit_amount,
			a.debit_amount,
			a.balance,
			a.description,
			a.remark,
			b.businessname,
			b.mobile_no,
			b.usertype_name 
			from 
			tblewallet2  a 
			left join tblusers b on a.user_id = b.user_id
			where 
			a.user_id = '$user_id' and 
			DATE(a.add_date) >= ? and 
			DATE(a.add_date) <= ? and 
			if(? != 'ALL',a.transaction_type = ? ,true) order by a.Id desc";
			$rslt = $this->db->query($str_query,array($from_date,$to_date,$ddlpaymenttype,$ddlpaymenttype));
			return $rslt;
	    }
			
		
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
	
	public function dataexport()
	{
	   
		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$user_id = $this->session->userdata("ApiId");
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			
			$data = array();
			
			if($db == "ARCHIVE")
			{
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
				
        		from masterpa_archive.tblewallet2 a 
        		left join tblusers b on a.user_id = b.user_id 
        		
        		
				left join masterpa_archive.tblpayment pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				left join tblusers p on cr.parentid = p.user_id
				
				
				
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				 order by Id";
		        $rslt = $this->db->query($str_query,array($from,$to,$user_id));
			}
			else
			{
			    $str_query = "select 
		
        		a.Id,
				a.dmr_id,
        		a.add_date,
        		a.description,
        		a.remark,
        		a.credit_amount,
        		a.debit_amount,
        		a.balance,
        		a.payment_id,
				a.transaction_type,
        		a.user_id
        		from tblewallet2 a 
        		left join tblusers b on a.user_id = b.user_id 
        		
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				 order by Id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			$company_name = "";
			$mobile = "";
			$amount = "";
			$description = $rw->description;
			if (preg_match('/Refund :/',$rw->description) == 1 ) 
			{
					//Refund : Mobile : 7354585761 Amount : 49 | Revert Date = 202
				$company_name = "";
				$mobile = $this->get_string_between($description, "Mobile : ", " Amount");
				$amount = $this->get_string_between($description, "Amount : ", " | Revert");
			}
			else if ($rw->transaction_type == "Recharge" ) 
			{
					//Vodafone | 7354585761 | 49 | Id = 314590
				$recarr = explode("|", $description);
				$company_name =  $recarr[0];
				$mobile = $recarr[1];
				$amount = $recarr[2];
			}



			
			$temparray = array(
			
									"Sr" =>  $i, 
									"DmtId" => $rw->dmr_id, 
									"add_date" => $rw->add_date, 
									"TransactionType" =>$rw->transaction_type, 
									"OperatorName" =>$company_name, 	
									"Mobile_Number" =>$mobile, 	
									"Amount" =>$amount, 	
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