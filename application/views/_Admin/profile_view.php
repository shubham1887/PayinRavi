<!DOCTYPE html>

<html lang="en">

  <head>

 


   <title>PROFILE</title>



    

     

    

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

          <span class="breadcrumb-item active">PROFILE</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>PROFILE</h4>

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
<?php

//print_r($dataprofile->result());exit;
?>
                  <table class="table table-bordered" style="font-size:14px;color:#000000;font-family:sans-serif">

     <tr>

     <td>

     	 <h2><?php echo $type; ?> Detail</h2>

     	<table>

<tr>

<td ><?php echo $type; ?> No# :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->mobile_no;?></td>

</tr>

<tr>

<td >Password :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->password;?></td>

</tr>

<tr>

<td >Transaction Password :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->txn_password;?></td>

</tr>

<tr>

<td ><?php echo $type; ?> Name :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->businessname;?></td>

</tr>

<tr>

<td >Parent Name :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->parent_name;?></td>

</tr>

<tr>

<td >PAN Number :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->pan_no;?></td>

</tr>

<tr>

<td >Email :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->emailid;?></td>

</tr>

<tr>

<td >Mobile No :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->mobile_no;?></td>

</tr>

<tr>

<td >Landline numbher :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->landline;?></td>

</tr>

</table>

     </td>

     <td>

     	<table >

        <tr>

<td >Scheme Name :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->group_name;?></td>

</tr>

        <tr>

<td >Joining Date :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->add_date;?></td>

</tr>

        <tr>

<td >Contact Person :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->contact_person;?></td>

</tr>

<tr>

<td >Address :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->postal_address;?></td>

</tr>

<tr>

<td >City :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->city_name;?></td>

</tr>

<tr>

<td >State :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->state_name;?></td>

</tr>

<tr>

<td >Pincode :</td>

<td width="10"> </td>

<td><?php echo $dataprofile->row(0)->pincode;?></td>

</tr>

</table>

     </td>

     </tr>

     </table>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	

      </div><!-- br-pagebody -->

      <script language="javascript">

	function changestatus(val1,id)

	{

		

				$.ajax({

				url:'<?php echo base_url()."_Admin/account_report2/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,

				cache:false,

				method:'POST',

				success:function(html)

				{

					if(html == "cash")

					{

						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>  	';

						document.getElementById("ptype"+id).innerHTML = str;		

					}

					else

					{

						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>  	';

						document.getElementById("ptype"+id).innerHTML = str;		

					}

					

				}

				}); 

			

		

	}

</script>

<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/account_report2/dataexport" ?>" method="get">

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

