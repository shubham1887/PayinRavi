<!DOCTYPE html>
<html>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>:Providing Financial Services To Every Corner Of India | Index</title>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--Favicon-->
    <link href="../assets2/images/Favicon/favicon502.png" rel="icon" />
    <!--Favicon End-->
    <script src="../mpayfiles/jquery.min.js"></script>
    <link href="../mpayfiles/RG-DEv.css" rel="stylesheet" />
    <!--sweet alert-->
    <script src="../js/Sweetalert/sweetalert.min.js"></script>
    <link href="../js/Sweetalert/sweetalert.css" rel="stylesheet" />
    <!--sweet alert End-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!--Font Style-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <!--Font Style End-->
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Font Awesome End-->
    <!-- Page plugins -->
    <link href="../mpayfiles/argon.min.css" rel="stylesheet" />
    <link href="../mpayfiles/Main1.css" rel="stylesheet" />
    <!--Color theme style-->
    <link href="../mpayfiles/Theme.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
</head>

<body>
	<h1 align="center">PG Response</h1>	

	<?php  
		 $secretkey = "51491cf0cf26081fdf422052d674204708f5fbaf";
		 $orderId = $_POST["orderId"];
		 $orderAmount = $_POST["orderAmount"];
		 $referenceId = $_POST["referenceId"];
		 $txStatus = $_POST["txStatus"];
		 $paymentMode = $_POST["paymentMode"];
		 $txMsg = $_POST["txMsg"];
		 $txTime = $_POST["txTime"];
		 $signature = $_POST["signature"];
		 $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
		 $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
		 $computedSignature = base64_encode($hash_hmac);
		 if ($signature == $computedSignature) {
	 ?>
	<div class="container"> 
	<div class="panel panel-success">
	  <div class="panel-heading">Signature Verification Successful</div>
	  <div class="panel-body">
	  	<!-- <div class="container"> -->
	 		<table class="table table-hover">
			    <tbody>
			      <tr>
			        <td>Order ID</td>
			        <td><?php echo $orderId; ?></td>
			      </tr>
			      <tr>
			        <td>Order Amount</td>
			        <td><?php echo $orderAmount; ?></td>
			      </tr>
			      <tr>
			        <td>Reference ID</td>
			        <td><?php echo $referenceId; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Status</td>
			        <td><?php echo $txStatus; ?></td>
			      </tr>
			      <tr>
			        <td>Payment Mode </td>
			        <td><?php echo $paymentMode; ?></td>
			      </tr>
			      <tr>
			        <td>Message</td>
			        <td><?php echo $txMsg; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Time</td>
			        <td><?php echo $txTime; ?></td>
			      </tr>
			    </tbody>
			</table>
		<!-- </div> -->

	   </div>
	</div>
	</div>
	 <?php   
	  	} else {
	 
	 ?>
	<div class="container"> 
	<div class="panel panel-danger">
	  <div class="panel-heading">Signature Verification failed</div>
	  <div class="panel-body">
	  	<!-- <div class="container"> -->
	 		<table class="table table-hover">
			    <tbody>
			      <tr>
			        <td>Order ID</td>
			        <td><?php echo $orderId; ?></td>
			      </tr>
			      <tr>
			        <td>Order Amount</td>
			        <td><?php echo $orderAmount; ?></td>
			      </tr>
			      <tr>
			        <td>Reference ID</td>
			        <td><?php echo $referenceId; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Status</td>
			        <td><?php echo $txStatus; ?></td>
			      </tr>
			      <tr>
			        <td>Payment Mode </td>
			        <td><?php echo $paymentMode; ?></td>
			      </tr>
			      <tr>
			        <td>Message</td>
			        <td><?php echo $txMsg; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Time</td>
			        <td><?php echo $txTime; ?></td>
			      </tr>
			    </tbody>
			</table>
		<!-- </div> -->
	  </div>	
	</div>	
	</div>
	
	<?php	
	 	}
	 ?>
<p id="demo"></p>

<script>
 setTimeout(function(){
            window.location.href = 'https://payin.live/Retailer/Pg_Report';
         }, 10);
      </script>
      <center><h1>Web page redirects after 2 seconds.</h1></center>
</body>
</html>



