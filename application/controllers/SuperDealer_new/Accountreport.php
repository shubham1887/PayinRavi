<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountreport extends My_Controller {
	
	
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
	public function pageview()
	{
		$word = "";
		$user_id = $this->session->userdata("SdId");
		
	
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
		$config['base_url'] = base_url()."SuperDealer_new/accountreport/pageview";
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
		$this->load->view('SuperDealer_new/accountreport_view',$this->view_data);			
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
			    
			    $this->pageview();		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddldb,$start_row,$per_page)
	{
	    
	      
    		//echo $from_date."   ".$to_date;exit;
    		  
    			$str_query = "
    			select 
    			a.Id,
    			a.payment_id,
    			a.recharge_id,
    			a.transaction_type,
    			a.payment_type,
    			a.credit_amount,
    			a.debit_amount,
    			a.balance,
    			a.description,
    			a.dmr_id,
    			a.bill_id,
    			a.remark,
    			a.add_date,
    			cr.businessname as cr_businessname,
    			cr.username as cr_username,
    			cr.mobile_no as cr_mobile_no,
    			cr.usertype_name as cr_usertype_name,
    			dr.businessname as dr_businessname,
    			dr.username as dr_username,
    			dr.mobile_no as dr_mobile_no,
    			dr.usertype_name as dr_usertype_name
    			from tblewallet a 
    			left join tblpayment pay on a.payment_id = pay.payment_id
    			left join tblusers cr on pay.cr_user_id = cr.user_id
    			left join tblusers dr on pay.dr_user_id = dr.user_id
    			where 
    		
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc limit ?,? ";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date,intval($start_row),intval($per_page)));
        	
        		return $rslt;
    		
	    
		
	}
	private function AccountLedger_getReport_rows($user_id,$from_date,$to_date,$ddldb)
	{
	    
	   
	      
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from tblewallet a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		  
	    
		
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