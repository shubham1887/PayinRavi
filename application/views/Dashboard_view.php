<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="https://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="https://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="https://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="https://themepixels.me/bracketplus/img/bracketplus-social.png">
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
    <script language="javascript">
        	function wait(ms)
        	{
           var start = new Date().getTime();
           var end = start;
           while(end < start + ms) {
             end = new Date().getTime();
          }
        }
		function get_balance()
		{
		
		    var apistr = document.getElementById("hidbalanceapis").value;
		    var apiarr = apistr.split(",");
		   
		    for(var i=0;i<apiarr.length-1;i++)
		    {
		        var tempapiname = apiarr[i];
				$("#sp"+tempapiname+"bal").html("....");
		        apicall(tempapiname);
			}	
			
		}
		function apicall(tempapiname)
		{
		       // document.getElementById("spin"+tempapiname+"balload").style.display="block";
			    //document.getElementById("sp"+tempapiname+"bal").style.display="none";
		        $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getAllBalance?api_name='+tempapiname,
				cache: false,
				success: function(html)
				{
					var data = html.split("^-^");
					$("#sp"+tempapiname+"bal").html(data[0]);
					$("#sp"+tempapiname+"pendingcount").html(data[1]);
					$("#sp"+tempapiname+"pendingamount").html(data[2]);
				},
				complete:function()
				{
					//document.getElementById("sp"+tempapiname+"bal").style.display="block";
					//document.getElementById("spin"+tempapiname+"balload").style.display="none";
				}	});
		}
		function get_load()
		  {
			 
			  $.ajax
			  ({
			          type: "GET",
			          url: '<?php echo base_url(); ?>_Admin/dashboard/getLoad',
			          cache: false,
			          success: function(html)
			          {
			              document.getElementById("userbalancediv").innerHTML = html;
                      }
			      
			  });
		      
		  }	
		  function get_load2()
		  {
			 
			  $.ajax
			  ({
			          type: "GET",
			          url: '<?php echo base_url(); ?>_Admin/dashboard/getLoad2',
			          cache: false,
			          success: function(html)
			          {
			              document.getElementById("userbalancediv2").innerHTML = html;
                      }
			      
			  });
		      
		  }	
		
			
	function get_operatorpendings()
	{
		document.getElementById("operatorwisepending").innerHTML = "";
	$.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getOperatorPendings',
				cache: false,
				success: function(html)
				{
					document.getElementById("operatorwisepending").innerHTML = html;
				},
				complete:function()
				{
					//document.getElementById("sp"+tempapiname+"bal").style.display="block";
					//document.getElementById("spin"+tempapiname+"balload").style.display="none";
				}	});
	}
	function get_newUsers()
	{
	   
	        document.getElementById("newusers").innerHTML = "";
	        $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getNewUsers',
				cache: false,
				success: function(html)
				{
					document.getElementById("newusers").innerHTML = html;
				},
				complete:function()
				{
					//document.getElementById("sp"+tempapiname+"bal").style.display="block";
					//document.getElementById("spin"+tempapiname+"balload").style.display="none";
				}	});
	}
	function get_operatorrouting()
	{
	
		document.getElementById("operatorwiserouting").innerHTML = "";
		$.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getapirouting',
				cache: false,
				success: function(html)
				{
					document.getElementById("operatorwiserouting").innerHTML = html;
				},
				complete:function()
				{
					//document.getElementById("sp"+tempapiname+"bal").style.display="block";
					//document.getElementById("spin"+tempapiname+"balload").style.display="none";
				}	});
	
	}
		
		
		function get_SuccessRecharge()
		{
			 $("#valsuccess").html("");
			 $("#valfailure").html("");
			 $("#valpending").html("");
			 //document.getElementById("spinsuccess").style.display="block";
			 //document.getElementById("iconsuccess").style.display="none";
			 //document.getElementById("spinfailure").style.display="block";
			 //document.getElementById("iconfailure").style.display="none";
			 //document.getElementById("spinpending").style.display="block";
			 //document.getElementById("iconpending").style.display="none";
			 $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getTotalSuccessRecahrge',
				cache: false,
				success: function(html)
				{
				    
				       
					var jsonobj = JSON.parse(html);
					var Success = jsonobj.Success;
					var Failure = jsonobj.Failure;
					var Pending = jsonobj.Pending;
					
					var Success_count = jsonobj.Success_Count;
					var Failure_count = jsonobj.Failure_Count;
					var Pending_count = jsonobj.Pending_Count;
					
					
				
					
					$("#valsuccess").html(Success);
					$("#valfailure").html(Failure);
					$("#valpending").html(Pending);
					
					$("#valsuccess_count").html(Success_count);
					$("#valfailure_count").html(Failure_count);
					$("#valpending_count").html(Pending_count);
					
				},
				complete:function()
				{
					//document.getElementById("iconsuccess").style.display="block";
					//document.getElementById("spinsuccess").style.display="none";
					//document.getElementById("iconfailure").style.display="block";
					//document.getElementById("spinfailure").style.display="none";
					//document.getElementById("iconpending").style.display="block";
					//document.getElementById("spinpending").style.display="none";
				}
			});
			
		}	
		
		
		function get_YesterdaySuccessRecharge()
		{
			 $("#valyesterdaysuccess").html("");
			 //$("#valfailure").html("");
			// $("#valpending").html("");
			 //document.getElementById("spinsuccess").style.display="block";
			 //document.getElementById("iconsuccess").style.display="none";
			 //document.getElementById("spinfailure").style.display="block";
			 //document.getElementById("iconfailure").style.display="none";
			 //document.getElementById("spinpending").style.display="block";
			 //document.getElementById("iconpending").style.display="none";
			 $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getYesterdayTotalSuccessRecahrge',
				cache: false,
				success: function(html)
				{
				    
				       
					var jsonobj = JSON.parse(html);
					var Success = jsonobj.Success;
					var Failure = jsonobj.Failure;
					var Pending = jsonobj.Pending;
					
					var Success_count = jsonobj.Success_Count;
					var Failure_count = jsonobj.Failure_Count;
					var Pending_count = jsonobj.Pending_Count;
					
					
				
					
					$("#valyesterdaysuccess").html(Success);
				//	$("#valfailure").html(Failure);
				//	$("#valpending").html(Pending);
					
					$("#valyesterdaysuccess_count").html(Success_count);
				//	$("#valfailure_count").html(Failure_count);
				//	$("#valpending_count").html(Pending_count);
					
				},
				complete:function()
				{
					//document.getElementById("iconsuccess").style.display="block";
					//document.getElementById("spinsuccess").style.display="none";
					//document.getElementById("iconfailure").style.display="block";
					//document.getElementById("spinfailure").style.display="none";
					//document.getElementById("iconpending").style.display="block";
					//document.getElementById("spinpending").style.display="none";
				}
			});
			
		}	
		
		function get_DMRValues()
		{
			 $("#valdmrsuccess").html("");
			 $("#valdmrfailure").html("");
			 $("#valdmrpending").html("");
			
			 $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getTotalDMRValues',
				cache: false,
				success: function(html)
				{
					var jsonobj = JSON.parse(html);
					var Success = jsonobj.Success;
					var Failure = jsonobj.Failure;
					var Pending = jsonobj.Pending;
					
					
					var SuccessCount = jsonobj.Success_Count;
					var FailureCount = jsonobj.Failure_Count;
					var PendingCount = jsonobj.Pending_Count;
					
					$("#valdmrsuccess").html(Success);
					$("#valdmrfailure").html(Failure);
					$("#valdmrpending").html(Pending);
					$("#valdmrsuccessCount").html(SuccessCount);
					$("#valdmrfailureCount").html(FailureCount);
					$("#valdmrpendingCount").html(PendingCount);
				},
				complete:function()
				{
				
				}
			});
			
		}	
	</script>
	<style>
    .pretty-table
{
  padding: 0;
  margin: 0;
  border-collapse: collapse;
  border: 1px solid #333;
  font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
  font-size: 0.9em;
  background: #bcd0e4 url("widget-table-bg.jpg") top left repeat-x;
}

