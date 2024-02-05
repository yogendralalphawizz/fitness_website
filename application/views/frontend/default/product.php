 <!-- Start of Main -->
        <main class="main mb-10 pb-1">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav container">
                <ul class="breadcrumb bb-no">
                    <li><a href="demo1.html">Home</a></li>
                    <li>Products</li>
                </ul>
           
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg">
                        <div class="main-content">
                            <div class="product product-single row">
                                <div class="col-md-5 mb-5">
                                    <div class="product-gallery product-gallery-sticky">
                                        <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                            <div class="swiper-wrapper row cols-1 gutter-no">
                                                <?php
                                                if(isset($product_images))
                                                {
                                                foreach($product_images as $row_image)
                                                {
                                                ?>
                                                <div class="swiper-slide">
                                                    <figure class="product-image">
                                                        <img src="<?=base_url()?><?=$row_image['image']?>"
                                                            data-zoom-image="<?=base_url()?><?=$row_image['image']?>"
                                                            alt="<?=$product_detial['product_name']?> Image" width="800" height="900">
                                                    </figure>
                                                </div>
                                            <?php
                                                }
                                                }
                                                ?>
                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                            <a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>
                                        </div>
                                        <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                            <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                                <?php
                                                if(isset($product_images))
                                                {
                                                foreach($product_images as $row_image)
                                                {
                                                ?>
                                                <div class="product-thumb swiper-slide">
                                                    <img src="<?=base_url()?><?=$row_image['image']?>"
                                                        alt="<?=$product_detial['product_name']?> Product Thumb" width="800" height="900">
                                                </div>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-7 mb-5 mb-md-7">
                                    <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                        <h1 class="product-title"><?=$product_detial['product_name']?></h1>
                                        <?php
                                        if($product_detial['off']!='')
                                        {
                                        ?>
                                        <span class="product-label product-label--on-sale"><?=$product_detial['off']?>% OFF</span>
                                        <?php
                                        }
                                        ?>
                                        <div class="product-bm-wrapper">
                                           <?php
                                           if($product_detial['category']!='')
                                                    {
                                           ?>
                                            <div class="product-meta">
                                                <div class="product-categories">
                                                    Category:
                                                    <?php 
                                                    
                                                    $cat_slug_arr=explode(",",$product_detial['category']);
                                                    for($i=0;$i<count($cat_slug_arr);$i++)
                                                    {
                                            $category = $this->db->get_where('categories', ['category_slug' => $cat_slug_arr[$i]])->row_array();
                                            ?>
                                        <span class="product-category"><a href="<?=base_url('/new-arrivals?category=')?><?=$category['category_slug']?>&sort_by=default&count=12"><?=$category['category_name']?></a></span>
                                            <?php
                                                    }
                                                    
                                                    ?>
                                                </div>
                                               
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <hr class="product-divider">

                                        <div class="product-price">
                                            <?php
                                            if($product_detial['offer_price']!='')
                                            {
                                            ?>
                                            <ins class="new-price"><strike>Rs.<?=$product_detial['price']?></strike></ins>
                                            <ins class="new-price">Rs.<?=$product_detial['offer_price']?></ins>
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                            <ins class="new-price">Rs.<?=$product_detial['price']?></ins>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <!--<div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 80%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#product-tab-reviews" class="rating-reviews scroll-to">(3
                                                Reviews)</a>
                                        </div>-->
                                    <?php
                                    if($product_detial['offer_desc']!='')
                                    {
                                       ?>
                                       <div class="product-short-desc">
                                            <?=$product_detial['offer_desc']?>
                                        </div>
                                        <span class="product_desc_show" id="1desc_show_more">Show More</span>
                                        <span class="product_desc_hide" style="display:none" id="1desc_show_more">Show Less</span>

                                       <?php
                                    }
                                    ?>
                                    
                                        

                                        <hr class="product-divider">

                                        <div class="product-form product-variation-form product-color-swatch">
                                            <label>Color:</label>
                                            <div class="d-flex align-items-center product-variations color-variations">
                                                <?php
                                                foreach($product_colors as $color_row)
                                                {
                                                    ?>
                                                <a href="javascript:void(0)" class="color" at="<?=$color_row['color']?>" style="background-color: <?=$color_row['color']?>"></a>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>
                                        </div>
                                        <div class="product-form product-variation-form product-size-swatch">
                                            <label class="mb-1">Size:</label>
                                            <div class="flex-wrap d-flex align-items-center product-variations size-variations">
                                                <?php
                                                foreach($product_sizes as $size_row)
                                                {
                                                    ?>
                                                <a href="javascript:void(0)" at="<?=$size_row['size']?>" class="size"><?=$size_row['size']?></a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="product-form product-variation-form product-size-swatch">
                                            <label class="mb-1">Style:</label>
                                            <div class="flex-wrap d-flex align-items-center product-variations style">
                                                <?php
                                                if($product_detial['style'])
                                                {
                                                    ?>
                                                <?=$product_detial['style']?>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        

                                        <div class="product-sticky-content sticky-content">
                                            <div class="product-form container">
                                                <div class="product-qty-form">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" type="number" min="1"
                                                            max="10000000">
                                                        <button class="quantity-plus w-icon-plus"></button>
                                                        <button class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary cartbtn" product_id="<?=base64_encode($product_detial['product_id'])?>">
                                                    <i class="w-icon-cart"></i>
                                                    <span>Add to Cart</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="social-links-wrapper">
                                            <div class="social-links">
                                                <div class="social-icons social-no-color border-thin">
                                                    <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                    <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                    <a href="#"
                                                        class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                    <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                    <a href="#"
                                                        class="social-icon social-youtube fab fa-linkedin-in"></a>
                                                </div>
                                            </div>
                                            <span class="divider d-xs-show"></span>
                                            <div class="product-link-wrapper d-flex">
                                                <?php
                                                if($this->session->userdata('user_id'))
                                                {
                                                    $data_found = $this->db->get_where('wishlist', ['wishlist_product_id' => $product_detial['product_id'] , 'wishlist_user_id' => $this->session->userdata('user_id')])->num_rows();
                                                    if($data_found==0)
                                                    {
                                                    ?>
                                                        <a href="javascript:void(0)"  data-pid="<?=$product_detial['product_id']?>" class="wishlist_icone_top_<?=$product_detial['product_id']?> add-wishlist btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <a href="javascript:void(0)"  data-pid="<?=$product_detial['product_id']?>" class="wishlist_icone_top_<?=$product_detial['product_id']?> add-wishlist btn-product-icon btn-wishlist w-icon-heart-full"><span></span></a>
                                                    <?php
                                                    }
                                                }
                                                
                                                else
                                                {
                                                    ?>
                                                <a href="javascript:void(0)"  data-pid="<?=$product_detial['product_id']?>" class="wishlist_icone_top_<?=$product_detial['product_id']?> add-wishlist btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
					      <section class="mt-3 without-bg-section pb-1">
	<div class="accordion-container">
  <div class="set">
    <a href="javascript:void(0);">
      Description
      <i class="fa fa-plus"></i>
    </a>
    <div class="content">
      <p><?=$product_detial['product_desc']?></p>
    </div>
  </div>
  <div class="set">
    <a href="javascript:void(0);">
      Specification
      <i class="fa fa-plus"></i>
    </a>
    <div class="content">
      <p><?=$product_detial['specification']?></p>
    </div>
  </div>
  
</div>				          
                        </div>
						
                    </section>
                                </div>
                            </div>
                   
                            <section class="related-product-section">
                                <div class="title-link-wrapper mb-4">
                                    <h4 class="title">Related Products</h4>
                                   
                                </div>
                                <div class="swiper-container swiper-theme" data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 5
                                        }
                                    }
                                }">
                                    <div class="swiper-wrapper row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                                        <?php
                                        //print_r($product_match);
                                        foreach($product_match as $product)
                                        {
                                        ?>
                                        <div class="swiper-slide product">
                                            <figure class="product-media">
                                                <a href="<?=base_url()?>product/<?=$product['slug']?>">
                                                    <?php
                                            $images = $this->db->get_where('product_image', ['product_id' => $product['product_id']])->row_array();
                                            
                                                    ?>
                                                    <img src="<?=base_url()?><?=$images['image']?>" alt="<?=$product['product_name']?>"
                                                        width="300" height="338" />
                                                </a>
                                                <!--<div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                        title="Add to cart"></a>
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist"></a>
                                                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                        title="Add to Compare"></a>
                                                </div>
                                                <div class="product-action">
                                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                        View</a>
                                                </div>-->
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?=base_url()?>product/<?=$product['slug']?>"><?=$product['product_name']?></a></h4>
                                               <!-- <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="<?=base_url()?>product/<?=$product['slug']?>" class="rating-reviews">(3 reviews)</a>
                                                </div>-->
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <?php
                                                    if($product['offer_price'])
                                                    {
                                                        echo '<strike>Rs. '.$product['price'].'</strike> | Rs. '.$product['offer_price'];
                                                    }
                                                    else
                                                    {
                                                       echo 'Rs. '.$product['price']; 
                                                    }
                                                    ?>
                                                       
                                                        
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <!-- End of Main Content -->

                    </div>
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->