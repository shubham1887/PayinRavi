<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetAepsCallback extends CI_Controller {
	public function logentry($data)
	{

		$filename = "inlogs/aepscallback.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()."\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function index()
	{  
			$response = file_get_contents('php://input');
			$this->logentry($response);
			 
			$rsltpost = json_encode($this->input->post());
			$this->logentry($rsltpost);
			$rsltget = json_encode($this->input->get());
			$this->logentry($rsltget);	
	}	
}
