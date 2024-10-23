<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Zplushcash_test extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 error_reporting(E_ALL);
ini_set('display_errors', 1);
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function statuscheck()
    {

    	$bill_id = $this->input->get("bill_id");
    	//<URL>/apis/v1/utilitybill?action=checkpaymentstatus
    	$request_array = array(
			"agentmerchantid"=>$bill_id,
		);

		$url = 'http://zpluscash.com/apis/v1/utilitybill?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=checkpaymentstatus&data='.urlencode(json_encode($request_array));    	

		$resp_array = array();
		$response =  $this->common->callurl($url);
		$json_obj = json_decode($response);
		print_r($json_obj);exit;
    }
    public function getbillerZpluscash()
    {
		$request_array = array(
			"userid"=>"16",
		);

		$url = 'http://zpluscash.com/apis/v1/utilitybill?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=getbillers&data='.urlencode(json_encode($request_array));    	

		$resp_array = array();
		$response =  $this->common->callurl($url);
		$json_obj = json_decode($response);
		// foreach($json_obj->DATA as $rw)
		// {
		// 	$type = $rw->type;

		// 	$resp_array[$type] = array();
		// }

		foreach($json_obj->DATA as $rw)
		{
			$billerid = $rw->billerid;
			$biller = $rw->biller;
			$isinstantpay = $rw->isinstantpay;
			$billercode = $rw->billercode;
			$title = $rw->title;
			$type = $rw->type;

			if(!isset($resp_array[$type]))
			{
				$resp_array[$type] = array();
			}
			$temparray = array(
				"billerid"=>$rw->billerid,
				"biller"=>$rw->biller,
				"isinstantpay"=>$rw->isinstantpay,
				"billercode"=>$rw->billercode,
				"title"=>$rw->title,
				"type"=>$rw->type,
			);
			array_push($resp_array[$type],$temparray);


		}
		$str = '<table border=1>
					<tr>
					<th>billerName</th>
					<th>Type</th>
					<th>Code</th>
					<th>BillerId</th>
					</tr>';
		foreach($resp_array as $rwser)
		{
				foreach($rwser as $rwoptr)
				{
					$str .= '<tr>

							<td>'.$rwoptr["biller"].'</td>
							<td>'.$rwoptr["type"].'</td>
							<td>'.$rwoptr["billercode"].'</td>
							<td>'.$rwoptr["billerid"].'</td>
					</tr>';		
				}
			
		}
		$str .= '</table>';
		echo $str;exit;
    }


    public function paybillZpluscash()
    {
    	$billerid = "";
    	$service_no = "123456789";
    	$amount = "100";
    	$insert_id = "1231";

    	$order_id = 12345;
    	$is_check_api = true;
    	$done_by = "WEB";
    	$option3 = "";
    	$option2 = "";
    	$particulars = false;
    	$ref_id = 0;
    	$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' and mobile_no = '8080623623'");
    	$company_id = "262";
    	$Amount = "10";
    	$Mobile = "50000012525";
    	$CustomerMobile = "8238232303";
    	$remark = "test";
    	$option1 = "";
    	$this->load->model("BillPayment");
    	$resp = $this->BillPayment->recharge_transaction2($userinfo,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2,$option3,$done_by,$order_id,$is_check_api);
    	print_r($resp);exit;
    	exit;


		$request_array = array(
			"billerid"=>$billerid,
			"reference1"=>$service_no,
			"amount"=>$amount,
			"agentmerchantid"=>$insert_id,
		);

		$url = 'http://zpluscash.com/apis/v1/utilitybill?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=payment&data='.json_encode($request_array);    	

		echo $url;exit;
		$response =  $this->common->callurl($url);
		
		echo $str;exit;
    }
    

	
}
