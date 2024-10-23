<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manual_refund extends CI_Controller {
	
	
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
	public function pageview()
	{
		$word = "";
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$txtNumId = $this->session->userdata("txtNumId");
		$ddloperator = $this->session->userdata("ddloperator");
		$ddlapi  = $this->session->userdata("ddlapi");
		$ddluser  = $this->session->userdata("ddluser");
		$ddldb  = $this->session->userdata("ddldb");
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		
		
		
		
		
		
		
		if($ddldb == "ARCHIVE")
		{
			
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM jantrech_archive.tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.edit_date = '3'
										 group by a.recharge_status ",array($fromdate,$todate));
			
		}
		else
		{
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.edit_date = '3'
										 group by a.recharge_status ",array($fromdate,$todate));
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
		$this->view_data['ddloperator'] =$ddloperator;
		$this->view_data['ddlapi'] =$ddlapi; 
		$this->view_data['ddluser'] =$ddluser; 
		$this->view_data['ddldb'] =$ddldb; 
		$this->view_data['result_recharge'] = $this->gettablerows($fromdate,$todate,$ddlapi,$ddloperator,$txtNumId,$ddluser,$ddldb);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/manual_refund_view',$this->view_data);			
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
			if($this->input->post('btnSubmit'))
			{
			   
				$Fromdate = $this->input->post('txtFrom',true);
				$Todate = $this->input->post('txtTo',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$ddloperator = $this->input->post('ddloperator',true);
				$ddlapi = $this->input->post('ddlapi',true);
				$ddluser = $this->input->post('ddluser',true);
			
				$ddldb = $this->input->post('ddldb',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->session->set_userdata("ddloperator",$ddloperator);
				$this->session->set_userdata("ddlapi",$ddlapi);
				$this->session->set_userdata("ddluser",$ddluser);
				$this->session->set_userdata("ddldb",$ddldb);
				$this->pageview();
									
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddlapi","ALL");
					$this->session->set_userdata("ddldb","LIVE");
					$this->pageview();
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
		        a.debited,
		        a.reverted,
		        a.edit_date,
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
        		from jantrech_archive.tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and 
				 a.edit_date = '3'
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			else
			{
				$str_query = "select 
		        a.debited,
		        a.reverted,
		        a.edit_date,
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
				 Date(a.add_date) <= ? and 
				 a.edit_date = '3'
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"debited" => $rw->debited, 
									"reverted" => $rw->reverted, 
									"edit_date" => $rw->edit_date, 
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
	
	
	public function ExecuteAPI($url)
	{	
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	public function logentry($data)
	{
		$filename = "urlrespnec.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}	
	private function gettablerows($from,$to,$api,$operator,$numid,$user_id,$ddldb)
	{
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
				a.host_id,
				c.businessname,
				c.username,
				state.state_name,
				state.code as statecode,
				p.businessname as parent_name
							from jantrech_archive.tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
							left join tblstate state on a.state_id = state.state_id

							where 
							
							if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
							(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
							(if(? >= 1,c.username =?,true) or if(? = 'ALL',true,c.username = ?)) and
							(if(? != '',a.ExecuteBy = ?,true) or if(? = 'ALL',true,a.ExecuteBy = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true)) and
							a.edit_date = '3'

							 order by a.recharge_id",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$api,$api,$api,$api,$from,$from,$to,$to));
		}
		else
		{
		   
		$returnrslt =  $this->db->query("
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
				a.host_id,
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
							(if(? != '',c.username =?,true) or if(? = 'ALL',true,c.username = ?)) and
							(if(? != '',a.ExecuteBy = ?,true) or if(? = 'ALL',true,a.ExecuteBy = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true)) and 
							a.edit_date = '3'

							 order by a.recharge_id",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$api,$api,$api,$api,$from,$from,$to,$to));
			return $returnrslt;
		}
		
	}
	
}