<?php header('Access-Control-Allow-Origin: *'); ?>
<link rel="preload" href="<?=base_url()?>assets/frontend/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
<link rel="preload" href="<?=base_url()?>assets/frontend/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
<link rel="preload" href="<?=base_url()?>assets/frontend/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2"
            crossorigin="anonymous">
<link rel="preload" href="<?=base_url()?>assets/frontend/fonts/wolmart87d5.ttf?png09e" as="font" type="font/ttf" crossorigin="anonymous">

    <!-- Vendor CSS -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/vendor/fontawesome-free/css/all.min.css">

   <!-- Plugins CSS -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/vendor/swiper/swiper-bundle.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/vendor/animate/animate.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/vendor/magnific-popup/magnific-popup.min.css">

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/css/lobibox.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/css/navigation.css">
    <!-- Default CSS -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/css/style.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/frontend/css/style.min.css">
<!--Toster stylr-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<style>
        .errors{
    color:red;
}
/*----------- 2. Home page 1 --------*/
body{
    font-family: adobe-garamond-pro, serif;
}
/* header area */
.header-area {
    left: 0;
    position: relative;
    top: 0;
    width: 100%;
    z-index: 99;
    transition: all 0.7s ease 0s;
    background-color: #f7d2cc;
}
.transparent-bar.stick {
    background-color: #f7d2cc;
    border-bottom: 0 solid #4a90e2;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.04);
    position: fixed;
    top: 0;
    width: 100%;
    padding: 0px 0;
    animation: 700ms ease-in-out 0s normal none 1 running fadeInDown;
    z-index: 9999;
}
.logo,
.language-currency,
.logo-menu-wrapper,
.header-site-icon,
.sticky-logo {
    transition: all 0.7s ease 0s;
}
.stick .language-currency,
.stick .logo {
    display: block;
    transition: all 0.7s ease 0s;
}
.sticky-logo {
    display: none;
    transition: all 0.7s ease 0s;
}
.stick .sticky-logo {
    display: block;
    padding-top: 4px;
    max-width: 50px
}
.stick .sticky-logo img{
    max-width: 100%
}
.stick .logo-menu-wrapper {
    padding-top: 0px;
}
.stick .header-site-icon {
    padding-top: 12px;
}
.stick .main-menu ul li a {
    line-height: 25px;
}
.language-currency {
    display: flex;
    padding-top: 16px;
}
.hm-3-padding .language-currency,
.hm-4-padding .language-currency {
    padding-top: 63px;
}
.hm-3-padding .header-site-icon,
.hm-4-padding .header-site-icon {
    padding-top: 64px;
}
.language {
    margin-right: 7px;
}
.mobile-menu-area {
    display: none;
}

.brand-logo-area.gray-bg {
    background-color: #d6d3d4;
}
.banner-wrapper.home-sc img {
    object-fit: cover;
}
/* chosen select option */
.chosen-container-single .chosen-single span {
    color: #666;
    display: block;
    font-size: 16px;
    transition: all .3s ease 0s;
}
.chosen-container-single .chosen-single span:hover {
    color: #f3a395;
}
.chosen-container-single .chosen-single {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    border-radius: 0px;
    box-shadow: none;
    color: #666;
    display: block;
    overflow: hidden;
    padding: 0;
    position: relative;
    text-decoration: none;
    border: none;
}
.chosen-container .chosen-drop {
    background: #fff none repeat scroll 0 0;
    border: medium none;
    box-shadow: none;
    margin-top: 10px;
    width: 100px;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}
.chosen-container-active.chosen-with-drop .chosen-single {
    background-image: none;
    border: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    box-shadow: none;
}
.chosen-container .chosen-single div b::before {
    color: #000000;
    content: "\f35f";
    font-family: "Ionicons";
    font-size: 12px;
    margin-left: 2px;
}
.chosen-container .chosen-results {
    padding: 4px;
}
.chosen-container .chosen-drop ul.chosen-results {
    margin: 0;
}
.chosen-container .chosen-drop ul li.highlighted {
    background: #f3a395;
}
/* logo */
.logo-menu-wrapper {
    padding-top: 10px;
}
.logo-small-device {
    padding-top: 30px;
    display: none;
}
/* menu */
.main-menu ul li {
    display: inline-block;
   /* padding: 0 58px;*/
    /*position: relative;*/
}
.main-menu ul li a {
    color: #797979;
    font-size: 17px;
    font-weight: 500;
    letter-spacing: 0.5px;
    line-height: 35px;
   /* text-transform: capitalize;*/
}
.main-menu ul li:hover > a {
    color: #f3a395;
}
.main-menu nav > ul > li > ul {
    background: #1a11115e  none repeat scroll 0 0;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
    display: block;
    left: 0px;
    opacity: 0;
    padding: 25px 0px 27px;
    position: absolute;
    text-align: left;
    top: 120%;
    transition: all 0.3s ease 0s;
    visibility: hidden;
    width: 200px;
    z-index: 999;
}
.main-menu nav ul li:hover > ul {
    opacity: 1;
    top: 100%;
    visibility: visible;
}
.main-menu nav ul li:hover > div {
    opacity: 1;
    top: 100%;
    visibility: visible;
}
.main-menu nav ul li ul > li {
    display: block;
    position: relative;
}
.main-menu nav ul li ul > li > a::before {
    background: #f3a395 none repeat scroll 0 0;
    content: "";
    height: 7px;
    left: 0px;
    opacity: 0;
    position: absolute;
    top: 14px;
    transition: all 0.3s ease-in-out 0s;
    width: 7px;
    border-radius: 50%;
    z-index: 999;
}
.main-menu nav ul li ul > li:hover > a::before {
    opacity: 1;
}
.main-menu nav ul li ul li > a,
.stick .main-menu nav ul li ul li > a {
    color: #FFF;
    font-weight: 400;
    letter-spacing: 3.8px;
    line-height: 32px;
    text-transform: capitalize;
    display: block;
}
.main-menu nav ul li ul li.active > a,
.stick .main-menu nav ul li ul li.active > a {
    color: #f3a395;
}
.main-menu nav ul li ul li:hover > a {
    padding-left: 15px;
}
.main-menu nav ul li > ul.mega-menu {
    padding: 45px 0px 47px;
    width: 100%;
}
.main-menu > nav > ul > li > ul.mega-menu > li {
    width: 33.333%;
    float: left;
    display: inline-block;
}
.main-menu > nav > ul > li > ul.mega-menu > li.mega-menu-img {
    display: block;
    overflow: hidden;
  
    /*margin-top: 25px;*/
}
.main-menu nav ul li > ul.mega-menu li ul {
    width: 100%;
}
.main-menu nav ul li > ul.mega-menu li ul > li {
    display: block;
    position: relative;
}
.main-menu nav ul li > ul.mega-menu li ul > li.mega-menu-title {
    font-size: 15px;
    font-weight: 500;
    text-transform: uppercase;
    margin-bottom: 15px;
}
.main-menu > nav > ul > li > ul.mega-menu > li.mega-menu-img a {
    padding-left: 0;
}
.main-menu nav ul li > ul.mega-menu li ul > li > a {
    display: block;
}
.main-menu nav ul li > ul.mega-menu li.mega-menu-img ul > li > a img {
    width: 100%;
}
.main-menu > nav > ul > li > ul.mega-menu > li.mega-menu-img a::before {
    display: none;
}
.main-menu nav ul li > ul.mega-menu li ul > li.mega-menu-title:hover::before {
    display: none;
    opacity: 0;
}
.main-menu nav > ul > li > ul.lavel-menu li ul {
    background: #1a11115e none repeat scroll 0 0;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
    display: block;
    left: 100%;
    opacity: 0;
    padding: 25px 0px 27px;
    position: absolute;
    text-align: left;
    top: 10px;
    transition: all 0.3s ease 0s;
    visibility: hidden;
    width: 200px;
    z-index: 999;
}
.main-menu nav > ul > li > ul.lavel-menu li:hover > ul {
    opacity: 1;
    top: 0px;
    visibility: visible;
}
.main-menu ul li a span {
    float: right;
}
/* cart search login */
.header-site-icon {
    display: flex;
    justify-content: flex-end;
    padding-top: 12px;
}
.same-style {
    margin-left: 17px;
}
.same-style:first-child {
    margin-left: 0px;
}
.same-style button,
.same-style a {
    background-color: transparent;
    border: medium none;
    color: #666666;
    font-size: 20px;
    cursor: pointer;
    position: relative;
}
.same-style button:hover,
.same-style a:hover {
    color: #f3a395;
}
.header-cart button span {
    font-size: 12px;
    position: absolute;
    right: -5px;
    top: -6px;
    display: inline-block;
    width: 20px;
    height: 20px;
    background-color: #f3a395;
    color: #fff;
    text-align: center;
    line-height: 20px;
    border-radius: 50px;
}

footer.footer-padding {
          

    background-color: #f7d2cc;
}
.footer-bottom.border-top-1.ptb-15 {
    background-color: #d6d3d4;
}
/* header cart */

.sidebar-cart {
    background: #ffffff none repeat scroll 0 0;
    color: #353535;
    min-height: 100vh;
    position: fixed;
    right: -480px;
    top: 0;
    -webkit-transition: all 0.5s ease-in-out 0s;
    -ms-transition: all 0.5s ease-in-out 0s;
    transition: all 0.5s ease-in-out 0s;
    width: 450px;
    z-index: 9999;
}
.wrap-sidebar {
    height: 100vh;
    margin: 0;
    overflow-y: auto;
    padding: 15px 47px 0;
    width: 100%;
}
.sidebar-cart-all {
    padding-bottom: 39px;
}
.sidebar-cart.inside {
    right: 0px;
}
.sidebar-cart-icon,
.sidebar-nav-icon {
    display: block;
    margin-bottom: 14px;
    overflow: hidden;
}
.sidebar-cart-icon button,
.sidebar-nav-icon button {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    color: #303030;
    cursor: pointer;
    float: right;
    font-size: 27px;
    padding: 0;
    transition: all 0.3s ease 0s;
}
.sidebar-cart-icon button:hover,
.sidebar-search-icon button:hover,
.sidebar-search-input form .form-search button:hover,
.sidebar-nav-icon button:hover {
    color: #f3a395;
}
.cart-content > h3 {
    font-size: 22px;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}
.cart-content ul li.single-product-cart {
    display: flex;
    margin-bottom: 27px;
}
.cart-img img {
    flex: 0 0 80px;
}
.cart-content ul li.single-product-cart:last-child {
    margin-bottom: 0px;
}
.cart-title > h3 {
    color: #646464;
    font-size: 16px;
    font-weight: 400;
    margin-bottom: 12px;
}
.cart-title > span {
    color: #f3a395;
    font-weight: 600;
}
.cart-title {
    margin: 0px 0 18px 30px;
}
.cart-delete {
    display: flex;
    flex-grow: 100;
    justify-content: flex-end;
}
.cart-delete a i {
    color: #4b4b4b;
    display: inline-block;
    font-size: 17px;
    line-height: 1;
    margin-top: 4px;
}
.cart-delete a i:hover {
    color: #f3a395;
}
.cart-content ul {
    margin-top: 25px;
}
.cart-total {
    border-top: 1px solid #e3e3e3;
    margin-top: 29px;
    padding-top: 17px;
    text-align: right;
    width: 100%;
}
.cart-total h4 {
    font-size: 18px;
    font-weight: 500;
    letter-spacing: 0.5px;
}
.cart-total h4 span {
    color: #f3a395;
    font-size: 18px;
    font-weight: 600;
}
.cart-checkout-btn > a.no-mrg {
    margin-right: 0px;
}
.cart-checkout-btn {
    margin-top: 13px;
}
.wrapper .body-overlay {
    background: rgba(240, 240, 240, 0.69) !important;
    cursor: crosshair;
    height: 100%;
    left: 0;
    opacity: 1;
    position: fixed;
    top: 0;
    transition: all 0.5s ease-in-out 0s;
    visibility: hidden;
    width: 100%;
    z-index: 999;
}
.wrapper.overlay-active .body-overlay {
    opacity: 1;
    visibility: visible;
}
.btn-style.cart-btn-style {
    letter-spacing: 1px;
    /*margin-right: 30px;*/
    padding: 13px 41px
}
.btn-hover:hover {
    color: white;
}
.btn-hover {
    position: relative;
}
/* search */
.main-search-active {
    background: rgba(0, 0, 0, 0.92) none repeat scroll 0 0;
    color: #353535;
    display: flex;
    justify-content: center;
    min-height: 100vh;
    padding: 32px 46px 39px;
    position: fixed;
    right: 0;
    top: 0;
    transform: translateX(110%);
    transition: transform 0.5s ease-in-out 0s;
    width: 100%;
    z-index: 9999;
}
.main-search-active.inside {
    transform: translateX(0px);
    z-index: 9999;
}
.sidebar-search-input {
    padding: 300px 0 0;
}
.sidebar-search-input form .form-search {
    position: relative;
}
.sidebar-search-input form .form-search input {
    background-color: transparent;
    border-color: #dadada;
    border-style: solid;
    border-width: 0 0 1px;
    color: #fff;
    display: block;
    font-size: 17px;
    height: 62px;
    line-height: 62px;
    padding: 0 40px 0 0;
    width: 800px;
}
.sidebar-search-input form .form-search button {
    background-color: transparent;
    border: medium none;
    color: #dadada;
    cursor: pointer;
    font-size: 25px;
    padding: 0;
    position: absolute;
    right: 0;
    top: 18px;
    transition: all 0.3s ease 0s;
}
.sidebar-search-icon {
    display: block;
    float: right;
    overflow: hidden;
    position: absolute;
    right: 375px;
}
.sidebar-search-icon button {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    color: #fff;
    cursor: pointer;
    font-size: 35px;
    line-height: 1;
    padding: 0;
    transition: all 0.3s ease 0s;
}
.sidebar-search-input form .form-search input::-moz-placeholder {
    color: #fff;
    opacity: 1;
}
.sidebar-search-input form .form-search input::-webkit-placeholder {
    color: #fff;
    opacity: 1;
}

/* slider */
.slider-1 {
    padding: 200px 0 200px; background-repeat: no-repeat;
}
.slider-content {
    margin-top: 0px;
}
.slider-single-img {
    overflow: hidden;
}
.slider-single-img > img {
    float: right;
    max-width: 100%;
    padding-left: 60px;
}
.slider-content h2 {
    color: #000;
    font-size: 60px;
    font-weight: 500;
    margin: 0;
    font-family: adobe-garamond-pro, serif;
}
.slider-content h2 span {
    color: #f3a395;
}
.slider-content p {
    font-family: adobe-garamond-pro, serif;
    color: #787878;
    font-size: 16px;
    margin: 10px 0 21px;
    width: 90%;
}
a.slider-btn {
    color: #303030;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    display: inline-block;
}

a.slider-btn:hover {
    color: #f3a395;
}
a.slider-btn::before {
    background: #f3a395 none repeat scroll 0 0;
    bottom: -5px;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    transition: all 0.3s ease-in-out 0s;
    width: 0;
}
a.slider-btn:hover::before {
    width: 100%;
}

