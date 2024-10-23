<!DOCTYPE html>
<html lang="en">
  <head>
		<title><?php echo $this->session->userdata("txtPageTitle"); ?></title>
		<?php include("elements/linksheader.php"); ?><link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script>
     <style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}
#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
</head><body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay">
   <div class="d-flex  ht-300 pos-relative align-items-center">
                <div class="sk-rotating-plane bg-black-800"></div>
              </div></div>
<div id="loadingGIF">
</div>
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
						  <span class="breadcrumb-item active">Api</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
						
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Api List</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body"><table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
					<tr>
                    	<th>Name</th>
                        <th>Status</th>
                        <th>NEFT</th>
                        <th>IMPS</th>
                        
                        <th>Neft Hold</th>
				    	<th>Range Status</th>
                        <th>Range Values</th>
                        <th>Re-root</th>
                        <th>Re-root Api</th>
	            </tr>
				</thead>
				<tbody>
				<?php 
				foreach($data->result() as $row)
				  { ?>
                      <tr>
                      	<td class="hidden-480"><?php echo $row->Name; ?>
                		        <input type="hidden" id="hidName<?php echo $row->Id;?>" value="<?php echo $row->Name; ?>">
                        </td>
                        <td class="hidden-480">
						<?php $status = $row->status;
										if($status == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="chkstatus<?php echo $row->Id; ?>" name="chkstatus" value="<?php echo $row->Id; ?>" onClick="settoggledmr(<?php echo $row->Id; ?>)">
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="chkstatus<?php echo $row->Id; ?>" name="chkstatus" value="<?php echo $row->Id; ?>" onClick="settoggledmr(<?php echo $row->Id; ?>)">
										<?php }?>
                        </td>
                        
                        <td class="hidden-480">
						<?php $neft = $row->neft;
										if($neft == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="neft<?php echo $row->Id; ?>" name="neft" value="<?php echo $row->Id; ?>" onClick="settoggleneft(<?php echo $row->Id; ?>)">
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="neft<?php echo $row->Id; ?>" name="neft" value="<?php echo $row->Id; ?>" onClick="settoggleneft(<?php echo $row->Id; ?>)">
										<?php }?>
                        </td>
                        
                        <td class="hidden-480">
						<?php $imps = $row->imps;
										if($imps == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="imps<?php echo $row->Id; ?>" name="imps" value="<?php echo $row->Id; ?>" onClick="settoggleimps(<?php echo $row->Id; ?>)">
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="imps<?php echo $row->Id; ?>" name="imps" value="<?php echo $row->Id; ?>" onClick="settoggleimps(<?php echo $row->Id; ?>)">
										<?php }?>
                        </td>
                        
                        <td class="hidden-480">
								<?php $hold_val = $row->hold_neft;
										if($hold_val == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="chkhold<?php echo $row->Id; ?>" name="chkhold" value="<?php echo $row->Id; ?>" onClick="setholddmr(<?php echo $row->Id; ?>)">
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="chkhold<?php echo $row->Id; ?>" name="chkhold" value="<?php echo $row->Id; ?>" onClick="setholddmr(<?php echo $row->Id; ?>)">
										<?php }?>
                        
                        </td>
                        
                        <td class="hidden-480">
								<?php $range_status = $row->range_status;
										if($range_status == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="chkrangestatus<?php echo $row->Id; ?>" name="chkrangestatus" value="<?php echo $row->Id; ?>" onClick="setrangestatus(<?php echo $row->Id; ?>)">
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="chkrangestatus<?php echo $row->Id; ?>" name="chkrangestatus" value="<?php echo $row->Id; ?>" onClick="setrangestatus(<?php echo $row->Id; ?>)" >
										<?php }?>
                        
                        </td>
                        <td>
                        
                        <input type="text" id="txtRange<?php echo $row->Id; ?>" name="txtRange" value="<?php echo $row->range_values; ?>" onBlur="updaterangedatas(<?php echo $row->Id; ?>)">
                        
                        </td>
                        <td class="hidden-480">
								<?php $reroot = $row->reroot;
										if($reroot == 1)
										{?>
											<input checked style="width: 12px" type="checkbox" class="inline" id="reroot<?php echo $row->Id; ?>" name="reroot" value="<?php echo $row->Id; ?>" onClick="setreroot(<?php echo $row->Id; ?>)" >
										<?php }
										else
										{?>
											<input style="width: 12px" type="checkbox" class="inline" id="reroot<?php echo $row->Id; ?>" name="reroot" value="<?php echo $row->Id; ?>" onClick="setreroot(<?php echo $row->Id; ?>)">
										<?php }?>
                        
                        </td>
                        
                        <td>
                        
                       <select id="ddlrerootapi<?php echo $row->Id; ?>" name="ddlrerootapi" class="form-control-sm" onChange="rerootapichange(<?php echo $row->Id; ?>)">
                       <option value="0"></option>
                       <?php 
					   	$rsltapis = $this->db->query("select Id,Name from tblapi order by Name");
						foreach($rsltapis->result() as $rwap)
						{?>
                        <option value="<?php echo $rwap->Id; ?>"><?php echo $rwap->Name; ?></option>
						<?php }
					   ?>
                       </select>
                        <script language="javascript">
						document.getElementById("ddlrerootapi<?php echo $row->Id; ?>").value = '<?php echo $row->reroot_api; ?>';
						</script>
                        </td>
                        
                    </tr>
					<?php } ?>

					</tbody>
				</table>
				<script language="javascript">
													function editform(id)
													{
														
														document.getElementById("hidPrimaryId").value =  id;
								  document.getElementById("HIDACTION").value =  "UPDATE";document.getElementById("txtName").value =  document.getElementById("hidName"+id).value;document.getElementById("txtUserId").value =  document.getElementById("hidusername"+id).value;document.getElementById("txtPassword").value =  document.getElementById("hidpassword"+id).value;
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
	
	
	
									function setholddmr(id)
									{
									
										if(document.getElementById("chkhold"+id).checked == true)      
										{      
											$('#myOverlay').show();
										$('#loadingGIF').show();  
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=HOLD&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
										$('#myOverlay').show();
										$('#loadingGIF').show();  
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=HOLD&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									
									function settoggledmr(id)
									{
									
										if(document.getElementById("chkstatus"+id).checked == true)      
										{    
											$('#myOverlay').show();
										$('#loadingGIF').show();  
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=Status&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
											$('#myOverlay').show();
										$('#loadingGIF').show();
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=Status&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									
									function setrangestatus(id)
									{
									
										if(document.getElementById("chkrangestatus"+id).checked == true)      
										{      
											$('#myOverlay').show();
										$('#loadingGIF').show();
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=RangeStatus&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
										$('#myOverlay').show();
										$('#loadingGIF').show();

											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=RangeStatus&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									
									
									function updaterangedatas(id)
									{
									
									$('#myOverlay').show();
    								$('#loadingGIF').show();
										$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=RANGE&val='+document.getElementById("txtRange"+id).value,
											cache:false,
											method:'POST',
											success:function(html)
											{
												//alert(html);
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
									}
									
									
									function setreroot(id)
									{
									
										if(document.getElementById("reroot"+id).checked == true)      
										{      
											$('#myOverlay').show();
										$('#loadingGIF').show();
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=Reroot&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
										$('#myOverlay').show();
										$('#loadingGIF').show();

											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=Reroot&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									function rerootapichange(id)
									{
										$('#myOverlay').show();
    									$('#loadingGIF').show();
										$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=RerootApi&val='+document.getElementById("ddlrerootapi"+id).value,
											cache:false,
											method:'POST',
											success:function(html)
											{
												//alert(html);
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
									}
									
									function settoggleneft(id)
									{
									
										if(document.getElementById("neft"+id).checked == true)      
										{      
											$('#myOverlay').show();
										$('#loadingGIF').show();
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=NEFT&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
										$('#myOverlay').show();
										$('#loadingGIF').show();

											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=NEFT&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									function settoggleimps(id)
									{
									
										if(document.getElementById("imps"+id).checked == true)      
										{      
											$('#myOverlay').show();
										$('#loadingGIF').show();
											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=IMPS&val=1',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 
										} 
										else
										{
										$('#myOverlay').show();
										$('#loadingGIF').show();

											$.ajax({
											url:'<?php echo base_url()."_Admin/dmr_report/setvalues?"; ?>api_id='+id+'&field=IMPS&val=0',
											cache:false,
											method:'POST',
											success:function(html)
											{
												
											},
											complete:function()
											{
												 $('#myOverlay').hide();
												$('#loadingGIF').hide();
											}
											}); 

										}  
									}
									
									
								</script>
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
																            <label for="form-field-select-3">Name</label>
																            <div>
																	            <input type="text" name="txtName" id="txtName" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
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
																            <label for="form-field-select-3">Password</label>
																            <div>
																	            <input type="text" name="txtPassword" id="txtPassword" class="form-control">
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