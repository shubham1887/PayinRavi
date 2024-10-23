<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prepaid_commission extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {

       if($this->session->userdata('aloggedin') != TRUE) 
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
	public function getresult()
	{
	    $str_company_id = "";
		$group_id = $_GET["groupid"];
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$group_info = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
		$str = '<div>Commission Structure of '.$group_info->row(0)->group_name.'</div><input type="hidden" id="uid" name="uid" value="'.$group_id.'">
		<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
				<tr>  
    				<th>Sr No.</th>
    				<th>Network</th>
    				<th>Client Commission %</th>
    				<th>Min Commission</th>
    				<th>Max Commission</th>
    				<th>Commission Type</th>
    				<th></th>
				</tr>';
    	$i = 0;
		$result_company = $this->db->query("select * from tblcompany order by service_id,company_name");
		foreach($result_company->result() as $row) 	
		{
		$str_company_id.=$row->company_id.",";
					$rslt  = $this->db->query("select * from tblgroupapi where group_id = ? and company_id = ?",array($group_id,$row->company_id));
					$adm_com_rslt  = $this->db->query("select * from tblcompany where company_id = ?",array($row->company_id));
				if($i % 2 == 0)
				{
					$str .='<tr class="row1">';
				}
				else
				{
					$str .='<tr class="row2">';
				}
					$str.='
			
					<td >'.$i.'</td>
					<td >'.$row->company_name.'</td>';
					
					
					
					
					if($rslt->num_rows() > 0)
					{
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value="'.$rslt->row(0)->commission.'"/>';
							$str.= '</td>';
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMinCom'.$row->company_id.'" name="txtMinCom'.$row->company_id.'" value="'.$rslt->row(0)->min_com_limit.'"/>';
							$str.= '</td>';
							$str.= '<td >';
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMaxCom'.$row->company_id.'" name="txtMaxCom'.$row->company_id.'" value="'.$rslt->row(0)->max_com_limit.'"/>';
							$str.= '</td>';
							$str.= '<td>';
							if($rslt->row(0)->commission_type == "PER")
							{
								$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
								<option value="PER">Percentage</option>
								<option value="AMOUNT">Amount</option>';
								$str.= '</select>';
							}
							else
							{
								$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
								<option value="AMOUNT">Amount</option>
								<option value="PER">Percentage</option>';
								$str.= '</select>';
							}
							$str.= '</td>';
					}
					else
					{
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtMinCom'.$row->company_id.'" name="txtMinCom'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						$str.= '<td><input style="width:150px;" class="form-control" type="text" width="30" id="txtMaxCom'.$row->company_id.'" name="txtMaxCom'.$row->company_id.'" value=""/>';
						$str.= '</td>';
						
						
						
						$str.= '<td>';
							
						$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
						<option value="PER">Percentage</option>
						<option value="AMOUNT">Amount</option>';
						$str.= '</select>';
							
							$str.= '</td>';
						
					}
					$str.='
					<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$group_id.'\')"/></td>
					</tr>
					';
					$i++;
				
		} 
		
		
		$str.='<tr>
    <td></td>
 
    <td colspan=3 align="center">
        <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeall()">
        <input type="hidden" id="hidcompany_ids" value="'.$str_company_id.'">
    </td>
</tr>';
		
       $str.='</table>';
				echo $str;
	}
	public function UpdateGroupCommission()
	{
		//print_r($this->input->post());exit;
		$dataarray = $this->input->post("common");
		$master_array = $dataarray["mastercomm"];
		$dist_array = $dataarray["distcomm"];
		$retailer_array = $dataarray["retailercomm"];
		$api_array = $dataarray["apicomm"];
		$wl_array = $dataarray["wlcomm"];

		//print_r($master_array);exit;


		$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
		foreach($company_rslt->result() as $rwoptr)
		{
			if(isset($master_array[$rwoptr->company_id]))
			{
				$MdComm = $master_array[$rwoptr->company_id];
				$DComm = $dist_array[$rwoptr->company_id];
				$RComm = $retailer_array[$rwoptr->company_id];
				$AComm = $api_array[$rwoptr->company_id];
				$WComm = $wl_array[$rwoptr->company_id];


				$this->db->query("delete from tblgroupapi where company_id = ?",array(intval($rwoptr->company_id)));

				$this->db->query("insert into tblgroupapi(company_id,add_date,ipaddress,RetailerComm,DistComm,MdComm,WLComm,ApiComm) values(?,?,?,?,?,?,?,?)",
									array($rwoptr->company_id,$this->common->getDate(),$this->common->getRealIpAddr(),$RComm,$DComm,$MdComm,$WComm,$AComm));
				
					
				
			}
		}




		$str_resp = '<form action="'.base_url().'_Admin/Prepaid_commission/UpdateGroupCommission" data-ajax="true" data-ajax-method="POST" data-ajax-mode="replace" data-ajax-success="OnSuccess" data-ajax-update="#divEditFormComm" id="form0" method="post" novalidate="novalidate">    

  <input id="btnsubmit" type="submit" value="Save Now" class="btn  waves-effect" style="display:none;">
    <div class="slab-table">
        <table id="updatecolm" class="table table-bordered" style="margin-top: 15px;">
            <thead class="" style="position:initial;">
                <tr>
                    <th>Operator&nbsp;Name</th>
                    <th>Master&nbsp;(M/D)&nbsp;%</th>
                    <th>Distributor&nbsp;%</th>
                    <th>Retailer&nbsp;%</th>
                    
                    <th>API&nbsp;%</th>
                    <th>White Label&nbsp;%</th>
                </tr>
            </thead>
            <tbody id="tbodyshow">';

            
                $rsltgroupapi = $this->db->query("select 
                  a.company_id,a.company_name ,
                  IFNULL(b.RetailerComm,0.00) as  RetailerComm,
                  IFNULL(b.DistComm,0.00) as  DistComm,
                  IFNULL(b.MdComm,0.00) as  MdComm,
                  IFNULL(b.WLComm,0.00) as  WLComm,
                  IFNULL(b.ApiComm,0.00) as  ApiComm
                from tblcompany a 
                left join tblgroupapi b on a.company_id = b.company_id 
                where 
                a.service_id = 1 or a.service_id = 2");
                foreach($rsltgroupapi->result() as $rwoptr)
                {


                   $str_resp .= ' <tr>
                        <td>'.$rwoptr->company_name.'</td>
                        <td>'.$rwoptr->MdComm.'</td>
                        <td>'.$rwoptr->DistComm.'</td>
                        <td>'.$rwoptr->RetailerComm.'</td>
                        <td>'.$rwoptr->ApiComm.'</td>
                        <td>'.$rwoptr->WLComm.'</td>
                    </tr>';

                 }
             

                    
                 
            $str_resp .= '</tbody>
            <tbody id="tbodyedit" style="display:none;">';


               
                  foreach($rsltgroupapi->result() as $rwoptr)
                  {



                        $str_resp .= '<tr>
                          
                          <td>
                              '.$rwoptr->company_name.'
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field mastercomm must be a number." id="common_'.$rwoptr->company_id.'__mastercomm" name="common[mastercomm]['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->MdComm.'">
                              <span class="field-validation-valid" data-valmsg-for="common[mastercomm]['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field dlmcomm must be a number." id="common_'.$rwoptr->company_id.'__dlmcomm" name="common[distcomm]['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->DistComm.'">
                              <span class="field-validation-valid" data-valmsg-for="common[distcomm]['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field dlm_rem_comm must be a number." id="common_'.$rwoptr->company_id.'__dlm_rem_comm" name="common[retailercomm]['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->RetailerComm.'">
                              <span class="field-validation-valid" data-valmsg-for="common[retailercomm]['.$rwoptr->company_id.'" data-valmsg-replace="true"></span>
                          </td>
                          
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field apicomm must be a number." id="common_'.$rwoptr->company_id.'__apicomm" name="common[apicomm]['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->ApiComm.'">
                              <span class="field-validation-valid" data-valmsg-for="common[apicomm]['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field whitelabelcomm must be a number." id="common_'.$rwoptr->company_id.'__whitelabelcomm" name="common[wlcomm]['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->WLComm.'">
                              <span class="field-validation-valid" data-valmsg-for="common[wlcomm]['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                          </td>
                      </tr>';



                   }
                 
                
               
            $str_resp .= '</tbody>
        </table>
    </div>
</form>';

echo  $str_resp;exit;








	}


	public function UserPrepaidSlab()
	{
		$role = trim($this->input->post("role"));
		if($role == "Master")
		{

			if(isset($_POST["Button"]))
			{
				if($this->input->post("Button") == "Update For Existing Users")	
				{
					$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					if($ddlUserId > 0)
					{
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{
							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($ddlUserId,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$ddlUserId,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($ddlUserId,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}
						}
					}
					else
					{

						$master_array = $this->input->post("UpdateMaster");
						
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{



							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];

								$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'MasterDealer'");
								foreach($userlist->result() as $rwuser)
								{
									$rw_user_id = $rwuser->user_id;
									
									$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
									if($rsltcheck->num_rows() == 1)
									{
										$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
									}
									else
									{
										$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
														array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
									}
								}
							}
						}
					
					}
					
				}
				else if($this->input->post("Button") == "Update Existing & New Users")	
				{
					//$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					
				

					$master_array = $this->input->post("UpdateMaster");
					
					$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
					foreach($company_rslt->result() as $rwoptr)
					{



						if(isset($master_array[$rwoptr->company_id]))
						{
							$company_id = $rwoptr->company_id;
							$commission = $master_array[$rwoptr->company_id];

							$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'MasterDealer'");
							foreach($userlist->result() as $rwuser)
							{
								$rw_user_id = $rwuser->user_id;
								
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}




							$rsltcheck_group = $this->db->query("update tblgroupapi set MdComm = ? where company_id = ?",array($commission,$company_id));

						}
					}
				
				
					
				}
			}
			



















			$str_options = '';
			$user_rslt = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'MasterDealer'");
			foreach($user_rslt->result() as $rwuser)
			{
				$str_options.='<option value="'.$rwuser->user_id.'">'.$rwuser->businessname.'</option>';
			}

			$userid = intval(trim($this->input->post("userid")));
			if($userid > 1)
			{
				$rsltgroupapiall = false;
				$tbody = "tbodyedit";
				$userinfo = $this->db->query("select user_id,businessname,usertype_name,mobile_no from tblusers where user_id = ?",array($userid));

				$businessname =  $userinfo->row(0)->businessname;
				$mobile_no =  $userinfo->row(0)->mobile_no;
				$user_id =  $userinfo->row(0)->user_id;



				//echo $businessname."   ".$mobile_no;exit;


					$display_user = $userinfo->row(0)->businessname;

					$rsltgroupapi = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.commission,0.00) as  Commission
	                from tblcompany a 
	                left join tbluser_commission b on a.company_id = b.company_id  and b.user_id = ?
	                where 
	                a.service_id = 1 or a.service_id = 2",array($user_id));
	                $rsltgroupapi_display = $rsltgroupapi;

			}
			else
			{
				$rsltgroupapi = false;
				$tbody = "tbodyedit";
				$user_id = "0";
				$businessname = "";
				$mobile_no = "";

				$display_user = "ALL";
				 $rsltgroupapiall = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.MdComm,0.00) as  Commission
	                from tblcompany a 
	                left join tblgroupapi b on a.company_id = b.company_id 
	                where 
	                a.service_id = 1 or a.service_id = 2");
				 $rsltgroupapi_display = $rsltgroupapiall;
	               
			}


		}
		else if($role == "Dealer")
		{

			if(isset($_POST["Button"]))
			{
				if($this->input->post("Button") == "Update For Existing Users")	
				{
					$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					if($ddlUserId > 0)
					{
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{
							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($ddlUserId,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$ddlUserId,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($ddlUserId,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}
						}
					}
					else
					{

						$master_array = $this->input->post("UpdateMaster");
						
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{



							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];

								$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'Distributor'");
								foreach($userlist->result() as $rwuser)
								{
									$rw_user_id = $rwuser->user_id;
									
									$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
									if($rsltcheck->num_rows() == 1)
									{
										$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
									}
									else
									{
										$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
														array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
									}
								}
							}
						}
					
					}
					
				}
				else if($this->input->post("Button") == "Update Existing & New Users")	
				{
					//$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					
				

					$master_array = $this->input->post("UpdateMaster");
					
					$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
					foreach($company_rslt->result() as $rwoptr)
					{



						if(isset($master_array[$rwoptr->company_id]))
						{
							$company_id = $rwoptr->company_id;
							$commission = $master_array[$rwoptr->company_id];

							$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'Distributor'");
							foreach($userlist->result() as $rwuser)
							{
								$rw_user_id = $rwuser->user_id;
								
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}




							$rsltcheck_group = $this->db->query("update tblgroupapi set DistComm = ? where company_id = ?",array($commission,$company_id));

						}
					}
				
				
					
				}
			}
			













			$str_options = '';
			$user_rslt = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'Distributor'");
			foreach($user_rslt->result() as $rwuser)
			{
				$str_options.='<option value="'.$rwuser->user_id.'">'.$rwuser->businessname.'</option>';
			}

			$userid = intval(trim($this->input->post("userid")));
			if($userid > 1)
			{
				$rsltgroupapiall = false;
				$tbody = "tbodyedit";
				$userinfo = $this->db->query("select user_id,businessname,usertype_name,mobile_no from tblusers where user_id = ?",array($userid));

				$businessname =  $userinfo->row(0)->businessname;
				$mobile_no =  $userinfo->row(0)->mobile_no;
				$user_id =  $userinfo->row(0)->user_id;



				//echo $businessname."   ".$mobile_no;exit;


					$display_user = $userinfo->row(0)->businessname;

					$rsltgroupapi = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.commission,0.00) as  Commission
	                from tblcompany a 
	                left join tbluser_commission b on a.company_id = b.company_id  and b.user_id = ?
	                where 
	                a.service_id = 1 or a.service_id = 2",array($user_id));
	                $rsltgroupapi_display = $rsltgroupapi;

			}
			else
			{
				$rsltgroupapi = false;
				$tbody = "tbodyedit";
				$user_id = "0";
				$businessname = "";
				$mobile_no = "";

				$display_user = "ALL";
				 $rsltgroupapiall = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.DistComm,0.00) as  Commission
	                from tblcompany a 
	                left join tblgroupapi b on a.company_id = b.company_id 
	                where 
	                a.service_id = 1 or a.service_id = 2");
				 $rsltgroupapi_display = $rsltgroupapiall;
	               
			}


		}
		else if($role == "Retailer")
		{

			if(isset($_POST["Button"]))
			{
				if($this->input->post("Button") == "Update For Existing Users")	
				{
					$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					if($ddlUserId > 0)
					{
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{
							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($ddlUserId,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$ddlUserId,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($ddlUserId,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}
						}
					}
					else
					{

						$master_array = $this->input->post("UpdateMaster");
						
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{



							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];

								$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'Agent'");
								foreach($userlist->result() as $rwuser)
								{
									$rw_user_id = $rwuser->user_id;
									
									$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
									if($rsltcheck->num_rows() == 1)
									{
										$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
									}
									else
									{
										$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
														array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
									}
								}
							}
						}
					
					}
					
				}
				else if($this->input->post("Button") == "Update Existing & New Users")	
				{
					//$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					
				

					$master_array = $this->input->post("UpdateMaster");
					
					$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
					foreach($company_rslt->result() as $rwoptr)
					{



						if(isset($master_array[$rwoptr->company_id]))
						{
							$company_id = $rwoptr->company_id;
							$commission = $master_array[$rwoptr->company_id];

							$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'Agent'");
							foreach($userlist->result() as $rwuser)
							{
								$rw_user_id = $rwuser->user_id;
								
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}




							$rsltcheck_group = $this->db->query("update tblgroupapi set RetailerComm = ? where company_id = ?",array($commission,$company_id));

						}
					}
				
				
					
				}
			}
			













			$str_options = '';
			$user_rslt = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'Agent'");
			foreach($user_rslt->result() as $rwuser)
			{
				$str_options.='<option value="'.$rwuser->user_id.'">'.$rwuser->businessname.'</option>';
			}

			$userid = intval(trim($this->input->post("userid")));
			if($userid > 1)
			{
				$rsltgroupapiall = false;
				$tbody = "tbodyedit";
				$userinfo = $this->db->query("select user_id,businessname,usertype_name,mobile_no from tblusers where user_id = ?",array($userid));

				$businessname =  $userinfo->row(0)->businessname;
				$mobile_no =  $userinfo->row(0)->mobile_no;
				$user_id =  $userinfo->row(0)->user_id;



				//echo $businessname."   ".$mobile_no;exit;


					$display_user = $userinfo->row(0)->businessname;

					$rsltgroupapi = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.commission,0.00) as  Commission
	                from tblcompany a 
	                left join tbluser_commission b on a.company_id = b.company_id  and b.user_id = ?
	                where 
	                a.service_id = 1 or a.service_id = 2",array($user_id));
	                $rsltgroupapi_display = $rsltgroupapi;

			}
			else
			{
				$rsltgroupapi = false;
				$tbody = "tbodyedit";
				$user_id = "0";
				$businessname = "";
				$mobile_no = "";

				$display_user = "ALL";
				 $rsltgroupapiall = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.RetailerComm,0.00) as  Commission
	                from tblcompany a 
	                left join tblgroupapi b on a.company_id = b.company_id 
	                where 
	                a.service_id = 1 or a.service_id = 2");
				 $rsltgroupapi_display = $rsltgroupapiall;
	               
			}


		}


		else if($role == "API")
		{

			if(isset($_POST["Button"]))
			{
				if($this->input->post("Button") == "Update For Existing Users")	
				{
					$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					if($ddlUserId > 0)
					{
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{
							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($ddlUserId,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$ddlUserId,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($ddlUserId,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}
						}
					}
					else
					{

						$master_array = $this->input->post("UpdateMaster");
						
						$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
						foreach($company_rslt->result() as $rwoptr)
						{



							if(isset($master_array[$rwoptr->company_id]))
							{
								$company_id = $rwoptr->company_id;
								$commission = $master_array[$rwoptr->company_id];

								$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'APIUSER'");
								foreach($userlist->result() as $rwuser)
								{
									$rw_user_id = $rwuser->user_id;
									
									$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
									if($rsltcheck->num_rows() == 1)
									{
										$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
									}
									else
									{
										$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
														array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
									}
								}
							}
						}
					
					}
					
				}
				else if($this->input->post("Button") == "Update Existing & New Users")	
				{
					//$master_array = $this->input->post("Materuser");
					$ddlUserId = $this->input->post("ddlUserId");
					
				

					$master_array = $this->input->post("UpdateMaster");
					
					$company_rslt = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2");
					foreach($company_rslt->result() as $rwoptr)
					{



						if(isset($master_array[$rwoptr->company_id]))
						{
							$company_id = $rwoptr->company_id;
							$commission = $master_array[$rwoptr->company_id];

							$userlist = $this->db->query("select user_id from tblusers where usertype_name = 'APIUSER'");
							foreach($userlist->result() as $rwuser)
							{
								$rw_user_id = $rwuser->user_id;
								
								$rsltcheck = $this->db->query("select user_id from tbluser_commission where user_id = ? and company_id = ?",array($rw_user_id,$company_id));
								if($rsltcheck->num_rows() == 1)
								{
									$this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,$rw_user_id,$company_id));
								}
								else
								{
									$this->db->query("insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)",
													array($rw_user_id,$rwoptr->company_id,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));	
								}
							}




							$rsltcheck_group = $this->db->query("update tblgroupapi set ApiComm = ? where company_id = ?",array($commission,$company_id));

						}
					}
				
				
					
				}
			}
			













			$str_options = '';
			$user_rslt = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'APIUSER'");
			foreach($user_rslt->result() as $rwuser)
			{
				$str_options.='<option value="'.$rwuser->user_id.'">'.$rwuser->businessname.'</option>';
			}

			$userid = intval(trim($this->input->post("userid")));
			if($userid > 1)
			{
				$rsltgroupapiall = false;
				$tbody = "tbodyedit";
				$userinfo = $this->db->query("select user_id,businessname,usertype_name,mobile_no from tblusers where user_id = ?",array($userid));

				$businessname =  $userinfo->row(0)->businessname;
				$mobile_no =  $userinfo->row(0)->mobile_no;
				$user_id =  $userinfo->row(0)->user_id;



				//echo $businessname."   ".$mobile_no;exit;


					$display_user = $userinfo->row(0)->businessname;

					$rsltgroupapi = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.commission,0.00) as  Commission
	                from tblcompany a 
	                left join tbluser_commission b on a.company_id = b.company_id  and b.user_id = ?
	                where 
	                a.service_id = 1 or a.service_id = 2",array($user_id));
	                $rsltgroupapi_display = $rsltgroupapi;

			}
			else
			{
				$rsltgroupapi = false;
				$tbody = "tbodyedit";
				$user_id = "0";
				$businessname = "";
				$mobile_no = "";

				$display_user = "ALL";
				 $rsltgroupapiall = $this->db->query("select 
	                  a.company_id,a.company_name ,
	                  IFNULL(b.ApiComm,0.00) as  Commission
	                from tblcompany a 
	                left join tblgroupapi b on a.company_id = b.company_id 
	                where 
	                a.service_id = 1 or a.service_id = 2");
				 $rsltgroupapi_display = $rsltgroupapiall;
	               
			}


		}


		



		$str_resp = '<form action="'.base_url().'_Admin/Prepaid_commission/UserPrepaidSlab" data-ajax="true" data-ajax-failure="onfailed" data-ajax-method="POST" data-ajax-mode="replace" data-ajax-success="OnSuccess1" data-ajax-update="#divEditFormComm" id="form0" method="post">    

	<input id="btnsubmituser" type="submit" name="Button" value="Update For Existing Users" class="btn  waves-effect" style="display:none;" />
    <input id="btnsubmitusercommon" type="submit" name="Button" value="Update Existing & New Users" class="btn  waves-effect" style="display:none;" />
    <input id="btnsubmitusercommondlmrem" type="submit" name="Button" value="Update Existing & New Users" class="btn  waves-effect" style="display:none;" />
	<input id="role" name="role" type="hidden" value="'.$role.'" />    
	<div class="row clearfix" style="margin-right:0px;">
        <div class="col-md-12">
            
            <div class="slab-master-block">
                <div class="slab-master-block-left">
                    <div id="allshow" class="row">
                        <div class="col-md-12" style="padding-right:20px;">
                            <div class="custom-district-img">
                                <img src="'.base_url().'vfiles/slab-user.svg" style="width:18px;">
                            </div>
                            <select class="form-control for-select2" id="ddlUserId" name="ddlUserId" onchange="ddlUserIdChange()">
	                            <option value="">All Users</option>
								'.$str_options.'
							</select>';

							if($userid > 0)
							{
								$str_resp .= '

									<script language="javascript">
							document.getElementById("ddlUserId").value = '.$userid.';
							
							</script>

								';
							}


