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
    
   <script language="javascript">
    function getCityName(urlToSend)
	{
		if(document.getElementById('ddlState').selectedIndex != 0)
		{
			document.getElementById('hidStateCode').value = $("#ddlState")[0].options[document.getElementById('ddlState').selectedIndex].getAttribute('code');					
		$.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlState').value,
  success: function(html){
    $("#ddlCity").html(html);
  }
});
		}
	}
	
$(document).ready(function(){
	//global vars
	var form = $("#frmdistributer_form1");
	var dname = $("#txtDistname");var postaladdr = $("#txtPostalAddr");
	var pin = $("#txtPin");var mobileno = $("#txtMobNo");var emailid = $("#txtEmail");
	var ddlsch = $("#ddlSchDesc");
	var Username = $("#txtUsername");
	//On Submitting
	form.submit(function(){
		if(validateDname() & validateAddress() & validatePin() & validateMobileno() & validateEmail() & validateScheme())
			{				
			return true;
			}
		else
			return false;
	});
	//validation functions	
	function validateDname(){
		if(dname.val() == ""){
			dname.addClass("error");return false;
		}
		else{
			dname.removeClass("error");return true;
		}		
	}	
	function validateUsername()
	{
		
		if(Username.val() == ""){
			Username.addClass("error");return false;
		}
		else{
			Username.removeClass("error");return true;
		}		
	}
	function validateAddress(){
		if(postaladdr.val() == ""){
			postaladdr.addClass("error");return false;
		}
		else{
			postaladdr.removeClass("error");return true;
		}		
	}
	function validatePin(){
		if(pin.val() == ""){
			pin.addClass("error");
			return false;
		}
		else{
			pin.removeClass("error");
			return true;
		}
		
	}
	function validateMobileno(){
		if(mobileno.val().length < 10){
			mobileno.addClass("error");return false;
		}
		else{
			mobileno.removeClass("error");return true;
		}
	}
	function validateEmail(){
		var a = $("#txtEmail").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		if(filter.test(a)){
			emailid.removeClass("error");
			return true;
		}
		else{
			emailid.addClass("error");			
			return false;
		}
	}
	function validateScheme(){
		if(ddlsch[0].selectedIndex == 0){
			ddlsch.addClass("error");			
			return false;
		}
		else{
			ddlsch.removeClass("error");		
			return true;
		}
	}
			
	setTimeout(function(){$('div.message').fadeOut(1000);}, 10000);
	
});
</script>
    </head><body>
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
						  <a class="breadcrumb-item" href="#">Users</a>
						  <span class="breadcrumb-item active">Master Distributor Registration Form</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
						<?php include("elements/messagebox.php"); ?>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Registration Form</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">
                                          
										  <form method="post" action="<?php echo base_url()."_Admin/admin_md_registration"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">  
                                    <table class="table table-bordered bordered table-responsive"> <tbody> 
                                    <tr> 	
                                    <td> 		
                                        <h5>MasterDealer Name :</h5>		
                                        <input type="text" class="form-control-sm" placeholder="Enter Dealer Name." id="txtDistname" name="txtDistname" value="<?php echo $regData['distributer_name']; ?>"  maxlength="100" style="width:300px;" /> 	
                                    </td> 
                                    <td> 		
                                        <h5>Mobile No :</h5> 		
                                        <input style="width:300px;" type="text" class="form-control-sm" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $regData['mobile_no']; ?>"/>
                                    </td> 
                                    </tr> 
                                    <tr> 	
                                    <td> 		
                                        <h5>Postal Address :</h5> 		
                                        <textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control-sm" ><?php echo $regData['postal_address']; ?></textarea> 	
                                    </td> 
                                    <td> 		
                                        <h5>Pin Code :</h5> 		
                                        <input type="text" style="width:300px;" class="form-control-sm" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placeholder="Enter Pin Code." value="<?php echo $regData['pincode']; ?>"/> 	
                                    </td> 
                                    </tr>  
                                    <tr> 	
                                    <td> 		
                                    <h5>State :</h5> 		
                                    <input type="hidden" name="hidStateCode" id="hidStateCode" /> 		
                                    <select style="width:300px;" class="form-control-sm" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."_Admin/city/getCity/"; ?>')" placeholder="Select State.<br />Click on drop down">
                                        <option value="0">Select State</option> 		
                                        <?php 		
                                        $str_query = "select * from tblstate order by state_name"; 				
                                        $result = $this->db->query($str_query);		 			
                                        for($i=0; $i<$result->num_rows(); $i++) 				
                                        { 					
                                            echo "<option code='".$result->row($i)->codes."' value='".$result->row($i)->state_id."'>".$result->row($i)->state_name."</option>"; 				
                                        } 		
                                        ?> 		
                                    </select> 	
                                    </td> 	
                                    <td> 		
                                        <h5>City/District :</h5> 	
                                        <select style="width:300px;" class="form-control-sm" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down"> 			
                                        <option value="0">Select City</option> 		
                                        </select> 	
                                    </td> 
                                    </tr>
                                    
                                    
                                    <tr>
                                        <td>
                                            <h5>Wallet1 Flat Commission :</h5>
                                            <input type="text" style="width:300px;" class="form-control-sm" name="txtW1FlatComm" id="txtW1FlatComm" maxlength="5"/>
                                        </td>
                                        <td>
                                            <h5>Wallet2 Flat Commission :</h5>
                                            <input style="width:300px;" type="text" class="form-control-sm" id="txtW2FlatComm"  name="txtW2FlatComm"  maxlength="5" />
                                        </td>
                                    </tr>
                                    
                                    
                                    <tr> 	
                                    <td> 
                                        <h5>Contact Person :</h5> 	
                                        <input style="width:300px;" type="text" class="form-control-sm" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="300" value="<?php echo $regData['contact_person']; ?>"/>
                                    </td> 	
                                    <td> 	
                                        <h5>	Email :</h5> 		
                                        <input style="width:300px;" type="text" class="form-control-sm" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="300" value="<?php echo $regData['emailid']; ?>"/> 	</td> </tr>  
                                    <tr> 	
                                    <td> 		
                                        <h5>Pan No :</h5> 		
                                        <input style="width:300px;" type="text" class="form-control-sm" name="txtpanNo" id="txtpanNo" value="<?php echo $regData['pan_no']; ?>"/> 	
                                    </td> 	
                                    <td>
                                        <h5>Aadhar Number :</h5> 		
                                        <input style="width:300px;" type="text" class="form-control-sm" name="txtAadhar" id="txtAadhar" value="<?php echo $regData['aadhar']; ?>" maxlength="12"/> 	  		 	
                                    </td> 
                                    </tr> 	 
                                    <tr> 	
                                     	
                                    <td>  		
                                        <h5>GST Number :</h5> 		
                                        <input style="width:300px;" type="text" class="form-control-sm" id="txtGst" placeholder="Enter GST Number." name="txtGst"  maxlength="12" value="<?php echo $regData['gst']; ?>"/> 	
                                    </td> 
                                    <td>
                                        <h5>Scheme :</h5> 					
                                            <select style="width:300px;" class="form-control-sm" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc"> 						  
                                            <option>Select Scheme</option> 				
                                            <?php 					$str_query = "select * from tblgroup where groupfor = 'MasterDealer'"; 					
                                            $resultScheme = $this->db->query($str_query);		 						
                                            foreach($resultScheme->result() as $row) 				
                                            { 								
                                                echo "<option value='".$row->Id."'>".$row->group_name."</option>"; 							
                                            } 	?> 			
                                            </select> 				
                                    </td>
                                    </tr> 	 
                                    
                                    <tr> 	
                                        <td> 		
                                         		
                                            <h5>Downline Scheme For Distributor : </h5>				
                                            <select style="width:300px;" class="form-control-sm" id="ddlDownSchDesc"  name="ddlDownSchDesc"> 					
                                                <option>Select Scheme</option> 					
                                                <?php 				
                                                $str_query = "select Id,group_name from tblgroup where groupfor = 'Distributor'"; 					
                                                $resultScheme = $this->db->query($str_query);		 					
                                                foreach($resultScheme->result() as $row) 						
                                                { 						
                                                    echo "<option value='".$row->Id."'>".$row->group_name."</option>"; 						
                                                }?> 					
                                            </select> 				
                                        </td> 				
                                        <td> 				
                                            <h5>Downline Scheme For Retailer :</h5> 				
                                            <select style="width:300px;" class="form-control-sm" id="ddlDownSchDesc2"  name="ddlDownSchDesc2"> 					
                                            <option>Select Scheme</option> 				
                                            <?php 				$str_query = "select Id,group_name from tblgroup where groupfor = 'Agent'"; 					
                                            $resultScheme = $this->db->query($str_query);		 					
                                            foreach($resultScheme->result() as $row) 					
                                            { 						
                                                echo "<option value='".$row->Id."'>".$row->group_name."</option>"; 					
                                            } 					
                                            ?> 					
                                            </select> 				
                                        </td> 			
                                    </tr> 
                                     <tr>   
                                        <td colspan="2">        
                                          
                                                 <?php echo $this->Service_model->getService_checkboxHTMLTABLE(); ?>
                                            
                                        </td> 
                                    </tr> 			 
                                    <tr> 	 
                                        <td colspan="2" align="center">  	
                                        <input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Submit Details"/> 
                                    </td> 
                                    </tr> 	 
                                    </table>   
                                    </form>
										  
										  
										  </div>
            									</div>
        								</div>
									</div><!-- end <div class=row -->
								</div><!-- br-pagebody -->
      	<?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
	
	
	<!-- ########## END: MAIN PANEL ########## -->
	
	
	
	<script src="<?php echo base_url(); ?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url(); ?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/vendor/d3.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/rickshaw.min.js"></script>

    <script src="<?php echo base_url(); ?>js/bracket.js"></script>
    <script src="<?php echo base_url(); ?>js/ResizeSensor.js"></script>
    <script src="<?php echo base_url(); ?>js/widgets.js"></script>
    	<script language="javascript">
		function gethourlysale()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var hourlysale = jsonobj.hourlysale;
						var totalsale = jsonobj.totalsale;
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
						document.getElementById("spark1").innerHTML = hourlysale;
						document.getElementById("spark1_totalsale").innerHTML = totalsale;
						document.getElementById("spark1_totalsale2").innerHTML = totalsale;
						document.getElementById("spark1_totalcharge").innerHTML = totalcharge;
						
						document.getElementById("spark1_totalcount").innerHTML = totalcount;
						
						//sidebar
						document.getElementById("sidebargrosssuccess").innerHTML = totalsale;
						
						
						
					},
					complete:function()
					{
					
						$('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
						//document.getElementById("sp"+tempapiname+"bal").style.display="block";
						//document.getElementById("spin"+tempapiname+"balload").style.display="none";
					}	});
		}
		
		
		function gethourlyRickshawGraph()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var hourlysale = jsonobj.hourlysale;
						var totalsale = jsonobj.totalsale;
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
						
						var arr = [];
						var t =hourlysale.split(",");
						var r2_graf_max = 0;
						for (var i = 0; i < t.length-1; i++) 
						{
								var temparr = {};
								temparr = {x:i,y:+t[i]};
								arr.push(temparr);
								if(+t[i] > r2_graf_max)	
								{
									r2_graf_max = +t[i];
								}
						}
						 
						
						
						console.log(Math.max(+t));
						var rs2 = new Rickshaw.Graph({
						element: document.querySelector('#rickshaw2'),
						renderer: 'area',
						max: r2_graf_max,
						series: [{
						  data: arr,
						  color: '#1CAF9A'
						}]
					  });
					  rs2.render();
						 // Responsive Mode
  new ResizeSensor($('.br-mainpanel'), function(){
    rs2.configure({
      width: $('#rickshaw2').width(),
      height: $('#rickshaw2').height()
    });
    rs2.render();
  });
						
						
					},
					complete:function()
					{
					
						$('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
						//document.getElementById("sp"+tempapiname+"bal").style.display="block";
						//document.getElementById("spin"+tempapiname+"balload").style.display="none";
					}	});
		}
		
