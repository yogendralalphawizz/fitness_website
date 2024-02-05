 
    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?php echo base_url('/admin/Dashboard'); ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <!--<img src="<?=BACKEND_CSS_URL;?>images/logo-sm.png" alt="" height="24">-->
                                </span>
                                <span class="logo-lg">
                                    <!--<img src="<?=BACKEND_CSS_URL;?>images/logo-sm.png" alt="" height="24">--> <span class="logo-txt">Sports Wear Panel</span>
                                </span>
                            </a>

                            <a href="index-2.html" class="logo logo-light">
                                <!--<span class="logo-sm">
                                    <img src="<?=BACKEND_CSS_URL;?>images/logo-sm.png" alt="" height="24">
                                </span>-->
                                <span class="logo-lg">
                                    <!--<img src="<?=BACKEND_CSS_URL;?>images/logo-sm.png" alt="" height="24">--> <span class="logo-txt">Sports Wear Panel</span>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                               <h2>Sports Wear Panel</h2>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="search" class="icon-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                     
                         <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item right-bar-toggle me-2">
                                <i data-feather="settings" class="icon-lg"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php $profile_pic = $this->db->get_where('admin', ['id' => $this->session->userdata('login_user')['id']])->row('profile_pic'); if($profile_pic){ echo base_url($profile_pic); } else { BACKEND_CSS_URL . 'images/users/avatar.jpg'; } ?>"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium">Admin</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?php echo base_url('/admin/Dashboard/profile'); ?>"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item" href="<?php echo base_url('/admin/Dashboard/change_pass'); ?>"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i>Change password </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('/admin/Auth/logout'); ?>"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
