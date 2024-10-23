<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_callback extends CI_Controller {
	public function logentry($data)
	{

		$filename = "inlogs/aepsresp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
		write_file($filename." .\n", 'a+');
		write_file($filename, $this->common->getDate()."\n", 'a+');
		write_file($filename, $data."\n", 'a+');
		write_file($filename, $sapretor."\n", 'a+');
	}

	public function index()
	{ 


		$data = json_encode($this->input->get());
		$this->logentry("GET : ".$data);
		$data = json_encode($this->input->post());
		$this->logentry("POST : ".$data);
		$json = file_get_contents('php://input');
		$this->logentry("PHP INPUT : ".$json);
		echo "RESPONSE RECEIVED";exit;
	
	
	}	




}
