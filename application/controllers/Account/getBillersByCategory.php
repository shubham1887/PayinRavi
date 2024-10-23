<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GetBillersByCategory extends CI_Controller {
	public function index()
	{	
		$this->load->model("Bbps");	
		$categoryId = "2";
		$coverage = "IND-GUJ-Ahmedabad";
		if(isset($_GET["categoryId"]))
		{
			$categoryId = trim($_GET["categoryId"]);
		}
			if(isset($_GET["coverage"]))
		{
			$coverage = trim($_GET["coverage"]);
		}
		//echo "sdf";exit;
		$billersCategory = $this->Bbps->GetBillersByCategory($categoryId,$coverage);
		print_r($billersCategory);exit;
		$xmlobj = (array)simplexml_load_string($billersCategory);
		if(isset($xmlobj[0]))
		{
			$dataobj = json_decode($xmlobj[0]);
			
			foreach($dataobj->Response as $row )
			{
				
				$Id = $row->Id;
				$BillerCategory = $row->BillerCategory;
				$BillerCategoryDesc = $row->BillerCategoryDesc;
				$BillerMode = $row->BillerMode;
				$BillerId = $row->BillerId;
				$BillerName = $row->BillerName;
				$AcceptAdHocPayment = $row->AcceptAdHocPayment;
				$PaymentAmtExactness = $row->PaymentAmtExactness;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$this->db->query("insert into bbps_BillersByCategory(Id,BillerCategory,BillerCategoryDesc,BillerMode,BillerId,BillerName,AcceptAdHocPayment,PaymentAmtExactness,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?,?)",array($Id,$BillerCategory,$BillerCategoryDesc,$BillerMode,$BillerId,$BillerName,$AcceptAdHocPayment,$PaymentAmtExactness,$add_date,$ipaddress));
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
