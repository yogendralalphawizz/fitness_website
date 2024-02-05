        <!-- Start of Main -->
        <main class="main login-page">
            <!-- Start of Page Header -->
            <!--<div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">My Account</h1>
                </div>
            </div>-->
            <!-- End of Page Header -->

            <!-- Start of Breadcrumb -->
           <!-- <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="demo1.html">Home</a></li>
                        <li>My account</li>
                    </ul>
                </div>
            </nav>-->
            <!-- End of Breadcrumb -->
            <div class="page-content">
                <div class="container">
                    <div class="login-popup">
                        <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                            <!--<ul class="nav nav-tabs text-uppercase" role="tablist">
                                <li class="nav-item">
                                    <a href="#sign-in" class="nav-link active">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#sign-up" class="nav-link">Sign Up</a>
                                </li>
                            </ul>-->
							<h3 class="text-center mb-6">Login to my account</h3>
                                 <form class="mb-5" action="<?=base_url('login/validate_login/user')?>"  method="post">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" class="form-control" name="email" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <!--<div class="form-checkbox d-flex align-items-center justify-content-between">
                                        <input type="checkbox" class="custom-checkbox" id="remember1" name="remember1" required="">
                                        <label for="remember1">Remember me</label>
                                        <a href="#">Last your password?</a>
                                    </div>-->
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                 </form>
							<p class="text-center mb-0">New customer? <a href="<?=base_url()?>register">Create your account</a></p> 
							<p class="text-center mb-0">Lost password? <a href="<?=base_url()?>recover-password">Recover Password</a></p>
                            <!--<p class="text-center">Sign in with social account</p>
                            <div class="social-icons social-icon-border-color d-flex justify-content-center">
                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                <a href="#" class="social-icon social-google fab fa-google"></a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End of Main -->