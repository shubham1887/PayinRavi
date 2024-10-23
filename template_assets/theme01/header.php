	<header>
				<div class="wrapper">
				<img src="<?php echo base_url()."recharge_logo_web.png"; ?>" style="width:250px;">
				
                <div class="mainhead-right">
                  <div class="mainhead-right1">
                    <div class="headleft">
                      <div class="phone"><img style="margin-top:-8px;" src="../../template_assets/theme01/images/mail.png" />&nbsp;&nbsp;<a href="#" class="phn"><?php echo $data["EmailId"]; ?></a> </div>
                    </div>
                    <div class="headright">
                       <div class="buttonc"><a href="<?php echo base_url(); ?>login">SIGN IN</a></div>
                    </div>
                  <div class="clr"></div></div>
                  <nav>
                    <ul class="sf-menu sf-js-enabled sf-shadow">
                    
                    <?php
                    $Home_class = "";
                    $Aboutus_class = "";
                    $service_class = "";
                    $download_class = "";
                    $contactus_class = "";
                    if($this->uri->segment(3) == "Home")
                    {$Home_class = "active"; }
                    if($this->uri->segment(3) == "Aboutus")
                    {$Aboutus_class = "active"; }
                    if($this->uri->segment(3) == "Service")
                    {$service_class = "active"; }
                    if($this->uri->segment(3) == "Downloads")
                    {$download_class = "active"; }
                    if($this->uri->segment(3) == "ContactUs")
                    {$contactus_class = "active"; }
                    
                    ?>
                        
                        
                      <li><a href="<?php echo base_url()."Home"; ?>" id="ctl00_lnkHome" class="<?php echo $Home_class; ?>">Home</a></li>
                      <li><a href="<?php echo base_url()."Aboutus"; ?>" id="ctl00_lnkAbout" class="<?php echo $Aboutus_class; ?>">About Us</a></li>
                      <li><a href="<?php echo base_url()."Service"; ?>" id="ctl00_lnkService" class="<?php echo $service_class; ?>">Services</a></li>
                      <li><a href="<?php echo base_url()."Downloads"; ?>" id="ctl00_lnkDownload" class="<?php echo $download_class; ?>">Download</a></li>
                     <li><a href="<?php echo base_url()."ContactUs"; ?>" id="ctl00_lnkContact" class="<?php echo $contactus_class; ?>">Contact Us</a></li>
                    
                    </ul>
                         
					<!--<ul id="menu">
						<li id="nav1" class="active"><a href="index.html">Home</a></li>
					  <li id="nav2"><a href="aboutus.html">About</a></li>
					  <li id="nav3"><a href="services.html">Services</a></li>
					  <li id="nav4"><a href="howtouse.html">How to use</a></li>
					  <li id="nav5"><a href="contacts.html">Contacts</a></li>
				  </ul>-->
                  </nav>
                </div>
                
				<div class="clr"></div></div>
				<div class="wrapper">
                  <div class="slidebox">
                    <div class="slider">
                      <ul class="items">
                        <li><img src="../../template_assets/theme01/images/img1.jpg" alt=""></li>
                        <li><img src="../../template_assets/theme01/images/img2.jpg" alt=""></li>
                        <li><img src="../../template_assets/theme01/images/img3.jpg" alt=""></li>
                      </ul>
                    </div>
                  </div>
				</div>
			</header>
			<div class="ic"></div>