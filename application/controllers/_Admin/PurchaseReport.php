<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseReport extends CI_Controller {
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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
			if($this->input->post('btnSearch') == "Search")
			{
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$this->view_data['pagination'] = NULL;
					
					$this->view_data['message'] =$this->msg;

						$purchase_array = array();
					$rsltapilist = $this->db->query("select Id,api_name 
						from api_configuration 
					        where 
					        (
					        api_name !='Random' or api_name != 'Denomination_wise' or api_name != 'Circle_wise' or api_name != 'STOP' or api_name != 'PENDING'
					        ) 
					        and enable_balance_check = 'yes' ");
					    $i=1;
					    $qmarks = '';
					    $str_rows = $rsltapilist->num_rows();
					    foreach ($rsltapilist->result() as $rwapi) 
					    {
					            $api_name = $rwapi->api_name;
					            $rsltopening = $this->db->query("select * from api_clossingBalance order by Id desc limit 1");
					            if( $rsltopening->num_rows() == 1)
					            {
					            	$opening = $rsltopening->row(0)->$api_name;
					            	$purchase_array[$api_name]["Opening"]	 = $opening;
					            }


					            $totalSale = 0;
					            $rsltsales = $this->db->query("select IFNULL(Sum(Amount),0) as total from mt3_transfer where (Status = 'SUCCESS' or Status = 'PENDING') and API = ? and Date(add_date) = ?",array($api_name,$this->common->getMySqlDate()));
					            if($rsltsales->num_rows() == 1)
					            {
					            	$totalSale += $rsltsales->row(0)->total;
					            }

					            $rsltsales = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where (recharge_status = 'Success' or recharge_status = 'Pending') and ExecuteBy = ? and Date(add_date) = ?",array($api_name,$this->common->getMySqlDate()));
					            if($rsltsales->num_rows() == 1)
					            {
					            	$totalSale += $rsltsales->row(0)->total;
					            }



					            $purchase_array[$api_name]["SALE"]	 = $totalSale;
					            $purchase_array[$api_name]["APINAME"]	 = $api_name;



					    }


					    
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['data_result']  = $purchase_array;
					$this->load->view('_Admin/PurchaseReport_view',$this->view_data);	
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from_date = $to_date  = $this->common->getMySqlDate();
					$this->view_data['pagination'] = NULL;
					
					$this->view_data['message'] =$this->msg;

						$purchase_array = array();
					$rsltapilist = $this->db->query("select Id,api_name 
						from api_configuration 
					        where 
					        (
					        api_name !='Random' or api_name != 'Denomination_wise' or api_name != 'Circle_wise' or api_name != 'STOP' or api_name != 'PENDING'
					        ) 
					        and enable_balance_check = 'yes' ");
					    $i=1;
					    $qmarks = '';
					    $str_rows = $rsltapilist->num_rows();
					    foreach ($rsltapilist->result() as $rwapi) 
					    {
					            $api_name = $rwapi->api_name;
					            $rsltopening = $this->db->query("select * from api_clossingBalance order by Id desc limit 1");
					            if( $rsltopening->num_rows() == 1)
					            {
					            	$opening = $rsltopening->row(0)->$api_name;
					            	$purchase_array[$api_name]["Opening"]	 = $opening;
					            }


					            $totalSale = 0;
					            $rsltsales = $this->db->query("select IFNULL(Sum(Amount),0) as total from mt3_transfer where (Status = 'SUCCESS' or Status = 'PENDING') and API = ? and Date(add_date) = ?",array($api_name,$this->common->getMySqlDate()));
					            if($rsltsales->num_rows() == 1)
					            {
					            	$totalSale += $rsltsales->row(0)->total;
					            }

					            $rsltsales = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where (recharge_status = 'Success' or recharge_status = 'Pending') and ExecuteBy = ? and Date(add_date) = ?",array($api_name,$this->common->getMySqlDate()));
					            if($rsltsales->num_rows() == 1)
					            {
					            	$totalSale += $rsltsales->row(0)->total;
					            }



					            $purchase_array[$api_name]["SALE"]	 = $totalSale;
					            $purchase_array[$api_name]["APINAME"]	 = $api_name;



					    }


					    
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['data_result']  = $purchase_array;
					$this->load->view('_Admin/PurchaseReport_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
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
	
	public function updateadminremark()
	{
	    if(isset($_POST["txtRemark"]) and isset($_POST["hidpaymentid"]))
	    {
	        $ddlbank = $this->input->post("ddlbank");
	        $remark = $this->input->post("txtRemark");
	        $paymentid = $this->input->post("hidpaymentid");
	        $rslt = $this->db->query("select Id,payment_id from tblewallet where Id = ?",array(intval($paymentid)));
	        if($rslt->num_rows() == 1)
	        {
	            $ew_payment_id = $rslt->row(0)->payment_id;
	            $this->db->query("update tblewallet set remark = ?,admin_remark = ? where payment_id = ?",array($ddlbank,$remark,intval($ew_payment_id)));
	            $this->db->query("update tblpayment set remark = ?,bank_remark = ? where payment_id = ?",array($ddlbank,$remark,intval($ew_payment_id)));
	            echo "OK";exit;
	        }
	        else
	        {
	            echo "Some Error Occured";exit;
	        }
	    }
	    else
	    {
	        echo "Input Parameter Missing";exit;
	    }
	}
	
}