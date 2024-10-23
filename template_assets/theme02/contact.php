<?php include('header.php');?>
<!--======= SUB BANNER =========-->
  <section class="sub-banner">
    <div class="container">
      <div class="position-center-center">
        <h2>Contact</h2>
        <ul class="breadcrumb">
          <li><a href="http://www.rechargeunlimited.com/">Home</a></li>
          <li>Contact</li>
        </ul>
      </div>
    </div>
  </section>
<div id="content">
	<section class="contact-us light-gray-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
            		<div id="map"></div>
          		</div>
          		<div class="col-md-6">
            		<h3 class="font-alegreya margin-top-10">Get In Touch With Us</h3>
					<div class="contact-info">
						<div class="col-md-12">
						 	<h4><i class="fa fa-map-marker"></i> &nbsp;Visit Us</h4>
							<p>Shreeji Sales, 1, saundary apt.,<br> surdhara circe, thaltej,<br> Ahmedabad, Gujarat.</p>
						</div>
						<div class="col-md-6">
							<h5> <i class="fa fa-phone"></i> &nbsp;Call Us</h5>
							<p>(91) <strong>079-40052173</strong></p>
							<p>(91) <strong>917-388-7395</strong></p>
						</div>
						<div class="col-md-6">
							<h5> <i class="fa fa-phone"></i> &nbsp;Working Hours</h5>
							<p>Mon - Sat : 9:00 AM - 9:00 PM</p>
							<p>&nbsp;</p>
						</div>
						<div class="col-md-6">
							<h5> <i class="fa fa-envelope"></i> &nbsp;Email Us</h5>
							<p><a href="mailto:info@rechargeunlimited.com">info@rechargeunlimited.com</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>	
  </div>
  <!-- End Content -->
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script> 
<script type="text/javascript">
var map;
function initialize_map() {
	if ($('#map').length) {
  		var myLatLng = new google.maps.LatLng(17.3807064, 78.557296);
		var mapOptions = {
			zoom: 14,
			center: myLatLng,
			scrollwheel: false,
			panControl: false,
			zoomControl: true,
			scaleControl: false,
			mapTypeControl: false,
			streetViewControl: false
		};
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			tittle: 'RechargeUnlimited',
			icon: 'images/map-pointer.png'
	
		});
	} else {
  		return false;
	}
}
google.maps.event.addDomListener(window, 'load', initialize_map);
</script>
<?php include('footer.php');?>
