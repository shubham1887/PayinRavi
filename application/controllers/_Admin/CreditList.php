<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreditList extends CI_Controller {
	
	
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
			
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$data_array = array();
					$rslt = $this->db->query("select b.user_id,a.chield_id,b.businessname,b.username,b.usertype_name,b.mobile_no from creditmaster a left join tblusers b on a.chield_id  = b.user_id
						where a.parent_id = 1 and a.chield_id != 1 
						group by a.chield_id
						");
					$this->load->model("Credit_master");
					$totalcredit = 0;
					foreach($rslt->result() as $rw)
					{
						$credit = $this->Credit_master->getcredit(1,$rw->user_id);
						$temparray = array(
							"user_id"=>$rw->user_id,
							"businessname"=>$rw->businessname,
							"mobile_no"=>$rw->mobile_no,
							"usertype_name"=>$rw->usertype_name,
							"credit"=>$credit
						);
						$totalcredit += $credit;
						array_push($data_array,$temparray);
					}
					$this->view_data['data_array']  = $data_array;
					$this->view_data['totalcredit']  = $totalcredit;
					$this->load->view('_Admin/CreditList_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
}