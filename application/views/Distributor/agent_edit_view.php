<!DOCTYPE html>
<html lang="en">
<?php
	$user_id = $this->Common_methods->decrypt($this->input->get("id"));
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
			b.birthdate,
			a.scheme_id
			from tblusers a
			left join tblusers_info b on a.user_id = b.user_id
			where a.user_id=?",array($user_id));	
	
 ?>
  <head>
    

    <title>Retaielr Edit</title>

    
     
    
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">Retailer Edit</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Retailer Edit</h4>
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
                  <form method="post" action="<?php echo base_url()."Distributor/agent_edit?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table">

<tr>
<td><h5>Retailer Name :</h5><input type="text" class="form-control-sm" placeholder="Enter Retailer Name." id="txtDistname" name="txtDistname" value="<?php echo $result_user->row(0)->businessname; ?>"  maxlength="100" style="width:300px;"/>
</td>
<td>
</td>
</tr>
<tr>
<td><h5>Postal Address :</h5><textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control-sm" ><?php echo $result_user->row(0)->postal_address; ?></textarea>
</td>
<td><h5>Pin Code :</h5><input type="text" style="width:300px;" class="form-control-sm" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placehoder="Enter Pin Code." value="<?php echo $result_user->row(0)->pincode; ?>"/>
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
			echo "<option  value='".$result->row($i)->state_id."'>".$result->row($i)->state_name."</option>";
		}
?>
</select><input type="hidden" id="hidStateID" value="<?php echo $result_user->row(0)->state_id; ?>" /> </td>
<td><h5>City/District :</h5><select style="width:300px;" class="form-control-sm" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down"><option value="0">Select City</option>
</select><input type="hidden" id="hidCityID" value="<?php echo $result_user->row(0)->city_id; ?>" /> </td>
</tr>
<tr>
<td><h5>Mobile No :</h5><input style="width:300px;" type="text" class="form-control-sm" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $result_user->row(0)->mobile_no; ?>"/>
</td>
<td><h5>Email :</h5><input type="text" style="width:300px;" class="form-control-sm" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="150" value="<?php echo $result_user->row(0)->emailid; ?>"/></td>
</tr>
<tr>
<td><h5>Pan No :</h5><input type="text" style="width:300px;" class="form-control-sm" name="txtpanNo" id="txtpanNo" value="<?php echo $result_user->row(0)->pan_no; ?>"/></td>
<td><h5>Contact Person :</h5><input style="width:300px;" type="text" class="form-control-sm" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="150" value="<?php echo $result_user->row(0)->contact_person; ?>"/>
</td>
</tr>
<tr>
<td><h5>Aadhar No :</h5><input type="text" style="width:300px;" class="form-control-sm" name="txtAadhar" id="txtAadhar" value="<?php echo $result_user->row(0)->aadhar_number; ?>"/></td>
<td><h5>GST Number :</h5><input style="width:300px;" type="text" class="form-control-sm" id="txtgst" placeholder="Enter GST Number." name="txtgst"  maxlength="150" value="<?php echo $result_user->row(0)->gst_no; ?>"/>
</td>
</tr>
<tr>
<td><h5>Birth Date :</h5><input type="text" style="width:300px;" class="form-control-sm" name="txtBDate" id="txtBDate" value="<?php echo $result_user->row(0)->birthdate; ?>"/></td>
<td>
</td>
</tr>
</table>
<table cellpadding="5" cellspacing="0" bordercolor="#f5f5f5" width="80%" border="0">

  <tr>
    <td><h5>Scheme :</h5><select style="width:300px;" class="form-control-sm" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc">
      <option>Select Scheme</option>
      <?php
$str_query = "select * from tblgroup where groupfor = 'Agent' and user_id = ?";
		$resultScheme = $this->db->query($str_query,array($this->session->userdata("DistId")));		
		foreach($resultScheme->result() as $row)
		{
			echo "<option value='".$row->Id."'>".$row->group_name."</option>";
		}
?>
      </select><input type="hidden" id="hidScheme" value="<?php echo $result_user->row(0)->scheme_id; ?>" /> 
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
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-8">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">COMMISSION SETTING</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <form method="post" action="<?php echo base_url()."Distributor/agent_edit/commission?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form2" id="frmdistributer_form2" autocomplete="off">
                                <input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >
    <tr>
        <th>Sr.</th>
        <th>Operator Name</th>
        <th>Commission</th>
        <th></th>
    </tr>            
            
<?php
    $commission_info = $this->db->query("
            select
            a.company_id,
            a.company_name,
            b.commission
            from tblcompany a 
            left join tbluser_commission b on a.company_id = b.company_id and b.user_id = ?
            where a.service_id = 1 or a.service_id = 2 or a.service_id = 3
            order by a.service_id,a.company_name
    ",array($user_id));
    $i = 1;
    $str_company_id = "";
    foreach($commission_info->result() as $cmp)
    {
        $str_company_id.=$cmp->company_id.",";
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $cmp->company_name; ?></td>
            <td>
                <input type="text" id="txtCommissino<?php echo $cmp->company_id; ?>" class="form-control" style="color:#000000;font-weight:bold;width:120px;" value="<?php echo $cmp->commission; ?>">
                
            </td>
            <td ><input type="button" id="btn-change" value="Submit" class="btn btn-primary btn-sm" onClick="changeCommission(<?php echo $cmp->company_id; ?>)"></td>
        </tr>
    <?php 
        $i++;
    }

?>
<tr>
    <td></td>
 
    <td colspan=3 align="center">
        <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeall()">
    </td>
</tr>
</table> 
<input type="hidden" id="hidcompany_ids" value="<?php echo $str_company_id; ?>">

                            </form>
              </div><!-- card-body -->
            </div>
            <script language="javascript">
function changeall()
{
    var ids = document.getElementById("hidcompany_ids").value;
    var struserarr = ids.split(",");
    for(i=0;i<struserarr.length;i++)
	{
		var id = struserarr[i];
		changeCommission(id);
	}
}
function changeCommission(id)
{
  

	var company_id = id;
	var commission = document.getElementById("txtCommissino"+id).value;
	var user_id = <?php echo $user_id; ?>;
	if(commission <= 5)
	{
	  
		$.ajax({
          type: "POST",
          url:'<?php echo base_url();?>Distributor/agent_edit/change_commission?company_id='+company_id+'&commission='+commission,
          cache:false,
          data:{'company_id':company_id,'user_id':user_id,'commission':commission},
          beforeSend: function() 
		  {
           	$('#myOverlay').show();
        	$('#loadingGIF').show();
          },
          success: function(html)
          {
            //alert(html);
          },
          complete:function()
    	  {
    		    $('#myOverlay').hide();
    			$('#loadingGIF').hide();
    			//$('#myLoader').hide();
    	  }
        });
    }
  
	
}
</script> 
        </div>
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