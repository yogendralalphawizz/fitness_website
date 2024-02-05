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
									    echo 'Edit Color';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/sizes'); ?>">Colors</a></li>
											<li class="breadcrumb-item active">Edit Color </li>
										</ol>
									</div>

								</div>
							</div>
						</div>
						<!-- end page title -->
						
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<form id="add_slider" method="post" style="max-width: 700px; margin: 0 auto;" enctype="multipart/form-data">
											<?php echo $this->security->csrf_input(); ?>
											<div class="row">
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Title</label>
														<input type="text" required name="title" class="form-control" placeholder="Enter Title" value="<?php echo addslashes($slider['name']); ?>" />
													</div>
												</div>
												
												
											</div>                                                
											<div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary w-lg waves-effect waves-light">Save</button>
                                        </div>
										</form>
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
	
	</body>
	
	<script type="text/javascript">
	x_dropzone();
	</script>