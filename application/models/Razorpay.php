<?php
class Razorpay extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getRAZOR_KEY_ID()
	{
		$rslt = $this->db->query("select value from admininfo where param = 'RAZOR_KEY_ID'");
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->value;
		}
		return false;
	}
	public function getRAZOR_KEY_SECRET()
	{
		$rslt = $this->db->query("select value from admininfo where param = 'RAZOR_KEY_SECRET'");
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->value;
		}
		return false;
	}
	public function order($amount,$order_id)// this api is for android app to register order in in razorpay
	{
		$url = 'https://api.razorpay.com/v1/orders';
        $amount=$amount*100;
        $key_id = $this->getRAZOR_KEY_ID();
        $key_secret = $this->getRAZOR_KEY_SECRET();
        $fields_string = "amount=".$amount."&currency=INR&receipt=".$order_id;
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
	}
	public function order_status($order_id)
	{
		$url = 'https://api.razorpay.com/v1/orders/'.$order_id.'/payments';
		$key_id = $this->getRAZOR_KEY_ID();
        $key_secret = $this->getRAZOR_KEY_SECRET();
       
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;

	}
	
}

?>