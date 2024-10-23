<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class CreateScheme extends MY_Controller {
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

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}  
		else 
		{ 



		$data['message']='';	

			if(isset($_POST["txtscheme"]) and isset($_POST["txtschemDesc"]) and isset($_POST["txtamount"]) and isset($_POST["addtype"]) and isset($_POST["ddlschemType"]))
			{
		
					$user_id =  $this->session->userdata("SdId");	
					$txtscheme = $this->input->post("txtscheme",TRUE);
					$txtschemDesc = $this->input->post("txtschemDesc",TRUE);	
					$txtamount = $this->input->post("txtamount",TRUE);	
					$addtype = $this->input->post("addtype",TRUE);	
					//$ddlschemType = $this->input->post("ddlschemType",TRUE);	
					$ddlschemType = "Agent";


					$check_group = $this->db->query("select Id from tblgroup where user_id = ? and group_name = ?",array($user_id,$txtscheme));
					if($check_group->num_rows() == 1)
					{
						$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
						$this->session->set_flashdata('MESSAGEBOX', "Group Already Exist. Please Try Different Name");
						redirect("SuperDealer_new/CreateScheme");
					}
					else
					{
						$insert_rslt = $this->db->query("insert into tblgroup(group_name,description,groupfor,min_balance,add_date,ipaddress,user_id) values(?,?,?,?,?,?,?)",
						array($txtscheme,$txtschemDesc,$ddlschemType,$txtamount,$this->common->getDate(),$this->common->getRealIpAddr(),$user_id));
						if($insert_rslt == true)
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
							$this->session->set_flashdata('MESSAGEBOX', "Group Created Successfully");
							redirect("SuperDealer_new/CreateScheme");
						}
						else
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
							$this->session->set_flashdata('MESSAGEBOX',"Failure. Please Try Again");
							redirect("SuperDealer_new/CreateScheme");
						}
					}
				}
			else if(isset($_GET["trackwind"]))
			{
				$group_id = trim($this->input->get("trackwind"));
				$user_id = $this->session->userdata("SdId");
				$rslt_delete = $this->db->query("delete from tblgroup where user_id = ? and Id = ?",array($user_id,$group_id));
				if($rslt_delete == true)
				{
					$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
					$this->session->set_flashdata('MESSAGEBOX', "Group Deleted Successfully");
					redirect("SuperDealer_new/CreateScheme");
				}
				else
				{
					$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
					$this->session->set_flashdata('MESSAGEBOX',"Failure. Please Try Again");
					redirect("SuperDealer_new/CreateScheme");
				}
			}
			else
			{
				$user_id = $this->session->userdata("SdId");
				$data['result_scheme']=$this->db->query("select Id,group_name,description,add_date,groupfor,min_balance,service,user_id from tblgroup where user_id = ?",array($user_id));
				$data['message']='';
				$this->load->view('SuperDealer_new/CreateScheme_view',$data);
			}
		} 			
	}
}
?>