$distributor_options = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'Distributor'");
$str_options_dist = '';
$user_rslt = $this->db->query("select user_id,businessname,mobile_no from tblusers where usertype_name = 'APIUSER'");
foreach($distributor_options->result() as $rwuser_dist)
{
	$str_options_dist.='<option value="'.$rwuser_dist->user_id.'">'.$rwuser_dist->businessname.'</option>';
}

                        $str_resp .= '</div>
                    </div>
                    <div id="retailerdrop" class="row" style="display:none;">

                        <div class="col-md-6" style="padding-right:0px;">
                            <div >
                                <div class="custom-district-img">
                                    <img src="'.base_url().'vfiles/slab-user.svg" style="width:18px;">
                                </div>
                                <select class="form-control for-select2" id="ddldealer" name="ddldealer" onchange="ddlretailerid()">
                                	<option value="">All Distributor</option>
                                	'.$str_options_dist.'
								</select>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:5px;padding-right:20px;">
                            <div >
                                <div class="custom-district-img">
                                    <img src="'.base_url().'vfiles/slab-user.svg" style="width:18px;">
                                </div>
                                <select class="form-control for-select2" id="ddlUserIdrem" name="ddlUserIdrem" onchange="ddlUserIdChangerem()">
                                	<option value="">All Retailer</option>
                                	'.$str_options.'
								</select>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="slab-master-block-right">
                    <div id="slab-master-message" class="slab-master-message slab-master-message-show" style="display: none;">
                        <p>  If you edit the slabs of all the master distributors, you are given a data view of the common slabs.</p>
                    </div>
                    <div id="slab-master-detail" class="slab-master-detail slab-master-detail-hide" style="display: block;">
                        <div class="row clearfix">

                            <div class="col-md-4 col-sm-4 col-xs-4 col-4">
                                <span class="master-slab-right-icon">
                                    <img src="'.base_url().'vfiles/user.svg">
                                </span>
                                <input class="form-control" type="text" placeholder="User Name" value="'.$businessname.'">

                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 col-4">
                                <span class="master-slab-right-icon" style="border-left: 1px solid #bbb;">
                                    <img src="'.base_url().'vfiles/number.svg">
                                </span>
                                <input class="form-control" type="text" placeholder="User Registered Number" value="'.$mobile_no.'">

                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 col-4">
                                <span class="master-slab-right-icon" style="border-left: 1px solid #bbb;">
                                    <img src="'.base_url().'vfiles/email.svg">
                                </span>
                                <input class="form-control" type="text" placeholder="User Registered Mail" value="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <table class="table table-bordered slab-table">
        <thead  style="position: initial;">
            <tr>
                <th>User&nbsp;ID</th>
                <th>Operator&nbsp;Name</th>
                <th>Commission&nbsp;(%)</th>
                

            </tr>
        </thead>
        <tbody id="tbodyshow">
            <!--Master User-->';


            foreach($rsltgroupapi_display->result() as $rwoptr)
            {
            	 


                   $str_resp .= ' <tr>
                   		<td>'.$display_user.'</td>
                        <td>'.$rwoptr->company_name.'</td>
                        <td>'.$rwoptr->Commission.'</td>
                       
                    </tr>';

                 
            }


           $str_resp.=' <!--End Master-->
            <!--Dealer User-->
            <!--End Dealer-->
            <!--Retailer User-->
            <!--End Retailer-->
            <!--Delaer Retailer-->
            <!-- End Dealer Retailer-->
            <!--API User-->
            <!--End API-->
            <!--Whitelabel User-->
            <!--End Whitelabel-->

        </tbody>
        <tbody id="tbodyedit" style="display:none;">
            <!--Master User-->';
            	if($rsltgroupapi != false)
            	{
				foreach($rsltgroupapi->result() as $rwoptr)
                  {




                  		$str_resp .='<tr>
                        <input id="Materuser_'.$rwoptr->company_id.'__RolesName" name="Materuser['.$rwoptr->company_id.']" type="hidden" value="'.$role.'" />
                        <input data-val="true" data-val-number="The field idno must be a number." data-val-required="The idno field is required." id="Materuser_'.$rwoptr->company_id.'__idno" name="Materuser['.$rwoptr->company_id.']" type="hidden" value="'.$rwoptr->company_id.'" />
                        <input id="Materuser_'.$rwoptr->company_id.'__optcode" name="Materuser['.$rwoptr->company_id.']" type="hidden" value="'.$rwoptr->company_id.'" />
                        <td>
                            '.$businessname.'
                        </td>
                        <td>
                            '.$rwoptr->company_name.'
                        </td>
                        <td>
                            <input class="text-box single-line" data-val="true" data-val-number="The field comm must be a number." id="Materuser_'.$rwoptr->company_id.'__comm" name="Materuser['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->Commission.'" />
                            <span class="field-validation-valid" data-valmsg-for="Materuser['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                        </td>


                    </tr>';









                 
                }
            }


          $str_resp.='   <!--End Master-->
            <!--Dealer User-->
            <!--End Dealer-->
            <!--Retailer User-->
            <!--End Retailer-->
            <!--dealer Retailer User-->
            <!--End dealer Retailer-->
            <!--API User-->
            <!--End Api-->
            <!--Whitelabel User-->
            <!--End Whitelabel-->

        </tbody>
        <tbody id="tbodyeditAll" style="display:none;">
            <!--Master User Update-->';

