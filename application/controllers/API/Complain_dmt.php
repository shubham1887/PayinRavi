<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain_dmt extends CI_Controller {
		 
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
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
	public function pageview()
	{
		
		$user_id = $this->session->userdata("ApiId");
		$start_row = intval($this->uri->segment(4));
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		
		$result = $this->db->query("select complain_id from tblcomplain_dmt where complain_status = 'Pending' and user_id = ?",array($user_id));
		
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."API/complain_dmt/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("SELECT 
a.complain_id,a.dmr_id,a.complain_date,a.complainsolve_date,a.complain_status,a.message,a.complain_type,a.response_message,
b.order_id,b.unique_id,b.add_date,b.RemiterMobile,b.AccountNumber,b.IFSC,b.Amount,b.Status,b.RESP_status,b.RESP_opr_id,b.RESP_name,b.API,b.refund_date,
c.businessname,c.username,
c.usertype_name
FROM `tblcomplain_dmt` a
left join mt3_transfer b on a.dmr_id = b.Id
left join tblusers c on a.user_id = c.user_id
where a.user_id = ? 
order by complain_id desc
",array($user_id));
		$this->view_data['message'] =$this->msg;
		$this->view_data['cmpl_flag'] =0;
		$this->view_data['searchword'] ="";
		$this->view_data['from'] ="";
		$this->view_data['to'] ="";
		$this->load->view('API/complain_dmt_view',$this->view_data);		
	}

	public function index() 
	{
	

				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login'); 
		}	 
		else 
		{ 
			$data['message']='';				
			if(isset($_POST["txtFrom"]) and isset($_POST["txtTo"]))
		    {
		        $from = $this->input->post("txtFrom");
		        $to = $this->input->post("txtTo");
		        $searchword = $this->input->post("txtSearch");
		        $total_row = 0;	
		        $user_id = $this->session->userdata("ApiId");
        		$this->view_data['pagination'] = "";
        		$this->view_data['result_complain'] = $this->db->query("SELECT 
        a.complain_id,a.dmr_id,a.complain_date,a.complainsolve_date,a.complain_status,a.message,a.complain_type,a.response_message,
        b.order_id,b.unique_id,b.add_date,b.RemiterMobile,b.AccountNumber,b.IFSC,b.Amount,b.Status,b.RESP_status,b.RESP_opr_id,b.RESP_name,b.API,b.refund_date,
        c.businessname,c.username,
        c.usertype_name
        FROM `tblcomplain_dmt` a
        left join mt3_transfer b on a.dmr_id = b.Id
        left join tblusers c on a.user_id = c.user_id
        where 
        a.user_id = ? and
        a.complain_date BETWEEN ? and ? and
        (a.complain_status != 'Pending' and a.complain_status != 'InProcess') and
        if(? != '',(b.AccountNumber = ? or b.order_id = ? or b.RemiterMobile = ? or b.Id = ?),true)
        order by complain_id desc
        ",array($user_id,$from,$to,$searchword,$searchword,$searchword,$searchword,$searchword));
        		$this->view_data['message'] =$this->msg;
        		$this->view_data['from'] =$from;
        		$this->view_data['to'] =$to;
        		$this->view_data['searchword'] =$searchword;
        		$this->load->view('API/complain_dmt_view',$this->view_data);		
		        
		    }
			else if($this->input->post("btnSubmit") == "Submit")
			{
				//print_r($this->input->post());exit;
				$Subject = $this->input->post("ddlcomp_tyoe",TRUE);
				$Message = $this->input->post("txtMessage",TRUE);
				if($this->input->post("ddlcomp_tyoe") == "Recharge Id")
				{
					$recharge_id = $this->input->post("recharge_id",TRUE);
				}
				else
				{
					$recharge_id = NULL;
				}
				
					
		$date = $this->common->getMySqlDate();
		$user_id = $this->session->userdata('ApiId');
		$str_query = "insert into tblcomplain_dmt(user_id,complain_date,complain_status,message,complain_type,dmr_id) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$date,'Pending',$Message,$Subject,$recharge_id));	
		$userinfo = $this->Userinfo_methods->getUserInfo($user_id);
		$this->load->model("Sms");	
		$this->Sms->complainsms($userinfo->row(0)->username,$userinfo->row(0)->businessname);		
		$this->pageview();			
			}
			else
			{
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}