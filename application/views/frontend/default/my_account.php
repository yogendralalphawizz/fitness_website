<div class="about-story pb-15">
   <center>
      <h1 class="cart-heading"></h1>
   </center>
      <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="vertical-tab" role="tabpanel">
               <!-- Nav tabs -->
               <ul class="nav nav-tabs" role="tablist">
                  <li class="active" ><a href="#" style="color:red !important;">Profile</a></li>
                  <li ><a href="<?=base_url()?>my-orders">Orders</a></li>
               </ul>
               <!-- Tab panes -->
               <div class="tab-content tabs">
                  <div role="tabpanel" class="tab-pane fade active show" id="Section1">
                     <div class="row login-form-container">
                                                <h4 class="login-text"><b>CUSTOMER PROFILE</b></h4>
                        <div id="customer_PROFILE" class="col-sm-6">
                           <h6><b>UPDATE YOUR PROFILE</b></h6>
                           <div class="form-group">
                              <label for="email">EMAIL</label>
                              <input type="email"  name="user_email" value="<?=$profile['email']?>" id="email" autocomplete="off" class="static form-control" placeholder="Enter Email Address" disabled="">
                                                         </div>
                           <div class="form-group">
                              <label for="pwd">PASSWORD</label>
                              <span class="text-black">***********</span>
                              <button type="button" class="button text-black btn-sm" data-toggle="modal" data-target="#myModal"><span class="ion-key"></span> Edit</button>
                           </div>
                           <!--PASSWORD MODAL OPERNER-->                             
                           <div class="modal fade" id="myModal" role="dialog">
                              <div class="modal-dialog modal-sm">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h4 class="modal-title">Change Creadentials</h4>
                                       <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                          <form action="<?=base_url()?>Home/account_update_creds" method="post" id="creadential_updater">
                                             <div class="col-md-12">
                                                <div class="row form-group">
                                                   <div class="col-md-12 col-sm-12  col-xs-12">
                                                      <label for="oldpwd">Old Password</label>
                                                      <input type="password" class="form-control" name="acc_current_password" id="oldpwd" autocomplete="nope" placeholder="Old Password">
                                                                                                         </div>
                                                   <div class="col-md-12 col-sm-12  col-xs-12">
                                                      <label for="newpwd">New Password</label>
                                                      <input type="password" class="form-control" name="acc_new_password" id="newpwd" autocomplete="nope" placeholder="New Password">
                                                                                                         </div>
                                                   <div class="col-md-12 col-sm-12  col-xs-12">
                                                      <label for="cnpwd">Confirm New Password</label>
                                                      <input type="password" class="form-control" name="acc_confirm_password" id="cnpwd" autocomplete="nope" placeholder="Confirm Password">
                                                                                                         </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                   <div class="col-md-5  col-xs-12 align-self-center">
                                                      <input type="submit" class="button text-black btn-sm" name="change_passsword" value="SAVE">
                                                   </div>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--PASSWORD MODAL CLOSED--> 
                        </div>
                        <div id="user_PROFILE_2" class="col-sm-6">
                           <form action="<?=base_url()?>Home/update_billing_address" id="update_billing_info" method="post" enctype="multipart/form-data" autocomplete="on">
                              <!-- ******************BILLING ADDRESS***********************-->
                              <h6 class="mt-auto"><b>BILLING ADDRESS</b></h6>
                              <div class="row form-group">
                                 <div class="col-md-6 col-sm-12  col-xs-12">
                                    <label for="fname">FIRST NAME</label>
                                    <input type="text" class="form-control" name="bill_first_name" id="fname" value="<?=$profile['first_name']?>">
                                                                     </div>
                                 <div class="col-md-6 col-sm-12  col-xs-12">
                                    <label for="lname">LAST NAME</label>
                                    <input type="text" class="form-control" name="bill_last_name" id="lname" value="<?=$profile['last_name']?>">
                                                                     </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12 col-sm-12  col-xs-12">
                                    <label for="Address1">ADDRESS 1</label>
                                    <input type="text" class="form-control" name="bill_address1" id="Address1" value="<?=$profile['address_line_1']?>">
                                                                     </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12 col-sm-12  col-xs-12">
                                    <label for="Address2">ADDRESS 2</label>
                                    <input type="text" class="form-control" name="bill_address2" id="Address2" value="<?=$profile['address_line_2']?>">
                                                                     </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12 col-sm-12  col-xs-12">
                                    <label for="Country">COUNTRY</label>
                                    <select name="bill_country" class="form-control" class="country" id="Country" >
                                       <option value="">--Select Country--</option>
                                                                              <option data-countrycode="101" selected value="IN">India</option>
                                                                              </select>
                                                                     </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-4 col-sm-12  col-xs-12">
                                    <label for="Zipcode">ZIP CODE</label>
                                    <input type="text" class="form-control" name="bill_zipcode" id="Zipcode" value="<?=$profile['postcode']?>">
                                                                     </div>
                                 <div class="col-md-4 col-sm-12  col-xs-12">
                                    <label for="city">CITY</label>
                                    <input type="text" class="form-control" name="bill_city" id="city" value="<?=$profile['city']?>">
                                                                     </div>
                                 <div class="col-md-4 col-sm-12  col-xs-12">
                                    <label for="state">STATE</label>
                                <input type="text" class="form-control" name="bill_state" id="state" value="<?=$profile['state']?>">
                                    </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12 col-sm-12  col-xs-12">
                                    <label for="Tel">TEL</label>
                                    <input type="text" class="form-control" name="bill_tel" id="Tel" value="<?=$profile['phone']?>">
                                                                     </div>
                              </div>
                            <center>  <button type="submit" name="submit" form="update_billing_info" class="btn btn-submit">SAVE</button> </center>

                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>