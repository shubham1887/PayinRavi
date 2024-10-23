<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commonsettings extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_amounts_us'] = $this->db->query("select * from common where param = 'USamounts'");
		$this->view_data['result_amounts_ut'] = $this->db->query("select * from common where param = 'Uamounts'");
		
		$this->view_data['result_amounts_ds'] = $this->db->query("select * from common where param = 'DSamounts'");
		$this->view_data['result_amounts_dt'] = $this->db->query("select * from common where param = 'Damounts'");
		
		
		$this->view_data['result_amounts_bs'] = $this->db->query("select * from common where param = 'BSamounts'");
		$this->view_data['result_amounts_bt'] = $this->db->query("select * from common where param = 'Bamounts'");
		
		$this->view_data['result_bal'] = $this->db->query("select * from common where param = 'balancecheck'");
		$this->view_data['result_lst'] = $this->db->query("select * from common where param = 'last3transactions'");
		$this->view_data['result_belowrechargeamount'] = $this->db->query("select * from common where param = 'belowrechargeamount'");
		$this->view_data['result_belowrechargeamount_smscharge'] = $this->db->query("select * from common where param = 'belowrechargeamount_smscharge'");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/commonsettings_view',$this->view_data);		
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
			if($this->input->post("btnSubmit") == "Submit")
			{
			
				$balcheck = $this->input->post("txtbalcheck");
				$lstcheck = $this->input->post("txtlstcheck");
				$txtlowAmt = $this->input->post("txtlowAmt");
				$txtbsmscharge = $this->input->post("txtbsmscharge");
				
				
				$txtUSamounts = $this->input->post("txtUSamounts");
				$txtUTamounts = $this->input->post("txtUTamounts");
				
				$txtDSamounts = $this->input->post("txtDSamounts");
				$txtDTamounts = $this->input->post("txtDTamounts");
				
				$txtBSamounts = $this->input->post("txtBSamounts");
				$txtBTamounts = $this->input->post("txtBTamounts");
				
				$this->db->query("update common set value=? where param = 'USamounts'",array($txtUSamounts));
				$this->db->query("update common set value=? where param = 'Uamounts'",array($txtUTamounts));
				
				
				$this->db->query("update common set value=? where param = 'DSamounts'",array($txtDSamounts));
				$this->db->query("update common set value=? where param = 'Damounts'",array($txtDTamounts));
				
				$this->db->query("update common set value=? where param = 'BSamounts'",array($txtBSamounts));
				$this->db->query("update common set value=? where param = 'Bamounts'",array($txtBTamounts));
				
				
				$this->db->query("update common set value=? where param = 'balancecheck'",array($balcheck));
				$this->db->query("update common set value=? where param = 'last3transactions'",array($lstcheck));
				$this->db->query("update common set value=? where param = 'belowrechargeamount'",array($txtlowAmt));
				$this->db->query("update common set value=? where param = 'belowrechargeamount_smscharge'",array($txtbsmscharge));
				//$txtMaxRecAmount = $this->input->post("txtMaxRecAmount");
				//$this->db->query("update common set  value = ? where param = 'maxrecamount'",array($txtMaxRecAmount));
				$this->pageview();
			}
			
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		}
	}	
}