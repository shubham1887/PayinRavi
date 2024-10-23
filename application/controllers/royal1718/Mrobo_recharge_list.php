<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mrobo_recharge_list extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
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
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$txtLapuNumber = $this->input->post("txtLapuNumber",TRUE);

				$txtRecNumber = $this->input->post("txtRecNumber",TRUE);
				
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mrobo'] = $this->db->query("
					select * from lapu_recharge_history 
					where 
					recharge_date BETWEEN ? and ?  and
					if(? != '',lapu_no = ?,true)

					order by Id",array($from_date,$to_date,$txtLapuNumber,$txtLapuNumber));

				//print_r($this->view_data['result_mrobo']->result());exit;

				$this->view_data['message'] =$this->msg;
				// $rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
				// $rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
				// $this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
				// $this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['LapuNumber']  = $txtLapuNumber;
				$this->view_data['RecNumber']  = $txtRecNumber;
				$this->view_data['ddlpaymenttype']  = "ALL";
				$this->load->view('royal1718/Mrobo_recharge_list_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from_date = $to_date  = $this->common->getMySqlDate();
					$this->view_data['pagination'] = NULL;
					$this->view_data['result_mrobo'] = $this->db->query("select * from lapu_recharge_history where recharge_date = ? order by Id",array($from_date));

					//print_r($this->view_data['result_mrobo']->result());exit;

					$this->view_data['message'] =$this->msg;
					// $rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
					// $rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
					// $this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
					// $this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['LapuNumber']  = "";
					$this->view_data['RecNumber']  = "";
					$this->view_data['ddlpaymenttype']  = "ALL";
					$this->load->view('royal1718/Mrobo_recharge_list_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
}