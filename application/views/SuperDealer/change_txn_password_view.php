<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>TRANSACTION PASSWORD CHANGE</title>



    

     

    

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

});

    

    function startexoprt()

{

        $('.DialogMask').show();

        

        var from = document.getElementById("txtFrom").value;

        var to = document.getElementById("txtTo").value;

        document.getElementById("hidfrm").value = from;

        document.getElementById("hidto").value = to;

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

          <a class="breadcrumb-item" href="#">SuperDealer</a>

          <span class="breadcrumb-item active">TRANSACTION PASSWORD CHANGE</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>TRANSACTION PASSWORD CHANGE</h4>

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

                  <form action="<?php echo base_url()."Distributor/change_txnpassword" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                             <label>Old Transaction Password</label>
                                            <input class="form-control"  id="txtOldPassword" name="txtOldPassword" type="text" style="width:120px;" maxlength="6" placeholder="Old Txn Password">
                                        </td>
                                        <td style="padding-right:10px;">
                                             <label>New Transaction Password</label>
                                            <input class="form-control" id="txtNewPassword" name="txtNewPassword" maxlength="4" type="text" style="width:120px;" placeholder="New Txn Password">
                                        </td>
                                        <td style="padding-right:10px;">
                                             <label>Confirm Transaction Password :</label>
                                            <input class="form-control" id="txtCnfPassword"  name="txtCnfPassword" maxlength="4" type="text" style="width:120px;" placeholder="Confirm New Txn Password">
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        <button type="reset" class="btn btn-success">Reset Button</button>
                                        </td>
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

