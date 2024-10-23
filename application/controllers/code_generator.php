<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Code_generator extends CI_Controller {
    private function countfields()
    {
        $k =0;
        for($i=1;$i<=20;$i++)
        {
           
            if(isset($_POST["txtFieldName".$i])) 
            {
                
                $tempvariable =  $this->input->post("txtFieldName".$i);
              //  echo $tempvariable."<br>";
                if($tempvariable == "")
                {
                    
                    break;
                }
                else
                {
                    $k++;
                }
                
            }
            else
            {
              
                break;
               
            }
        }
        return $k;
    }
	public function index()
	{
	    
	    
		if($this->input->post("txtPageName"))
		{
		    $fieldcount = $this->countfields();
			$txtPageName = trim($this->input->post("txtPageName"));
			$ddlPageFor = trim($this->input->post("ddlPageFor"));
			$txtPageTitle = trim($this->input->post("txtPageTitle"));
			$txtTableName = trim($this->input->post("txtTableName"));
			
			$txtParam1 = trim($this->input->post("txtParam1"));
			$ddlparameter_type1 = trim($this->input->post("ddlparameter_type1"));
			$txtFieldName1 = trim($this->input->post("txtFieldName1"));
			$txtTblRef1 = trim($this->input->post("txtTblRef1"));
			$txtTblRef_Id1 = trim($this->input->post("txtTblRef_Id1"));
			$txtTblRef_Name1 = trim($this->input->post("txtTblRef_Name1"));
			
			
			$txtParam2 = trim($this->input->post("txtParam2"));
			$ddlparameter_type2 = trim($this->input->post("ddlparameter_type2"));
			$txtFieldName2 = trim($this->input->post("txtFieldName2"));
			$txtTblRef2 = trim($this->input->post("txtTblRef2"));
			$txtTblRef_Id2 = trim($this->input->post("txtTblRef_Id2"));
			$txtTblRef_Name2 = trim($this->input->post("txtTblRef_Name2"));
			
			
			
			
				for($k=1;$k<=$fieldcount;$k++)
				{
				    $this->session->set_userdata("txtParam".$k,$this->input->post("txtParam".$k));
				    $this->session->set_userdata("ddlparameter_type".$k,$this->input->post("ddlparameter_type".$k));
					$this->session->set_userdata("txtddlvalues".$k,$this->input->post("txtddlvalues".$k));
				    $this->session->set_userdata("txtFieldName".$k,$this->input->post("txtFieldName".$k));
				    $this->session->set_userdata("txtTblRef".$k,$this->input->post("txtTblRef".$k));
				    $this->session->set_userdata("txtTblRef_Id".$k,$this->input->post("txtTblRef_Id".$k));
				    $this->session->set_userdata("txtTblRef_Name".$k,$this->input->post("txtTblRef_Name".$k));
				 
				   
				}
			
			
			$this->session->set_userdata("aloggedin",TRUE);
			$this->session->set_userdata("txtPageName",$txtPageName);
			$this->session->set_userdata("ddlPageFor",$ddlPageFor);
			$this->session->set_userdata("txtPageTitle",$txtPageTitle);
			$this->session->set_userdata("txtTableName",$txtTableName);
			
			//$this->session->set_userdata("txtParam1",$txtParam1);
//			$this->session->set_userdata("ddlparameter_type1",$ddlparameter_type1);
//			$this->session->set_userdata("txtFieldName1",$txtFieldName1);
//			$this->session->set_userdata("txtTblRef1",$txtTblRef1);
//			$this->session->set_userdata("txtTblRef_Id1",$txtTblRef_Id1);
//			$this->session->set_userdata("txtTblRef_Name1",$txtTblRef_Name1);
//			
//			$this->session->set_userdata("txtParam2",$txtParam2);
//			$this->session->set_userdata("ddlparameter_type2",$ddlparameter_type2);
//			$this->session->set_userdata("txtFieldName2",$txtFieldName2);
//			$this->session->set_userdata("txtTblRef2",$txtTblRef2);
//			$this->session->set_userdata("txtTblRef_Id2",$txtTblRef_Id2);
//			$this->session->set_userdata("txtTblRef_Name2",$txtTblRef_Name2);
			
			
			
			$redirect_midpath = "";
			if($ddlPageFor == "Admin")
			{
				$file = APPPATH.'controllers/_Admin/'.$txtPageName.".php";
				$redirect_midpath = "_Admin/".$txtPageName;
			}
 			
				//Use the function is_file to check if the file already exists or not.
			if(!is_file($file))
			{
			    $this->load->model("Cache");
			    $this->Cache->writecontroller($fieldcount);
			    $this->Cache->writeview($fieldcount);
			}
		}
				
		else
		{
		$this->session->set_userdata("aloggedin",TRUE);
			$data["message"] = "";
			$this->load->view('code_generator_view',$data);					
		}
	}
	public function writeview()
	{
	
		$txtPageName = $this->session->userdata("txtPageName");
		$ddlPageFor = $this->session->userdata("ddlPageFor");
		$txtPageTitle = $this->session->userdata("txtPageTitle");
		$txtTableName = $this->session->userdata("txtTableName");
		$txtParam1 = $this->session->userdata("txtParam1");
		$ddlparameter_type1 = $this->session->userdata("ddlparameter_type1");
		$txtFieldName1 = $this->session->userdata("txtFieldName1");
		
		
		$txtParam2 = $this->session->userdata("txtParam2");
		$ddlparameter_type2 = $this->session->userdata("ddlparameter_type2");
		$txtFieldName2 = $this->session->userdata("txtFieldName2");
		$txtTblRef2 = $this->session->userdata("txtTblRef2");
		$txtTblRef_Id2 = $this->session->userdata("txtTblRef_Id2");
		$txtTblRef_Name2 = $this->session->userdata("txtTblRef_Name2");
		
		if($ddlPageFor == "Admin")
		{
			$file = APPPATH.'views/_Admin/'.$txtPageName."_view.php";
		}
 			
	
	
		$strhtml = "<!DOCTYPE html>
<html lang=\"en\">
	<head>
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />
		<meta charset=\"utf-8\" />
		<title><?php echo \$this->session->userdata(\"txtPageTitle\"); ?></title>
		<?php include(\"files/links.php\"); ?>
	</head>
	<body class=\"no-skin\">
		<?php include(\"files/adminheader.php\"); ?>
		<div class=\"main-container ace-save-state\" id=\"main-container\">
			<script type=\"text/javascript\">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
		<?php include(\"files/adminsidebar.php\"); ?>
		
		
		<div class=\"main-content\">
				<div class=\"main-content-inner\">
					<div class=\"breadcrumbs ace-save-state\" id=\"breadcrumbs\">
						<ul class=\"breadcrumb\">
							<li>
								<i class=\"ace-icon fa fa-home home-icon\"></i>
								<a href=\"#\">Home</a>							</li>

							<li>
								<a href=\"#\">Other Pages</a>							</li>
							<li class=\"active\">Blank Page</li>
						</ul><!-- /.breadcrumb -->

						<!-- /.nav-search -->
					</div>

					<div class=\"page-content\">
					
					<div class=\"row\">
							<div class=\"col-xs-12\">
							</div>
					</div>
					<div class=\"row\">
							<div class=\"col-xs-12\">
								<!-- PAGE CONTENT BEGINS -->";
								
							$strhtml .='
							<script language="javascript">
							$("#bootbox-regular").on(ace.click_event, function() {
									bootbox.prompt("What is your name?", function(result) {
										if (result === null) {
											
										} else {
											
										}
									});
								});
							</script>	
							<div style="float:right">

								<a href="#modal-form" role="button" class="blue btn btn-primary" data-toggle="modal" onClick="addform()"> <i class="ace-icon fa fa-plus bigger-120"></i>Add New Item </a>
								<script language="javascript">
									function addform()
									{
										document.getElementById("HIDACTION").value = "INSERT";
									}
								</script>
								
								
<!-------------------------------------- INSERT EDIT MODEL START ----------------------->								
								<div id="modal-form" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Please fill the following form fields</h4>
											</div>

											<div class="modal-body">
												<div class="row">
													
													<div class="col-xs-12 col-sm-7">
													<?php echo form_open(\'\',array(\'id\'=>"frmPopup",\'method\'=>\'post\'))?>
												
													<input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
													';
													
													//echo $txtFieldName1."  ".$ddlparameter_type1;exit;
														if($txtFieldName1 != "")
														{
															if($ddlparameter_type1 == "text")
															{
																$strhtml .='
																<input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																<div class="form-group">
																<label for="form-field-select-3">'.$txtParam1.'</label>
																<div>
																	<input type="text" name="txt'.$txtParam1.'" id="txt'.$txtParam1.'" class="form-control">
																</div>
															</div>
															<div class="space-4"></div>';
															}
														}
														if($txtFieldName2 != "")
														{
															if($ddlparameter_type2 == "text")
															{
																$strhtml .='
															
																<div class="form-group">
																<label for="form-field-select-3">'.$txtParam2.'</label>
																<div>
																	<input type="text" name="txt'.$txtParam2.'" id="txt'.$txtParam2.'" class="form-control">
																</div>
															</div>
															<div class="space-4"></div>';
															}
															else if($ddlparameter_type2 == "select")
															{
																$strhtml .='
															
																<div class="form-group">
																<label for="form-field-select-3">'.$txtParam2.'</label>
																<div>
																	<select name="txt'.$txtParam2.'" id="txt'.$txtParam2.'" class="form-control">
																	<option value="0">Select</option>';
																	
																$strhtml .="<?php 
																\$qry = \"select * from ".$txtTblRef2."\";
																	\$rsltddl2 = \$this->db->query(\$qry);
																	foreach(\$rsltddl2->result() as \$rdd)
																	{?>
																		<option value=\"<?php echo \$rdd->".$txtTblRef_Id2."?>\"><?php echo \$rdd->".$txtTblRef_Name2."?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class=\"space-4\"></div>";
															}
														}
												

														

														$strhtml .='
														<?php echo form_close();?>
													</div>
												</div>
											</div>

											<div class="modal-footer">
												<button class="btn btn-sm" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													Cancel
												</button>

												<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="validateandsubmit()">
													<i class="ace-icon fa fa-check"></i>
													Save
												</button>
												<script language="javascript">
												function validateandsubmit()
												{
													document.getElementById("frmPopup").submit();
												}
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>	


<!-------------------------------------- DELETE MODEL START ----------------------->								
								<div id="modal-formdelete" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Are You Soure Want To Delete <span id="spanDeletePopupName"></span></h4>
											</div>
											<div class="modal-footer">
												<button class="btn btn-sm" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													Cancel
												</button>

												<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="deletesubmit()">
													<i class="ace-icon fa fa-check"></i>
													Yes
												</button>
												<script language="javascript">
													function deletesubmit()
													{
														document.getElementById("HIDACTION").value="DELETE";
														document.getElementById("frmPopup").submit();
													}
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>							
							
								<table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													
													<th class="detail-col">Sr.</th>
													<th>'.$txtParam1.'</th>';
													if($txtFieldName2 != "")
													{
														$strhtml .='<th>'.$txtParam2.'</th>';
													}
										$strhtml .='<th>DateTime</th>
													<th></th>
												</tr>
											</thead>

											<tbody>';
										
										
										$strhtml .='<?php foreach($data->result() as $row)
										{ ?>';
										$strhtml .='<tr>
													<td><a href="#">1</a></td>
													<td>
													<?php echo $row->'.$txtFieldName1.'; ?>
													<input type="hidden" id="hid'.$txtFieldName1.'" value="<?php echo $row->'.$txtFieldName1.'; ?>">
													</td>';
													if($txtFieldName2 != "" and $txtTblRef_Name2 != "")
													{
														$strhtml .='<th><?php echo $row->'.$txtTblRef2."_".$txtTblRef_Name2.'; ?>
														<input type="hidden" id="hid'.$txtFieldName2.'" value="<?php echo $row->'.$txtTblRef2."_".$txtTblRef_Name2.'; ?>">
														</th>';
													}
													else if($txtFieldName2 != "")
													{
														$strhtml .='<th><?php echo $row->'.$txtTblRef_Name2.'; ?>
														<input type="hidden" id="hid'.$txtFieldName2.'" value="<?php echo $row->'.$txtTblRef_Name2.'; ?>">
														</th>';
													}
										$strhtml .='<td class="hidden-480"><?php echo $row->add_date; ?></td>
													
													<td>
														<div class="hidden-sm hidden-xs btn-group">
															<button class="btn btn-xs btn-success">
																<i class="ace-icon fa fa-check bigger-120"></i>															</button>

															<button class="btn btn-xs btn-info" onClick="editform(<?php echo $row->Id; ?>)" href="#modal-form" data-toggle="modal">
																<i class="ace-icon fa fa-pencil bigger-120"></i>															</button>
																<script language="javascript">
																function editform(id)
																{
																	document.getElementById("hidPrimaryId").value =  id;
																	document.getElementById("HIDACTION").value =  "UPDATE";
																	document.getElementById("txt'.$txtParam1.'").value =  document.getElementById("hid'.$txtFieldName.'"+id).value;
																}
																</script>

															<button class="btn btn-xs btn-danger" onClick="deletitem(<?php echo $row->Id; ?>)" href="#modal-formdelete" data-toggle="modal">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>															</button>
																<script language="javascript">
																function deletitem(id)
																{
																	document.getElementById("hidPrimaryId").value =  id;
																	document.getElementById("HIDACTION").value =  "DELETE";
																}
																</script>

															<button class="btn btn-xs btn-warning">
																<i class="ace-icon fa fa-flag bigger-120"></i>															</button>
														</div>
													</td>
												</tr>';
										$strhtml .=		'<?php } ?>';
										$strhtml .='

												

											</tbody>
										</table>
										';
								
									
				$strhtml .="				<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<?php include(\"files/adminfooter.php\"); ?>
					
		
		";
		if(!is_file($file))
		{
		file_put_contents($file, $strhtml);
		}
	}
}