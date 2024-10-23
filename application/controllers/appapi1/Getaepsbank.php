<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getaepsbank extends CI_Controller {
	
	public function index()
	{
	   
	 
	    $resp_array = array(
	        "status"=>"success",
	        "infomsg"=>"bank load successfully",
	        );
	        
	   
	        
//	$hostnm="SWORLD.BIZ";        
	        $bank_rows = array();
	    $rslt = $this->db->query("select aeps_bk_code,aeps_bk_nm  from aeps_bank where aeps_bk_sts=1 order by aeps_bk_nm asc");
	    foreach($rslt->result() as $row)
	    {
	        $user_bank_id = $row->aeps_bk_code;
	      
	        $bank_name = $row->aeps_bk_nm;
	        $temparray = array(
	            "bank_id"=>$user_bank_id,
	            "bank_name"=>$bank_name
	            );
	            array_push($bank_rows,$temparray);
	    }
	    $resp_array["data"] = $bank_rows;
	   echo json_encode($resp_array);exit;

			    
	   
	   
	    
	}
}