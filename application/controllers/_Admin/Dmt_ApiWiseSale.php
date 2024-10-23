<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmt_ApiWiseSale extends CI_Controller 
{
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) 
	{
    	$sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

    	array_multisort($sort_col, $dir, $arr);
	}



	public function index() 
	{	
		// error_reporting(-1);
		// ini_set('display_errors',1);
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		else if($this->input->post("btnSearch"))
		{
			$data = array();
			$apis = array();
			$users = array();
			$user_array = array();






			$from = $this->input->post("txtFromDate");
			$to = $this->input->post("txtToDate");
			
			$data_maintotal = array();
			
		$rsltmaintotal = $this->db->query("SELECT a.Id,a.API,b.businessname,b.username,b.usertype_name,a.user_id,
				IFNULL(Sum(a.Amount),0) as totaldmt,
				p.businessname as dist_businessname,
			p.username as dist_username,
			p.mobile_no as dist_mobile_no,
			p.usertype_name as dist_usertype_name,
				count(a.Id)  as totalcount FROM `mt3_transfer` a 
left join tblusers b on a.user_id = b.user_id
left join tblusers p on b.parentid = p.user_id

where
a.Status = 'SUCCESS' and 
Date(a.add_date) >= ? and Date(a.add_date) <= ?  
group by a.user_id order by totaldmt desc",array($from,$to));
		foreach($rsltmaintotal->result() as $rwmain)
		{
			$data_maintotal[$rwmain->user_id]["total"] = $rwmain->totaldmt;
			$data_maintotal[$rwmain->API][$rwmain->user_id]["count"] = $rwmain->totalcount;
			
			array_push($users,$rwmain->user_id);
			$user_array[$rwmain->user_id]["Name"] = $rwmain->businessname;
			$user_array[$rwmain->user_id]["UserName"] = $rwmain->username;
			$user_array[$rwmain->user_id]["UserType"] = $rwmain->usertype_name;
			$user_array[$rwmain->user_id]["dist_UserType"] = $rwmain->dist_usertype_name;
			$user_array[$rwmain->user_id]["distbusinessname"] = $rwmain->dist_businessname;
			$user_array[$rwmain->user_id]["distmobile_no"] = $rwmain->dist_mobile_no;
			
		}








				$str_query = "SELECT a.Id,a.API,b.businessname,b.username,b.usertype_name,a.user_id,
				IFNULL(Sum(a.Amount),0) as totaldmt,
				p.businessname as dist_businessname,
			p.username as dist_username,
			p.mobile_no as dist_mobile_no,
			p.usertype_name as usertype_name,
				count(a.Id)  as totalcount FROM `mt3_transfer` a 
left join tblusers b on a.user_id = b.user_id
left join tblusers p on b.parentid = p.user_id

where 
a.Status = 'SUCCESS' and
Date(a.add_date) >= ? and Date(a.add_date) <= ?  group by a.API,a.user_id";
		$rslt = $this->db->query($str_query,array($from,$to));
		
			
			foreach($rslt->result() as $rwop)
			{
				$data[$rwop->API][$rwop->user_id]["total"] = $rwop->totaldmt;
				$data[$rwop->API][$rwop->user_id]["count"] = $rwop->totalcount;
				array_push($apis,$rwop->API);
			}
		$apis = array_unique($apis);
		//$users = array_unique($users);
		


		$this->array_sort_by_column($data, 'total');

		//print_r($data);exit;

		$this->view_data["apis"] = array_unique($apis);
		$this->view_data["users"] = $users;

		$this->view_data["user_array"] = $user_array;
		$this->view_data["from"] = $from;
		$this->view_data["result_data"] = $data;
		$this->view_data["from"] = $from;
		$this->view_data["to"] = $to;
		$this->view_data["ddlapi"] = $ddlapi;
		$this->load->view("_Admin/Dmt_ApiWiseSale_view",$this->view_data);
		
		}
		else
		{
			
			$data = array();
			$apis = array();
			$users = array();
			$user_array = array();






			$from = $to = $this->common->getMySqlDate();
			
			
			$data_maintotal = array();
			
		$rsltmaintotal = $this->db->query("SELECT a.Id,a.API,b.businessname,b.username,b.usertype_name,a.user_id,
				IFNULL(Sum(a.Amount),0) as totaldmt,
				p.businessname as dist_businessname,
			p.username as dist_username,
			p.mobile_no as dist_mobile_no,
			p.usertype_name as dist_usertype_name,
				count(a.Id)  as totalcount FROM `mt3_transfer` a 
left join tblusers b on a.user_id = b.user_id
left join tblusers p on b.parentid = p.user_id

where
a.Status = 'SUCCESS' and 
Date(a.add_date) >= ? and Date(a.add_date) <= ?  
group by a.user_id order by totaldmt desc",array($from,$to));
		foreach($rsltmaintotal->result() as $rwmain)
		{
			$data_maintotal[$rwmain->user_id]["total"] = $rwmain->totaldmt;
			$data_maintotal[$rwmain->API][$rwmain->user_id]["count"] = $rwmain->totalcount;
			
			array_push($users,$rwmain->user_id);
			$user_array[$rwmain->user_id]["Name"] = $rwmain->businessname;
			$user_array[$rwmain->user_id]["UserName"] = $rwmain->username;
			$user_array[$rwmain->user_id]["UserType"] = $rwmain->usertype_name;
			$user_array[$rwmain->user_id]["dist_UserType"] = $rwmain->dist_usertype_name;
			$user_array[$rwmain->user_id]["distbusinessname"] = $rwmain->dist_businessname;
			$user_array[$rwmain->user_id]["distmobile_no"] = $rwmain->dist_mobile_no;
		}








				$str_query = "SELECT a.Id,a.API,b.businessname,b.username,b.usertype_name,a.user_id,
				IFNULL(Sum(a.Amount),0) as totaldmt,
				p.businessname as dist_businessname,
			p.username as dist_username,
			p.mobile_no as dist_mobile_no,
			p.usertype_name as usertype_name,
				count(a.Id)  as totalcount FROM `mt3_transfer` a 
left join tblusers b on a.user_id = b.user_id
left join tblusers p on b.parentid = p.user_id

where 
a.Status = 'SUCCESS' and
Date(a.add_date) >= ? and Date(a.add_date) <= ?  group by a.API,a.user_id";
		$rslt = $this->db->query($str_query,array($from,$to));
		
			
			foreach($rslt->result() as $rwop)
			{
				$data[$rwop->API][$rwop->user_id]["total"] = $rwop->totaldmt;
				$data[$rwop->API][$rwop->user_id]["count"] = $rwop->totalcount;
				array_push($apis,$rwop->API);
			}
		$apis = array_unique($apis);
		//$users = array_unique($users);
		


		$this->array_sort_by_column($data, 'total');

		//print_r($data);exit;

		$this->view_data["apis"] = array_unique($apis);
		$this->view_data["users"] = $users;

		$this->view_data["user_array"] = $user_array;
		$this->view_data["from"] = $from;
		$this->view_data["result_data"] = $data;
		$this->view_data["from"] = $from;
		$this->view_data["to"] = $to;
		$this->view_data["ddlapi"] = $ddlapi;
		$this->load->view("_Admin/Dmt_ApiWiseSale_view",$this->view_data);
		
		
		}
	}
}