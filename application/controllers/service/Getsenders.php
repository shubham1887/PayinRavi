<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getsenders extends CI_Controller {
	
	public function index()
	{ 
		$url = 'https://masterpay.pro/appapi1/getsender_temp';
		$curl = curl_init();

		curl_setopt_array
		(
			$curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"postman-token: 2021c20d-47ed-ed8b-378a-7bf00adc49a8"
			),
		)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$json_resp = json_decode($response);
		foreach($json_resp as $rw)
		{
			$checkremitterexist = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($rw->mobile));
			if($checkremitterexist->num_rows() == 0)
			{
				$rsltinsert = $this->db->query("insert into mt3_remitter_registration(add_date,ipaddress,mobile,name,lastname,pincode)
				values(?,?,?,?,?,?)",
				array(
				$this->common->getDate(),
				$this->common->getRealIpAddr(),
				$rw->mobile,
				$rw->name,
				$rw->lastname,
				$rw->pincode
				));
				if($rsltinsert == true)
				{
					echo file_get_contents("https://masterpay.pro/appapi1/getsender_temp/update_row?Id=".$rw->Id);
				}
			}
		}
	}	
}
