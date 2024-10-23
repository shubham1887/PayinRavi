<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddFund extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
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

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSubmit') == "Submit")
			{
				$txtAmount = trim($this->input->post("txtAmount",TRUE));
				$txtReamrk = $this->input->post("txtReamrk",TRUE);
			    $Amount = intval($txtAmount);
			    $remark  = substr($txtReamrk,0,40);
			    $description = "Add Fund To Admin";
			    $credit_user_id  = 1;
			    $payment_id = 0;
			    $transaction_type = "PAYMENT";
			    $add_date = $this->common->getDate();
			    $ipaddress = $this->common->getRealIpAddr();
			    $payment_type="CASH";
			    $admin_remark = $description;
			    $old_balance = 0;
			    $okd_balance_rslt = $this->db->query("select balance from tblewallet where user_id = 1 order by Id desc limit 1"); 
			    if( $okd_balance_rslt->num_rows() == 1)
			    {
			        $old_balance =  $okd_balance_rslt->row(0)->balance;
			    }
			   
				$current_balance_credit_user_id = $old_balance + $Amount;
				$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark)
				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$Amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$admin_remark));
				
		    	$this->session->set_flashdata('MESSAGEBOXTYPE', "SUCCESS");
				$this->session->set_flashdata('MESSAGEBOX', "Fund Added Successfully");
				redirect("_Admin/addFund");
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
				    $old_balance = 0;
    			    $okd_balance_rslt = $this->db->query("select balance from tblewallet where user_id = 1 order by Id desc limit 1"); 
    			    if( $okd_balance_rslt->num_rows() == 1)
    			    {
    			        $old_balance =  $okd_balance_rslt->row(0)->balance;
    			    }
					$this->view_data['message']  = "";
					$this->view_data["currentbalance"] = $old_balance;
					$this->load->view('_Admin/add_fund_view',$this->view_data);	
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
	        a.Id,a.payment_id,a.credit_amount,a.debit_amount,a.balance,a.description,a.remark,a.add_date as payment_date,a.user_id,a.payment_type,a.transaction_type,
	        cr.businessname as bname,
	        cr.username,
	        cr.usertype_name as usertype
	        from masterpa_archive.tblewallet  a
	        left join masterpa_archive.tblpayment b on a.payment_id = b.payment_id
	        left join tblusers cr on b.cr_user_id = cr.user_id
	        where 
	        a.user_id = ? and 
	        Date(a.add_date) >= ? and 
	        Date(a.add_date) <= ? 
	        order by a.Id desc ";
			$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
			return $rslt;
	    }
	    else
	    {
	        $str_query = "
			select 
			a.Id,
			a.payment_id,
			a.transaction_type,
			a.payment_type,
			a.add_date,
			a.credit_amount,
			a.debit_amount,
			a.balance,
			a.description,
			a.remark,
			cr.businessname as cr_businessname,
			cr.mobile_no as cr_mobile_no,
			cr.usertype_name as cr_usertype_name 
			from 
			tblewallet  a 
			left join tblpayment p on a.payment_id = p.payment_id
			left join tblusers cr on p.cr_user_id = cr.user_id
			left join tblusers dr on p.dr_user_id = dr.user_id
			where 
			a.user_id = '$user_id' and 
			DATE(a.add_date) >= ? and 
			DATE(a.add_date) <= ? and 
			
			if(? != 'ALL',a.payment_type = ? ,true) order by a.Id desc";
			$rslt = $this->db->query($str_query,array($from_date,$to_date,$ddlpaymenttype,$ddlpaymenttype));
			return $rslt;
	    }
			
		
	}
	
	private function gettotalcredit($user_id,$from_date,$to_date,$ddldb)
	{
	
	
		if($ddldb == "LIVE")
		{
			$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
			return $rsltcredit->row(0)->total;
		}
		else
		{
		   
			$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from masterpa_archive.tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
			return $rsltcredit->row(0)->total;
		
		}
		
	}
	private function gettotaldebit($user_id,$from_date,$to_date,$ddldb)
	{
	
	    if($ddldb == "LIVE")
		{
				$rsltcredit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
			return $rsltcredit->row(0)->total;
		}
		else
		{
		   
		    $rsltcredit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from masterpa_archive.tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
			return $rsltcredit->row(0)->total;	
		
		}
		
	}
	public function dataexport()
	{
	   
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
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
				dr.usertype_name  as dr_usertype_name,
				p.businessname as parent_name,
				p.username as parent_username,
				p.mobile_no as parent_mobile,
				p.usertype_name as parent_type
				
        		from masterpa_archive.tblewallet a 
        		left join tblusers b on a.user_id = b.user_id 
        		
        		
				left join masterpa_archive.tblpayment pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				left join tblusers p on cr.parentid = p.user_id
				
				
				
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = 1
				 order by Id";
		        $rslt = $this->db->query($str_query,array($from,$to));
			}
			else
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
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = 1
				 order by Id";
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			
				
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
									"payment_to_UserType" =>$rw->cr_usertype_name, 
										
									"ParentName" =>$rw->parent_name, 
									"ParentId" =>$rw->parent_username, 
									"ParentMobile" =>$rw->parent_mobile,
									"ParentType" =>$rw->parent_type, 	
										
									
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
	public function setvalues()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "";exit;
		}
		$id = $_GET["Id"];
		$val= $_GET["val"];
		$ewinfo = $this->db->query("select Id from tblewallet where payment_id = ?",array($id));
		$field = $_GET["field"];
		
		if($ewinfo->num_rows() >= 1)
		{
			
			if($field == "payment_type")
			{
					
				$this->db->query("update tblewallet set payment_type = ? where payment_id = ?",array($val,$id));
				echo $val;	
			}
			
		}
	}
}