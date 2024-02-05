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
							<h3 class="text-center mb-6">Recover Password</h3>
                                 <form class="mb-5" method="post" action="<?=base_url('Login/forgot_password')?>">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" class="form-control" name="email" id="email">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Recover Password</button>
                                 </form>
							<p class="text-center mb-0">Remembered your password? <a href="<?=base_url()?>login">Back to login</a></p> 
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End of Main -->