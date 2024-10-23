<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {
	
	
	
	
	public function index() 
	{
	    if(isset($_GET['username']) && isset($_GET['pwd'])  )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
			
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']) )
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
	
			
			
			$user_info = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd));
			if($user_info->num_rows() == 1)
			{
			
					if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor"  or $user_info->row(0)->usertype_name == "MasterDealer")
					{
					    
					    $this->load->view("appapi1/chat_view.php");
					}	
					else
					{
					        $resparray = array(
				'status'=>1,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
					
					}
			}
			else
			{
				$resparray = array(
				'status'=>1,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
			}
	
	
	}
	

}