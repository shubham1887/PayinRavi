<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmt_api_setting extends CI_Controller {
	
	
	
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
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug  = TRUE;
    }
    public function getapilist()
	{
	    
	    
	        
	        $str_html = '<table class="table .table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Name</th>
                                            
                                             <th>Api Status</th>
                                            
                                             <th>Priority</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>';
	        
	        
	        
	        
	       
	        $apiresult = $this->db->query("
			select 
				a.Id,
				a.api_name,
				a.priority,
				
				a.is_dmt,
				a.is_active

				from api_configuration  a 
				
				where a.is_dmt = 'yes'
				
				order by a.priority
    		");
    		if($apiresult->num_rows() > 0)
    		{
    		    $i=1; 
			   if($apiresult != false)
			   {
			       $class= "";
			       $done =false;
    			   foreach($apiresult->result() as $row)
    			   {
    			       $class = "";
    			        
    			        $checkbox_class = "";
    			        if($row->is_active == "yes")
    			        {
    			            $class = "btn-success";
    			            $checkbox_class = "checked";

    			        }
					
                                $str_html .= '<tr class="'.$class.'">';
                                $str_html .= '<td>'.$i.'</td>';
                                $str_html .= '<td><span id="name_'.$row->Id.'">'.$row->api_name.'</span></td>';
                              
                                $str_html .= '<td>
                                                    <input '.$checkbox_class.' OnClick="updatevalues('.$row->Id.')"  type="checkbox" id="chkisapiactive'.$row->Id.'" name="chkisapiactive" class="form-control-sm" style="width:60px;height:24px;">
                                              </td>';
                               
                               
                                    
                                $str_html .= '<td>
                                                <input onKeyUp="updatepriority('.$row->Id.')" onBlur="updatepriority('.$row->Id.')"  type="number" id="txtPriority'.$row->Id.'" name="txtPriority" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->priority.'">
                                            </td>';


                               
                                $str_html .= '</tr>';
                            $i++;
                            } 
                } 
                            
                                $str_html .= '</tbody>
                                            </table>';
                      
    		}
    		
    		        
                    
                    
                    echo $str_html."^-^";exit;        
    		
    		
    		
    		
    		
    		
    		
    		
	    
	}
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['pagination'] = "";
		$this->view_data['result_api'] = $this->db->query("
		select a.*
		from api_configuration a
		where a.is_dmt = 'yes' 
		order by a.api_name desc");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/Dmt_api_setting_view',$this->view_data);		
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
			if($this->input->post("btnSubmit") == "Submit")
			{
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = $this->input->post("txtUserName",TRUE);
				$Password = $this->input->post("txtPassword",TRUE);
				$Ip = $this->input->post("txtIp",TRUE);	
				$Token = $this->input->post("txtToken",TRUE);	
				$httpmethod = $this->input->post("ddlhttpmethod",TRUE);				
				$parameters = str_replace(" ","%20",$this->input->post("txtparameters",TRUE));	
				$txtMinBalanceLimit = $this->input->post("txtMinBalanceLimit",TRUE);	
				$apigroup = $this->input->post("ddlapigroup",TRUE);	
				
				$this->load->model('Api_model');
				
				$result = $this->db->query("insert into tblapi(api_name,username,password,static_ip,apitocken,add_date,ipaddress,httpmethod,params,status,minbalance_limit,apigroup) values(?,?,?,?,?,?,?,?,?,?,?,?)",array($ApiName,$UserName,$Password,$Ip,$Token,$this->common->getDate(),$this->common->getRealIpAddr(),$httpmethod,$parameters,1,$txtMinBalanceLimit,$apigroup));		
				
				
				$this->msg ="Api Add Successfully.";
				$this->pageview();
				
				}
			else if($this->input->post("btnSubmit") == "Update")
			{				
				$apiID = $this->input->post("hidID",TRUE);
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = $this->input->post("txtUserName",TRUE);
				$Password = $this->input->post("txtPassword",TRUE);
				$Ip = $this->input->post("txtIp",TRUE);			
				$Token = $this->input->post("txtToken",TRUE);	
				$httpmethod = $this->input->post("ddlhttpmethod",TRUE);				
				$parameters = str_replace(" ","%20",$this->input->post("txtparameters",TRUE));
				$ddlstatus = $this->input->post("ddlstatus",TRUE);	
				$txtMinBalanceLimit = $this->input->post("txtMinBalanceLimit",TRUE);	
				$apigroup = $this->input->post("ddlapigroup",TRUE);	
				//echo $parameters ;exit;
				
				
				$Status = $this->input->post("hidStatus",TRUE);					
				$this->load->model('Api_model');
				$result = $this->db->query("update tblapi set api_name=?,username=?,password=?,static_ip=?,apitocken=?,httpmethod=?,params = ?,status = ?,minbalance_limit = ?,apigroup = ? where api_id=?",array($ApiName,$UserName,$Password,$Ip,$Token,$httpmethod,$parameters,$ddlstatus,$txtMinBalanceLimit,$apigroup,$apiID));		
				
				$this->msg ="Api Update Successfully.";
				$this->pageview();
							
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$apiID = $this->input->post("hidValue",TRUE);
				$this->load->model('Api_model');
				if($this->Api_model->delete($apiID) == true)
				{
					$this->msg ="Api Delete Successfully.";
					$this->pageview();
				}
				else
				{
					
				}				
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
	public function getapibalance()
	{
		if(isset($_GET["id"]))
		{
		    $id = $_GET["id"];
	        echo $id."#".$this->Api_model->getBalance($id)."#";exit;	    
		}
		
	}
	public function setvalues()
	{
		if(isset($_GET["field"]) and isset($_GET["val"])  and isset($_GET["Id"]))
		{
			$Id = trim($this->input->get("Id"));
			$field = trim($this->input->get("field"));
			$val = trim($this->input->get("val"));
			//echo $Id."  ".$field." ".$val;exit;
			if($field == "is_active")
			{
				$this->db->query("update api_configuration set is_active=? where Id = ?",array($val,$Id));	
				echo "OK";
			}
			if($field == "priority")
			{
				$this->db->query("update api_configuration set priority=? where Id = ?",array($val,$Id));	
				echo "OK";
			}
			

		}
	}
}