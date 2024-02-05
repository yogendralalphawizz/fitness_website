<div class="cart-main-area pb-100">
                <div class="container">
                    <div class="row">
                        <?php
                        if($wishlists)
                        {
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 50px;">
                            <center><h1 class="cart-heading">WISHLIST</h1> <center>
                                    
            <form action="#">
                                <div class="table-content table-responsive">
                                    <table>
                                        <thead>
                                           
                                            <tr>
                                                
                                               <th class="product-name"></th>
                                                <th class="product-name" colspan="2" style="width: 30%;">Item</th>
                                              <!--  <th class="product-price master_hider">Price</th>-->
                                                <th class="product-quantity">Price</th>
                                               
                                                 
                                                 <th class="product-subtotal ">Action</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                         <?php
                                        
                                            foreach($wishlists as $row)
                                            {
                                            $images = $this->db->get_where('product_image', ['product_id' => $row['wishlist_product_id']])->row_array();
                                            $product = $this->db->get_where('products', ['product_id' => $row['wishlist_product_id']])->row_array();

                                            ?>    
                                            <tr class="row_bottom" id="wishlist_id_70">
                                             <td style="width: 12%;">
                                                 	<img src="<?=base_url()?><?=$images['image']?>" alt="" width="80" height="80">
                                                 	<?php
                                                if($this->session->userdata('user_id'))
                                                {
                                                $data_found = $this->db->get_where('wishlist', ['wishlist_product_id' => $product['product_id'] , 'wishlist_user_id' => $this->session->userdata('user_id')])->num_rows();
                                                if($data_found==0)
                                                {
                                                ?>
                                                <a href="javascript:void(0)"  data-pid="<?=$product['product_id']?>" class="wishlist_page wishlist_icone_top_<?=$product['product_id']?> add-wishlist btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                <a href="javascript:void(0)"  data-pid="<?=$product['product_id']?>" class="wishlist_page wishlist_icone_top_<?=$product['product_id']?> add-wishlist btn-product-icon btn-wishlist w-icon-heart-full"><span></span></a>
                                                <?php
                                                }
                                                
                                                }
                                                
                                            
                                                ?>
                                                 	</td>
                                                 <td class="product-name" colspan="2">
												<a href="<?=base_url()?>product/<?=$product['slug']?>">
												<div class="row">
												
													<div class="col-sm-12">
													<span>
													<?=$product['product_name']?>
													</span>
													</div>
													</div>
												</a>
												</td>
                                                <td class="product-quantity">
                                                    <div class="row">
                                                        <div class="col-12">
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
                                                         <div class="col-12">
                                                                                                                           
                                                            <span class="text-success">In Stock</span>
                                                                                                                    </div>
                                                        
                                                    </div>
                                                    
                               
                                                </td>
                                              
                                                <td class="product-quantity">
                                              
                           <div class="action_link cart_button_1" id="cart_button_1">
                               <a href="<?=base_url()?>product/<?=$product['slug']?>" class="btn btn-danger">Add To Cart</a>
                           </div>
                                           
                            </td>
  
                                            </tr>
                                         <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
								<div class="row">
								<div class="col-lg-12 pt-14" style="text-align:left;">
								 <a href="<?=base_url('new-arrivals')?>" class="color_font"><h6 class="color_font"> <i class="ion-ios-arrow-back"></i> Continue Shopping</h6></a>
								 </div>
								
								 </div>
                             
                            </form>
                         </center></center></div>
                         <?php
                        }
                        else
                        {
                            ?>
                        <h2 style="color:red;text-align: center;    margin: 100px;">Wishlist Empty!</h2>    
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>