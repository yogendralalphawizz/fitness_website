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
									    echo 'Products';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Products </li>
										</ol>
									</div>

								</div>
							</div>
						</div>
						<!-- end page title -->
						
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header groupformheader">
										<h4 class="card-title">Products  &nbsp; </h4>
										<div class="actionbutton">
											<a href="<?php echo base_url('/admin/Dashboard/add_product/'); ?>" class="btn btn-success waves-effect waves-light"><i class=" fas fa-plus font-size-16 align-middle me-2"></i> Add Product</a>
										</div>
									</div>
									<div class="card-body">
										<table class="table table-bordered" id="social_slider_table">
											<thead>
												<tr>
												    <th>Image</th>
													<th>Name</th>
													<th>Price</th>
													<th>Size</th>
													<th>Color</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
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
                                <script>document.write(new Date().getFullYear())</script> © WebDealSoft.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by <a href="#!" class="text-decoration-underline">WebDealSoft</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->
  
  
  <!-- end  -->
    <?php require_once (__DIR__ . '/include/include-bottom.php'); ?>
	
	<div class="modal fade" tabindex="-1" id="preview_modal">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			
    		</div>
    	</div>
    </div>
	<script type="text/javascript">
	
	$(document).ready(function () {
    $('#social_slider_table').DataTable({
         'processing': true,
         'serverSide': true,
        ajax: '<?php echo base_url('admin/Dashboard/product_ajax'); ?>',
        
    });
});
    
    function preview_modal(url, modal_selector, initiator = false, middleware = false)
    {
    	 $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 
                jQuery(modal_selector).modal('show');
                jQuery('.modal-content').html(data)
                

            }
        });
    }
    
    function product_img_mw(data){
        if( data.image ){
            data['image_html'] = '<a href="'+data.image+'" target="_blank"><img src="'+data.image+'" style="width:72px; height:72px; object-fit:cover;"></a>'
        } else {
            data['image_html'] = '-';
        }
		
        return data;
    }
    </script>

	</body>