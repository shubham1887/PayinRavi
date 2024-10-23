<!DOCTYPE html>

<html lang="en">

<?php

	$user_id = $this->Common_methods->decrypt($this->uri->segment(4));
	$result_user = $this->db->query("
		select 
			a.user_id,
			a.parentid,
			a.businessname,
			a.mobile_no,
			a.usertype_name,
			a.username,
			a.state_id,a.city_id,
			b.postal_address,
			b.pincode,
			b.aadhar_number,
			b.pan_no,
			b.gst_no,
			b.landline,
			b.emailid,
			b.contact_person,
			a.scheme_id,
			c.group_name
			from tblusers a
			left join tblusers_info b on a.user_id = b.user_id
			left join tblgroup c on a.scheme_id = c.Id			
			where a.user_id=? and parentid = ?",array($user_id,$this->session->userdata("DistId")));	
 ?>

  <head>

    



    <title>Distributor::FOS Edit</title>



    

     

    

	<?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>

	 	

$(document).ready(function(){

 $(function() {

           $( "#txtBDate" ).datepicker({dateFormat:'yy-mm-dd',changeMonth: true, changeYear: true,yearRange: "-100:+0" });

           

         });

});



</script>





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



function getCityNameOnLoad(urlToSend)

	{

		if(document.getElementById('ddlState').selectedIndex != 0)

		{

								

		$.ajax({

  type: "GET",

  url: urlToSend+""+document.getElementById('ddlState').value,

  success: function(html){

    $("#ddlCity").html(html);

	document.getElementById('ddlCity').value = document.getElementById('hidCityID').value;		

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

	function setLoadValues()

	{

		document.getElementById('ddlparent').value = <?php echo $result_user->row(0)->parentid; ?>;	

		document.getElementById('ddlSchDesc').value = document.getElementById('hidScheme').value;		

		document.getElementById('ddlState').value = document.getElementById('hidStateID').value;

		getCityNameOnLoad('<?php echo base_url()."Distributor/city/getCity/"; ?>');

					

	}	

</script>

  </head> 



  <body>

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

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">FOS</a>

          <span class="breadcrumb-item active">FOS Edit</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>FOS Edit</h4>

        </div>

      </div><!-- d-flex -->



      <div class="br-pagebody">

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-6 col-lg-12">

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                  <form method="post" action="<?php echo base_url()."Distributor/fos_edit?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
							   
<input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table">
<tbody>
<tr>
<td>FOS Name :<input readonly type="text" class="form-control" placeholder="Enter FOS Name." id="txtDistname" name="txtDistname" value="<?php echo $result_user->row(0)->businessname; ?>"  maxlength="100" style="width:300px;"/>
</td>
<td></td>
</tr>
<tr>
<td>Postal Address :<textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control" ><?php echo $result_user->row(0)->postal_address; ?></textarea>
</td>
<td>Pin Code :<input type="text" style="width:300px;" class="form-control" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placehoder="Enter Pin Code." value="<?php echo $result_user->row(0)->pincode; ?>"/>
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
</select><input type="hidden" id="hidStateID" value="<?php echo $result_user->row(0)->state_id; ?>" /> </td>
<td>City/District :<select style="width:300px;" class="form-control" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down"><option value="0">Select City</option>
</select><input type="hidden" id="hidCityID" value="<?php echo $result_user->row(0)->city_id; ?>" /> </td>
</tr>
<tr>
<td>Mobile No :<input readonly style="width:300px;" type="text" class="form-control" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $result_user->row(0)->mobile_no; ?>"/>
</td>
<td>Email :<input type="text" style="width:300px;" class="form-control" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="150" value="<?php echo $result_user->row(0)->emailid; ?>"/></td>
</tr>
<tr>
<td>Pan No :<input readonly type="text" style="width:300px;" class="form-control" name="txtpanNo" id="txtpanNo" value="<?php echo $result_user->row(0)->pan_no; ?>"/></td>
<td>Contact Person :<input style="width:300px;" type="text" class="form-control" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="150" value="<?php echo $result_user->row(0)->contact_person; ?>"/>
</td>
</tr>
<tr>
<td>Aadhar No :<input readonly type="text" style="width:300px;" class="form-control" name="txtAadhar" id="txtAadhar" value="<?php echo $result_user->row(0)->aadhar_number; ?>"/></td>
<td>GST Number :<input readonly style="width:300px;" type="text" class="form-control" id="txtgst" placeholder="Enter GST Number." name="txtgst"  maxlength="150" value="<?php echo $result_user->row(0)->gst_no; ?>"/>
</td>
</tr>
</table>
<table cellpadding="5" cellspacing="0" bordercolor="#f5f5f5" width="80%" border="0">
<tbody>
  <tr>
    <td>
		<td><span style="font-size: 14px;font-weight: bold;margin-left: 20px;">Group :<?php echo $result_user->row(0)->group_name; ?></span>
</td>
</td>
 <td><input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Update Details"/>
      <input type="reset" class="btn btn-default" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
  </tr>
  
  
 
  
</table>
</form>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	

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