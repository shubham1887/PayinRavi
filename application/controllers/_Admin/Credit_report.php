<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_report extends CI_Controller {
	
	
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
				$ddluser = $this->input->post("ddluser",TRUE);
				
				$user_id = 1;
				$this->view_data['pagination'] = NULL;
				
				$this->view_data['result_mdealer'] = $this->db->query("SELECT b.businessname,a.Id,a.parent_id,a.chield_id,a.credit_amount,a.creditrevert,a.payment_received,a.outstanding,a.remark,a.add_date,a.transaction_date FROM `creditmaster` a left join tblusers b on a.chield_id = b.user_id
where Date(a.transaction_date) BETWEEN ? and ? and
if(? > 0,a.chield_id = ?,true) order by a.Id desc",array($from_date,$to_date,$ddluser,$ddluser));
				$this->view_data['message'] =$this->msg;
				//print_r($this->view_data['result_mdealer']->result());exit;
			
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['ddluser']  = $ddluser;
				
				$this->load->view('_Admin/credit_report_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from_date = $this->common->getMySqlDate();
					$to_date = $from_date;
					$ddluser = "ALL";
					
					$user_id = 1;
					$this->view_data['pagination'] = NULL;
					
					$this->view_data['result_mdealer'] = $this->db->query("SELECT b.businessname,a.Id,a.parent_id,a.chield_id,a.credit_amount,a.creditrevert,a.payment_received,a.outstanding,a.remark,a.add_date,a.transaction_date FROM `creditmaster` a left join tblusers b on a.chield_id = b.user_id
	where Date(a.transaction_date) BETWEEN ? and ? order by a.Id desc",array($from_date,$to_date));
					$this->view_data['message'] =$this->msg;
					
				
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['ddluser']  = $ddluser;
					
					$this->load->view('_Admin/credit_report_view',$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}