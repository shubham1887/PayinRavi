<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_history extends CI_Controller {
	
	
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
		



		ini_set('display_errors',1);
		error_reporting(-1);
		$this->db->debug = TRUE;
    }
 	public function getBalance()
	{		
		
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("MdId"));	
		echo $balance;
	}
	public function commonfunction()
	{	
		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
	//echo "asdfsdf";exit;
		$word = $this->session->userdata("word");
		$from = $this->session->userdata("from");
		$to = $this->session->userdata("to");
		$ddldb = $this->session->userdata("ddldb");
		
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		
		$user = $this->session->userdata("MdId");
		
		
		
		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		if($ddldb == "ARCHIVE")
		{
		    $rsltcount = $this->db->query("select count(recharge_id) as total from jantrech_archive.tblrecharge where Date(add_date) >= ? and Date(add_date) <= ? and user_id = ?",array($from,$to,$user));
		   
		}
		else
		{
			$rsltcount = $this->db->query("select count(recharge_id) as total from tblrecharge where Date(add_date) >= ? and Date(add_date) <= ? and user_id = ?",array($from,$to,$user));
		}
		
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Retailer/recharge_history/commonfunction";
		$config['total_rows'] = $rsltcount->row(0)->total;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] = $rsltcount->row(0)->total; 
		$this->view_data['fromdate'] =$from; 
		$this->view_data['todate'] =$to; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		if($ddldb == "ARCHIVE")
		{
			
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM jantrech_archive.tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.user_id = ?
										 group by a.recharge_status ",array($from,$to,$user));
			
		}
		else
		{
		    
		    
		    $date = $this->common->getDate();
            $time = strtotime($date);
            $time = $time - (2 * 60);
            $date = date("Y-m-d H:i:s", $time);
           
            $pendingrecent = 0;
            $rslt_sp = $this->db->query("SELECT 
    						a.recharge_status,
    						Sum(a.amount) as total,
    						Sum(a.commission_amount) as commission
    						FROM tblrecharge a 
    						where 
    						Date(a.add_date) >= ? and  Date(a.add_date) <= ? and
    						a.add_date < ?  and a.user_id = ? and a.recharge_status = 'Pending'",array($from,$to,$date,$this->session->userdata("MdId")));
    						
    		if($rslt_sp->num_rows() == 1)
    		{
    		    $pendingrecent = $rslt_sp->row(0)->total;
    		}
    		
		    
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and user_id = ?
										 group by a.recharge_status ",array($from,$to,$user));
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
					$totalsuccess = $row->total + $pendingrecent;	
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total - $pendingrecent;	
				}
			}
	
		}
	
		
		$this->view_data['totalRecahrge'] =$totalsuccess;
		$this->view_data['totalpRecahrge'] =$totalpending;
		$this->view_data['totalfRecahrge'] =$totalfailure;
		
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		$this->view_data['user'] =$user;
		$this->view_data['word'] =$word;
		$this->view_data['ddldb'] =$ddldb;
		$this->view_data['ddlstatus'] =$ddlstatus;
		$this->view_data['ddloperator'] =$ddloperator;
		
		$this->view_data["summary"] = $this->getsummary($from,$to);
		
		$this->view_data['result_all'] = $this->get_recharge($from,$to,$this->session->userdata("MdId"),$start_row,$per_page,$word,$ddldb,$ddlstatus,$ddloperator);
		$this->view_data['message'] =$this->msg;
		$this->load->view('MasterDealer_new/recharge_history_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 





/*

Array ( [ddl_status] => [Operator] => [txtmob] => [txt_frm_date] => 2020-10-23 [txt_to_date] => 2020-10-23 [btntype] => LIVE )
*/


		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else if(isset($_POST["txt_frm_date"]) and isset($_POST["txt_to_date"]))
		{
		
			$from = $this->input->post('txt_frm_date',true);
			$to = $this->input->post('txt_to_date',true);
			$word = $this->input->post('txtmob',true);
			$ddldb = $this->input->post('ddldb',true);
			
			$ddlstatus = $this->input->post('ddl_status',true);
			$ddloperator = $this->input->post('Operator',true);
			
			
			$this->session->set_userdata("from",$from);
			$this->session->set_userdata("to",$to);
			$this->session->set_userdata("word",$word);
			$this->session->set_userdata("ddldb",$ddldb);
			$this->session->set_userdata("ddlstatus",$ddlstatus);
			$this->session->set_userdata("ddloperator",$ddloperator);
			$this->commonfunction();					
		}
		else if($this->input->post('hidrecid') and $this->input->post('hidmsg'))
		{
			$user_id = $this->session->userdata("MdId");
			$hidrecid = $this->input->post('hidrecid',true);
			$hidmsg = $this->input->post('hidmsg',true);
			$rsltrecharge = $this->db->query("select recharge_id,add_date from tblrecharge where recharge_id = ? and recharge_status != 'Pending' and user_id = ? ",array($hidrecid,$user_id));
			if($rsltrecharge->num_rows() == 1)
			{
			
			
				$rsltcheckcomplain = $this->db->query("select * from tblcomplain where recharge_id = ? and complain_status = 'Pending'",array($hidrecid));
				if($rsltcheckcomplain->num_rows() == 1)
				{
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("word","");
					$this->commonfunction();
				}
				else
				{
					$txtToDate = date_format(date_create($rsltrecharge->row(0)->add_date),'y-m-d');
				$date = $this->common->getMySqlDate();
				$date1= strtotime($txtToDate);
				$date2= strtotime($date);
				$secs = $date2 - $date1;// == return sec in difference
				$days = $secs / 86400;
			
				if($days <= 5)
				{
					$this->db->query("insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)",array($user_id,$this->common->getDate(),'Pending',$hidmsg,'Recharge',$hidrecid));
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("word","");
					$this->session->set_userdata("ddldb","ALL");
					$this->commonfunction();
				}
				else
				{
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("word","");
					$this->session->set_userdata("ddldb","ALL");
					$this->commonfunction();
				}
					
				}
			}
			else
			{
				$date = $this->common->getMySqlDate();								
				$this->session->set_userdata("from",$date);
				$this->session->set_userdata("to",$date);
				$this->session->set_userdata("word","");
				$this->session->set_userdata("ddldb","ALL");
				$this->commonfunction();
			}
		}
		else 
		{ 						
				$user=$this->session->userdata('MdUserType');
				if(trim($user) == 'MasterDealer')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("word","");
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddldb","LIVE");
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	private function getsummary($from,$to)
	{
		/////openging balance code
		$opening_balance = 0;
		$user_id = $this->session->userdata("MdId");
		$opening_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($user_id,$from));
		if($opening_rslt->num_rows() == 1)
		{
			$opening_balance = $opening_rslt->row(0)->balance;
		}


		/////clossing balance code
		$clossing_balance = 0;
		$user_id = $this->session->userdata("MdId");
		$clossing_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$to));
		if($clossing_rslt->num_rows() == 1)
		{
			$clossing_balance = $clossing_rslt->row(0)->balance;
		}


		/////purchase
		$total_purchase = 0;
		$total_transfer = 0;
		$user_id = $this->session->userdata("MdId");
		$purchase_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as total_purchase,IFNULL(Sum(debit_amount),0) as total_transfer from tblewallet where transaction_type = 'PAYMENT' and user_id = ? and Date(add_date) BETWEEN  ? and ?  order by Id desc limit 1",array($user_id,$from,$to));
		if($purchase_rslt->num_rows() == 1)
		{
			$total_purchase = $purchase_rslt->row(0)->total_purchase;
			$total_transfer = $purchase_rslt->row(0)->total_transfer;
		}





		////dmt transaction
		$total_dmt = 0;
		$totalcharge = 0;
		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(Amount),0) as total,IFNULL(Sum(Charge_Amount),0) as totalcharge,count(Id) as totalcount,Status from mt3_transfer 
					where 
					user_id = ? and
					(Status = 'SUCCESS' or Status = 'PENDING') and
					Date(add_date) BETWEEN ? and ? ",array($user_id,$from,$to));
		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmt = $rslt_dmt->row(0)->total;
			$totalcharge = $rslt_dmt->row(0)->totalcharge;
		}



		////recharge query

		$totalrecharge = 0;
		$totalcommission = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalrecharge,IFNULL(Sum(commission_amount),0) as totalcommission from tblrecharge where user_id = ? and Date(add_date) BETWEEN ? and ? and (recharge_status = 'Success' or recharge_status = 'Pending')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalrecharge = 	$recharge_rslt->row(0)->totalrecharge;
			$totalcommission = 	$recharge_rslt->row(0)->totalcommission;
		}


		$purchase = 0;

		$str = '<table class="table table-bordered">
					<tr>
						<th>Opening</th>
						<th>Purchase</th>
						<th>Revert</th>
						<th>Recharge</th>
						<th>Commission</th>

						<th>DMT</th>
						<th>DMT Charge</th>

						<th>Clossing</th>
					</tr>
					<tr>
						<th>'.$opening_balance.'</th>
						<th>'.$total_purchase.'</th>
						<th>'.$total_transfer.'</th>
						<th>'.$totalrecharge.'</th>
						<th>'.$totalcommission.'</th>

						<th>'.$total_dmt.'</th>
						<th>'.$totalcharge.'</th>

						<th>'.$clossing_balance.'</th>
					</tr>
				</table>';
			return $str;


	}
	private function get_recharge($start_date,$end_date,$user_id,$startrow,$perpage,$word,$ddldb,$ddlstatus,$ddloperator)
	{

		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;

		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		if($ddldb == "ARCHIVE")
		{
		
				$str_query ="
				select  
				b.edit_date,
				a.balance,
			    a.update_time,
				a.recharge_id,
				a.mobile_no,
				a.amount,
				a.recharge_status,
				a.add_date,
				a.operator_id,
				a.commission_amount,
				a.commission_per,
				a.recharge_by,
				b.company_name,
				c.businessname,
				c.username
				from jantrech_archive.tblrecharge a
				left join tblcompany b on a.company_id = b.company_id
				left join tblusers c on a.user_id = c.user_id 
				where 
				a.amount > 0 and
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=? and
				if(? != 'ALL',a.recharge_status = ?,true) and
				if(? != 'ALL',a.company_id = ?,true) and
				if(? != '',a.mobile_no = ?,true) 
				order by a.recharge_id desc limit ?,? ";		
				$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("MdId"),$ddlstatus,$ddlstatus,$ddloperator,$ddloperator,$word,$word,intval($startrow),intval($perpage)));
				
				return $result;
			
		}
		else
		{
			$str_query ="
				select 
				


				a.Id,
				a.balance,
				a.credit_amount,
				a.debit_amount,
				a.description,
				a.remark,
				a.add_date,
				a.user_id,
				a.transaction_type,


				b.edit_date, 
				b.update_time,
				b.recharge_id,
				b.mobile_no,
				b.amount,
				b.recharge_status,
				b.add_date as recharge_date,
				b.operator_id,
				b.commission_amount,
				b.commission_per,
				b.recharge_by,
				c.company_name,
				u.businessname,
				u.username
				from tblewallet a
				left join tblrecharge b on a.recharge_id = b.recharge_id
				left join tblcompany c on b.company_id = c.company_id
				left join tblusers u on a.user_id = u.user_id 
				where 
				Date(b.add_date)>=? and 
				Date(b.add_date)<= ? and 
				a.user_id=?   and
				if(? != 'ALL',b.recharge_status = ?,true) and
				if(? > 0,b.company_id = ?,true) and
				if(? != '',b.mobile_no = ?,true) 
				order by a.Id desc  limit ?,?";		
				$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("MdId"),$ddlstatus,$ddlstatus,$ddloperator,$ddloperator,$word,$word,intval($startrow),intval($perpage)));
				return $result;
			
		}
		
			
		
		
	}
	private function get_recharge_all($start_date,$end_date,$user_id,$ddldb)
	{
		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		if($ddldb == "ARCHIVE")
		{
			$str_query ="select  update_time,tblrecharge.recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.recharge_status,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.commission_amount,tblrecharge.commission_per,tblrecharge.recharge_by,company_name,businessname,username,company_name from wlmangal_archivdb.tblrecharge,wlmangal_db.tblcompany,wlmangal_db.tblusers where 
				tblusers.user_id = tblrecharge.user_id and tblusers.usertype_name = 'Agent'  and
		tblcompany.company_id=tblrecharge.company_id and Date(tblrecharge.add_date)>=? and Date(tblrecharge.add_date)<= ? and tblrecharge.user_id=?  order by tblrecharge.recharge_id";		
			$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("MdId")));
			return $result;
		}
		else
		{
			$str_query ="select  update_time,tblrecharge.recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.recharge_status,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.commission_amount,tblrecharge.commission_per,tblrecharge.recharge_by,company_name,businessname,username,company_name from tblrecharge,tblcompany,tblusers where 
				tblusers.user_id = tblrecharge.user_id and tblusers.usertype_name = 'Agent'  and
		tblcompany.company_id=tblrecharge.company_id and Date(tblrecharge.add_date)>=? and Date(tblrecharge.add_date)<= ? and tblrecharge.user_id=?  order by tblrecharge.recharge_id";		
			$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("MdId")));
			return $result;
		}
			
		
		
	}	
	public function dataexport()
	{
	   
	   	if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			$user_id = $this->session->userdata("MdId");
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
				 a.user_id = ?
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
				 a.user_id = ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"recharge_id" => $rw->recharge_id, 
									"operatorId" =>$rw->operator_id, 
									"add_date" =>$rw->add_date, 
									"update_time" =>$rw->update_time, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Recharge By" =>$rw->recharge_by, 
									"Recharge Status" =>$rw->recharge_status, 
									"Ret.Comm" =>$rw->commission_amount, 
								);
					
					
					
					//array_push( $data,$temparray);
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
	}