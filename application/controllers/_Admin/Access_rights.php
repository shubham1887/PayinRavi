<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_rights extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$start_row = $this->uri->segment(4);

		$per_page = 20;
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Access_rights_model');
		$result = $this->Access_rights_model->get_access_rights();
		$total_row = $result->num_rows();	
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/access_rights/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = 20; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_access'] = $this->Access_rights_model->get_access_rights_limited($start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/access_rights_view',$this->view_data);		
	}
	public function getUsername()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$usertype= $this->input->get("usertype");
		$this->load->model('Access_rights_model');
		$result = $this->Access_rights_model->get_username($usertype);	
		echo "<option value='0'>--Select--</option>"; 
		for($i=0;$i<$result->num_rows();$i++)
		{
			echo "<option value='".$result->row($i)->user_id."'>".$result->row($i)->name."</option>"; 
		}
	}
	public function getStatus()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$user_id= $this->input->get("user_id");
		$module_name = $this->input->get("module_name");
		$this->load->model('Access_rights_model');
		$result = $this->Access_rights_model->get_access_rights_details($user_id,$module_name);	
		if($result->num_rows() == 1)
		{
		echo $result->row(0)->isActive."***".$result->row(0)->module_id;
		}
		else
		{
			echo "no***0";
		}
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
			if($this->input->post('SewarchBox'))
			{
				$SearchWord = $this->input->post("SewarchBox",TRUE);								
				$this->load->model('Access_rights_model');
				$result = $this->Access_rights_model->Search($SearchWord);		
				$this->view_data['result_access'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/access_rights_view',$this->view_data);						
			}					
			else if($this->input->post("hidmodule_id"))
			{
				$user_id = $this->input->post("hiduser_id",TRUE);
				$isMobile = $this->input->post("hidisMobile",TRUE);
				$isDTH = $this->input->post("hidisDTH",TRUE);	
				$isAIR = $this->input->post("hidisAIR",TRUE);					
				$module_id = $this->input->post("hidmodule_id",TRUE);	
				$this->load->model('Access_rights_model');
				if($this->Access_rights_model->add_update($user_id,$isMobile,$isDTH,$isAIR,$module_id) == true)
				{
					$this->msg ="Permission Granted Successfully.";
					$this->pageview();
				}
				else
				{
					
				}
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}
	public function InsertAccessRights()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$user_id = $this->input->post("id");
		$AIR = $this->input->post("AIR");
		$MOBILE = $this->input->post("MOBILE");
		$DTH = $this->input->post("DTH");
		$GPRS = $this->input->post("GPRS");
		$SMS = $this->input->post("SMS");
		$WEB = $this->input->post("WEB");
		
		$rlst_rights = $this->db->query("select * from tbluserrights where user_id = ?",array($user_id));
		if($rlst_rights->num_rows() < 1)
		{
			$str_query = "insert into tbluserrights(AIR,MOBILE,DTH,SMS,GPRS,WEB,user_id) values(?,?,?,?,?,?,?)";
			$rst = $this->db->query($str_query,array($AIR,$MOBILE,$DTH,$SMS,$GPRS,$WEB,$user_id));
		}
		else
		{
			$str_query = "update tbluserrights set AIR=?,MOBILE=?,DTH=?,SMS=?,GPRS=?,WEB=? where user_id=? ";
			$rst = $this->db->query($str_query,array($AIR,$MOBILE,$DTH,$SMS,$GPRS,$WEB,$user_id));
		}
		$this->pageview();
	}
	public function searchuser()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
			$searchWord = $this->input->post("hidsearch");
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_access'] = $this->db->query("select * from tblusers where (businessname like '%".$searchWord."%' or mobile_no like '%".$searchWord."%' or username like '%".$searchWord."%') and usertype_name = 'Agent'");
		$this->view_data['message'] ="";
		$this->load->view('_Admin/access_rights_view',$this->view_data);		
			
	}
}