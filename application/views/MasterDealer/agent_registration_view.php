<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>Distributor Registration</title>



    

     

    

	<?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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
<script>
	 	
$(document).ready(function(){
 $(function() {
           $( "#txtBDate" ).datepicker({dateFormat:'yy-mm-dd',changeMonth: true, changeYear: true });
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
	</script>
  </head> 



  <body onLoad="selectddlvalue()">

<div class="DialogMask" style="display:none"></div>

   <div id="myOverlay"></div>

<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>

    <!-- ########## START: LEFT PANEL ########## -->

    

    <?php include("elements/mdsidebar.php"); ?><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->



    <!-- ########## START: HEAD PANEL ########## -->

    <?php include("elements/mdheader.php"); ?><!-- br-header -->

    <!-- ########## END: HEAD PANEL ########## -->



    <!-- ########## START: RIGHT PANEL ########## -->

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."MasterDealer/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">Distributor</a>

          <span class="breadcrumb-item active">Distributor Registration</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>Distributor Registration</h4>

        </div>

      </div><!-- d-flex -->



      <div class="br-pagebody">

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-6 col-lg-12">
          <?php include("elements/messagebox.php");?>

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                  <form method="post" action="<?php echo base_url()."MasterDealer/agent_registration?crypt=".$this->Common_methods->encrypt("MyData")?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<table class="table">
<tbody>
<tr>
<td><h5>Distributer Name :</h5><input type="text" class="form-control-sm" placeholder="Enter Distributer Name." id="txtDistname" name="txtDistname" value="<?php echo $regData['distributer_name']; ?>"  maxlength="100" style="width:300px;"/>
</td>
<td>
<h5><h5>Mobile No :</h5><input style="width:300px;" type="text" class="form-control-sm" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $regData['mobile_no']; ?>"/>
</td>
</tr>
<tr>
<td><h5>Postal Address :</h5><textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control-sm" ><?php echo $regData['postal_address']; ?></textarea>
</td>
<td><h5>Pin Code :</h5><input type="text" style="width:300px;" class="form-control-sm" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placehoder="Enter Pin Code." value="<?php echo $regData['pincode']; ?>"/>
</td>
</tr>
<tr>
<td><h5>State :</h5>
<input type="hidden" name="hidStateCode" id="hidStateCode" />
<select style="width:300px;" class="form-control-sm" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."Distributor/city/getCity/"; ?>')" placehoder="Select State.<br />Click on drop down"><option value="0">Select State</option>
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
<td><h5>City/District :</h5><select style="width:300px;" class="form-control-sm" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down"><option value="0">Select City</option>
</select></td>
</tr>
<tr>
<td>
    <h5>Scheme :</h5>
					<select style="width:300px;" class="form-control-sm" id="ddlSchDesc"  placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc">
						  <option>Select Scheme</option>
						  <?php
					$str_query = "select * from tblgroup where groupfor = 'Distributor' and user_id = ?";
							$resultScheme = $this->db->query($str_query,array($this->session->userdata("MdId")));		
							foreach($resultScheme->result() as $row)
							{
								echo "<option value='".$row->Id."'>".$row->group_name."</option>";
							}
							?>
					</select>
</td>
<td><h5>Email :</h5><input type="text" style="width:300px;" class="form-control-sm" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="150" value="<?php echo $regData['emailid']; ?>"/></td>
</tr>
<tr>
<td></td>
<td>
</td>
</tr>
<tr>
	<td>
		<h5>Pan No :</h5>
		<input style="width:300px;" type="text" class="form-control-sm" name="txtpanNo" id="txtpanNo" value="<?php echo $regData['pan_no']; ?>"/>
	</td>
	<td> 
		<h5>Contact Person :</h5>
		<input style="width:300px;" type="text" class="form-control-sm" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="300" value="<?php echo $regData['contact_person']; ?>"/>
	</td>
</tr>
<tr>
	<td>
		<h5>Aadhar Number :</h5>
		<input style="width:300px;" type="text" class="form-control-sm" name="txtAadhar" id="txtAadhar" value="<?php echo $regData['aadhar']; ?>" maxlength="12"/>
	</td>
	<td> 
		<h5>GST Number :</h5>
		<input style="width:300px;" type="text" class="form-control-sm" id="txtGst" placeholder="Enter GST Number." name="txtGst"  maxlength="12" value="<?php echo $regData['gst']; ?>"/>
	</td>
</tr>
	<tr>
				<td>
					
				</td>
				
				<td>
						<h5>Birth Date :</h5>
		            <input style="width:300px;" type="text" class="form-control-sm" id="txtBDate" placeholder="Enter Birth Date." name="txtBDate" />
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

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	

      </div><!-- br-pagebody -->

      <script language="javascript">

	function changestatus(val1,id)

	{

		

				$.ajax({

				url:'<?php echo base_url()."MasterDealer/account_report2/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,

				cache:false,

				method:'POST',

				success:function(html)

				{

					if(html == "cash")

					{

						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>  	';

						document.getElementById("ptype"+id).innerHTML = str;		

					}

					else

					{

						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>  	';

						document.getElementById("ptype"+id).innerHTML = str;		

					}

					

				}

				}); 

			

		

	}

</script>

<form id="frmexport" name="frmexport" action="<?php echo base_url()."MasterDealer/account_report2/dataexport" ?>" method="get">

                                    <input type="hidden" id="hidfrm" name="from">

                                    <input type="hidden" id="hidto" name="to">

                                    <input type="hidden" id="hiddb" name="db">

                                    

                                    </form>

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

