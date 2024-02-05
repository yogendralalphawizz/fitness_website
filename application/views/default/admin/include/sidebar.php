    <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">Menu</li>

                            <li>
                                <a href="<?php echo base_url('/admin/Dashboard'); ?>">
                                    <i class="fas fa-desktop"></i>
                                    <span >Dashboard</span>
                                </a>
                            </li>

                            <!--<li>
                                <a href="javascript:void(0)" class="has-arrow">
                                   <i class=" fas fa-cog"></i>
                                    <span data-key="t-apps">Web Configuration</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo base_url('/admin/Dashboard/mail_config'); ?>">
                                            <span >Email config</span>
                                        </a>
                                    </li>
									
									<li>
                                        <a href="<?php echo base_url('/admin/Dashboard/social_config'); ?>">
                                            <span >Social info</span>
                                        </a>
                                    </li>
        
                                    <li>
                                        <a href="<?php echo base_url('/admin/Dashboard/web_config'); ?>">
                                            <span >Web Settings</span>
                                        </a>
                                    </li>
									 <li>
                                        <a href="<?php echo base_url('/admin/Dashboard/sliders'); ?>">
                                            <span >Sliders</span>
                                        </a>
                                    </li>
							
                                 
                                </ul>
                            </li>-->
                     
                           
                          
                          
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class=" fas fa-users"></i>
                                    <span >User Management</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                   <!-- <li><a href="#" data-key="t-login">Add User</a></li>-->
                                    <li><a href="<?php echo base_url('/admin/Dashboard/users'); ?>" data-key="t-login">Users</a></li>
                                    
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fas fa-list-alt
"></i>
                                    <span >Category</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
								
                                    <li><a href="<?php echo base_url('/admin/Dashboard/add_category'); ?>" data-key="t-login">Add Category</a></li>
                                    <li><a href="<?php echo base_url('/admin/Dashboard/categories'); ?>" data-key="t-login">Category List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fa fa-gift"></i>
                                    <span >Product Management</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="<?=base_url()?>admin/Dashboard/colors" data-key="t-login">Color</a></li>
                                    <li><a href="<?=base_url()?>admin/Dashboard/sizes" data-key="t-login">Size</a></li>

                                    <li><a href="<?=base_url()?>admin/Dashboard/add_product" data-key="t-login">Add Product</a></li>
                                    <li><a href="<?=base_url()?>admin/Dashboard/products" data-key="t-login">Product List</a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fa fa-file"></i>
                                    <span >Order Management</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                   
                                    <li><a href="<?=base_url()?>admin/Dashboard/orders" data-key="t-login">View Orders</a></li>
                                    <li><a href="#" data-key="t-login">User By Orders</a></li>
                                    
                                </ul>
                            </li>
                            
                           
							<li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fa fa-signal "></i>
                                    <span>Sales Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="#" data-key="t-login">Sales Reports list</a></li>
                                    
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fas fa-file"></i>
                                    <span>Invoice</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="#" data-key="t-login">Invoice</a></li>
                                    
                                </ul>
                            </li>
                             <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                     <i class="fa fa-list"></i>
                                    <span >Pages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
										<li><a href="<?php echo base_url('/admin/Dashboard/banners'); ?>" data-key="t-login">Banners</a></li>
										<li><a href="<?php echo base_url('/admin/Dashboard/app_pages'); ?>" data-key="t-login">Pages</a></li>
										<li><a href="<?php echo base_url('/admin/Dashboard/faqs'); ?>" data-key="t-login">FAQs</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?=base_url('/admin/Auth/logout')?>" class="has-arrow">
                                     <i class="mdi mdi-logout"></i>
                                    <span >Logout</span>
                                </a>
                                
                            </li>
						



                        </ul>

                     
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            
