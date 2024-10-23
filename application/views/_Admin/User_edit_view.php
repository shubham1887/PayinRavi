<!DOCTYPE html>
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
			a.flatcomm,
			a.flatcomm2,
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
			b.call_back_url,
			b.client_ip,
			b.client_ip2,
			b.client_ip3,
			b.client_ip4,
			a.scheme_id
			from tblusers a
			left join tblusers_info b on a.user_id = b.user_id
			where a.user_id=?",array($user_id));	
	$api_dropdown_options = $this->Api_model->getApiListForDropdownList();
 ?>
<html lang="en">
  <head>
		<title><?php echo $result_user->row(0)->usertype_name;  ?> Edit</title>
		<?php include("elements/linksheader.php"); ?><link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
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
	    document.getElementById('ddlSchDesc').value = document.getElementById('hidScheme').value;		
		document.getElementById('ddlState').value = document.getElementById('hidStateID').value;
		getCityNameOnLoad('<?php echo base_url()."_Admin/city/getCity/"; ?>');
					
	}	
</script>
     <style>
	 .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
	
	 </style>
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

</style>
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
</style>
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
     <style>
	 .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
	
	 </style>
    </head><body  onLoad="setLoadValues()">
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
						  <a class="breadcrumb-item" href="#"><?php echo $result_user->row(0)->usertype_name;  ?></a>
						  <span class="breadcrumb-item active"><?php echo $result_user->row(0)->usertype_name;  ?> Edit</span>
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
                                        <form method="post" action="<?php echo base_url()."_Admin/user_edit?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table table-borderless" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >

<tr>
    <td align="right">
        <label><?php echo $result_user->row(0)->usertype_name;  ?> Name :</label>
    </td>
    <td>
        <input type="text" class="text" placeholder="Enter Retailer Name." id="txtDistname" name="txtDistname" value="<?php echo $result_user->row(0)->businessname; ?>"  maxlength="100" style="width:300px;"/>
    </td>
    <td align="right">
       
    </td>
    <td>
        
    </td>
</tr>
<tr>
    <td align="right">
        <label>Postal Address :</label>
    </td>
    <td>
        <textarea style="width:300px;" placeholder="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="text" ><?php echo $result_user->row(0)->postal_address; ?></textarea>
    </td>
    <td align="right">
        <label>Pin Code :</label>
    </td>
    <td>
        <input type="text" style="width:300px;" class="text" id="txtPin" onKeyPress="return isNumeric(event);" name="txtPin" maxlength="8" placehoder="Enter Pin Code." value="<?php echo $result_user->row(0)->pincode; ?>"/>
    </td>
</tr>

<tr>
    <td align="right">
        <label>State :</label>
    </td>
    <td>
        <input type="hidden" name="hidStateCode" id="hidStateCode" />
        <select style="width:300px;height:30px;" class="text" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."_Admin/city/getCity/"; ?>')" placehoder="Select State.<br />Click on drop down"><option value="0">Select State</option>
        <?php
        $str_query = "select * from tblstate order by state_name";
        		$result = $this->db->query($str_query);		
        		for($i=0; $i<$result->num_rows(); $i++)
        		{
        			echo "<option  value='".$result->row($i)->state_id."'>".$result->row($i)->state_name."</option>";
        		}
        ?>
        </select>
        <input type="hidden" id="hidStateID" value="<?php echo $result_user->row(0)->state_id; ?>" /> 
    </td>
    <td align="right">
        <label>City/District :</label>
    </td>
    <td>
        <select style="width:300px;height:30px;" class="text" id="ddlCity" name="ddlCity" placeholder="Select City.<br />Click on drop down">
            <option value="0">Select City</option>
        </select>
        <input type="hidden" id="hidCityID" value="<?php echo $result_user->row(0)->city_id; ?>" /> 
    </td>
</tr>

<tr>
    <td align="right"><label>Wallet1 Flat Commission :</label></td>
    <td><input type="text" style="width:300px;" class="text" name="txtW1FlatComm" id="txtW1FlatComm" value="<?php echo $result_user->row(0)->flatcomm; ?>"/></td>
    <td align="right"><label>Wallet2 Flat Commission :</label></td>
    <td><input style="width:300px;" type="text" class="text" id="txtW2FlatComm"  name="txtW2FlatComm"  maxlength="150" value="<?php echo $result_user->row(0)->flatcomm2; ?>"/>
</td>
</tr>



