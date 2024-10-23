<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Longcode_settings extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$this->view_data['pagination'] = NULL;
		$rslt = $this->db->query("select * from longcodeusers order by username");
		$this->view_data['longcodeusers'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/longcode_settings_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				
				$txtUsername = $this->input->post("txtUsername",TRUE);
				$txtKeyword = $this->input->post("txtKeyword",TRUE);
				$txtResponseUrl = $this->input->post("txtResponseUrl",TRUE);
				$this->db->query("insert into longcodeusers(username,url,keyword) values(?,?,?)",array($txtUsername,$txtResponseUrl,$txtKeyword));
				$this->msg ="Commission Add Successfully.";
				$this->pageview();
			}
			else if( $this->input->post("btnSubmit") == "Update") 
			{	
			//print_r($this->input->post());exit;
				$id = $this->input->post("hidId",TRUE);			
				$txtUsername = $this->input->post("txtUsername",TRUE);
				$txtKeyword = $this->input->post("txtKeyword",TRUE);

				$txtResponseUrl = $this->input->post("txtResponseUrl",TRUE);
				$this->db->query("update longcodeusers set username= ?,url= ?,keyword = ? where Id = ?",array($txtUsername,$txtResponseUrl,$txtKeyword,$id));
				$this->msg ="Commission Add Successfully.";
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