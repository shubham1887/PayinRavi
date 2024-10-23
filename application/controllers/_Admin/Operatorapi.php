<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorapi extends CI_Controller {
	
	
	
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
			$data['message']='';	
			
			if($this->input->post("btnSearch") == "Search")
			{
				$company_id = $this->input->post("ddlcompany",TRUE);
				$this->view_data['pagination'] = "";
				$this->view_data['result_api'] = $this->db->query("
					select 
						a.Id,
						a.api_name,
						b.pendinglimit,
						b.totalpending,
						b.failurelimit,
						b.priority,
						b.status as operator_status,
						b.company_id,
						b.multi_threaded,
						b.reroot,
						b.reroot_api_id,
						b.statewise,
						b.amountrange,
						c.status as api_status
						from api_configuration  a 
						left join operatorpendinglimit b on a.Id = b.api_id and b.company_id = ?
						left join operator_api_availibility c on a.Id = c.api_id and c.company_id = ?
						
						order by b.priority 
				",array(intval($company_id),intval($company_id)));
				$this->view_data['message'] =$this->msg;
				$this->view_data['company_id'] =$company_id;
				$this->load->view('_Admin/operatorapi_view',$this->view_data);	
				
				
			}
			else if($this->input->post("company_id") and  $this->input->post("api_id"))
			{	
				error_reporting(-1);
				ini_set('display_errors',1);
				$this->db->db_debug = TRUE;			
			
				$company_id = $this->input->post("company_id",TRUE);
				$api_id = $this->input->post("api_id",TRUE);
				$status = $this->input->post("status",TRUE);
				$pendinglimit = $this->input->post("pendinglimit",TRUE);
				$failurelimit = $this->input->post("failurelimit",TRUE);
				$priority = $this->input->post("priority",TRUE);
				$multi = $this->input->post("multi",TRUE);
				$reroot = $this->input->post("reroot",TRUE);
				$reroot_api_id = $this->input->post("reroot_api_id",TRUE);
				$series = $this->input->post("series",TRUE);
				$amtrange = $this->input->post("amtrange",TRUE);
				$result = $this->db->query("select * from operatorpendinglimit where company_id = ? and api_id = ?",array($company_id,$api_id));
				if($result->num_rows() == 1)
				{
					$this->db->query("update operatorpendinglimit set status = ?,reroot = ?,reroot_api_id = ?,pendinglimit = ?,failurelimit = ?,priority = ?,update_date = ?,multi_threaded = ?,statewise = ?,amountrange = ? where company_id = ? and api_id = ?",array($status,$reroot,$reroot_api_id,$pendinglimit,$failurelimit,$priority,$this->common->getDate(),$multi,$series,$amtrange,$result->row(0)->company_id,$result->row(0)->api_id));
					
					$check_pfvalues = $this->db->query("select * from pf_values where company_id = ? and api_id = ?",array($company_id,$api_id));
					if($check_pfvalues->num_rows() == 0)
					{
							$this->db->query("insert into pf_values(company_id,api_id,pendinglimit,failurelimit) 
						values(?,?,?,?)",
						array($company_id,$api_id,$pendinglimit,$failurelimit));
					}
					else
					{
						$this->db->query("update pf_values set pendinglimit = ?,failurelimit = ? where company_id = ? and api_id = ?",array($pendinglimit,$failurelimit,$result->row(0)->company_id,$result->row(0)->api_id));
					}
					
					


					$this->load->model("AutoStopApi");
					$this->AutoStopApi->update_failure_limit($result->row(0)->api_id,$result->row(0)->company_id,$failurelimit);

					
					
					$resp = array(
						"totalpending"=>$result->row(0)->totalpending
					);
					
					echo json_encode($resp);exit;
				}
				else
				{
					$this->db->query("insert into operatorpendinglimit(company_id,api_id,pendinglimit,failurelimit,priority,status,add_date,multi_threaded,statewise,amountrange,reroot,reroot_api_id) 
					values(?,?,?,?,?,?,?,?,?,?,?,?)",
					array($company_id,$api_id,$pendinglimit,$failurelimit,$priority,$status,$this->common->getDate(),$multi,$series,$amtrange,$reroot,$reroot_api_id));
					
					$check_pfvalues = $this->db->query("select * from pf_values where company_id = ? and api_id = ?",array($company_id,$api_id));
					if($check_pfvalues->num_rows() == 0)
					{
							$this->db->query("insert into pf_values(company_id,api_id,pendinglimit,failurelimit) 
						values(?,?,?,?)",
						array($company_id,$api_id,$pendinglimit,$failurelimit));
					}
					else
					{
						$this->db->query("update pf_values set pendinglimit = ?,failurelimit = ? where company_id = ? and api_id = ?",array($pendinglimit,$failurelimit,$result->row(0)->company_id,$result->row(0)->api_id));
					}
					
					echo "OK";exit;
				}
							
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				    if(false)
					//if(isset($_GET["mcrypt"]))
					{
						$company_id = $this->Common_methods->decrypt($this->input->get("mcrypt"));
				
						$this->view_data['pagination'] = "";
						$this->view_data['result_api'] = $this->db->query("
    					select 
    						a.Id,
    						a.api_name,
    						b.pendinglimit,
    						b.totalpending,
    						b.failurelimit,
    						b.priority,
    						b.status as operator_status,
    						b.company_id,
    						b.multi_threaded,
    						b.reroot,
    						b.reroot_api_id,
    						b.statewise,
    						b.amountrange,
    						c.status as api_status
    						from api_configuration  a 
    						left join operatorpendinglimit b on a.Id = b.api_id and b.company_id = ?
    						left join operator_api_availibility c on a.Id = c.api_id and c.company_id = ?
    						
    						order by b.priority 
    				",array(intval($company_id),intval($company_id)));
    				$this->view_data['message'] =$this->msg;
    				$this->view_data['company_id'] =$company_id;
    				$this->load->view('_Admin/operatorapi_view',$this->view_data);		
					}
					else
					{
					
						$this->view_data['pagination'] = "";
						$this->view_data['result_api'] = false;
						$this->view_data['message'] =$this->msg;
						$this->view_data['company_id'] =0;
						$this->load->view('_Admin/operatorapi_view',$this->view_data);		
					}
					
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	public function apienabledisable()
	{
	    if($this->input->post("company_id") and  $this->input->post("api_id"))
	    {
	        $company_id = trim($this->input->post("company_id"));
	        $api_id = trim($this->input->post("api_id"));
	        $series = trim($this->input->post("series"));
	        if($series == 'yes')
	        {
	            $rslt = $this->db->query("select * from operator_api_availibility where company_id = ? and api_id = ?",array(intval($company_id),intval($api_id)));
	            if($rslt->num_rows() == 0)
	            {
	                $this->db->query("insert into operator_api_availibility(company_id,api_id,status) values(?,?,?)",array(intval($company_id),intval($api_id),'active'));
	            }
	        }
	        else
	        {
	            $rslt = $this->db->query("delete  from operator_api_availibility where company_id = ? and api_id = ?",array(intval($company_id),intval($api_id)));
	        }
	        
	        
	    }
	}
	public function getapilist()
	{
	    
	    if(isset($_POST["company_id"]))
	    {
	        
	        $str_html = '<table class="table .table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Name</th>
                                             <th  style="display:none">Range</th>
                                             <th>Pending<br>Limit</th>
                                             <th>Total<br>Pending</th>
                                             <th>Priority</th>
											 <th>Enable/Disable</th>
                                            <th>Failure<br>Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
	        
	        $str_html2 = '<table class="table .table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Name</th>
                                             <th  style="display:none">Range</th>
                                             <th>Pending<br>Limit</th>
                                             <th>Total<br>Pending</th>
                                             <th>Priority</th>
											 <th>Enable/Disable</th>
                                            <th>Failure<br>Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
	        
	        
	        $company_id = intval(trim($this->input->post("company_id",TRUE)));
	        $apiresult = $this->db->query("
			select 
				a.Id,
				a.api_name,
				b.pendinglimit,
				b.totalpending,
				b.failurelimit,
				b.priority,
				b.status as operator_status,
				b.company_id,
				b.multi_threaded,
				b.reroot,
				b.reroot_api_id,
				b.statewise,
				b.amountrange,
				CASE 
            		WHEN b.status = 'active' THEN 1
                    ELSE 0
                    END as flag
				from api_configuration  a 
				left join operatorpendinglimit b on a.Id = b.api_id and b.company_id = ?
				where b.status = 'active'
				
				order by b.priority
    		",array(intval($company_id)));
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
    			        
    			        if($row->operator_status == "active")
    			        {
    			            $class = "btn-success";
    			        }
					
                                $str_html .= '<tr class="'.$class.'">';
                                $str_html .= '<td>'.$i.'</td>';
                                $str_html .= '<td><span id="name_'.$row->Id.'">'.$row->api_name.'</span></td>';
                                $str_html .= '<td  style="display:none"><input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="text" id="txtRange'.$row->Id.'" name="txtRange" class="form-control-sm" style="width:90px;height:24px;" value="'.$row->amountrange.'"></td>';
                                $str_html .= '<td>
                                                    <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="number" id="txtPendingLimit'.$row->Id.'" name="txtPendingLimit" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->pendinglimit.'">
                                              </td>';
                                $str_html .= '<td><span id="totalpending_'.$row->Id.'">'.$row->totalpending.'</span></td>';
                                $str_html .= '<td>
                                                    <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="number" id="txtPriority'.$row->Id.'" name="txtPriority" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->priority.'">
                                              </td>';
								$str_html .= '<td>';
									
											if($row->operator_status == "active")
											{
    											$str_html .= '<div class="panel panel-default"> 
                                					<input onClick="updateoperatorapi('.$row->Id.')" checked type="checkbox" id="md_checkbox_'.$row->Id.'" class="filled-in chk-col-purple" />
                                                    <label for="md_checkbox_'.$row->Id.'"></label>
                                                </div>';
											 }
											else
											{
												$str_html .= '<div class="panel panel-default"> 
                            					    <input onClick="updateoperatorapi('.$row->Id.')" type="checkbox" id="md_checkbox_'.$row->Id.'" class="filled-in chk-col-purple" />
                                                    <label for="md_checkbox_'.$row->Id.'"></label>
                                                    </div>';
										 	}
									        $str_html .= '</td>';
                                    
                                $str_html .= '<td>
                                                <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')"  type="number" id="txtFailureLimit'.$row->Id.'" name="txtFailureLimit" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->failurelimit.'">
                                            </td>';


                                $str_html .= '<td  style="display:none">
                                             	<input type="button" id="btnUpdate" name="btnUpdate" value="Search" class="btn btn-primary btn-xs" onClick="updateoperatorapi('.$row->Id.')">                                 
                                                <input type="hidden" id="hidcompany_id'.$row->Id.'" value="'.$company_id.'">
                                              </td>';
                                $str_html .= '</tr>';
                            $i++;
                            } 
                } 
                            
                                $str_html .= '</tbody>
                                            </table>';
                      
    		}
    		
    		
    		
    		$apiresult2 = $this->db->query("
			select 
				a.Id,
				a.api_name,
				b.pendinglimit,
				b.totalpending,
				b.failurelimit,
				b.priority,
				b.status as operator_status,
				b.company_id,
				b.multi_threaded,
				b.reroot,
				b.reroot_api_id,
				b.statewise,
				b.amountrange
				from api_configuration  a 
				left join operatorpendinglimit b on a.Id = b.api_id and b.company_id = ?
				
				
				order by b.priority
    		",array(intval($company_id)));
    		
    		    $i=1; 
			   if($apiresult2 != false)
			   {
			       $class= "";
			       $done =false;
    			   foreach($apiresult2->result() as $row)
    			   {
    			       $class = "";
    			        
    			        if($row->operator_status == "active")
    			        {
    			            
    			        }
    			        else
    			        {
    			        	$str_html2 .= '<tr class="'.$class.'">';
                                $str_html2 .= '<td>'.$i.'</td>';
                                $str_html2 .= '<td><span id="name_'.$row->Id.'">'.$row->api_name.'</span></td>';
                                $str_html2 .= '<td  style="display:none"><input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="text" id="txtRange'.$row->Id.'" name="txtRange" class="form-control-sm" style="width:90px;height:24px;" value="'.$row->amountrange.'"></td>';
                                $str_html2 .= '<td>
                                                    <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="number" id="txtPendingLimit'.$row->Id.'" name="txtPendingLimit" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->pendinglimit.'">
                                              </td>';
                                $str_html2 .= '<td><span id="totalpending_'.$row->Id.'">'.$row->totalpending.'</span></td>';
                                $str_html2 .= '<td>
                                                    <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')" type="number" id="txtPriority'.$row->Id.'" name="txtPriority" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->priority.'">
                                              </td>';
								$str_html2 .= '<td>';
									
											if($row->operator_status == "active")
											{
    											$str_html2 .= '<div class="panel panel-default"> 
                                					<input onClick="updateoperatorapi('.$row->Id.')" checked type="checkbox" id="md_checkbox_'.$row->Id.'" class="filled-in chk-col-purple" />
                                                    <label for="md_checkbox_'.$row->Id.'"></label>
                                                </div>';
											 }
											else
											{
												$str_html2 .= '<div class="panel panel-default"> 
                            					    <input onClick="updateoperatorapi('.$row->Id.')" type="checkbox" id="md_checkbox_'.$row->Id.'" class="filled-in chk-col-purple" />
                                                    <label for="md_checkbox_'.$row->Id.'"></label>
                                                    </div>';
										 	}
									        $str_html2 .= '</td>';
                                    
                                $str_html2 .= '<td>
                                                <input onKeyUp="updateoperatorapi('.$row->Id.')" onBlur="updateoperatorapi('.$row->Id.')"  type="number" id="txtFailureLimit'.$row->Id.'" name="txtFailureLimit" class="form-control-sm" style="width:60px;height:24px;" value="'.$row->failurelimit.'">
                                            </td>';


                                $str_html2 .= '<td  style="display:none">
                                             	<input type="button" id="btnUpdate" name="btnUpdate" value="Search" class="btn btn-primary btn-xs" onClick="updateoperatorapi('.$row->Id.')">                                 
                                                <input type="hidden" id="hidcompany_id'.$row->Id.'" value="'.$company_id.'">
                                              </td>';
                                $str_html2 .= '</tr>';
                            $i++;
    			        }
                    } 
                } 
                            
                $str_html2 .= '</tbody>
                                            </table>';
                    
                    
                    
                    
                    echo $str_html."^-^".$str_html2;exit;        
    		
    		
    		
    		
    		
    		
    		
    		
	    }
	}
	public function getoperatorlist()
	{
		if(isset($_POST["service_id"]))
		{
			$str = '';
			$service_id = trim($this->input->post("service_id"));
			$rsltoptr = $this->db->query("select company_id,company_name from tblcompany where service_id = ? order by company_name",array($service_id));
			foreach($rsltoptr->result() as $rw)
			{
				$str .='<option value="'.$rw->company_id.'">'.$rw->company_name.'</option>';
			}
			echo $str;exit;
		}
	}
}