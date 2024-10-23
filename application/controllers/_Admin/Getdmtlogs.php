<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getdmtlogs extends CI_Controller {
	
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	    if ($this->session->userdata('aloggedin') != TRUE) 
	    {
	        echo "false";exit;
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
		    if(isset($_GET["dmr_id"]))
		    {
		       
		        $dmr_id = $this->input->get("dmr_id");
		        $recharge_info = $this->db->query("select Id from mt3_transfer where Id = ?",array($dmr_id));
		        if($recharge_info->num_rows() == 1)
		        {
		           
		            $loginfo = $this->db->query("select add_date,request,response from dmt_reqresp where dmt_id = ? 
		            order by Id",array($dmr_id));    
		        if($loginfo->num_rows() == 1)
		        {
		            $resparray = array(
		                "message"=>"success",
		                "status"=>0,
		                "request"=>$loginfo->row(0)->add_date.">>".$loginfo->row(0)->request,
		                "response"=>$loginfo->row(0)->response,
		                );
		            echo json_encode($resparray );exit;
		        }
		        else if($loginfo->num_rows() == 2)
		        {
		            
		            $response = '';
		            $request = "";
		            foreach($loginfo->result() as $rw)
		            {
		                $response .=$rw->response." <br> -------------------------<br>";
		                $request .= $rw->add_date.">>".$rw->request." <br> -------------------------<br>";
		            }
		            $resparray = array(
		                "message"=>"success",
		                "status"=>0,
		                "request"=>$request ,
		                "response"=>$response,
		                );
		            echo json_encode($resparray );exit;
		        }
		        else if($loginfo->num_rows() > 2)
		        {
		            $response = '';
		            $request = "";
		            foreach($loginfo->result() as $rw)
		            {
		                $response .=$rw->response." <br> -------------------------<br>";
		                $request .= $rw->add_date.">>".$rw->request." <br> -------------------------<br>";
		            }
		            $resparray = array(
		                "message"=>"success",
		                "status"=>0,
		                "request"=>$request ,
		                "response"=>$response,
		                );
		            echo json_encode($resparray );exit;
		        }
		        else
		        {
		            $resparray = array(
		                "message"=>"success",
		                "status"=>0,
		                "request"=>"No Data" ,
		                "response"=>"No Data",
		                );
		            echo json_encode($resparray);exit;
		        }
		        }
		        
		        
		      //  echo $loginfo->num_rows();exit;
		        
		    }
		} 
	}	
}