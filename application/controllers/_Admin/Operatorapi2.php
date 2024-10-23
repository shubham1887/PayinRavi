<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorapi2 extends CI_Controller {
	
	
	
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
			$data['message']='';	
			
			if($this->input->post("btnSearch") == "Search")
			{
				$ddlapi = $this->input->post("ddlapi",TRUE);
				$ddlcompany = $this->input->post("ddlcompany",TRUE);
				$this->view_data['pagination'] = "";
				
				
				
				$this->view_data['result_api'] = $this->db->query("
					select 
					    a.api_id,
					    a.company_id,
					    a.pendinglimit,
					    a.totalpending,
					    a.failurelimit,
					    a.priority,
					    a.status as operator_status,
					    a.multi_threaded,
					    a.reroot,
					    a.reroot_api_id,
					    a.statewise,
					    b.api_name,
					    b.username,
					    c.company_name 
					    from operatorpendinglimit a 
					    join tblapi b on a.api_id = b.api_id  
					    join tblcompany  c on a.company_id = c.company_id 
					    where 
					    if(? > 0 , a.api_id = ?,true) and 
					    if(? > 0 , a.company_id = ?,true) 
				",array($ddlapi,$ddlapi,$ddlcompany,$ddlcompany));
				$this->view_data['message'] =$this->msg;
				$this->view_data['ddlapi'] =$ddlapi;
				$this->view_data['ddlcompany'] =$ddlcompany;
				$this->load->view('_Admin/operatorapi2_view',$this->view_data);	
				
				
			}
			else if($this->input->post("company_id") and  $this->input->post("api_id"))
			{			
			
				$api_id = $this->input->post("api_id",TRUE);
				$company_id = $this->input->post("company_id",TRUE);
				$status = $this->input->post("status",TRUE);
				$pendinglimit = $this->input->post("pendinglimit",TRUE);
				$failurelimit = $this->input->post("failurelimit",TRUE);
				$priority = $this->input->post("priority",TRUE);
				$multi = $this->input->post("multi",TRUE);
				$reroot = $this->input->post("reroot",TRUE);
				$reroot_api_id = $this->input->post("reroot_api_id",TRUE);
				$series = $this->input->post("series",TRUE);
				
			
				
				$result = $this->db->query("select * from operatorpendinglimit where company_id = ? and api_id = ?",array($company_id,$api_id));
				if($result->num_rows() == 1)
				{
					$this->db->query("update operatorpendinglimit set status = ?,reroot = ?,reroot_api_id = ?,pendinglimit = ?,failurelimit = ?,priority = ?,update_date = ?,multi_threaded = ?,statewise = ? where company_id = ? and api_id = ?",array($status,$reroot,$reroot_api_id,$pendinglimit,$failurelimit,$priority,$this->common->getDate(),$multi,$series,$result->row(0)->company_id,$result->row(0)->api_id));
					
					$resp = array(
						"totalpending"=>$result->row(0)->totalpending
					);
					
					echo json_encode($resp);exit;
				}
				else
				{
					$this->db->query("insert into operatorpendinglimit(company_id,api_id,pendinglimit,failurelimit,priority,status,add_date,multi_threaded,statewise,reroot,reroot_api_id) 
					values(?,?,?,?,?,?,?,?,?,?,?)",
					array($company_id,$api_id,$pendinglimit,$failurelimit,$priority,$status,$this->common->getDate(),$multi,$series,$reroot,$reroot_api_id));
					echo "OK";exit;
				}
							
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					if(isset($_GET["mcrypt"]))
					{
						$company_id = $this->Common_methods->decrypt($this->input->get("mcrypt"));
				
						$this->view_data['pagination'] = "";
						$this->view_data['result_api'] = $this->db->query("
					select a.api_id,a.company_id,a.pendinglimit,a.totalpending,a.failurelimit,a.priority,a.status as operator_status,a.multi_threaded,a.reroot,a.reroot_api_id,a.statewise,b.api_name,b.username from operatorpendinglimit a join tblapi b on a.api_id = b.cpi_id  join tblcompany  c on a.company_id = c.company_id where a.api_id = ?
				",array($ddlapi));
						$this->view_data['message'] =$this->msg;
						$this->view_data['company_id'] =$company_id;
						$this->load->view('_Admin/operatorapi2_view',$this->view_data);		
					}
					else
					{
					
						$this->view_data['pagination'] = "";
						$this->view_data['result_api'] = false;
						$this->view_data['message'] =$this->msg;
						$this->view_data['company_id'] =0;
						$this->load->view('_Admin/operatorapi2_view',$this->view_data);		
					}
					
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}