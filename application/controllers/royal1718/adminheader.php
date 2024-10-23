  <div id="cm-menu">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="cm-flex"><a href="index.html" class="cm-logo"></a></div>
                <div class="btn btn-primary md-menu-white" data-toggle="cm-menu"></div>
            </nav>
            <div id="cm-menu-content">
                <div id="cm-menu-items-wrapper">
                    <div id="cm-menu-scroller">
                        <ul class="cm-menu-items">
                            <li><a href="index.html" class="sf-house">Home</a></li>
                            <li><a href="<?php echo base_url()."Admin/bank_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="sf-dashboard">Bank Ledger</a></li>
                            <li><a href="components-text.html" class="sf-brick">Components</a></li>
                            <li id="ul_users" class="cm-submenu">
                                <a class="sf-window-layout">Users <span class="caret"></span></a>
                                <ul>
                                    <li><a href="<?php echo base_url()."Admin/debtor_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Debtors</a></li>
                                    <li class="active"><a href="<?php echo base_url()."Admin/creditor_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Creditors</a></li>
                                    <li><a href="layouts-tabs.html">2nd nav tabs</a></li>
                                </ul>
                            </li>
                            <li class="cm-submenu pre-open">
                                <a class="sf-window-layout">Reports <span class="caret"></span></a>
                                <ul>
                                    <li  class="active"><a href="<?php echo base_url()."Admin/bank_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Bank Ledger</a></li>
                                     <li  class="active"><a href="<?php echo base_url()."Admin/filetr_bank_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Filter Bank Ledger</a></li>
                                    <li><a href="<?php echo base_url()."Admin/account_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Balance Topup</a></li>
                                    <li><a href="<?php echo base_url()."Admin/datewise_debtor_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Datewise Debtor Ledger</a></li>
                                    <li><a href="<?php echo base_url()."Admin/debtor_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Debtor Ledger</a></li>
                                </ul>
                            </li>
                            
                            
                             <li class="cm-submenu pre-open">
                                <a class="sf-window-layout">Purchase <span class="caret"></span></a>
                                <ul>
                                    <li  class="active"><a href="<?php echo base_url()."Admin/purchase_ledger?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Bank Ledger</a></li>
                                   
                                </ul>
                            </li>
                            
                            
                            
                            <li class="cm-submenu pre-open">
                                <a class="sf-window-layout">Uploads <span class="caret"></span></a>
                                <ul>
                                    <li  class="active"><a href="<?php echo base_url()."Admin/sbiuploadfile?crypt=".$this->Common_methods->encrypt("MyData"); ?>">SBI Upload</a></li>
                                    <li  class="active"><a href="<?php echo base_url()."Admin/pnbuploadfile?crypt=".$this->Common_methods->encrypt("MyData"); ?>">PNB Upload</a></li>
                                    <li><a href="<?php echo base_url()."Admin/logoupload?crypt=".$this->Common_methods->encrypt("MyData"); ?>">BOB Upload</a></li>
                                   
                                </ul>
                            </li>
                            <li class="cm-submenu">
                                <a class="sf-cat">Icons <span class="caret"></span></a>
                                <ul>
                                    <li><a href="ico-sf.html">Small-n-flat</a></li>
                                    <li><a href="ico-md.html">Material Design</a></li>
                                    <li><a href="ico-fa.html">Font Awesome</a></li>
                                </ul>
                            </li>
                            <li><a href="notepad.html" class="sf-notepad">Text Editor</a></li>
                            <li><a href="login.html" class="sf-lock-open">Login page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <header id="cm-header">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="btn btn-primary md-menu-white hidden-md hidden-lg" data-toggle="cm-menu"></div>
                <div class="cm-flex">
                    <h1>Check this breadcrumb</h1> 
                    <form id="cm-search" action="index.html" method="get">
                        <input type="search" name="q" autocomplete="off" placeholder="Search...">
                    </form>
                </div>
                <div class="pull-right">
                    <div id="cm-search-btn" class="btn btn-primary md-search-white" data-toggle="cm-search"></div>
                </div>
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-notifications-white" data-toggle="dropdown"> <span class="label label-danger">23</span> </button>
                    <div class="popover cm-popover bottom">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            <div class="list-group">
                                <a href="#" class="list-group-item">

                                    <h4 class="list-group-item-heading text-overflow">
                                        <i class="fa fa-fw fa-envelope"></i> Nunc volutpat aliquet magna.
                                    </h4>
                                    <p class="list-group-item-text text-overflow">Pellentesque tincidunt mollis scelerisque. Praesent vel blandit quam.</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        <i class="fa fa-fw fa-envelope"></i> Aliquam orci lectus
                                    </h4>
                                    <p class="list-group-item-text">Donec quis arcu non risus sagittis</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        <i class="fa fa-fw fa-warning"></i> Holy guacamole !
                                    </h4>
                                    <p class="list-group-item-text">Best check yo self, you're not looking too good.</p>
                                </a>
                            </div>
                            <div style="padding:10px"><a class="btn btn-success btn-block" href="#">Show me more...</a></div>
                        </div>
                    </div>
                </div>
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-account-circle-white" data-toggle="dropdown"></button>
                    <ul class="dropdown-menu">
                        <li class="disabled text-center">
                            <a style="cursor:default;"><strong>John Smith</strong></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-cog"></i> Settings</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()."logout?crypt=".$this->Common_methods->encrypt("MyData"); ?>"><i class="fa fa-fw fa-sign-out"></i> Sign out</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <nav class="cm-navbar cm-navbar-default cm-navbar-slideup">
                <div class="cm-flex">
                    <div class="cm-breadcrumb-container">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Profile</a></li>
                            <li class="active">Lorem Page</li>
                        </ol>
                    </div>
                </div>
            </nav>
        </header>