/* Default Slider Animations */
.owl-item .slider-content * {
    -webkit-animation-duration: 1.3s;
    animation-duration: 1.3s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
.owl-item.active .slider-content * {}
.owl-item.active .slider-animated-1 h5 {
    -webkit-animation-delay: 0.7s;
    animation-delay: 0.7s;
    -webkit-animation-name: fadeInLeft;
    animation-name: fadeInLeft;
}
.owl-item.active .slider-animated-1 h2 {
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
    -webkit-animation-name: fadeInLeft;
    animation-name: fadeInLeft;
}
.owl-item.active .slider-animated-1 p {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInLeft;
    animation-name: fadeInLeft;
}
.owl-item.active .slider-animated-1 img {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInRight;
    animation-name: fadeInRight;
}
.owl-item.active .slider-animated-1 a {
    -webkit-animation-delay: 1.3s;
    animation-delay: 1.3s;
    -webkit-animation-name: fadeInLeft;
    animation-name: fadeInLeft;
}

/* Slider Animations 2 */

.owl-item.active .slider-animated-2 h2 {
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}
.owl-item.active .slider-animated-2 h5 {
    -webkit-animation-delay: 0.7s;
    animation-delay: 0.7s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}
.owl-item.active .slider-animated-2 p {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}
.owl-item.active .slider-animated-2 img {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}
.owl-item.active .slider-animated-2 a {
    -webkit-animation-delay: 1.3s;
    animation-delay: 1.3s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}

/* Slider Animations 3 */
.owl-item.active .slider-animated-3 h2 {
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
}
.owl-item.active .slider-animated-3 a {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInUp;
    animation-name: fadeInUp;
}
/* Slider Animations 4 */
.owl-item.active .slider-animated-4 h2 {
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
    -webkit-animation-name: fadeInLeft;
    animation-name: fadeInLeft;
}
.owl-item.active .slider-animated-4 a {
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
    -webkit-animation-name: fadeInRight;
    animation-name: fadeInRight;
}

/* banner style */

.banner-wrapper {
    position: relative;
}
.banner-border::before {
    border: 1px solid #f3a395;
    content: "";
    height: 100%;
    left: -10px;
    position: absolute;
    top: 10px;
    width: 100%;
    transition: all .4s ease 0s;
    pointer-events: none;
}
.banner-border-2::before {
    border: 1px solid #f3a395;
    content: "";
    height: 100%;
    right: -10px;
    position: absolute;
    top: 10px;
    width: 100%;
    transition: all .4s ease 0s;
    pointer-events: none;
}
.banner-border:hover::before {
    left: 0px;
    top: 0px;
}
.banner-border-2:hover::before {
    right: 0px;
    top: 0px;
}
.banner-img img {
    width: 100%;
}
.hm1-banner .row {
    margin-left: -10px;
    margin-right: -10px;
}
.hm1-banner .row div[class^="col-"] {
    padding-left: 10px;
    padding-right: 10px;
}
.banner-position-center-right {
    padding: 30px;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

.banner-wrapper.home-sc h2 {
    font-size: 60px;
    line-height: 80px;
    margin-bottom: 15px;
}
.banner-position-center-left {
    left: 0;
    padding: 30px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}
.banner-position-top {
    left: 0;
    padding: 35px;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
    pointer-events: none;
}
.banner-position-bottom {
    bottom: 0;
    left: 0;
    padding: 33px;
    position: absolute;
    right: 0;
    text-align: center;
    pointer-events: none;
}
.banner-content-style1 > h2 {
    color: #646161;
    font-size: 24px;
    font-weight: bold;
    line-height: 29px;
    margin: 0;
    text-transform: uppercase;
}
.banner-content-style2 > h3 {
    color: #646161;
    font-size: 18px;
    margin-bottom: 4px;
}
.banner-content-style2 > h2 {
    color: #646161;
    font-size: 24px;
    font-size: 24px;
    font-weight: 500;
    margin: 0;
}
.banner-content-style2 h2 > span {
    color: #f3a395;
}
.banner-content-style3 > h3 {
    color: #5d5d5d;
    font-size: 23px;
    margin: 0;
}
.banner-content-style4 > h3 {
    color: #f3a395;
    font-size: 30px;
    font-weight: 500;
    margin: 0;
}
.banner-wrapper:hover .banner-content-style1 > h2,
.banner-wrapper:hover .banner-content-style2 > h2,
.banner-wrapper:hover .banner-content-style4 > h3 {
    animation: 700ms ease-in-out 0s normal none 1 running fadeInUp;
}
.banner-wrapper:hover .banner-content-style2 > h3,
.banner-wrapper:hover .banner-content-style3 > h3 {
    animation: 700ms ease-in-out 0s normal none 1 running fadeInDown;
}
/* section title */
.section-title.text-center > h2 {
     font-family: adobe-garamond-pro, serif;
    color: #292929;
    display: inline-block;
    font-size: 36px;
    font-weight: 500;
    line-height: 1;
    margin: 0;
    position: relative;
}
.section-title > h2::before {
    background-color: #292929;
    content: "";
    height: 1px;
    left: -210px;
    position: absolute;
    top: 21px;
    transition: all 0.4s ease 0s;
    width: 160px;
}
.section-title > h2::after {
    background-color: #292929;
    content: "";
    height: 1px;
    right: -210px;
    position: absolute;
    top: 21px;
    transition: all 0.4s ease 0s;
    width: 160px;
}
/* product area */
.product-tab-list {
    display: flex;
    justify-content: center;
}
.product-tab-list a {
    position: relative;
}
.product-tab-list a h4 {
    color: #2b2b2b;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 1px;
    margin: 0 31px;
    text-transform: uppercase;
    transition: all .3s ease 0s;
}
.product-tab-list a::before {
    background-color: #2b2b2b;
    content: "";
    height: 1px;
    position: absolute;
    right: -4px;
    top: 7px;
    transition: all 0.4s ease 0s;
    width: 5px;
}
.product-tab-list a:last-child::before {
    display: none;
}
.product-tab-list a.active h4,
.product-tab-list a h4:hover {
    color: #f3a395;
}
.product-wrapper,
.product-img {
    overflow: hidden;
    position: relative;
}
.product-img img {
    width: 100%;
}
.product-action {
    bottom: 0px;
    left: 0;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: center;
    transition: all 0.6s ease 0s;
}
.product-wrapper:hover .product-action {
    bottom: 20px;
    opacity: 1;
}
.product-content {
    padding-top: 15px;
}
.product-content > h4 {
    color: #646464;
    font-size: 16px;
    margin: 0;
}
.product-content > h4 a {
    color: #646464;
}
.product-content > h4 a:hover,
.product-action-style > a:hover {
    color: #f3a395;
}
.product-rating i {
    color: #f3a395;
    font-size: 16px;
    margin: 0 3px;
}
.product-rating {
    margin: 11px 0 9px;
}
.product-price > span.old {
    font-size: 14px;
    font-weight: 400;
    text-decoration: line-through;
}
.product-price > span {
    color: #646464;
    display: inline-block;
    font-size: 16px;
    font-weight: 500;
    margin: 0 2px;
}
.product-action-style {
    background-color: #fff;
    box-shadow: 0 0 8px 1.7px rgba(0, 0, 0, 0.06);
    display: inline-block;
   padding: 6px 4px 2px;
}
.product-action-style > a {
    color: #979797;
    line-height: 1;
    padding: 0 10px;
    position: relative;
}
.product-action-style > a.action-plus {
    font-size: 25px;
}
.product-action-style > a.action-heart {
    font-size: 16px;
}
.product-action-style > a.action-cart {
    font-size: 20px;
    position: relative;
    top: 2px;
}
.product-action-style > a::before {
    background: #d2d2d2 none repeat scroll 0 0;
    content: "";
    height: 28px;
    position: absolute;
    right: 2px;
    top: 3px;
    width: 1px;
}
.product-action-style > a:last-child::before {
    display: none;
}
.product-img > span {
    background-color: #fff;
    box-shadow: 0 0 8px 1.7px rgba(0, 0, 0, 0.06);
    color: #333;
    display: inline-block;
    font-size: 12px;
    font-weight: 500;
    left: 20px;
    letter-spacing: 1px;
    padding: 3px 12px;
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    top: 20px;
}
.product-img img {
    transition: all 1.5s ease 0s;
    width: 100%;
}
.product-wrapper:hover .product-img img {
    transform: scale(1.2);
}
/* banner style */
.banner-content-5 {
    padding: 20px 100px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}
.banner-content-5 > h4 {
    color: #f3a395;
    font-family: "Painter PERSONAL USE ONLY";
    font-size: 24px;
    margin: 0;
}
.banner-content-5 > h2 {
    color: #444444;
    font-size: 36px;
    line-height: 31px;
    margin: 8px 0 7px;
}
.banner-content-5 > h3 {
    color: #444444;
    font-size: 24px;
    margin-bottom: 39px;
}
.banner-btn {
    color: #414141;
    display: inline-block;
    font-weight: 500;
    position: relative;
}
.banner-btn:hover {
    color: #f3a395;
}
.banner-btn:before {
    background: #414141 none repeat scroll 0 0;
    bottom: -6px;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    transition: all 0.3s ease-in-out 0s;
    width: 100%;
}
.banner-btn:hover:before {
    background: #f3a395 none repeat scroll 0 0;
}
.overflow {
    overflow: hidden;
}
.banner-wrapper.overflow a img,
.banner-img a img {
    transition: all 0.3s ease 0s;
    width: 100%;
}
.banner-wrapper.overflow:hover a img {
    transform: scale(1.1);
}
.banner-img.overflow:hover a img {
    transform: scale(1.05);
}

/* new collection */

.single-new-collection {
    position: relative;
}
.new-collection-content {
    left: 0;
    padding: 41px 20px;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
}
.new-collection-content > h2 {
    color: #5d5d5d;
    font-size: 23px;
    margin-bottom: 14px;
}
.new-collection-content .btn-style {
    padding: 8px 14px;
}
.owl-dots {
    bottom: 0;
    left: 0;
    padding: 15px;
    position: absolute;
    right: 0;
    text-align: center;
}
.new-collection-slider .owl-dot {
    background: #5a5a5a none repeat scroll 0 0;
    border-radius: 50%;
    display: inline-block;
    height: 13px;
    margin: 0 6px;
    width: 13px;
}
.new-collection-slider .owl-dot.active {
    background: #f3a395 none repeat scroll 0 0;
}
/* dealy area*/
.dealy-mrg {
    margin: 0 20px;
}
.dealy-product-content-center {
    align-items: center;
    display: flex !important;
    justify-content: center;
    text-align: center;
}
.dealy-product-content > h3 {
    color: #646464;
    font-size: 30px;
    margin: 0;
}
.dealy-product-content > h3 a {
    color: #646464;
}
.dealy-rating i {
    color: #f3a395;
    font-size: 24px;
    margin: 0 3px;
}
.dealy-price > span {
    color: #646464;
    font-size: 30px;
    font-weight: 500;
    margin: 0 6px;
}
.dealy-price > span.old {
    color: #b3b3b3;
    font-size: 24px;
    font-weight: 400;
    text-decoration: line-through;
}
.dealy-of-product-area {
    padding: 36px 0;
    overflow: hidden;
}
.timer span {
    color: #646464;
    display: inline-block;
    font-size: 48px;
    line-height: 1;
    margin: 0 15px;
    position: relative;
}
.timer span p {
    display: none;
}
.timer span.cdown::before {
    background-color: #646464;
    content: "";
    height: 6px;
    position: absolute;
    right: -19px;
    top: 16px;
    width: 6px;
    z-index: 99;
}
.timer span.cdown::after {
    background-color: #646464;
    bottom: 9px;
    content: "";
    height: 6px;
    position: absolute;
    right: -19px;
    width: 6px;
    z-index: 99;
}
.dealy-rating {
    margin: 13px 0 8px;
}
.timer {
    margin: 24px 0 33px;
}

/* blog */

.blog-padding .container-fluid,
.footer-padding .container-fluid,
.services-padding .container-fluid {
    padding: 0 310px;
}
.hm-blog .row {
    margin-left: -20px;
    margin-right: -20px;
}
.hm-blog .row div[class^="col-"] {
    padding-left: 20px;
    padding-right: 20px;
}
.blog-hm-content > h3 {
    color: #636262;
    font-size: 20px;
    font-weight: 500;
    line-height: 30px;
    margin: 0;
}
.blog-hm-content > h3 a {
    color: #636262;
}
.blog-meta li {
    display: inline-block;
    margin-right: 10px;
    color: #797979;
    font-size: 13px;
    text-transform: capitalize;
}
.blog-meta li a:hover,
.blog-hm-content > h3 a:hover {
    color: #f3a395;
}
.blog-meta li span {
    color: #585858;
    font-weight: 500;
    margin-right: 4px;
}
.blog-meta li:last-child {
    margin-right: 0px;
}
.blog-meta {
    margin: 11px 0 20px;
}
.blog-hm-content > p {
    margin: 0;
}
.blog-img {
    margin-bottom: 31px;
    overflow: hidden;
    position: relative;
}
.blog-img img {
    width: 100%;
}

/* footer */

.footer-widget-title > h3 {
    color: #505050;
    font-weight: 500;
    font-size: 14px;
    text-transform: uppercase;
    margin: 0;
}
.food-address {
    display: flex;
    margin-bottom: 16px;
}
.food-address:last-child,
.quick-link li:last-child,
.single-twitter:last-child {
    margin-bottom: 0px;
}
.food-info-icon i {
    color: #2e2e2e;
    font-size: 20px;
    margin-top: -2px;
    display: inline-block;
}
.food-info-content > p {
    color: #808080;
    line-height: 23px;
    margin: 0;
}
.food-info-content > p a {
    color: #808080;
}
.food-info-icon {
    margin-right: 20px;
}
.quick-link li a {
    color: #808080;
}
.quick-link li {
    margin-bottom: 9px;
}
.single-twitter {
    display: flex;
    margin-bottom: 8px;
}
.twitter-icon {
    margin-right: 20px;
}
.twitter-icon i {
    color: #434444;
    font-size: 20px;
}
.twitter-content > p {
    color: #808080;
    margin: 0;
}
.twitter-content > p a {
    color: #808080;
}
.twitter-content > p a.link1 {
    color: #393939;
}
.twitter-content > p a.link2,
.quick-link li a:hover,
.food-info-content > p a:hover,
.twitter-content > p a:hover {
    color: #f3a395;
}
.twitter-content > p a.link2:hover {
    color: #333;
}
.footer-widget-title {
    margin-bottom: 1px;
}
.copyright > p {
    margin: 0;
    color: #767676;
    margin-top: 3px;
}
.copyright > p a {
    color: #555;
}
.copyright > p a:hover {
    color: #f3a395;
}
.footer-payment-method {
    margin-top: 2px;
    float: right;
}

/* modal style */

.modal-body {
    display: flex;
    justify-content: space-between;
   /* padding: 50px;*/
}
.modal-dialog {
    margin: 21px auto;
    min-width: 878px;
}
.quick-view-tab-content .tab-pane > img {
    width: 100%;
}
.quick-view-list {
    margin-top: 10px;
}
.quick-view-list a {
    margin-right: 10px;
    margin-bottom: 10px;
}
.quick-view-list a:last-child {
    margin-right: 0px;
}
.qwick-view-left {
    flex: 0 0 320px;
    margin-right: 30px;
}
.quick-view-tab-content .tab-pane > img {
    flex: 0 0 320px;
}
.quick-view-list a img {
    flex: 0 0 100px;
}
.modal-content {
    border-radius: 0rem;
}
.qwick-view-content > h3 {
    color: #646464;
    font-size: 20px;
    font-weight: 500;
    margin: 0;
}
.price span {
    color: #707070;
    font-size: 18px;
    font-weight: 400;
}
.price span.new {
    color: #ff5112;
    margin-right: 12px;
}
.price span.old {
    color: #707070;
    text-decoration: line-through;
}
.quick-view-rating i {
    color: #000000;
    font-size: 18px;
    margin-right: 5px;
}
.quick-view-rating i.red-star {
    color: #ffc800;
}
.rating-number {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 9px;
}
.quick-view-number > span {
    color: #808080;
    display: block;
    font-size: 14px;
    margin: 3px 0 0 10px;
}
.qwick-view-content > p {
    color: #807f7f;
    margin-bottom: 25px;
}
.select-option-part label {
    color: #646464;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 14px;
}
.select-option-part {
   margin-bottom: 10px;
}
.select-option-part select {
    -moz-appearance: none;
    -webkit-appearance: none;
    border: 1px solid #dcdcdc;
    box-shadow: none;
        font-weight: 500;
    color: #ffffff;
    background: azure;
    font-size: 16px;
    height: 43px;
    padding: 0px 10px;
    position: relative;
    width: 100%;
    background: rgb(242, 182, 172) url("../../assets/img/icon-img/1.png") no-repeat scroll right 20px center;
}
.qtybutton {
    color: #727272;
    cursor: pointer;
    float: left;
    font-size: 16px;
    font-weight: 600;
    height: 20px;
    line-height: 20px;
    position: relative;
    text-align: center;
    width: 20px;
}
input.cart-plus-minus-box {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    float: left;
    font-size: 16px;
    height: 25px;
    margin: 0;
    padding: 0;
    text-align: center;
    width: 25px;
}
.cart-plus-minus *::-moz-selection {
    background: transparent none repeat scroll 0 0;
    color: #333;
    text-shadow: none;
}
.cart-plus-minus {
    border: 1px solid #dcdcdc;
    overflow: hidden;
    padding: 12px 0 7px 5px;
    width: 80px;
    height: 46px;
}
.quickview-plus-minus {
    display: flex;
    justify-content: flex-start;
    padding-top: 5px;
}

.quickview-btn-cart > a {
    background-color: #ee3333;
    color: #fff;
    display: inline-block;
    font-weight: 600;
    letter-spacing: 0.08px;
    line-height: 1;
    padding: 17px 35px;
    position: relative;
    text-transform: uppercase;
    z-index: 5;
}
/* .quickview-btn-cart > a {
    padding: 14px 35px;
} */
.quickview-btn-wishlist > a {
    border: 1px solid #dcdcdc;
    color: #727272;
    display: inline-block;
    font-size: 22px;
    padding: 7px 18px 5px;
    z-index: 9;
}
.quickview-btn-wishlist > a:hover {
    border: 1px solid transparent;
}
.quickview-btn-wishlist a {
    overflow: hidden;
}
.quickview-btn-cart {
    margin: 0 30px;
}
.qtybutton.inc {
    margin-top: 2px;
}
.price {
    margin: 9px 0 8px;
}
#exampleModal .close,
#exampleCompare .close {
    color: #fff;
    float: right;
    font-size: 50px;
    font-weight: 700;
    line-height: 1;
    opacity: 1;
    position: absolute;
    right: 370px;
    text-shadow: 0 1px 0 #fff;
    top: 32px;
    transition: all .3s ease 0s;
    cursor: pointer;
}
#exampleModal .close:hover,
#exampleCompare .close:hover {
    color: #f3a395;
}
.modal-backdrop.show {
    opacity: 0.8;
}
.modal-content .close:hover {
    color: #f3a395;
}
.modal-open .modal {
    background: rgba(255,255,255, 0.25) !important;
    z-index: 99999;
}
.modal-backdrop.show {
    z-index: 9999;
}

/*---------- 3. Home page 2 ---------*/

