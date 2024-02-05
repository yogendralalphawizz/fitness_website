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
									<h4 class="mb-sm-0 font-color-18"><?php 
									if($page_title){
									    echo $page_title;
									}else{
									    echo 'Colors';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Colors</li>
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
										<h4 class="card-title">Colors &nbsp; </h4>
									<a href="<?=base_url('admin/Dashboard/add_color')?>">	
									<button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i> Add Color</button>
									</a>
									</div>
									<div class="card-body">
										<table class="table table-bordered" id="social_slider_table">
											<thead>
												<tr>
													<th>Title</th>
													<th>Status</th>
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

<script type="text/javascript">
window.addEventListener('load', function(){
	$('#social_slider_table').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": "<?php echo base_url('admin/Dashboard/colors_datatable'); ?>",
		"columns": [
			{ "data": 'name' },
			{ "data": 'status' },
			{ "data": 'action', "orderable": false, "searchable": false }
		]
	});
});

</script>