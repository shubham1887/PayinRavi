<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_transaction_report extends CI_Controller {
	
	
	private $msg='';
	public function commonfunction()
	{	
		if ($this->session->userdata('MdLoggedIn') != TRUE) 
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
		$config['base_url'] = base_url()."/all_transaction_report/commonfunction";
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
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.MdId= ?
										 group by a.recharge_status ",array($from,$to,$this->session->userdata("SdId")));
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
		
		
		
		
		$this->view_data['result_all'] = $this->get_recharge($from,$to,$user,$start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/all_transaction_report_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else if($this->input->post('btnSearch'))
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
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
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
				Date(a.add_date)>=? and Date(a.add_date)<= ? and a.MdId = ?
		and if(?!='ALL',a.user_id = ?,true)  order by a.recharge_id ";		
			$result = $this->db->query($str_query,array($from_date,$to_date,$this->session->userdata("SdId"),$user_id,$user_id));
			return $result;
	
	}	
	public function dataexport()
	{
		if ($this->session->userdata('MdLoggedIn') != TRUE) 
		{ 
			echo false; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["user"]))
		{
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$user = trim($_GET["user"]);
			$parent_id = $this->session->userdata("SdId");
			
				$result_all = $this->get_recharge_all($from,$to,$user);
				
				echo '<table border=1><tr><th>Sr No</th><th >AgentName</th><th>Agent Id</th><th >Recharge ID</th><th >Transaction Id</th><th>Recharge Date Time</th><th>Company Name</th><th>Mobile No</th><th>Commission Per(%)</th><th>Amount</th><th>Debit Amount</th><th>Status</th></tr>';

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
				Date(a.add_date)>=? and Date(a.add_date)<= ? and a.MdId = ?
		and if(?!='ALL',a.user_id = ?,true)  order by a.recharge_id limit ?,?";		
			$result = $this->db->query($str_query,array($from_date,$to_date,$this->session->userdata("SdId"),$user_id,$user_id,intval($startrow),intval($perpage)));
			return $result;
		
	}



	private function getrechargerowcount($from,$to,$user_id)
	{
		$from_date = $from;
		$to_date = $to;
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from_date <= $archivdate and $to_date <= $archivdate)
		{
			$countarr = $this->db->query("select IFNULL(count(recharge_id),0) as total from maharshi_archivdata.tblrecharge where Date(tblrecharge.add_date) >='$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.MdId = ?  and if(?!='ALL',tblrecharge.user_id = ?,true) ",array($this->session->userdata("SdId"),$user_id,$user_id));
		
			return $countarr->row(0)->total;
		}
		else if($from_date > $archivdate and $to_date > $archivdate)
		{
			$countarr = $this->db->query("select IFNULL(count(recharge_id),0) as total from tblrecharge where Date(add_date) >='$from' and Date(add_date) <= '$to' and tblrecharge.MdId = ?  and if(?!='ALL',tblrecharge.user_id = ?,true) ",array($this->session->userdata("SdId"),$user_id,$user_id));
		
			return $countarr->row(0)->total;
		}
			
	
	}






	}