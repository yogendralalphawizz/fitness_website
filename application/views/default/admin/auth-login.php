<!doctype html>
<html lang="en">
    
<head>

        <meta charset="utf-8" />
        <title><?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sports Wear" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo BACKEND_CSS_URL; ?>">

        <!-- preloader css -->
        <link rel="stylesheet" href="<?php echo BACKEND_CSS_URL; ?>css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?php echo BACKEND_CSS_URL; ?>css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo BACKEND_CSS_URL; ?>css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo BACKEND_CSS_URL; ?>css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
      
      <style>
        .auth-full-page-content{
          width: 450px;
          margin: 0 auto;
          /*height: 100%;*/
          box-shadow: 0 0 2px rgba(0,0,0,0.3);
       }
      </style>
    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-12 col-lg-12 col-md-12">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index-2.html" class="d-block auth-logo">
                                            <!--<img src="<?=base_url()?>" alt="" height="28"> <span class="logo-txt"></span>-->
                                            <h1>Sports Wear</h1>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back !</h5>
                                            <p class="text-muted mt-2">Sign in to continue.</p>
                                        </div>
                                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                                        <form class="mt-4 pt-2" method="post">
                                            <?php $this->security->csrf_input(); ?>
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="text" class="form-control" id="username" placeholder="Enter Email Address" name="email">
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Password</label>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="<?php echo base_url('/admin/Auth/forgot_password'); ?>" class="text-muted">Forgot password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" placeholder="Enter password" name="password">
                                                    <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                            <div class="g-recaptcha" data-sitekey="6LdBmNUgAAAAAExhK5HX3kEWNq3Xb2SjjHMViQTA"></div>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <!--<div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                           
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                            imposing change
                                                            on myself. It's a lot more progressing fun than looking back.
                                                            That's why
                                                            I ultricies enim
                                                            at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="<?php echo BACKEND_CSS_URL; ?>images/users/avatar-1.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Richard Drews
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Web Designer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                            free ourselves by widening our circle of compassion to embrace
                                                            all living
                                                            creatures and
                                                            the whole of quis consectetur nunc sit amet semper justo. nature
                                                            and its beauty.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="<?php echo BACKEND_CSS_URL; ?>images/users/avatar-2.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Rosanna French
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Web Developer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
                                                            people will forget what you said, people will forget what you
                                                            did,
                                                            but people will never forget
                                                            how donec in efficitur lectus, nec lobortis metus you made them
                                                            feel.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <img src="<?php echo BACKEND_CSS_URL; ?>images/users/avatar-3.jpg"
                                                                    class="avatar-md img-fluid rounded-circle" alt="...">
                                                                <div class="flex-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Ilse R. Eaton</h5>
                                                                    <p class="mb-0 text-white-50">Manager
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        <!-- JAVASCRIPT -->
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/jquery/jquery.min.js"></script>
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/node-waves/waves.min.js"></script>
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="<?php echo BACKEND_CSS_URL; ?>libs/pace-js/pace.min.js"></script>
        <!-- password addon init -->
        <script src="<?php echo BACKEND_CSS_URL; ?>js/pages/pass-addon.init.js"></script>
        
        <?php echo alertify_render( '//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build', 'top-right' ); ?>
    </body>

</html>