if($rsltgroupapiall != false)
{


            	 foreach($rsltgroupapiall->result() as $rwoptr)
                  {

                 $str_resp .='
                    <tr>
                        <input data-val="true" data-val-number="The field idno must be a number." data-val-required="The idno field is required." id="UpdateMaster__'.$rwoptr->company_id.'_idno" name="UpdateMaster['.$rwoptr->company_id.']" type="hidden" value="'.$rwoptr->company_id.'" />

                        <td>
                            <p>All</p>
                        </td>
                        <td style="display:none;">
                            <input id="UpdateMaster_'.$rwoptr->company_id.'__optcode" name="UpdateMaster['.$rwoptr->company_id.']" type="hidden" value="712" />
                        </td>
                        <td>
                            '.$rwoptr->company_name.'

                        </td>
                        <td>
                            <input data-val="true" data-val-number="The field comm must be a number." id="UpdateMaster_'.$rwoptr->company_id.'__comm" name="UpdateMaster['.$rwoptr->company_id.']" style="width:100%" type="text" value="'.$rwoptr->Commission.'" />
                            <span class="field-validation-valid" data-valmsg-for="UpdateMaster['.$rwoptr->company_id.']" data-valmsg-replace="true"></span>
                        </td>
                    </tr>';
                }
 }
      
          

        $str_resp .='</tbody>
    </table>
