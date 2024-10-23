<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request extends CI_Controller {
	
	
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
			echo "LOGIN_FAILED";exit;
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
       
    }
	public function pageview()
	{
		$this->load->view('Distributor_new/payment_request_view',$this->view_data);		
	}
	public function MDTODealer()
	{
		$tabtype = $this->input->get("tabtype");
		$user_id = $this->session->userdata("DistId");
		$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
		if($userinfo->num_rows() == 1)
		{
			$parentid = $userinfo->row(0)->parentid;

$str = '<table class="table table-bordered table-striped table-hover">
        <thead style="background-color:whitesmoke;">
            <tr>

                <th>Order&nbsp;No</th>

                <th>Request&nbsp;To</th>
                <th>Mode</th>
                <th>Description</th>
                <th>Order&nbsp;₹</th>
                <th>Charge</th>
                <th>Net&nbsp;Amount</th>

                
                
                <th>Request&nbsp;Date </th>
                <th>##</th>
                

            </tr>
        </thead>
        <tbody id="tblbody">';

			$rslt = $this->db->query("select * from tblautopayreq where user_id = ? ",array($user_id));
			foreach($rslt->result() as $rw)
			{

				$request_to = "Distributor";
				if($rw->request_to == 1)
				{
					$request_to = "Admin";
				}
				$str .= '


    
            <tr class="tr" style="background:no-repeat;" onclick="tablerowshowdetail22( "ASHISH PATEL","ORD100002","Pending","Cash","ravikant","test","10.00","12/6/2020 1:17:33 PM",","0.00","10.00","Purchase Request")">

                <td>';



                if($rw->status == "Pending")
                {
					$str .= '<p style="margin-top:6px;">
                            <img src="/ashok-images/clock.svg" style="width: 20px;">
                        '.$rw->Id.'

                    </p>';
                }
                else if($rw->status == "Approve")
                {
						$str .= '<span style="font-size:0px;">SUCCESS</span><img style="height: 20px;width: 18px;margin-right:5px;max-width: 100%;padding: 0; border-radius:50%; background-color:green" src="http://maharshimulti.co.in/ashok-images/correct.svg">Approved';
                }
                else if($rw->status == "Reject")
                {
						$str .= '<p>
					                    <img style="height: 20px;width: 18px;margin-right:5px;max-width: 100%;padding: 0; border-radius:50%; background-color:red" src="http://maharshimulti.co.in/ashok-images/closes.svg">

					                <span style="font-size:0px;">Failure</span>Rejected
					            </p>';
                }

                    


               $str .= ' </td>






                <td><p style="margin-top:6px;">'.$request_to.'</p></td>
                <td>'.$rw->payment_type.'</td>
                <td>'.$rw->collection_by.'   '.$rw->client_remark.'  '.$rw->bank_name.'  '.$rw->bank_transfer_type.'  '.$rw->transaction_id.'</td>
                <td><p style="font-size:12px;text-align:center;">'.$rw->amount.'</p> </td>
                <td><p style="font-size:12px;text-align:center;">0.00</p> </td>
                <td>'.$rw->amount.'</td>

                <td>'.$rw->add_date.'</td>
                <td class="popupimagepurchase"><img data-toggle="modal" data-target="#m-d-fund-transfer12" src="/ashok-images/rightaeps.svg" /></td>
                

                


                
                

                
                

                

            </tr>
        

';

			}
			$str .='</tbody>
    </table>';
			echo $str;exit;
		}
	}
	public function R_Creditchk()
	{
		header('Content-Type: application/json');
		$user_id = $this->session->userdata("DistId");
		$MID = $this->input->get("MID");
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($userinfo->num_rows() == 1)
		{
			$parentid = $userinfo->row(0)->parentid;
			if($MID == "Admin")
			{
				$parentid = 1;
			}
			
		//echo $parentid."   ".$user_id;exit;

			$this->load->model("Credit_master");
			$credit = $this->Credit_master->getcredit($parentid,$user_id);

			$bank_array = array();
			 $rsltbank = $this->db->query("SELECT a.user_bank_id,a.account_name,a.ifsc_code,a.account_number,a.branch_name,b.bank_name FROM `tbluser_bank` a left join tblbank b on a.bank_id = b.bank_id");
			 foreach( $rsltbank->result() as $rwbank)
			 {
			 	$temparray = array(
			 		"Disabled"=>false,
			 		"Group"=>null,
			 		"Selected"=>false,
			 		"Text"=>$rwbank->bank_name,
			 		"Value"=>$rwbank->account_number
			 	);
			 	array_push($bank_array,$temparray);
			 }

			 $resp_array = array(
			 	"listbank"=>$bank_array,
			 	"walletinfo"=>array(),
			 	"diff"=>$credit 
			 );
			 echo json_encode($resp_array);exit;
			 echo '{"listbank":[{"Disabled":false,"Group":null,"Selected":false,"Text":"ICICI BANK","Value":"045205009464"}],"walletinfo":[{"Disabled":false,"Group":null,"Selected":false,"Text":"PHONE PE","Value":"9428556279"}],"diff":0.00}';
			echo '{"listbank":[{"ICICI","012355454"}],"walletinfo":[],"diff":'.$credit.'}';exit;

		}
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
			//print_r($this->input->post());exit;
			$data['message']='';	
			/*
			 [Payto] => Distributor
    [hdPaymentMode] => Cash
    [hdMDcollection] => ravikant
    [hdMDComments] => test
    [hdPaymentAmount] => 10
    [X-Requested-With] => XMLHttpRequest
			*/			
			if(isset($_POST["Payto"]) and isset($_POST["hdPaymentMode"]) and isset($_POST["hdMDcollection"])  and isset($_POST["hdMDComments"])  and isset($_POST["hdPaymentAmount"]))
			{
				$Payto = $this->input->post("Payto");
				$hdPaymentMode = $this->input->post("hdPaymentMode");
				$hdMDcollection = $this->input->post("hdMDcollection");
				$hdMDComments = $this->input->post("hdMDComments");
				$hdPaymentAmount = $this->input->post("hdPaymentAmount");
				if($Payto == "Distributor")
				{
					
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						 error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
							$parentid = $userinfo->row(0)->parentid;
							$transaction_id = "";
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = 0;
							$bank_transfer_type = "";
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}
				else if($Payto == "Admin")
				{
					
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						 error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
							$parentid =1;
							$transaction_id = "";
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = 0;
							$bank_transfer_type = "";
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}

			}
			else if(isset($_POST["Payto"]) and isset($_POST["hdPaymentMode"]) and isset($_POST["hdMDTransferType"])  and isset($_POST["hdMDBank"])  and isset($_POST["hdMDaccountno"]) and isset($_POST["hdMDutrno"]) and isset($_POST["hdPaymentAmount"]))
			{
				$Payto = $this->input->post("Payto");
				$hdPaymentMode = $this->input->post("hdPaymentMode");
				$hdMDTransferType = $this->input->post("hdMDTransferType");
				$hdMDBank = $this->input->post("hdMDBank");
				$hdMDaccountno = $this->input->post("hdMDaccountno");
				$hdMDutrno = $this->input->post("hdMDutrno");
				$hdPaymentAmount = $this->input->post("hdPaymentAmount");
				if($Payto == "Distributor")
				{
					
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						
							$parentid = $userinfo->row(0)->parentid;
							$transaction_id = $hdMDutrno;
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = $hdMDaccountno;
							$bank_transfer_type = $hdMDTransferType;
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_name,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$hdMDBank,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}
				else if($Payto == "Admin")
				{
					error_reporting(-1);
					ini_set('display_errors',1);
					$this->db->db_debug = TRUE;
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						
							$parentid = 1;
							$transaction_id = $hdMDutrno;
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = $hdMDaccountno;
							$bank_transfer_type = $hdMDTransferType;
							$hdMDcollection = "";
							$hdMDComments = "";
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_name,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$hdMDBank,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}

			}
			else if(isset($_POST["Payto"]) and isset($_POST["hdPaymentMode"]) and isset($_POST["hdMDComments"])  and isset($_POST["hdPaymentAmount"]) )
			{
				$Payto = $this->input->post("Payto");
				$hdPaymentMode = $this->input->post("hdPaymentMode");
				$hdMDComments = $this->input->post("hdMDComments");
				$hdMDTransferType = "";
				$hdMDBank = "";
				$hdMDaccountno = "";
				$hdMDutrno = "";
				$hdPaymentAmount = $this->input->post("hdPaymentAmount");
				if($Payto == "Distributor")
				{
					
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						
							$parentid = $userinfo->row(0)->parentid;
							$transaction_id = $hdMDutrno;
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = $hdMDaccountno;
							$bank_transfer_type = $hdMDTransferType;
							$hdMDcollection = "";
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_name,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$hdMDBank,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}
				else if($Payto == "Admin")
				{
					// error_reporting(-1);
					// ini_set('display_errors',1);
					// $this->db->db_debug = TRUE;
					$user_id = $this->session->userdata("DistId");
					$userinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($user_id));
					if($userinfo->num_rows() == 1)
					{
						
							$parentid = 1;
							$transaction_id = $hdMDutrno;
							$status = "Pending";
							$wallet_type = "Wallet1";
							$bank_account_id = $hdMDaccountno;
							$bank_transfer_type = $hdMDTransferType;
							$hdMDcollection = "";
							
							$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,host_id,collection_by,bank_account_id,bank_name,bank_transfer_type,request_to) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($user_id,$hdPaymentAmount,$hdPaymentMode,$transaction_id,$status,$this->common->getDate(),$this->common->getRealIpAddr(),$hdMDComments,$wallet_type,1,$hdMDcollection,$bank_account_id,$hdMDBank,$bank_transfer_type,$parentid));
							echo "Your purcharge Order Successfully.";exit;
					}
				}

			}



			if($this->input->post("btnSubmit") == 'Submit')
			{								
				$request_amount = $this->input->post("txtReqamt",TRUE);
				$payment_date = $this->input->post("txtPaymentdate",TRUE);
				$payment_mode = $this->input->post("ddlPaymod",TRUE);
				$deposite_time = $this->input->post("ddlDeptime",TRUE);
				$cheque_no = $this->input->post("txtChaqueno",TRUE);
				$cheque_date = $this->input->post("txtChaquedate",TRUE);				
				$client_bank_id = $this->input->post("ddlClientBank",TRUE);								
				$bank_id = $this->input->post("ddlDepositBank",TRUE);
				$remarks = $this->input->post("txtRemarks",TRUE);				
				$user_id =$this->session->userdata("id");								
				$this->load->model('Payment_request_model');
				if($this->Payment_request_model->addRequest($request_amount,$payment_date,$payment_mode,$deposite_time,$cheque_no,$cheque_date,$bank_id,$client_bank_id,$remarks,$user_id) == true)
				{
					$this->session->set_flashdata('message', 'Payment Request Submit Successfully.');
					redirect(base_url()."Retailer/payment_request");					
				}				
			}			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}