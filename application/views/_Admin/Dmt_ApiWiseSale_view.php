<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>DMT API WISE REPORT</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
        
$(document).ready(function(){
    
    
   
    
 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
    

    function startexoprt()
{
        $('.DialogMask').show();
        
        var from = document.getElementById("txtFromDate").value;
        var to = document.getElementById("txtToDate").value;
       // var db = document.getElementById("ddldb").value;
        document.getElementById("hidfrm").value = from;
        document.getElementById("hidto").value = to;
      //  document.getElementById("hiddb").value = db;
        document.getElementById("frmexport").submit();
    $('.DialogMask').hide();
}
    </script>
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
          <span class="breadcrumb-item active">DMT API WISE REPORT</span>
          <a class="breadcrumb-item success" href="<?php echo base_url(); ?>_Admin/dmr_report"><b style="color: green">DMT REPORT</b></a>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        
        <div class="col-sm-6 col-lg-5">
          <h4>DMT API WISE REPORT</h4>
        </div>
        
        <div class="col-sm-6 col-lg-7" style="display: none;">
            
            
            <span class="breadcrumb-item active">
                <button class="btn btn-success btn-sm" type="button" style="font-size:14px;">Total Payment : <?php echo round($totaldebit,2); ?></button>
            </span>
              <span class="breadcrumb-item active">
                <button class="btn btn-danger btn-sm" type="button" style="font-size:14px;">Total Revert : <?php echo round($totalcredit,2); ?></button>
              </span>
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
                 <form action="<?php echo base_url()."_Admin/Dmt_ApiWiseSale" ?>" method="post" name="frmSearch" id="frmSearch">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                             <h5>From Date</h5>
                                            <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFromDate" name="txtFromDate" type="text" style="width:120px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>To Date</h5>
                                            <input class="form-control-sm" id="txtToDate" value="<?php echo $to; ?>" name="txtToDate" type="text" style="width:120px;cursor:pointer" readonly>
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary btn-sm">
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-sm" onClick="startexoprt()">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT API WISE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
              
                                <div class="table-responsive">
                                     <?php if($apis != false) {?>
 <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
    <tr>  
    <td>Dist Name</td>
    
    <td>Agent Name</td>
    <?php 
        $grandtotal = array();
        foreach($apis as $api_row)
        {
            $grandtotal[$api_row] = 0;

            ?>
            <td><?php echo $api_row;?></td>
        <?php }
    ?>
     <td>Total</td>
    </tr>
</thead>
    <?php 
    $i=0;

    //print_r($);exit;
    foreach($users as $users_row)  
    {
     $row_total=0; 
       // echo $users_row;exit;
    ?>
   
    <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
        <td><?php echo $user_array[$users_row]["distbusinessname"]; ?> - <?php echo $user_array[$users_row]["distmobile_no"]; ?> <br>[<?php echo $user_array[$users_row]["dist_UserType"]; ?>]</td>

        <td><?php echo $user_array[$users_row]["Name"]; ?> - <?php echo $user_array[$users_row]["UserName"]; ?>  <br>[<?php echo $user_array[$users_row]["UserType"]; ?>]</td>
        <?php foreach($apis as $api_row)
        {?>
            <td>
                <?php 
                if(isset($result_data[$api_row][$users_row]))
                {
                     $row_total += $result_data[$api_row][$users_row]["total"];
                     $grandtotal[$api_row] += $result_data[$api_row][$users_row]["total"];
                    echo $result_data[$api_row][$users_row]["total"]." ( ".$result_data[$api_row][$users_row]["count"]." ) ";
                }
                else
                {
                    echo 0;
                }
                
                ?>
            </td>

        <?php }
    ?>
    <td><?php echo $row_total; ?></td>
     </tr>
            
       
        
<?php } ?>

 <thead class="thead-colored thead-danger" >
 <tr>  
    
    <td>TOTAL</td>
    <td></td>
    <?php 
        $subtotal = 0;
        foreach($apis as $api_row)
        {
            $subtotal += $grandtotal[$api_row];
            ?>
            <td><?php echo $grandtotal[$api_row];?></td>
        <?php }
    ?>
     <td><?php echo  $subtotal; ?></td>
    </tr>
</thead>
</table> 
<?php } ?>
                                </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script language="javascript">
      
      function addremark(Id,payment_id)
      {
           
        document.getElementById('hidtblpayment_id').value = payment_id;
          document.getElementById('spanpaymentid').innerHTML = payment_id;
          document.getElementById('hidpaymentid').value = Id;
       $('#myremarkupdatemodel').modal({'show':true});   
      }
      
      
    function changestatus(val1,id)
    {
        
                $.ajax({
                url:'<?php echo base_url()."_Admin/account_report/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,
                cache:false,
                method:'POST',
                success:function(html)
                {
                    if(html == "cash")
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>     ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    else
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>   ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    
                }
                }); 
            
        
    }
</script>


<div class="modal fade" id="myremarkupdatemodel" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
             <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
              <h4 class="modal-title" id="modalmptitle"></h4>
              
            </div>
            <div class="modal-body">
                <form id="frmRemarkUpdate" action="" method="post">
                <table>
                    <tr>
                        <td>
                            <h5 style="color:#000">Payment Id : <span id="spanpaymentid"></span></h5>
                        </td>
                    </tr>
                    <tr>
                        
                             <td>
                                 <label>
                             Bank</label>
                            <select id="ddlbank" name="ddlbank" style="width:200px" class="form-control-sm">
                                <option value="SBI">SBI</option>
                                <option value="ICICI">ICICI</option>
                                <option value="MEHSANA">MEHSANA</option>
                                <option value="CREDIT">CREDIT</option>
                                <option value="CASH">CASH</option>
                                <option value="EXCHANGE">EXCHANGE</option>
                                <option value="WRONG">WRONG</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        
                        <td>
                            <input type="text" id="txtRemark" name="txtRemark" class="form-control" placeholder="Enter Admin Remark" style="width:400px;">
                        </td>
                        <td><input type="button" id="btbsubmitremark" value="Update" class="btn btn-success" onClick="actionupdateremark()"></td>
                    </tr>
                </table>    
                <input type="hidden" id="hidtblpayment_id" name="hidtblpayment_id">
                <input type="hidden" id="hidpaymentid" name="hidpaymentid">
                
                </form>
            </div>
            <div class="modal-footer">
             <span id="spanbtnclode" > <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
            </div>
          </div>
        </div>
    </div>
    <input type="hidden" id="hidremarkupdateurl" value="<?php echo base_url()."_Admin/account_report/updateadminremark" ?>">
<script language="javascript">
    function actionupdateremark()
        {
            $.ajax({
                url:document.getElementById("hidremarkupdateurl").value,
                cache:false,
                data:$('#frmRemarkUpdate').serialize(),
                method:'POST',
                success:function(data)
                {
                
                },
                error:function()
                {
                    
                },
                complete:function()
                {
                    $('#myremarkupdatemodel').modal('hide');
                }
                });
        }
</script>

<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/account_report/dataexport" ?>" method="get">
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
