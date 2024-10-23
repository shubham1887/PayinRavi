<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddBalance extends CI_Controller {
	

	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
	public function index() 
	{
		//print_r($this->input->post());exit;
		if(isset($_POST["Select_UserName"]) and isset($_POST["cramount"]) and isset($_POST["crcomment"]) ) 	
		{
			$User_mobile = trim($this->input->post("Select_UserName"));
			$txtAmount = floatval(trim($this->input->post("cramount")));
			$txtRemark = trim($this->input->post("crcomment"));
			$Wallet_Type = trim($this->input->post("Wallet_Type"));
			if($txtAmount > 0)
			{
				$myBalance = $this->Common_methods->getAgentBalance($this->session->userdata("MdId"));
				if($myBalance >= $txtAmount)
				{
					$this->load->model("Common_methods");
					$userinfo = $this->db->query("select user_id,businessname,username,usertype_name from tblusers where username = ? and parentid = ?",array($User_mobile,$this->session->userdata("MdId")));
					if($userinfo->num_rows() == 1)
					{
						$description = $this->session->userdata("DistBusinessName")." To ".$userinfo->row(0)->businessname;
						$payment_type = "CASH";
						$cr_user_id = $userinfo->row(0)->user_id;



						if($Wallet_Type == "Wallet2")
						{

							$response = $response = $this->Ew2->DealerAddBalance($this->session->userdata("MdId"),$cr_user_id,$txtAmount,$txtRemark);
							//$this->Ew2->DealerAddBalance($this->session->userdata("MdId"),$cr_user_id,$txtAmount,$txtRemark);	
						}
						else
						{
							$response = $this->Common_methods->DealerAddBalance($this->session->userdata("MdId"),$cr_user_id,$txtAmount,$txtRemark);		
						}

						
						$json_obj = json_decode($response);	
						if(isset($json_obj->status) and isset($json_obj->message) )
						{
							$status = $json_obj->status;
							$message = $json_obj->message;
							if($status == "0")
							{
								$this->view_data['MESSAGEBOXTYPE'] ="success";
				        		$this->view_data['MESSAGEBOX'] = $message;
								redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData"));
							}
							else
							{
								$this->view_data['MESSAGEBOXTYPE'] ="error";
				        		$this->view_data['MESSAGEBOX'] = $message;
								redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData")); 
							}
						}
						else
						{
							$this->view_data['MESSAGEBOXTYPE'] ="success";
				        		$this->view_data['MESSAGEBOX'] = $message;
								redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					}
					else
					{
						$this->view_data['MESSAGEBOXTYPE'] ="error";
		        		$this->view_data['MESSAGEBOX'] ="InSufficient Balance";
						redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData")); 				
					}
					
				}
				else
				{
					$this->view_data['MESSAGEBOXTYPE'] ="error";
	        		$this->view_data['MESSAGEBOX'] ="InSufficient Balance";
					redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData")); 		
				}
			}
			else
			{
				$this->view_data['MESSAGEBOXTYPE'] ="error";
        		$this->view_data['MESSAGEBOX'] ="Invalid Amount Entered";
				redirect(base_url()."MasterDealer_new/AddBalance?crypt=".$this->Common_methods->encrypt("MyData")); 
			}
		}
		else
		{
			$this->view_data["message"] = "";
			$this->load->view("MasterDealer_new/AddBalance_view",$this->view_data);	
		}
		
	}
	public function FindUserDetails()
	{
		header("Content-Type:application/json");
		if(isset($_POST["requestType"]))
		{
			$requestType = trim($this->input->post("requestType"));
			$parentid = $this->session->userdata("MdId");
			$rsltdownline = $this->db->query("select username,businessname,mobile_no,usertype_name from tblusers where parentid = ? order by businessname",array($parentid));
			$dataarray = array();
			foreach($rsltdownline->result() as $rw)
			{
				$username = $rw->username;
				$businessname = $rw->businessname;
				$mobile_no = $rw->mobile_no;
				$usertype_name = $rw->usertype_name;
				$temparray = array(
					"Username"=>$username,
					"UserDetails"=>$username." - ".$businessname
				);
				array_push($dataarray,$temparray);
			}
			echo json_encode($dataarray);exit;
		}
	}	
}