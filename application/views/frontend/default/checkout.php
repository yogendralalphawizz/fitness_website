<div class="checkout-area ">
      <div class="container">
      <div class="row">
         <!-- Start of LEFT Portion -->	
         <div class="col-lg-6 col-md-12 col-12 pb-80">
            <div class="breadcrumb-area bg-img mb-10 pt-15">
               <div id="accordion" class="accordion mobile_product_viewer pb-20">
                  <div class="card mb-0">
                     <div class="card-header collapsed" data-toggle="collapse" href="#cart_product">
                        <a class="card-title toggle_cart_icon">
                           <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__icon">
                              <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z"></path>
                           </svg>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="breadcrumb-content-2">
                  <ul>
                                          <li class="breadcrumb-item">
                        <a href="<?=base_url()?>cart">Cart</a><i class="fa fa-angle-double-right color_modifier_right"></i>
                        <strong class="strong_highlight chekout_form">Address Information</strong><i class="fa fa-angle-double-right color_modifier_right"></i>
                        <span class="chekout_payment">Payment</span>
                     </li>
                      
                                                            </ul>
               </div>
            </div>
            <!--ADRESS AND BILLING SHIPPING DETAILS-->					
            <div class="checkout-billing-details-wrap">
                                          
               <!--Step Form Parameter-->  


               <div class="billing-form-wrap mt-30 address_checkout" style="display:block">
                  <h5 class="checkout-title fontsize20">Billing address</h5>
                <form action="<?=base_url()?>/order/56cdc14e-e197-401a-8494-5f439bd05a21" method="post" id="order_form" enctype="multipart/form-data">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="single-input-item form-label-group">
                              <input type="text" id="f_name" class="form-control" required placeholder="First Name" name="first_name" value="<?=$this->session->userdata('firstname')?>" required="">
                              <label for="f_name" class="required">First Name</label>
                                                         </div>
                        </div>
                        <div class="col-md-6">
                           <div class="single-input-item form-label-group">
                              <input type="text" id="l_name" class="form-control" required placeholder="Last Name" name="last_name" value="<?=$this->session->userdata('lastname')?>" required="">
                              <label for="l_name" class="required">Last Name</label>
                                                         </div>
                        </div>
                     </div>
                     <div class="single-input-item form-label-group">
                              <input type="email" value="" id="email" placeholder="Email" name="email" required class="form-control">
                              <label for="email" class="required">Email</label>
                                                         </div>
                     <div class="single-input-item  form-label-group">
                        <input type="text" id="bill_street_line_1" required placeholder="Street address Line 1" name="street_line_1" class="form-control" value="" required="">
                        <label for="bill_street_line_1" class="required">Address</label>
                                             </div>
                     <div class="single-input-item form-label-group">
                        <input type="text" id="bill_street_line_2" placeholder="Apartment, suite, etc. (optional)" name="street_line_2" class="form-control" value="">
                        <label for="bill_street_line_2" class="required">Apartment, suite, etc. (optional)</label>
                     </div>
                     <div class="single-input-item form-label-group">
                        <input type="text" id="bill_town" required placeholder="Town / City" name="city" class="form-control" value="" required="">
                        <label for="bill_town" class="required">Town / City</label>
                                             </div>
                     <div class="row">
                        <div class="col-md-4">
                           <select class="country form-control ptx-16" id="country"  name="country" required>
                              <option value="">--Country--</option>
                                                            <option data-countrycode="IN" value="IN">India</option>
                                                            </select>
                           <label for="country" class="select_modifier">Country</label>
                                                   </div>
                        <div class="col-md-4">
                           <div class="single-input-item form-label-group">
                              <input type="text" required id="bill_state" placeholder="State / Province" name="state" class="form-control" value="">
                              <label for="bill_state" class="required">State / Province</label>
                                                         </div>
                        </div>
                        <div class="col-md-4">
                           <div class="single-input-item form-label-group">
                              <input type="text" required id="bill_postcode" placeholder="Postcode / ZIP" name="zipcode" class="form-control" value="" required="">
                              <label for="bill_postcode" class="required">Postcode / ZIP</label>
                                                         </div>
                        </div>
                     </div>
                     <div class="single-input-item form-label-group">
                        <input type="text" id="bill_phone" required placeholder="Phone" name="phone" class="form-control" value="">
                        <label for="bill_phone" class="required">Phone</label>
                                             </div>
                     <div class="checkout-box-wrap ">
                        <label class="fontsize16 checkbox_container" for="address_set">Set Shipping Address As Billing Address
                        <input type="radio" class="shipment_choice custom-control-input address_setter" checked="" id="address_set" name="address_setter" value="same_shipment">
                        <span class="checkmark"></span>
                        </label>
                     </div>
                                          <div class="checkout-box-wrap shipment_addresses">
                        <label class="fontsize16 checkbox_container mb-25" for="shipment_to_master">Ship to a
                        different address?
                        <input type="radio" class="shipment_choice custom-control-input shipment_to" data-id="master" id="shipment_to_master" name="address_setter" value="other_shipment">
                        <span class="checkmark"></span>
                        </label>
                        <div class="ship-to-different account-create single-form-row" id="address_master" style="display: none">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="single-input-item form-label-group">
                                    <input type="text" value="" id="f_name_2" placeholder="First Name" name="shipment_fname" class="form-control">
                                    <label for="f_name_2" class="required">First Name</label>
                                                                     </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="single-input-item form-label-group">
                                    <input type="text" value="" id="l_name_2" placeholder="Last Name" name="shipment_lname" class="form-control">
                                    <label for="l_name_2" class="required">Last Name</label>
                                                                     </div>
                              </div>
                           </div>
                           <div class="single-input-item form-label-group">
                              <input type="email" value="" id="email_2" placeholder="Email" name="shipment_email" class="form-control">
                              <label for="email_2" class="required">Email</label>
                                                         </div>
                           <div class="single-input-item form-label-group">
                              <input type="text" value="" id="shipment_street_1" placeholder="Street address Line 1" class="form-control" name="shipment_street_1">
                              <label for="shipment_street_1" class="required">Address</label>
                                                         </div>
                           <div class="single-input-item form-label-group">
                              <input type="text" value="" placeholder="Apartment, suite, etc. (optional)" id="shipment_street_2" class="form-control" name="shipment_street_2">
                              <label for="shipment_street_2">Apartment, suite, etc. (optional)</label>
                           </div>
                           <div class="single-input-item form-label-group">
                              <input type="text" value="" id="city_2" placeholder="Town / City" name="shipment_city" class="form-control">
                              <label for="city_2">Town / City</label>
                                                         </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <select name="shipment_country" class="shipment_countries form-control ptx-16"  id="country_2">
                                    <option value="">--Country--</option>
                                                                        <option selected data-countrycode="IN" value="IN">India</option>
                                                                        </select>
                                 <label for="country_2" class="select_modifier">Country</label>
                                                               </div>
                              <div class="col-md-4">
                                 <div class="single-input-item form-label-group">
                                    <input type="text" value="" id="state_2" placeholder="State / Province" name="shipment_state" class="form-control">
                                    <label for="state_2">State / Province</label>
                                                                     </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="single-input-item form-label-group">
                                    <input type="text" value="" id="postcode_2" placeholder="Postcode / ZIP" name="shipment_zip" class="form-control">
                                    <label for="postcode_2">Postcode / ZIP</label>
                                                                     </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-input-item form-label-group">
                        <textarea name="ordernote" id="ordernote" cols="30" class="form-control" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        <!--<label for="ordernote">Order Instructions</label>-->
                     </div>
                  </form>
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pt-12 responsive_bottom_aligner ">
                        <a href="<?=base_url()?>cart" class="color_font">
                           <h6 class="color_font"> <i class="ion-ios-arrow-back"></i> Return to cart</h6>
                        </a>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 responsive_bottom_aligner">
                    <button type="button" form="order_form" value="Place order" class="default-cbtn desktop_rightfloater submit_address  btn-block">Next</button>
                     </div>
                  </div>
               </div>
               <!--END OF BILLING ADDRESS AND SHIPPING ADDRESS PLUS ORDER NOTE-->                           
               <!--FRESH STARTS OF SHIPPING METHOD-->          
                <div class="billing-form-wrap mt-50 payment_checkout" style="display:none">

               <!--FRESH STARTS OF SHIPPING METHOD ENDS HERE-->                                     
               <!--PAYMENT METHOD VIEWER-->                            
               <!--PAYMENT OPTIONS-->	
                                       
               <div class="billing-form-wrap mt-40 ">
                  <!--New Accordian Of Payments Viewer Card-->
                  <div class="section section--payment-method" data-payment-method="">
                     <div class="section__header">
                        <h5 class="checkout-title fontsize20">Payment</h5>
                        <p class="section__text fontsize16">
                           All transactions are secure and encrypted.
                        </p>
                     </div>
                     <div class="section__content">
                        <div data-payment-subform="required">
                           <fieldset class="content-box">
                              <legend class="visually-hidden">Choose a payment method</legend>
                              <!--<<<<<<<<<<<<<<<<<<<Credit Card--------------------------------------------->
                              <div class="radio-wrapper content-box__row " data-gateway-group="express" data-select-gateway="142313291">
                                 <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-6 col-xs-2">
                                       <div class="radio__input">
                                          <label class="radio_container">
                                          <input type="radio" id="tab-1" form="order_form" selected name="paymentmethod" value="cash" checked="">
                                          <span class="radio_checkmark"></span>
                                          </label>
                                       </div>
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-6 col-xs-10">
                                       <div class="radio__label  ">
                                          <label for="tab-1" class="radio__label__primary content-box__emphasis">
                                          Cash
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="radio-wrapper content-box__row content-box__row--secondary" data-subfields-for-gateway="142313291" id="payment-gateway-subfields-Credit_card" style="display:none">
                                 <div class="blank-slate">
                                    <i class="blank-slate__icon icon icon--offsite"></i>
                                    <p class="shown-if-js">After clicking “Complete order”, you will be redirected to Credit Card to complete your purchase securely.</p>
                                 </div>
                              </div>
                              <!--<<<<<<<<<<<<<<<<<<<----------------Credit Card ENDS------------------ -->
                              <!--<<<<<<<<<<<<<<<<<<<PayPal--------------------------------------------->
                              <div class="radio-wrapper content-box__row content-box__row--secondary" data-subfields-for-gateway="142313291" id="payment-gateway-subfields-Bank_transfer" style="display:none">
                                 <div class="blank-slate">
                                    <i class="blank-slate__icon icon icon--offsite"></i>
                                    <table>
                                       <tbody>
                                                                                    <tr class="row_bottom">
                                             <td class="select_bank">
                                                <label class="radio_container">
                                                <input type="radio" form="order_form" id="bank_id_1" name="select_bank" value="1" >
                                                <span class="radio_checkmark"></span>
                                                </label>
                                             </td>
                                             <td class="product-name">
                                                <div class="row">
                                                   <div class="col-sm-12">
                                                      <span>
                                                         <strong>BANK NAME</strong> 
                                                         <p class="m-0">BANK4546576879765</p>
                                                         <strong>BANK ACCOUNT</strong>
                                                         <p class="m-0"> XXXXXXXXXXXXXXXX</p>
                                                         <strong>SWIFT CODE</strong>
                                                         <p class="m-0"> XXXXXXXXX</p>
                                                      </span>
                                                   </div>
                                                </div>
                                             </td>
                                             <td class="bank_details-date">
                                                <span class="amount">
                                                LAST UPDATE <br>
                                                </span>
                                             </td>
                                             <td class="product-subtotal">
                                                <div class="image-upload">
                                                   <i>Only(jpg|png|jpeg are allowed of dimension 1024*768 of 10MB)</i>
                                                   <div id="wrapper" style="margin-top: 20px;">
                                                      <input id="fileUpload" form="order_form" name="slip_img_1" type="file"> 
                                                      <div id="image-holder1"></div>
                                                   </div>
                                                                                                        
                                                   
                                                </div>
                                             </td>
                                          </tr>
                                                                                    <tr class="row_bottom">
                                             <td class="select_bank">
                                                <label class="radio_container">
                                                <input type="radio" form="order_form" id="bank_id_2" name="select_bank" value="2">
                                                <span class="radio_checkmark"></span>
                                                </label>
                                             </td>
                                             <td class="product-name">
                                                <div class="row">
                                                   <div class="col-sm-12">
                                                      <span>
                                                         <strong>BANK NAME</strong> 
                                                         <p class="m-0">BANK4546576878475</p>
                                                         <strong>BANK ACCOUNT</strong>
                                                         <p class="m-0"> XXXXXXXXXXXXXXXX</p>
                                                         <strong>SWIFT CODE</strong>
                                                         <p class="m-0"> XXXXXXXXX</p>
                                                      </span>
                                                   </div>
                                                </div>
                                             </td>
                                             <td class="bank_details-date">
                                                <span class="amount">
                                                LAST UPDATE <br>
                                                </span>
                                             </td>
                                             <td class="product-subtotal">
                                                <div class="image-upload">
                                                   <i>Only(jpg|png|jpeg are allowed of dimension 1024*768 of 10MB)</i>
                                                   <div id="wrapper" style="margin-top: 20px;">
                                                      <input id="fileUpload" form="order_form" name="slip_img_2" type="file"> 
                                                      <div id="image-holder2"></div>
                                                   </div>
                                                                                                        
                                                   
                                                </div>
                                             </td>
                                          </tr>
                                                                                 </tbody>
                                    </table>
                                 </div>
                              </div>
                              <!--<<<<<<<<<<<<<<<<<<<PayPal ENds--------------------------------------------->
                              <!--<<<<<<<<<<<<<<<<<<<--------------------------------------------->
                              <div class="radio-wrapper content-box__row " data-gateway-group="express" data-select-gateway="142313291">
                                 <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-6 col-xs-2">
                                       <div class="radio__input">
                                          <label class="radio_container">
                                          <input type="radio" id="tab-3" form="order_form" name="paymentmethod" value="Razorpay" >
                                          <span class="radio_checkmark"></span>
                                          </label>
                                       </div>
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-6 col-xs-10">
                                       <div class="radio__label  ">
                                          <label for="tab-3" class="radio__label__primary content-box__emphasis">
                                          <img alt="PayPal" class="offsite-payment-gateway-logo" src="https://www.indiafintech.com/wp-content/uploads/2017/10/Razorpay-Logo.png">
                                          <span class="visually-hidden">
                                          Razorpay
                                          </span>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="radio-wrapper content-box__row content-box__row--secondary" data-subfields-for-gateway="142313291" id="payment-gateway-subfields-Paypal" style="display:block">
                                 <div class="blank-slate">
                                    <i class="blank-slate__icon icon icon--offsite"></i>
                                    <center><img src="https://www.indiafintech.com/wp-content/uploads/2017/10/Razorpay-Logo.png" width="200" class="img-rounded" alt="paypal_img"></center>
                                    <center>After clicking “Complete order”, you will be redirected to Razorpay to complete your purchase securely.</center>
                                 </div>
                              </div>
                              <!--<<<<<<<<<<<<<<<<<<<PayPal ENds--------------------------------------------->
                           </fieldset>
                        </div>
                     </div>
                  </div>
                  <!--New Accordian Of Payments Viewer Card Ends-->
                  <!--+++++++++++SUBMITTER WITH REMEBER ME+++++++++++++++-->
                  <div class="mt-10">
                     <label class="checkbox_container">I have read and agree term of use
                     <input type="checkbox" form="order_form" name="terms_validate" id="cart_t_c">
                     <span class="checkmark"></span>
                     </label>
                                       </div>
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pt-12 responsive_bottom_aligner">
                        <a href="<?=base_url()?>" class="color_font">
                           <h6 class="color_font"> <i class="ion-ios-arrow-back"></i> Return to shipping</h6>
                        </a>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 responsive_bottom_aligner ">
                        <button type="button" form="order_form" value="Place order" class="default-cbtn desktop_rightfloater paynow  btn-block">Pay now</button>
                     </div>
                  </div>
                  <!-- <div class="payment-method">
                     <div class="payment-accordion">
                         
                         <div class="order-button-payment">
                            
                         </div>								
                     </div>
                     </div>     -->
                  <!--+++++++++++SUBMITTER WITH REMEBER ME ENDS+++++++++++++++-->
               </div>
               <!--PAYMENT OPTIONS ENDS-->	                        
               <!--PAYMENT METHOD VIEWER ENDS HERE-->                                         
            </div>
         </div>
         </div>
         <!-- end of LEFT Portion -->							
         <!-- Start of Right Portion -->		
         <div class="col-lg-6 col-md-12 col-12" id="desktop_view_tbody">
            <div class="your-order" style="margin-top: 40px;">
               <h4 style="border-bottom: 1px solid #d4caca;">ORDER SUMMARY </h4>
               <div class="your-order-table table-responsive">
                  <table>
                     <tbody>
                         <?php
                         $totamount=0;
                         foreach($cart_detail as $row_cart)
                         {
                         ?>
                        <tr class="row_bottom">
                           <td class="product-name">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <img src="<?=base_url()?><?=$row_cart['image']?>" alt="" class="checkout_img_modifier" width="80" height="80">
                                 </div>
                                 <div class="col-sm-9 pl-30 pr-30">
                                    <span>
                                       <!--PRODUCT NAME-->
                                       <?=$row_cart['cid_name']?> X <?=$row_cart['qty']?><br>
                                       Size : <?=$row_cart['size']?><br>
                                       Color : <?=$row_cart['color']?><br>
                                                                                                                   <!--Carat-->
                                       <!--SIZE-->
                                       <br>
                                    </span>
                                 </div>
                              </div>
                           </td>
                           <td class="product-quantity amount" style="width: 37%;text-align:right;"> Rs.
                               <?php
                               if($row_cart['offer_price']!='')
                               {
                                   echo $row_cart['offer_price']*$row_cart['qty'];
                                   $totamount+=$row_cart['offer_price']*$row_cart['qty'];
                               }
                               else
                               {
                                   echo $row_cart['price']*$row_cart['qty'];
                                   $totamount+=$row_cart['price']*$row_cart['qty'];
                               }
                               ?>
                              
                           </td>
                        </tr>
                        <?php
                         }
                         ?>
                        </tbody>
                     <tfoot>
                        
                        
                        		    
                        <tr class="cart-subtotal">
                           <th class="text-left">Subtotal</th>
                           <td class="amount_aligner" style="padding: 0px 40px 0px 82px;text-align: right;"><span class="amount">Rs.<?=$totamount?></span>
                              <input type="hidden" name="gross_cart_amount" id="gross_cart_amount" form="order_form" value="<?=$totamount?>" readonly="">
                           </td>
                        </tr>
                        
                        <tr class="order-total">
                           <th class="text-left">Total</th>
                           <td class="amount_aligner" style="padding: 0px 40px 0px 15px;"><strong><span class="amount static_amount" id="static_amount">Rs.<?=$totamount?></span></strong>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
         <!-- End of Right Portion -->							
      
   </div>
</div>