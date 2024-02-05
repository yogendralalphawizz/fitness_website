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
									<h4 class="mb-sm-0 font-size-18">Change Password</h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Change Password</li>
										</ol>
									</div>

								</div>
							</div>
						</div>
						<!-- end page title -->
						
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Change Password</h4>
									</div>
									<div class="card-body">
										<form method="post">
											<?php echo $this->security->csrf_input(); ?>
											<div class="mb-3">
												<label for="old_password" class="form-label font-size-13 text-muted">Old Password</label>
												<input class="form-control" name="old_pass" id="old_password" type="password" placeholder="Old Password" />
											</div>
											<div class="mb-3">
												<label for="new_password" class="form-label font-size-13 text-muted">New Password</label>
												<input class="form-control" name="new_pass" id="new_password" type="password" placeholder="New Password" />
											</div>
											<div class="mb-3">
												<label for="confirm_password" class="form-label font-size-13 text-muted">Confirm Password</label>
												<input class="form-control" name="confirm_pass" id="confirm_password" type="password" placeholder="Confirm Password" />
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-outline-primary">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						
				    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Cosec.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by <a href="#!" class="text-decoration-underline">Cosec</a>
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
