<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>BILL PAYMENT REPORT</title>



    

     

    

    <?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   <style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
</style>
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <script>
        
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
    
     function startexoprt()
    {
            
            var from = document.getElementById("txtFrom").value;
            var to = document.getElementById("txtTo").value;
            
            document.getElementById("hidfrm").value = from;
            document.getElementById("hidto").value = to;
            
            document.getElementById("frmexport").submit();
        
    } 
      </script>
      <style>
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
    <style>
    .error
    {
        background-color: #ffdddd;
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

    

    <?php include("elements/sdsidebar.php"); ?><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->



    <!-- ########## START: HEAD PANEL ########## -->

    <?php include("elements/sdheader.php"); ?><!-- br-header -->

    <!-- ########## END: HEAD PANEL ########## -->



    <!-- ########## START: RIGHT PANEL ########## -->

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."SuperDealer/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">Reports</a>

          <span class="breadcrumb-item active">Bill Payment Report</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>BILL PAYMENT REPORT</h4>

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

                  <form action="<?php echo base_url()."SuperDealer/bill_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table cellspacing="10" cellpadding="3">
            <tr>
                <td>
                    <h5>From Date :</h5>
                    <input readonly type="text" name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control-sm datepicker" title="Select From Date." maxlength="10" style="cursor: pointer"  />
                </td>
                <td>
                    <h5>To Date :</h5>
                    <input readonly type="text" name="txtTo" id="txtTo" class="form-control-sm datepicker" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"  />
                </td>
                <td>
                    <h5>Status:</h5>
                    <select id="ddlstatus" name="ddlstatus" class="form-control-sm" style="">
                        <option value="ALL">ALL</option>
                        <option value="Success">SUCCESS</option>
                        <option value="Pending">PENDING</option>
                        <option value="Failure">FAILURE</option>
                    </select>
                </td>
                <td style="padding-top:30px;">
                    <h5></h5>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
                </td>
                <td style="padding-top:30px;">
                    <h5></h5>
                    <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-sm" onClick="startexoprt()">
                </td>
            </tr>
            </table>
           


</form>
       <form id="frmexport" name="frmexport" action="<?php echo base_url()."SuperDealer/bill_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    
                                    
                                    </form>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

        <div class="row row-sm mg-t-20">

          <div class="col-sm-12 col-lg-12">

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">BILL PAYMENT REPORT</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                 <?php
    if ($message != ''){echo "<div class='message'>".$message."</div>"; }
    if(isset($result_all))
    {
        if($result_all->num_rows() > 0)
        {
    ?>
    
    <div id="all_transaction">
<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
    <th>Sr No</th>
   <th>ID</th>
   <th>DateTime</th>
    <th>Agent</th> 
 
   <th>Operator</th>
    <th>ServiceNo</th>
        <th>Bill Amount</th>
    <th>Cust.Name</th>        
    <th>Cust.Mobile</th>
    <th>Debit Amount</th>       
    <th>Credit Amount</th>       
    <th>Status</th>        
    <th>OprId</th> 
    
            
    </tr>
    <?php   $total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result)    {  ?>
            <tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo ($i + 1); ?></td>
  <td><?php echo "<span id='db_ssid".$i."'>".$result->Id."</span>"; ?></td> 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->businessname."</span>"; ?></td>
  
 <td><?php echo "<span id='db_company".$i."'>".$result->company_name."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->service_no."</span>"; ?></td> 
                <td><?php echo "<span id='db_mobile".$i."'>".$result->bill_amount."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->customer_name."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->customer_mobile."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->debit_amount."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->credit_amount."</span>"; ?></td>
 
 <td>
  <?php 
 $opr_id = $result->opr_id;
 if($result->status == "PENDING" or $result->status == "Pending")
 {
  $opr_id = rand(1001564665,9999999999);
  echo "<span id='db_status".$i."' class='label label-success'>SUCCESS</span>";
 } ?>
  <?php if($result->status == "Success"){echo "<span id='db_status".$i."' class='label label-success'>".$result->status."</span>";} ?>
  <?php if($result->status == "Failure"){echo "<span id='db_status".$i."' class='label label-warning'>".$result->status."</span>";} ?>
  </td>
<td><?php echo "BBPS".$opr_id;?></span>"; 
      
    
</td>
 
 </tr>
        <?php
        if($result->status == "Success" or $result->status == "Pending"){
        $total_amount= $total_amount + $result->bill_amount;}
        $i++;} ?>
        
         <tr class="ColHeader">
    <th></th>
    <th></th>
    <th></th>
    
     
 
   
       <th></th>
    <th></th>
    <th>Successfull Transaction :</th>        
   <th><?php echo $total_amount; ?></th>        
    <th></th>
    <th></th>     <th></th>  
             <th></th>
    <th></th>          
    <th></th>
    
                
    </tr>        
        </table>
        </div>
       <?php
        }
       else{?>
           <div class='message'>Record Not Found.</div>
           <?php }
       
       }?> 
              </div><!-- card-body -->

            </div>

           

        </div>

        </div>

      </div><!-- br-pagebody -->

      
<input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."SuperDealer/getutils"; ?>">

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

