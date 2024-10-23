<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>SuperDistributor Registration</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <script>
	 	
$(document).ready(function(){
 $(function() {
           $( "#txtBDate" ).datepicker({dateFormat:'yy-mm-dd',changeMonth: true, changeYear: true });
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});



$(document).ready(function(){
	//global vars
	var form = $("#frmdistributer_form1");
	var dname = $("#txtDistname");var postaladdr = $("#txtPostalAddr");
	var pin = $("#txtPin");var mobileno = $("#txtMobNo");var emailid = $("#txtEmail");
	var ddlsch = $("#ddlSchDesc");
	var Username = $("#txtUsername");
	var domainname = $("#txtDomainName");
	//On Submitting
	form.submit(function(){
		if(Domainname() & validateDname() & validateAddress() & validatePin() & validateMobileno() & validateEmail() & validateScheme())
			{				
			return true;
			}
		else
			return false;
	});
	//validation functions	
	
	function Domainname(){
		if(domainname.val() == ""){
			domainname.addClass("error");return false;
		}
		else{
			domainname.removeClass("error");return true;
		}		
	}
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
</script>
<style>
	 .error
{
	background:#E2E3FC;
}
	 .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
	
	 </style>
</head>
<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>-->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include("files/sdheader.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sdsidebar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Super Distributor Registration Form</h3>
                        
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                <?php include("files/messagebox.php"); ?>    	
                    
                    
                        <!--<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bordered Table</h4>
                                <h6 class="card-subtitle">Add<code>.table-bordered</code>for borders on all sides of the table and cells.</h6>
                                <div class="table-responsive">
                                    
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <form method="post" action="<?php echo base_url()."SuperDealer/sd_registration"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">  
                                    <table class="table table-bordered bordered table-responsive"> <tbody> 
                                    <tr> 	
                                    <td> 		
                                        <h5>Domain Name :</h5>		
                                        <input type="text" class="form-control-sm" placeholder="Enter Domain Name." id="txtDomainName" name="txtDomainName" value="<?php echo ""; ?>"  maxlength="100" style="width:300px;" /> 	
                                    </td> 
                                    <td> 		
                                      
                                    </td> 
                                    </tr> 
                                    <tr> 	
                                    <td> 		
                                        <h5>SuperDealer Name :</h5>		
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
                                            <?php 					$str_query = "select * from tblgroup where groupfor = 'SuperDealer'"; 					
                                            $resultScheme = $this->db->query($str_query);		 						
                                            foreach($resultScheme->result() as $row) 				
                                            { 								
                                                echo "<option value='".$row->Id."'>".$row->group_name."</option>"; 							
                                            } 	?> 			
                                            </select> 				
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
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <div class="table-responsive">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php include("files/rightbar.php"); ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 <?php echo $this->white->getDomainName(); ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/popper/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="../assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="../assets/plugins/peity/jquery.peity.init.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
</style>
</body>
</html>