/* sidebar menu */
.menu-icon {
    margin-right: 25px;
}
.menu-icon > button {
    border: medium none;
    padding: 0;
    border: 2px solid #878787;
    color: #878787;
    display: inline-block;
    font-size: 22px;
    line-height: 1;
    padding: 0 6px;
    cursor: pointer;
    background-color: transparent;
}
.menu-close {
    position: absolute;
    right: 50px;
    top: 52px;
}
.menu-close button {
    background-color: #f3a395;
    border: medium none;
    color: #fff;
    font-size: 28px;
    line-height: 1;
    padding: 3px 11px;
    cursor: pointer;
}
.menu-close button:hover {
    background-color: #333;
}
.sidebarmenu-wrapper {
    background: #fff none repeat scroll 0 0;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
    height: 100%;
    left: -500px;
    overflow-y: auto;
    padding: 155px 50px 15px 50px;
    position: fixed;
    top: 0;
    transition: all 0.4s ease 0s;
    width: 350px;
    z-index: 9999;
}
.sidebarmenu-style {
    align-items: center;
    display: flex;
}
.sidebarmenu-style nav.menu ul li a {
    color: #797979;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.5px;
    padding: 18px 0;
    text-transform: uppercase;
}
.sidebarmenu-style nav.menu ul li:hover > a {
    color: #f3a395;
}
.sidebarmenu-style nav.menu ul li ul {
    padding-left: 16px;
}
.sidebarmenu-style nav.menu ul li ul li.sub-style a {
    font-weight: 500;
    text-transform: uppercase;
}


.sidebarmenu-style nav.menu ul li ul li a,
.sidebarmenu-style nav.menu ul li ul li.sub-style ul li a {
    font-size: 14px;
    font-weight: 400;
    padding: 8px 0;
    text-transform: capitalize;
    color: #797979;
}
.sidebarmenu-style nav.menu ul li ul li.active a,
.sidebarmenu-style nav.menu ul li ul li.sub-style ul li.active a {
    color: #f3a395;
}
.sidebarmenu-style nav.menu ul li ul li.sub-style ul li a:hover {
    color: #f3a395;
}

.sidebarmenu-style nav.menu ul li ul li.sub-style > a > i {
  margin-left: 5px;
}

.newsletter-title {
    color: #333;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
    position: relative;
    text-transform: uppercase;
}
.newsletter-title p {
    color: #666;
    margin: 0;
}
.newsletter-title::before {
    background-color: #f3a395;
    bottom: -8px;
    content: "";
    height: 2px;
    left: 0;
    position: absolute;
    width: 59px;
}
.newsletter-area {
    margin-top: 35px;
}
.subscribe-form form {
    position: relative;
}
.subscribe-form form input {
    background-color: #f7f7f7;
    border: medium none;
    color: #333;
    font-size: 13px;
/*     font-weight: 400; */
    padding: 0 57px 0 15px;
}
.subscribe-form form input::-moz-placeholder {
    color: #7d7d7d;
    opacity: 1;
}
.mc-form .mc-news {
    left: -5000px;
    position: absolute;
}
.subscribe-form .clear input {
    background-color: #ffb5c0;
    border: medium none;
    padding: 0 15px;
    /* text-indent: -99999px; */
   /*  width: 50px; */
}
.subscribe-form .clear input.button {
    border: medium none;
}
.subscribe-form .clear input:hover {
    background-color: #ffb5c0;
    border-radius: none;
}
.mc-form .clear {
    background-color: #ffb5c0;
    bottom: 0;
    display: inline-block;
    position: absolute;
    right: 0;
   /* z-index: 999999;*/
}
/* .mc-form .clear::before {
    color: #fff;
    content: "ï‘³";
    font-family: "Ionicons";
    font-size: 30px;
    position: absolute;
    right: 16px;
    top: 1px;
    z-index: 9;
    pointer-events: none;
} */
.follow-icon ul li {
    display: inline-block;
    margin-right: 22px;
}
.follow-icon ul li:last-child {
    margin-right: 0px;
}
.follow-icon ul li a {
   display: inline-block;
    font-size: 21px;
    height: 12px;
    line-height: 30px;
    text-align: center;
    width: 30px;
    border-radius: 100%;
    background-color: transparent;
    /*border: 1px solid #f3a395;*/
}
.follow-icon ul li.facebook a:hover {
    background-color: #3b5998;
    color: #fff;
    border: 1px solid #3b5998;
}
.follow-icon ul li.twitter a:hover {
    background-color: #1da1f2;
    color: #fff;
    border: 1px solid #1da1f2;
}

.follow-icon ul li.instagram a:hover {
    background-color: #c32aa3;
    color: #fff;
    border: 1px solid #c32aa3;
}
.follow-icon ul li.tumblr a:hover {
    background-color: #35465d;
    color: #fff;
    border: 1px solid #35465d;
}
.follow-icon {
    margin-top: 29px;
}

/* slider home2 */
.slider-2 {
    padding: 223px 0 164px;
}
.slider-content-2 h5 {
    color: #3e3e3e;
    font-size: 14px;
    margin: 0;
    text-transform: uppercase;
}
.slider-content-2 h2 {
    color: #3e3e3e;
    font-family: "Playfair Display", serif;
    font-size: 72px;
    font-weight: bold;
    line-height: 80px;
    margin: 37px 0 41px;
    text-transform: capitalize;
}
.slider-single-img-2 {
    overflow: hidden;
}
.slider-single-img-2 img {
    padding: 0 34px 0 68px;
}
.menu-icon.menu-icon-none {
    display: none;
}
.stick .menu-icon.menu-icon-none {
    display: block;
}
.stick .menu-icon > button {
    margin-top: 11px;
}
.header-2.stick .sticky-logo {
    padding-top: 0;
}
.header-2.stick .header-site-icon {
    padding-top: 12px;
}

/* banner */

.banner-position-6 {
    bottom: 0;
    left: 0;
    position: absolute;
}
.banner-position-7 {
    padding: 10px;
    position: absolute;
    right: 100px;
    top: 70px;
}
.banner-content-6 > h2 {
    color: #000000;
    font-size: 58px;
    font-weight: 900;
    line-height: 65px;
    margin-bottom: 72px;
    opacity: 0.15;
    text-align: right;
}
.banner-content-6 > a {
    color: #3e3e3e;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0.5px;
    padding-left: 15px;
    position: relative;
}
.banner-content-6 > a:hover {
    color: #f3a395;
}
.banner-content-6 > a::before {
    background-color: #f3a395;
    content: "";
    height: 13px;
    left: 0;
    position: absolute;
    top: 3px;
    width: 4px;
}
.banner-content-6 > h5 {
    color: #f3a395;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 14px;
}
.banner-content-6 > h3 {
    color: #363636;
    font-size: 30px;
    line-height: 40px;
    font-family: 'Playfair Display', serif;
    margin: 0;
    font-weight: 400;
}

/* product2 */

.section-title-2 > h2 {
    color: #292929;
    font-size: 36px;
    font-weight: 500;
    line-height: 29px;
}
.product-padding .container-fluid {
    padding: 0 338px;
}
.product-wishlist {
    position: absolute;
    right: 30px;
    top: 30px;
}
.product-action-2 {
    bottom: 20px;
    display: flex;
    justify-content: center;
    left: 0;
    position: absolute;
    right: 0;
    text-align: center;
    transition: all 0.4s ease 0s;
}
.product-action-2 a {
    background-color: #fff;
    box-shadow: 0 0 8px 1px rgba(0, 0, 0, 0.1);
    color: #666666;
    display: inline-flex;
    height: 44px;
    justify-content: center;
    margin: 0 7.5px;
    padding: 7px 0;
    width: 53px;
    transition: all 0.3s ease 0s;
    transform: scale(0);
}
.product-img .product-action-2 a:nth-child(1) {
    transition: all 0.3s ease .2s;
}
.product-img .product-action-2 a:nth-child(2) {
    transition: all 0.4s ease 0.3s;
}
.product-img .product-action-2 a:nth-child(3) {
    transition: all 0.5s ease 0.4s;
}
.product-wrapper:hover .product-img .product-action-2 a {
    transform: scale(1);
}
.product-action-2 a:hover {
    background-color: #f3a395;
    color: #fff;
}
.product-action-2 a.action-plus-2 {
    font-size: 18px;
}
.product-action-2 a.action-cart-2 {
    font-size: 20px;
}
.product-action-2 a.action-reload {
    font-size: 17px;
}
.product-action-2 a i {
    display: block;
    line-height: 30px;
}
.product-price-2 > span {
    color: #646464;
    display: block;
    font-size: 16px;
    margin-top: 8px;
}
.product-wishlist > a {
    color: #000000;
    font-size: 16px;
}
.product-wishlist > a:hover {
    color: #f3a395;
}
.banner-content-7 {
    left: 0;
    position: absolute;
    right: 0;
    text-align: center;
    top: 50%;
    transform: translateY(-50%);
}
.banner-content-7 > img {
    transition: all 0.3s ease 0s;
}
.banner-content-7 > h2 {
    color: #ffffff;
    font-size: 48px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 20px 0 27px;
}
.banner-btn-2 {
    background-color: #fff;
    border-radius: 50px;
    color: #3e3e3e;
    display: inline-block;
    font-size: 16px;
    font-weight: 500;
    padding: 8px 24px 10px;
    position: relative;
    overflow: hidden;
}
.banner-btn-2:hover {
    color: #fff;
}
.section-title-2 > p {
    color: #707070;
    font-size: 16px;
    margin: 0;
}
.testimonials-area .container-fluid {
    padding: 0px 30px;
}
.single-testimonial > p {
    color: #666666;
    line-height: 30px;
    margin: 32px auto 0;
    width: 51%;
}
.single-testimonial > h4 {
    color: #666666;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 1.5px;
    margin-bottom: 5px;
    text-transform: uppercase;
}
.single-testimonial > span {
    color: #747171;
    font-size: 14px;
    font-weight: 400;
}
.testimonial-icon {
    margin: 25px 0 24px;
}
.testimonial-icon i {
    color: #666666;
    font-size: 26px;
}
.owl-carousel .owl-item .single-testimonial img {
    display: block;
    margin: 0 auto;
    width: auto;
}
.testimonial-active {
    position: relative;
}
.testimonial-active.owl-carousel .owl-nav div {
    left: 300px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #8d8c8c;
    opacity: 0;
    transition: all .3s ease 0s;
}
.testimonial-active.owl-carousel .owl-nav div:hover {
    color: #000;
}
.testimonial-active:hover .owl-nav div {
    opacity: 1;
}
.testimonial-active.owl-carousel .owl-nav div.owl-next {
    left: auto;
    right: 300px;
}

/* services h2 */

.services-wrapper {
    display: flex;
    justify-content: space-between;
}
.single-services {
    display: flex;
}
.services-icon {
    margin-right: 20px;
}
.services-text > h5 {
    color: #4f4e4e;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 6px;
}
.services-text > p {
    color: #4f4e4e;
    font-weight: 500;
    line-height: 24px;
    margin: 0;
}
a.cr-btn b,
button.cr-btn b {
    background: rgba(25, 25, 25, 1) none repeat scroll 0 0;
    border-radius: 50%;
    bottom: 0;
    display: block;
    height: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease-in-out 0s, height 0.6s ease-in-out 0s;
    width: 0;
    z-index: 1;
}
a.cr-btn:hover b,
button.cr-btn:hover b {
    height: 500px;
    width: 500px;
}
.btn-style:hover {
    border: 0px solid #f3a395;
    color: #ffffff;
}
/* Compare style */

.modal-compare-width {
    max-width: 900px;
}
.table-content.compare-style th a span {
    color: #050035;
    display: inline-block;
    font-weight: 600;
    line-height: 0.81em;
    margin: 0;
    text-align: center;
}
.table-content.compare-style th p {
    color: #383838;
    font-size: 16px;
    margin: 0;
    text-transform: capitalize;
}
.table-content.compare-style th a {
    text-transform: capitalize;
    font-size: 14px;
    color: #333;
}
.table-content.compare-style th a:hover {
    color: #f3a395;
}
.table-content.compare-style th a span {
    color: #050035;
    display: inline-block;
    font-size: 1em;
    font-weight: 600;
    line-height: 0.81em;
}
.table-content.compare-style th img {
    display: block;
    margin: 20px 0;
}
.table-content.table-responsive.compare-style tbody tr,
.table-content.table-responsive.compare-style thead {
    border-bottom: 1px solid #f1f1f1;
}
.table-content.table-responsive.compare-style tbody tr:last-child {
    border-bottom: 0px solid #f1f1f1;
}
.table-content.compare-style thead {
    background-color: transparent;
}
.table-content.compare-style table {
    text-align: inherit;
}
.table-content.compare-style table th {
    padding: 14px 0;
    text-align: inherit;
}
.table-content table td.compare-title h4 {
    border-top: medium none;
    color: #333333;
    font-size: 13px;
    font-weight: 400;
    margin: 0;
    min-width: 205px;
    overflow: hidden;
    text-align: left;
    text-transform: uppercase;
    vertical-align: middle;
}
.table-content table td.compare-common,
.table-content table td.compare-title {
    font-size: 14px;
    padding: 14px 0;
}
.table-content.compare-style table td p {
    margin: 0;
}
.table-content.compare-style th a.compare-btn {
    color: #383838;
    font-size: 14px;
    text-transform: capitalize;
}
.table-content.compare-style th a.compare-btn:hover {
    color: #050035;
}
.table-content.compare-style th span {
    display: block;
    margin: 10px 0;
}
.table-content.compare-style table {
    margin: 0 0 0px;
}
.modal .close {
    color: grey;
    float: right;
      right: 15px;
    bottom: 15px;
    position: relative;
    font-weight: bold;
    line-height: 1;
    margin-right: 0px;
    opacity: 1;
    text-shadow: 0 1px 0 #fff;
}
.table-content.compare-style table thead tr {
    border-bottom: medium none;
}



/*------- 4. Home page 3 -----------*/

.header-height {
    min-height: 116px;
}
.banner-padding .container-fluid,
.hm-3-padding .container-fluid {
    padding: 0 310px
}

.slider-banner-wrapper img {
    width: 100%;
}

.slider-banner-wrapper {
    position: relative;
}
.slider-banner-content1 {
    left: 40px;
    padding: 10px;
    position: absolute;
    top: 40px;
}
.slider-banner-content1 > h5 {
    color: #f3a395;
    font-size: 16px;
    font-weight: 500;
    text-transform: uppercase;
    margin: 0;
}
.slider-banner-content2 > h5 {
    color: #f3a395;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    margin: 0;
}
.slider-banner-content1 > h3 {
    color: #363636;
    font-family: "Playfair Display", serif;
    font-size: 36px;
    line-height: 48px;
    margin: 25px 0 37px;
}
.slider-banner-content2 > h3 {
    color: #363636;
    font-family: "Playfair Display", serif;
    font-size: 30px;
    line-height: 40px;
    margin: 11px 0 17px;
}
.slider-banner-content3 > h3 {
    color: #363636;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    line-height: 31px;
    margin: 0;
}
.slider-banner-btn {
    border-radius: 50px;
    padding: 10px 25px 12px;
    text-transform: capitalize;
}
.slider-banner-btn2 {
    border-radius: 50px;
    padding: 7px 15px 9px;
    text-transform: capitalize;
}
.slider-banner-content2 {
    left: 20px;
    padding: 10px;
    position: absolute;
    top: 20px;
}
.slider-banner-content3 {
    bottom: 20px;
    left: 20px;
    padding: 10px;
    position: absolute;
}
.banner-padding .row {
    margin-left: -7.5px;
    margin-right: -7.5px;
}
.banner-padding .col-lg-5,
.banner-padding .col-lg-6,
.banner-padding .col-lg-7,
.banner-padding .col-lg-4 {
    padding-left: 7.5px;
    padding-right: 7.5px;
}
.slider-banner-wrapper > a::before,
.blog-img > a::before {
    background: rgba(255, 255, 255, 0.3) none repeat scroll 0 0;
    bottom: 0;
    content: "";
    left: 50%;
    opacity: 1;
    position: absolute;
    right: 51%;
    top: 0;
}
.slider-banner-wrapper > a::after,
.blog-img > a::after {
    background: rgba(255, 255, 255, 0.3) none repeat scroll 0 0;
    bottom: 50%;
    content: "";
    left: 0;
    opacity: 1;
    position: absolute;
    right: 0;
    top: 50%;
}
.slider-banner-wrapper:hover a::after,
.blog-hm-wrapper:hover .blog-img > a::after {
    bottom: 0;
    opacity: 0;
    top: 0;
    transition: all 500ms ease-in 0s;
}

.slider-banner-wrapper:hover a::before,
.blog-hm-wrapper:hover .blog-img > a::before {
    left: 0;
    opacity: 0;
    right: 0;
    transition: all 900ms ease-in 0s;
}


/* product-area home 3 */

