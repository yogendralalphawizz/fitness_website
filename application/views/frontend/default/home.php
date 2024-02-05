
 <!-- Start of Main -->
        <main class="main">
            <div class="container pb-2">
                <div class="intro-section mb-2">
				 <!-- Start of Shop Category -->
				 <?php
				 if($categories_slider)
				 {
				 ?>
                    <div class="shop-default-category category-ellipse-section mb-6 mt-6 pt-8">
                        <div class="swiper-container swiper-theme shadow-swiper"
                            data-swiper-options="{
                            'spaceBetween': 20,
                            'autoplay': true,
                            'autoplayTimeout': 1000,
                            'slidesPerView': 1,
                            'breakpoints': {
                                '480': {
                                    'slidesPerView': 3
                                },
                                '576': {
                                    'slidesPerView': 4
                                },
                                '768': {
                                    'slidesPerView': 5
                                },
                                '992': {
                                    'slidesPerView': 6
                                },
                                '1200': {
                                    'slidesPerView': 6,
                                    'spaceBetween': 30
                                }
                            }
                        }">
                            <div class="swiper-wrapper row gutter-lg cols-xl-8 cols-lg-7 cols-md-6 cols-sm-4 cols-xs-3 cols-2">
                              <?php
                              foreach($categories_slider  as $categories_slider_row)
                              {
                              ?>
                                
                                <div class="swiper-slide category-wrap">
                                    <div class="category category-ellipse">
                                        <figure class="category-media">
                                            <a href="<?=base_url()?>new-arrivals?category=<?=$categories_slider_row['category_slug']?>">
                                                <img src="<?=base_url()?><?=$categories_slider_row['image']?>" class="cat-img" alt="<?=$categories_slider_row['category_name']?>"
                                                    width="190" height="190" style="background-color: #5C92C0;" />
                                            </a>
                                        </figure>
                                        <div class="category-content">
                                            <h4 class="category-name">
                                                <a href="<?=base_url()?>new-arrivals?category=<?=$categories_slider_row['category_slug']?>"><?=$categories_slider_row['category_name']?></a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                              <?php
                              }
                              ?>
                                
                            </div>
                            <!--<div class="swiper-pagination"></div>-->
                        </div>
                    </div>
                   
                 <?php
				 }
                 ?>
                    <!-- End of Shop Category -->
				<?php
				if($banners)
				{
				    foreach($banners as $banner_row)
				    {
				        if($banner_row['slug']=='offer-banner')
				        {
				    
				?>
				<div class="banner banner-fixed sale-on-banner br-sm">
                    <figure>
                        <img src="<?=base_url()?><?=$banner_row['image']?>" alt="<?=$banner_row['title']?>"
                            width="680" height="180" style="background-color: #2F3237;" />
                    </figure>   
                    <div class="banner-content text-center x-50 y-50 mt-1" style="color: white;">
                        <?=$banner_row['banner_desc']?>
                    </div>
                </div>
                <?php
				}
				    }
                }
                ?>
                <!-- End of sale-on-banner  -->
				
                    <div class="row">
					    <div class="intro-banner-wrapper col-lg-3 mt-4">
                            <div class="banner banner-fixed intro-banner col-lg-12 col-sm-6 br-sm mb-4">
                                <figure>
                                    <img src="<?=base_url()?>assets/frontend/images/demos/demo11/banner/banner-1.jpg" alt="Category Banner" width="680" height="180" style="background-color: #E4E7EC;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-capitalize text-default font-secondary font-weight-normal">Top Products</h4>
                                    <h3 class="banner-title text-dark text-uppercase ls-25">Soft Towel</h3>
                                    <a href="<?=base_url('new-arrivals')?>" class="btn btn-white btn-outline btn-rounded btn-icon-right br-xs slide-animate">
                                        Shop Now<i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End of Intro Banner -->    
                            <div class="banner banner-fixed intro-banner col-lg-12 col-sm-6 intro-banner2 mb-4 br-sm">
                                <figure>
                                    <img src="<?=base_url()?>assets/frontend/images/demos/demo11/banner/banner-2.jpg" alt="Category Banner" width="680" height="180" style="background-color: #33363B;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-capitalize font-secondary font-weight-normal">New Arrivals</h4>
                                    <h3 class="banner-title text-white text-uppercase ls-25">Fresh Cameras</h3>
                                    <a href="<?=base_url('new-arrivals')?>" class="btn btn-white btn-outline btn-rounded btn-icon-right br-xs slide-animate">
                                        Shop Now<i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End of Intro Banner -->    
                        </div>
						
                        <div class="intro-slide-wrapper col-lg-6">
                            <div class="swiper-container swiper-theme animation-slider pg-inner pg-xxl-hide pg-show pg-white nav-xxl-show nav-hide" data-swiper-options = "{
                                'spaceBetween': 0,
                                'slidesPerView': 1
                            }">
                                <div class="swiper-wrapper gutter-no row cols-1">
                                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide1 br-sm text-center" 
                                        style="background-image: url(<?=base_url()?>assets/frontend/images/demos/demo11/slides/slide-1.jpg); background-color: #5B98B7;">
                                        <div class="banner-content y-50">
                                            <h3 class="banner-title text-capitalize text-white font-secondary font-weight-normal ls-0 slide-animate" 
                                                data-animation-options="{'name': 'fadeInLeftShorter', 'duration': '.5s', 'delay': '.2s'}">
                                                City Light
                                            </h3>
                                            <h4 class="banner-subtitle text-uppercase text-white font-weight-normal ls-0 slide-animate" 
                                                data-animation-options="{'name': 'fadeInRightShorter', 'duration': '.5s', 'delay': '.4s'}">
                                                New Trends This Season
                                            </h4>
                                            <span class="font-weight-bolder text-uppercase text-white slide-animate d-block ls-normal" 
                                                data-animation-options="{'name': 'fadeInRightShorter', 'duration': '.5s', 'delay': '.4s'}">
                                                Fashion Show 2021
                                            </span>
                                            
                                        </div>
                                    </div>
                                    <!-- End of Intro Slide 1 -->
                                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide2 br-sm"
                                        style="background-image: url(<?=base_url()?>assets/frontend/images/demos/demo11/slides/slide-2.jpg); background-color: #DFE0E4;">
                                        <div class="banner-content">
                                            <div class="slide-animate" data-animation-options="{
                                                'name': 'fadeInDownShorter', 'duration': '1s'
                                                }">
                                                <h3 class="banner-title text-capitalize text-dark font-secondary font-weight-normal mb-1">New Arrivals!</h3>
                                                <h4 class="banner-price-info text-capitalize text-dark mb-4 ls-25">
                                                    Lifestyle From <strong class="text-secondary">Rs.99.99</strong>
                                                </h4>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Intro Slide 2 -->
                                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide3 br-sm" style="background-image: url(<?=base_url()?>assets/frontend/images/demos/demo11/slides/slide-3.jpg); background-color: #ECECEC;">
                                        <div class="banner-content y-50">
                                            <div class="slide-animate" data-animation-options="{'name': 'fadeInLeftShorter', 'duration': '1s'}">
                                                <h3 class="banner-title text-capitalize text-dark font-secondary font-weight-normal">From Online Store</h3>
                                                <h4 class="banner-price-info text-dark ls-25">
                                                    <strong>Get up to</strong><br>
                                                    35% OFF!
                                                </h4>
                                                <div class="d-flex">
                                                    <a href="<?=base_url('new-arrivals')?>" class="btn btn-white btn-outline btn-rounded btn-icon-right br-xs slide-animate mt-4 mr-6">
                                                        Shop Now
                                                        <i class="w-icon-long-arrow-right"></i>
                                                    </a>
                                                    <img src="<?=base_url()?>assets/frontend/images/demos/demo11/sale-sm.png" alt="sale" width="196" height="136">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Intro Slide 3 -->
                                </div>
                                <div class="swiper-pagination"></div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                            </div>
                        </div>
                        <div class="intro-banner-wrapper col-lg-3 mt-4">
                            <div class="banner banner-fixed intro-banner col-lg-12 col-sm-6 br-sm mb-4">
                                <figure>
                                    <img src="<?=base_url()?>assets/frontend/images/demos/demo11/banner/banner-1.jpg" alt="Category Banner" width="680" height="180" style="background-color: #E4E7EC;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-capitalize text-default font-secondary font-weight-normal">Top Products</h4>
                                    <h3 class="banner-title text-dark text-uppercase ls-25">Soft Towel</h3>
                                    <a href="<?=base_url('new-arrivals')?>" class="btn btn-white btn-outline btn-rounded btn-icon-right br-xs slide-animate">
                                        Shop Now<i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End of Intro Banner -->    
                            <div class="banner banner-fixed intro-banner col-lg-12 col-sm-6 intro-banner2 mb-4 br-sm">
                                <figure>
                                    <img src="<?=base_url()?>assets/frontend/images/demos/demo11/banner/banner-2.jpg" alt="Category Banner" width="680" height="180" style="background-color: #33363B;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-capitalize font-secondary font-weight-normal">New Arrivals</h4>
                                    <h3 class="banner-title text-white text-uppercase ls-25">Fresh Cameras</h3>
                                    <a href="<?=base_url('new-arrivals')?>" class="btn btn-white btn-outline btn-rounded btn-icon-right br-xs slide-animate">
                                        Shop Now<i class="w-icon-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End of Intro Banner -->    
                        </div>
                    </div>
                </div>
                <!-- End of Intro-section -->
				
                <!-- End of Category Banner Wrapper -->
                <div class="banner-product-wrapper appear-animate row mb-6 pt-6">
                    <div class="col-xl-5 col-md-5">
                        <div class="categories bg-lightsky d-flex flex-column br-xs">
                            <h3 class="banner-title mb-0">BEST SELLERS</h3>
							<p>Our Selection of our Latest Best Sellers from Across our site. Get your latest Style Statement here at the Best Prices. COD Available across the Site on all your Purchases.</p>
                            <a href="#" class="btn-but-now font-weight-bold text-uppercase">
                                Buy Now<i class="w-icon-long-arrow-right"></i></a>
														
                        </div>
						<div class="">
							   <img src="<?=base_url()?>assets/frontend/images/demos/demo1/categories/3-2.jpg" alt="Category Banner"
                                    width="680" height="200" style="background-color: #444549;" />
									
                        </div>
                    </div>
                    <div class="product-wrapper col-xl-7 col-md-7">   
                        <div class="bg-grey pb-0 pt-0 swiper-container swiper-theme h-100" data-swiper-options="{
                            'spaceBetween': 15,
                             'autoplay': true,
                            'autoplayTimeout': 2000,
                            'slidesPerView': 2,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 1
                                },
                                '768': {
                                    'slidesPerView': 2
                                },
                                '992': {
                                    'slidesPerView': 2
                                },
                                '1300': {
                                    'slidesPerView': 3
                                }
                            }
                        }">
                            <div class="swiper-wrapper row cols-xl-4 cols-lg-3">
                                <?php
                                //print_r($products_slider);
                                foreach($products_slider as $product_row)
                                {
                                ?>
                                <div class="swiper-slide product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?=base_url()?>product/<?=$product_row['slug']?>">
                                                <?php
                                            $images = $this->db->get_where('product_image', ['product_id' => $product_row['product_id']])->result_array();
                                            $i_img=0;
                                            foreach($images as $image_row)
                                            {
                                                if($i_img<2)
                                                {
                                                ?>
                                             <img src="<?=base_url()?><?=$image_row['image']?>" alt="<?=$product_row['product_name']?>"
                                                    width="300" height="337">  
                                                <?php
                                                $i_img++;
                                                }
                                            }
                                            ?>
                                                

                                            </a>
                                            <!--<div class="product-action-horizontal">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart" title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" title="Wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare" title="Compare"></a>
                                                <a href="#" class="btn-product-icon btn-quickview w-icon-search" title="Quick View"></a>
                                            </div>-->
											<div class="product-label-group">
                                                <label class="product-label label-new">New</label>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="<?=base_url()?>product/<?=$product_row['slug']?>"><?=$product_row['product_name']?></a></h4>
                                            <!--<div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(3 Reviews)</a>
                                            </div>-->
                                            <div class="product-price">
                                                <?php
                                                if($product_row['offer_price']!='')
                                                {
                                                ?>
                                                <ins class="new-price amount">Rs. <?=$product_row['offer_price']?></ins>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                <ins class="new-price amount">Rs. <?=$product_row['price']?></ins>
                                                <?php    
                                                }
                                                ?>
                                            </div>
											<a href="<?=base_url()?>product/<?=$product_row['slug']?>" class="btn btn-primary product-btn-link">choose options</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
							<div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <!-- End of Swiper -->
                    </div>
                </div>
                <!-- End of Banner Product Wrapper -->

                 <div class="post-wrapper appear-animate mb-6 pt-6">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0">Offer More Than 50%</h2>
                        <a href="<?=base_url('new-arrivals')?>" class="font-weight-bold font-size-normal">View All</a>
                    </div>
                    <div class="product-wrapper col-xl-12 col-md-12">   
                        <div class="pb-0 pt-0 swiper-container swiper-theme h-100" data-swiper-options="{
                            'spaceBetween': 15,
                             'autoplay': true,
                            'autoplayTimeout': 2000,
                            'slidesPerView': 2,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 2
                                },
                                '768': {
                                    'slidesPerView': 3
                                },
                                '992': {
                                    'slidesPerView': 3
                                },
                                '1300': {
                                    'slidesPerView': 5
                                }
                            }
                        }">
                            <div class="swiper-wrapper row cols-xl-12 cols-lg-12">
                                <?php
                                //print_r($products_slider);
                                foreach($off_products_slider as $product_row)
                                {
                                ?>
                                <div class="swiper-slide product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?=base_url()?>product/<?=$product_row['slug']?>">
                                                <?php
                                            $images = $this->db->get_where('product_image', ['product_id' => $product_row['product_id']])->result_array();
                                            $i_img=0;
                                            foreach($images as $image_row)
                                            {
                                                if($i_img<2)
                                                {
                                                    if($i_img==0)
                                                    {
                                                ?>
                                             <img src="<?=base_url()?><?=$image_row['image']?>" alt="<?=$product_row['product_name']?>"
                                                    style="width: 300px !important;   height: 210px !important;">  
                                                <?php
                                                $i_img++;
                                                }
                                                else
                                                {
                                                  ?>
                                             <img src="<?=base_url()?><?=$image_row['image']?>" alt="<?=$product_row['product_name']?>"
                                                    width="300" height="337">  
                                                <?php  
                                                }
                                                }
                                                
                                                
                                            }
                                            ?>
                                                

                                            </a>
                                            <!--<div class="product-action-horizontal">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart" title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" title="Wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare" title="Compare"></a>
                                                <a href="#" class="btn-product-icon btn-quickview w-icon-search" title="Quick View"></a>
                                            </div>-->
											<div class="product-label-group">
                                                <label class="product-label label-new off-lable" style="background: red !important;"><?=$product_row['off']?>% Off</label>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="<?=base_url()?>product/<?=$product_row['slug']?>"><?=$product_row['product_name']?></a></h4>
                                            <!--<div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(3 Reviews)</a>
                                            </div>-->
                                            <div class="product-price">
                                                <?php
                                                if($product_row['offer_price']!='')
                                                {
                                                ?>
                                                <ins class="new-price amount">Rs. <?=$product_row['offer_price']?></ins>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                <ins class="new-price amount">Rs. <?=$product_row['price']?></ins>
                                                <?php    
                                                }
                                                ?>
                                            </div>
											<a href="<?=base_url()?>product/<?=$product_row['slug']?>" class="btn btn-primary product-btn-link">choose options</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
							<div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <!-- End of Swiper -->
                    </div>
                </div>
                <!-- Post Wrapper -->
				
            </div>
            <!-- End of Container -->
			
			<div class="swiper-container swiper-theme icon-box-wrapper br-sm" data-swiper-options="{
                    'loop': true,
                    'spaceBetween': 10,
                    'autoplay': false,
                    'autoplayTimeout': 4000,
                    'slidesPerView': 1,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2
                        },
                        '768': {
                            'slidesPerView': 2
                        },
                        '992': {
                            'slidesPerView': 3
                        },
                        '1200': {
                            'slidesPerView': 4
                        }
                    }
                    }">
                    <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                        <div class="swiper-slide icon-box icon-box-side text-dark">
                            <span class="icon-box-icon icon-shipping">
                                <i class="w-icon-truck"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bolder">Free Shipping & Returns</h4>
                                <p class="text-default">For all orders over $99</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side text-dark">
                            <span class="icon-box-icon icon-payment">
                                <i class="w-icon-bag"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bolder">Secure Payment</h4>
                                <p class="text-default">We ensure secure payment</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side text-dark icon-box-money">
                            <span class="icon-box-icon icon-money">
                                <i class="w-icon-money"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bolder">Money Back Guarantee</h4>
                                <p class="text-default">Any back within 30 days</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side text-dark icon-box-chat">
                            <span class="icon-box-icon icon-chat">
                                <i class="w-icon-chat"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bolder">Customer Support</h4>
                                <p class="text-default">Call or email us 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>

        </main>
        <!-- End of Main -->
        
        