.pretty-table caption
{
  caption-side: bottom;
  font-size: 0.9em;
  font-style: italic;
  text-align: right;
  padding: 0.5em 0;
}

.pretty-table th, .pretty-table td
{
  border: 1px dotted #666;
  padding: 0.5em;
  text-align: left;
  color: #632a39;
}

.pretty-table th[scope=col]
{
  
  background-color: #8fadcc;
  text-transform: uppercase;
  font-size: 0.9em;
  border-bottom: 2px solid #333;
  border-right: 2px solid #333;
}

.pretty-table th+th[scope=col]
{
  
  background-color: #7d98b3;
  border-right: 1px dotted #666;
}

.pretty-table th[scope=row]
{
  background-color: #b8cfe5;
  border-right: 2px solid #333;
}

.pretty-table tr.alt th, .pretty-table tr.alt td
{
  color: #2a4763;
}

.pretty-table tr:hover th[scope=row], .pretty-table tr:hover td
{
  /*background-color: #632a2a;*/
}
.error
{
    background-color: #63Fa2a;
}
.borderless td, .borderless th {
    border: 1px thin;
    
}


.table th, .table td {
    padding: 0.45rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
</style>
  </head>

  <body>

   <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
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
      <div class="br-pagetitle" style="display:none">
        <i class="icon icon ion-ios-photos-outline"></i>
        <div>
          <h4>Dashboard </h4>
          
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody pd-x-20 pd-sm-x-30">
          



      	 <div id="duepayments">
                                    
                                </div>













          
          
          
           <div class="row row-sm mg-t-20">
          <div class="col-lg-5">
            <div class="widget-2">
              <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                  <h6 class="card-title">Summary</h6>
                  
                                    <a style="padding-left:50px;" href="javascript:void(0)" onClick="load_summary()"><i class="fas fa-sync"></i></a>
                 
                </div><!-- card-header -->
                
                <div class="card-body pd-0">
                   <div class="card-body" >
                                <div class="d-flex no-block">
                                    
                                </div>
                                <!--<h6 class="card-subtitle">March  2017</h6>-->
                                <div class="table-responsive">
                                    
                                     <table class="table  borderless" style="background-color:#7d98b3;color:#000000">
                                            <tr>
                                                <td  class="btn-default" align="center"></td>
                                                <td class="btn-success" align="center">Success</td>
                                                <td class="btn-primary" align="center">Pending</td>
                                                <td class="btn-danger" align="center">Failure</td>
                                            </tr>
                                            <tr>
                                                <td  class="btn-default" align="center">Today Recharge</td>
                                                <td  align="center" class="btn-success"><a  style="color:#FFF" href="<?php echo base_url()."_Admin/list_recharge/filter?date=today&status=Success"; ?>"><b><span id="valsuccess"></span></b></a></td>
                                                <td class="btn-primary" align="center"><a style="color:#FFF"  href="<?php echo base_url()."_Admin/list_recharge/filter?date=today&status=Pending"; ?>"><b><span id="valpending"></span></b></a></td>
                                                <td class="btn-danger" align="center"><a style="color:#FFF"  href="<?php echo base_url()."_Admin/list_recharge/filter?date=today&status=Failure"; ?>"><b><span id="valfailure"></span></b></a></td>
                                            </tr>
                                            <tr>
                                                <td  class="btn-default" align="center">Average Daily Recharge</td>
                                                <td class="btn-success" align="center"><b><span id="val_avgdaily_success"></span></b></td>
                                                <td class="btn-primary" align="center"><b><span id="val_avgdaily_pending"></span></b></td>
                                                <td class="btn-danger" align="center"><b><span id="val_avgdaily_failure"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td  class="btn-default" align="center">Yesterday Recharge</td>
                                                <td class="btn-success" align="center"><b><span id="valydaysuccess"></span></b></td>
                                                <td class="btn-primary" align="center"><b><span id="valydaypending"></span></b></td>
                                                <td class="btn-danger" align="center"><b><span id="valydayfailure"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td  class="btn-default" align="center">Last Month Recharge</td>
                                                <td class="btn-success" align="center"><b><span id="val_lastmonth_success"></span></b></td>
                                                <td class="btn-primary" align="center"><b><span id="val_lastmonth_pending"></span></b></td>
                                                <td class="btn-danger" align="center"><b><span id="val_lastmonth_failure"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td class="btn-default"  align="center" style="font-size:14;color:#000000;">Today DMT</td>
                                                <td class="btn-success" align="center"><b><span id="valdmrsuccess"></span></b></td>
                                                <td class="btn-primary" align="center"><b><span id="valdmrpending"></span></b></td>
                                                <td class="btn-danger" align="center"><b><span id="valdmrfailure"></span></b></td>
                                            </tr>
                                    </table>
                                    
                                    <table class="table color-table success-table">
                                      
                                        <tbody>
                                            
                                            <tr>
                                                <td><b>Yesterday Success Recharge</b></td><td><b><span id="valyesterdaysuccess"></span></b> | <b><span id="valyesterdaysuccess_count"></b></td>
                                            </tr>
                                            
                                            <tr>
                                                <td><b>Average Daily Recharge</b></td><td><b><span id="avg_daily_recharge"></span></b> | <b><span id="avg_daily_recharge_count"></b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Last Month Success Recharge</b></td><td><b><span id="last_month_success_recharge"></span></b> </td>
                                            </tr>
                                            
                                           
                                            <tr>
                                                <td><b>Payment Request Pending</b></td><td><b><span id="pending_payment_request"></span></b>   </td>
                                            </tr>
                                            <tr>
                                                <td><b>Complain Pending</b></td><td><b><span id="pending_complains"></span></b>   </td>
                                            </tr>
                                            
                                          
                                            
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- widget-2 -->
          </div><!-- col-6 1 -->
          <div class="col-lg-6">
            <div class="widget-2">
              <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                  <h6 class="card-title">API BALANCE</h6>
                  
                                    <a style="padding-left:50px;" href="javascript:void(0)" onClick="get_balance()"><i class="fas fa-sync"></i></a>
                 
                </div><!-- card-header -->
                
                <div class="card-body pd-0">
                   <div class="card-body">
                                <div class="d-flex no-block">
                                    
                                </div>
                                <!--<h6 class="card-subtitle">March  2017</h6>-->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td align="center">API Name</td>
                                                <td  align="center">Balance</td>
                                                <td align="center">Pending</td>
                                                <td align="center">Amount</td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
                                $apique = "";
                                $apirsltview = $this->db->query("select a.Id,a.api_name from api_configuration a  where a.enable_balance_check = 'yes'");
                                foreach($apirsltview->result() as $rwapirow)
                                {
                                    $apique.=$rwapirow->api_name.",";
                                ?>
                                
                                
                                	<tr>
                                            <td align="center">
                                                <h6><a href="javascript:void(0)" class="link"><?php echo $rwapirow->api_name; ?></a></h6>
                                                <!--<small class="text-muted">Product id : MI5457 </small>-->
                                                </td>
                                                
                                                <td align="center">
                                                <h5><span id="sp<?php echo $rwapirow->api_name; ?>bal" ></span></h5>
                                                </td>
                                                <td align="center">
                                                <h5><span id="sp<?php echo $rwapirow->api_name; ?>pendingcount" ></span></h5>
                                                </td>
                                                <td align="center">
                                                <h5><span id="sp<?php echo $rwapirow->api_name; ?>pendingamount" ></span></h5>
                                                </td>
                                                
                                                
                                        </tr>
                                <?php } 
                                ?>
                                
                            
                            <input type="hidden" id="hidbalanceapis" value="<?php echo $apique; ?>">
                                        
                                        
                                            
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- widget-2 -->
          </div><!-- col-6 1 -->
        </div><!-- row -->
          
          
          
          
  

        <div class="row row-sm mg-t-20">
          
          <div class="col-lg-5 mg-t-20 mg-lg-t-0">
            <div class="widget-2">
              <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                  <h4 class="card-title">System Load</h4>
                    <a style="padding-left:50px;" href="javascript:void(0)" onClick="get_operatorpendings()"><i class="fas fa-sync"></i></a>
                </div><!-- card-header -->
                
                <div class="card-body pd-0">
                    <!-- Column -->
                    <div id="userbalancediv">
                                    
                                </div>
                            
                   
                    <!-- Column -->
                  
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- widget-2 -->
          </div><!-- col-6 -->
          <div class="col-lg-5 mg-t-20 mg-lg-t-0">
            <div class="widget-2">
              <div class="card shadow-base overflow-hidden">
                <div class="card-header">
                  <h4 class="card-title">System Load 2</h4>
                    <a style="padding-left:50px" href="javascript:void(0)" onClick="get_load2()"><i class="fas fa-sync"></i></a>
                </div><!-- card-header -->
                
                <div class="card-body pd-0">
                    <!-- Column -->
                    <div id="userbalancediv2">
                                    
                                </div>
                            
                   
                    <!-- Column -->
                  
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- widget-2 -->
          </div><!-- col-6 -->
        </div><!-- row -->

       

        <div class="row row-sm mg-t-20">
          <div class="col-lg-4">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent pd-20">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Operator Wise Pending</h6>
              </div><!-- card-header -->
              <div id="operatorwisepending"></div>
              <div class="card-footer tx-12 pd-y-15 bg-transparent">
                <a href="<?php echo base_url()."_Admin/list_recharge" ?>"><i class="fa fa-angle-down mg-r-5"></i>View All Transaction History</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <div class="col-lg-8 mg-t-20 mg-lg-t-0">
            <div class="card shadow-base bd-0">
              <div class="card-header pd-20 bg-transparent">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">New Users</h6>
              </div><!-- card-header -->
              <div id="newusers"></div>
             
            </div><!-- card -->
          </div><!-- col-6 -->
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
    		function getduepayments()
	{
	   
	        document.getElementById("duepayments").innerHTML = "";
	        $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>_Admin/dashboard/getDuePayments',
				cache: false,
				success: function(html)
				{
					document.getElementById("duepayments").innerHTML = html;
				},
				complete:function()
				{
					//document.getElementById("sp"+tempapiname+"bal").style.display="block";
					//document.getElementById("spin"+tempapiname+"balload").style.display="none";
				}	});
	}
		function gethourlysale()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var hourlysale = jsonobj.hourlysale;
						var totalsale = jsonobj.totalsale;
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
						//document.getElementById("spark1").innerHTML = hourlysale;
					//	document.getElementById("spark1_totalsale").innerHTML = totalsale;
					//	document.getElementById("spark1_totalsale2").innerHTML = totalsale;
					//	document.getElementById("spark1_totalcharge").innerHTML = totalcharge;
						
						//document.getElementById("spark1_totalcount").innerHTML = totalcount;
					//	
						//sidebar
						document.getElementById("sidebargrosssuccess").innerHTML = totalsale;
						
						
						
					},
					complete:function()
					{
					
						$('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
						//document.getElementById("sp"+tempapiname+"bal").style.display="block";
						//document.getElementById("spin"+tempapiname+"balload").style.display="none";
					}	});
		}
		
		
		
		function getCurrentMOnth_average_recharge()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getCurrentMOnth_average_recharge',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
					
						document.getElementById("avg_daily_recharge").innerHTML = totalcharge;
						document.getElementById("avg_daily_recharge_count").innerHTML = totalcount;
						
						
						
					},
					complete:function()
					{
					    
					}	
		    });
		}
		
		function getLastMonthly_success_recharge()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getPreviousMonth_success_recharge',
					cache: false,
					success: function(html)
					{
				
						document.getElementById("last_month_success_recharge").innerHTML = html;
						
						
						
					},
					complete:function()
					{
					    
					}	
		    });
		}
		function getPendingPayment_request()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getpqyreq_count',
					cache: false,
					success: function(html)
					{
				
						document.getElementById("pending_payment_request").innerHTML = html;
						
						
						
					},
					complete:function()
					{
					    
					}	
		    });
		}
		
		
		function getPendingComplains()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getcomplain_count',
					cache: false,
					success: function(html)
					{
				
						document.getElementById("pending_complains").innerHTML = html;
						
						
						
					},
					complete:function()
					{
					    
					}	
		    });
		}
		
		function gethourlyRickshawGraph()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
					cache: false,
					success: function(html)
					{
						var jsonobj = JSON.parse(html);
						var hourlysale = jsonobj.hourlysale;
						var totalsale = jsonobj.totalsale;
						var totalcount = jsonobj.totalcount;
						var totalcharge = jsonobj.totalcharge;
						
						
						
						var arr = [];
						var t =hourlysale.split(",");
						var r2_graf_max = 0;
						for (var i = 0; i < t.length-1; i++) 
						{
								var temparr = {};
								temparr = {x:i,y:+t[i]};
								arr.push(temparr);
								if(+t[i] > r2_graf_max)	
								{
									r2_graf_max = +t[i];
								}
						}
						 
						
						
						console.log(Math.max(+t));
						var rs2 = new Rickshaw.Graph({
						element: document.querySelector('#rickshaw2'),
						renderer: 'area',
						max: r2_graf_max,
						series: [{
						  data: arr,
						  color: '#1CAF9A'
						}]
					  });
					  rs2.render();
						 // Responsive Mode
  new ResizeSensor($('.br-mainpanel'), function(){
    rs2.configure({
      width: $('#rickshaw2').width(),
      height: $('#rickshaw2').height()
    });
    rs2.render();
  });
						
						
					},
					complete:function()
					{
					
						$('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
						//document.getElementById("sp"+tempapiname+"bal").style.display="block";
						//document.getElementById("spin"+tempapiname+"balload").style.display="none";
					}	});
		}
		
		function load_summary()
		{
		    get_SuccessRecharge();
		    getCurrentMOnth_average_recharge();
		    getLastMonthly_success_recharge();
		    get_DMRValues();
		    getPendingComplains();
	        getPendingPayment_request();
	        get_YesterdaySuccessRecharge();
		}
		
