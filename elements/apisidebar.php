<div class="br-logo"><a href=""><span style="margin-left:2px;"><img style="width:140px;height:60px;" src="<?php echo base_url(); ?>payin_logo.png" /></span></a></div>
<div class="br-sideleft sideleft-scrollbar">
      <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
      <ul class="br-sideleft-menu">
        <li class="br-menu-item">
          <a href="<?php echo base_url()."API/Dashboard"; ?>" class="br-menu-link">
            <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
            <span class="menu-item-label">Dashboard</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
       
        
        <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <!--<i class="menu-item-icon icon ion-ios-briefcase-outline tx-22"></i>-->
            <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
            <span class="menu-item-label">REPORTS</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
            <li class="sub-item"><a href="<?php echo base_url()."API/recharge_history?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Recharge Report</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/Account_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Account Report</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/Operatorwisereport?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Operator Report</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/dmr_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">DMR Report</a></li>
          <li class="sub-item"><a href="<?php echo base_url()."API/Account_report2?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">DMR Wallet Report</a></li>


            
          </ul>
        </li>
        <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <!--<i class="menu-item-icon icon ion-ios-briefcase-outline tx-22"></i>-->
            <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
            <span class="menu-item-label">AEPS</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
            <li class="sub-item"><a href="<?php echo base_url()."API/Aeps_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Aeps Report</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/Aeps_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Aeps Ledger</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/AddBank?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Move TO Bank</a></li>

            <li class="sub-item"><a href="<?php echo base_url()."API/MoveToWallet?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Move TO Wallet</a></li>
            

            
          </ul>
        </li>
        <!-- br-menu-item -->
        <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <i class="menu-item-icon ion-person-stalker tx-24"></i>
            <span class="menu-item-label">Payment Request</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
            <li class="sub-item"><a href="<?php echo base_url()."API/payment_request?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Payment Request</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/payment_history?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Payment Requeset History</a></li>
          </ul>
        </li><!-- br-menu-item -->
        
        <!--<li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <i class="menu-item-icon ion-person-stalker tx-24"></i>
            <span class="menu-item-label">Complains</span>
          </a>
          <ul class="br-menu-sub">
            <li class="sub-item"><a href="<?php echo base_url()."API/complain?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Complain</a></li>
            <li class="sub-item"><a href="<?php echo base_url()."API/complain_history?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sub-link">Complain History</a></li>
          </ul>
        </li>-->
        
        <li class="br-menu-item">

          <a href="<?php echo base_url()."API/mycommission"; ?>" class="br-menu-link">

            <i class="menu-item-icon icon ion-ios-list-outline tx-24"></i>

            <span class="menu-item-label">My Commission</span>

          </a><!-- br-menu-link -->

        </li>
        
        <!-- br-menu-item -->
        
       
        <li class="br-menu-item">
          <a href="<?php echo base_url()."API/Change_Password"; ?>" class="br-menu-link">
            <i class="menu-item-icon icon icon ion-key tx-22"></i>
            <span class="menu-item-label">Change Password</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
        <li class="br-menu-item">
          <a href="<?php echo base_url()."Api_document"; ?>" target="_blank" class="br-menu-link">
            <i class="menu-item-icon icon ion-arrow-down-a tx-22"></i>
            <span class="menu-item-label">Recharge Api Document</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
        <li class="br-menu-item">
          <a href="<?php echo base_url()."payin_api_document.docx"; ?>" target="_blank" class="br-menu-link">
            <i class="menu-item-icon icon ion-arrow-down-a tx-22"></i>
            <span class="menu-item-label">MoneyTransfer Api Document</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
        
        <li class="br-menu-item">
          <a href="<?php echo base_url()."ApiLogout"; ?>" class="br-menu-link">
            <i class="menu-item-icon icon icon ion-power tx-22"></i>
            <span class="menu-item-label">Sign Out</span>
          </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->
      </ul><!-- br-sideleft-menu -->

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