<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GetBillersCategories extends CI_Controller {
	public function index()
	{	
		$this->load->model("Bbps");	
		$billersCategory = $this->Bbps->getBillerCategories();
		$xmlobj = (array)simplexml_load_string($billersCategory);
		if(isset($xmlobj[0]))
		{
			$dataobj = json_decode($xmlobj[0]);
			foreach($dataobj->Response as $row )
			{
				$Id = $row->Id;
				$Name = $row->Name;
				$this->db->query("insert into bbps_BillerCategories(Id,Name,add_date,ipaddress) values(?,?,?,?)",array($Id,$Name,$this->common->getDate(),$this->common->getRealIpAddr()));
			}
		}
	}
	public function callurl($url)
	{	
		// $username;exit;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_TIMEOUT,15);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
}
