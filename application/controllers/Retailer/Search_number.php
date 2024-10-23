<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_number extends CI_Controller {
	
	
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
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		



		// ini_set('display_errors',1);
		// error_reporting(-1);
		// $this->db->debug = TRUE;
    }
 	public function getBalance()
	{		
		
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("AgentId"));	
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
	
		$user = $this->session->userdata("AgentId");
		
		
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
		    
		    
		  
		    
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										a.mobile_no = ? and user_id = ?
										 group by a.recharge_status ",array($word,$user));
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
		
		
		$this->view_data['word'] =$word;
		
		
		
		
		$this->view_data['result_all'] = $this->get_recharge($this->session->userdata("AgentId"),$word);
		$this->view_data['message'] =$this->msg;
		$this->load->view('Retailer/search_number_view',$this->view_data);			
	
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
		else if(isset($_POST["txtmob"]) )
		{
			$word = $this->input->post('txtmob',true);
			$this->session->set_userdata("word",$word);
			$this->commonfunction();					
		}
		
		else 
		{ 						
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{		
								
					$this->session->set_userdata("word","");
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	private function get_recharge($user_id,$word,$ddldb= "LIVE")
	{

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

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
				$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("AgentId"),$ddlstatus,$ddlstatus,$ddloperator,$ddloperator,$word,$word,intval($startrow),intval($perpage)));
				
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
				
				a.user_id=?   and
				b.mobile_no = ?
				order by a.Id desc ";		
				$result = $this->db->query($str_query,array($this->session->userdata("AgentId"),$word));
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
			$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("AgentId")));
			return $result;
		}
		else
		{
			$str_query ="select  update_time,tblrecharge.recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.recharge_status,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.commission_amount,tblrecharge.commission_per,tblrecharge.recharge_by,company_name,businessname,username,company_name from tblrecharge,tblcompany,tblusers where 
				tblusers.user_id = tblrecharge.user_id and tblusers.usertype_name = 'Agent'  and
		tblcompany.company_id=tblrecharge.company_id and Date(tblrecharge.add_date)>=? and Date(tblrecharge.add_date)<= ? and tblrecharge.user_id=?  order by tblrecharge.recharge_id";		
			$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("AgentId")));
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
			$user_id = $this->session->userdata("AgentId");
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