<!DOCTYPE html>
<html lang="en">
  <head>
        <title>Distributor Registration</title>
        <?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     


<script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
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


    </head>
    <body>
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
                                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Distributor Registration Form</h6>
                                            <span class="tx-12 tx-uppercase">
                                                
                                            
                                            </span>
                        </div><!-- card-header -->
                        <div class="card-body">
                        

                                <form method="post" action="<?php echo base_url()."SuperDealer/dist_registration"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off">  
                                    <table class="table table-bordered bordered table-responsive"> 
                                        <tbody> 
                                    <tr>  
                                    <td>    
                                        <h5>Dist Name :</h5>    
                                        <input type="text" class="form-control-sm" placeholder="Enter Dealer Name." id="txtDistname" name="txtDistname" value="<?php echo $regData['distributer_name']; ?>"  maxlength="100" style="width:300px;" />  
                                    </td> 
                                    <td>    
                                        <h5>Mobile No :</h5>    
                                        <input style="width:300px;" type="text" class="form-control-sm" onKeyPress="return isNumeric(event);" placeholder="Enter Mobile No.<br />e.g. 9898980000" id="txtMobNo" name="txtMobNo" maxlength="10"  value="<?php echo $regData['mobile_no']; ?>"/>
                                    </td> 
                                    </tr> 

                                    <tr>
                                        <td>
                                     <h5>Select Parent:</h5> 
                                     <select id="ddlparent" name="ddlparent" class="form-control-sm" style="width:300px;"> 
                                        <option value="1">Select</option> 
                                        <?php   
                                        $rlstparent = $this->db->query("select * from tblusers where usertype_name='MasterDealer' and host_id = ?",array($this->session->userdata("SdId")));    
                                        foreach($rlstparent->result() as $row)  
                                        {  ?>  
                                        <option value="<?php echo $row->user_id; ?>"><?php echo $row->businessname; ?></option>  
                                        <?php } ?> 
                                        </select>  
                                        </td>
                                        <td></td>
                                        <td></td>
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
                                        <h5>  Email :</h5>    
                                        <input style="width:300px;" type="text" class="form-control-sm" id="txtEmail" placeholder="Enter Email ID.<br />e.g some@gmail.com" name="txtEmail"  maxlength="300" value="<?php echo $regData['emailid']; ?>"/>   </td> </tr>  
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
                                            <?php           $str_query = "select * from tblgroup where groupfor = 'Distributor'";          
                                            $resultScheme = $this->db->query($str_query);               
                                            foreach($resultScheme->result() as $row)        
                                            {                 
                                                echo "<option value='".$row->Id."'>".$row->group_name."</option>";              
                                            }   ?>      
                                            </select>         
                                    </td>
                                    </tr>    





                                     <tr>   
                                        <td>        
                                                
                                            <h5>Downline Scheme For Retailer : </h5>             
                                            <select style="width:300px;" class="form-control-sm" id="ddlDownSchDesc"  name="ddlDownSchDesc">                    
                                                <option>Select Scheme</option>                  
                                                <?php               
                                                $str_query = "select Id,group_name from tblgroup where groupfor = 'Agent'";                   
                                                $resultScheme = $this->db->query($str_query);                           
                                                foreach($resultScheme->result() as $row)                        
                                                {                       
                                                    echo "<option value='".$row->Id."'>".$row->group_name."</option>";                      
                                                }?>                     
                                            </select>               
                                        </td>               
                                        <td>                
                                                     
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
</html>