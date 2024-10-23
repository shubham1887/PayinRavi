<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manual_bank_entry extends CI_Controller {

    function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if($this->session->userdata('Adminusertype') != "ADMIN") 
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
	public function index()
	{
	     if($this->input->post("btnSubmit"))
		{
			$TxnDate = $this->input->post("txnDate");
			$Debit = $this->input->post("txtWithdrawal");
			$Credit = $this->input->post("txtDeposit");
			$Balance = "";
			$ddlNarration = trim($this->input->post("ddlNarration"));
			$txtDetails = $this->input->post("txtDetails");
		
			$txtbank_account_id = $this->input->post("ddlaccount");
			$Description = $ddlNarration;
		    $Cheque_no = "";
		    $BranchCode = "";
		   
		    $accountinfo = $this->db->query("select * from tblbankdetail where Id = ?",array($txtbank_account_id));
			if($accountinfo->num_rows() == 1)
			{
				$bank_account_id = $accountinfo->row(0)->Id;
				$bank_id = $accountinfo->row(0)->bank_id;
				$VaslueDate = "";
				$bankledgerinfo = $this->db->query("select * from tblBankLedger where transaction_date = ? and Withdrawal = ? and Deposit = ? and Balance = ? and Narration = ? and bank_id = ? and bank_account_id = ?",array($TxnDate,$Debit,$Credit,$Balance,$Description,$bank_id,$bank_account_id));
				if($bankledgerinfo->num_rows() == 0)
				{
				    
				    
				    if (is_uploaded_file($_FILES['image']['tmp_name'])) 
            	    {
            	        
						$imageFileType = strtolower(pathinfo($_FILES['image']['tmp_name'],PATHINFO_EXTENSION));
						$image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
  						$fp1 = 'data:image/'.$imageFileType.';base64,'.$image_base64;
						$image1 = true;
						
            	       
                    }
				   
					$this->db->query("insert into tblBankLedger(user_id,hostname,add_date,ipaddress,transaction_date,Withdrawal,Deposit,Balance,Narration,Details,bank_id,bank_account_id,branchcode,BankRefNo,sValueDate,image) 
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
					array(1,"account.quickapp.in",$this->common->getDate(),$this->common->getRealIpAddr(),$TxnDate,$Debit,$Credit,$Balance,$Description,$Cheque_no,$bank_id,$bank_account_id,$BranchCode,$Cheque_no,$VaslueDate,$fp1));
				
				}
			}
			
		    redirect(base_url()."Admin/manual_bank_entry");
		//	$this->load->view("Admin/manual_bank_entry_view",$this->view_data);	
			
		}
		else
		{
		
		
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["description"] = "";
			$this->view_data["ddlaccount"] = "";
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/manual_bank_entry_view",$this->view_data);
		}
		
	}
	
}