.price-decrease {
    left: 0;
    position: absolute;
    top: 0;
    padding: 20px;
}
.price-decrease > span {
    background-color: #f3a395;
    color: #fff;
    display: inline-block;
    font-size: 14px;
    padding: 1px 10px;
    text-transform: uppercase;
}
.product-action-3 {
    background-color: #f3a395;
    bottom: 0;
    left: 0;
    padding: 7px 15px 8px;
    position: absolute;
    right: 0;
    text-align: center;
    transform: translateY(15px);
    transition: all 0.4s ease-in-out 0s;
    opacity: 0;
}
.product-action-3:hover {
    background-color: #000;
}
.product-wrapper:hover .product-action-3 {
    opacity: 1;
    transform: translateY(0px);
}
.product-action-3 a {
    color: #fff;
}
.product-action-3 a i {
    color: #ffffff;
    font-size: 16px;
    margin-right: 7px;
    position: relative;
    top: 2px;
}
.product-title-wishlist {
    display: flex;
    justify-content: space-between;
}
.product-title-3 > h4 {
    color: #646464;
    font-size: 16px;
    margin-bottom: 13px;
}
.product-title-3 > h4 a {
    color: #646464;
}
.product-wishlist-3 > a {
    color: #000000;
    font-size: 14px;
    margin-right: 1px;
}
.product-peice-3 > span {
    color: #646464;
    font-size: 14px;
    font-weight: 500;
    margin-right: 6px;
}
.product-peice-3 > span.old {
    color: #7a7a7a;
    display: inline-flex;
    font-size: 14px;
    font-weight: 400;
    text-decoration: line-through;
}
.product-addtocart > a {
    color: #646464;
    font-size: 14px;
}
.product-title-3 > h4 a:hover,
.product-addtocart > a:hover,
.product-wishlist-3 > a:hover {
    color: #f3a395;
}
.product-addtocart > a i {
    margin-right: 8px;
}
.product-peice-addtocart {
    margin-bottom: 2px;
    position: relative;
}
.product-addtocart {
    left: 0;
    position: absolute;
    top: 0;
    opacity: 0;
    transform: translateY(15px);
    transition: all 0.4s ease-in-out 0s;
}
.product-wrapper:hover .product-addtocart {
    opacity: 1;
    transform: translateY(0px);
}
.product-peice-3 {
    transition: all .3s ease 0s;
    transform: translateY(0px);
    transition: all 0.4s ease-in-out 0s;
    opacity: 1;
}
.product-wrapper:hover .product-peice-3 {
    opacity: 0;
    transform: translateY(-15px);
}
.product-area-3 .row {
    margin-left: -10px;
    margin-right: -10px;
}
.product-area-3 .col-lg-3 {
    padding-left: 10px;
    padding-right: 10px;
}
.section-title-3 h2 {
    color: #363636;
    font-size: 48px;
    position: relative;
    font-family: "Playfair Display", serif;
}
.section-title-3 h2::before {
    background-color: #363636;
    content: "";
    height: 2px;
    left: 0px;
    position: absolute;
    bottom: -31px;
    transition: all 0.4s ease 0s;
    width: 163px;
    right: 0;
    margin: 0 auto;
}
.h3-services .row {
    margin-left: -10px;
    margin-right: -10px;
}
.h3-services .row div[class^="col-"] {
    padding-left: 10px;
    padding-right: 10px;
}
.h3-services .single-services.orange {
    padding: 33px 27px;
}
.h3-services .single-services.yellow {
    padding: 33px 18px;
}
.h3-services .single-services.purple {
    padding: 33px 20px;
}
.h3-services .single-services.sky {
    padding: 33px 38px;
}
.orange {
    background-color: #fcedda;
}
.yellow {
    background-color: #f2fbcb;
}
.purple {
    background-color: #f7d8f9;
}
.sky {
    background-color: #dbfafe;
}
.single-services:hover .services-icon img {
    animation: 500ms ease-in-out 0s normal none 1 running zoomIn;
}
.overview-content > h2 {
    color: #494949;
    font-size: 36px;
    line-height: 45px;
    font-family: "Playfair Display", serif;
    margin: 0;
}
.overview-content > h3 {
    color: #494949;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    line-height: 30px;
    margin: 27px 0 34px;
}
.btn-style.overview-btn.cr-btn {
    border-radius: 50px;
    padding: 12px 25px;
    text-transform: capitalize;
}
.zoom-out {
    overflow: hidden;
    position: relative;
    transition: all 0.3s ease 0s;
}
.zoom-img > img {
    display: block;
    transition: all 0.5s ease-out 0s;
    width: 100%;
}
.zoom-out .zoom-img img:last-child {
    left: 0;
    opacity: 0;
    position: absolute;
    top: 0;
    transform: scale(1.5);
    visibility: hidden;
}
.overview-wrapper:hover .zoom-img img {
    opacity: 1;
    transform: scale(1);
    visibility: visible;
}
.overview-img img {
    width: 100%;
}
.zoom-out {
    margin: 0 42px 0 103px;
}
.overview-content {
    margin-top: 9px;
}

/*--------- 5. Home page 4 ----------*/

.hm-4-padding .container-fluid {
    padding: 0 60px;
}
.align-item {
    align-items: center;
}
.product-img-4 img {
    width: 100%;
}
.product-img-4 {
    position: relative;
}
.product-action-4 {
    display: flex;
    justify-content: center;
    left: 0;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%) scale(0);
    transition: all .6s ease 0s;
}
.product-content-5 {
    bottom: 0;
    left: 0;
    opacity: 0;
    padding: 20px 30px;
    position: absolute;
    transition: all 0.6s ease 0s;
    width: 100%;
}
.product-wrapper:hover .product-content-5 {
    opacity: 1;
}
.product5-title > h4 a {
    color: #646464;
}
.product5-title > h4 a:hover,
.product5-wishlist > a:hover {
    color: #f3a395;
}
.product5-price-wishlist {
    display: flex;
    justify-content: space-between;
}
.product5-title > h4 {
    color: #646464;
    font-size: 16px;
    margin-bottom: 14px;
    transform: translateX(-20px);
    transition: all 0.6s ease-in-out 0s;
}
.product5-price > span {
    color: #646464;
    font-weight: 500;
    transform: translateX(-20px);
    transition: all 0.6s ease-in-out 0s;
    display: block;
}
.product5-wishlist > a {
    color: #000000;
    font-size: 18px;
    transform: translateX(20px);
    transition: all 0.6s ease-in-out 0s;
    display: block;
}
.product-wrapper:hover .product5-title > h4,
.product-wrapper:hover .product5-price > span,
.product-wrapper:hover .product5-wishlist > a {
    transform: translateX(0px);
}
.product-action-4 a {
    background-color: #414141;
    box-shadow: 0 0 8px 1px rgba(0, 0, 0, 0.1);
    color: #fff;
    display: inline-flex;
    height: 46px;
    justify-content: center;
    margin: 0 7.5px;
    transition: all 0.3s ease 0s;
    width: 46px;
    border-radius: 50px;
}
.product-action-4 a:hover {
    background-color: #f3a395;
}
.product-action-4 a.action-plus-2,
.product-action-4 a.action-cart-2 {
    font-size: 18px;
}
.product-action-4 a.action-reload {
    font-size: 17px;
}
.product-action-4 a i {
    display: block;
    line-height: 46px;
}
.product-shadow {
    transition: all .3s ease 0s;
}
.product-shadow:hover {
    box-shadow: 0 7px 18px 1px rgba(0, 0, 0, 0.05);
}
.product-shadow:hover .product-action-4 {
    transform: translateY(-50%) scale(1);
}
.product-content-4 {
    bottom: 0;
    padding: 95px 100px;
    position: absolute;
    right: 0;
}
.product-content-4.product-content-4-left {
    left: 0;
}
.product-content-4 > h3 {
    color: #ffffff;
    font-size: 24px;
    font-family: 'Painter PERSONAL USE ONLY';
    margin: 0;
}
.product-content-4 > h2 {
    color: #ffffff;
    font-family: "Playfair Display", serif;
    font-size: 36px;
    margin: 3px 0 9px;
}
.product-content-4 > h4 {
    color: #fff;
    font-family: "Playfair Display", serif;
    font-size: 20px;
    margin-bottom: 30px;
}
.product4-btn.btn-style {
    border-radius: 50px;
    padding: 13px 32px 12px;
    cursor: pointer;
}
.footer-flex {
    display: flex;
    justify-content: space-between;
}
.product-wrapper.product-shadow img {
    width: 100%;
}
.hidden {
    display: none;
}
.view-more .btn-style.cr-btn {
    border-radius: 50px;
    padding: 13px 33px;
}
.view-more .btn-style.cr-btn span i {
    font-size: 14px;
    margin-right: 7px;
    position: relative;
    top: 1px;
}

/*-------- 6. About us ----------*/

.breadcrumb-content > h2 {
    color: #353535;
    font-size: 30px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: capitalize;
}
.breadcrumb-content li {
    color: #353535;
    display: inline-block;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 0.1px;
    text-transform: uppercase;
}
.breadcrumb-content li a {
    color: #353535;
    padding-right: 10px;
    position: relative;
}
.breadcrumb-content li a:hover {
    color: #f3a395;
}
.breadcrumb-content li a::after {
    background-color: #4b4b4b;
    content: "";
    height: 1px;
    position: absolute;
    right: -3px;
    top: 7px;
    transform: rotate(-71deg);
    width: 12px;
}
.breadcrumb-content {
    padding: 32px 0 35px;
}
.about-us-title > h3 {
    color: #5a5a5a;
    font-size: 24px;
    font-weight: 500;
    letter-spacing: 0.4px;
    line-height: 36px;
    margin: 0;
}
.about-us-details > p {
    margin: 0;
}
.about-us-details > p.about-us-pera-mb {
    margin: 0 0 20px;
}
.team-content > h4 {
    color: #292929;
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 3px;
}
.team-content > span {
    color: #292929;
}
.team-content {
    padding-top: 26px;
}
.team-img > img {
    width: 100%;
}
.team-area .row {
    margin-left: -10px;
    margin-right: -10px;
}
.team-area .row div[class^="col-"] {
    padding-left: 10px;
    padding-right: 10px;
}
.team-img img {
    transition: all 0.4s ease 0s;
}
.team-wrapper:hover .team-img img {
    filter: grayscale(100%);
    transition: all 0.4s ease 0s;
}
.single-logo {
    display: flex;
    justify-content: center;
}
.brand-logo-active.owl-carousel .owl-item img {
    width: auto;
	height: 40px;
}
.subscribe-form {
	padding: 10px 1px 0px;
	
	
}
.span_newsletter{
	font-weight: 900;
    color: white;
}
/*-------- 7. Contact page ----------*/

#map {
    height: 500px;
    width: 100%;
}
.contact-title {
    color: #505050;
    font-size: 16px;
    font-weight: 500;
    position: relative;
    margin-bottom: 40px;
}
.contact-title::before {
    background-color: #f3a395;
    bottom: -8px;
    content: "";
    height: 2px;
    left: 0;
    position: absolute;
    width: 59px;
}
.contact-form-style > input {
    background-color: #f7f7f7;
    border: none;
    font-weight: 500;
    font-size: 12px;
    color: #7d7d7d;
    padding: 0 15px;
    height: 50px;
}
.contact-form-style > textarea {
    background-color: #f7f7f7;
    border: medium none;
    color: #7d7d7d;
    font-size: 12px;
    font-weight: 500;
    height: 190px;
    padding: 20px 15px;
}
.contact-form-style > input::-moz-placeholder,
.contact-form-style > textarea::-moz-placeholder {
    color: #7d7d7d;
    opacity: 1;
}
.contact-form-style > input::-webkit-placeholder,
.contact-form-style > textarea::-webkit-placeholder {
    color: #7d7d7d;
    opacity: 1;
}

.contact-form-style button {
    border: medium none;
    padding: 12px 32px;
    margin-top: 40px;
    cursor: pointer;
}
.communication-info {
    background-color: #f7f7f7;
    margin-right: 80px;
    padding: 54px 35px;
}
.single-communication {
    display: flex;
    margin-bottom: 37px;
}
.single-communication:last-child {
    margin-bottom: 0px;
}
.communication-icon i {
    border: 1px solid #ea000d;
    border-radius: 50%;
    color: #ea000d;
    font-size: 24px;
    height: 66px;
    line-height: 66px;
    text-align: center;
    width: 66px;
}
.communication-icon i {
    border: 1px solid #f3a395;
    border-radius: 50%;
    color: #f3a395;
    display: inline-block;
    font-size: 18px;
    height: 47px;
    line-height: 47px;
    text-align: center;
    width: 47px;
    transition: all .3s ease 0s;
}
.communication-icon {
    margin-right: 15px;
}
.communication-text > h4 {
    font-size: 15px;
    color: #505050;
    font-weight: 500;
    margin-bottom: 5px;
}
.communication-text > p {
    color: #666;
    margin: 0;
    font-size: 14px;
}
.communication-text > p a {
    color: #666;
}
.communication-text > p a:hover {
    color: #f3a395;
}
.single-communication:hover .communication-icon i {
    background-color: #f3a395;
    color: #fff;
}
.contact-message p{
  margin-top: 10px;
  margin-bottom: 0;
  color: #555;
}



/*------------ 8. Shop page -----------*/

.shop-topbar-wrapper {
    border-bottom: 1px solid #f1f1f1;
    display: flex;
    justify-content: space-between;
    margin-bottom: 31px;
    padding-bottom: 18px;
}
.view-mode > li {
    display: inline-block;
    margin-right: 20px;
}
.view-mode > li a {
    font-size: 30px;
}
.view-mode > li.active a {
    color: #f3a395;
}
button.product-filter-toggle {
    background-color: transparent;
    border: medium none;
    cursor: pointer;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-top: 11px;
    padding: 0;
    text-transform: uppercase;
}
.product-filter-wrapper {
    background-color: #fff;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
    display: none;
    margin-bottom: 40px;
    padding: 45px 45px 12px;
    width: 100%;
}
.product-filter h5 {
    color: #666;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-bottom: 13px;
    padding-bottom: 7px;
    position: relative;
    text-transform: uppercase;
}
.product-filter h5::before {
    background-color: #000;
    bottom: 0;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    width: 25px;
}
.sort-by li a {
    color: #666;
    display: inline-block;
    font-size: 14px;
    line-height: 25px;
    text-transform: capitalize;
}
.color-filter li a {
    color: #666;
    display: inline-block;
    font-size: 14px;
    line-height: 25px;
    text-transform: capitalize;
}
.color-filter li a i {
    border-radius: 50%;
    display: block;
    float: left;
    height: 10px;
    margin-right: 11px;
    margin-top: 7px;
    width: 10px;
}
.product-tags a {
    color: #666;
    font-size: 14px;
    line-height: 25px;
    margin-right: 8px;
    text-transform: capitalize;
}
#price-range {
    background-color: #c0c0c0;
    border: medium none;
    border-radius: 0;
    float: left;
    height: 3px;
    margin-top: 14px;
    width: 100%;
}
.ui-slider .ui-slider-range {
    background-position: 0 0;
    border: 0 none;
    display: block;
    font-size: 0.7em;
    position: absolute;
    z-index: 1;
}
.ui-slider-horizontal .ui-slider-range {
    height: 100%;
    top: 0;
}
#price-range .ui-slider-range {
    background-color: #f3a395;
    border-radius: 0;
}
#price-range .ui-slider-handle {
    background-color: #f3a395;
    border: medium none;
    border-radius: 50%;
    height: 10px;
    top: -4px;
    transition: none 0s ease 0s;
    width: 10px;
}
.price-values {
    float: left;
    margin-top: 9px;
    width: 100%;
}
.price-values span {
    color: #666;
    display: block;
    float: left;
    font-size: 14px;
    line-height: 23px;
    margin-right: 6px;
}
.price-values input {
    border: medium none;
    color: #666;
    display: block;
    font-size: 14px;
    height: 23px;
    line-height: 23px;
    padding: 0;
    width: 90px;
    background: transparent;
}
.sort-by li a:hover,
.color-filter li a:hover,
.product-tags a:hover,
button.product-filter-toggle:hover,
.product-list-details > h2 a:hover {
    color: #f3a395;
}
.product-list .product-width {
    flex: 0 0 100%;
    max-width: 100%;
}
.product-list .product-img {
    margin-right: 30px;
    width: 310px;
    float: left;
    display: inline-block;
}
.product-list .product-content {
    display: none;
}
.product-list-details {
    display: none;
}
.product-list .product-list-details {
    display: block;
    overflow: hidden;
}
.product-list-details > h2 {
    color: #646464;
    font-size: 24px;
    margin-bottom: 5px;
}
.product-list-details > h2 a {
    color: #646464;
}
.product-list-details > p {
    color: #666666;
    display: block;
    margin: 18px 0 25px;
}
.shop-list-cart > a {
    border: 1px solid #f3a395;
    color: #333;
    display: inline-block;
    font-size: 14px;
    padding: 10px 20px 8px;
}
.shop-list-cart > a:hover {
    color: #fff;
    background-color: #f3a395;
}

.shop-list-cart > a i {
    margin-right: 8px;
}

/* shop list */

.product-list.product-list-width-2 .product-width {
    flex: 0 0 50%;
    max-width: 50%;
}
/* shop list */
.product-list.product-list-width-3 .product-width {
    flex: 0 0 33.333%;
    max-width: 33.333%;
}
.product-list-width-3 .product-list-details > h2 {
    font-size: 20px;
}
/* pagination */
.pagination-style li {
    display: inline-block;  padding: 4px;    border-radius: 4px;
   
}
.pagination-style li a {
        border: 1px solid pink;
    color: #333;
    font-size: 16px;
    font-weight: bold;
     padding:10px 15px;
}
.pagination-style li a:hover,
.pagination-style li a.active {
    color: #f3a395;
    background: grey;
}


/*------- 9. Product details ---------*/

