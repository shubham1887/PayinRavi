<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('url');
	}
	public function index()
	{
		$this->load->view('Home');
	}
	public function submitContactus()
	{
		$name = $this->input->post('name');	
		$email = $this->input->post('email');	
		$state = $this->input->post('state');	
		$city = $this->input->post('city');	
		$message = $this->input->post('message');
		
		$this->load->library('email');	
		$this->email->from('championsofttech@gmail.com', 'Contact Us | MasterMoney');
		$this->email->to('info@championsofttech.com');
		$this->email->subject('Contact Us | MasterMoney');
		$this->email->message('Name = >'.$name.'Email = >'.$email.'State = >'.$state.'City = >'.$city.'Message = >'.$message);
		if($this->email->send())
		{
		   //Success email Sent
		   //var_dump($this->email->print_debugger());
		   $this->session->set_flashdata("success","Email sent successfully."); 
		  //die('if');
		}else{
			$this->session->set_flashdata("error","Error in sending Email.");
		   //Email Failed To Send
		   //echo $this->email->print_debugger();
		}
		
		redirect(base_url().'landingpage'.'#contactus');
	}

}
