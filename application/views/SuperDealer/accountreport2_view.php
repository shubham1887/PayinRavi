<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>DMT WALLET REPORt</title>



    

     

    

    <?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>

        

$(document).ready(function(){

    

    

    document.getElementById("ddlpaymenttype").value = '<?php echo $ddlpaymenttype; ?>';

    document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';

    

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

        var db = document.getElementById("ddldb").value;

        document.getElementById("hidfrm").value = from;

        document.getElementById("hidto").value = to;

        document.getElementById("hiddb").value = db;

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

          <span class="breadcrumb-item active">DMT WALLET REPORT</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>DMT WALLET REPORT</h4>

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

                  <form action="<?php echo base_url()."SuperDealer/account_report2" ?>" method="post" name="frmCallAction" id="frmCallAction">

                           <input type="hidden" id="hidID" name="hidID">

                                    <table cellspacing="10" cellpadding="3">

                                    <tr>

                                    <td style="padding-right:10px;">

                                             <label>From Date</label>

                                            <input class="form-control" value="<?php echo $from_date; ?>" id="txtFromDate" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>

                                        <td style="padding-right:10px;">

                                             <label>To Date</label>

                                            <input class="form-control" value="<?php echo $to_date; ?>" id="txtToDate" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>

                                        <td style="padding-right:10px;">

                                             <label>Payment Type</label>

                                           <select id="ddlpaymenttype" name="ddlpaymenttype" class="form-control" style="width: 120px">

                                               <option value="ALL">ALL</option>

                                               <option value="credit">CREDIT</option>

                                               <option value="cash">CASH</option>

                                            </select>

                                        </td>

                                        <td style="padding-right:10px;">

                                             <label>Data</label>

                                           <select id="ddldb" name="ddldb" class="form-control" style="width: 120px">

                                               <option value="LIVE">LIVE</option>

                                               <option value="ARCHIVE">ARCHIVE</option>

                                            </select>

                                        </td>

                                        

                                        

                                        <td valign="bottom">

                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">

                                      <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">

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

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT WALLET REPORT</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                <table class="table table-bordered table-striped" style="color:#00000E">

              <thead class="thead-colored thead-primary" >

                <tr>

                    <th>Payment Date</th>

    <th >Payment Id</th>

    <th  >Payment To</th>

    <th>User type</th>

    <th>Transaction type</th>

     <th>Payment type</th>

    <th >Description</th>

    <th  >Remark</th>

    <th>Cr/Dr Amount</th>

    

    <th >Balance</th>

                        

                </tr>

              </thead>

              <tbody>

              <?php 

            $i = 0;

            foreach($result_mdealer->result() as $result)

            {

                if(($result->debit_amount > 0 and $result->transaction_type == 'PAYMENT') or ($result->credit_amount > 0))

                {   

          ?>

            <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">

<td><?php echo $result->add_date; ?></td>

 <td ><?php echo $result->payment_id; ?></td>

  <td><?php echo $result->businessname; ?></td>

  <td><?php echo $result->usertype_name; ?></td>

                

                

                

  <td ><?php echo $result->transaction_type; ?></td>

                

                

    <td id="ptype<?php echo $result->payment_id; ?>">

      <?php 

                if($result->payment_type == "cash")

                {?>

                    <a href="javascript:void(0)" onClick="changestatus('credit','<?php echo $result->payment_id; ?>')"><?php echo $result->payment_type; ?></a>     

                <?php }

                else

                {?>

                    <a href="javascript:void(0)" onClick="changestatus('cash','<?php echo $result->payment_id; ?>')"><?php echo $result->payment_type; ?></a>   

                <?php }

                

        ?>

    </td>           

   

 <td><?php echo $result->description; ?></td>

 <td ><?php echo $result->remark; ?></td>

 <td><?php if($result->credit_amount > 0){echo "-".$result->credit_amount;}else{echo $result->debit_amount;} ?></td>

 

  <td><?php echo $result->balance; ?></td>

 </tr>

        <?php   

        $i++;} } ?>

              </tbody>

            </table>

              </div><!-- card-body -->

            </div>

             <?php  echo $pagination; ?> 

        </div>

        </div>

      </div><!-- br-pagebody -->

      <script language="javascript">

    function changestatus(val1,id)

    {

        

                $.ajax({

                url:'<?php echo base_url()."SuperDealer/account_report2/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,

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

<form id="frmexport" name="frmexport" action="<?php echo base_url()."SuperDealer/account_report2/dataexport" ?>" method="get">

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

