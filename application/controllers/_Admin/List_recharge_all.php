<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class List_recharge_all extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		$ddlapi  = $this->session->userdata("ddlapi");
		
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		
		$this->view_data['pagination'] = "";
		$this->load->database();
        $this->db->reconnect();
		//$str_totalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Success' and recharge_date >=? and recharge_date <= ? ";
		//$str_ptotalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Pending' and recharge_date >=? and recharge_date <= ? ";
	//	$str_ftotalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Failure' and recharge_date >=? and recharge_date <= ? ";
		//$totalrslt = $this->db->query($str_totalqry,array($fromdate,$todate));
		//$ptotalrslt = $this->db->query($str_ptotalqry,array($fromdate,$todate));
		//$ftotalrslt = $this->db->query($str_ftotalqry,array($fromdate,$todate));
	//	$this->view_data['totalRecahrge'] =$this->getsuccesscount($fromdate,$todate);
		//$this->view_data['totalpRecahrge'] =$ptotalrslt->row(0)->totalRecahrge;
		//$this->view_data['totalfRecahrge'] =$this->getFailurecount($fromdate,$todate);
		
		
		$this->view_data['from'] =$fromdate; 
		$this->view_data['to'] =$todate; 
		$this->view_data['ddlstatus'] =$ddlstatus; 
		$this->view_data['ddloperator'] =$ddloperator; 
		$this->view_data['ddlapi'] =$ddlapi; 
		
		
		$recinfo = $this->db->query("select
								a.transaction_id,
								a.updated_by,
								a.user_id, 	
								
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
	c.company_name,
	a.commission_amount,
	a.add_date,
	a.update_time,
	a.operator_id,
	a.recharge_status,
	a.MdComm,
	a.MdId,
	a.DId,
	a.DComm,
	b.businessname,
	b.username,
	b.parentid,
	p.businessname as parent_name
	
	from tblrecharge a
	left join tblcompany c on a.company_id = c.company_id
	left join tblusers b on a.user_id = b.user_id
	left join tblusers p on b.parentid = p.user_id 
				
	where 
	
	Date(a.add_date) >= ? and
	Date(a.add_date) <= ? and
	if(? != 'ALL',a.recharge_status = ?,true) and
	if(? != 'ALL',a.ExecuteBy = ?,true) and
	if(? > 1,a.company_id = ?,true)
	
	 order by recharge_id desc limit 50",array($fromdate,$todate,$ddlstatus,$ddlstatus,$ddlapi,$ddlapi,$ddloperator,$ddloperator));
		
		
		
		$this->view_data['result_recharge'] = $recinfo;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/list_recharge_all_view',$this->view_data);			
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
			
				$Fromdate = $this->input->post('txtFromDate',true);
				$Todate = $this->input->post('txtToDate',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$ddlstatus = $this->input->post('ddlstatus',true);
				$ddloperator = $this->input->post('ddloperator',true);
				$ddlapi = $this->input->post('ddlapi',true);
				$ddluser = $this->input->post('ddluser',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->session->set_userdata("ddlstatus",$ddlstatus);
				$this->session->set_userdata("ddloperator",$ddloperator);
				$this->session->set_userdata("ddlapi",$ddlapi);
				$this->session->set_userdata("ddluser",$ddluser);
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
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddlapi","ALL");
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}