.product-details-large .easyzoom > a img {
    width: 100%;
}
.product-dec-slider.owl-carousel .owl-nav div {
    background-color: #fff;
    border-radius: 50px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    color: #8d8c8c;
    display: inline-block;
    font-size: 13px;
    height: 35px;
    left: -15px;
    line-height: 37px;
    opacity: 0;
    position: absolute;
    text-align: center;
    top: 50%;
    transform: translateY(-50%);
    transition: all 0.3s ease 0s;
    width: 35px;
}
.product-dec-slider.owl-carousel .owl-nav div:hover {
    background-color: #f3a395;
    color: #fff;
}
.product-dec-slider.owl-carousel .owl-nav div.owl-next {
    left: auto;
    right: -15px;
}
.product-dec-slider:hover .owl-nav div {
    opacity: 1;
}
.product-dec-slider .owl-dots {
    display: none
}
.product-details-content h2 {
    color: #646464;
    font-size: 24px;
    font-weight: 500;
    margin: 0;
}
.pd-sub-title {
    color: #333;
    display: block;
    font-size: 16px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    position: relative;
}
.pd-sub-title::before {
    background-color: #9d9d9d;
    bottom: 0;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    width: 30px;
}
.product-overview > p {
    margin: 0;
}
.product-overview {
    margin: 30px 0;
}
.product-size ul li,
.product-share ul li {
    /*display: inline-block;*/
}
.product-size ul li a,
.product-share ul li a {
    background-color: transparent;
    border: 1px solid #b6b6b6;
    border-radius: 50%;
    color: #777;
    display: block;
    float: left;
    font-size: 13px;
    height: 31px;
    line-height: 29px;
    margin-right: 11px;
    margin-top: 5px;
    text-align: center;
    text-transform: uppercase;
    width: 31px;
}
.product-size ul li a:hover,
.product-share ul li a:hover {
    background-color: #f3a395;
    border: 1px solid #f3a395;
    color: #fff;
}
.product-color {
    overflow: hidden;
}
.product-color > ul li {
    border-radius: 50px;
    cursor: pointer;
    display: block;
    float: left;
    height: 21px;
    margin-right: 15px;
    text-indent: -9999px;
    transition: all 0.4s ease 0s;
    width: 21px;
}
.product-color > ul li.red {
    background: #ff4136 none repeat scroll 0 0;
}
.product-color > ul li.pink {
    background: #ff01f0 none repeat scroll 0 0;
}
.product-color > ul li.blue {
    background: #3649ff none repeat scroll 0 0;
}
.product-color > ul li.sky2 {
    background: #00c0ff none repeat scroll 0 0;
}
.product-color > ul li.green {
    background: #00ffae none repeat scroll 0 0;
}
.product-color > ul li.purple2 {
    background: #8a00ff none repeat scroll 0 0;
}
.product-color {
    margin: 31px 0 35px;
    overflow: hidden;
}
.product-categories li,
.product-details-tags li {
    display: inline-block;
    margin-right: 10px;
}
.product-categories li a,
.product-details-tags li a {
    color: #666;
    text-transform: capitalize;
}
.product-categories li a:hover,
.product-details-tags li a:hover {
    color: #f3a395;
}
.product-categories {
    margin: 30px 0 34px;
}
.product-share {
    margin-top: 5px;
}
.product-rating > span {
    color: #666;
}
.product-details .easyzoom > a img {
    width: 100%;
}
.product-gallery .row {
    margin-left: -10px;
    margin-right: -10px;
}
.product-gallery .row div[class^="col-"] {
    padding-left: 10px;
    padding-right: 10px;
}
.bundle-area > h3 {
    color: #707070;
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 15px;
}
.bundle-area > p {
    margin: 0;
}
.bundle-img {
    display: flex;
    margin: 34px 0 35px;
}
.single-bundle-img {
    cursor: pointer;
    margin-right: 11px;
    position: relative;
}
.single-bundle-img::before {
    background: rgba(0, 0, 0, 0.15) none repeat scroll 0 0;
    bottom: 0;
    content: "";
    left: 0;
    opacity: 0;
    pointer-events: none;
    position: absolute;
    right: 0;
    top: 0;
    transition: all 400ms ease-in 0s;
}
.single-bundle-img:hover::before {
    opacity: 1;
}
.single-bundle-img a img {
    width: 100%;
}
.bundle-price ul li {
    color: #525252;
    font-size: 14px;
    margin-bottom: 10px;
    padding-left: 20px;
    position: relative;
}
.bundle-price ul li::before {
    color: #727272;
    content: "ï´";
    font-family: "Ionicons";
    font-size: 14px;
    left: 0;
    position: absolute;
    text-indent: inherit;
    top: 0;
}
.bundle-price ul li span {
    position: relative;
}
.bundle-price ul li span::before {
    background: #7d7d7d none repeat scroll 0 0;
    bottom: 9px;
    content: "";
    height: 1px;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    width: 32px;
}
.bundle-price ul li:last-child {
    margin-bottom: 0;
}
.bundle-result {
    margin-top: 32px;
}
.bundle-result > h4 {
    color: #333;
    font-size: 16px;
    font-weight: 400;
}
.bundle-result > h4 span {
    color: #747373;
    font-weight: 400;
}
.bundle-result > h4 span .bundle-cross {
    position: relative;
}
.bundle-result > h4 span .bundle-cross::before {
    background: #9f9e9e none repeat scroll 0 0;
    bottom: 10px;
    content: "";
    height: 1px;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    width: 45px;
}
.quickview-btn-cart.bundle-cart {
    display: block;
    line-height: 1;
    margin: 37px 0 0;
}

/*----------------------
    10. Shopping cart
----------------------*/
.shopping-cart-area {
    border-bottom: 1px solid #ddd;
}
.shopping-cart-area .breadcrumb {
    padding: 30px 0;
}
.shopping-cart-area .breadcrumb li a {
    color: #bdbdbd;
    transition: all 0.3s ease 0s;
}
h1.cart-heading {
    color: #252525;
    font-size: 25px;
    margin-bottom: 25px;
    text-transform: uppercase;
}
.cart-title-area {
    padding-top: 30px;
}
.car-header-title h2 {
    font-size: 20px;
    margin: 0;
    text-transform: uppercase;
}
.table-content table {
    width: 100%;
}
.wishlist .table-content table {
    margin: 0 0 0px;
}
.table-content.wish table {
    margin: 0 0 0px;
}
.table-content table thead tr {
    border-bottom: 3px solid #e1e1e1;
}
.table-content table th {
    border-top: medium none;
    color: #444;
    font-size: 18px;
    font-weight: 400;
    padding: 0px 10px 12px;
    text-transform: capitalize;
}
.table-content table td {
    padding: 30px 10px 0;
}
.table-content table td input {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: #f7f7f7 none repeat scroll 0 0;
    border-color: currentcolor #ebebeb currentcolor currentcolor;
    border-image: none;
    border-radius: 0;
    border-style: none solid none none;
    border-width: medium 1px medium medium;
    color: #3f3f3f;
    font-size: 14px;
    font-weight: normal;
    height: 45px;
    padding: 0;
    text-align: center;
    width: 75px;
}
.pro-details-quantity .pro-qty .qtybtn.inc {
    background-color: #f7f7f7;
    cursor: pointer;
    display: block;
    left: 70px;
    padding: 14px 0 0;
    position: absolute;
    text-align: center;
    top: 0;
    width: 55px;
    z-index: 9999;
}
.pro-details-quantity .pro-qty .qtybtn i {
    color: #3f3f3f;
    font-size: 12px;
}
.pro-details-quantity .pro-qty .qtybtn.dec {
    background-color: #f7f7f7;
    bottom: 0;
    cursor: pointer;
    display: block;
    left: 70px;
    padding: 0 0 10px;
    position: absolute;
    text-align: center;
    width: 55px;
    z-index: 9999;
}
.pro-qty {
    position: relative;
}
.table-content table td.product-subtotal.product-subtotal {
    width: 120px;
}
.table-content table td.product-subtotal {
    width: 120px;
}
.table-content table td.product-name a {
    color: #444;
    display: block;
    font-size: 15px;
    margin-bottom: 10px;
    text-transform: capitalize;
}
.table-content table td.product-name > span {
    color: #444;
    letter-spacing: 1px;
}
.table-content table td.product-name a:hover {
    color: #555;
}
.table-content table td.product-name {
    width: 270px;
}
.table-content table td.product-thumbnail {
    width: 200px;
}
.table-content table td.product-remove i {
    color: #000;
    display: inline-block;
    font-size: 20px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    width: 40px;
}
.table-content table .product-price .amount,
.table-content table td.product-subtotal {
    color: #444;
    font-size: 15px;
    font-weight: 400;
    letter-spacing: 1px;
}
.table-content table td.product-remove i:hover {
    color: #999;
}
.table-content table td.product-quantity {
    width: 180px;
}
.table-content table td.product-remove {
    width: 150px;
}
.table-content table td.product-price {
    width: 130px;
}
.update-checkout-cart {
    display: flex;
}
.update-cart {
    margin-left: 20px;
}
.update-cart:first-child {
    margin-left: 0px;
}
.cart-shipping .btn-style {
    padding: 18px 33px 17px;
}
.update-cart button {
    border: medium none;
}
.cart-shiping-update {
    border-bottom: 1px solid #ebebeb;
    display: flex;
    justify-content: space-between;
    margin-bottom: 69px;
    margin-top: 36px;
    overflow: hidden;
    padding-bottom: 57px;
}
.wishlist .cart-shiping-update {
    border-bottom: medium none navy;
    margin-bottom: 0;
    padding-bottom: 0;
}
.discount-code h4 {
    color: #333;
    font-size: 20px;
    margin-bottom: 24px;
    text-transform: capitalize;
}
.discount-code {
    background-color: #f7f7f7;
    display: block;
    margin-right: 30px;
    padding: 55px 70px;
}
.coupon input {
    background: #fff none repeat scroll 0 0;
    border: medium none;
    height: 56px;
    padding-left: 10px;
    padding-right: 50px;
}
.coupon input.cart-submit {
    background-color: #f3a395;
    color: #fff;
    cursor: pointer;
    padding: 0 30px;
    position: absolute;
    right: 0;
    text-transform: uppercase;
    top: 0;
    width: inherit;
}
.coupon input.cart-submit:hover {
    background-color: #000;
}
.coupon {
    position: relative;
}
.button-coupon {
    background-color: #3f3f3f;
    border: medium none;
    color: #fff;
    font-weight: 500;
    height: 56px;
    letter-spacing: 0.4px;
    padding: 0 28px;
    position: absolute;
    right: 0;
    text-transform: uppercase;
    transition: all .3s ease 0s;
}
.shop-total > h3 {
    background-color: #f3a395;
    color: #fff;
    font-size: 20px;
    margin: 0;
    padding: 23px 30px 22px;
    text-transform: capitalize;
}
.shop-total ul {
    padding: 37px 0 35px;
}
.shop-total ul li {
    color: #333;
    font-size: 16px;
    padding-bottom: 22px;
    text-transform: capitalize;
}
.shop-total ul li.order-total {
    border-bottom: 1px solid #ebebeb;
    margin-bottom: 18px;
    padding-bottom: 32px;
}
.shop-total ul li span {
    float: right;
}
.cart-btn > a,
.continue-shopping-btn > a {
    background-color: #f7f7f7;
    color: #444;
    display: block;
    letter-spacing: 1px;
    padding: 23px 10px 22px;
    text-transform: uppercase;
}
.cart-btn > a:hover,
.continue-shopping-btn > a:hover {
    background-color: #f3a395;
    color: #fff;
}
.button-coupon:hover {
    background-color: #666;
}
.product-cart-icon.product-subtotal > a {
    color: #333;
    font-size: 25px;
}
.product-cart-icon.product-subtotal > a:hover,
.table-content table td.product-name a:hover {
    color: #f3a395;
}

/*------- 11. Checkout page --------*/
.coupon-accordion h3 {
    background-color: #f7f6f7;
    border-top: 3px solid #f3a395;
    color: #444;
    font-size: 14px;
    font-weight: 400;
    list-style: outside none none !important;
    margin: 0 0 25px !important;
    padding: 1em 2em 1em 3.5em !important;
    position: relative;
    width: auto;
}
.panel-title > a:hover,
.panel-title > a:focus {
    color: #f3a395;
}
.coupon-accordion h3::before {
    color: #000;
    content: "ï„”";
    display: inline-block;
    font-family: fontawesome;
    left: 1.5em;
    position: absolute;
    top: 1em;
}
.coupon-accordion span {
    cursor: pointer;
    color: #6f6f6f;
    transition: all .3s ease 0s;
}
.coupon-accordion span:hover,
p.lost-password a:hover {
    color: #f3a395;
}
.coupon-content {
    border: 1px solid #e5e5e5;
    display: none;
    margin-bottom: 20px;
    padding: 20px;
}
.coupon-info p.coupon-text {
    margin-bottom: 15px
}
.coupon-info p {
    margin-bottom: 0
}
.coupon-info p.form-row-first {}
.coupon-info p.form-row-first label,
.coupon-info p.form-row-last label {
    display: block;
}
.coupon-info p.form-row-first label span.required,
.coupon-info p.form-row-last label span.required {
    color: #333;
}
.coupon-info p.form-row-first input,
.coupon-info p.form-row-last input {
    border: 1px solid #e5e5e5;
    height: 36px;
    margin: 0 0 14px;
    max-width: 100%;
    padding: 0 0 0 10px;
    width: 370px;
    background-color: transparent;
}
.coupon-info p.form-row-last {}
.coupon-info p.form-row input[type="submit"]:hover,
p.checkout-coupon input[type="submit"]:hover {
    background: #f3a395 none repeat scroll 0 0;
}
.coupon-info p.form-row input[type="checkbox"] {
    height: inherit;
    position: relative;
    top: 2px;
    width: inherit;
}
.form-row > label {
    margin-top: 7px;
}
p.lost-password {
    margin-top: 15px;
}
p.lost-password a {
    color: #6f6f6f;
}
p.checkout-coupon input[type="text"] {
    background-color: transparent;
    border: 1px solid #ddd;
    height: 36px;
    padding-left: 10px;
    width: 170px;
}
p.checkout-coupon input[type="submit"] {
    background: #333 none repeat scroll 0 0;
    border: medium none;
    border-radius: 0;
    color: #fff;
    cursor: pointer;
    height: 36px;
    margin-left: 6px;
    padding: 5px 18px;
    text-transform: uppercase;
    transition: all 0.3s ease 0s;
    width: inherit;
}
.coupon-checkout-content {
    margin-bottom: 30px;
    display: none;
}
.checkbox-form h3 {
    border-bottom: 1px solid #e5e5e5;
    color: #444;
    font-size: 25px;
    margin: 0 0 20px;
    padding-bottom: 10px;
    text-transform: uppercase;
    width: 100%;
}
.country-select {
    margin-bottom: 30px;
    position: relative;
}
.country-select label,
.checkout-form-list label {
    color: #444;
    display: block;
    font-size: 14px;
    margin: 0 0 5px;
}
.country-select label span.required,
.checkout-form-list label span.required {
    color: #f3a395;
    font-size: 15px;
}
.country-select select {
    -moz-appearance: none;
    border: 1px solid #ddd;
    height: 42px;
    padding-left: 10px;
    width: 100%;
    background-color: transparent;
}
.country-select::before {
    content: "ï„£";
    display: inline-block;
    font-family: "Ionicons";
    font-size: 17px;
    position: absolute;
    right: 12px;
    top: 36px;
    color: #666;
}
.checkout-form-list {
    margin-bottom: 30px;
}
.checkout-form-list label {
    color: #444;
}
.checkout-form-list label span.required {}
.checkout-form-list input[type=text],
.checkout-form-list input[type=password],
.checkout-form-list input[type=email] {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #e5e5e5;
    border-radius: 0;
    height: 42px;
    width: 100%;
    padding: 0 0 0 10px;
}
.checkout-form-list input[type="checkbox"] {
    display: inline-block;
    height: inherit;
    margin-right: 10px;
    position: relative;
    top: 2px;
    width: inherit;
}
.ship-different-title input {
    height: inherit;
    line-height: normal;
    margin: 4px 0 0;
    position: relative;
    top: 1px;
    width: 30px;
}
.create-acc label {
    color: #333;
    display: inline-block;
}
.checkout-form-list input[type=password] {}
.create-account {
    display: none
}
.ship-different-title h3 label {
    display: inline-block;
    margin-right: 20px;
    font-size: 25px;
    color: #363636;
}
.order-notes textarea {
    background-color: transparent;
    border: 1px solid #ddd;
    height: 90px;
    padding: 15px;
    width: 100%;
}
#ship-box-info {
    display: none
}
.your-order {
    background: cornsilk;
    overflow: hidden;
    padding: 30px 40px 45px;
}
.your-order h3 {
    border-bottom: 1px solid #d8d8d8;
    color: #444;
    font-size: 25px;
    margin: 0 0 20px;
    padding-bottom: 10px;
    text-transform: uppercase;
    width: 100%;
}
.your-order-table table {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    width: 100%;
}
.your-order-table table th,
.your-order-table table td {
    border-bottom: 1px solid #d8d8d8;
    border-right: medium none;
    font-size: 14px;
    padding: 15px 0;
    /* text-align: center; */
}
.your-order-table table td .product-quantity {
    font-weight: 400;
}
.your-order-table table th {
    border-top: medium none;
    font-weight: normal;
    text-align: center;
    text-transform: uppercase;
    vertical-align: middle;
    white-space: nowrap;
    width: 250px;
}
.your-order-table table .shipping ul li input {
    position: relative;
    top: 2px;
}
.your-order-table table .shipping th {
    vertical-align: top;
}
.your-order-table table .order-total th {
    border-bottom: medium none;
    font-size: 18px;
}
.your-order-table table .order-total td {
    border-bottom: medium none;
}
.your-order-table table tr.cart_item:hover {
    background: #F9F9F9
}
.your-order-table table tr.order-total td span {
    color: #444;
    font-size: 20px;
    font-weight: 500;
}
.payment-accordion h3 {
    border-bottom: 0 none;
    margin-bottom: 10px;
    padding-bottom: 0;
}
.payment-accordion h3 a {
    color: #6f6f6f;
    font-size: 14px;
    padding-left: 25px;
    position: relative;
    text-transform: capitalize;
    text-decoration: none
}
.payment-content p {
    font-size: 13px;
}
.payment-accordion img {
    height: 60px;
    margin-left: 15px;
}
.order-button-payment input {
    background: #ffc6ce  none repeat scroll 0 0;
    border: 1px solid transparent;
    color: #000;
    cursor: pointer;
    font-size: 14px;
    font-weight: 400;
    height: inherit;
    letter-spacing: 1px;
    margin: 20px 0 0;
    padding: 13px 20px 11px;
    text-transform: uppercase;
    transition: all 0.3s ease 0s;
    width: 100%;
}
.order-button-payment input:hover {
    background: #ffb5c0;
    border: 1px solid #ffb5c0;
    color: #fff;
}
.coupon-info p.form-row input[type="submit"] {
    background: #252525 none repeat scroll 0 0;
    border: medium none;
    border-radius: 0;
    box-shadow: none;
    color: #fff;
    display: inline-block;
    float: left;
    font-size: 14px;
    height: 40px;
    line-height: 40px;
    margin-right: 15px;
    padding: 0 25px;
    text-transform: uppercase;
    transition: all 0.3s ease 0s;
    width: inherit;
    cursor: pointer;
}

