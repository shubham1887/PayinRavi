<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>BILL PAYMENT REPORT</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
    
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
         document.getElementById("ddlstatus").value = '<?php echo $status; ?>';
         document.getElementById("ddlmode").value = '<?php echo $mode; ?>';
         
         
});
    
         
        
function startexoprt()
{
        $('.DialogMask').show();
        
        var from = document.getElementById("txtFrom").value;
        var to = document.getElementById("txtTo").value;
    var ddlstatus = document.getElementById("ddlstatus").value;
    var ddlmode = document.getElementById("ddlmode").value;


        document.getElementById("hidfrm").value = from;
        document.getElementById("hidto").value = to;

    document.getElementById("hidexpstatus").value = ddlstatus;
    document.getElementById("hidmode").value = ddlmode;

        document.getElementById("frmexport").submit();
    $('.DialogMask').hide();
}
    
    </script>
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
<script type="text/javascript">
    
    function ActionSubmit(value)
    {
        if(document.getElementById('action_'+value).selectedIndex != 0)
        {
            var isstatus;
            if(document.getElementById('action_'+value).value == "Success")
            {isstatus = 'Success';}
            else if(document.getElementById('action_'+value).value == "Failure")
            {isstatus='Failure';}
            else if(document.getElementById('action_'+value).value == "Pending")
            {isstatus='Pending';}
            
            if(confirm('Are you sure?\n you want to '+isstatus+' ....!!!')){
                var txnpwd = prompt("Please Enter Transaction Password");
                

        //alert(document.getElementById('action_'+value).value);

                document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
                document.getElementById('hidOprId').value= document.getElementById('txtOpeId'+value).value;
                
                
                document.getElementById('hidid').value= value;
                document.getElementById('hidTxnPwd').value= txnpwd;
                            
                document.getElementById('frmCallAction').submit();
                }
        }
    }
    
</script>
<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">BILL Excel Upload</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
       <div class="col-sm-6 col-lg-3">
          <h4>BILL Excel Upload</h4>
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
                  <div class="table-responsive">
                                    <form action="<?php echo base_url()."_Admin/Bill_upload" ?>" method="post" name="frmCallAction" id="frmCallAction" enctype="multipart/form-data">
                         
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                        <td style="padding-right:10px;">
                                             <label>Select File</label>
                                            
                                        <input type="file" name="file" size="20" />
                                        </td>
                                        

                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="upload" class="btn btn-primary">

                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>




        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Excel Format</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <div class="table-responsive">
                                   
                         
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-colored thead-primary">
                                                
                                    <tr>
                                        <td align="center">
                                             <label>A</label>
                                        </td>
                                        <td align="center">
                                             <label>B</label>
                                        </td>
                                        <td align="center">
                                             <label>C</label>
                                        </td>
                                        <td align="center">
                                             <label>D</label>
                                        </td>

                                    </tr>
                                    </thead>
                                    <tr>
                                        <td align="center">
                                             <b>Company Name</b>
                                        </td>
                                        <td align="center">
                                             <b>Service No</b>
                                        </td>
                                        <td align="center">
                                             <b>Amount</b>
                                        </td>
                                        <td align="center">
                                             <b>Operator Id</b>
                                        </td>

                                    </tr>
                                    </table>
                                        
                                       
                                   
                                </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        
      </div><!-- br-pagebody -->
       <form action="<?php echo base_url()."_Admin/bill_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidOprId" name="hidOprId" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
<input type="hidden" id="hidTxnPwd" name="hidTxnPwd">
<input type="hidden" id="hidCustName" name="hidCustName">
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
