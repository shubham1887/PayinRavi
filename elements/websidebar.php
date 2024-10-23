<div class="br-logo"><a href=""><span style="margin-left:2px;"><img style="width:140px;height:60px;" src="<?php echo base_url()."logo_w.png"; ?>" /></span></a></div>
<div class="br-sideleft sideleft-scrollbar">
      <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
      <ul class="br-sideleft-menu">
        <li class="br-menu-item">
          <a href="<?php echo base_url()."WEB/Home"; ?>" class="br-menu-link">
            <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
            <span class="menu-item-label">Dashboard</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
        
        
        
        <li class="br-menu-item">
          <a href="<?php echo base_url()."WEB/Add_fund_final"; ?>" class="br-menu-link">
            <i class="menu-item-icon icon ion-ios-arrow-right tx-24"></i>
            <span class="menu-item-label">Add Fund</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
        
       
        
        <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <!--<i class="menu-item-icon icon ion-ios-briefcase-outline tx-22"></i>-->
            <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
            <span class="menu-item-label">REPORTS</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
          
          	<li class="sub-item"><a href="<?php echo base_url()."WEB/payment_history?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">RECHARGE REPORT</a></li>
            
          	
          </ul>
        </li>



      <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Information Summary</label>

      <div class="info-list">
      
      
      <div class="info-list-item">
          <div>
            <p class="info-list-label">Success</p>
            <h5 class="info-list-amount" id="sidebargrosssuccess">...</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#1C7973"], "height": 35, "width": 60 }'>4,3,5,7,12,10,4,5,11,7</span>
        </div><!-- info-list-item -->
        <div class="info-list-item">
          <div>
            <p class="info-list-label">Pending</p>
            <h5 class="info-list-amount" id="sidebargrosspending">...</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#336490"], "height": 35, "width": 60 }'>8,6,5,9,8,4,9,3,5,9</span>
        </div><!-- info-list-item -->

        

        <div class="info-list-item">
          <div>
            <p class="info-list-label">Failure</p>
            <h5 class="info-list-amount" id="sidebargrosfailure">...</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#8E4246"], "height": 35, "width": 60 }'>1,2,1,3,2,10,4,12,7</span>
        </div><!-- info-list-item -->

        <div class="info-list-item">
          <div>
            <p class="info-list-label">HOLD</p>
            <h5 class="info-list-amount" id="sidebargroshold">...</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#9C7846"], "height": 35, "width": 60 }'>3,12,7,9,2,3,4,5,2</span>
        </div><!-- info-list-item -->
      </div><!-- info-list -->

      <br>
    </div>