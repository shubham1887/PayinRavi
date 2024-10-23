<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getbannerlist extends CI_Controller {
	
	public function index()
	{ 
	    
	   
	    $host_id = 1;	
	    $rslt  = $this->db->query("SELECT * FROM `tblbanners` where host_id = ?",array($host_id));
	    $mainarray = array();
	    $mainarray["message"] = "Success";
	    $mainarray["msgcode"] = "0";
	    $mainarray["data"] = array();
	    $temparray = array();
	    foreach($rslt->result() as $r)
	    {
	       $temparray = array(
	           "id"=>$r->Id,
	           "banner_image"=>$r->imageurl,
	           ); 
	           array_push($mainarray["data"], $temparray);
	    }
	    echo json_encode($mainarray);exit;
	}	
}
