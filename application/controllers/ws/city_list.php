<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_list extends CI_Controller {
	
	public function index()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(!empty($_GET['state_id']))
			{
				$state_id = $_GET['state_id'];
			}else{
				//echo 'Paramenter is missing';
				$resp = array(
		    		"status"=>1,
		    		"message"=>"Paramenter is missing."
					);
				echo json_encode($resp);
				exit;
			}			
		}else{
			//echo 'Paramenter is missing';
			$resp = array(
		    		"status"=>1,
		    		"message"=>"Paramenter is missing."
					);
				echo json_encode($resp);
			exit;
		}

		 $this->get_city($state_id);
		//exit;
	
	}	
	function get_city($state_id)
	{
		$str_query =  $this->db->query("select * from  tbl_cities_list where state_id=? order by name",array($state_id));
		
		$resparray['data'] = array();
		foreach($str_query->result() as $row)
		{
			$data = array(
				'id'=>$row->id,
				'name'=>$row->name
			);
			array_push($resparray['data'],$data);
		}			

		// if($str_query == true)
		// {
		//    	$resp = array(
		//     "status"=>0,
		//     "message"=>"Inquiry submit successful."
		// 	);
		// 	echo json_encode($resp);
		// }											

		echo json_encode($resparray);
		exit;



	}

	
}
