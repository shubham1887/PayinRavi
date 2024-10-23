<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_history extends CI_Controller { 
	
	
	private $msg='';
	public function commonfunction()
	{ 	
		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		$word = "";
		$fromdate = $this->session->userdata("from");
		$todate = $this->session->userdata("to");
		
		$txtNumId = $this->session->userdata("txtNumId");
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		$user = $this->session->userdata("AgentId");
		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
	
		/*$countarr = $this->db->query("select count(recharge_id) as total from tblrecharge where recharge_date >='$fromdate' and recharge_date <= '$todate' and tblrecharge.user_id  = ? order by tblrecharge.recharge_id desc",array($this->session->userdata("AgentId")));*/
		$total_rows = $this->gettablerowscount($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$user);
		//echo $total_rows;exit;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Retailer/recharge_history/commonfunction";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] = $total_rows; 
		$this->view_data['fromdate'] =$fromdate; 
		$this->view_data['todate'] =$todate; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		$rslt_sf = $this->db->query("SELECT 
										
										a.recharge_status,
										Sum(a.amount) as total,
										Sum(a.FosComm) as totalcomm 
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.user_id= ?
										 group by a.recharge_status ",array($fromdate,$todate,$this->session->userdata("AgentId")));
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
		
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate;
		$this->view_data['to'] =$todate;
		$this->view_data['user'] =$user;
		$this->view_data['ddlstatus'] =$ddlstatus; 
		$this->view_data['ddloperator'] =$ddloperator; 
		$this->view_data['result_recharge'] = $this->gettablerows($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page,$user);
		//$this->view_data['result_all'] = 
		$this->view_data['message'] =$this->msg;
		$this->load->view('Retailer/recharge_history_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		else if($this->input->post('btnSearch'))
		{
		
			$fromdate = $this->input->post('txtFrom',true);
			$todate = $this->input->post('txtTo',true);
			$txtNumId = $this->input->post('txtNumId',true);
			$ddlstatus = $this->input->post('ddlstatus',true);
			$ddloperator = $this->input->post('ddloperator',true);
			$this->session->set_userdata("from",$fromdate);
			$this->session->set_userdata("to",$todate);
			$this->session->set_userdata("txtNumId",$txtNumId);
			$this->session->set_userdata("ddlstatus",$ddlstatus);
			$this->session->set_userdata("ddloperator",$ddloperator);
			$this->commonfunction();					
		}
		else if($this->input->post('hidrecid') and $this->input->post('hidmsg'))
		{
					if($this->session->userdata('ReadOnly') == true)
					{
						redirect(base_url()."Retailer/recharge_history");
					}
				
				$hidrecid = $this->input->post('hidrecid',true);
				$hidmsg = $this->input->post('hidmsg',true);
				$user_id = $this->session->userdata('AgentId');	
				$recharge_info = $this->db->query("select * from tblrecharge where recharge_id = ? and recharge_status = 'Pending'",array($hidrecid));
				if($recharge_info->num_rows() == 1)
				{
					$this->commonfunction();
				}
				else
				{
					$recinfo = $this->db->query("select * from tblcomplain where complain_status = 'Pending' and recharge_id = ?",array($hidrecid));
					if($recinfo->num_rows() > 0)
					{
						$this->commonfunction();
					}
					else
					{
						$date = $this->common->getDate();		
						$str_query = "insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)";
						$this->db->query($str_query,array($user_id,$date,"Pending",$hidmsg,"Recharge",$hidrecid));
						$this->commonfunction();
						
					}
				}
				
		
	} 
		else 
		{ 						
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	public function dataexport()
	{
		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$user_id = $this->session->userdata("AgentId");
			
				$result_all = $this->getallrechargedata($from,$to,$user_id);
				
				echo '<table border=1><tr><th>Sr No</th><th >AgentName</th><th>Agent Id</th><th >Recharge ID</th><th >Operator Id</th><th>Recharge Date Time</th><th>Company Name</th><th>Mobile No</th><th>Commission Per(%)</th><th>Amount</th><th>Debit Amount</th><th>Status</th></tr>';
				if($result_all->num_rows() > 0)
				{
					$i = 0;
					$total_amount=0;
					$total_commission=0;
					foreach($result_all->result() as $result) 	{
					{
					
					
			
						echo '<tr> <td>'.($i + 1).'</td>
						  <td>'.$result->businessname.'</td>
						   <td>'.$result->username.'</td>
						  <td>'.$result->recharge_id.'</td>
						  <td>'.$result->operator_id.'</td>
						 <td>'.$result->add_date.'</td> 
						 <td>'.$result->company_name.'</td> 
						 <td>'.$result->mobile_no.'</td> 
						 <td>'.$result->commission_per.'</td>
						 <td>'.$result->amount.'</td>';
 
	if($result->recharge_status == "Success")
	{
		$total_commission += $result->commission_amount;
		$debit_amount = $result->amount - $result->commission_amount;
	}
	else
	{
		$debit_amount = 0;
	}

  	echo '<td>'.$debit_amount.'</td>
	<td>'.$result->recharge_status.'</td>
	
	</tr>';
		$i++;
					} 
				} 
			}
			
			echo '</table>';
		
	}
		else
		{
			echo "parameter missing";exit;
		}
		}
		private function getallrechargedata($from,$to,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		return $this->db->query("select
	a.user_id, 	
	a.recharge_id,
	a.company_id,
	a.mobile_no,
	a.amount,
	a.recharge_by,
	b.company_name,
	a.commission_amount,
	a.commission_per,
	a.add_date,
	a.edit_date,
	a.update_time,
	a.operator_id,
	a.recharge_status,
	c.businessname,
	c.username from tblrecharge a
	left join tblcompany b on a.company_id = b.company_id
	left join tblusers c on a.user_id = c.user_id
				
				where 
				
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and a.user_id = ?
				
				 order by recharge_id",array($from,$from,$to,$to,$user_id));
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
			
			
			return $this->db->query("select
	tblrecharge.user_id, 	
	tblrecharge.recharge_id,
	tblrecharge.company_id,
	tblrecharge.mobile_no,
	tblrecharge.amount,
	tblrecharge.recharge_by,
tblcompany.company_name,
tblrecharge.commission_amount,
tblrecharge.commission_per,
tblrecharge.add_date,
tblrecharge.update_time,
tblrecharge.operator_id,
tblrecharge.recharge_status,
tblusers.businessname,
tblusers.username from gofullrc_archiv.tblrecharge,tblcompany,tblusers
				
				where 
				
				tblusers.user_id = tblrecharge.user_id and 
				tblcompany.company_id = tblrecharge.company_id and 
				(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and tblrecharge.user_id = ?
				
				 order by recharge_id",array($from,$from,$to,$to,$user_id));
			
		}
		
		
	}
	
	private function gettablerows($from,$to,$operator,$status,$numid,$start,$perpage,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		return $this->db->query("
		select 
			a.user_id, 	
			a.recharge_id,
			a.company_id,
			a.mobile_no,
			a.amount,
			a.recharge_by,
			b.company_name,
			a.commission_amount,
			a.commission_per,
			a.add_date,
			a.edit_date,
			a.update_time,
			a.operator_id,
			a.recharge_status,
			c.businessname,
			c.username 
			from tblrecharge a
		left join tblcompany b on a.company_id = b.company_id
		left join tblusers c on a.user_id = c.user_id
		where
				if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
				(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
				(if(? >= 1,a.user_id =?,true) or if(? = 'ALL',true,a.user_id = ?)) and
				(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and 
				a.user_id = ?
				
				 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
		
		return $this->db->query("select
	tblrecharge.transaction_id,updated_by,tblrecharge.user_id, 	
	tblusers.parentid,
	tblrecharge.recharge_id,tblrecharge.company_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.recharge_by,tblcompany.company_name,tblrecharge.commission_amount,tblrecharge.add_date,tblrecharge.update_time,tblrecharge.operator_id,tblrecharge.recharge_status,
				tblusers.businessname,tblusers.username from gofullrc_archiv.tblrecharge,tblcompany,tblusers
				
				where 
			
				tblusers.user_id = tblrecharge.user_id and 
				tblcompany.company_id = tblrecharge.company_id and 
				if(? != '',(tblrecharge.mobile_no = ? or tblrecharge.recharge_id = ?),true) and 
				(if(? >= 1,tblrecharge.company_id =?,true) or if(? = 'ALL',true,tblrecharge.company_id = ?)) and
				(if(? >= 1,tblrecharge.user_id =?,true) or if(? = 'ALL',true,tblrecharge.user_id = ?)) and
				(if(? != '',tblrecharge.recharge_status = ?,true) or if(? = 'ALL',true,tblrecharge.recharge_status = ?)) and
				(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and
				tblrecharge.user_id = ?
				
				 order by recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		
		}
		
		
	}
	private function gettablerowscount($from,$to,$operator,$status,$numid,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		{
		$rsltrowcount=  $this->db->query("select
	tblrecharge.recharge_id from tblrecharge,tblcompany,tblusers
				
				where 
			
				tblusers.user_id = tblrecharge.user_id and 
				tblcompany.company_id = tblrecharge.company_id and 
				if(? != '',(tblrecharge.mobile_no = ? or tblrecharge.recharge_id = ?),true) and 
				(if(? >= 1,tblrecharge.company_id =?,true) or if(? = 'ALL',true,tblrecharge.company_id = ?)) and
				(if(? >= 1,tblrecharge.user_id =?,true) or if(? = 'ALL',true,tblrecharge.user_id = ?)) and
				(if(? != '',tblrecharge.recharge_status = ?,true) or if(? = 'ALL',true,tblrecharge.recharge_status = ?)) and
				(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and
				tblrecharge.user_id = ?
				
				 ",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id));
				 return $rsltrowcount->num_rows();
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
			$rsltrowcount=  $this->db->query("select
	tblrecharge.recharge_id from gofullrc_archiv.tblrecharge,tblcompany,tblusers
				
				where 
			
				tblusers.user_id = tblrecharge.user_id and 
				tblcompany.company_id = tblrecharge.company_id and 
				if(? != '',(tblrecharge.mobile_no = ? or tblrecharge.recharge_id = ?),true) and 
				(if(? >= 1,tblrecharge.company_id =?,true) or if(? = 'ALL',true,tblrecharge.company_id = ?)) and
				(if(? >= 1,tblrecharge.user_id =?,true) or if(? = 'ALL',true,tblrecharge.user_id = ?)) and
				
				(if(? != '',tblrecharge.recharge_status = ?,true) or if(? = 'ALL',true,tblrecharge.recharge_status = ?)) and
				(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and
				tblrecharge.user_id = ?
				
				 ",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id));
				 return $rsltrowcount->num_rows();
		}
		
		
	}
	private function getsuccesscount($from,$to,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from tblrecharge
				
			where 
			Date(tblrecharge.add_date) >= ? and
				Date(tblrecharge.add_date) <= ? and 
				recharge_status = 'Success' and
				tblrecharge.user_id = ?
				
				 ",array($from,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
				$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from gofullrc_archiv.tblrecharge
				
				where 
			Date(tblrecharge.add_date) >= ? and
				Date(tblrecharge.add_date) <= ? and 
				recharge_status = 'Success' and
				tblrecharge.user_id = ?
				
				 ",array($from,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		
		
	}
	private function getFailurecount($from,$to,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Failure' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
				$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from gofullrc_archiv.tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Failure' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		
		
	}
	
	
	private function getPendingcount($from,$to,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Pending' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
				$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(amount),0) as total from gofullrc_archiv.tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Pending' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		
		
	}
	private function getCommissionAmount($from,$to,$user_id)
	{
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from > $archivdate and $to > $archivdate)
		
		{
		$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(Commission_amount),0) as total from tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Success' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		else if($from <= $archivdate and $to > $archivdate)
		{
		
		}
		else if($from <= $archivdate and $to <= $archivdate)
		{
				$rsltrowcount=  $this->db->query("select
	IFNULL(Sum(commission_amount),0) as total from gofullrc_archiv.tblrecharge
				
				where 
			(if(? != '',Date(tblrecharge.add_date) >= ?,true)) and
				(if(? != '',Date(tblrecharge.add_date) <= ?,true)) and 
				recharge_status = 'Success' and 
				tblrecharge.user_id = ?
				
				 ",array($from,$from,$to,$to,$user_id));
				 return $rsltrowcount->row(0)->total;
		}
		
		
	}

}