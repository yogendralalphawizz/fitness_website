<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once (__DIR__ . '/include/head.php'); ?>
	<style type="text/css">
		#profile_pic_preview {
			width:128px;
			height:128px;
			object-fit:cover;
			border-radius:50%;
			cursor:pointer;
		}
	</style>
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
									<h4 class="mb-sm-0 font-size-18">Update Profile</h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Update Profile</li>
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
										<h4 class="card-title">Update Profile</h4>
									</div>
									<div class="card-body">
										<form method="post" enctype="multipart/form-data">
											<?php echo $this->security->csrf_input(); ?>
											<div class="mb-3 text-center">
												<input type="file" id="profile_pic" name="profile_pic" accept=".jpeg,.jpg,.png,.gif" style="display:none;">
												<img src="<?php if($profile['profile_pic']){
													echo base_url($profile['profile_pic']);
												} else {
													echo base_url('/assets/backend/images/users/avatar.jpg');
												} ?>" id="profile_pic_preview">
											</div>
											<div class="mb-3">
												<label for="first_name" class="form-label font-size-13 text-muted">First Name</label>
												<input class="form-control" name="first_name" id="first_name" type="text" placeholder="First Name" value="<?php echo addslashes($profile['first_name']); ?>" required />
											</div>
											<div class="mb-3">
												<label for="last_name" class="form-label font-size-13 text-muted">Last Name</label>
												<input class="form-control" name="last_name" id="last_name" type="text" placeholder="Last Name" required value="<?php echo addslashes($profile['last_name']); ?>" />
											</div>
											<div class="mb-3">
												<label for="email" class="form-label font-size-13 text-muted">Email Address</label>
												<input class="form-control" name="email" id="email" type="email" placeholder="Email Address" value="<?php echo addslashes($profile['email']); ?>" />
											</div>
											<div class="mb-3">
												<label for="phone_num" class="form-label font-size-13 text-muted">Phone Number</label>
												<input class="form-control" name="phone_num" id="phone_num" type="text" placeholder="Phone Number" value="<?php echo addslashes($profile['phone_num']); ?>" />
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
	
	<script type="text/javascript">
	jQuery('#profile_pic_preview').click(function(){
		jQuery('#profile_pic').click();
	});
	
	jQuery('#profile_pic').change(function(){
		let file = this.files[0];
		if( file ){
			document.querySelector('#profile_pic_preview').src = URL.createObjectURL(file)
		}
	});
	</script>