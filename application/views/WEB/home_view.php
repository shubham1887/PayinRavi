<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Dashboard Cards | Bracket Plus Responsive Bootstrap 4 Admin Template</title>

    <!-- vendor css -->
    <link href="<?php echo base_url(); ?>lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bracket.css">
  </head>

  <body>

   <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/websidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/webheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">Bracket</a>
          <a class="breadcrumb-item" href="">Cards &amp; Widgets</a>
          <span class="breadcrumb-item active">Dashboard</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <i class="icon icon ion-ios-photos-outline"></i>
        <div>
          <h4>Dashboard Cards</h4>
          <p class="mg-b-0">Dashboard cards are used in an overview or summary of a project, for crm or form cms.</p>
        </div>
      </div><!-- d-flex -->

    

        <!-- row -->

        <div class="row row-sm mg-t-20">
          <div class="col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent pd-20">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Due Payments</h6>
              </div><!-- card-header -->
              <div id="divlasttxns">
              </div>
              <div class="card-footer tx-12 pd-y-15 bg-transparent">
                <table class="table table-bordered table-striped" style="color:#00000E">
                   <thead class="thead-colored thead-primary" style="font-size: 14px;" >
                  <tr>
                    <td>Id</td>
                    <td>DueDate</td>
                    <td>Type</td>
                    <td>Description</td>
                    <td>Status</td>
                    <td>Amount</td>
                    <td></td>
                  </tr>
                </thead>
                  <?php
                    foreach($duepayments->result() as $drw)
                    {?>
                        <tr>
                          <td><?php echo $drw->Id; ?></td>
                          <td><?php echo $drw->due_date; ?></td>
                          <td><?php echo $drw->charge_type; ?></td>
                          <td><?php echo $drw->description; ?></td>
                          <td><?php echo $drw->status; ?></td>
                          <td><?php echo $drw->amount; ?></td>

                          <td>
                               <?php  if($drw->status == "Pending")
                            {?>
                            <input type="button" id="btnpay" class="btn btn-success btn-sm" value="Pay" onclick="dopayment('<?php echo $drw->Id;  ?>')">
                          <?php } ?>
                          </td>
                        </tr>
                    <?php }

                   ?>
                </table>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <!-- col-6 -->
        </div><!-- row -->
        <form id="frmdopayment" name="frmdopayment" method="POST" action="<?php echo base_url()."WEB/Home/dopayment"; ?>">
          <input type="hidden" name="hidid" id="hidid">
        </form>
        <script language="javascript">
          function dopayment(id)
          {
              document.getElementById("hidid").value = id;
              document.getElementById("frmdopayment").submit();
          }
        </script>

        <div class="bg-gray-300 ht-100 d-flex align-items-center justify-content-center mg-t-20">
          <h6 class="tx-uppercase mg-b-0 tx-roboto tx-normal tx-spacing-2">More Coming Soon...</h6>
        </div>
      </div><!-- br-pagebody -->
      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2017. Bracket Plus. All Rights Reserved.</div>
          <div>Attentively and carefully made by ThemePixels.</div>
        </div>
        <div class="footer-right d-flex align-items-center">
         
        </div>
      </footer>
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
    	<script language="javascript">
		function getrechargesummary()
		{
			$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>API/Dashboard/getSummary',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var SUCCESS = jsonobj.SUCCESS;
						var PENDING = jsonobj.PENDING;
						var FAILURE = jsonobj.FAILURE;
						var BALANCE = jsonobj.BALANCE;
						
						document.getElementById("cardsuccess").innerHTML = SUCCESS;
						document.getElementById("cardpending").innerHTML = PENDING;
						document.getElementById("cardfailure").innerHTML = FAILURE;
						document.getElementById("cardbalance").innerHTML = BALANCE;
						
					}	
					});

		}
		function getlasttransactions()
		{
			$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>API/Dashboard/getLastTransactions',
					cache: false,
					success: function(html)
					{
						document.getElementById("divlasttxns").innerHTML = html;
						
										
					}	
			});
		}
		function gethourlysale()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>API/dashboard/getTodaysHourSale',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var hourlysale = jsonobj.hourlysale;
						var totalsale = jsonobj.totalsale;
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
						document.getElementById("spark1").innerHTML = hourlysale;
						document.getElementById("spark1_totalsale").innerHTML = totalsale;
						document.getElementById("spark1_totalsale2").innerHTML = totalsale;
						document.getElementById("spark1_totalcharge").innerHTML = totalcharge;
						
						document.getElementById("spark1_totalcount").innerHTML = totalcount;
						
						
					},
					complete:function()
					{
					
						$('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 25,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 24
  });
						//document.getElementById("sp"+tempapiname+"bal").style.display="block";
						//document.getElementById("spin"+tempapiname+"balload").style.display="none";
					}	});
		}
		
		
		
		
$(document).ready(function()
	{
	 // setTimeout(function(){window.location.reload(1);}, 50000);
		//get_load();
		//get_load2()
		//gethourlysale();
		//getrechargesummary();
		//getlasttransactions();
		
		//get_operatorpendings();
		//get_operatorrouting();
  		//get_Anshbalance();
	  	//get_M2mbalance();
		//get_Maharshibalance();
		//get_Dmrbalance();
		//get_DMRValues();
	
		//get_SuccessRecharge();
	  	//window.setInterval(get_load, 60000 * 10);
		// window.setInterval(gethourlysale, 20000);	
		// window.setInterval(getlasttransactions, 40000);	
		// window.setInterval(getrechargesummary, 40000);	
	//	window.setInterval(gethourlyRickshawGraph, 60000);	
		//window.setInterval(get_operatorrouting, 60000);	
		//window.setInterval(get_balance, 60000 * 10);
		//window.setInterval(get_Anshbalance, 60000);
		//window.setInterval(get_M2mbalance, 60000);
		//window.setInterval(get_Maharshibalance, 60000);
		//window.setInterval(get_SuccessRecharge, 60000);
	
		//window.setInterval(get_DMRValues, 60000);
	
	  
		setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
						   });
	</script>
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1199px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1199px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1200px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
  </body>
</html>
