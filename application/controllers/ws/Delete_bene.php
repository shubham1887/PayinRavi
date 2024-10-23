<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete_bene extends CI_Controller {
	function __construct()
	{
			parent:: __construct();
			$this->load->model('New_post_model');
			$this->load->model('Language_model');
			$this->load->helper('string');
	}
	public function index()
	{ 
			$this->Language_model->set_lang("eng");
			
			$this->New_post_model->check_post_method();
				
				$_username = $this->input->post("username")?trim($this->input->post("username",true)):"";
				$_password = $this->input->post("password")?trim($this->input->post("password",true)):"";
				$_sendermobile = $this->input->post("sendermobile")?trim($this->input->post("sendermobile",true)):"";
				$_beneid = $this->input->post("beneid")?trim($this->input->post("beneid",true)):"";
				if($_username===""||$_password===""||$_sendermobile===""||$_beneid===""){
						$this->New_post_model->missing_parameter();	
				}
				else{
					$_username=$this->_dec_sec_data($_username);
					$_password=$this->_dec_sec_data($_password);
					$_sendermobile=$this->_dec_sec_data($_sendermobile);
					$_beneid=$this->_dec_sec_data($_beneid);
					$_mobile_len=strlen($_sendermobile);
				}
			
				if($_mobile_len<MOBILE_LEN){
						$this->New_post_model->wrong_mobile_len();	
				}
				
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where mobile_no = ? and password = ?",array($_username,$_password));
				$this->New_post_model->check_valid_upass($userinfo);
				
				$user_id = $userinfo->row(0)->user_id;
				$status = $userinfo->row(0)->status;
				$this->New_post_model->is_active_login($status);
				if($user_id=='2')
				{
						if($_sendermobile!='1111111111'){
							$delqur = "delete from beneficiaries where Id=".$_beneid." and sender_mobile='".$_sendermobile."'";
						}
						else{
							$delqur = "delete from beneficiaries where Id=".$_beneid;
						}
						$ressel = $this->db->query("select * from beneficiaries where Id=".$_beneid);
						$sptr = date("dmy");
						$arrsel = implode("__{$sptr}__",$ressel->row_array());
						$this->db->reset_query();
						$this->db->query($delqur);
						$this->query_logs($arrsel."__{$sptr}__".$delqur);
						$this->New_post_model->common_success_response("Beneficiary deleted successfully.");
				}
				else
				{
						$this->New_post_model->common_error_response(UNAUTH_ERROR);	
				}
	}	
	private function _dec_sec_data($ciphertext){
		$key = trim("thisiskeyformmin");
		$ciphertext = strtr(
				$ciphertext,
				array(
						'.' => '+',
						'-' => '=',
						'~' => '/'
				)
		);$original_plaintext="";
		$c = base64_decode($ciphertext);
		$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len=32);
		$ciphertext_raw = substr($c, $ivlen+$sha2len);
		$original_plaintext = @openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
		if($original_plaintext!==""){ $calcmac="";
			$calcmac = @hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
			if($calcmac!==""&&is_string($calcmac)){
				if (hash_equals($hmac, $calcmac))
				{
					return $original_plaintext;
				}
			}
		}
		return "error";
	}
	private function query_logs($qur)
	{
		$log  = "Query: ".$qur.PHP_EOL.
        "-------------------------".PHP_EOL;
		$filename ='checkquerylogs/deletebene_'.date("j.n.Y").'.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		file_put_contents('checkquerylogs/deletebene_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
	}
}