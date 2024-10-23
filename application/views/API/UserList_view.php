<!DOCTYPE html>
<html lang="en">
  <head>
		<title><?php echo $this->session->userdata("txtPageTitle"); ?></title>
		<?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script></head><body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
						  <a class="breadcrumb-item" href="#">DMT</a>
						  <span class="breadcrumb-item active">UserList</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
                     <?php include("elements/messagebox.php"); ?>
						<div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
											
										  </div><!-- card-header -->
										  <div class="card-body">
                                          
                                          <form action="<?php echo base_url()."_Admin/agent_list" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table class="table table-bordered table-striped" style="color:#00000E">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <label>NAME</label>
                                            <input class="form-control-sm" id="txtAGENTName" value="<?php echo $txtAGENTName; ?>" name="txtAGENTName" type="text" style="width:120px;" placeholder="ENTER NAME">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>LOGIN ID</label>
                                            <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text" style="width:120px;" placeholder="ENTER LOGIN ID">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>MOBILE NO</label>
                                             <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text" style="width:120px;" placeholder="ENTER MOBILE NO">
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">
                                       <input type="button" id="btnExport" name="btnExport" value="Export To Excel" class="btn btn-success btn-sm" onClick="startexoprttwo()">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                          
                                        </div>
            									</div>
        								</div>
									</div>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">UserList List</h6>
											<span class="tx-12 tx-uppercase">
												<a href="<?php echo base_url()."_Admin/User_registration" ?>"  class="blue btn btn-primary btn-sm" > <i class="ace-icon fa fa-plus bigger-120"></i>Add New User </a>
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body"><table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
												<tr><th>UserId</th><th>Name</th><th>Mobile</th><th>Email</th><th>Address</th><th>State</th><th>City</th><th>Group</th>
		            <th>DateTime</th>
				    <th></th>
	            </tr>
				</thead>
				<tbody><?php foreach($result_dealer->result() as $row)
						      { ?><tr><td class="hidden-480"><?php echo $row->mobile_no; ?>
                		        <input type="hidden" id="hidusername<?php echo $row->user_id;?>" value="<?php echo $row->mobile_no; ?>"></td><td class="hidden-480"><?php echo $row->businessname; ?>
                		        <input type="hidden" id="hidbusinessname<?php echo $row->user_id;?>" value="<?php echo $row->businessname; ?>"></td><td class="hidden-480"><?php echo $row->mobile_no; ?>
                		        <input type="hidden" id="hidmobile_no<?php echo $row->user_id;?>" value="<?php echo $row->mobile_no; ?>"></td><td class="hidden-480"><?php echo $row->emailid; ?>
                		        <input type="hidden" id="hidemailid<?php echo $row->user_id;?>" value="<?php echo $row->emailid; ?>"></td><td class="hidden-480"><?php echo $row->postal_address; ?>
                		        <input type="hidden" id="hidpostal_address<?php echo $row->user_id;?>" value="<?php echo $row->postal_address; ?>"></td><td class="hidden-480"><?php echo $row->state_name; ?>
                		        <input type="hidden" id="hidstate_id<?php echo $row->user_id;?>" value="<?php echo $row->state_id; ?>"></td><td class="hidden-480"><?php echo ""; ?>
                		        <input type="hidden" id="hidCity<?php echo $row->user_id;?>" value="<?php echo ""; ?>"></td>
                                <td class="hidden-480"><?php echo $row->group_name; ?>
                		        <input type="hidden" id="hiddmr_group<?php echo $row->user_id;?>" value="<?php echo $row->dmr_group; ?>"></td><td class="hidden-480"><?php echo $row->add_date; ?></td>
											<td>
												<div class="hidden-sm hidden-sm btn-group">
												    <button class="btn btn-sm btn-success">
													<i class="ace-icon fa fa-check bigger-120"></i>															</button>

													<a class="btn btn-sm btn-info" href="<?php echo base_url()."_Admin/User_edit?cryptid=".$this->Common_methods->encrypt($row->user_id); ?>">
													<i class="ace-icon fa fa-pencil bigger-120"></i>Edit	
													</a>
												

													<a class="btn btn-sm btn-info" href="<?php echo base_url()."_Admin/BalanceTransfer?cryptid=".$this->Common_methods->encrypt($row->user_id); ?>">
												    <i class="fa fa-plus bigger-120"></i>															
                                                    </a>
                                                    <button class="btn btn-sm btn-danger">
												    <i class="fa fa-minus bigger-120"></i>															
                                                    </button>
													

													<button class="btn btn-sm btn-warning">
													<i class="fa fa-share bigger-120"></i>															</button>
												</div>
										</td></tr><?php } ?>

												

											</tbody>
										</table><script language="javascript">
													function editform(id)
													{
														
														document.getElementById("hidPrimaryId").value =  id;
								  document.getElementById("HIDACTION").value =  "UPDATE";document.getElementById("txtUserId").value =  document.getElementById("hidusername"+id).value;document.getElementById("txtName").value =  document.getElementById("hidbusinessname"+id).value;document.getElementById("txtMobile").value =  document.getElementById("hidmobile_no"+id).value;document.getElementById("txtEmail").value =  document.getElementById("hidemailid"+id).value;document.getElementById("txtAddress").value =  document.getElementById("hidpostal_address"+id).value;document.getElementById("txtState").value =  document.getElementById("hidstate_id"+id).value;document.getElementById("txtCity").value =  document.getElementById("hidCity"+id).value;document.getElementById("txtGroup").value =  document.getElementById("hiddmr_group"+id).value;
													}
													</script></div>
            									</div>
        								</div>
									</div><!-- end <div class=row -->
								</div><!-- br-pagebody -->
      	<?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
	
	
	<!-- ########## END: MAIN PANEL ########## -->
	
	
	
	

    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>
	
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
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------><!-------------------------------------- INSERT EDIT MODEL START ----------------------->								
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
													<?php echo form_open('',array('id'=>"frmPopup",'method'=>'post'))?>
												
													<input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
													
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">UserId</label>
																            <div>
																	            <input type="text" name="txtUserId" id="txtUserId" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Name</label>
																            <div>
																	            <input type="text" name="txtName" id="txtName" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Mobile</label>
																            <div>
																	            <input type="text" name="txtMobile" id="txtMobile" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Email</label>
																            <div>
																	            <input type="text" name="txtEmail" id="txtEmail" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Address</label>
																            <div>
																	            <input type="text" name="txtAddress" id="txtAddress" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">State</label>
																<div>
																	<select name="txtState" id="txtState" class="form-control">
																	<option value="0">Select</option><?php 
																$qry = "select * from tblstate";
																	$rsltddl6 = $this->db->query($qry);
																	foreach($rsltddl6->result() as $rdd)
																	{?>
																		<option value="<?php echo $rdd->Id?>"><?php echo $rdd->state_name?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">City</label>
																<div>
																	<select name="txtCity" id="txtCity" class="form-control">
																	<option value="0">Select</option>
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">Group</label>
																<div>
																	<select name="txtGroup" id="txtGroup" class="form-control">
																	<option value="0">Select</option><?php 
																$qry = "select * from mt3_group";
																	$rsltddl8 = $this->db->query($qry);
																	foreach($rsltddl8->result() as $rdd)
																	{?>
																		<option value="<?php echo $rdd->Id?>"><?php echo $rdd->Name?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
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