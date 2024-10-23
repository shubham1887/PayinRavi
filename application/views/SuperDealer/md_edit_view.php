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
      a.downline_scheme,
      a.downline_scheme2,
      a.state_id,a.city_id,
      b.postal_address,
      b.pincode,
      b.aadhar_number,
      b.pan_no,
      b.gst_no,
      b.landline,
      b.emailid,
      b.contact_person,
      a.scheme_id
      from tblusers a
      left join tblusers_info b on a.user_id = b.user_id
      where a.user_id=? and host_id = ?",array($user_id,$this->session->userdata("SdId"))); 
  //print_r($result_user->result());exit;
 ?>
<html lang="en">
  <head>
        <title>Master Distributor Edit</title>
        <?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     


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


    </head><body   onLoad="setLoadValues()">
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sdsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/sdheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
                      <div class="br-pageheader">
                      </div><!-- br-pageheader -->
                      <!-- d-flex -->
                       
                     <div class="br-pagebody">
                        <?php include("elements/messagebox.php"); ?>
                        
                        
                        
            <div class="row row-sm mg-t-20">
                <div class="col-sm-12 col-lg-12">
                    <div class="card shadow-base bd-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Commission Settings</h6>
                                            <span class="tx-12 tx-uppercase">
                                                
                                            
                                            </span>
                        </div><!-- card-header -->
                        <div class="card-body">
                        

                                <form method="post" action="<?php echo base_url()."SuperDealer/md_edit?crypt=".$this->Common_methods->encrypt("MyData");?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">
<input type="hidden" name="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>">
<table class="table">
<tbody>
<tr>
<td><h5>MasterDistributor Name :</h5><input type="text" class="form-control-sm" placeholder="Enter MD Name." id="txtDistname" name="txtDistname" value="<?php echo $result_user->row(0)->businessname; ?>"  maxlength="100" style="width:300px;"/>
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
<select style="width:300px;" class="form-control-sm" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."_Admin/city/getCity/"; ?>')" placehoder="Select State.<br />Click on drop down"><option value="0">Select State</option>
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
<td><h5>Wallet1 Flat Commission :</h5><input type="text" style="width:300px;" class="form-control-sm" name="txtW1FlatComm" id="txtW1FlatComm" value="<?php echo $result_user->row(0)->flatcomm; ?>"/></td>
<td><h5>Wallet2 Flat Commission :</h5><input style="width:300px;" type="text" class="form-control-sm" id="txtW2FlatComm"  name="txtW2FlatComm"  maxlength="150" value="<?php echo $result_user->row(0)->flatcomm2; ?>"/>
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
                                            <script language="javascript">
                                              document.getElementById("ddlDownSchDesc").value = '<?php echo $result_user->row(0)->downline_scheme; ?>';
                                            </script>             
                                        </td>               
                                        <td>                
                                            <h5>Downline Scheme For Retailer :</h5>                 
                                            <select style="width:300px;" class="form-control-sm" id="ddlDownSchDesc2"  name="ddlDownSchDesc2">                  
                                            <option>Select Scheme</option>              
                                            <?php               $str_query = "select Id,group_name from tblgroup where groupfor = 'Agent'";                     
                                            $resultScheme = $this->db->query($str_query);                           
                                            foreach($resultScheme->result() as $row)                    
                                            {                       
                                                echo "<option value='".$row->Id."'>".$row->group_name."</option>";                  
                                            }                   
                                            ?>                  
                                            </select>  
                                             <script language="javascript">
                                              document.getElementById("ddlDownSchDesc2").value = '<?php echo $result_user->row(0)->downline_scheme2; ?>';
                                            </script>               
                                        </td>           
                                    </tr>      
</table>


<table cellpadding="5" cellspacing="0" bordercolor="#f5f5f5" width="80%" border="0">
<tbody>
  <tr>
    <td><h5>Scheme :</h5><select style="width:300px;" class="form-control-sm" id="ddlSchDesc" onChange="ChangeAmount()" placeholder="Select Scheme Name.<br />Click on drop down" name="ddlSchDesc">
      <option>Select Scheme</option>
      <?php
        $str_query = "select * from tblgroup where groupfor = 'MasterDealer' or groupfor = 'ALL'";
    $resultScheme = $this->db->query($str_query);   
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


</div> <!-- card body-->                           
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
    
  </body>
</html>