<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Commission Groups</title>
		<?php include("elements/linksheader.php"); ?><link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
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
    
    <?php include("elements/distsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/distheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
   
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>
						  <a class="breadcrumb-item" href="#"></a>
						  <span class="breadcrumb-item active">Group</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   <div class="br-pagetitle">
						<div>
						  <h4>GROUPS</h4>
						</div>
					  </div>
      				 <div class="br-pagebody">
						
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Group List</h6>
											<span class="tx-12 tx-uppercase">
												<a href="#modal-form" role="button" class="blue btn btn-primary btn-sm" data-toggle="modal" onClick="addform()"> <i class="ace-icon fa fa-plus bigger-120"></i>Add New Item </a>
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body"><table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
					<tr><th>GroupName</th>
					<th>Group Type</th>
		            <th>DateTime</th>
				    <th></th>
	            </tr>
				</thead>
				<tbody><?php foreach($result_group->result() as $row)
						      { ?>
                  <tr>
                  	<td class="hidden-480">
                  	    <?php echo $row->group_name; ?>
                		<input type="hidden" id="hidName<?php echo $row->Id;?>" value="<?php echo $row->group_name; ?>">
                  </td>
                  <td class="hidden-480">
					<span  id="charge_type_<?php echo $row->Id; ?>">
						<?php echo $row->groupfor; ?>
					</span>
					<input type="hidden" id="hidcharge_type<?php echo $row->Id;?>" value="<?php echo $row->groupfor; ?>"></td>
                    
                    <td class="hidden-480"><?php echo $row->add_date; ?></td>
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
				</td>
				</tr><?php } ?>

												

											</tbody>
										</table><script language="javascript">
													function editform(id)
													{
														
														document.getElementById("hidPrimaryId").value =  id;
								                        document.getElementById("HIDACTION").value =  "UPDATE";
								                        document.getElementById("txtGroupName").value =  document.getElementById("hidName"+id).value;
								                        //alert(document.getElementById("hidcharge_type"+id).value);
								                        document.getElementById("ddlgroupfor").value =  document.getElementById("hidcharge_type"+id).value;
								                        
													}
													</script></div>
            									</div>
        								</div>
									</div><!-- end <div class=row -->
								</div><!-- br-pagebody -->
      	<?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
	
	
	<!-- ########## END: MAIN PANEL ########## -->
	
	
	
	<script language="javascript">
									function addform()
									{
										document.getElementById("HIDACTION").value = "INSERT";
									}
	</script>

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
																            <label for="form-field-select-3">GroupName</label>
																            <div>
																	            <input type="text" name="txtGroupName" id="txtGroupName" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">Group Type</label>
																<div>
																	<select name="ddlgroupfor" id="ddlgroupfor" class="form-control">
    																	<option value="Agent">Retailer</option>
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
																       
																        
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