<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {
	
	
	
	private $msg='';
function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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
	public function pageview()
	{
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['pagination'] = "";
		$this->view_data['result_api'] = $this->db->query("
		select a.*
		from tblbanners a where a.host_id = ?
		order by a.Id desc",array($this->session->userdata("SdId")));
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/banner_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

	    if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
			 
			    $user_id = $this->session->userdata("SdId");
			    if (is_uploaded_file($_FILES['banner']['tmp_name'])) 
        	    {
        	      
        	        $file_ext=strtolower(end(explode('.',$_FILES['banner']['name'])));
                    $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                    if(in_array($file_ext,$expensions)=== false)
                    {
                        redirect(base_url()."SuperDealer/banner");
                    }
                    else
                    {
                        $response .= "\nFile Found";
                        $uploads_dir = "uploads/banners/".$this->common->getDate().$user_id.$_FILES["banner"]["name"];
                        $tmp_name = $_FILES['banner']['tmp_name'];
                        $pic_name = $_FILES['banner']['name'];
                        $response .= "\nFile Name : ".$_FILES['banner']['name'];
                        move_uploaded_file($tmp_name, $uploads_dir);
                        $inuploads_dir = base_url().$uploads_dir;
                        $this->db->query("insert into tblbanners(imageurl,status,add_date,ipaddress,host_id) values(?,?,?,?,?)",array($inuploads_dir,1,$this->common->getDate(),$this->common->getRealIpAddr(), $user_id));
                        
                        $response .= "\nFile Uploaded Successfully to the server";
                        redirect(base_url()."SuperDealer/banner");
                    }     
                }
				
			}
			else if($this->input->post("hidaction") == "Set")
			{
			    $user_id = $this->session->userdata("SdId");
			    $hiduserid = $this->input->post("hiduserid");
			    $hidstatus = $this->input->post("hidstatus");
			    $this->db->query("update tblbanners set status = ? where Id = ? and host_id = ?",array($hidstatus,$hiduserid,$user_id));
			    redirect(base_url()."_Admin/banner");
			}
			else if($this->input->post("hidaction") == "DELETE")
			{
			    
			    $user_id = $this->session->userdata("SdId");
			    $hiduserid = $this->input->post("hiduserid");
			    //echo  $this->input->post("hiduserid");exit;
			    $this->db->query("delete from tblbanners  where Id = ? and host_id = ?",array($hiduserid,$user_id));
			    redirect(base_url()."SuperDealer/banner");
			}
			else
			{
				    $this->pageview();
			}
		} 
	}	
}