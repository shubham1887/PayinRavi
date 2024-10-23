<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor::FOS Registration</title>
      <?php include("files/links.php"); ?>
      <?php include("files/apijaxscripts.php"); ?>
<script type="text/javascript" language="javascript">
	function test()
	{
		alert("here");
	}
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
		
		var scheme_id = '<?php echo $regData['scheme_id']; ?>';
		document.getElementById("ddlState").value = state_id;
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
        <?php include("files/distributorheader.php"); ?>  
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
      <?php include("files/distributorsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">FOS Registration</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                 <?php include("files/messagebox.php");?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>FOS Registrataion
                            
                        </div>
                        <div class="panel-body">
                           <form method="post" action="<?php echo base_url()."Distributor/fos_registration?crypt=".$this->Common_methods->encrypt("MyData")?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<table class="table">
<tbody>
<tr>
<td>FOS Id :<input type="text" class="form-control" placeholder="Enter FOS Id." id="txtUsername" name="txtUsername" value="<?php echo $regData['username']; ?>"  maxlength="100" style="width:300px;"/>
</td>
<td>
</td>
</tr>
<tr>
<td>FOS Name :<input type="text" class="form-control" placeholder="Enter FOS Name." id="txtDistname" name="txtDistname" value="<?php echo $regData['distributer_name']; ?>"  maxlength="100" style="width:300px;"/>
</td>
<td>
</td>
</tr>
<tr>
<td>Postal Address :<textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control" ><?php echo $regData['postal_address']; ?></textarea>
</td>
<td>Pin Code :<input type="text" style="width:300px;" class="form-control" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placehoder="Enter Pin Code." value="<?php echo $regData['pincode']; ?>"/>
</td>
</tr>
<tr>
<td>State :
<input type="hidden" name="hidStateCode" id="hidStateCode" />
<select style="width:300px;" class="form-control" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."Distributor/city/getCity/"; ?>')" placehoder="Select State.<br />Click on drop down"><option value="0">Select State</option>
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
<td>City/District :<select style="width:300px;" class="form-control" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down"><option value="0">Select City</option>
</select></td>
</tr>
<tr>
<td>Mobile No :<input style="width:300px;" type="text" class="form-control" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $regData['mobile_no']; ?>"/>
</td>
<td>Email :<input type="text" style="width:300px;" class="form-control" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="150" value="<?php echo $regData['emailid']; ?>"/></td>
</tr>
<tr>
<td></td>
<td>
</td>
</tr>
<tr>
	<td>
		Pan No :
		<input style="width:300px;" type="text" class="form-control" name="txtpanNo" id="txtpanNo" value="<?php echo $regData['pan_no']; ?>"/>
	</td>
	<td> 
		Contact Person :
		<input style="width:300px;" type="text" class="form-control" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="300" value="<?php echo $regData['contact_person']; ?>"/>
	</td>
</tr>
	<tr>
	<td>
		Aadhar Number :
		<input style="width:300px;" type="text" class="form-control" name="txtAadhar" id="txtAadhar" value="<?php echo $regData['aadhar']; ?>" maxlength="12"/>
	</td>
	<td> 
		GST Number :
		<input style="width:300px;" type="text" class="form-control" id="txtGst" placeholder="Enter GST Number." name="txtGst"  maxlength="12" value="<?php echo $regData['gst']; ?>"/>
	</td>
</tr>
	<tr>
				<td>
					Scheme :
					<select style="width:300px;" class="form-control" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc">
						  <option>Select Scheme</option>
						  <?php
							$str_query = "select * from tblgroup where groupfor = 'FOS'";
							$resultScheme = $this->db->query($str_query);		
							foreach($resultScheme->result() as $row)
							{
								echo "<option value='".$row->Id."'>".$row->group_name."</option>";
							}
							?>
					</select>
				</td>
				
				<td>
					
				</td>
			</tr>
<tr>
	<td colspan="2">
		<table>
			
			
		</table>
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
s