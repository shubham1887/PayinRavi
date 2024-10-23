<?php defined('BASEPATH') OR exit('No direct script access allowed');
class New_post_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->helper(array("url", "text"));
        define("LOGIN_TOKEN", "login_token");
				define("NEW_LOGIN_TOKEN", "new_login_token");
				define("NEW_LOGIN_DEVICE", "new_login_device");
				define("NEW_LOGIN_OTP", "new_login_otp");
				define("BUSINESS_NAME", "business_name");
				define("CONTACT_PERSON", "contact_person");
				define("USER_ID", "user_id");
				define("USER_DOB", "user_dob");
				define("USER_MOBILE", "user_mobile");
				define("USER_WHATSAPP", "user_whatsapp");
				define("USER_TYPE", "user_type");
				define("USER_ADDRESS", "user_address");
				define("USER_PINCODE", "user_pincode");
				define("USER_PANNO", "user_panno");
				define("USER_EMAIL", "user_email");
				define("USER_CITY", "user_city");
				define("USER_STATE", "user_state");
				define("CITY_ID", "city_id");
				define("STATE_ID", "state_id");
				define("USER_BALANCE", "user_balance");
				define("USER_KYC","user_kyc");
				define("USER_FLAG1","user_flag1");
        define("LOCATION_FLAG", "location_flag");
				define("SUCCESS_STATUS",0);
				define("ERROR_STATUS",1);
				define("LOGINOTP_STATUS",2);
				define("WRONG_LOGIN_STATUS",3);
				define("ERROR_DATA_KEY","error");
				define("ERROR_DATA_VAL","error");
				define("SUCCESS_DATA_KEY","success");
				define("SUCCESS_DATA_VAL","success");
				define("FORGOT_TOKEN", "forgot_token");
				define("PASSWORD_MIN_LEN",6);
				define("PASSWORD_MAX_LEN",15);
				define("MOBILE_LEN",10);
				define("ALL_OTP_LEN",4);define("PINCODE_LEN",6);
				define("SIGNUP_MSG","signup_msg");
				define("REC_PER_PAGE",20);
				define("CUR_PAGE","current_page");
				define("TOT_PAGE","total_page");
				define("OPRT_NAME","operator");
    }
		public function missing_parameter(){
				$resparray = array(
				"message"=>MIS_PARA,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function is_active_login($status){
			if($status !== '1')
			{
				$this->inactive_login();
			}
		}
		public function inactive_login(){
				$resparray = array(
				"message"=>INACTIVE_LOGIN,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function check_post_method(){
			if($this->input->server('REQUEST_METHOD') != 'POST')
			{
				$this->wrong_method();
			}	
		}
		public function check_get_method(){
			if($this->input->server('REQUEST_METHOD') != 'GET')
			{
				$this->wrong_method();
			}	
		}
		public function wrong_method(){
				$resparray = array(
				"message"=>WRONG_LOGIN_METHOD,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');	
				echo json_encode($resparray);exit;	
		}
		public function wrong_input(){
				$resparray = array(
				"message"=>WRONG_INPUT,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;
		}
		public function check_valid_upass($result){
			if($result->num_rows()<=0)
			{
				$this->wrong_upass();
			}
		}
		public function wrong_upass(){
				$resparray = array(
				"message"=>WRONG_UPASS,
				"status"=>WRONG_LOGIN_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function check_valid_user($result){
			if($result->num_rows()<=0)
			{
				$resparray = array(
				"message"=>WRONG_USER,
				"status"=>WRONG_LOGIN_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;
			}
		}
		public function check_valid_user_mobile($result){
			if($result->num_rows()<=0)
			{
				$this->wrong_user_mobile();
			}
		}
		public function wrong_user_mobile(){
				$resparray = array(
				"message"=>WRONG_USER_MOBILE,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function check_valid_company($result){
			if($result->num_rows()<=0)
			{
				$this->wrong_company();
			}
		}
		private function wrong_company(){
				$resparray = array(
				"message"=>WRONG_COMPANY,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function wrong_mobile_len($type="mobile"){
				$_message=WRONG_MOBILE_LENGTH;
				if($type!=="mobile")$_message=WRONG_WHATSAPP_LENGTH;
				$resparray = array(
				"message"=>$_message,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function wrong_pincode_len(){
				$resparray = array(
				"message"=>WRONG_PINCODE_LENGTH,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function common_success_response($msg="",$status="",$data=array()){
				if(trim($msg)===""){
					$msg=COMMON_SUCCESS_MSG;
				}
				if(trim($status)===""){
					$status=SUCCESS_STATUS;
				}
				if(count($data)<=0){
					$data=array(SUCCESS_DATA_KEY=>SUCCESS_DATA_VAL);
				}
				$resparray = array(
				"message"=>$msg,
				"status"=>$status,
				"data"=>$data);
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function common_success_data($data,$page=0,$totalpage=0){
				if($page>0&&$totalpage>0){
					$resparray = array(
					"message"=>SUCCESS_DATA_KEY,
					"status"=>SUCCESS_STATUS,
					CUR_PAGE=>$page,
					TOT_PAGE=>$totalpage,
					"data"=>$data);
				}
				else{
					$resparray = array(
					"message"=>SUCCESS_DATA_KEY,
					"status"=>SUCCESS_STATUS,
					"data"=>$data);	
				}
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function common_success_roffer($data,$mobile=0,$opr=''){
				if($mobile>0&&$opr!==''){
					$resparray = array(
					"message"=>SUCCESS_DATA_KEY,
					"status"=>SUCCESS_STATUS,
					USER_MOBILE=>$mobile,
					OPRT_NAME=>$opr,
					"data"=>$data);
				}
				else{
					$resparray = array(
					"message"=>SUCCESS_DATA_KEY,
					"status"=>SUCCESS_STATUS,
					"data"=>$data);	
				}
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function common_error_response($msg=""){
				if(trim($msg)===""){
					$msg=COMMON_ERROR_MSG;
				}
				$resparray = array(
				"message"=>$msg,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;	
		}
		public function tech_err_response(){
				$resparray = array(
				"message"=>TECH_ERROR_MSG,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;
		}
		public function insert_data($tblname,$insdata){
				$this->db->reset_query();$insert_id=0;
				$this->db->insert($tblname, $insdata);
				$insert_id = $this->db->insert_id();
				return  $insert_id;	
		}
		public function update_data($tblname,$upddata,$arrwhr){
				$this->db->reset_query();
				$this->db->where($arrwhr);
				if ($this->db->update($tblname, $upddata)) {
					return $this->db->affected_rows(); 
				} else { 
					return 0; 
				} 	
		}
		public function select_data($tblname,$fields,$arrwhr=array()){
				$this->db->reset_query();$this->db->cache_off();
				$this->db->select($fields);
				if(count($arrwhr)>0){
					$this->db->where($arrwhr);
				}
				return $this->db->get($tblname);
		}
		public function get_decimal_digit($val){
			return (floor($val*100)/100);
		}
		public function is_valid_email($email){
			if(!$this->check_email_format($email)){
				$resparray = array(
				"message"=>WRONG_EMAIL,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;
			}
		}
		private function check_email_format($str) {
			return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
		}
		public function is_valid_date($date,$format="Y-m-d"){
			if(!$this->check_date_format($date,$format)){
				$resparray = array(
				"message"=>WRONG_DATE,
				"status"=>ERROR_STATUS,
				"data"=>array(ERROR_DATA_KEY=>ERROR_DATA_VAL));
				header('Content-Type: application/json');
				echo json_encode($resparray);exit;
			}
		}
		private function check_date_format($date,$format="Y-m-d"){
				$d = DateTime::createFromFormat($format, $date);
    		return $d && $d->format($format) === $date;	
		}
}