<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorwisereport extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function commonfunction()
	{	
		
		
		
		$from = $this->session->userdata("from");
		$to = $this->session->userdata("to");
		$user = $this->session->userdata("ApiId");
		
		
		$this->view_data['pagination'] = "";
		$this->load->database();
                $this->db->reconnect();
		
		
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		$this->view_data['user'] =$user;
		
		
		
		
		$this->view_data['result_all'] = $this->get_recharge($from,$to,$this->session->userdata("ApiId"));
		$this->view_data['message'] =$this->msg;
		$this->load->view('API/operatorwisereport_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else if($this->input->post('btnSearch'))
		{
		
			$from = $this->input->post('txtFrom',true);
			$to = $this->input->post('txtTo',true);
			$this->session->set_userdata("from",$from);
			$this->session->set_userdata("to",$to);
			$this->commonfunction();					
		}
		else 
		{ 						
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	private function get_recharge($start_date,$end_date,$user_id)
	{
		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
			$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(commission_amount) as Commission,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where Date(add_date) >=? and Date(add_date) <=? and tblrecharge.user_id = ? and  tblrecharge.recharge_status = 'Success' group by company_id";
		$result = $this->db->query($str_query,array($start_date,$end_date,$this->session->userdata("ApiId")));
		return $result;
		
		
	}
	
	public function dataexport()
	{
		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			echo false; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			
			$user_id = $this->session->userdata("ApiId");
			
				$result_all = $this->get_recharge($from,$to,$user_id);
				
				echo '<table border=1><tr><th>Sr No</th><th >AgentName</th><th>APIUSER Id</th><th >Recharge ID</th><th >Transaction Id</th><th>Recharge Date Time</th><th>Company Name</th><th>Mobile No</th><th>Commission Per(%)</th><th>Amount</th><th>Debit Amount</th><th>Status</th></tr>';

				if($result_all->num_rows() > 0)
				{
					$i = 0;
					$total_amount=0;
					$total_commission=0;
					foreach($result_all->result() as $result) 	{
					{
					
					
			
						echo '<tr> <td>'.($i + 1).'</td>
						  <td>'.$result->businessname.'</td>
						   <td>'.$result->username.'</td>
						  <td>'.$result->recharge_id.'</td>
						  <td>'.$result->operator_id.'</td>
						 <td>'.$result->add_date.'</td> 
						 <td>'.$result->company_name.'</td> 
						 <td>'.$result->mobile_no.'</td> 
						 <td>'.$result->commission_per.'</td>
						 <td>'.$result->amount.'</td>';

 

	if($result->recharge_status == "Success")
	{
		$total_commission += $result->commission_amount;
		$debit_amount = $result->amount - $result->commission_amount;
	}
	else
	{
		$debit_amount = 0;
	}


  	echo '<td>'.$debit_amount.'</td>
	<td>'.$result->recharge_status.'</td>
	</tr>';

		$i++;
					} 
				} 
			}
			
			echo '</table>';
		
	}
		else
		{
			echo "parameter missing";exit;
		}
		}
	}