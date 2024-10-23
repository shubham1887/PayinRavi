<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Superdistributor_List extends CI_Controller {

	

	

	private $msg='';

	public function pageview()

	{ 

		if ($this->session->userdata('aloggedin') != TRUE) 

		{ 

			redirect(base_url().'login'); 

		} 

		$start_row = $this->uri->segment(4);

		$per_page = $this->common_value->getPerPage();

		if(trim($start_row) == ""){$start_row = 0;}

		

		$result = $this->db->query("select user_id from tblusers where usertype_name = 'MasterDealer'");

		$total_row = $result->num_rows();

		

		$this->load->library('pagination');

		$config['base_url'] = base_url()."_Admin/superdistributor_list/pageview";

		$config['total_rows'] = $total_row;

		$config['per_page'] = $per_page; 



		$this->pagination->initialize($config); 

		$this->view_data['pagination'] = $this->pagination->create_links();

		$this->view_data['result_dealer'] = $this->db->query("select tblusers.*,(select state_name from tblstate where tblstate.state_id = tblusers.state_id) as state_name,(select state_name from tblcity where tblcity.city_id = tblusers.city_id) as city_name from tblusers where usertype_name = 'MasterDealer' order by businessname limit ?,?",array($start_row,$per_page));

		$this->view_data['message'] =$this->msg;

		$this->load->view('_Admin/superdistributor_list_view',$this->view_data);		

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

		if($this->input->post("hidSearchFlag") && $this->input->post("hidSearchValue"))

			{

				$SearchBy = $this->input->post("hidSearchFlag",TRUE);

				$SearchWord = $this->input->post("hidSearchValue",TRUE);								

				$this->load->model('Md_dealer_list_model');

				$result = $this->Md_dealer_list_model->getMasterdealerFiltered("MasterDealer",$SearchBy,$SearchWord);		

				$this->view_data['result_dealer'] = $result;

				$this->view_data['message'] =$this->msg;

				$this->view_data['pagination'] = NULL;

				$this->load->view('_Admin/superdistributor_list_view',$this->view_data);			

			}

			else if($this->input->post('btnSearch') == "Search")

			{

				$SearchBy = $this->input->post("ddlSearchBy",TRUE);

				$SearchWord = $this->input->post("txtSearch_Word",TRUE);								

				$this->load->model('Distributor_list_model');

				$result = $this->Distributor_list_model->Search($SearchBy,$SearchWord);		

				$this->view_data['result_dealer'] = $result;

				$this->view_data['message'] =$this->msg;

				$this->view_data['pagination'] = NULL;

				$this->load->view('_Admin/superdistributor_list_view',$this->view_data);						

			}					

			else if($this->input->post('hidaction') == "Set")

			{								

				$status = $this->input->post("hidstatus",TRUE);

				$user_id = $this->input->post("hiduserid",TRUE);

				$start_page = $this->input->post("startpage",TRUE);
				

				$this->load->model('Agent_list_model');

				$result = $this->Agent_list_model->updateAction($status,$user_id);

				if($result == true)

				{

					$this->msg="Action Submit Successfully.";
					if($start_page >0)
					{
					redirect(base_url()."_Admin/superdistributor_list");						
					}
					else
					{
						redirect(base_url()."_Admin/superdistributor_list");
					}

				}

			}

			else if($this->input->post('hidaddto') == "Addto")

			{								

				$usertype_name = $this->input->post("hidusertype",TRUE);

				$user_id = $this->input->post("hiduserid",TRUE);

				$this->load->model('Agent_list_model');

				$result = $this->Agent_list_model->updateUsertype($usertype_name,$user_id);

				if($result == true)

				{

					$this->msg="Action Submit Successfully.";

					$this->pageview();	

				}

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

	}	

}