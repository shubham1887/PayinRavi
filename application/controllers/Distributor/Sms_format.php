<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sms_format extends CI_Controller {
	public function index()
	{
		
		$this->load->view('Distributor/sms_format_view');		
	}	
}
