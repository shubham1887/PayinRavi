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
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  </head>

  <body>

   <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/apisidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/apiheader.php"); ?><!-- br-header -->
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

      <div class="br-pagebody pd-x-20 pd-sm-x-30">
        <div class="row no-gutters widget-1 shadow-base">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title">Today's Sale</h6>
                <a href=""><i class="icon ion-android-more-horizontal"></i></a>
              </div><!-- card-header -->
              <div class="card-body">
                <span id="spark1"></span>
                <span id="spark1_totalsale"></span>
              </div><!-- card-body -->
              <div class="card-footer">
                <div>
                  <span class="tx-11">Gross Sales</span>
                  <h6 id="spark1_totalsale2" class="tx-success">0</h6>
                </div>
                <div>
                  <span  class="tx-11">No. of Items</span>
                  <h6 id="spark1_totalcount" class="tx-inverse"></h6>
                </div>
                <div>
                  <span class="tx-11">Txn. Charge</span>
                  <h6 id="spark1_totalcharge" class="tx-warning"></h6>
                </div>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-3 -->
         

          <!-- col-3 -->
        </div><!-- row -->

       

        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-3">
            <div class="bg-success rounded overflow-hidden">
              <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                <i class="ion ion-earth tx-60 lh-0 tx-white-8"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Total Success</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="cardsuccess"></p>
                  <span class="tx-11 tx-roboto tx-white-8"></span>
                </div>
              </div>
              <div id="ch1" class="ht-50 tr-y-1"></div>
            </div>
          </div><!-- col-3 -->
          <div class="col-sm-6 col-lg-3 mg-t-20 mg-sm-t-0">
            <div class="bg-warning rounded overflow-hidden">
              <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                <i class="ion ion-bag tx-60 lh-0 tx-white-8"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Total Pending</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"id="cardpending" ></p>
                  <span class="tx-11 tx-roboto tx-white-8"></span>
                </div>
              </div>
              <div id="ch3" class="ht-50 tr-y-1"></div>
            </div>
          </div><!-- col-3 -->
          <div class="col-sm-6 col-lg-3 mg-t-20 mg-lg-t-0">
            <div class="bg-danger rounded overflow-hidden">
              <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                <i class="ion ion-monitor tx-60 lh-0 tx-white-8"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Total Failure</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="cardfailure"></p>
                  <span class="tx-11 tx-roboto tx-white-8"></span>
                </div>
              </div>
              <div id="ch2" class="ht-50 tr-y-1"></div>
            </div>
          </div><!-- col-3 -->
          <div class="col-sm-6 col-lg-3 mg-t-20 mg-lg-t-0">
            <div class="bg-primary rounded overflow-hidden">
              <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                <i class="ion ion-clock tx-60 lh-0 tx-white-8"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Balance</p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="cardbalance"></p>
                  <span class="tx-11 tx-roboto tx-white-8"></span>
                </div>
              </div>
              <div id="ch4" class="ht-50 tr-y-1"></div>
            </div>
          </div><!-- col-3 -->
        </div><!-- row -->

        <!-- row -->

        <div class="row row-sm mg-t-20">
          <div class="col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent pd-20">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Last Transaction History</h6>
              </div><!-- card-header -->
              <div id="divlasttxns">
              </div>
              <div class="card-footer tx-12 pd-y-15 bg-transparent">
                <a href="<?php echo base_url()."API/Dmr_report?crypt=".$this->Common_methods->getAgentBalance($this->session->userdata("ApiId")); ?>"><i class="fa fa-angle-down mg-r-5"></i>View All Transaction History</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <!-- col-6 -->
        </div><!-- row -->

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
          <span class="tx-uppercase mg-r-10">Share:</span>
          <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-facebook tx-20"></i></a>
          <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Bracket%20Plus,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-twitter tx-20"></i></a>
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
		gethourlysale();
		getrechargesummary();
		getlasttransactions();
		
		//get_operatorpendings();
		//get_operatorrouting();
  		//get_Anshbalance();
	  	//get_M2mbalance();
		//get_Maharshibalance();
		//get_Dmrbalance();
		//get_DMRValues();
	
		//get_SuccessRecharge();
	  	//window.setInterval(get_load, 60000 * 10);
		window.setInterval(gethourlysale, 20000);	
		window.setInterval(getlasttransactions, 40000);	
		window.setInterval(getrechargesummary, 40000);	
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
