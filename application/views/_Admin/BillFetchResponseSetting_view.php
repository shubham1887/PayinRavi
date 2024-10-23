<!DOCTYPE html>
<html lang="en">
  <head>
    

   <title>Bill Fetch Message Settings</title>

    
     
    
  <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
function SetEdit(value)
  {
    document.getElementById('txtCustomerNameStart').value=document.getElementById("customerNameStart_"+value).innerHTML;
    document.getElementById('txtCustomerNameEnd').value=document.getElementById("customerNameEnd_"+value).innerHTML;    
    document.getElementById('txtBillAmountStart').value=document.getElementById("BillAmountStart_"+value).innerHTML;
    document.getElementById('txtBillAmountEnd').value=document.getElementById("BillAmountEnd_"+value).innerHTML;    
    document.getElementById('txtDueDateStart').value=document.getElementById("DueDateStart_"+value).innerHTML;
    document.getElementById('txtDueDateEnd').value=document.getElementById("DueDateEnd_"+value).innerHTML;   
    
    document.getElementById('btnSubmit').value='Update';
    document.getElementById('hidID').value = value;
    document.getElementById('ddlapi').value=document.getElementById("api_id_"+value).value;
    
    //document.getElementById('myLabel').innerHTML = "Edit API";
  }
  function Confirmation(value)
  {
    var varName = document.getElementById("status_word_"+value).innerHTML;
    if(confirm("Are you sure?\nyou want to delete "+varName+" Settings.") == true)
    {
      document.getElementById('hidValue').value = value;
      document.getElementById('frmDelete').submit();
    }
  }
</script>
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
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
  border-bottom:: 1px solid #ddd;
  overflow:hidden;
}
</style>
  </head> 

  <body>
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
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">DEVELOPER OPTIONS</a>
          <span class="breadcrumb-item active">BILL FETCH Message Settings</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Message Settings</h4>
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
                  <form role="form" method="post" action="<?php echo base_url()."_Admin/BillFetchResponseSetting?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table class="table" style="font-size:14px;color:#000">
                                    <tr>
                    <td style="padding-right:10px;">
                                           <label>Select API</label>
                                            <select id="ddlapi" name="ddlapi" class="form-control-sm" style="width:120px">
                        <option value="0">Select</option>
                        
                      <?php
                        $rsltapi = $this->db->query("select * from api_configuration where is_bbps = 'yes' order by api_name");
                        foreach($rsltapi->result() as $rw)
                        {?>
                          <option value="<?php echo $rw->Id; ?>"><?php echo $rw->api_name; ?></option>
                        
                        <?php } ?>
                      </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                           <label>Customer Name Start</label>
                                            <input  class="form-control-sm"  id="txtCustomerNameStart" name="txtCustomerNameStart" type="text"  style="width:120px">
                                        </td>
                                        <td style="padding-right:10px;">
                                           <label>Customer Name End</label>
                                            <input  class="form-control-sm"  id="txtCustomerNameEnd" name="txtCustomerNameEnd" type="text"  style="width:120px">
                                        </td>


                                        <td style="padding-right:10px;">
                                           <label>Bill Amount Start</label>
                                            <input  class="form-control-sm"  id="txtBillAmountStart" name="txtBillAmountStart" type="text"  style="width:120px">
                                        </td>
                                        <td style="padding-right:10px;">
                                           <label>Bill Amount End</label>
                                            <input  class="form-control-sm"  id="txtBillAmountEnd" name="txtBillAmountEnd" type="text"  style="width:120px">
                                        </td>
                                        <td style="padding-right:10px;">
                                           <label>Due Date Start</label>
                                            <input  class="form-control-sm"  id="txtDueDateStart" name="txtDueDateStart" type="text"  style="width:120px">
                                        </td>
                                        <td style="padding-right:10px;">
                                           <label>Due Date End</label>
                                            <input  class="form-control-sm"  id="txtDueDateEnd" name="txtDueDateEnd" type="text"  style="width:120px">
                                        </td>
                                    
                                        <td valign="bottom">
                                        <h5>&nbsp;</h5>
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-sm">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                     <form action="<?php echo base_url()."_Admin/BillFetchResponseSetting?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="delete" />
</form>                 
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">TURNOVER REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                      <th>API</th>
                      
                                           
                                            <th>CustomerName Start</th>
                                            <th>CustomerName End</th>
                                            <th>BillAmount Start</th>
                                            <th>BillAmount End</th>
                                            
                                            <th>DueDate Start</th>
                                            <th>DueDate End</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1; foreach($data->result() as $row)
                   {?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->api_name; ?></td>
                      
                                           

                                            <td><span id="customerNameStart_<?php echo $row->Id; ?>"><?php echo $row->customerNameStart; ?></span></td>
                                            <td><span id="customerNameEnd_<?php echo $row->Id; ?>"><?php echo $row->customerNameEnd; ?></span></td>


                                            <td><span id="BillAmountStart_<?php echo $row->Id; ?>"><?php echo $row->customerNameStart; ?></span></td>
                                            <td><span id="BillAmountEnd_<?php echo $row->Id; ?>"><?php echo $row->customerNameEnd; ?></span></td>



                                            <td><span id="DueDateStart_<?php echo $row->Id; ?>"><?php echo $row->DueDateStart; ?></span></td>
                                            <td><span id="DueDateEnd_<?php echo $row->Id; ?>"><?php echo $row->DueDateEnd; ?></span></td>

                                           
                                           
                                             <td>
                                                  <input type="hidden" id="api_id_<?php echo $row->Id; ?>" value="<?php echo $row->api_id; ?>">
                                                 <input type="button" id="btndelete" value="Delete" onClick="Confirmation('<?php echo $row->Id; ?>')">
                                                  <input type="button" id="btnedit" value="Edit" onClick="SetEdit('<?php echo $row->Id; ?>')">
             
              
           
             
              </td>
                                        </tr>
                                   <?php $i++;} ?>  
                                    </tbody>
                                </table>
              </div><!-- card-body -->
            </div>
             
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
