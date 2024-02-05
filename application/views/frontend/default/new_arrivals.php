 <!---loder product ajax --->
 <div class="overlay-spinner"></div>
 
 <!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <!-- Start of Shop Banner -->
                    <!--<div class="shop-default-banner banner d-flex align-items-center mb-5 br-xs"
                        style="background-image: url(assets/images/shop/banner1.jpg); background-color: #FFC74E;">
                        <div class="banner-content">
                            <h4 class="banner-subtitle font-weight-bold">Accessories Collection</h4>
                            <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-normal">Smart Wrist
                                Watches</h3>
                            <a href="shop-banner-sidebar.html" class="btn btn-dark btn-rounded btn-icon-right">Discover
                                Now<i class="w-icon-long-arrow-right"></i></a>
                        </div>
                    </div>-->
                    <!-- End of Shop Banner -->

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
					
					      <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="index.html">Home</a></li>
                        <li>NewArrivals</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg mb-10">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <div class="filter-actions">
                                        <label>Filter :</label>
                                        <!--<a href="#" class="btn btn-dark btn-link filter-clean">Clean All</a>-->
                                    </div>
                                    <!-- Start of Collapsible widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>All Categories</label></h3>
                                        
                                        <ul class="widget-body filter-items search-ul categories_filter item-check mt-1">
                                            
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Price</label></h3>
                                        <div class="widget-body">
                                            <ul class="filter-items search-ul">
                                                <li ><a href="javascript:void(0)" class="filter_check" at="0,500">Rs. 0.00 - Rs. 500.00</a></li>
                                                <li><a href="javascript:void(0)" class="filter_check" at="500,1000">Rs. 500.00 - Rs. 1000.00</a></li>
                                                <li><a href="javascript:void(0)" class="filter_check" at="1000,1500">Rs. 1000.00 - Rs. 1500.00</a></li>
                                                <li><a href="javascript:void(0)" class="filter_check" at="1500,2000">Rs. 1500.00 - Rs. 2000.00</a></li>
                                                <li><a href="javascript:void(0)" class="filter_check" at="2000">Rs. 2000.00+</a></li>
                                            </ul>
                                            <form class="price-range">
                                               
                                                <input type="number" name="min_price" class="min_price text-center"
                                                    placeholder="$min"><span class="delimiter">-</span><input
                                                    type="number" name="max_price" class="max_price text-center"
                                                    placeholder="$max"><a href="javascript:void(0)"
                                                    class="btn btn-primary btn-rounded filter_check">Go</a>
                                                   
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Size</label></h3>
                                        <ul class="widget-body filter-items  sizes_filter">
                                            
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <!--<div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Brand</label></h3>
                                        <ul class="widget-body filter-items item-check mt-1">
                                            <li><a href="#">Elegant Auto Group</a></li>
                                            <li><a href="#">Green Grass</a></li>
                                            <li><a href="#">Node Js</a></li>
                                            <li><a href="#">NS8</a></li>
                                            <li><a href="#">Red</a></li>
                                            <li><a href="#">Skysuite Tech</a></li>
                                            <li><a href="#">Sterling</a></li>
                                        </ul>
                                    </div>-->
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Color</label></h3>
                                        <ul class="widget-body filter-items colors_filter">
                                            
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->

                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            <nav class="toolbox sticky-toolbox sticky-content fix-top">
                                <div class="toolbox-left">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle 
                                        btn-icon-left d-block d-lg-none"><i
                                            class="w-icon-category"></i><span>Filters</span></a>
                                    <div class="toolbox-item toolbox-sort select-box text-dark">
                                        <label>Sort By :</label>
                                        <select name="orderby" class="form-control" id="sort_by_product">
                                            <option value="default" selected="selected">Default sorting</option>
                                            <!--<option value="popularity">Sort by popularity</option>
                                            <option value="rating">Sort by average rating</option>-->
                                            <option value="date">Sort by latest</option>
                                            <option value="price-low">Sort by pric: low to high</option>
                                            <option value="price-high">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="toolbox-right">
                                    <div class="toolbox-item toolbox-show select-box">
                                        <select name="count" class="form-control" id="count_product">
                                            <option value="12" selected="selected">Show 12</option>
                                            <option value="24">Show 24</option>
                                            <option value="36">Show 36</option>
                                        </select>
                                    </div>
                                    <div class="toolbox-item toolbox-layout">
                                        <a href="shop-banner-sidebar.html" class="icon-mode-grid btn-layout active">
                                            <i class="w-icon-grid"></i>
                                        </a>
                                        <!--<a href="shop-list.html" class="icon-mode-list btn-layout">
                                            <i class="w-icon-list"></i>
                                        </a>-->
                                    </div>
                                </div>
                            </nav>
                            <div class="product-wrapper new_arrival_product-wrapper row cols-md-3 cols-sm-2 cols-2">
                                
                                
                            </div>

                            <div class="toolbox toolbox-newarrival-pagination justify-content-between" style="padding-top: 100px;">
                                
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->
        
        
