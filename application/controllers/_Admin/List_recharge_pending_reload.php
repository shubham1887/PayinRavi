<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_recharge_pending_reload extends CI_Controller {
	
	
	private $msg=''; 
	private $message=''; 
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
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}	
	
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_recharge'] = $this->db->query("select 
		
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.status as recharge_status,
        		a.user_id,
        		api.api_name as ExecuteBy,
        		a.add_date,
        		c.company_name,
        		b.businessname as name,
        		b.username
        		from tblpendingrechares a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
			    left join tblapi api on a.api_id = api.api_id
				
				order by a.recharge_id");
				
		$this->view_data['message'] =$this->msg;
		
		$rslttotal = $this->db->query("select sum(amount) as total ,count(recharge_id) as totalcount from tblpendingrechares");
		$totalpendin = $rslttotal->row(0)->total;
		$totalpendincount = $rslttotal->row(0)->totalcount;
		
		$this->view_data["total"] = $totalpendin;
		$this->view_data["totalcount"] = $totalpendincount;
		$this->load->view('_Admin/list_recharge_pending_reload_view',$this->view_data);	
		return 0;	
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
		
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
		
		} 
	}	

	public function custom_response($recharge_id,$mobile_no,$amount,$status,$message,$order_id,$response_type)
	{
		redirect(base_url()."_Admin/list_recharge_pending_reload?crypt=".$this->Common_methods->encrypt("MyData"));
	}	
	public function gettransactions()
	{
	    $result = $this->db->query("select 
		
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.status as recharge_status,
        		a.user_id,
        		api.api_name as ExecuteBy,
        		a.add_date,
        		c.company_name,
        		b.businessname as name,
        		b.username
        		from tblpendingrechares a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
			    left join tblapi api on a.api_id = api.api_id
				
				order by a.recharge_id limit 50");
		$resp = '';
		$resp.='
		<table class="" style="color:#000;padding:5px;margin:2px;font-size:14px;border-collapse: collapse;" border=1>
    <tr>  
     <th>SR No.</th> 
     <th>Recharge Id</th>
    <th>Recharge Date</th>
    <th>Name</th>
   <th>Company Name</th>
	<th>Mobile No</th>    
	<th>Amount</th>    
   	<th>API</th>    
   	<th>Status</th>    

    </tr>
		';
		 $strrecid = '';
		 $i = 1;
		 $total = 0;
		foreach($result->result() as $result)
		{
		     $recdt = $result->add_date;
    		$recdatetime =date_format(date_create($recdt),'Y-m-d h:i:s');
    		$cdate =date_format(date_create($this->common->getDate()),'Y-m-d h:i:s');
    	    $this->load->model("Update_methods");
    	    $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
	    
	    
	    
        	if(isset($result->recharge_id)) 
        	{
        		$strrecid .=$result->recharge_id."#"; 
        	}
        
    	    if($diff > 5) 
    	    {
    	        $resp.='<tr class="error">';
    	    }
    	    else
    	    {
    	        $resp.='<tr>';
    	    }
    	    $resp .='';
    	    
             $resp .='<td>'.$i.'</td>';
            $resp .='<td>'.$result->recharge_id.'</td>';
 $resp .='<td>'.$result->add_date.'</td>';
 $resp .='<td>'.$result->name.'</td>';
  $resp .='<td>'.$result->company_name.'</td>
 <td>'.$result->mobile_no.'</td>
 <td>'.$result->amount.'</td>
 <td>'.$result->ExecuteBy.'</td>';
 
  $resp .='<td> Pending</td>';

 
 $resp .'</tr>';
	    $i++;
		$total += $result->amount;
		}
		$resp.='</table>
		
		<input type="hidden" id="hidtotalcount" value="'.$i.'">
		<input type="hidden" id="hidtotalamount" value="'.$total.'">
		<input type="hidden" id="hisrecids" value="'.$strrecid.'">
		';
		
		echo $resp;
	}
}