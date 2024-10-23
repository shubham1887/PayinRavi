<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserProfile extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
{ 
redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if(isset($_POST["txt_frm_date"]) and isset($_POST["txt_to_date"]))
			{
			
				$from = $this->input->post('txt_frm_date',true);
				$to = $this->input->post('txt_to_date',true);
			
    			$ddldb = $this->input->post("ddldb",TRUE);
			    
			    $this->session->set_userdata("FromDate",$from);
			    $this->session->set_userdata("ToDate",$to);
			    $this->session->set_userdata("ddldb",$ddldb);
			    
			    $this->pageview();	
			}					
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
					$this->view_data['userdata'] = $this->db->query("
						select 
						a.user_id,a.businessname,
						a.mobile_no,a.username,
						a.add_date,
						state.state_name,
						city.city_name,
						info.postal_address,
						info.pincode,
						info.emailid,
						info.birthdate,
						info.aadhar_number,
						info.pan_no,
						info.gst_no,
						a.terms_and_conditions,
						a.kyc

						from tblusers a 
						left join tblusers_info info on a.user_id = info.user_id
						left join tblstate state on a.state_id = state.state_id
						left join tblcity city on a.city_id = city.city_id
						
						where a.user_id = ?
						",array($this->session->userdata('DistId')));

					

					$doc_array = array();
					$doc_rslt = $this->db->query("
						SELECT user_id,doc_type,image_path,status FROM mpay_documents.documents where user_id = ? and status = 'APPROVED' ",array($this->session->userdata('DistId')));
					if($doc_rslt->num_rows() > 0)
					{
						foreach($doc_rslt->result() as $rwdoc)
						{
							$doc_array[$rwdoc->doc_type] = 	$rwdoc->image_path;
						}
						
					}

					$this->view_data['userdocs'] = $doc_array;
					$this->view_data['message'] =$this->msg;
					$this->load->view('Distributor_new/UserProfile_view',$this->view_data);			
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function SubPaymentLoad()
	{
		header('Content-Type: application/json');


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		 $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->fromDate) and isset($json_obj->toDate))
          {

            $from =  date_format(date_create(trim((string)$json_obj->fromDate)),'Y-m-d');
            $to =  date_format(date_create(trim((string)$json_obj->toDate)),'Y-m-d');
/*
		{"StatusCode":1,"Message":"Success","TotalAmount":225860.000,
		"Data":[
		{
			"OrderId1":0,
			"OrderID":"1760808",
			"TransactionType":"Credit",
			"CreditUser":"8080801887-sai-sai prasad",
			"DebitUser":"7666075076-peher-sai prasad",
			"TxnDate":"20-03-2021",
			"TxnTime":"11:19:23",
			"OpeningBalance":20179.690,
			"Amount":200.000,
			"ClosingBalnce":20379.690,
			"PaymentType":"Credit",
			"remarks":"Balance transfer from:7666075076-peher-sai prasad To:8080801887-sai-sai prasad ##d"}
			]}
		*/
		$str_query ="
				select 
				'0' as OrderId1,
				a.Id as OrderID,
				'Credit' as TransactionType,
				CONCAT_WS('-', cr.username, cr.businessname) as CreditUser,
				CONCAT_WS('-', dr.username, dr.businessname) as DebitUser,
				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBalance,
				a.credit_amount as Amount,
				a.balance as ClosingBalnce,
				a.payment_type as PaymentType,
				CONCAT_WS('-', a.description, a.remark) as remarks
				from tblewallet a
				left join tblpayment p on a.payment_id = p.payment_id
				left join tblusers cr on p.cr_user_id = cr.user_id 
				left join tblusers dr on p.dr_user_id = dr.user_id 
				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=? and
				a.transaction_type = 'PAYMENT' 
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("DistId")));
				

				if($result->num_rows() > 0)
				{
						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"Total"=>0,
							"Success"=>0,
							"Pending"=>0,
							"Failure"=>0,
							"Reversal"=>0,
							"Data"=>$result->result()
					);
					echo json_encode($resp_array);exit;
				}
				else
				{
					$resp_array = array(
			"StatusCode"=>2,
			"Message"=>"Data Not Found.",
			"Total"=>0,
			"Success"=>0,
			"Pending"=>0,
			"Failure"=>0,
			"Reversal"=>0,
			"Data"=>null
		);
		echo json_encode($resp_array);exit;
				}



		
	}
	}
}