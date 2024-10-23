<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class List_recharge extends CI_Controller {
	
	
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
    }
	public function pageview()
	{
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		$word = "";
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$txtNumId = $this->session->userdata("txtNumId");
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		$ddldb  = $this->session->userdata("ddldb");
		$user_id = $this->session->userdata("SdId");
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}

		
		
		
		$total_row = $this->gettablerowscount($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page);	
		$this->load->library('pagination');
		$config['base_url'] = base_url()."SuperDealer/list_recharge/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		
		if($ddldb == "ARCHIVE")
		{
			
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM dhanpayc_archive.tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.host_id = ?
										group by a.recharge_status ",array($fromdate,$todate,$user_id));
			
		}
		else
		{
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.host_id = ?
										 group by a.recharge_status ",array($fromdate,$todate,$user_id));
		}
		
		
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
			
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->recharge_status == "Success")
				{
					$totalsuccess = $row->total;	
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total;	
				}
			}
	
		}
	
		
		$this->view_data['totalRecahrge'] =$totalsuccess;
		$this->view_data['totalpRecahrge'] =$totalpending;
		$this->view_data['totalfRecahrge'] =$totalfailure;
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate; 
		$this->view_data['to'] =$todate; 
		$this->view_data['ddlstatus'] =$ddlstatus; 
		$this->view_data['ddloperator'] =$ddloperator;
		$this->view_data['ddluser'] =$ddluser; 
		$this->view_data['ddldb'] =$ddldb; 
		$this->view_data['result_recharge'] = $this->gettablerows($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page,$ddldb);
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/list_recharge_view',$this->view_data);			
	}
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post("txtSearchNumber"))
			{
			    redirect(base_url()."SuperDealer/list_recharge");
				$user_id = $this->session->userdata("SdId");
				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
				$serachbumber = trim($this->input->post("txtSearchNumber"));
				$this->view_data['totalRecahrge'] ="";
				$this->view_data['totalpRecahrge'] ="";
				$this->view_data['totalfRecahrge'] ="";
				
				$this->view_data['txtNumId'] =$serachbumber; 
				$this->view_data['from'] =""; 
				$this->view_data['to'] =""; 
				$this->view_data['ddlstatus'] ="ALL"; 
				$this->view_data['ddloperator'] ="ALL"; 
				$this->view_data['ddlapi'] ="ALL"; 
				$this->view_data['ddluser'] ="ALL"; 
				$this->view_data['ddldb'] ="LIVE"; 
				$this->view_data['result_recharge'] = $this->db->query("
		select
				a.transaction_id,
				a.updated_by,
				a.user_id, 	
                a.state_id,
				a.edit_date,
				a.update_time,
				a.retry,
				a.recharge_id,
				a.company_id,
				a.balance,
				a.mobile_no,
				a.amount,
				a.recharge_by,
				a.ExecuteBy,
				a.ewallet_id,
				a.user_id,
				b.company_name,
				b.mcode,
				a.commission_amount,
				a.add_date,
				a.update_time,
				a.operator_id,
				a.recharge_status,
				a.MdComm,
				a.MdId,
				a.DId,
				a.DComm,
				a.lapubalance,
				c.businessname,
				c.username,
				p.businessname as parent_name,
				state.state_name,
				state.code as statecode
							from tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
                            left join tblstate state on a.state_id = state.state_id
							where 
							(a.mobile_no = ? or a.recharge_id = ?) and a.host_id = ?
							 order by a.recharge_id desc",array($serachbumber,$serachbumber,$user_id));
							 
							
				$this->view_data['message'] =$this->msg;
				$this->load->view('SuperDealer/list_recharge_view',$this->view_data);	
			}
			else if($this->input->post('btnSubmit'))
			{
			
				$Fromdate = $this->input->post('txtFrom',true);
				$Todate = $this->input->post('txtTo',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$ddlstatus = $this->input->post('ddlstatus',true);
				$ddloperator = $this->input->post('ddloperator',true);
				$ddluser = $this->input->post('ddluser',true);
				$ddldb = $this->input->post('ddldb',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Fromdate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->session->set_userdata("ddlstatus",$ddlstatus);
				$this->session->set_userdata("ddloperator",$ddloperator);
				$this->session->set_userdata("ddldb",$ddldb);
				$this->pageview();
									
			}
			else
			{
				
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddldb","LIVE");
					$this->pageview();
			}
		} 
	}	
	
	public function dataexport()
	{
	   exit;
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			$user_id = $this->session->userdata("SdId");
			$data = array();
			
			if($db == "ARCHIVE")
			{
				$str_query = "select 
		
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.state_id,
        		a.amount,
        		a.recharge_status,
        		a.transaction_id,
        		a.operator_id,
        		a.amount,
        		a.user_id,
        		a.ExecuteBy,
				a.commission_amount,
        		a.add_date,
        		a.update_time,
        		a.operator_id,
        		a.recharge_by,
        		a.lapubalance,
        		c.company_name,
        		b.businessname,b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				state.state_name,
				state.code as statecode
        		from dhanpayc_archive.tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and a.host_id = ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
			}
			else
			{
				$str_query = "select 
		
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.state_id,
        		a.amount,
        		a.recharge_status,
        		a.transaction_id,
        		a.operator_id,
        		a.amount,
        		a.user_id,
        		a.ExecuteBy,
				a.commission_amount,
        		a.add_date,
        		a.update_time,
        		a.operator_id,
        		a.recharge_by,
        		a.lapubalance,
        		c.company_name,
        		b.businessname,b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				state.state_name,
				state.code as statecode
        		from tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and a.host_id = ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"recharge_id" => $rw->recharge_id, 
									"ewallet_id" => $rw->ewallet_id, 
									"transaction_id" =>$rw->transaction_id, 
									"operator_id" =>$rw->operator_id, 
									"add_date" =>$rw->add_date, 
									"update_time" =>$rw->update_time, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Execute By" =>$rw->ExecuteBy, 
									"Recharge By" =>$rw->recharge_by, 
									"Recharge Status" =>$rw->recharge_status, 
									"Ret.Comm" =>$rw->commission_amount, 
									"ParentName" =>$rw->parent_businessname, 
									"ParentUserId" =>$rw->parent_username, 
									"state_name" =>$rw->state_name, 
								);
					
					
					
				//	array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "recharge_list From ".$from." To  ".$to.".xls";
    
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
		
	private function gettablerows($from,$to,$operator,$status,$numid,$start,$perpage,$ddldb)
	{
		$user_id = $this->session->userdata("SdId");
		if($ddldb == "ARCHIVE")
		{
			return $this->db->query("
		select
				a.transaction_id,
				a.updated_by,
				a.user_id, 	
                a.state_id,
				a.edit_date,
				a.update_time,
				a.retry,
				a.recharge_id,
				a.company_id,
				a.balance,
				a.mobile_no,
				a.amount,
				a.recharge_by,
				a.ExecuteBy,

				a.ewallet_id,
				a.user_id,
				b.company_name,
				b.mcode,
				a.commission_amount,
				a.add_date,
				a.update_time,
				a.operator_id,
				a.recharge_status,
				a.MdComm,
				a.MdId,
				a.DId,
				a.DComm,
				a.lapubalance,
				c.businessname,
				c.username,
				state.state_name,
				state.code as statecode,
				p.businessname as parent_name
							from dhanpayc_archive.tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
							left join tblstate state on a.state_id = state.state_id

							where 
							
							if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
							(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
							(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true)) and
							a.host_id = ? and
							a.amount > 0

							 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		}
		else
		{
			return $this->db->query("
		select
				a.transaction_id,
				a.updated_by,
				a.user_id, 	
                a.state_id,
				a.edit_date,
				a.update_time,
				a.retry,
				a.recharge_id,
				a.company_id,
				a.balance,
				a.mobile_no,
				a.amount,
				a.recharge_by,
				a.ExecuteBy,
				a.ewallet_id,
				a.user_id,
				b.company_name,
				b.mcode,
				a.commission_amount,
				a.add_date,
				a.update_time,
				a.operator_id,
				a.recharge_status,
				a.MdComm,
				a.MdId,
				a.DId,
				a.DComm,
				a.lapubalance,
				c.businessname,
				c.username,
				state.state_name,
				state.code as statecode,
				p.businessname as parent_name
							from tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
							left join tblstate state on a.state_id = state.state_id

							where 
							
							if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
							(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
							(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true)) and
							a.host_id = ? and
							a.amount > 0 and
							(a.edit_date != 5 or a.recharge_status = 'Success')

							order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		}
		
	}
	private function gettablerowscount($from,$to,$operator,$status,$numid,$start,$perpage)
	{
		$user_id = $this->session->userdata("SdId");
		$rsltrowcount=  $this->db->query("
				select 
				count(recharge_id) as total from tblrecharge
				where ExecuteBy = 'MSOFT' and Date(add_date) >= ? and Date(add_date) <= ? and host_id = ? and amount > 0
				",array($from,$to,$user_id));
		return $rsltrowcount->row(0)->total;
		
	}
}