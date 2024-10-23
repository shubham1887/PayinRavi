<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
        class City extends CI_Controller 
		{
        
    	    public function index()  
    	    {
    		    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    		    $this->output->set_header("Pragma: no-cache"); 		
				if ($this->session->userdata("aloggedin") != TRUE) 
				{ 
					redirect(base_url()."login"); 
				}			
					
				else 		
				{	
					if($this->input->post('HIDACTION') == "INSERT")
					{	$CityName = $this->input->post("txtCityName");	$StateName = $this->input->post("txtStateName");	$this->db->query("insert into tblcity(city_name,state_id,add_date,ipaddress) values(?,?,?,?)",array($CityName,$StateName,$this->common->getDate(),$this->common->getRealIpAddr()));
					
						
							
						
							redirect(base_url()."_Admin/City");
							
						}	
						else if($this->input->post('HIDACTION') == "UPDATE")
					{
						$CityName = $this->input->post("txtCityName");	$StateName = $this->input->post("txtStateName");$Id = $this->input->post("hidPrimaryId");
						$this->db->query("update tblcity  set city_name = ?, state_id = ?,edit_date = ?,ipaddress = ? where Id = ?",array($CityName,$CityName,$this->common->getDate(),$this->common->getRealIpAddr(),$Id));
						redirect(base_url()."_Admin/City");
					}
					else if($this->input->post('HIDACTION') == "DELETE")
					{
						$Id = $this->input->post("hidPrimaryId");
						$this->db->query("delete from tblcity  where Id = ?",array($Id));
						redirect(base_url()."_Admin/City");
					} 
					else
					{
						$this->view_data["message"]  = "";	$this->view_data["data"]  = $this->db->query("select a.*, a2.state_name as tblstate_state_name from tblcity a  left join tblstate a2  on a.state_id  = a2.state_id"); $this->load->view("_Admin/City_view",$this->view_data);
					}
				}
		}
		public function getCity() 
		{
			//$stateID = $this->input->post("StateID",TRUE);
			$stateID = $this->uri->segment(4);
			$str_query = "select * from tblcity where state_id = ? order by city_name";
			$result = $this->db->query($str_query,array($stateID));
			
			echo "<option value='0'>Select City</option>";	
			for($i=0; $i<$result->num_rows(); $i++)
			{
				echo "<option value='".$result->row($i)->Id."'>".$result->row($i)->city_name."</option>";	
			}		
		}
	}