/*--------- 12. Login register page ---------*/
.login-form-container {
    background: transparent none repeat scroll 0 0;
    /* box-shadow: 0 0 6px rgba(0, 0, 0, 0.1); */
    text-align: left;
}
.login-text {
    margin-bottom: 30px;
    text-align: center;
}
.login-text h2 {
    color: #444;
    font-size: 30px;
    margin-bottom: 5px;
    text-transform: capitalize;
}
.login-text span {
    font-size: 15px;
}
.login-form-container input {
    /*background-color: #fff6f5;*/
    /*border: medium none;*/
    color: #7d7d7d;
    font-size: 16px;
    font-weight: 500;
    height: 40px;
    padding: 0 15px;
   /*  margin-bottom: 8px; */
}
.login-form-container input::-moz-placeholder,
.login-form-container input::-webkit-placeholder {
    color: #7d7d7d;
    opacity: 1;
}
.login-toggle-btn {
    padding: 10px 0 19px;
}
.login-form-container input[type="checkbox"] {
    height: 15px;
    margin: 0;
    position: relative;
    top: 1px;
    width: 17px;
}
.login-form-container label {
    color: #777;
    font-size: 14px;
    font-weight: 400;
}
.login-toggle-btn > a {
    color: #666;
    float: right;
    transition: all 0.3s ease 0s;
}
.login-toggle-btn > a:hover {
    color: #f3a395;
}
.login-register-tab-list {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
}
.login-register-tab-list.nav a h4 {
    font-size: 25px;
    font-weight: 500;
    margin: 0 20px;
    text-transform: capitalize;
    transition: all 0.3s ease 0s;
}
.login-register-tab-list.nav a.active h4,
.login-register-tab-list.nav a h4:hover {
    color: #f3a395;
}
.login-form button {
	    padding: 10px 35px;
    border: medium none;
    cursor: pointer;
}

/*------- 13. Blog page --------*/
.blog-area .container-fluid {
    padding: 0 310px;
}
.blog-img img {
    width: 100%;
}
.blog-content > h2 {
    color: #444;
    font-size: 30px;
    font-weight: 500;
    margin: 0;
    text-transform: capitalize;
}
.blog-content > h2 a {
    color: #444;
}
.blog-date-categori {
    margin: 9px 0 19px;
}
.blog-date-categori li {
    color: #656565;
    display: inline-block;
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-style: italic;
    font-weight: 400;
}
.blog-date-categori ul li::after {
    content: "/";
    margin: 0 3px 0 4px;
}
.blog-date-categori ul li:last-child::after {
    display: none;
}
.blog-date-categori ul li a {
    color: #f3a395;
    display: inline-block;
    position: relative;
    transition: all 0.3s ease 0s;
}
.blog-date-categori ul li a::before {
    background-color: #f3a395;
    bottom: 3px;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    transition: all 0.3s ease 0s;
    width: 100%;
}
.blog-date-categori ul li a:hover::before {
    background-color: #000;
}
.blog-date-categori ul li a:hover {
    color: #000;
}
.single-blog-wrapper > p {
    margin: 0;
}
.blog-btn-social {
    display: flex;
    justify-content: space-between;
}
.blog-social {
    display: flex;
}
.blog-btn .btn-style {
    font-size: 13px;
    padding: 5px 10px 7px;
    text-transform: capitalize;
}
.blog-social ul li {
    display: inline-block;
    margin-left: 13px;
}
.blog-social ul li:nth-child(1) {
    margin-left: 0px;
}

.blog-social ul li a {
    color: #444;
    font-size: 18px;
}
.blog-social > span {
    color: #444;
    font-weight: 500;
    margin: 3px 15px 0 0;
    text-transform: capitalize;
}
/* quote post */
blockquote {
    margin: 0;
}
.quote-post {
    background-color: #f3a395;
    padding: 74px 50px 77px 58px;
    position: relative;
}
.quote-content,
.link-content {
    z-index: 9;
    position: relative;
}
.quote-content > span {
    color: #ececec;
}
.quote-content > h3 {
    color: #f3f2f2;
    font-size: 18px;
    font-weight: 500;
    line-height: 28px;
    margin: 19px 0 22px;
    text-transform: uppercase;
}
.quote-content > h3 a {
    color: #f3f2f2;
}
.quote-content h6 {
    color: #f3f2f2;
    font-size: 14px;
    font-weight: 400;
    margin: 0;
    padding-left: 28px;
    position: relative;
}
.quote-content h6::before {
    background-color: #f3f2f2;
    content: "";
    height: 1px;
    left: 0;
    position: absolute;
    top: 9px;
    transition: all 0.3s ease 0s;
    width: 18px;
}
.post-img {
    display: inline-block;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    text-align: center;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
}
.post-img > img {
    max-width: 188px;
}

/* gallery post */
.blog-gallery-slider .owl-nav div,
.slider-active .owl-nav div {
    color: #494949;
    font-size: 35px;
    left: 50px;
    opacity: 0;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    transition: all 0.3s ease 0s;
    visibility: hidden;
}
.blog-gallery-slider .owl-nav div.owl-next,
.slider-active .owl-nav div.owl-next {
    left: auto;
    right: 50px;
}
.blog-gallery-slider .owl-nav div:hover,
.slider-active .owl-nav div:hover {
    color: #f3a395;
}
.blog-gallery-slider:hover .owl-nav div,
.slider-active:hover .owl-nav div {
    opacity: 1;
    visibility: visible;
}

/* link post */
.link-post {
    background-color: #000000;
    padding: 74px 48px 77px;
    position: relative;
}

.link-content > span {
    color: #ececec;
}
.link-content > h3 {
    color: #f3f2f2;
    font-size: 18px;
    font-weight: 500;
    margin: 20px 0 0;
    text-transform: uppercase;
}
.link-content > h3 a {
    color: #f3f2f2;
}
.blog-social ul li a:hover,
.blog-author > h4 a:hover,
.news-form > button:hover,
.blog-categori ul li a:hover,
.blog-tags ul > li a:hover,
.blog-sidebar-social li a:hover,
.link-content > h3 a:hover,
.recent-post-content > h4 a:hover,
.blog-content > h2 a:hover {
    color: #f3a395;
}
.blog-btn > a:hover::before {
    background-color: #f3a395;
}
.quote-content > h3 a:hover {
    text-decoration: underline;
}

/* Blog sidebar */
.blog-search form input {
    background: #efefef none repeat scroll 0 0;
    border: medium none;
    box-shadow: none;
    color: #a8a8a8;
    font-size: 14px;
    height: 60px;
    padding-left: 20px;
    padding-right: 50px;
    width: 100%;
}
.blog-search form input:-moz-placeholder {
    color: #000;
    opacity: 1;
}
.blog-search form {
    position: relative;
}
.news-form > button {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    color: #a7a7a7;
    font-size: 24px;
    padding: 0;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}
.blog-author > h4 {
    color: #717171;
    font-size: 18px;
    font-weight: 400;
    margin: 16px 0 6px;
}
.blog-author > h4 a {
    color: #717171;
}
.recent-post-wrapper {
    align-items: center;
    display: flex;
    margin-bottom: 25px;
}
.recent-post-wrapper:last-child,
.blog-categori ul li:last-child {
    margin-bottom: 0px;
}
.recent-post-img a img {
    flex: 0 0 94px;
}
.blog-widget-title {
    color: #444;
    font-size: 18px;
    font-weight: 500;
}
.recent-post-content > h4 {
    color: #444;
    font-size: 17px;
    font-weight: 400;
    margin-bottom: 4px;
}
.recent-post-content > h4 a {
    color: #444;
}
.recent-post-content > span {
    color: #a7a7a7;
}
.recent-post-img {
    margin-right: 25px;
}
.blog-categori ul li {
    margin-bottom: 17px;
}
.blog-categori ul li a {
    color: #444;
    font-size: 15px;
}
.blog-instagram img {
    width: 84px;
}
.blog-instagram li {
    display: inline-block;
    margin-bottom: 9px;
    margin-right: 6px;
}
.blog-instagram li a {
    position: relative;
    display: block;
}
.blog-instagram li a::before {
    background-color: #f3a395;
    content: "";
    height: 100%;
    left: 0;
    opacity: 0;
    position: absolute;
    right: 0;
    transition: all 0.3s ease 0s;
    width: 100%;
}
.blog-instagram li a:hover::before {
    opacity: 0.6;
}
.blog-sidebar-social li {
    display: inline-block;
    margin-right: 32px;
}

.blog-sidebar-social li:last-child {
    margin-right: 0px;
}
.blog-sidebar-social li a {
    color: #444;
    font-size: 24px;
}
.blog-tags ul > li {
    display: inline-block;
    margin-bottom: 7px;
    margin-right: 17px;
    position: relative;
}

.blog-tags ul li::after {
    background-color: #6d6d6d;
    content: "";
    font-size: 8px;
    height: 12px;
    position: absolute;
    right: -12px;
    top: 4px;
    transform: rotate(20deg);
    width: 1.5px;
}
.blog-tags ul > li a {
    color: #444;
    letter-spacing: 0.5px;
    text-transform: capitalize;
}
.blog-tags ul li:last-child::after {
    display: none;
}

/* blog masonry */
.masonary-style .blog-content > h2 {
    font-size: 18px;
}
.masonary-style .quote-post {
    padding: 74px 44px 77px 47px;
}

/*---------- 14. Blog details -------*/
.highlights-title-wrapper {
    display: flex;
    margin: 56px 0 47px;
}
.importent-title > h4 {
    color: #444;
    font-size: 18px;
    font-style: italic;
    font-weight: 500;
    line-height: 34px;
    margin: 0;
}
.highlights-img > img {
    width: 73px;
}
.highlights-img {
    margin-right: 25px;
    margin-top: 9px;
}
.dec-img > img {
    width: 100%;
}
.dec-img-wrapper {
    margin: 56px 0 53px;
}
.blog-dec-tags-social {
    border-bottom: 2px solid #f6f6f6;
    display: flex;
    justify-content: space-between;
    margin-top: 52px;
    padding-bottom: 10px;
}
.blog-dec-tags ul li {
    display: inline-block;
    position: relative;
}
.blog-dec-tags ul li a {
    color: #444;
    margin-right: 18px;
    text-transform: capitalize;
}
.blog-dec-tags ul li::after {
    background-color: #6d6d6d;
    content: "";
    font-size: 8px;
    height: 12px;
    position: absolute;
    right: 6px;
    top: 5px;
    transform: rotate(20deg);
    width: 1.5px;
}
.blog-dec-tags ul li:last-child::after {
    display: none;
}
.blog-dec-social {
    display: flex;
}
.blog-dec-social ul li {
    display: inline-block;
    margin-left: 14px;
}
.blog-dec-social ul li a {
    color: #333333;
    font-size: 18px;
}
.blog-dec-social > span {
    color: #444;
    font-weight: 500;
    margin-top: 3px;
    text-transform: capitalize;
}
.blog-dec-tags ul li a:hover,
.blog-dec-social ul li a:hover,
.blog-details-btn a:hover {
    color: #f3a395;
}
.administrator-wrapper {
    align-items: center;
    display: flex;
    border-bottom: 2px solid #f6f6f6;
    padding: 30px 0;
}
.administrator-img {
    margin-right: 30px;
}
.administrator-content > h4 {
    color: #444;
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 19px;
}
.administrator-content > p {
    color: #262626;
    font-size: 15px;
    line-height: 26px;
    margin: 0;
}
.blog-dec-title {
    color: #444;
    font-size: 20px;
    font-weight: 500;
    margin: 0;
    text-transform: capitalize;
}
.single-comment-wrapper {
    display: flex;
}
.blog-comment-content > h4 {
    color: #444;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin: 0;
}
.blog-comment-content > span {
    color: #656565;
    display: block;
    margin: 6px 0 8px;
}
.blog-comment-content > p {
    margin-bottom: 15px;
}
.blog-comment-img {
    margin-right: 28px;
}
.leave-form {
    margin-bottom: 30px;
}
.blog-reply-wrapper form input,
.blog-reply-wrapper form textarea {
    background: #f7f7f7 none repeat scroll 0 0;
    border: medium none;
    color: #8e8e8e;
    font-size: 14px;
    height: 60px;
    padding: 2px 20px;
}
.blog-reply-wrapper form input::-moz-placeholder,
.blog-reply-wrapper form textarea::-moz-placeholder {
    color: #8e8e8e;
    opacity: 1;
}
.blog-reply-wrapper form input::-webkit-placeholder,
.blog-reply-wrapper form textarea::-webkit-placeholder {
    color: #8e8e8e;
    opacity: 1;
}
.blog-reply-wrapper form textarea {
    height: 235px;
    padding: 25px 20px;
}
.blog-reply-wrapper form .text-leave input {
    background-color: #f3a395;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-weight: 400;
    height: inherit;
    letter-spacing: 1px;
    margin-top: 60px;
    padding: 14px 30px 13px;
    width: inherit;
}
.blog-reply-wrapper form .text-leave input:hover {
    background-color: #000;
}
.blog-reply-wrapper > form {
    margin-top: 65px;
}
.blog-details-btn a {
    color: #444;
    font-weight: 500;
    text-transform: capitalize;
}
/*--------- 15. Scrollup ---------*/
#scrollUp {
    background: #f3a395 none repeat scroll 0 0;
    bottom: 85px;
    color: #ffffff;
    cursor: pointer;
    display: none;
    font-size: 20px;
    height: 40px;
    line-height: 40px;
    position: fixed;
    right: 12px;
    text-align: center;
    width: 38px;
    z-index: 9999;
}
#scrollUp:hover {
    background: #333 none repeat scroll 0 0;
}
.follow-icon ul li.twitter a{
	background-color: #1da1f2;
    color: #fff;
    border: 1px solid #1da1f2;
}
.follow-icon ul li.facebook a{
	background-color: #3b5998;
    color: #fff;
    border: 1px solid #3b5998;
}
.follow-icon ul li.instagram a{
    background-color: #c32aa3;
    color: #fff;
    border: 1px solid #c32aa3;
}
.follow-icon ul li.tumblr a{
    background-color: #35465d;
    color: #fff;
    border: 1px solid #35465d;
}
.main-menu{
	margin:0 auto;
}
.stick .language-currency{
   display:flex;
}

.newsletter-services{
	background: rgb(100, 99, 99);
	    border-top: 5px solid white;
    border-bottom: 5px solid white;
}
.newsletter input[type="text"] {
    width: 200px;
   
    padding-right: 50px;
}

.newsletter input[type="submit"] {
  margin-left: -4px;
    height: 46px;
    width: 50px;
    background: #fff;
    color: grey;
    border: 0;
    -webkit-appearance: none;
}