<tr>
<td align="right"><label>Mobile No :</label></td><td><input style="width:300px;" type="text" class="text" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $result_user->row(0)->mobile_no; ?>"/>
</td>
<td align="right"><label>Email :</label></td><td><input type="text" style="width:300px;" class="text" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="150" value="<?php echo $result_user->row(0)->emailid; ?>"/></td>
</tr>
<tr>
<td align="right"><label>Pan No :</label></td><td><input type="text" style="width:300px;" class="text" name="txtpanNo" id="txtpanNo" value="<?php echo $result_user->row(0)->pan_no; ?>"/></td>
<td align="right"><label>Contact Person :</label></td><td><input style="width:300px;" type="text" class="text" id="txtConPer" placeholder="Enter Contact No." name="txtConPer"  maxlength="150" value="<?php echo $result_user->row(0)->contact_person; ?>"/>
</td>
</tr>
<tr>
<td align="right"><label>Aadhar No :</label></td><td><input type="text" style="width:300px;" class="text" name="txtAadhar" id="txtAadhar" value="<?php echo $result_user->row(0)->aadhar_number; ?>"/></td>
<td align="right"><label>GST Number :</label></td><td><input style="width:300px;" type="text" class="text" id="txtgst" placeholder="Enter GST Number." name="txtgst"  maxlength="150" value="<?php echo $result_user->row(0)->gst_no; ?>"/>
</td>
</tr>
<tr>
    <td align="right"><label>Birth Date :</label></td><td><input type="text" style="width:300px;" class="text" name="txtBDate" id="txtBDate" value="<?php echo $result_user->row(0)->birthdate; ?>"/></td>
    <td align="right">
        <label>Scheme :</label>
    </td>
    <td>
        <select style="width:300px;height:30px;" class="text" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.Click on drop down" name="ddlSchDesc">
          <option>Select Scheme</option>
          <?php
            $str_query = "select * from tblgroup where groupfor = 'APIUSER'";
    		$resultScheme = $this->db->query($str_query);		
    		foreach($resultScheme->result() as $row)
    		{
    			echo "<option value='".$row->Id."'>".$row->group_name."</option>";
    		}
        ?>
          </select>
          <input type="hidden" id="hidScheme" value="<?php echo $result_user->row(0)->scheme_id; ?>" /> 
    </td>
</tr>
</table>









<!------------------   callback and ip settings -------------------------->



    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Service Access</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
</div><!-- card-header -->



 <div class="card-body"><!--- start card-body-->

<table class="table table-borderless" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >
    <tr> 	
        <td>Callback Url</td>
        <td colspan="4"><input type="text" id="txtCallbackUrl"  name="txtCallbackUrl" class="text" value="<?php echo $result_user->row(0)->call_back_url; ?>"  style="width:950px;height:30px;" placeholder="http://www.yourdomainname.com"></td>
    </tr> 
    <tr> 
        <td>Ip Address</td>
     
            
        <td><input type="text" id="txtIp1"  name="txtIp1" class="text"  style="width:150px;height:30px;" placeholder="Ip Address 1" value="<?php echo $result_user->row(0)->client_ip; ?>">  </td>
        <td><input type="text" id="txtIp2"  name="txtIp2" class="text"  style="width:150px;height:30px;" placeholder="Ip Address 2" value="<?php echo $result_user->row(0)->client_ip2; ?>"> </td>
        <td><input type="text" id="txtIp3"  name="txtIp3" class="text"  style="width:150px;height:30px;" placeholder="Ip Address 3" value="<?php echo $result_user->row(0)->client_ip3; ?>"> </td>
        <td><input type="text" id="txtIp4"  name="txtIp4" class="text"  style="width:150px;height:30px;" placeholder="Ip Address 4" value="<?php echo $result_user->row(0)->client_ip4; ?>"> </td>
               
       
    </tr> 
</table>

</div><!--- end card-body-->


















<!-----------xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx------------>








































<div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Service Access</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
</div><!-- card-header -->



 <div class="card-body"><!--- start card-body-->

<table class="table table-borderless" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >
    <tr> 	
        <td colspan="2"> 		
            <?php echo $this->Service_model->getService_checkboxHTMLTABLE($result_user->row(0)->user_id); ?>
        </td> 
    </tr> 
</table>

</div><!--- end card-body-->
<table class="table table-borderless" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >
    <tr> 	
        <td colspan="2"> 		
            <input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Update Details"/>
      <input type="reset" class="btn btn-default" id="bttnCancel" name="bttnCancel" value="Cancel"/>
        </td> 
    </tr> 
</table>






</form>
										  </div>
            									</div>
        								</div>
						</div><!-- end <div class=row -->
                        
                        
            <div class="row row-sm mg-t-20">
                <div class="col-sm-12 col-lg-12">
				    <div class="card shadow-base bd-0">
				        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Commission Settings</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
					    </div><!-- card-header -->
                        <div class="card-body">
									  <form method="post" action="<?php echo base_url()."_Admin/distributer_edit/commission?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form2" id="frmdistributer_form2" autocomplete="off">
                                <input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table table-borderless" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden" >
    <tr>
        <th>Sr.</th>
        <th>Operator Name</th>
        <th>Commission</th>
        <th>Type</th>
        <th>Api1</th>
        <th>Limit Txn</th>
        <th>Limit Amount</th>
        <th>Blocked Amounts</th>
        <th></th>
    </tr>            
            
