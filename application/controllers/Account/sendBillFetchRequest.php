<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SendBillFetchRequest extends CI_Controller 
{
	public function index()
	{	
		$this->load->model("Bbps");	
		$agentId = 'TJ01TJ03000000000001';
		$billerId = 'MAHA00000MAH01';
		$mobileNumber = '9924160199';
		$customerParams = '170566996432|4603';
		$ip = $this->common->getRealIpAddr();
		$mac = 'BC-EE-7B-9C-F6-C0';
		
		
		
		$CustomerParamsByBillerId = $this->Bbps->SendBillFetchRequest($agentId,$billerId,$mobileNumber,$customerParams,$ip,$mac);
		
		
		$xmlobj = (array)simplexml_load_string($CustomerParamsByBillerId);
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
	
	public function GetClientMac()
	{
    $macAddr=false;
    $arp=`arp -n`;
    $lines=explode("\n", $arp);
print_r($lines);exit;
    foreach($lines as $line){
        $cols=preg_split('/\s+/', trim($line));

        if ($cols[0]==$_SERVER['REMOTE_ADDR']){
            $macAddr=$cols[2];
        }
    }

    return $macAddr;
}
	public function getmac()
	{
		$data = shell_exec("arp -an");
		echo $data;exit;
	}
	public function callurl($url)
	{	
		// $username;exit;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
}
