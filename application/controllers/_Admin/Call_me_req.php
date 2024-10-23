<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Call_me_req extends CI_Controller {
	
	
	private $msg=''; 
	private $message=''; 
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
		  
		    if($this->input->post('hidaction') == "Set")
			{		
								
				$status = $this->input->post("hidstatus",TRUE);
				$Id = $this->input->post("hidrechargeid",TRUE);
				$hidid = $this->input->post("hidid",TRUE);
				$this->db->query("update callreq set status = ?,remark = ?,last_update = ? where Id = ?",array($status,$hidid,$this->common->getDate(),$Id));
				
				
					redirect(base_url()."_Admin/call_me_req?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else if($this->input->post('btnSubmit'))
			{
			
				$txtNumber = $this->input->post('txtNumber',true);
				$this->view_data['rsltcallreq'] = $this->db->query("select 
		
            		a.Id,
            		a.user_id,
            		a.add_date,
            		a.status,
            		b.businessname,
            		b.username,
            		b.mobile_no,
            		p.businessname as parent_name,
            		p.username as parent_id
            		from callreq a 
            		left join tblusers b on a.user_id = b.user_id 
    			   left join tblusers p on b.parentid = p.user_id
    				where 
    			    (a.status = 'PENDING' or a.status = 'OPEN') and b.mobile_no = ?
    				order by a.Id",array($txtNumber));
    	
    		$this->load->view('_Admin/call_me_req_view',$this->view_data);	
			}
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				    $this->view_data['rsltcallreq'] = $this->db->query("select 
		
            		a.Id,
            		a.user_id,
            		a.add_date,
            		a.status,
            		a.remark,
            		b.businessname,
            		b.username,
            		b.mobile_no,
            		p.businessname as parent_name,
            		p.username as parent_id
            		from callreq a 
            		left join tblusers b on a.user_id = b.user_id 
    			   left join tblusers p on b.parentid = p.user_id
    				where 
    			    a.status = 'PENDING' or a.status = 'OPEN'
    				order by a.Id");
    	
    		$this->load->view('_Admin/call_me_req_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}