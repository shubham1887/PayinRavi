<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sms_format extends CI_Controller {
	public function index()
	{
		
		$this->load->view('Retailer/sms_format_view');		
	}	
}