$(document).ready(function()
	{
	 // setTimeout(function(){window.location.reload(1);}, 50000);
		get_load();
		getduepayments();
		get_load2();
		get_balance();
		gethourlysale();
		gethourlyRickshawGraph();
		get_SuccessRecharge();
		get_operatorpendings();
		getCurrentMOnth_average_recharge();
		getLastMonthly_success_recharge();
		get_newUsers();
		//get_operatorrouting();
  		get_Paytmbalance();
	  	//get_M2mbalance();
		//get_Maharshibalance();
		//get_Dmrbalance();
		get_DMRValues();
	get_admin_balance();
	getPendingComplains();
	getPendingPayment_request();
	get_YesterdaySuccessRecharge();
		//get_SuccessRecharge();
	  	window.setInterval(get_load, 60000 * 10);
		window.setInterval(gethourlysale, 60000 * 10);	
		window.setInterval(gethourlyRickshawGraph, 60000 * 10);	
		//window.setInterval(get_operatorrouting, 60000);	
		window.setInterval(get_balance, 60000 * 10);
		window.setInterval(get_Paytmbalance, 60000 * 10);
		//window.setInterval(get_M2mbalance, 60000);
		//window.setInterval(get_Maharshibalance, 60000);
		window.setInterval(get_SuccessRecharge, 60000 * 10);
		window.setInterval(getPendingPayment_request, 60000 * 10);
	    window.setInterval(getPendingComplains, 60000 * 10);
	
	    window.setInterval(getCurrentMOnth_average_recharge, 60000 * 10);
		window.setInterval(get_DMRValues, 60000 * 10);
	window.setInterval(getduepayments, 60000 * 10);
	  
		setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
						   });
						   
						   
						   
	function get_Paytmbalance(){$.ajax({type: "GET",url: '<?php echo base_url(); ?>/_Admin/Dashboard/getAllBalance?api_name=PAYTM',cache: false,success: function(html){$("#spanPAYTMbal").html(html);}});$("#spanPAYTMbal").fadeOut(1000);$("#spanPAYTMbal").fadeIn(2000);}	
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
