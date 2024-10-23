<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlogs extends CI_Controller {
	
	
	
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
    	ini_set('memory_limit',-1);
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
		    if(isset($_GET["recharge_id"]))
		    {
		       
		        $recharge_id = $this->input->get("recharge_id");
		        $recharge_info = $this->db->query("select recharge_id,mobile_no,amount,Date(add_date) as add_date from tblrecharge where recharge_id = ?",array($recharge_id));
		        if($recharge_info->num_rows() == 1)
		        {
		            $mobile_no = $recharge_info->row(0)->mobile_no;
		            $amount = $recharge_info->row(0)->amount;
		            $add_date = $recharge_info->row(0)->add_date;
		            $reqlike1 = "%".$recharge_id."%";
		            $reqlike2 = "%".$mobile_no."%";
		            $reqlike3 = "%".$amount."%";
		            $loginfo = $this->db->query("select request,response from tblreqresp where recharge_id = ? and Date(add_date) >= ? 
		            order by Id",array($recharge_id, $add_date));    
		            if($loginfo->num_rows() == 1)
		        {
		            $resparray = array(
		                "message"=>"success",
		                "status"=>0,
		                "request"=>$loginfo->row(0)->request,
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
		                $request .= $rw->request." <br> -------------------------<br>";
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
		                $request .= $rw->request." <br> -------------------------<br>";
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
		        else
		        {
//echo $recharge_id;exit;
		        	//echo $this->input->get("recharge_id");exit;
		        	$loginfo = $this->db->query("select request,response from tblreqresp where recharge_id = ?",array($recharge_id)); 
		        	//echo $loginfo->num_rows();exit;
		           // echo $recharge_id;exit;   
		           // print_r($loginfo ->result());exit;
		            if($loginfo->num_rows() == 1)
			        {
			            $resparray = array(
			                "message"=>"success",
			                "status"=>0,
			                "request"=>$loginfo->row(0)->request,
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
			                $request .= $rw->request." <br> -------------------------<br>";
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
			                $request .= $rw->request." <br> -------------------------<br>";
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
	public function getlog_table() 
	{
	    $str_table = '<table class="table" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow: auto;">
	                        <tr>
    	                        <td>LogId</td>
    	                        <td>RechargeId</td>
    	                        <td>DateTime</td>
    	                        <td>Request</td>
    	                        <td>Response</td>
	                        </tr>
	            
	    ';
		if(isset($_GET["recharge_id"]))
	    {
	        $recharge_id = intval(trim($this->input->get("recharge_id"))); 
	        $rsltlog = $this->db->query("select Id,recharge_id,add_date,request,response from tblreqresp where recharge_id = ? order by Id",array($recharge_id));
	        foreach($rsltlog->result() as $rw)
	        {
	            $str_table.='
	                            <tr>
	                                <td>'.$rw->Id.'</td>
	                                <td>'.$rw->recharge_id.'</td>
	                                <td>'.$rw->add_date.'</td>
	                                <td style="width:250px;max-width:250px;word-wrap:break-word;overflow:hidden">'.$rw->request.'</td>
	                                <td style="width:250px;max-width:250px;word-wrap:break-word;overflow:hidden">'.htmlentities($rw->response).'</td>
	                            </tr>
	            ';
	        }
	        $str_table.='</table>';
	        echo $str_table;exit;
	    }
		
	}	
}