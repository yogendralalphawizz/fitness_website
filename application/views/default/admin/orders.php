<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once (__DIR__ . '/include/head.php'); ?>
</head>
<body>
	<?php require_once (__DIR__ . '/include/header.php'); ?>
	<?php require_once (__DIR__ . '/include/sidebar.php'); ?>
    <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

						<!-- start page title -->
						<div class="row">
							<div class="col-12">
								<div class="page-title-box d-sm-flex align-items-center justify-content-between">
									<h4 class="mb-sm-0 font-size-18"><?php 
									if($page_title){
									    echo $page_title;
									}else{
									    echo 'Orders';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Orders</li>
										</ol>
									</div>

								</div>
							</div>
						</div>
						<!-- end page title -->
						
						<div class="about-story pb-15">
   <center>
      <h1 class="cart-heading"></h1>
   </center>
      <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="vertical-tab">
            
               <div class="tab-content tabs">
                  <div class="col-md-12 login-form-container pt-1 pb-1 pr-1 pl-1">
                     <div class="col-md-12 col-12 col-lg-12 col-xl-12 col-sm-12  col-xs-12 ml-auto mr-auto">
                        <div class="row form-group">
                           <div class="col-md-4 col-sm-12  col-xs-12">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date" class="flat_date flatpickr-input" id="min-date" >
                           </div>
                           <div class="col-md-4 col-sm-12  col-xs-12">
                              <label for="End_date">End Date</label>
                              <input type="date" name="end_date" class="flat_date flatpickr-input" id="max-date" >
                           </div>
                           
                        </div>
                     </div>
                  </div>
                  <!--Table Of Orders -->
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="table-responsive text-black" style="color:black !important;">
    <table id="ordertable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sr.No.</th>
                <th>DATE</th>
                <th>ORDER NO.</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Sr.No.</th>
                <th>DATE</th>
                <th>ORDER NO.</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </tfoot>
    </table>
                        <!--<table class="table">
                           <thead>
                              <tr>
                                 <th>DATE</th>
                                 <th>ORDER NO.</th>
                                 <th>VALUE</th>
                                 <th>PAYMENT</th>
                                 <th>STATUS</th>
                                 <th>REMARK</th>
                              </tr>
                           </thead>
                           <tbody id="data_order_filtered"><tr>
                                
                                <td>2021-03-11</td>
                                <td> #2</td>
                                <td>231.99</td>
                                <td>Paypal</td>
                                <td>Pending</td>
                                <td>
                                <button class="button hvr-float-shadow" onclick="view_order_info(2,event)">View</button>
                                <button class="button hvr-float-shadow" onclick="track_order_info(2,event)">Track</button> <button class="button hvr-float-shadow" id="btn_cancel2" onclick="cancel_order_info(2,event)">Cancel</button></td>
                              </tr></tbody>
                        </table>-->
                        <div id="pagination_order_link"></div>
                     </div>
                  </div>
                  <!--Table Of Orders Ends -->				
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal" id="order_info_model" style="padding-left: 17px; z-index: 1050111;" aria-modal="true">
   <div class="modal-dialog" style="max-width: 80%;">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <a href="javascript:void(0)" class="printMe">Print</a> <h4 class="modal-title" id="order_number"></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body" id="order_body">
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
</div>
						
				    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © WebSealSoft.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by <a href="#!" class="text-decoration-underline">WebSealSoft</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->
  
  
  <!-- end  -->
    <?php require_once (__DIR__ . '/include/include-bottom.php'); ?>
	
	</body>



