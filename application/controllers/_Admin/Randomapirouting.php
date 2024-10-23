<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Randomapirouting extends CI_Controller {
	
	
	
	private $msg='';
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
 		error_reporting(-1);
 		ini_set('display_errors',1);
 		$this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
        $this->load->model("Api_model");
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        $this->load->model("Api_model");
        $this->load->model("Address_model");
    }
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['pagination'] = "";
		$this->view_data['result_api'] = $this->db->query("
		select 
			a.Id,
			a.add_date,
			a.api_id,
			a.company_id,
			b.api_name,
			c.company_name
		from tblrandomapirouting a 
		left join api_configuration b on a.api_id = b.Id
		left join tblcompany c on a.company_id = c.company_id
		order by a.company_id");
		
			$this->view_data['result_amountapi'] = $this->db->query("
		select 
			a.Id,
			a.add_date,
			a.api_id,
			a.amounts,
			a.company_id,
			b.api_name,
			c.company_name
		from amountwiseapi a 
		left join api_configuration b on a.api_id = b.Id
		left join tblcompany c on a.company_id = c.company_id
		order by a.company_id");
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/Randomapirouting_view',$this->view_data);		
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
			$data['message']='';				
			if($this->input->post("ddlApi"))
			{
				$ApiId = $this->input->post("ddlApi",TRUE);
				$company_id = $this->input->post("ddlcompany",TRUE);
				
				$result = $this->db->query("insert into tblrandomapirouting(api_id,company_id,add_date,ipaddress) values(?,?,?,?)",array($ApiId,$company_id,$this->common->getDate(),$this->common->getRealIpAddr()));		
				
				
				$this->msg ="Api Add Successfully.";
				redirect(base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"));
				
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$HidId = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from tblrandomapirouting where Id = ?",array($HidId));
				
				redirect(base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}
	public function amountwiseapi() 
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache"); 

		 
		$data['message']='';				
		if($this->input->post("ddlAmountApi"))
		{
			$ApiId = $this->input->post("ddlAmountApi",TRUE);
			$company_id = $this->input->post("ddlAmountcompany",TRUE);
			$txtAmounts = $this->input->post("txtAmounts",TRUE);
			$result = $this->db->query("insert into amountwiseapi(api_id,company_id,add_date,ipaddress,amounts) values(?,?,?,?,?)",array($ApiId,$company_id,$this->common->getDate(),$this->common->getRealIpAddr(),$txtAmounts));		
			
			
			$this->msg ="Api Add Successfully.";
			redirect(base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"));
			
		}
		else if( $this->input->post("hidAmountValue") && $this->input->post("Amountaction") ) 
		{				
			$HidId = $this->input->post("hidAmountValue",TRUE);
			$this->db->query("delete from amountwiseapi where Id = ?",array($HidId));
			
			redirect(base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"));
		}
		else
		{
			$user=$this->session->userdata('ausertype');
			if(trim($user) == 'Admin')
			{
			$this->pageview();
			}
			else
			{redirect(base_url().'login');}																					
		}
		
	}
	public function addrandomapi()
	{
	    if(isset($_POST["company_id"]) and isset($_POST["api_id"]))
	    {
	        $company_id = intval(trim($this->input->post("company_id")));
	        $api_id = intval(trim($this->input->post("api_id")));
	        $result = $this->db->query("insert into tblrandomapirouting(api_id,company_id,add_date,ipaddress) values(?,?,?,?)",array($api_id,$company_id,$this->common->getDate(),$this->common->getRealIpAddr()));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function addamountapi()
	{
	    if(isset($_POST["company_id"]) and isset($_POST["amounts"]) and isset($_POST["amounts_api"]))
	    {
	        $company_id = intval(trim($this->input->post("company_id")));
	        $amounts = trim($this->input->post("amounts"));
	        $amounts_api = intval(trim($this->input->post("amounts_api")));
	        
	        $result = $this->db->query("insert into amountwiseapi(api_id,company_id,amounts,add_date,ipaddress) values(?,?,?,?,?)",array($amounts_api,$company_id,$amounts,$this->common->getDate(),$this->common->getRealIpAddr()));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function addstateapi()
	{
	    if(isset($_POST["company_id"]) and isset($_POST["stateapi"]) and isset($_POST["state_id"]))
	    {
	        $company_id = intval(trim($this->input->post("company_id")));
	        $state_id = trim($this->input->post("state_id"));
	        $stateapi = intval(trim($this->input->post("stateapi")));
	        
	        $result = $this->db->query("insert into serieswiseapi(api_id,company_id,state_id,add_date,ipaddress) values(?,?,?,?,?)",array($stateapi,$company_id,$state_id,$this->common->getDate(),$this->common->getRealIpAddr()));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	
	
	
	public function updateamounts()
	{
	    if(isset($_POST["Id"]) and isset($_POST["amounts"]) and  isset($_POST["amounts_api"]))
	    {
	        $Id = intval(trim($this->input->post("Id")));
	        $amounts = trim($this->input->post("amounts"));
	        $amounts_api = intval(trim($this->input->post("amounts_api")));
	        $amounts_circle = intval(trim($this->input->post("amounts_circle")));
	        $result = $this->db->query("update amountwiseapi set amounts = ?,api_id = ?,circle_id = ? where Id = ?",array($amounts,$amounts_api,$amounts_circle,$Id));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function update_series_api()
	{
	    if(isset($_POST["Id"]) and isset($_POST["stateapi"]) )
	    {
	        $Id = intval(trim($this->input->post("Id")));
	        $stateapi = intval(trim($this->input->post("stateapi")));
	        $result = $this->db->query("update serieswiseapi set api_id = ? where Id = ?",array($stateapi,$Id));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function delete_amounts_api()
	{
	    if(isset($_POST["Id"]) )
	    {
	        $Id = intval(trim($this->input->post("Id")));
	        $result = $this->db->query("delete from  amountwiseapi  where Id = ?",array($Id));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function delete_series_api()
	{
	    if(isset($_POST["Id"]) )
	    {
	        $Id = intval(trim($this->input->post("Id")));
	        $result = $this->db->query("delete from  serieswiseapi  where Id = ?",array($Id));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function delete_random_api()
	{
	    if(isset($_POST["Id"]) )
	    {
	        $Id = intval(trim($this->input->post("Id")));
	        $result = $this->db->query("delete from  tblrandomapirouting  where Id = ?",array($Id));	
	        echo "OK";exit;
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	public function getCustomApiData()
	{
	    
//////////////////////////////////////////////////////////
//random api data
////////////////////////////////////////////////////////
	    $str = '<table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Operator Name</th>
                                            <th>API Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        $str_amounts = '<table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Operator Name</th>
											<th style="width:350px;">Amounts</th>
                                            <th>API Name</th>
                                            <th>Circle Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    
                                    
                                    
        $str_series = '<table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Operator Name</th>
											<th style="width:350px;">Circle</th>
                                            <th>API Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    
                                    
	    if(isset($_POST["company_id"]))
	    {
	        $company_id = intval(trim($this->input->post("company_id")));
	        $randomapis = $this->db->query("
    		select 
    			a.Id,
    			a.add_date,
    			a.api_id,
    			a.company_id,
    			b.api_name,
    			c.company_name
    		from tblrandomapirouting a 
    		left join api_configuration b on a.api_id = b.Id
    		left join tblcompany c on a.company_id = c.company_id
    		where a.company_id = ?
    		order by a.company_id",array($company_id));
    		$i=1;
    		foreach($randomapis->result() as $rwrndm)
    		{
    		    $str.='<tr>';
    		        $str .='<td>'.$i.'</td>';
    		         $str .='<td><span id="routername_'.$rwrndm->Id.'">'.$rwrndm->company_name.'</span></td>';
    		         $str .='<td><span id="name_'.$rwrndm->Id.'">'.$rwrndm->api_name.'</span></td>';
    		         $str .='<td>
                                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="Confirmation('.$rwrndm->Id.')">Delete</a>
                            </td>';
    		    $str.='</tr>';                      
    		}
    		 $str.='<tr></tbody>
                                </table>';
                                
                                
//////////////////////////////////////////////////////////
//amount api data
////////////////////////////////////////////////////////
          $result_amountapi = $this->db->query("
		select 
			a.Id,
			a.add_date,
			a.api_id,
			a.amounts,
			a.company_id,
			b.api_name,
			a.circle_id,
			c.company_name,
			circle.circleName
		from amountwiseapi a 
		left join api_configuration b on a.api_id = b.Id
		left join tblcompany c on a.company_id = c.company_id
		left join freecharge_circlemaster circle on a.circle_id = circle.circleMasterId
		where a.company_id = ?
		order by a.company_id",array($company_id));
            
           $i=1; 
           foreach($result_amountapi->result() as $row)
		   {
                $str_amounts.='<tr>';
                    $str_amounts.='<td>'.$i.'</td>';
					$str_amounts.='<td><span id="amountroutername_'.$row->Id.'">'.$row->company_name.'</span></td>';
					$str_amounts.='<td style="width:350px;"><input type="text" id="amounts'.$row->Id.'" value="'.$row->amounts.'" style="width:350px;" onKeyUp="updataamounts(\''.$row->Id.'\')"></td>';
                    $str_amounts.='<td><span id="amountname_'.$row->Id.'">';
                                        $str_amounts.='<select id="ddlamountapi'.$row->Id.'" style="width:120px;height:30px" onChange="updataamounts(\''.$row->Id.'\')">';
                                        $str_amounts.='<option value="'.$row->api_id.'">'.$row->api_name.'</option>';
                                        $str_amounts.=$this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto($row->api_id,2);
                                        $str_amounts.='</select>';
                                        
                    $str_amounts.='</span></td>';


                    $str_amounts.='<td><span id="amountcircle_'.$row->Id.'">';
                                        $str_amounts.='<select id="ddlamountcircle'.$row->Id.'" style="width:120px;height:30px" onChange="updataamounts(\''.$row->Id.'\')">';
                                        $str_amounts.='<option value="'.$row->circle_id.'">'.$row->circleName.'</option>';
                                        $str_amounts.=$this->Address_model->getStateDropdownList();
                                        $str_amounts.='</select>';
                                        
                    $str_amounts.='</span></td>';



                    $str_amounts.='<td>
                         <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="ConfirmationAmount('.$row->Id.')">Delete</a>
                    </td>';
                $str_amounts.='</tr>';
                $i++;
           }  
            $str_amounts .= '</tbody>
        </table>';
        
        
//////////////////////////////////////////////////////////
//series api data
////////////////////////////////////////////////////////
          $result_stateapi = $this->db->query("
		select 
			a.Id,
			a.add_date,
			a.api_id,
			a.company_id,
			a.state_id,
			b.api_name,
			c.company_name,
			circle.circleName
		from serieswiseapi a 
		left join freecharge_circlemaster circle on a.state_id = circle.circleMasterId
		left join api_configuration b on a.api_id = b.Id
		left join tblcompany c on a.company_id = c.company_id
		where a.company_id = ?
		order by a.company_id",array($company_id));
            
           $i=1; 
           foreach($result_stateapi->result() as $row)
		   {
                $str_series.='<tr>';
                    $str_series.='<td>'.$i.'</td>';
					$str_series.='<td><span id="stateroutername_'.$row->Id.'">'.$row->company_name.'</span></td>';
					$str_series.='<td><span id="statename_'.$row->Id.'">'.$row->circleName.'</span></td>';
                    $str_series.='<td><span id="statename_'.$row->Id.'">';
                                        $str_series.='<select id="ddlstateapi'.$row->Id.'" style="width:120px;height:30px" onChange="updatestateapi(\''.$row->Id.'\')">';
                                        $str_series.='<option value="'.$row->api_id.'">'.$row->api_name.'</option>';
                                        $str_series.=$this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto($row->api_id,3);
                                        $str_series.='</select>';
                                        
                    $str_series.='</span></td>';
                    $str_series.='<td>
                         <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="Confirmationstate('.$row->Id.')">Delete</a>
                    </td>';
                $str_series.='</tr>';
                $i++;
           }  
            $str_series .= '</tbody>
        </table>';


            echo $str."^-^".$str_amounts."^-^".$str_series;exit;
	    }
	}
}