</form><link href="'.base_url().'vfiles/select2.min.css" rel="stylesheet" />
<script src="'.base_url().'vfiles/select2.full.min.js"></script>
<script>
    $(".for-select2").select2();


</script>
<script>
        function OnSuccess1(data) {
            $("#btnsubmituser").hide();
            $("#btnsubmitusercommon").hide();
            $("#btnEdit").show();
            var chk = ";
            if (chk == "Retailer") {
                $("#retailerdrop").show();
                $("#allshow").hide();
            }
            else {
                $("#retailerdrop").hide();
                $("#allshow").show();
            }
        }
        function onfailed(error) {
            alert(error.responseText);
        }
</script>
';
echo $str_resp;exit;
	}

	public function index() 
	{
		$rslt = $this->db->query("select company_id,company_name from tblcompany where service_id = 1");
		$this->view_data['result_company'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/prepaid_commission2_view',$this->view_data);					
	}
	function ChangeCommission()
	{
		if($this->session->userdata("ausertype") != "Admin")
		{
			"UN Authorized Access";exit;
		}
		
		$comm = trim($_GET["com"]);
		$mincom = trim($_GET["mincom"]);
		$maxcom = trim($_GET["maxcom"]);
		$comtype = $_GET["comtype"];
		$group_id = $_GET["groupid"];
		$company_id = $_GET["company_id"];
		
		

		
		
		$groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
		if($groupinfo->num_rows() == 1)
		{
				if($maxcom >= 0 and $mincom >= 0)
				{
					if($maxcom > $mincom)
					{
						if($comm <= $maxcom and $comm >= $mincom)
						{
							$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
							if($rslt->num_rows() > 0)
							{

								$insertgroupapi = $this->db->query("update tblgroupapi set commission=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));

								echo "OK";exit;
							}
							else
							{
								$this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
								$this->db->query("insert into tblgroupapi(company_id,commission,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
								echo "OK";exit;
							}	


						}
						else
						{
							echo "Commission Not In Range";exit;
						}
					}
					else
					{
						echo "Max Commission Must Be Gragter Than Or Equal to Min Commission";exit;
					}


				}
				else
				{
					echo "Minus Value Not Allowed";exit;
				}
		}




		


	}
	public function changecommissionodl()
	{
		$comm = $_GET["com"];
		$mincom = $_GET["mincom"];
		$maxcom = $_GET["maxcom"];
		$comtype = $_GET["comtype"];
		$group_id = $_GET["groupid"];
		$company_id = $_GET["company_id"];
		$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			
			$insertgroupapi = $this->db->query("update tblgroupapi set commission=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));
			
			echo true;
		}
		else
		{
			$this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
			$this->db->query("insert into tblgroupapi(company_id,commission,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
			echo true;
		}
		
	}
	public function changeapi()
	{
		$company_id = $_GET["company_id"];
		$api_id = $_GET["api_id"];
		$group_id = $_GET["group_id"];
		$rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
		if($rslt->num_rows() > 0)
		{
			$str_qry ="update tblgroupapi set api_id=? where group_id = $group_id and company_id = ?";
			$insertgroupapi = $this->db->query($str_qry,array($api_id,$company_id));
			echo true;
		}
		
	}
	private function changeusercommission($group_id,$commission,$company_id)
	{
	
			
			$rsltusers = $this->db->query("select user_id from tblusers where scheme_id = ?",array($group_id));
			foreach($rsltusers->result() as $user)
			{
				$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
				if($check_rslt->num_rows()  == 1)
				{
				
					$rslt = $this->db->query("update tbluser_commission set commission = ? where Id = ?",array($commission,$check_rslt->row(0)->Id));
				}
				else
				{
					$this->db->query("delete from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
					$add_date = $this->common->getDate();
					$str_qry = "insert into tbluser_commission(user_id,company_id,commission,add_date) values( ? , ?, ? , ?)";
					$rslt_in = $this->db->query($str_qry,array($user->user_id,$company_id,$commission,$add_date));
				}	
			}	
		}
	
	
}