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
							<h3 class="text-center">Create my account</h3>
							     <form class="mb-5" id="registration_form" action="" method="post">
                                    <div class="form-group mb-5">
                                        <label>First Name *</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="">
                                        <span id="firstname_error"></span>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label>Last Name *</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname">
                                        <span id="lastname_error"></span>
                                    </div>
                                    <!--<div class="form-group mb-5">
                                        <label>Phone Number *</label>
                                        <input type="text" class="form-control" name="phone-number" id="phone-number" required>
                                    </div>-->
									<div class="form-group">
                                        <label>Email*</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                        <span id="email_error"></span>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label>Password *</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                        <span id="password_error"></span>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label>Confirm Password *</label>
                                        <input type="password" class="form-control" name="cpassword" id="cpassword">
                                        <span id="cpassword_error"></span>
                                    </div>
                                    <!--<div class="form-group mb-5">
                                        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>">
                                        </div>
                                        <span id="recaptcha_error"></span>
                                    </div>-->
                                  
                                    <!--<div class="form-checkbox user-checkbox mt-0">
                                        <input type="checkbox" class="custom-checkbox checkbox-round active" id="check-customer" name="check-customer" required="">
                                        <label for="check-customer" class="check-customer mb-1">I am a customer</label>
                                        <br>
                                        <input type="checkbox" class="custom-checkbox checkbox-round" id="check-seller" name="check-seller" required="">
                                        <label for="check-seller" class="check-seller">I am a vendor</label>
                                    </div>-->
                                    <!--<div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                        <input type="checkbox" class="custom-checkbox" id="remember" name="remember" required="">
                                        <label for="remember" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                                    </div>-->
                                    <button type="submit" class="btn btn-primary">Sign up</button>
                                 </form>
							<p class="text-center mb-0">Already have an account? <a href="<?=base_url('login')?>">Login here</a></p> 	 
                            
                           <!-- <p class="text-center">Sign in with social account</p>
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