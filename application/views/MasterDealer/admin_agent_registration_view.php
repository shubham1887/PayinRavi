<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN::Retailer Registration</title>
      <?php include("files/links.php"); ?>
    <?php include("files/apijaxscripts.php"); ?>
<script type="text/javascript" language="javascript">					
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
function getAreaName(urlToSend)
	{
		if(document.getElementById('ddlCity').selectedIndex != 0)
		{
		$.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlCity').value,
  success: function(html){
	  var html = "<option value='0'>Select Area</option>"+html+"<option value='0'>Other</option>";
    $("#ddlArea").html(html);
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
	function ChangeAmount()
	{
		if(document.getElementById('ddlSchDesc').selectedIndex != 0)
		{
			document.getElementById('spAmount').innerHTML = $("#ddlSchDesc")[0].options[document.getElementById('ddlSchDesc').selectedIndex].getAttribute("amount");
			document.getElementById('hid_scheme_amount').value = document.getElementById('spAmount').innerHTML;
		}
	}	
</script>
	<script language="javascript">
	function selectddlvalue()
	{
		var state_id = '<?php echo $regData['state_id']; ?>';
		var city_id = '<?php echo $regData['city_id']; ?>';
		var retailer_type_id = '<?php echo $regData['retailer_type_id']; ?>';
		var scheme_id = '<?php echo $regData['scheme_id']; ?>';
		var parentid = '<?php echo $regData['parentid']; ?>';
		document.getElementById("ddlState").value = state_id;
		
		document.getElementById("ddlRetType").value = retailer_type_id;
		document.getElementById("ddlSchDesc").value = scheme_id;
		var urlToSend = '<?php echo base_url()."local_area/getCity/"; ?>';
		$.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlState').value,
  success: function(html){
    $("#ddlCity").html(html);
	document.getElementById("ddlCity").value = city_id;
  }
});
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
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
        <?php include("files/adminheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/adminsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Registration Form
                            
                        </div>
                        <div class="panel-body">
                           <form method="post" action="<?php echo base_url()."_Admin/admin_agent_registration";?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<table class="table">
<tr>
<td >Agent Name :<input type="text" class="form-control" placeholder="Enter Agent Name." id="txtDistname" name="txtDistname" value="<?php echo $regData['distributer_name']; ?>"  maxlength="100" style="width:300px;" />
</td>
<td >Select Parent :
<select id="ddlDistname" name="ddlDistname" class="form-control" placeholder="Select Distributor Name." style="width:300px;">
<option>--Select--</option>
<?php
		$str_query = "select * from tblusers where (usertype_name = ?) order by businessname";
		$result = $this->db->query($str_query,array('Distributor'));		
		for($i=0; $i<$result->num_rows(); $i++)
		{
			echo "<option value='".$result->row($i)->user_id	."'>".$result->row($i)->businessname."</option>";
		}
?>
</select>
</td>
</tr>
<tr>
<td >Postal Address :<textarea placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control" style="width:300px;"><?php echo $regData['postal_address']; ?></textarea>
</td>
<td >Pin Code :<input type="text" class="form-control" style="width:300px;" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placeholder="Enter Pin Code." value="<?php echo $regData['pincode']; ?>"/>
</td>
</tr>
<tr>
<td >State :
<input type="hidden" name="hidStateCode" id="hidStateCode" />
<select class="form-control" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."local_area/getCity/"; ?>')" placeholder="Select State.<br />Click on drop down" style="width:300px;"><option value="0">Select State</option>
<?php
$str_query = "select * from tblstate order by state_name";
		$result = $this->db->query($str_query);		
		for($i=0; $i<$result->num_rows(); $i++)
		{
			echo "<option code='".$result->row($i)->codes."' value='".$result->row($i)->state_id."'>".$result->row($i)->state_name."</option>";
		}
?>
</select></td>
<td >City/District :<select class="form-control" id="ddlCity" style="width:300px;" name="ddlCity" placeholder="Select City.<br />Click on drop down"><option value="0">Select City</option>
</select></td>
</tr>
<tr>
<td >Mobile No :<input type="text" class="form-control" style="width:300px;" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10" value="<?php echo $regData['mobile_no']; ?>"/>
</td>
<td >Landline :<input type="text" class="form-control" style="width:300px;" id="txtLandNo" name="txtLandNo" onKeyPress="return isNumeric(event);" placeholder="Enter Landline No.<br />e.g 07926453647" maxlength="11" value="<?php echo $regData['landline']; ?>"/></td>
</tr>
<tr>
<td >Agent Business Name :<select class="form-control" id="ddlRetType" name="ddlRetType" style="width:300px;" placeholder="Select Retailer Type.<br />Click on drop down"><option>Select Agent Business Name</option>
<?php
$str_query = "select * from tblratailertype order by retailer_type_name";
		$result = $this->db->query($str_query);		
		for($i=0; $i<$result->num_rows(); $i++)
		{
			echo "<option value='".$result->row($i)->retailer_type_id."'>".$result->row($i)->retailer_type_name."</option>";
		}
?>
</select></td>
<td >Email :<input type="text" class="form-control" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  style="width:300px;" maxlength="150" value="<?php echo $regData['emailid']; ?>"/><br />
<span id="emailidInfo"></span>
</td>
</tr>
<tr>
<td >Pan No :<input type="text" name="txtpanNo" id="txtpanNo" value="<?php echo $regData['pan_no']; ?>" class="form-control" style="width:300px;" /></td>
<td >Contact Person :<input type="text" class="form-control" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="150" value="<?php echo $regData['contact_person']; ?>"   style="width:300px;" /><br />
</td>
</tr>
<tr>
    <td >Scheme :
    <select class="form-control" style="width:300px;" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc" style="width:300px;">
      <option>Select Scheme</option>
      <?php
$str_query = "select * from tblgroup where groupfor = 'Agent'";
		$resultScheme = $this->db->query($str_query);		
		for($i=0; $i<$resultScheme->num_rows(); $i++)
		{
			echo "<option  value='".$resultScheme->row($i)->Id."'>".$resultScheme->row($i)->group_name."</option>";
		}
?>
      </select>
</td>
    <td><input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Submit Details"/>
      <input type="reset" class="button" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
  </tr>
</table>
</form>
                        </div>
                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            
        </div>
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->
    <!-- Core Scripts - Include with every page -->
   
   <?php include("files/adminfooter.php"); ?> 
</body>
</html>
