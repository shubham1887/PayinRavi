<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_entry extends CI_Controller {
	
	
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
			$data['message']='';	
		
			if($this->input->post("hidattribute") == "CASH_RECEIVE")
			{
				
				$ddluser = trim($this->input->post("ddluser",TRUE));
				$ddlbank = trim($this->input->post("ddlbank",TRUE));
				$txtAmount = trim($this->input->post("txtAmount",TRUE));
				$txtRemark = trim($this->input->post("txtRemark",TRUE));
				$txtDate = trim($this->input->post("txtDate",TRUE));
				$payment_id= trim($this->input->post("hidpayment_id",TRUE));
				
			
				
				$add_date = $this->common->getDate();
				$rslt_userinfo = $this->db->query("select a.user_id,info.autoaccounting from tblusers a  left join tblusers_info info on a.user_id = info.user_id where a.user_id = ? and a.host_id = 1",array($ddluser));
			    if($rslt_userinfo->num_rows() == 1)
				{
				   
			        $autoaccounting = $rslt_userinfo->row(0)->autoaccounting;
			        $user_id = $rslt_userinfo->row(0)->user_id;
			        if($autoaccounting == 'yes')
			        {
			            $this->load->model("credit_model");
			            $parent_id = 1;
			            $chield_id = $user_id;
			            $credit_amount =  0;
			            $creditrevert = 0;
			            $payment_received = $txtAmount;
			            $remark = $txtRemark;
			            $reference_id = 0;
			            $cash_ref_id = $payment_id;
			           
			            $resp = $this->credit_model->credit_debit_entry($transaction_date,$parent_id,$chield_id,$credit_amount,$creditrevert,$payment_received,$remark,$reference_id,$cash_ref_id);
			            if($resp == true)
			            {
			                $this->session->set_flashdata("MESSAGEBOXTYPE","success");
			                $this->session->set_flashdata("MESSAGEBOX","Cash Receive Entry Submitted Successfully");
			            }
			            else
			            {
			                $this->session->set_flashdata("MESSAGEBOXTYPE","danger");
			                $this->session->set_flashdata("MESSAGEBOX","Some Error Occured");
			            }
			        }
			        else
			        {
			             $this->session->set_flashdata("MESSAGEBOXTYPE","warning");
			             $this->session->set_flashdata("MESSAGEBOX","User Not Found IN Debtor List");
			        }
				        
				    
				}
				
				redirect(base_url()."_Admin/credit_entry");
				
			}
			
			else if($this->input->post("txtFrom") and $this->input->post("txtTo"))
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				    $from = $this->input->post("txtFrom");
				    $to = $this->input->post("txtTo");
				    
				    	$this->view_data['pagination'] = "";
                		$this->view_data['result_creditledger'] = $this->db->query("select 
                			a.*,
                			cr.businessname as bname,
                			cr.username as username,
                			cr.user_id as cr_user_id,
                			cr.usertype_name as usertype,
                			dr.businessname as dr_bname,
                			dr.username as dr_username,
                			dr.usertype_name as dr_usertype,
                			dr.user_id as dr_user_id,
                			cm.cash_ref_id
                			
                			from tblewallet a
                			left join tblpayment p on a.payment_id = p.payment_id
                			left join tblusers cr on p.cr_user_id = cr.user_id
                			left join tblusers dr on p.dr_user_id = dr.user_id
                			left join creditmaster cm on p.payment_id = cm.cash_ref_id
                			where 
                			a.user_id = 1 and 
                			DATE(a.add_date) >= ? and
                			DATE(a.add_date) <= ? and 
                			a.remark NOT LIKE  '%Commission%'
                			order by a.Id desc",array($from,$to));
                		$this->view_data['message'] =$this->msg;
                	    $this->view_data['from'] = $from;
                	    $this->view_data['to'] = $to;
                		
                		$this->load->view('_Admin/credit_entry_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				    $from=$to = $this->common->getMySqlDate();
				    	$this->view_data['pagination'] = "";
                		$this->view_data['result_creditledger'] = $this->db->query("select 
                			a.*,
                			cr.businessname as bname,
                			cr.username as username,
                			cr.user_id as cr_user_id,
                			cr.usertype_name as usertype,
                			dr.businessname as dr_bname,
                			dr.username as dr_username,
                			dr.usertype_name as dr_usertype,
                			dr.user_id as dr_user_id,
                			cm.cash_ref_id
                			
                			from tblewallet a
                			left join tblpayment p on a.payment_id = p.payment_id
                			left join tblusers cr on p.cr_user_id = cr.user_id
                			left join tblusers dr on p.dr_user_id = dr.user_id
                			left join creditmaster cm on p.payment_id = cm.cash_ref_id
                			where 
                			a.user_id = 1 and 
                			DATE(a.add_date) >= ? and
                			DATE(a.add_date) <= ? and 
                			a.remark NOT LIKE  '%Commission%'
                			order by a.Id desc",array($from,$to));
                		$this->view_data['message'] =$this->msg;
                	    $this->view_data['from'] = $from;
                	    $this->view_data['to'] = $to;
                		
                		$this->load->view('_Admin/credit_entry_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}
}