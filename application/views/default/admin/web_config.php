<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once (__DIR__ . '/include/head.php'); ?>
</head>
<body>
	<style type="text/css">
		#company_logo_preview, #favicon_preview {
			width:128px;
			height:128px;
			object-fit:cover;
			border-radius:50%;
			cursor:pointer;
		}
	</style>
	
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
									<h4 class="mb-sm-0 font-size-18">Web Config</h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Web Config</li>
										</ol>
									</div>

								</div>
							</div>
						</div>
						<!-- end page title -->
						
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Web Config</h4>
									</div>
									<div class="card-body">
										<form method="post" enctype="multipart/form-data">
											<?php echo $this->security->csrf_input(); ?>
											<div class="row">
												<div class="col-md-6 mb-3 text-center">
													<p>Company Logo <span >( 254 X 52 Px )</span></p>
													<input type="file" id="company_logo" name="company_logo" accept=".jpeg,.jpg,.png,.gif" style="display:none;">
													<img src="<?php if($profile['company_logo']){
														echo base_url($profile['company_logo']);
													} else {
														echo base_url('/assets/backend/images/logo.png');
													} ?>" id="company_logo_preview">
													
												</div>
												<div class="col-md-6 mb-3 text-center">
													<p>Favicon <span >( 24 X 24 Px )</span></p>
													<input type="file" id="favicon" name="favicon" accept=".jpeg,.jpg,.png,.gif" style="display:none;">
													<img src="<?php if($profile['favicon']){
														echo base_url($profile['favicon']);
													} else {
														echo base_url('/assets/backend/images/logo.png');
													} ?>" id="favicon_preview">
												</div>
												<div class="col-md-4 mb-3">
													<label for="site_title" class="form-label font-size-13 text-muted">Site Title</label>
													<input class="form-control" name="site_title" id="site_title" type="text" placeholder="Site Title" value="<?php echo addslashes($profile['site_title']); ?>" required />
												</div>
												<div class="col-md-4 mb-3">
													<label for="site_tagline" class="form-label font-size-13 text-muted">Site Tagline</label>
													<input class="form-control" name="site_tagline" id="site_tagline" type="text" placeholder="Site Tagline" required value="<?php echo addslashes($profile['site_tagline']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="company_email" class="form-label font-size-13 text-muted">Company Email</label>
													<input class="form-control" name="company_email" id="company_email" type="email" placeholder="Company Email" required value="<?php echo addslashes($profile['company_email']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="company_phone" class="form-label font-size-13 text-muted">Company Phone</label>
													<input class="form-control" name="company_phone" id="company_phone" type="text" placeholder="Company Phone" value="<?php echo addslashes($profile['company_phone']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="company_address" class="form-label font-size-13 text-muted">Company Address</label>
													<input class="form-control" name="company_address" id="company_address" type="text" placeholder="Company Address" value="<?php echo addslashes($profile['company_address']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="copyright_text" class="form-label font-size-13 text-muted">Copyright Text</label>
													<input class="form-control" name="copyright_text" id="copyright_text" type="text" placeholder="Copyright Text" value="<?php echo addslashes($profile['copyright_text']); ?>" />
												</div>
												<h5 class="col-md-12"><hr> Home Page SEO</h5>
												<div class="col-md-4 mb-3">
													<label for="home_page_keywords" class="form-label font-size-13 text-muted">Keywords</label>
													<input class="form-control" name="home_page_keywords" id="home_page_keywords" type="text" placeholder="Keywords" value="<?php echo addslashes($profile['home_page_keywords']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="home_page_meta_title" class="form-label font-size-13 text-muted">Meta Title</label>
													<input class="form-control" name="home_page_meta_title" id="home_page_meta_title" type="text" placeholder="Meta Title" value="<?php echo addslashes($profile['home_page_meta_title']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="home_page_meta_descr" class="form-label font-size-13 text-muted">Meta Description</label>
													<input class="form-control" name="home_page_meta_descr" id="home_page_meta_descr" type="text" placeholder="Meta Description" value="<?php echo addslashes($profile['home_page_meta_descr']); ?>" />
												</div>
												<div class="col-md-12 text-center">
													<button type="submit" class="btn btn-danger">Save</button>
												</div>
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
	jQuery('#company_logo_preview').click(function(){
		jQuery('#company_logo').click();
	});
	
	jQuery('#company_logo').change(function(){
		let file = this.files[0];
		if( file ){
			document.querySelector('#company_logo_preview').src = URL.createObjectURL(file)
		}
	});
	
	jQuery('#favicon_preview').click(function(){
		jQuery('#favicon').click();
	});
	
	jQuery('#favicon').change(function(){
		let file = this.files[0];
		if( file ){
			document.querySelector('#favicon_preview').src = URL.createObjectURL(file)
		}
	});
	</script>