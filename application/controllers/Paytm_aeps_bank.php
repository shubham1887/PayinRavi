<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paytm_aeps_bank extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('url');
	}
	public function index()
	{
		$str = '{"responseMessage":"SUCCESS","responseCode":200,"requestId":"183721fb-608a-4fd4-9dcc-0520915219c4","payload":{"iinList":[{"iin":"111123","name":"ICICI"},{"iin":"111456","name":"HDFC"},{"iin":"111789","name":"AXIS"},{"iin":"990320","name":"Airtel Payment Bank"},{"iin":"608112","name":"Allahabad Bank"},{"iin":"607076","name":"Andhra Bank"},{"iin":"607198","name":"Andhra Pradesh Grameena Vikash Bank"},{"iin":"607121","name":"Andhra Pragathi Grameena Bank"},{"iin":"607024","name":"Aryavart Bank erstwhile Gramin Bank of Aryavart"},{"iin":"607064","name":"Assam Gramin Vikash Bank"},{"iin":"608087","name":"AU Small Finance Bank"},{"iin":"607153","name":"Axis Bank"},{"iin":"607063","name":"Bangiya Gramin Vikash Bank"},{"iin":"606985","name":"Bank Of Baroda"},{"iin":"508505","name":"Bank of India"},{"iin":"607387","name":"Bank of Maharashtra"},{"iin":"606995","name":"Baroda Gujarat Gramin Bank"},{"iin":"607280","name":"Baroda Rajasthan Kshetriya Gramin Bank"},{"iin":"606993","name":"Baroda Uttar Pradesh Gramin Bank "},{"iin":"607396","name":"Canara Bank"},{"iin":"607082","name":"Catholic Syrian Bank"},{"iin":"607264","name":"Central Bank of India"},{"iin":"607080","name":"Chaitanya Godavari Gramin Bank"},{"iin":"607214","name":"Chhattisgarh Rajya Gramin Bank"},{"iin":"607324","name":"City Union Bank "},{"iin":"607184","name":"Corporation Bank"},{"iin":"607136","name":"Dakshin Bihar Gramin Bank erstwhile Madhya Bihar Gramin Bank"},{"iin":"508547","name":"Dena Bank"},{"iin":"607218","name":"Ellaquai Dehati Bank"},{"iin":"508998","name":"Equitas Small Finance Bank"},{"iin":"607363","name":"Federal Bank"},{"iin":"817304","name":"Fincare Small Finance Bank"},{"iin":"608001","name":"Fino Payments Bank"},{"iin":"607152","name":"HDFC Bank"},{"iin":"607140","name":"Himachal Pradesh Gramin Bank"},{"iin":"508534","name":"ICICI Bank"},{"iin":"607095","name":"IDBI Bank"},{"iin":"608117","name":"IDFC First Bank"},{"iin":"608314","name":"India Post Payment Bank"},{"iin":"607105","name":"Indian bank"},{"iin":"607126","name":"Indian Overseas Bank"},{"iin":"607161","name":"Union Bank of India"},{"iin":"607232","name":"Madhyanchal Gramin Bank"},{"iin":"607000","name":"Maharashtra Gramin Bank "},{"iin":"607062","name":"Manipur Rural Bank "},{"iin":"607206","name":"Meghalaya Rural Bank"},{"iin":"607230","name":"Mizoram Rural Bank"},{"iin":"607060","name":"Odisha Gramya Bank "},{"iin":"508831","name":"Oriental Bank of Commerce"},{"iin":"607079","name":"Paschim Banga Gramin Bank"},{"iin":"607135","name":"Prathma UP Gramin Bank erstwhile Sarva UP Gramin Bank "},{"iin":"607054","name":"Puduvai Bharathiar Grama Bank"},{"iin":"607087","name":"Punjab & Sind Bank"},{"iin":"607138","name":"Punjab Gramin Bank"},{"iin":"607027","name":"Punjab National Bank"},{"iin":"607212","name":"Purvanchal Gramin Bank"},{"iin":"607509","name":"Rajasthan Marudhara Gramin Bank"},{"iin":"607393","name":"RBL"},{"iin":"607053","name":"Saptagiri Grameena Bank"},{"iin":"607139","name":"Sarva Haryana Gramin Bank"},{"iin":"607200","name":"Saurashtra Gramin Bank"},{"iin":"607119","name":"Shivalik Mercantile Cooperative Bank "},{"iin":"607475","name":"South Indian Bank"},{"iin":"607094","name":"State Bank of India"},{"iin":"607580","name":"Syndicate Bank"},{"iin":"607187","name":"Tamilnad Mercantile Bank"},{"iin":"607052","name":"TamilNadu Grama Bank erstwhile Pallavan Grama Bank"},{"iin":"607195","name":"Telangana Grameena Bank"},{"iin":"652150","name":"The Saraswat Co-operative Bank Ltd"},{"iin":"607065","name":"Tripura Gramin Bank"},{"iin":"607066","name":"UCO Bank"},{"iin":"508991","name":"Ujjivan Small Finance Bank Limited"},{"iin":"607234","name":"Utkal Gramin Bank"},{"iin":"607073","name":"Uttar Banga Kshetriya Gramin Bank "},{"iin":"607069","name":"Uttar Bihar Grameen Bank "},{"iin":"607197","name":"Uttarakhand Gramin Bank"},{"iin":"607020","name":"Vidarbha Konkan Gramin Bank"},{"iin":"607075","name":"Vijaya Bank"},{"iin":"607618","name":"YES Bank"},{"iin":"607022","name":"Madhya Pradesh Gramin Bank erstwhile Narmada Jhabua Gramin Bank"},{"iin":"607122","name":"Karnataka Vikas Grameena Bank "},{"iin":"508662","name":"Karur Vysya Bank"},{"iin":"607365","name":"Kashi Gomati Samyut Gramin Bank"},{"iin":"607399","name":"Kerala Gramin Bank"},{"iin":"990309","name":"Kotak Mahindra Bank"},{"iin":"607058","name":"Lakshmi Vilas Bank"},{"iin":"607270","name":"Karnataka Bank"},{"iin":"607400","name":"Karnataka Gramin Bank erstwhile Pragathi Krishna Gramin Bank"},{"iin":"607210","name":"Jharkhand Rajya Gramin Bank erstwhile Vananchal Gramin Bank"},{"iin":"607189","name":"IndusInd Bank"},{"iin":"607440","name":"Jammu & Kashmir Bank "},{"iin":"607808","name":"J& K Grameen Bank"},{"iin":"607131","name":"Tamil Nadu State Apex Co-operative Bank Ltd"}]}}';



		$json_obj = json_decode($str);
		if(isset($json_obj->responseMessage) and isset($json_obj->responseCode))
		{
			$responseMessage = $json_obj->responseMessage;
			$responseCode = $json_obj->responseCode;
			if($responseCode == "200")
			{
				$payload = $json_obj->payload;
				$iinList = $payload->iinList;
				foreach($iinList as $bk)
				{
					$iin = $bk->iin;
					$name = $bk->name;
					$this->db->query("insert into paytm_aeps_banks(Id,name) values(?,?)",array($iin,$name));
					//echo $iin." | ".$name;exit;
				}
			}
		}
	}
	

}