.checkbox_container {
  display: block;
  position: relative;
  padding-left: 35px;
 
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.checkbox_container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
        border-radius: 6px;
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.checkbox_container:hover input ~ .checkmark {
  background-color: #ccc;
      border-radius: 6px;

}

/* When the checkbox is checked, add a blue background */
.checkbox_container input:checked ~ .checkmark {
        border-radius: 6px;

  background-color: #f07e81;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkbox_container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox_container .checkmark:after {
  left: 10px;
  top: 4px;
  width: 6px;
  height: 14px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
/* RADIO CSSS */
/* Customize the label (the container) */
.radio_container {
 
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
 
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.radio_container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom radio button */
.radio_checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #e99;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.radio_container:hover input ~ .radio_checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.radio_container input:checked ~ .radio_checkmark {
  background-color: #f07e81;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.radio_checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.radio_container input:checked ~ .radio_checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.radio_container .radio_checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

.bank_details-date{
	font-size:12px;
	    padding: 30px;
}
.text-center > label{
	text-align:center;
}

.cart_amt_floater{
	float: right;
	
}
.row_bottom{
	border-bottom: 2px solid #f0eeee;
}

.default-btn{
	  background-color: #f2b6ac;
    border: medium none;
    color: #ffffff;
    border: 1px solid #f3a395;
   font-size: 16px;
    font-weight: 500;
    height: 50px;
    padding: 13px 26px;
	cursor: pointer;
}

.default-btn:hover{
	background: #f3a395;
    border: 1px solid #f3a395;
    color: #fff;
	cursor: pointer;
}

.default-btn_wishlist{
    width:70%;
	  background-color: #f2b6ac;
    border: medium none;
    color: #ffffff;
    border: 1px solid #f3a395;
   font-size: 16px;
    font-weight: 500;
    height: 50px;
    padding: 13px 26px;
	cursor: pointer;
}

.default-btn_wishlist:hover{
	background: #f3a395;
    border: 1px solid #f3a395;
    color: #fff;
	cursor: pointer;
}

.default-cbtn{
	  background-color: #e14f36;
    border: medium none;
    color: #ffffff;
    border: 1px solid #f3a395;
    font-size: 16px;
    font-weight: 500;
    height: 40px;
    padding: 9px 26px;
	cursor: pointer;
}

.default-cbtn:hover{
	background: #f3a395;
    border: 1px solid #f3a395;
    color: #fff;
	cursor: pointer;
}




.wishlist_clickcolor{
    color:red;
}

.chack_box_hidden{
    display:none;
}
.float_right{
    float: right;
}

.custom_qty_class{
    height: 39px!important;
    padding: 5px 13px;
}
.mc-form input{
    height:34px !important;
}
.page-list-items {
    margin: 3px 0;
}
.pageitemtitle{
    color: #848484;
    text-transform: uppercase;
    margin-right: 5px;
}
.footeritemswidget{
    padding: 0 5px;
    border-right: 1px solid #333;
    font-size: 14px;
}
    .go_to_cart{
	    background-color: #f2b6ac;
    border: medium none;
    color: #ffffff;
    border: 1px solid #f3a395;
   font-size: 14px;
    font-weight: 500;
    height: 50px;
    padding: 13px 26px;
	cursor: pointer;
}

.go_to_cart:hover{
	background: #f3a395;
    border: 1px solid #f3a395;
    color: #fff;
	cursor: pointer;
}

/*BOTON CODE */
    .boton {
        width: 200px;
        height: 50px;
        margin: auto;
        display: block;
        position: relative;
    }
    
    .botontext {
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 1;
        text-align: center;
        line-height: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        text-transform: uppercase;
    }
    
    .twist {
        display: block;
        height: 100%;
        width: 25%;
        position: relative;
        float: left;
        margin-left: -4px;
    }
    
    .twist:before {
        content: "";
        width: 100%;
        height: 100%;
        background: #FEB3B3;
        bottom: 100%;
        position: absolute;
        transform-origin: center bottom 0px; 
        transform: matrix3d(1, 0, 0, 0, 
                            0, 0, -1, -0.003, 
                            0, 1, 0, 0, 
                            0, 0, 0, 1);
        
-webkit-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
   -moz-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
     -o-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
        transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); /* custom */
    }
    
    .twist:after {
        content: "";
        position: absolute;
        width: 100%;
        top: 100%;
        height: 100%;
        background: #FDBABA;
        transform-origin: center top 0px;
        transform: matrix3d(1, 0, 0, 0, 
                            0, 1, 0, 0, 
                            0, 0, 1, -0.003, 
                            0, -50, 0, 1);
        
-webkit-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
   -moz-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
     -o-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
        transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); /* custom */
    }
    
    .boton:hover .twist:before {
        background: #F7D2CC;
        transform: matrix3d(1, 0, 0, 0, 
                            0, 1, 0, 0, 
                            0, 0, 1, 0.003, 
                            0, 50, 0, 1);
    }
    
    .boton:hover .twist:after {
        background: #F7D2CC;
        transform: matrix3d(1, 0, 0, 0, 
                            0, 0, -1, 0.003, 
                            0, 1, 0, 0, 
                            0, 0, 0, 1);
    }

    .boton .twist:nth-of-type(1) {
        margin-left: 0;
    }
    
    .boton .twist:nth-of-type(1):before,
    .boton .twist:nth-of-type(1):after {
        transition-delay: 0s;
    }
    
    .boton .twist:nth-of-type(2):before,
    .boton .twist:nth-of-type(2):after {
        transition-delay: 0.1s;
    }
    
    .boton .twist:nth-of-type(3):before,
    .boton .twist:nth-of-type(3):after {
        transition-delay: 0.2s;
    }
    
    .boton .twist:nth-of-type(4):before,
    .boton .twist:nth-of-type(4):after {
        transition-delay: 0.3s;
    }
    
    .boton .botontext:nth-of-type(1) {
        color: #3d3b40;
        bottom: 100%;
        transform-origin: center bottom 0px; 
        transform: matrix3d(1, 0, 0, 0, 
                            0, 0, -1, -0.003, 
                            0, 1, 0, 0, 
                            0, 0, 0, 1);
        
-webkit-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
   -moz-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
     -o-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
        transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); /* custom */
    }
    
    .boton:hover .botontext:nth-of-type(1) {
        transform: matrix3d(1, 0, 0, 0, 
                            0, 1, 0, 0, 
                            0, 0, 1, 0.003, 
                            0, 50, 0, 1);
    }
    
    .boton .botontext:nth-of-type(2) {
        color: #fff;
        top: 100%;
        transform-origin: center top 0px;
        transform: matrix3d(1, 0, 0, 0, 
                            0, 1, 0, 0, 
                            0, 0, 1, -0.003, 
                            0, -50, 0, 1);
        
-webkit-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
   -moz-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
     -o-transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); 
        transition: all 500ms cubic-bezier(0.970, 0.000, 0.395, 0.995); /* custom */
    }
    
    .boton:hover .botontext:nth-of-type(2) {
        transform: matrix3d(1, 0, 0, 0, 
                            0, 0, -1, 0.003, 
                            0, 1, 0, 0, 
                            0, 0, 0, 1);
    }



/*ACCORDIAN*/
/*.panel-group .panel {
		border-radius: 0;
		box-shadow: none;
		border-color: #EEEEEE;
	}

	.panel-default > .panel-heading {
		padding: 0;
		border-radius: 0;
		color: #212121;
	
		border-color: #EEEEEE;
	}

	.panel-title {
	    border-bottom: 1px solid #a5a0a0;
		font-size: 14px;
	}

	.panel-title > a {
		display: block;
		padding: 15px;
		text-decoration: none;
	}

	.more-less {
		float: right;
		color: #212121;
	}

	.panel-default > .panel-heading + .panel-collapse > .panel-body {
		border-top-color: #EEEEEE;
	}

.collapse_tab{
        padding: 0px 18px;
}*/

/*------------ 13. breadcrumb style 2 -----------*/

.breadcrumb-content-2 > ul li {
  color: #929191;
  display: inline-block;
  font-size: 15px;
  font-weight: 400;
  padding-right: 27px;
  position: relative;
  text-transform: capitalize;
}
.breadcrumb-content-2 > ul li a {
  color: #929191;
}
.breadcrumb-content-2 > ul li a:hover {
  color: #f7d2cc;
}
.breadcrumb-content-2 ul li:after {
  background-color: #929191;
  
  font-size: 8px;
  height: 11px;
  margin-left: 11px;
  position: absolute;
  right: 11px;
  top: 6px;
  -webkit-transform: rotate(33deg);
      -ms-transform: rotate(33deg);
          transform: rotate(33deg);
  width: 2px;
}

/*Bread ends*/
.border_1{
    border: 1px solid grey;
}

.custom_section_padder{
    padding: 33px 0 130px 0;
}
.single-input-item {
    padding-bottom: 12px;
}
.fontsize14 {
    font-size: 14px;
}
.wrapper {    
    margin-bottom: 7%;
    
}


.promosanitizer{
    border: 1px dashed grey;
    padding: 5px;
}
.switch{
    font-size:25px;
}
/*EFFECTS BUTTON PROMOCode*/
.image-upload>input {
  display: none;
}
.thumb-image{
 float:left;width:100px;
 position:relative;
 padding:5px;
}

.error{
    color:#f80505;
}


/*Verticle Tabs */
a:hover,a:focus{
text-decoration: none;
outline: none;
}
/*.vertical-tab{
width:100%;
display: table;
}*/

.vertical-tab .nav-tabs li{
float: none;
vertical-align: top;
}
.vertical-tab .nav-tabs li a{
color: #333;
    background: #fff;
    font-size: 18px;
    font-weight: 700;
    /* letter-spacing: 1px; */
    /* text-align: center; */
    /* text-transform: uppercase; */
    padding: 13px 12px 10px;
    margin: 0 9px 9px 0;
    /* border-radius: 30px; */
    border: none;
    /* display: block; */
    overflow: hidden;
    position: relative;
    /* z-index: 1; */
    transition: all 0.1s ease;
}
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: #fff;
    border: none !important;
    border-bottom-color: transparent;
}
.vertical-tab .nav-tabs li a:before,
.vertical-tab .nav-tabs li a:after{
content: '';
background: linear-gradient(to right bottom, #F7D2CC,transparent,transparent);
height: 60%;
width: 50%;
position: absolute;
left: 0;
top: 0;
z-index: -1;
transition: all 0.3s;
}
.vertical-tab .nav-tabs li a:after{
background: linear-gradient(to left top, #F7D2CC,transparent,transparent);
left: auto;
right: 0;
top: auto;
bottom: 0;
}
.vertical-tab .nav-tabs li a:hover:before,
.vertical-tab .nav-tabs li.active a:before,
.vertical-tab .nav-tabs li.active a:hover:before{
width: 150%;
height: 150%;
}
.vertical-tab .nav-tabs li a:hover:after,
.vertical-tab .nav-tabs li.active a:after,
.vertical-tab .nav-tabs li.active a:hover:after{
width: 150%;
height: 150%;
}
.vertical-tab .tab-content{
color: #fff;
/*background: linear-gradient(to right, #EA2027,#e54245);
font-size: 14px;*/
letter-spacing: 1px;
line-height: 25px;
/*text-shadow: 0 0 3px #333;*/
padding:0px 17px 17px 25px;
margin-top: 10px;
/*border-radius: 40px;*/
display: table-cell;
position: relative;
}
.vertical-tab .tab-content h3{
font-weight: 700;
-transform: uppercase;
letter-spacing: 1px;
margin: 0 0 7px 0;
}
@media only screen and (max-width: 479px){
.vertical-tab .nav-tabs{
width: 100%;
display: block;
border: none;
}
.vertical-tab .nav-tabs li a{ margin: 0 0 10px; }
.vertical-tab .tab-content{
padding: 25px 20px;
display: block;
}
.vertical-tab .tab-content h3{ font-size: 18px; }
}

#loading
{
 text-align:center; 
 background: url('https://www.petdukan.com/Mauritius/admin_assets/loaders/103.gif') no-repeat center; 
 height: 150px;
}

/*Rating and Reviewing css*/
.star-rating {
  line-height:32px;
  font-size:1.25em;
}

.star-rating .fa-star{color: yellow;}
.border-left
{
border-left: 1px solid;
    height: 19px;
    margin: 4px 10px;
    color: #8e8482;
}

/*----------------------------------------*/
/*  25.  Accordion CSS
/*----------------------------------------*/
.panel-collapse .panel-heading {
    position: relative;
}
.panel-collapse .panel-heading .panel-title>a:after, .panel-collapse .panel-heading .panel-title>a:before{
    position:absolute;
    bottom:0;
    left:0;
    height:1px;
    width:100%;
    content:"";
    -webkit-transition:all;
    -o-transition:all;
    transition:all;
    -webkit-transition-duration:.3s;
    transition-duration:.3s;
    -webkit-backface-visibility:hidden;
    -moz-backface-visibility:hidden;
    backface-visibility:hidden
}
.panel-collapse .panel-heading .panel-title>a:after{
    -webkit-transform:scale(0);
    -ms-transform:scale(0);
    -o-transform:scale(0);
    transform:scale(0)
}
.panel-collapse .panel-heading:not(.active) .panel-title>a:before{
    background:#eee
}
.panel-collapse .panel-heading:after,.panel-collapse .panel-heading:before{
    font-size:14px;
    position:absolute;
    left:0;
    -webkit-transition:all;
    -o-transition:all;
    transition:all;
    -webkit-transition-duration:.3s;
    transition-duration:.3s;
    -webkit-backface-visibility:hidden;
    -moz-backface-visibility:hidden;
    backface-visibility:hidden;
    top:8px;
}
.panel-collapse .panel-heading:before{
    margin-top: 8px;
    /*content:"\f48a";
    -ms-transform:scale(1);
    -o-transform:scale(1);*/
	 font-family: 'Ionicons';
}
.panel-collapse .panel-heading:after{
    margin-top: 8px;
    -webkit-transform:scale(0);
    -ms-transform:scale(0);
    -o-transform:scale(0);
    transform:scale(0);
    content:"\f463";
	font-family: 'Ionicons';
}
.panel-collapse .panel-heading.active .panel-title>a:after{
    -webkit-transform:scale(1);
    -ms-transform:scale(1);
    -o-transform:scale(1);
    transform:scale(1)
}
.panel-collapse .panel-heading.active:before{
    -webkit-transform:scale(0) rotate(-90deg);
    -ms-transform:scale(0) rotate(-90deg);
    -o-transform:scale(0) rotate(-90deg);
    transform:scale(0) rotate(-90deg)
}
.panel-collapse .panel-heading.active:after{
    /*-webkit-transform:scale(1);
    -ms-transform:scale(1);
    -o-transform:scale(1);
    transform:scale(1)*/
}
.panel-collapse .panel-body{
    border-top:0!important;
    padding-left:12px;
    padding-right:5px
}
.panel-group:not([data-collapse-color]) .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#2196F3
}
.panel-group[data-collapse-color=nk-green] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#00c292
}
.panel-group[data-collapse-color=nk-red] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#F44336
}
.panel-group[data-collapse-color=nk-pink] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#b7b4b5
}
.panel-group[data-collapse-color=nk-purple] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#9C27B0
}
.panel-group[data-collapse-color=nk-indigo] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#3F51B5
}
.panel-group[data-collapse-color=nk-blue] .panel-collapse .panel-heading.active .panel-title>a:after{
    background:#2196F3
}

.notika-accrodion-cus .panel-heading {
    padding: 10px 12px;
}
.panel.notika-accrodion-cus {
    border: 0px solid transparent;
    box-shadow: none;
}
.notika-accrodion-cus .panel-title>a{
	font-size:16px;
	color:#6e6b6b;
}
.notika-accrodion-cus .panel-body p, .popovers-pr-sg p{
	font-size:14px;
	color:#333;
	line-height:24px;
	margin:0px;
}
.accordion-stn .panel-group {
    margin-bottom: 0px;
}
.accordion-hd p{
	margin-bottom: 0px;
}
.accordion-hd{
	margin-bottom: 20px;
}
.accordion-stn .panel-body{
	padding-top:20px;
	padding-bottom: 0px;
}

.mobile-footer li{padding: 0px 0px 8px 0px;}

/*Veriticle Slider*/
   .bs-vertical-wizard {
   /* border-right: 1px solid #eaecf1;*/
    padding-bottom: 50px;
}

.bs-vertical-wizard ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.bs-vertical-wizard ul>li {
    display: block;
    position: relative;
}

.bs-vertical-wizard ul>li>a {
    display: block;
    padding: 10px 10px 10px 40px;
    color: #333c4e;
    font-size: 17px;
    font-weight: 400;
    letter-spacing: .8px;
}

