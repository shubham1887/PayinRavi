<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Raisecomplain extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		 	
			//print_r($this->input->post());exit;
			if(isset($_POST["ddlsubject"]) and isset($_POST["message"]))
			{
					error_reporting(-1);
					ini_set('display_errors',1);
					$this->db->db_debug = TRUE;
				$ddlsubject = $this->input->post('ddlsubject',true);
				$message = $this->input->post('message',true);
				$tranid = intval($this->input->post("tranid",TRUE));

			    if($ddlsubject == "Transaction Dispute")
			    {
			    	$recharge_info = $this->db->query("select recharge_id,amount,mobile_no,add_date,recharge_status,user_id from tblrecharge where recharge_id = ? and user_id = ? ",array($tranid,intval($this->session->userdata("SdId"))));	
			    	//print_r($recharge_info->num_rows());exit;
			    	if($recharge_info->num_rows() == 1)
			    	{
			    		$rsltcomplain = $this->db->query("select * from tblcomplain where recharge_id = ? and user_id = ?",array($tranid,intval($this->session->userdata("SdId"))));
			    		if($rsltcomplain->num_rows() == 0)
			    		{
			    			$this->db->query("insert into tblcomplain(list_id,transacation_id,recharge_id,user_id,complain_date,complain_status,message,complain_type,host_id)
			    				values(?,?,?,?,?,?,?,?,?)",
			    				array(0,0,$tranid,$this->session->userdata("SdId"),$this->common->getDate(),"Pending",$message,$ddlsubject,1));
			    			$this->view_data['MESSAGEBOXTYPE'] ="success";
	    				    $this->view_data['MESSAGEBOX'] ="Complain Raised Successfully";
	    					$this->view_data['message'] ="Complain Raised Successfully";
	    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);
			    		}
			    		else
			    		{
							$this->view_data['MESSAGEBOXTYPE'] ="error";
	    				    $this->view_data['MESSAGEBOX'] ="Complain Already Submitted";
	    					$this->view_data['message'] ="Complain Already Submitted";
	    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);	
			    		}
			    			
			    	}
			    	else
			    	{
			    		$this->view_data['MESSAGEBOXTYPE'] ="error";
    				    $this->view_data['MESSAGEBOX'] ="Please Enter a Valid TransactionId";
    					$this->view_data['message'] ="Please Enter a Valid TransactionId";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);	
			    	}
			    }
			    
			    else if($ddlsubject == "Sales Inquiry")
			    {
		    		$rsltcomplain = $this->db->query("select * from tblcomplain where message = ? and user_id = ?",array($message,intval($this->session->userdata("SdId"))));
		    		if($rsltcomplain->num_rows() == 0)
		    		{
		    			$this->db->query("insert into tblcomplain(list_id,transacation_id,recharge_id,user_id,complain_date,complain_status,message,complain_type,host_id)
		    				values(?,?,?,?,?,?,?,?,?)",
		    				array(0,0,$tranid,$this->session->userdata("SdId"),$this->common->getDate(),"Pending",$message,$ddlsubject,1));
		    			$this->view_data['MESSAGEBOXTYPE'] ="success";
    				    $this->view_data['MESSAGEBOX'] ="Complain Raised Successfully";
    					$this->view_data['message'] ="Complain Raised Successfully";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);
		    		}
		    		else
		    		{
						$this->view_data['MESSAGEBOXTYPE'] ="error";
    				    $this->view_data['MESSAGEBOX'] ="Complain Already Submitted";
    					$this->view_data['message'] ="Complain Already Submitted";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);	
		    		}
			    }
			    else if($ddlsubject == "Other Technical Support")
			    {
			    	$rsltcomplain = $this->db->query("select * from tblcomplain where message = ? and user_id = ?",array($message,intval($this->session->userdata("SdId"))));
		    		if($rsltcomplain->num_rows() == 0)
		    		{
		    			$this->db->query("insert into tblcomplain(list_id,transacation_id,recharge_id,user_id,complain_date,complain_status,message,complain_type,host_id)
		    				values(?,?,?,?,?,?,?,?,?)",
		    				array(0,0,$tranid,$this->session->userdata("SdId"),$this->common->getDate(),"Pending",$message,$ddlsubject,1));
		    			$this->view_data['MESSAGEBOXTYPE'] ="success";
    				    $this->view_data['MESSAGEBOX'] ="Complain Raised Successfully";
    					$this->view_data['message'] ="Complain Raised Successfully";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);
		    		}
		    		else
		    		{
						$this->view_data['MESSAGEBOXTYPE'] ="error";
    				    $this->view_data['MESSAGEBOX'] ="Complain Already Submitted";
    					$this->view_data['message'] ="Complain Already Submitted";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);	
		    		}
			    }
			    else if($ddlsubject == "Billing Inquiry")
			    {
					$rsltcomplain = $this->db->query("select * from tblcomplain where message = ? and user_id = ?",array($message,intval($this->session->userdata("SdId"))));
		    		if($rsltcomplain->num_rows() == 0)
		    		{
		    			$this->db->query("insert into tblcomplain(list_id,transacation_id,recharge_id,user_id,complain_date,complain_status,message,complain_type,host_id)
		    				values(?,?,?,?,?,?,?,?,?)",
		    				array(0,0,$tranid,$this->session->userdata("SdId"),$this->common->getDate(),"Pending",$message,$ddlsubject,1));
		    			$this->view_data['MESSAGEBOXTYPE'] ="success";
    				    $this->view_data['MESSAGEBOX'] ="Complain Raised Successfully";
    					$this->view_data['message'] ="Complain Raised Successfully";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);
		    		}
		    		else
		    		{
						$this->view_data['MESSAGEBOXTYPE'] ="error";
    				    $this->view_data['MESSAGEBOX'] ="Complain Already Submitted";
    					$this->view_data['message'] ="Complain Already Submitted";
    					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);	
		    		}
			    }


			    
			}  
			   
								
			
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{
				
					$this->view_data['message'] =$this->msg;
					$this->load->view('SuperDealer_new/Raisecomplain_view',$this->view_data);				
				}
				else
				{redirect(base_url().'login');}																								
			}
		 
	}
}