<?php include('header.php');?>
<!--======= SUB BANNER =========-->
  <section class="sub-banner">
    <div class="container">
      <div class="position-center-center">
        <h2>Registration</h2>
        <ul class="breadcrumb">
          <li><a href="http://www.rechargeunlimited.com/">Home</a></li>
          <li>Registration</li>
        </ul>
      </div>
    </div>
  </section>
  
  <!-- Content -->
  <div id="content">
    <section class="padding-top-30 padding-bottom-100">
      	<div class="container"> 
        	<div class="heading-block text-center margin-bottom-30">
				<p>We are providing online <strong>FREE</strong> registration. So there is no need to visit retail shop or pay anyone to recharge your mobile phone. All you need to do is register yourself on <strong>rechargeunlimited.com</strong> with correct information. </p>
			</div>
			<div class="col-md-12">
			<span id="contact_message"></span>
          	<form role="form" id="contact_form" method="post" onSubmit="return false">
				<ul>
                	<li class="col-sm-6">
						<label>NAME *</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="">
					</li>
                	<li class="col-sm-6">
                    	<label>EMAIL *</label>
                      	<input type="text" class="form-control" name="email" id="email" placeholder="">
                 	</li>
                  	<li class="col-sm-6">
                    	<label>PHONE *</label>
                      	<input type="text" class="form-control" name="phone" id="phone" placeholder="">
                  	</li>
                  	<li class="col-sm-6">
                    	<label>SUBJECT *</label>
                      	<select name="service" id="service" class="form-control" required="required"/>
							<option value="Distributorship">Distributorship </option>
							<option value="Dealership">Dealership</option>
							<option value="Retailership">Retailership</option>
						</select>
					</li>
					<li class="col-sm-12">
						<label>MESSAGE *</label>
						<textarea class="form-control" name="message" id="message" rows="5" placeholder=""></textarea>
					</li>
					<li class="col-sm-12 no-margin">
						<button type="submit" value="submit" class="btn" id="btn_submit" onClick="proceed();">SEND NOW</button>
					</li>
                </ul>
        	</form>
			</div>
    	</div>
    </section>
	
  </div>
  <!-- End Content -->
<?php include('footer.php');?>