<?php
$option_slabs = '<optgroup label="COMMISSION_SLAB">';
$rslt_slabs = $this->db->query("SELECT Id,Name FROM `mt3_group` order by Name");
foreach($rslt_slabs->result() as $rwslab)
{
    $option_slabs.='<option value="'.$rwslab->Id.'">'.$rwslab->Name.'</option>';
}
 $ooption_slabs .= '</optgroup>';


    $commission_info = $this->db->query("
            select
            a.company_id,
            a.company_name,
            b.commission,
            b.commission_type,
            b.loadlimit,
            b.api_id,
            b.txn_limit,
            b.blocked_amounts
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
                <input type="text" id="txtComm<?php echo $cmp->company_id; ?>" class="text" style="color:#000000;font-weight:bold;width:120px;" value="<?php echo $cmp->commission; ?>">
            </td>
            <td>
                <select id="ddlcommtype<?php echo $cmp->company_id; ?>" name="ddlcommtype<?php echo $cmp->company_id; ?>" class="text" style="width:120px;height:30px">
                    <option value="PER">%</option>
                    <option value="AMOUNT">Amount</option>
                    <option value="STATE_WISE">STATE_WISE</option>
                    <?php echo $option_slabs; ?>
                </select>
                <script language="javascript">
                    document.getElementById("ddlcommtype<?php echo $cmp->company_id; ?>").value = '<?php echo $cmp->commission_type; ?>';
                </script>
            </td>
            <td>
                <select id="ddlapi1<?php echo $cmp->company_id; ?>" name="ddlapi1<?php echo $cmp->company_id; ?>" class="text" style="width:120px;height:30px">
                    <option value="0"></option>
                    <?php echo $api_dropdown_options;?>
                </select>
                <script language="javascript">
                    document.getElementById("ddlapi1<?php echo $cmp->company_id; ?>").value = '<?php echo $cmp->api_id; ?>';
                </script>
            </td>
            
            <td>
                <input type="number" id="txttxnLimit<?php echo $cmp->company_id; ?>" name="txttxnLimit<?php echo $cmp->company_id; ?>" class="text" style="color:#000000;font-weight:bold;width:60px;" value="<?php echo $cmp->txn_limit; ?>">
            </td>
            <td>
                <input type="number" id="txtAmountLimit<?php echo $cmp->company_id; ?>" name="txtAmountLimit<?php echo $cmp->company_id; ?>" class="text" style="color:#000000;font-weight:bold;width:80px;" value="<?php echo $cmp->loadlimit; ?>">
            </td>
            <td>
                <input type="text" id="txtBlockedAmount<?php echo $cmp->company_id; ?>" name="txtBlockedAmount<?php echo $cmp->company_id; ?>" class="text" style="color:#000000;font-weight:bold;width:120px;" value="<?php echo $cmp->blocked_amounts; ?>">
            </td>
            
            <td style="display:none"><input type="button" id="btn-change" value="Submit" class="btn btn-primary btn-sm" onClick="changeCommission_all(<?php echo $cmp->user_id; ?>)"></td>
        </tr>
    <?php 
        $i++;
    }

?>
<tr>
    <td></td>
 
    <td colspan=3 align="center">
        <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeCommission_all()">
         <img style="width:60px;display:none" id="imgloadingbtn" src="<?php echo base_url()."Loading.gif"; ?>" ></span>
    </td>
</tr>
</table> 
<input type="hidden" id="hidcompany_ids" value="<?php echo $str_company_id; ?>">

                            </form>
</div> <!-- card body-->                           
</div> 
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
          url:'<?php echo base_url();?>_Admin/distributer_edit/change_commission?company_id='+company_id+'&commission='+commission,
          cache:false,
          data:{'company_id':company_id,'user_id':user_id,'commission':commission},
          beforeSend: function() 
		  {
           	$('#myOverlay').show();
        	$('#loadingGIF').show();
          },
          success: function(html)
          {
            
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



function changeCommission_all()
{
    var params = new Array()
    var user_id = '<?php echo $result_user->row(0)->user_id; ?>';
   var ids = document.getElementById("hidcompany_ids").value;
   var struserarr = ids.split(",");
   for(i=0;i<struserarr.length;i++)
   {
       var jcompany_id = struserarr[i];
       if(jcompany_id > 0)
       {
           params[jcompany_id]= document.getElementById("txtComm"+jcompany_id).value+"@"+document.getElementById("ddlcommtype"+jcompany_id).value+"@"+document.getElementById("ddlapi1"+jcompany_id).value+"@"+document.getElementById("txttxnLimit"+jcompany_id).value+"@"+document.getElementById("txtAmountLimit"+jcompany_id).value+"@"+document.getElementById("txtBlockedAmount"+jcompany_id).value;
       }   
   }
   $.ajax({
          type: "POST",
          url:'<?php echo base_url();?>_Admin/agent_edit/ChangeCommission',
          cache:false,
          data:{'params':params,'user_id':user_id},
          beforeSend: function() 
		  {
		    document.getElementById("imgloadingbtn").style.display="block";
            $('#myModal').modal({show:true});
          },
          success: function(html)
          {
            console.log( html );
          },
          complete:function()
    	  {
    		document.getElementById("imgloadingbtn").style.display="none";
    		$('#myModal').modal('hide');
    		$('#myModal').hide();
    	  }
        });
  
	

	
	 
	  
	      
		
	  
    
  
	
}

</script>
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
    
  </body>
</html>