$(document).ready(function()
	{
	 // setTimeout(function(){window.location.reload(1);}, 50000);
		//get_load();
		//get_load2()
		gethourlysale();
		gethourlyRickshawGraph();
		//get_operatorpendings();
		//get_operatorrouting();
  		get_Paytmbalance();
	  	//get_M2mbalance();
		//get_Maharshibalance();
		//get_Dmrbalance();
		//get_DMRValues();
	
		//get_SuccessRecharge();
	  	//window.setInterval(get_load, 60000 * 10);
		window.setInterval(gethourlysale, 2000);	
		window.setInterval(gethourlyRickshawGraph, 60000);	
		//window.setInterval(get_operatorrouting, 60000);	
		//window.setInterval(get_balance, 60000 * 10);
		window.setInterval(get_Paytmbalance, 60000);
		//window.setInterval(get_M2mbalance, 60000);
		//window.setInterval(get_Maharshibalance, 60000);
		//window.setInterval(get_SuccessRecharge, 60000);
	
		//window.setInterval(get_DMRValues, 60000);
	
	  
		setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
						   });
						   
						   
						   
	function get_Paytmbalance(){$.ajax({type: "GET",url: '<?php echo base_url(); ?>/_Admin/Dashboard/getAllBalance?api_name=PAYTM',cache: false,success: function(html){$("#spanPAYTMbal").html(html);}});$("#spanPAYTMbal").fadeOut(1000);$("#spanPAYTMbal").fadeIn(2000);}	
	</script>
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1199px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1199px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1200px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
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