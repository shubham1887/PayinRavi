<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Smsapisetting extends CI_Controller {	
		private $msg='';
	public function pageview()
	{
		$rslt = $this->db->query("select * from common where param = 'smsapi'");
		$rslt_smscharge = $this->db->query("select * from common where param = 'smscharge'");
		$rslt_smssuccess = $this->db->query("select * from common where param = 'smssuccess'");
		$rslt_smsfailure = $this->db->query("select * from common where param = 'smsfailure'");
		
		$rslt_smsbal = $this->db->query("select * from common where param = 'smsbal'");
		$rslt_smslst = $this->db->query("select * from common where param = 'smslst'");
		
		$succ_flag = $rslt->row(0)->value;
		$smscharge = $rslt_smscharge->row(0)->value;
		$success = $rslt_smssuccess->row(0)->value;
		$failure = $rslt_smsfailure->row(0)->value;
		
		$bal = $rslt_smsbal->row(0)->value;
		$lst = $rslt_smslst->row(0)->value;
		
		$this->view_data['message'] ="";
		$this->view_data['ActiveAPI'] =$succ_flag;
		$this->view_data['success'] =$success;
		$this->view_data['failure'] =$failure;
		
		$this->view_data['bal'] =$bal;
		$this->view_data['lst'] =$lst;
		
		$this->view_data['smscharge'] =$smscharge;
		$this->load->view('_Admin/smsapisetting_view',$this->view_data);		
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
			if($this->input->post("hidform") == "Set")
			{
				$hidvalue = $this->input->post("hidvalue",TRUE);
				
					$rslt = $this->db->query("update common set value => where param = 'smsapi'",array($hidvalue));
					$this->session->set_flashdata('message', 'SMS API Change Successful.');
					redirect('_Admin/smsapisetting');
				
				
			}		
			else if($this->input->post("txtsmscharge"))
			{
				$smscharge = $this->input->post("txtsmscharge");
				$rslt = $this->db->query("UPDATE common SET `value` = ? WHERE `common`.`param` ='smscharge'",array($smscharge));
				
				$this->pageview();
			}	
			
			else if($this->input->post("hidtype"))
			{
			//print_r($this->input->post());exit;;
				$value = $this->input->post("hidvalue");
				$type = $this->input->post("hidtype");
		
				$rslt = $this->db->query("UPDATE common SET value = ? WHERE param =?",array($value,$type));
				
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
?>