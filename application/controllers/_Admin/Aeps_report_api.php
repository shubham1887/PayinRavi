<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Aeps_report_api extends CI_Controller {
	private $msg='';public $perpage;
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();

        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;


		$this->perpage=25;
				//redirect("http://mastermoney.in/ApiLogout");exit;
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
		 	
		  
			$_page=$this->input->post('page',TRUE)?intval($this->input->post('page',TRUE)):1;
			$_limit_data=$this->perpage;$_start_data=0;$_total_page=1;
			if($_page>1){
				$_start_data = ($_limit_data * $_page) - $_limit_data;
			}
			 
			if($this->input->post('btnSearch') == "Search")
			{
				$from = $this->input->post("txtFrom",TRUE);
				$to = $this->input->post("txtTo",TRUE);
				$company_id = intval($this->input->post("ddloperator",TRUE));
				$status = $this->input->post("ddlstatus",TRUE);
				$Mobile = $this->input->post("txtNumId",TRUE);
				$ddltype = $this->input->post("ddltype",TRUE);
				
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_recharge'] = $this->db->query("
						SELECT 
						SQL_CALC_FOUND_ROWS
						a.Id, a.token, a.outlet_id, a.amount, a.aadhaar_uid, a.bankiin, a.latitude, a.longitude, a.mobile, a.agent_id, a.sp_key, a.pidData, a.pidDataType, a.ci, a.dc, a.dpId, a.errCode, a.errInfo, a.fCount, a.tType, a.hmac, a.iCount, a.mc, a.mi, a.nmPoints, a.pCount, a.pType, a.qScore, a.rdsId, a.rdsVer, a.sessionKey, a.srno, a.user_agent, a.add_date, a.ipaddress, a.user_id, a.usertoken_id, a.resp_statuscode, a.resp_status, a.resp_opening_bal, a.resp_ipay_id, a.resp_amount, a.resp_amount_txn, a.resp_account_no, a.resp_txn_mode, a.resp_txn_status, a.resp_opr_id, a.resp_balance, a.resp_timestamp, a.resp_ipay_uuid, a.resp_orderid, a.resp_environment, a.credit_amount, a.debit_amount, a.Commission, a.ChargeAmount, a.tds,
							b.businessname 
						FROM aeps_request a
						left join tblusers b on a.user_id = b.user_id
				where 
				Date(a.add_date) BETWEEN ? and ? and
				if(? != 'ALL',a.sp_key = ?,true)

				order by a.Id desc limit ?,? ",array($from,$to,$ddltype,$ddltype,intval($_start_data),intval($this->perpage)));


				$query = $this->db->query('SELECT FOUND_ROWS() AS TotalCount');
					$_total_records = $query->row()->TotalCount;
				if($_total_records>$this->perpage)
				{
					$_total_page=ceil($_total_records/$this->perpage);
				}
					
					$this->view_data['page'] =$_page;
					$this->view_data['total_page'] =$_total_page;
					$this->view_data['message'] =$this->msg;
					$this->view_data['ddlstatus'] =$status;
					$this->view_data['ddloperator'] = $company_id;
					$this->view_data['from'] =$from;
					$this->view_data['to'] =$to;
					$this->view_data['ddldb'] ="LIVE";
					$this->view_data['ddltype'] = $ddltype;
					
					$this->view_data['txtNumId'] =$Mobile;
					
					$this->view_data["summary_array"] = $this->getTotalValues($from,$to);
					$this->load->view('_Admin/Aeps_report_api_view',$this->view_data);	
			}
			else
			{
			
				$from = $to = $this->common->getMySqlDate();
				$ddldb = "LIVE";
				$this->view_data['pagination'] = NULL;
				
				
				$this->view_data['result_recharge'] = $this->db->query("
					SELECT 
					SQL_CALC_FOUND_ROWS
					a.Id, a.token, a.outlet_id, a.amount, a.aadhaar_uid, a.bankiin, a.latitude, a.longitude, a.mobile, a.agent_id, a.sp_key, a.pidData, a.pidDataType, a.ci, a.dc, a.dpId, a.errCode, a.errInfo, a.fCount, a.tType, a.hmac, a.iCount, a.mc, a.mi, a.nmPoints, a.pCount, a.pType, a.qScore, a.rdsId, a.rdsVer, a.sessionKey, a.srno, a.user_agent, a.add_date, a.ipaddress, a.user_id, a.usertoken_id, a.resp_statuscode, a.resp_status, a.resp_opening_bal, a.resp_ipay_id, a.resp_amount, a.resp_amount_txn, a.resp_account_no, a.resp_txn_mode, a.resp_txn_status, a.resp_opr_id, a.resp_balance, a.resp_timestamp, a.resp_ipay_uuid, a.resp_orderid, a.resp_environment, a.credit_amount, a.debit_amount, a.Commission, a.ChargeAmount, a.tds,
						b.businessname
					FROM aeps_request a
					left join tblusers b on a.user_id = b.user_id
			where 
			a.sp_key = 'WAP' and
			
			Date(a.add_date) BETWEEN ? and ?
			order by a.Id desc limit ?,? ",array($from,$to,intval($_start_data),intval($this->perpage)));

			
			$query = $this->db->query('SELECT FOUND_ROWS() AS TotalCount');
				$_total_records = $query->row()->TotalCount;
				if($_total_records>$this->perpage){
					$_total_page=ceil($_total_records/$this->perpage);
				}
				
				$this->view_data['page'] =$_page;
				$this->view_data['total_page'] =$_total_page;
				$this->view_data['message'] =$this->msg;
				$this->view_data['ddlstatus'] ="ALL";
				$this->view_data['from'] =$from;
				$this->view_data['to'] =$to;
				$this->view_data['ddldb'] ="LIVE";
				$this->view_data['txtRemitter'] ="";
				$this->view_data['txtAccNo'] ="";
				$this->view_data['txtUserId'] ="";
				$this->view_data['ddlapi'] ="ALL";
				$this->view_data['txtNumId'] ="";
				$this->view_data['ddltype'] = "WAP";
				
				$this->view_data["summary_array"] = $this->getTotalValues($from,$to);
				$this->load->view('_Admin/Aeps_report_api_view',$this->view_data);	
			
			}
		 
	}	

	public function getTotalValues($from,$to)
	{
		$rslt_sf = $this->db->query("SELECT 
										a.resp_txn_status,
										Sum(a.amount) as total
										FROM aeps_request a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ?  
										 group by a.resp_txn_status ",array($from,$to));
		
		
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
			
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->resp_txn_status == "SUCCESS")
				{
					$totalsuccess = $row->total;	
				
				}
				if($row->resp_txn_status == "FAILED")
				{
					$totalfailure = $row->total;	
				}
				if($row->resp_txn_status == "PENDING")
				{
					$totalpending = $row->total;	
				}
			}
	
		}
	
		$arr = array(
				"Success"=>$totalsuccess,
				"Failure"=>$totalfailure,
				"Pending"=>$totalpending,
			);
		return $arr;
	}
	
	
	public function dataexport()
	{
	   
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$data = array();
			
			
			
			    $rslt = $this->db->query("select 
			    	a.Id, a.token, a.outlet_id, a.amount, a.aadhaar_uid, a.bankiin, a.latitude, a.longitude, a.mobile, a.agent_id, a.sp_key, a.pidData, a.pidDataType, a.ci, a.dc, a.dpId, a.errCode, a.errInfo, a.fCount, a.tType, a.hmac, a.iCount, a.mc, a.mi, a.nmPoints, a.pCount, a.pType, a.qScore, a.rdsId, a.rdsVer, a.sessionKey, a.srno, a.user_agent, a.add_date, a.ipaddress, a.user_id, a.usertoken_id, a.resp_statuscode, a.resp_status, a.resp_opening_bal, a.resp_ipay_id, a.resp_amount, a.resp_amount_txn, a.resp_account_no, a.resp_txn_mode, a.resp_txn_status, a.resp_opr_id, a.resp_balance, a.resp_timestamp, a.resp_ipay_uuid, a.resp_orderid, a.resp_environment, a.credit_amount, a.debit_amount, a.Commission, a.ChargeAmount, a.tds 
						FROM aeps_request a
						left join tblusers b on a.user_id = b.user_id
				where 
				Date(a.add_date) BETWEEN ? and ?
				order by a.Id desc",array($from,$to));
			
			
			
		$i = 1;
		foreach($rslt->result() as $rw)
		{
			$temparray = array(
			
									"Sr" =>  $i, 
									"TYPE" =>$rw->sp_key, 
									"AepsId" => $rw->Id, 
									"ClientId" => $rw->agent_id, 
									"APIClient" =>$rw->businessname, 
									"TransactionId" =>$rw->resp_opr_id, 
									"DateTime" =>$rw->add_date, 
									"Adhaar_no" =>$rw->aadhaar_uid, 
									"Number" =>$rw->mobile, 
									"Amount" =>$rw->amount, 
									"Commission" =>$rw->Commission, 
									"Status" =>$rw->resp_txn_status
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
    $fileName = "AEPS REPORT From ".$from." To  ".$to.".xls";
    
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