<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downline_recharge_report extends CI_Controller {
	
	
	private $msg='';
	public function commonfunction()
	{	
		if ($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		$word = "";
		$from = $this->session->userdata("from");
		$to = $this->session->userdata("to");
		$user = $this->session->userdata("user");
		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
	$total_row = $this->getrechargerowcount($from,$to,$user);
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Distributor/downline_recharge_report/commonfunction";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] = $total_row;
		$this->view_data['fromdate'] =$from; 
		$this->view_data['todate'] =$to; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
	
		
		$rslt_sf = $this->db->query("SELECT 
										
										a.recharge_status,
										Sum(a.amount) as total,
										Sum(a.FosComm) as totalcomm 
										FROM tblrecharge a 
										left join tblusers b on a.user_id = b.user_id
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and b.parentid= ? and a.edit_date != '60' and a.edit_date != '5'
										 group by a.recharge_status ",array($from,$to,$this->session->userdata("DistId")));
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
				$totalcommission =  $row->totalcomm;	
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
		
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		$this->view_data['user'] =$user;
		$this->view_data['txtNumId'] ="";
		$this->view_data['ddlstatus'] ="ALL";
		$this->view_data['ddloperator'] ="ALL";
		
		$this->view_data['user'] =$user;
		
		
		$this->view_data['result_all'] = $this->get_recharge($from,$to,$user,$start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('Distributor/downline_recharge_report_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else if($this->input->post('btnSubmit'))
		{
		
			$from = $this->input->post('txtFrom',true);
			$to = $this->input->post('txtTo',true);
			$service_id = $this->input->post('ddlType',true);
			$user_id = $this->input->post('ddlUser',true);			
			$this->session->set_userdata("from",$from);
			$this->session->set_userdata("to",$to);
			$this->session->set_userdata("user",$user_id);		
			$this->commonfunction();					
		}
		else 
		{ 						
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("user","ALL");		
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	
	private function get_recharge_all($from_date,$to_date,$user_id)
	{
		
			$str_query ="
			select 
			    update_time, 
			    DComm,
			    a.recharge_id,
			    a.mobile_no,
			    a.amount,
			    a.recharge_status,
			    a.add_date,
			    a.operator_id,
			    a.commission_amount,
			    a.commission_per,
			    a.recharge_by,
			    c.company_name,
			    b.businessname,
			    b.username
			    from tblrecharge a
			    left join tblcompany c on a.company_id = c.company_id
			    left join tblusers b on a.user_id = b.user_id
			    where 
				Date(a.add_date) BETWEEN ? and ? and 
				a.DId = ? and 
		        if(?!='ALL',a.user_id = ?,true)  
		        order by a.recharge_id";		
			$result = $this->db->query($str_query,array($from_date,$to_date,$this->session->userdata("DistId"),$user_id,$user_id));
			return $result;
		
	}	
	public function dataexport()
	{
	   
		if ($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
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
				 b.parentid = ? and
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				order by recharge_id";
		        $rslt = $this->db->query($str_query,array($this->session->userdata("DistId"),$from,$to));
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
				  b.parentid = ? and
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($this->session->userdata("DistId"),$from,$to));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"edit_date" => $rw->edit_date, 
									"recharge_id" => $rw->recharge_id, 
									"operator_id" =>$rw->operator_id, 
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
									"ParentName" =>$rw->parent_businessname, 
									"ParentUserId" =>$rw->parent_username, 
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

private function get_recharge($from_date,$to_date,$user_id,$startrow,$perpage)
	{
		$str_query ="select 
			
			a.update_time, 
			a.DComm,
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
			from tblrecharge a
			left join tblcompany b on a.company_id = b.company_id
			left join tblusers c on a.user_id = c.user_id
			where 
		        Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				c.parentid = ? and 
				if(?!='ALL',a.user_id = ?,true)  
        		order by a.recharge_id desc limit ?,?";		
			$result = $this->db->query($str_query,array($from_date,$to_date,$this->session->userdata("DistId"),$user_id,$user_id,intval($startrow),intval($perpage)));
			return $result;
		
	}

	private function getrechargerowcount($from,$to,$user_id)
	{
		$from_date = $from;
		$to_date = $to;
		$countarr = $this->db->query("
		select 
		IFNULL(count(a.recharge_id),0) as total 
		from tblrecharge a
		left join tblusers b on a.user_id = b.user_id
		where Date(a.add_date) >=? and Date(a.add_date) <= ? and b.parentid = ?  and if(?!='ALL',a.user_id = ?,true) ",array($from,$to,$this->session->userdata("DistId"),$user_id,$user_id));
		return $countarr->row(0)->total;
		
	}



	}