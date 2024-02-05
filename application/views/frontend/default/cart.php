<div class="cart-main-area pt-15 pb-100">
                <div class="container">
                    <div class="row emptycart">
                         <?php
                            if(empty($this->cart->contents()))
                            {
                                ?>
                                <h3 style="margin: 15%;
    text-align: center;
    color: red;">Shoping Cart Empty !</h3>
                                <?php
                            }
                            else
                            {
                            ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin: 50px 0px;">
                            <div class="cart_page_details">
                            <center><h1 class="cart-heading">SHOPPING CART</h1> </center>
                           
                            <div class="table-content table-responsive">
                                    <table>
                                        <thead>
                                            <tr style="text-align: left;">
                                               <!-- <th class="product-name">
												<label class="checkbox_container">All
												  <input type="checkbox"  name="checkAll" id="checkAll">
												  <span class="checkmark"></span>
												</label>
                                                   </th>-->
                                                <th class="product-name"></th>
                                                <th class="product-name switchable" colspan="1">Item</th>
                                                <th class="product-price master_hider">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Total</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php
                        $total_amount=0;
                        foreach ($this->cart->contents() as $items)
                        {
                        ?>
                                            <tr class="row_bottom">
                                              
                                             <td style="width: 12%;">
                                                 <img src="<?=base_url()?><?=$items['image']?>" alt="" width="80" height="80">
                                             </td>
                                                 <td class="product-name switchable" colspan="1">
												<a href="#">
												<div class="row">
												
													<div class="col-sm-12 font_changer" style="font-size: 15px;">
													   <span><?=$items['name']?></span>
													</div>
													</div>
												</a>
												</td>
                                                <td class="product-price master_hider"><span class="amount">Rs.
                                                <?php
                                                if($items['offer_price']!='')
                                                {
                                                    echo $items['offer_price'];
                                                }
                                                else
                                                {
                                                    $items['price'];
                                                }
                                                ?></span></td>
                                                <td class="product-quantity ">
                                                    <div class="row">
                                                        <div class="col-12 quantity master_qty">
                                                <div class="quantity-nav"><div class="quantity-button quantity-down">-</div></div><input type="number" style="background:initial;border-style: initial;" class="<?=$items['rowid']?> qty_manager" name="<?=$items['rowid']?>" value="<?=$items['qty']?>" min="1" max="50"  maxlength="3"  onkeyup="return false" onchange="checking_max_qty('<?=$items['rowid']?>')" readonly=""><div class="quantity-nav"><div class="quantity-button quantity-up">+</div></div>
                                               
                                                        </div>
                                                        <div class="col-12">
                                                  <a style="padding: 0px 18px;text-decoration: underline;" onclick="remove_cart_item('<?=$items['rowid']?>')" href="javascript:void(0)">Remove <!--<i  class="ti-trash fontsize24 hvr-buzz-out"></i>--></a>

                                                        </div>
                                                    </div>
                                   
                                                </td>
                                        <td class="product-subtotal product_subtotal_<?=$items['rowid']?>">Rs.
                                            <?php
                                                if($items['offer_price']!='')
                                                {
                                                    echo floatval($items['qty'])*floatval($items['offer_price']);
                                                    $total_amount+=floatval($items['qty'])*floatval($items['offer_price']);
                                                }
                                                else
                                                {
                                                    echo floatval($items['qty'])*floatval($items['price']);
                                                    $total_amount+=floatval($items['qty'])*floatval($items['price']);
                                                }
                                                ?>
                                        </td>
                                                
                                            </tr>
                        <?php
                        }
                        ?>
<tr class="row_bottom">
    <td colspan="1" class="product-subtotal" style="text-align:right;">  </td>
    <td colspan="1" class="product-subtotal switchable" style="text-align:right;">  </td>
    <td colspan="1" class="product-subtotal master_hider" style="text-align:right;">  </td>
     <td colspan="1" class="product-subtotal-qty" style="text-align:left;padding:8px 15px;font-weight:900;"></td>
    <td colspan="2" class="product-subtotal" style="padding:8px 15px;"> <strong id="subtotal_accumulator amount">Rs.<?=$total_amount?></strong> </td>
</tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
								<div class="row" style="margin-top: 25px;">
								 <div class="col-lg-8 pt-14 responsive_bottom_aligner">
								 <a href="<?=base_url()?>" class="color_font"><h6 class="color_font"> <i class="ion-ios-arrow-back"></i> Continue Shopping</h6></a>
								 </div> 
								
								 <div class="col-lg-2 responsive_bottom_aligner">
								     								      <button onclick="location.href = '<?=base_url()?>Home/remove/all';" class="default-cbtn" style="margin: 5px;"><span> CLEAR CART</span></button>

								  </div>
								  <div class="col-lg-2 responsive_bottom_aligner">
								  
								 								    <button onclick="location.href ='<?=base_url()?>checkout';" class="default-cbtn " style="margin: 5px;"><span>CHECKOUT</span></button> 

								  <!--<button type="button" class="default-btn float_right" style="float:right;margin: 5px;" onclick="cart_product_deleter()"><span><i class="ion-close-round"></i> DELETE</span></button>-->
							 <!-- <button type="submit" class="default-cbtn" form="update_cart_form" style="float:right;margin: 5px;"><span>UPDATE CART</span></button>-->
								 
								 </div>
								 </div>
								
								
						
                                             </div>
                                             <?php
                            }
                            ?>
                </div>
            </div>

</div>
                                             
                                       