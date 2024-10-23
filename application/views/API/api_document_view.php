<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API::API Document</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    

</head>

<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        <?php include("files/apiheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/apisidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">My Commission</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Recharge API
                            
                        </div>

                        <div class="panel-body">
                        	<h2>Recharge Url </h2>
                            <div>http://www.rechargeunlimited.com/api_users/recharge?userid=#UserID#&pin=#TXNPASSWORD#&circlecode=#circle#&operatorcode=#operator#&number=#Number#&amount=#Amount#&uniqueid=#uniqueid#</div>
                           <table style="width:600px;" class="table table-striped table-bordered bootstrap-datatable responsive" border="1">
                            <tr>
                                <td>userid</td>   
                                <td><b>provide by us</b></td>
                            </tr>
                            <tr>
                                <td>pin</td>   
                                <td><b>provide by us</b></td>
                            </tr>
                            <tr>
                                <td>circlecode</td>   
                                <td><b>pass 12</b></td>
                            </tr>
                             <tr>
                                <td>operatorcode</td>   
                                <td><b>Listed In Below Table</b></td>
                            </tr>
                            <tr>
                                <td>number </td>   
                                <td><b>Mobile/DTH Number</b></td>
                            </tr>
                             <tr>
                                <td>amount </td>   
                                <td><b>Recharge Amount</b></td>
                            </tr>
                            <tr>
                                <td>uniqueid </td>   
                                <td><b>Unique Id In Numeric</b></td>
                            </tr>
   
		</table>
                        </div>

                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>

</html>
