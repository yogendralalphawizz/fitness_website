
 <!-- Start of Header -->
        <header class="header">
           
            <!-- End of Header Top -->
            <div class="header-middle">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="#" class="mobile-menu-toggle w-icon-hamburger">
                        </a>
                        <a href="<?=base_url()?>" class="logo ml-lg-0">
						 <!--<h1 class="text-white">Ecomm</h1>-->
                            <img src="<?=base_url()?>assets/frontend/images/homelogo.png" alt="logo" width="144" height="45">
                        </a>
                        <form method="get" action="<?=base_url()?>new-arrivals" class="input-wrapper header-search hs-expanded hs-round bg-white br-xs d-md-flex">
                                           <input type="text" class="form-control bg-white" value="<?php if(isset($_GET['search']))  { echo $_GET['search'];  } ?>" name="search" id="search"
                                placeholder="Search in..."/>
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header-right ml-4">
                        <div class="header-login d-xs-show d-lg-flex align-items-center">
                            <a href="#" class="w-icon-user"></a>
                            <div class="user-info d-lg-show">
                                <a href="<?=base_url()?>login" class="phone-number font-weight-bolder ls-50">Login</a>
                            </div>
                        </div>
                        <!--<a class="wishlist label-down link d-xs-show ls-normal" href="wishlist.html">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlist</span>
                        </a>
                        <a class="compare label-down link d-xs-show" href="compare.html">
                            <i class="w-icon-compare"></i>
                            <span class="compare-label d-lg-show">Compare</span>
                        </a>-->
                        <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2 text-white">
                            <div class="cart-overlay"></div>
                            <a href="#" class="cart-toggle label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count text-white">0</span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                              <div class="dropdown-box">
                                <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close-cart">Close<i class="w-icon-long-arrow-right"></i></a>
                                </div>

                                <div class="products">
                                    
                                </div>

                                <div class="cart-total" style="display: none;">
                                    <label>Subtotal:</label>
                                    <span class="price">-</span>
                                </div>

                                <div class="cart-action" style="display: none;">
                                    <a href="<?=base_url()?>cart" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                    <a href="<?=base_url()?>checkout" class="btn btn-primary  btn-rounded">Checkout</a>
                                </div>
                            </div>
                            <!-- End of Dropdown Box -->                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->

            <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <nav class="main-nav">
                                <ul class="menu active-underline">
                                    <li class="active">
                                        <a href="<?=base_url()?>new-arrivals">New Arrivals</a>
                                    </li>
									 
                                    <li>
                                        <a href="#">Categories</a>

                                        <!-- Start of Megamenu -->
                                        <ul class="megamenu">
                                         <?php
                                        $categories=categories();
                                        //print_r($categories);
                                        foreach($categories as $parent_row)
                                        {
                                            if($parent_row['parent_category']==0)
                                            {
                                                
                                            ?>
                                            <li>
                                                <h4 class="menu-title"><?=$parent_row['category_name']?></h4>
                                                <ul>
                                                  <?php
                                                  foreach($categories as $child_row1)
                                                    {
                                                        if($child_row1['parent_category']==$parent_row['id'])
                                                        {
                                                  ?>
                                                    <li><a href="<?=base_url()?>new-arrivals?category=<?=$child_row1['category_slug']?>"><?=$child_row1['category_name']?></a></li>
                                                <?php
                                                        }
                                                    }
                                                    ?>
                                                  
                                                </ul>
                                            </li>
                                          <?php
                                        }
                                        }
                                        ?>
                                         
                                        </ul>
                                        <!-- End of Megamenu -->
                                    </li>
                                    <?php
                                    $i=0;
                                    foreach($categories as $parent_row)
                                    {
                                        if($i<7)
                                        {
                                        ?>
                                    <li><a href="<?=base_url()?>new-arrivals?category=<?=$parent_row['category_slug']?>"><?=$parent_row['category_name']?></a></li>
                                    <?php
                                        }
                                        $i++;
                                    }
                                    ?>
                                    
                                </ul>
                            </nav>
                        </div>
                        <!--<div class="header-right">
                            <a href="#" class="d-xl-show"><i class="w-icon-map-marker mr-1 mt-0"></i>Track Order</a>
                            <a href="#"><i class="w-icon-sale"></i>Daily Deals</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </header>
        <!-- End of Header -->


