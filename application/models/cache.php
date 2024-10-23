<?php
class Cache extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d");		
		return $date; 
	}

	public function writecontroller($fieldcount)
	{
	    
	    
	   
	    $ddlPageFor =	$this->session->userdata("ddlPageFor");
	    $txtPageName =	$this->session->userdata("txtPageName");
	    $redirect_midpath = "";
		if($ddlPageFor == "Admin")
		{
			$file = APPPATH.'controllers/_Admin/'.$txtPageName.".php";
			$redirect_midpath = "_Admin/".$txtPageName;
		}
		if(!is_file($file))
		{
		    $contents = $this->controller_class_structure_start();
		    $contents .= $this->controller_class_inex_methods($redirect_midpath,$fieldcount);
		    $contents .= $this->controller_class_structure_end();
		    //Save our content to the file.
			file_put_contents($file, $contents);
			
		}
	}
	
	
	public function controller_class_structure_start()
	{
	   $txtPageName =	$this->session->userdata("txtPageName");
	    
	    
	    $contents = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
        class ".ucfirst($txtPageName)." extends CI_Controller {
        "; 
        return $contents;
        
	}
	public function controller_class_structure_end()
	{
	    $contents = "}"; 
        return $contents;
        
	}
	public function controller_class_inex_methods($redirect_midpath,$fieldcount)
	{
	        
	    
	    $contents = "";
	        $this->session->userdata("aloggedin",TRUE);
			$txtPageName = $this->session->userdata("txtPageName");
			$ddlPageFor = $this->session->userdata("ddlPageFor");
			$txtPageTitle = $this->session->userdata("txtPageTitle");
			$txtTableName = $this->session->userdata("txtTableName");
			
			$txtParam1 = $this->session->userdata("txtParam1");
			$ddlparameter_type1 = $this->session->userdata("ddlparameter_type1");
			$txtFieldName1 = $this->session->userdata("txtFieldName1");
			$txtTblRef1 = $this->session->userdata("txtTblRef1");
			$txtTblRef_Id1 = $this->session->userdata("txtTblRef_Id1");
			$txtTblRef_Name1 = $this->session->userdata("txtTblRef_Name1");
			
			$txtParam2 = $this->session->userdata("txtParam2");
			$ddlparameter_type2 = $this->session->userdata("ddlparameter_type2");
			$txtFieldName2 = $this->session->userdata("txtFieldName2");
			$txtTblRef2 = $this->session->userdata("txtTblRef2");
			$txtTblRef_Id2 = $this->session->userdata("txtTblRef_Id2");
			$txtTblRef_Name2 = $this->session->userdata("txtTblRef_Name2");
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////      H E A D      ///////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    
	    $contents.="
    	    public function index()  
    	    {
    		    \$this->output->set_header(\"Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0\");
    		    \$this->output->set_header(\"Pragma: no-cache\"); ";
    		
    	if($ddlPageFor == "Admin")
		{
            $contents.="		
    		if (\$this->session->userdata(\"aloggedin\") != TRUE) 
    		{ 
    			redirect(base_url().\"login\"); 
    		}";
		}
		$contents.="			
					
    		else 		
    		{";
            	///////////////////////////////////////////////////////////////////////////////////////////
        	    ///////////////////////////////////////////////////////////////////////////////////////////
        	    ////////////////////////      B O D Y   I N S  E R T    ///////////////////////////////////
        	    ///////////////////////////////////////////////////////////////////////////////////////////
        	    ///////////////////////////////////////////////////////////////////////////////////////////	
    		
    	    $contents.="	if(\$this->input->post('HIDACTION') == \"INSERT\")
			{";
			
			    $insert_fields = "";
			    $insert_fields_questionmarks = "";
			    $insert_fields_parameters = "";
    			for($k=1;$k<=$fieldcount;$k++)
    			{
    			        
    			        $paramname = $this->session->userdata("txtParam".$k);
        		        $fieldname = $this->session->userdata("txtFieldName".$k);
        		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
        		        
        		        
        		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
        		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
        		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
    			        
    			        
    			        
    			       if($ddlparameter_type == "img")
    			       {
    			           $contents.="if ( isset(\$_FILES[\"file\"])) 
    						{
    							if (\$_FILES[\"file".$paramname."\"][\"error\"] > 0) 
    							{
    								echo \"Return Code: \" . \$_FILES[\"file".$paramname."\"][\"error\"] . \"<br />\";
    							}
    							if (file_exists(\$_FILES[\"file".$paramname."\"][\"name\"])) 
        						{
        							unlink(\$_FILES[\"file".$paramname."\"][\"name\"]);
        						}
        						if (!file_exists(\"userimages/1\")) {
        							mkdir(\"userimages/1\");
        						}
        						\$filename = \$_FILES[\"file".$paramname."\"][\"name\"];
        					
        						
        						date_default_timezone_set('Asia/Kolkata');
         						\$date= date('YmdHis') ;
        						
        						\$storagename = \"userimages/1/\".\$date.\$filename;
        						move_uploaded_file(\$_FILES[\"file".$paramname."\"][\"tmp_name\"],  \$storagename);
    						}";
    			        $contents.="	\$".$paramname." = \$this->input->post(\"txt".$paramname."\");";
    			        $insert_fields.= $fieldname.",";    
    			        $insert_fields_questionmarks.="?,";
    			        $insert_fields_parameters.="\$".$storagename.",";
    			        
    			       }
    			       else
    			       {
    			           $contents.="	\$".$paramname." = \$this->input->post(\"txt".$paramname."\");";
    			        $insert_fields.= $fieldname.",";    
    			        $insert_fields_questionmarks.="?,";
    			        $insert_fields_parameters.="\$".$paramname.",";
    			       }
    			        
    			        
    			       
    			    	
    			}
			    
			
				
    			$contents.="	\$this->db->query(\"insert into ".$txtTableName."(".$insert_fields."add_date,ipaddress)";
    		
    			$contents.=" values(".$insert_fields_questionmarks."?,?)\"";
    		
    			$contents.=",array(";
    			
    			
    			
    			$contents.=$insert_fields_parameters."\$this->common->getDate(),\$this->common->getRealIpAddr()));
    		
    			
    				
    			
    				redirect(base_url().\"".$redirect_midpath."\");
    				
    			}";
    	///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ////////////////////////      B O D Y   U P D A T E     ///////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////	
    	$contents.="	else if(\$this->input->post('HIDACTION') == \"UPDATE\")
			{
				\$".$txtParam1." = \$this->input->post(\"txt".$txtParam1."\");";
				if($txtParam2 != "")
				{
					$contents.="	\$".$txtParam2." = \$this->input->post(\"txt".$txtParam2."\");";
				}
				
				
				$contents.="\$Id = \$this->input->post(\"hidPrimaryId\");
				\$this->db->query(\"update ".$txtTableName."  set ".$txtFieldName1." = ?, ".$txtFieldName2." = ?,edit_date = ?,ipaddress = ? where Id = ?\",array(\$".$txtParam1.",\$".$txtParam1.",\$this->common->getDate(),\$this->common->getRealIpAddr(),\$Id));
				redirect(base_url().\"".$redirect_midpath."\");
			}";
		///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ////////////////////////      B O D Y   D E L E T E     ///////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////	
		$contents.="else if(\$this->input->post('HIDACTION') == \"DELETE\")
			{
				\$Id = \$this->input->post(\"hidPrimaryId\");
				\$this->db->query(\"delete from ".$txtTableName."  where Id = ?\",array(\$Id));
				redirect(base_url().\"".$redirect_midpath."\");
			} ";	
		///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ////////////////////////      B O D Y   L O A D  V I E W   ////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////////////	
        $contents.="else
			{
				\$this->view_data[\"message\"]  = \"\";";
				
				
				 $query = 'select a.*';
				for($k=1;$k<=$fieldcount;$k++)
    			{
    			        
    			        $paramname = $this->session->userdata("txtParam".$k);
        		        $fieldname = $this->session->userdata("txtFieldName".$k);
        		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
        		        
        		        
        		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
        		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
        		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
        		        if($txtTblRef != "")
        		        {
        		            $query .=', a'.$k.'.'.$txtTblRef_Name.' as '.$txtTblRef.'_'.$txtTblRef_Name;
        		        }
    			}
    			        
				 $query .=' from '.$txtTableName.' a ';
				 for($k=1;$k<=$fieldcount;$k++)
    			{
    			        
    			        $paramname = $this->session->userdata("txtParam".$k);
        		        $fieldname = $this->session->userdata("txtFieldName".$k);
        		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
        		        
        		        
        		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
        		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
        		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
        		        if($txtTblRef != "")
        		        {
        		            $query .=' left join '.$txtTblRef.' a'.$k.'  on a.'.$fieldname.'  = a'.$k.'.'.$txtTblRef_Id;
        		        }
    			}
				 
				
				    $contents.="	\$this->view_data[\"data\"]  = \$this->db->query(\"".$query."\");";    
				
				$contents.=" \$this->load->view(\"_Admin/".$txtPageName."_view\",\$this->view_data);
			}";
			
		$contents.="}";//close else part
		$contents.="}";//close Index Method
		return $contents;
	}





/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////// 
    public function writeview($fieldcount)
	{
	    $ddlPageFor =	$this->session->userdata("ddlPageFor");
	    $txtPageName =	$this->session->userdata("txtPageName");
	    $redirect_midpath = "";
		if($ddlPageFor == "Admin")
		{
			$file = APPPATH.'views/_Admin/'.$txtPageName."_view.php";
			$redirect_midpath = "_Admin/".$txtPageName;
		}
		if(!is_file($file))
		{
		    $contents = $this->view_headtag_start($fieldcount);
		    $contents .= $this->view_bodytag_head($fieldcount);
		   // $contents .= $this->view_bodytag_sidebar($fieldcount);
		    //$contents .= $this->view_bodytag_rightbar($fieldcount);
		    $contents .= $this->view_bodytag_maincontent($fieldcount);
		   
			file_put_contents($file, $contents);
			
		}
	}

    public function view_headtag_start($fieldcount)
    {
        	$strhtml = "<!DOCTYPE html>
<html lang=\"en\">
  <head>
		<title><?php echo \$this->session->userdata(\"txtPageTitle\"); ?></title>
		<?php include(\"elements/linksheader.php\"); ?>";
		
		
	$strhtml .= '<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';	
		
		
	$strhtml .= '<script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:\'yy-mm-dd\'});
            $( "#txtTo" ).datepicker({dateFormat:\'yy-mm-dd\'});
         });
});
	

	
	</script>';	
		
	$strhtml .= "</head>";
	
	
	
	
	
	return $strhtml;
    }
    public function view_bodytag_head($fieldcount)
    {
        $strhtml = "<body>
<div class=\"DialogMask\" style=\"display:none\"></div>
   <div id=\"myOverlay\"></div>
<div id=\"loadingGIF\"><img style=\"width:100px;\" src=\"<?PHP echo base_url(); ?>Loading.gif\" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include(\"elements/sidebar.php\"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include(\"elements/header.php\"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include(\"elements/rightbar.php\"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->";
		return $strhtml;
    }
    public function view_bodytag_maincontent($fieldcount)
    {
	 	$txtPageName = $this->session->userdata("txtPageName");
		$ddlPageFor = $this->session->userdata("ddlPageFor");
		$txtPageTitle = $this->session->userdata("txtPageTitle");
		$txtTableName = $this->session->userdata("txtTableName");
        $strhtml = '<div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
						  <a class="breadcrumb-item" href="#">DMT</a>
						  <span class="breadcrumb-item active">'.$txtPageName.'</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   <div class="br-pagetitle">
						<div>
						  <h4>'.$txtPageName.'</h4>
						</div>
					  </div>
      				 <div class="br-pagebody">
						
						';
								
								
								
					$strhtml .= ' <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">'.$txtPageName.' List</h6>
											<span class="tx-12 tx-uppercase">
												<a href="#modal-form" role="button" class="blue btn btn-primary btn-sm" data-toggle="modal" onClick="addform()"> <i class="ace-icon fa fa-plus bigger-120"></i>Add New Item </a>
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">';		
											$strhtml .=$this->writetablecontent($fieldcount);   
											$strhtml .="</div>
            									</div>
        								</div>
									</div><!-- end <div class=row -->
								</div><!-- br-pagebody -->
      	<?php include(\"elements/footer.php\"); ?>
    </div><!-- br-mainpanel -->
	
	
	<!-- ########## END: MAIN PANEL ########## -->
	
	
	
	<script language=\"javascript\">
									function addform()
									{
										document.getElementById(\"HIDACTION\").value = \"INSERT\";
									}
	</script>

    <script src=\"<?php echo base_url();?>lib/jquery/jquery.min.js\"></script>
    <script src=\"<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js\"></script>
    <script src=\"<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js\"></script>
    <script src=\"<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js\"></script>
    <script src=\"<?php echo base_url();?>lib/moment/min/moment.min.js\"></script>
    <script src=\"<?php echo base_url();?>lib/peity/jquery.peity.min.js\"></script>
    <script src=\"<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js\"></script>

    <script src=\"<?php echo base_url();?>js/bracket.js\"></script>
  </body>
</html>
	
	";
	
	$strhtml .=$this->writeview_deletemodel();
	$strhtml .= $this->writeview_insertmodel($fieldcount);
			return $strhtml;
    }
    public function writetablecontent($fieldcount)
    {
        
        $txtPageName = $this->session->userdata("txtPageName");
		$ddlPageFor = $this->session->userdata("ddlPageFor");
		$txtPageTitle = $this->session->userdata("txtPageTitle");
		$txtTableName = $this->session->userdata("txtTableName");
		
		$strhtml = '<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
												<tr>';
        for($k=1;$k<=$fieldcount;$k++)
		{
		        $paramname = $this->session->userdata("txtParam".$k);
		        $fieldname = $this->session->userdata("txtFieldName".$k);
		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
		        
		        
		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
		        
		        
		        $strhtml .= '<th>'.$paramname.'</th>';
		        
		}
		$strhtml .= '
		            <th>DateTime</th>
				    <th></th>
	            </tr>
				</thead>
				<tbody>';
			$strhtml .='<?php foreach($data->result() as $row)
						      { ?>';
        $srcipt_edit_innertext = 'document.getElementById("hidPrimaryId").value =  id;
								  document.getElementById("HIDACTION").value =  "UPDATE";';
								  $strhtml .= '<tr>';
						for($k=1;$k<=$fieldcount;$k++)
                		{
                		        $paramname = $this->session->userdata("txtParam".$k);
                		        $fieldname = $this->session->userdata("txtFieldName".$k);
                		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
                		        
                		        
                		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
                		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
                		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
                		        if($ddlparameter_type == "text")
                		        {
                		            $strhtml .= '<td class="hidden-480"><?php echo $row->'.$fieldname.'; ?>
                		        <input type="hidden" id="hid'.$fieldname.'<?php echo $row->Id;?>" value="<?php echo $row->'.$fieldname.'; ?>"></td>';
                		            
                		        }
								if($ddlparameter_type == "select_static")
                		        {
                		            $strhtml .= '<td class="hidden-480"><?php echo $row->'.$fieldname.'; ?>
                		        <input type="hidden" id="hid'.$fieldname.'<?php echo $row->Id;?>" value="<?php echo $row->'.$fieldname.'; ?>"></td>';
                		            
                		        }
                		        if($ddlparameter_type == "select")
                		        {
                		            $strhtml .= '<td class="hidden-480"><?php echo $row->'.$txtTblRef.'_'.$txtTblRef_Name.'; ?>
                		        <input type="hidden" id="hid'.$fieldname.'<?php echo $row->Id;?>" value="<?php echo $row->'.$fieldname.'; ?>"></td>';
                		            
                		        }
                		        if($ddlparameter_type == "img")
                		        {
                		            $strhtml .= '<td class="hidden-480">
                		            <img src="../<?php echo $row->'.$fieldname.'; ?>">
                		          
                		        <input type="hidden" id="hid'.$fieldname.'<?php echo $row->Id;?>" value="<?php echo $row->'.$fieldname.'; ?>"></td>';
                		            
                		        }
                		        $srcipt_edit_innertext.='document.getElementById("txt'.$paramname.'").value =  document.getElementById("hid'.$fieldname.'"+id).value;';
                		        
                		        
                		}		
                		$strhtml .= '<td class="hidden-480"><?php echo $row->add_date; ?></td>
											<td>
												<div class="hidden-sm hidden-sm btn-group">
												    <button class="btn btn-sm btn-success">
													<i class="ace-icon fa fa-check bigger-120"></i>															</button>

													<button class="btn btn-sm btn-info" onClick="editform(<?php echo $row->Id; ?>)" href="#modal-form" data-toggle="modal">
													<i class="ace-icon fa fa-pencil bigger-120"></i>Edit	
													</button>
												

													<button class="btn btn-sm btn-danger" onClick="deletitem(<?php echo $row->Id; ?>)" href="#modal-formdelete" data-toggle="modal">
												    <i class="ace-icon fa fa-trash-o bigger-120"></i>	Delete														</button>
													<script language="javascript">
													function deletitem(id)
													{
														document.getElementById("hidPrimaryId").value =  id;
														document.getElementById("HIDACTION").value =  "DELETE";
													}
												    </script>

													<button class="btn btn-sm btn-warning">
													<i class="ace-icon fa fa-flag bigger-120"></i>															</button>
												</div>
										</td>';
									$strhtml .= '</tr>';
									$strhtml .=		'<?php } ?>';
									$strhtml .='

												

											</tbody>
										</table>';
						
								$strhtml.='<script language="javascript">
													function editform(id)
													{
														
														'.$srcipt_edit_innertext.'
													}
													</script>'	;				
				return $strhtml;
    }
    public function writeview_deletemodel()
    {
        $strhtml = '<!-------------------------------------- DELETE MODEL START ----------------------->								
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
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>';
return $strhtml;
    }
    public function writeview_insertmodel($fieldcount)
    {
        $strhtml = '<!-------------------------------------- INSERT EDIT MODEL START ----------------------->								
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
														for($k=1;$k<=$fieldcount;$k++)
                                                		{
                                                		        $paramname = $this->session->userdata("txtParam".$k);
                                                		        $fieldname = $this->session->userdata("txtFieldName".$k);
                                                		        $ddlparameter_type = $this->session->userdata("ddlparameter_type".$k);
																$txtddlvalues = $this->session->userdata("txtddlvalues".$k);
                                                		        
                                                		        
                                                		        $txtTblRef = $this->session->userdata("txtTblRef".$k);
                                                		        $txtTblRef_Id = $this->session->userdata("txtTblRef_Id".$k);
                                                		        $txtTblRef_Name = $this->session->userdata("txtTblRef_Name".$k);
                                                		        
                                                		        if($ddlparameter_type == "text")
                                                		        {
                                                		            $strhtml .='
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">'.$paramname.'</label>
																            <div>
																	            <input type="text" name="txt'.$paramname.'" id="txt'.$paramname.'" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>';
                                                		        }
                                                		        if($ddlparameter_type == "select")
                                                		        {
                                                		            $strhtml .='
															
																<div class="form-group">
																<label for="form-field-select-3">'.$paramname.'</label>
																<div>
																	<select name="txt'.$paramname.'" id="txt'.$paramname.'" class="form-control">
																	<option value="0">Select</option>';
																	
																$strhtml .="<?php 
																\$qry = \"select * from ".$txtTblRef."\";
																	\$rsltddl".$k." = \$this->db->query(\$qry);
																	foreach(\$rsltddl".$k."->result() as \$rdd)
																	{?>
																		<option value=\"<?php echo \$rdd->".$txtTblRef_Id."?>\"><?php echo \$rdd->".$txtTblRef_Name."?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class=\"space-4\"></div>";
                                                		        }
																
																if($ddlparameter_type == "select_static")
                                                		        {
																
																$ddlarr =explode(",",$txtddlvalues);
                                                		            $strhtml .='
															
																<div class="form-group">
																<label for="form-field-select-3">'.$paramname.'</label>
																<div>
																	<select name="txt'.$paramname.'" id="txt'.$paramname.'" class="form-control">
																	<option value="0">Select</option>';
																	foreach($ddlarr as $rddlval)
																	{
																		$strhtml .= "<option value='".$rddlval."'>".$rddlval."</option>";	
																	}
																$strhtml .= "
																	
																	</select>
																	
																</div>
															</div>
															<div class=\"space-4\"></div>";
                                                		        }
																
                                                		        if($ddlparameter_type == "img")
                                                		        {
                                                		            $strhtml .='
															
																<div class="form-group">
																<label for="form-field-select-3">'.$paramname.'</label>
																<div>
																	<input type="file" name="file'.$paramname.'" id="file'.$paramname.'">
																	
																</div>
															</div>
															<div class=\"space-4\"></div>';
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
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>	';
return $strhtml;
    }

}

?>