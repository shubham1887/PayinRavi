<!-- Footer -->
  	<footer>
    	<div class="container">
      		<div class="row">
        		<div class="col-md-6 padding-top-20">           
          		<!-- News Letter -->
          		<div class="news-letter">
            	<h6>News Letter</h6>
            	<form>
              		<input type="email" placeholder="Enter your email..." >
              		<button type="submit"><i class="fa fa-envelope-o"></i></button>
            	</form>
          		</div>
        		</div>
        
        		<!-- Folow Us -->
        		<div class="col-md-6 padding-top-20">
          			<div class="news-letter">
            			<h6>Follow us</h6>
						<ul class="social_icons pull-right margin-left-10 margin-top-10">
						  <li><a href="#."><i class="fa fa-facebook"></i></a></li>
						  <li><a href="#."><i class="fa fa-twitter"></i></a></li>
						  <li><a href="#."><i class="fa fa-google-plus"></i></a></li>
						  <li><a href="#."><i class="fa fa-linkedin"></i></a></li>
						</ul>
          			</div>
        		</div>
      		</div>
    	</div>
    
    	<!-- Footer Info -->
    	<div class="footer-info">
      		<div class="container">
        		<div class="row">
          			<div class="col-md-4"> 
					<img class="margin-bottom-10" src="images/logo-footer.png" alt="" >
            		<ul class="personal-info">
              			<li><i class="fa fa-map-marker"></i> <?php echo $data["OfficeAddress"]; ?></li>
              			<li><i class="fa fa-envelope"></i> <?php echo $data["EmailId"]; ?></li>
              			<li><i class="fa fa-phone"></i> <?php echo $data["CustomerCare"]; ?></li>
            		</ul>
          			</div>
          
          			<!-- Service provided -->
          			<div class="col-md-4">
            			<h6>Service provided</h6>
						<ul class="links">
						 	<li><a href="<?php echo base_url(); ?>">HOME</a></li>
							<li><a href="<?php echo base_url().$theme_path."/Aboutus"; ?>"> ABOUT </a></li>
							<li><a href="<?php echo base_url().$theme_path."/Service"; ?>"> SERVICES </a></li>
							<li><a href="<?php echo base_url().$theme_path."/Bank_detail"; ?>">BANK DETAILS</a></li>
							<li><a href="<?php echo base_url().$theme_path."/Downloads"; ?>"> DOWNLOADS </a></li>
							<li><a href="<?php echo base_url().$theme_path."/ContactUs"; ?>"> CONTACT</a></li>
							<li><a href="<?php echo base_url().$theme_path."/Registration"; ?>"> REGISTRATION</a></li>
							<li><a href="<?php echo base_url(); ?>login"> LOGIN</a></li>
						</ul>
          			</div>
          
          			<!-- Quote -->
          			<div class="col-md-4">
            			<h6>Quick Contact</h6>
            			<div class="quote">
              			<form>
                			<input class="form-control" type="text" placeholder="Name">
                			<input class="form-control" type="text" placeholder="Phone No">
                			<textarea class="form-control" placeholder="Messages"></textarea>
                			<button type="submit" class="btn btn-orange">SEND NOW</button>
              			</form>
            		</div>
          		</div>
        	</div>
      	</div>
    </div>
    
    <!-- Rights -->
    <div class="rights">
      <div class="container">
        <p>Copyright © 2014 <?php echo $data["company_name"]; ?>. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
</div>
<!-- JavaScripts -->
<script src="../../template_assets/theme02/js/bootstrap.min.js"></script> 
<script src="../../template_assets/theme02/js/jquery.sticky.js"></script> 
<!-- SLIDER REVOLUTION 4.x SCRIPTS  --> 
<script type="text/javascript" src="../../template_assets/theme02/js/jquery.themepunch.tools.min.js"></script> 
<script type="text/javascript" src="../../template_assets/theme02/js/jquery.themepunch.revolution.min.js"></script> 
<script src="../../template_assets/theme02/js/main.js"></script> 
</body>
</html>