.bs-vertical-wizard ul>li>a:before {
    content: '';
    position: absolute;
    width: 3px;
    height: calc(100% - 25px);
    background-color: #bdc2ce;
    left: 13px;
    bottom: -9px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>a .ico {
    pointer-events: none;
    font-size: 14px;
    position: absolute;
    left: 10px;
    top: 15px;
    z-index: 2;
}

.bs-vertical-wizard ul>li>a:after {
    content: '';
    position: absolute;
    border: 2px solid #bdc2ce;
    border-radius: 50%;
    top: 14px;
    left: 6px;
    width: 16px;
    height: 16px;
    z-index: 3;
}

.bs-vertical-wizard ul>li>a .desc {
    display: block;
    color: #bdc2ce;
    font-size: 11px;
    font-weight: 400;
    line-height: 1.8;
    letter-spacing: .8px;
}

.bs-vertical-wizard ul>li.complete>a:before {
    background-color: #5cb85c;
    opacity: 1;
    height: calc(100% - 25px);
    bottom: -9px;
}

.bs-vertical-wizard ul>li.complete>a:after {display:none;}
.bs-vertical-wizard ul>li.locked>a:after {display:none;}
.bs-vertical-wizard ul>li:last-child>a:before {display:none;}

.bs-vertical-wizard ul>li.complete>a .ico {
    left: 8px;
}

.bs-vertical-wizard ul>li>a .ico.ico-green {
    color: #5cb85c;
}

.bs-vertical-wizard ul>li>a .ico.ico-muted {
    color: #bdc2ce;
}

.bs-vertical-wizard ul>li.current {
  /*  background-color: #fff;*/
}

.bs-vertical-wizard ul>li.current>a:before {
    background-color: #ffe357;
    opacity: 1;
}

.bs-vertical-wizard ul>li.current>a:after {
    border-color: #ffe357;
    background-color: #ffe357;
    opacity: 1;
}

.bs-vertical-wizard ul>li.current:after, .bs-vertical-wizard ul>li.current:before {
    left: 100%;
    top: 50%;
    border: solid transparent;
  /*  content: " ";*/
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.bs-vertical-wizard ul>li.current:after {
    border-color: rgba(255,255,255,0);
    border-left-color: #fff;
    border-width: 10px;
    margin-top: -10px;
}

.bs-vertical-wizard ul>li.current:before {
    border-color: rgba(234,236,241,0);
    border-left-color: #eaecf1;
    border-width: 11px;
    margin-top: -11px;
}
.details_attributes{
        margin: 9px 0 8px;
}


/*customm side bar of small devices*/
.sidepanel  {
  width: 0;
  position: fixed;
  z-index: 1;
  height: 250px;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidepanel li {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidepanel li:hover {
  color: #f1f1f1;
}

.sidepanel .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
}

.openbtn {
 
  border: none;
}

/*Extra css*/

.lower_footer {
    padding: 4px 0;
    float: left;
    width: 100%;
    background-color: #464645;
}

@media (min-width: 980px){
.lower_footer .footer-link {
    float: right;
    width: 58.33333333%;
}
.lower_footer .footer-link ul {
    float: right;
    width: auto;
}
}
@media (min-width: 768px){
.lower_footer .footer-link {
    float: left;
    /*text-align: right;*/
    right: 0;
    width: auto;
}
.footer-padding ul {
    display: block;
}
.lower_footer {
    height: 27px;
}
}
.lower_footer .footer-link {
    float: left;
    text-align: center;
    display: block;
    width: 100%;
}


.lower_footer .footer-link ul {
    display: inline-block;
    /*float: none;
    width: auto;*/
}


@media (min-width: 320px){
.lower_footer ul {
    display: none;
    float: left;
    width: 100%;
    margin-bottom: 0;
}
    
}


@media (min-width: 1170px){
.footer-padding .lower_footer .footer-link ul li {
    padding-right: 20px;
    padding-left: 20px;
    margin-right: 0;
}}
@media (min-width: 980px){
.footer-padding .lower_footer .footer-link ul li {
    margin-bottom: 0;
}}
@media (min-width: 500px){
.footer-padding .lower_footer .footer-link ul li {
    width: auto;
    padding-left: 12px;
    padding-right: 12px;
}}
.footer-padding .lower_footer .footer-link ul li {
    border-right: 1px solid #fff;
    width: auto;
    float: left;
    margin-right: 0;
    margin-bottom: 0;
    text-align: left;
    padding-left: 10px;
    padding-right: 10px;
}
.footer-padding .lower_footer .footer-link ul li a {
    color: #fff;
    text-transform: capitalize;
    font-family: 'adobe-garamond-pro','serif';
    font-size: 10px;
}
.footer-padding ul li a {
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -ms-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
    position: relative;
    color: #626366;
}
.footer-padding .lower_footer .footer-link ul li:last-child {
    border-right: 0;
    padding-right: 0;
}


/* -- quantity box -- */

.quantity {
  position: relative;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button
{
  -webkit-appearance: none;
  margin: 0;
}

input[type=number]
{
  -moz-appearance: textfield;
}

.quantity input {
  width: 45px;
  height: 42px;
  line-height: 1.65;
  float: left;
  display: block;
  padding: 0;
  margin: 0;
  padding-left: 20px;
  border: none;
}

.quantity input:focus {
  outline: 0;
}

.quantity-nav {
  float: left;
  position: relative;
  height: 42px;
}

.quantity-button {
    
  position: relative;
    cursor: pointer;
    width: 20px;
    text-align: center;
    color: #b2aeae;
    font-size: 13px;
    
    line-height: 1.7;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;   
    
    
 /* position: relative;
  cursor: pointer;
  
  width: 20px;
  text-align: center;
  color: #333;
  font-size: 13px;
  font-family: "Trebuchet MS", Helvetica, sans-serif !important;
  line-height: 1.7;
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;*/
}

.quantity-button.quantity-up {
   font-size: 30px;
    position: absolute;
    top: -6px;
}

.quantity-button.quantity-down {
 font-size: 30px;
    left: 20px;
    position: absolute;
    bottom: -4px;

}


/*Step Wizards Steps Viewer*/
.content-box {
    background: #fff;
    background-clip: padding-box;
    border: 1px solid;
    border-radius: 5px;
    color: #545454;
}



.content-box__row:last-child {
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
}
.content-box__row:first-child {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
.display-table .content-box__row {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.content-box__row--tight-spacing-vertical {
    padding-top: 0.85714em;
    padding-bottom: 0.85714em;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.content-box__row:after, .content-box__row:before {
    content: "";
    display: table;
}
.content-box__row:after {
    clear: both;
}
.content-box__row:after, .content-box__row:before {
    content: "";
    display: table;
}
.review-block {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
}
.review-block__inner {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
}
.review-block__label {
    font-size:16px;
    color: #737373;
    padding-right: 1.14286em;
    -webkit-box-flex: 0;
    -webkit-flex: 0 1 5em;
    -ms-flex: 0 1 5em;
    flex: 0 1 5em;
}
.review-block ~ .review-block {
    margin-top: 0.85714em;
    padding-top: 0.85714em;
    border-top: 1px solid #e6e6e6;
}
.address--tight {
    line-height: inherit;
}
.address {
    font-style: normal;
    line-height: 1.5em;
}
.visually-hidden {
    border: 0;
    clip: rect(0, 0, 0, 0);
    clip: rect(0 0 0 0);
    width: 2px;
    height: 2px;
    margin: -2px;
    overflow: hidden;
    padding: 0;
    position: absolute;
}

/*Form Css*/
.form-label-group {
  position: relative;
 /* margin-bottom: 1rem;*/
}

.form-label-group > input,
.form-label-group > label {
  padding: .75rem .75rem;
}

.form-label-group > label {
cursor: pointer;
  position: absolute;
  top: -3px;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0; /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(.75rem + .75rem * (2 / 3));
  padding-bottom: calc(.75rem / 3);
}

.form-label-group input:not(:placeholder-shown) ~ label {
  padding-top: calc(.75rem / 3);
  padding-bottom: calc(.75rem / 3);
  font-size: 14px;
  color: #777;
}


.form-label-coupongroup {
  position: relative;
 /* margin-bottom: 1rem;*/
}

.form-label-coupongroup > input,
.form-label-coupongroup > label {
  padding: .75rem .75rem;
}

.form-label-coupongroup > label {
  position: absolute;
  top: 19px;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0; /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-coupongroup input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-coupongroup input:-ms-input-placeholder {
  color: transparent;
}

.form-label-coupongroup input::-ms-input-placeholder {
  color: transparent;
}

.form-label-coupongroup input::-moz-placeholder {
  color: transparent;
}

.form-label-coupongroup input::placeholder {
  color: transparent;
}

.form-label-coupongroup input:not(:placeholder-shown) {
  padding-top: calc(.75rem + .75rem * (2 / 3));
  padding-bottom: calc(.75rem / 3);
}

.form-label-coupongroup input:not(:placeholder-shown) ~ label {
  padding-top: calc(.75rem / 3);
  padding-bottom: calc(.75rem / 3);
  font-size: 12px;
  color: #777;
}



.select_modifier{
    position: relative;
    right: -17px;
    padding-top: calc(.75rem / 3);
    padding-bottom: calc(.75rem / 3);
    font-size: 14px;
    color: #777;
    top: -28px;
}

.ptx-16{
        margin-bottom: -20px;
    height: 71%;
    padding-top: 18px;
}


/*------------------Payment Mode Layout-------------------------*/
.section__content:after, .section__content:before {
    content: "";
    display: table;
}

.hidden {
    display: none !important;
}
.notice--error {
    border-color: #fad9d9;
    background-color: #ffebeb;
}
.notice {
    position: relative;
    display: table;
    opacity: 1;
    margin-bottom: 1.42857em;
    padding: 1em;
    border-radius: 4px;
    border: 1px solid #d3e7f5;
    background-color: #eff8ff;
    color: #545454;
    -webkit-transition: opacity 0.5s ease-in-out;
    transition: opacity 0.5s ease-in-out;
}
.content-box:first-of-type, .content-box-spacing:first-of-type {
    margin-top: 0;
}
.main .content-box {
    border-color: #d9d9d9;
}
.content-box, .content-box-spacing {
    margin-top: 1em;
}
.content-box {
    background: #fff;
    background-clip: padding-box;
    border: 1px solid;
    border-radius: 5px;
    color: #545454;
}
fieldset {
    margin: 0;
    padding: 0;
    border: 0;
}
.visually-hidden {
    border: 0;
    clip: rect(0, 0, 0, 0);
    clip: rect(0 0 0 0);
    width: 2px;
    height: 2px;
    margin: -2px;
    overflow: hidden;
    padding: 0;
    position: absolute;
}
.radio-wrapper.content-box__row, .checkbox-wrapper.content-box__row {
    margin-bottom: 0;
}
.display-table .radio-wrapper, .display-table .checkbox-wrapper {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.display-table .content-box__row {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.radio-wrapper, .checkbox-wrapper {
    zoom: 1;
    margin-bottom: 1em;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.display-table .radio__input, .display-table .checkbox__input {
    display: table-cell;
}
.radio__input, .checkbox__input {
    padding-right: 0.75em;
    white-space: nowrap;
}
.display-table .radio__label, .display-table .checkbox__label {
    display: table-cell;
    width: 100%;
}
.radio__label, .checkbox__label {
    cursor: pointer;
    vertical-align: middle;
}
.display-table .radio__label__primary {
    display: table-cell;
    width: 100%;
}
.radio__label__primary {
    cursor: inherit;
    font-family: inherit;
    vertical-align: top;
}
.content-box__emphasis {
    font-weight: 500;
    color: #333333;
}
.radio__label, .checkbox__label {
    cursor: pointer;
    vertical-align: middle;
}
.content-box__row ~ .content-box__row {
    border-top: 1px solid #d9d9d9;
}
.radio-wrapper, .checkbox-wrapper {
    zoom: 1;
    margin-bottom: 1em;
}
.content-box__row--secondary {
    background-color: #fafafa;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.radio-wrapper.content-box__row, .checkbox-wrapper.content-box__row {
    margin-bottom: 0;
}
.display-table .radio-wrapper, .display-table .checkbox-wrapper {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.display-table .content-box__row {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.content-box__row ~ .content-box__row {
    border-top: 1px solid #d9d9d9;
}
.radio-wrapper, .checkbox-wrapper {
    zoom: 1;
    margin-bottom: 1em;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.radio-wrapper, .checkbox-wrapper {
    zoom: 1;
    margin-bottom: 1em;
}
.content-box__row--secondary {
    background-color: #fafafa;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.radio-wrapper.content-box__row, .checkbox-wrapper.content-box__row {
    margin-bottom: 0;
}
.display-table .radio-wrapper, .display-table .checkbox-wrapper {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.display-table .content-box__row {
    display: table;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
.content-box__row ~ .content-box__row {
    border-top: 1px solid #d9d9d9;
}
.radio-wrapper, .checkbox-wrapper {
    zoom: 1;
    margin-bottom: 1em;
}
.content-box__row {
    padding: 1.14286em;
    position: relative;
    zoom: 1;
}
.offsite-payment-gateway-logo {
    height: 24px;
    display: block;
    margin-top: -2px;
}
.content-box__emphasis {
    font-weight: 500;
    color: #333333;
}
.checkout_img_modifier{
    border-radius: 8px;
    border: 1px rgba(0,0,0,0.1) solid;
    z-index: 2;
}
.product-thumbnail__quantity {
    font-size: 0.85714em;
    font-weight: 500;
    line-height: 1.75em;
    white-space: nowrap;
    text-align: center;
    border-radius: 1.75em;
    background-color: rgba(114,114,114,0.9);
    color: #fff;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    min-width: 1.75em;
    height: 1.75em;
    padding: 0 0.58333em;
    position: absolute;
    right: -2em;
    top: -0.75em;
    z-index: 3;
}
.custom_style_btn{
    font-size: 9px;
   
    height:calc(3.5em + .75rem + 2px);
}
.amount_aligner{
    padding: 0px 40px 0px 82px;
    text-align: right;
}

.color_modifier_right{
    padding: 0px 16px;color: #dad4d4;
}

.color_font{
    color:#f3a395;
}
.strong_highlight{color:#f97c8f ;}
.ProductItem-details-quickViewFullItemLink-wrapper {
    border-bottom: 1px solid #9d9d9d;
}
.ProductItem-details-quickViewFullItemLink {
    opacity: .6;
    font-family: Helvetica,Arial,sans-serif;
    font-weight: normal;
    font-size: 14px;
    letter-spacing: 0px;
    line-height: 1.6em;
    font-family: brandon-grotesque;
    font-weight: 300;
    font-style: normal;
    font-size: 18px;
    letter-spacing: .06em;
    line-height: 1.8em;
    text-transform: none;
    color: #1d1d1d;
    -webkit-box-ordinal-group: 100;
    -moz-box-ordinal-group: 100;
    -ms-flex-order: 100;
    -webkit-order: 100;
   
}

.pb-80{
    padding-bottom:80px;
}
.pt-12{
   padding-top:12px;
}

.accordion .card-header:after {
    font-size: 16px;
    font-family: 'FontAwesome';  
    content: "Hide order summary \f106";
     
}
.accordion .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    font-size: 16px;
    content: "Show order summary \f107"; 
}
.toggle_cart_icon{
        padding: 0px 8px;
}
.review-block__content {
    -webkit-box-flex: 5;
    -webkit-flex: 5;
    -ms-flex: 5;
    flex: 5;
    color: #333333;
    padding-right: 1.14286em;
}


.mobile_pink_border{
    border-bottom: 1px solid pink;
}

.single-top-rated {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
}
.top-rated-text > h4 {
  color: #6c6c6c;
  font-size: 14px;
  font-weight: 600;
  margin: 0;
}
.top-rated-rating li {
  display: inline-block;
}
.top-rated-rating li {
  display: inline-block;
  margin-right: 5px;
}
.top-rated-rating li i {
  color: #000000;
  font-size: 16px;
}

.top-rated-rating li i.reting-color {
  color: #ee3333;
  font-size: 16px;
}
.top-rated-text > span {
  color: #8b8b8b;
  font-weight: 600;
}
.top-rated-text {
  margin-left: 20px;
}
.top-rated-rating {
  line-height: 1;
  margin: 9px 0 10px;
}
.sidebar-load {
  padding-top: 7px;
}

.social-network > a {
  background: #f6f6f6 none repeat scroll 0 0;
  color: #262626;
  display: inline-block;
  font-size: 20px;
  height: 60px;
  line-height: 59px;
  text-align: center;
  -webkit-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
  width: 80px;
}
.social-network > a:hover {
  background: #ee3333 none repeat scroll 0 0;
  color: #fff;
}

.blog-tags-style li {
  display: inline-block;
  margin: 0 5px 10px 0;
}
.blog-tags-style li a {
  border: 1px solid #cbcbcb;
  color: #232323;
  display: inline-block;
  font-size: 14px;
  font-weight: 400;
  line-height: 1;
  padding: 13px 19px;
  text-align: center;
  text-transform: capitalize;
  -webkit-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
}
.blog-tags-style li a:hover {
  color: #fff;
    background-color: #ee3333;
}

.sidebar-img-content {
  background: #f6f6f6 none repeat scroll 0 0;
  padding: 20px;
}
.sidebar-img-content > p {
  color: #646464;
  font-size: 14px;
  line-height: 26px;
  margin-bottom: 21px;
}

.sidebar-img-content h4 {
  color: #2f2f2f;
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 0;
}
.sidebar-img-content > span {
  color: #2f2f2f;
  font-size: 12px;
  font-weight: 400;
}
.sidebar-widget.mb-50 > img {
  width: 100%;
}

.sidebar-img-social ul li {
  display: inline-block;
    margin-right: 20px;
}
.sidebar-img-social ul li > a {
  font-size: 16px;
}
.sidebar-img-social {
  margin-top: 10px;
}
.blog-part > img {
    width: 100%;
}
/*.mobile-menu::before {    

content: "";    
background: rgba(0,0,0,0.65);    
position: fixed;    
top: 0;    
left:0;    
bottom: 0;    
right: 0;  
}*/

.form-group {
    margin:10px;
}


.set{
position: relative;
    width: 100%;
    height: auto;
    background-color: white;
    padding: 10px;
    box-shadow: 0px 0px 1px black;
}
.set > a{
  display: block;
  padding: 10px 15px;
  text-decoration: none;
  color: #555;
  font-weight: 600;
font-size: 13px;
-webkit-transition:all 0.2s linear;
  -moz-transition:all 0.2s linear;
  transition:all 0.2s linear;
}
.set > a i{
  float: right;
  margin-top: 2px;
}
.set > a.active{
  background-color:#3399cc;
  color: #fff;
}
.content{
  background-color: #fff;
  display:none;
}
.content p{
  padding: 10px 15px;
  margin: 0;
  color: #333;
}
    </style>  
