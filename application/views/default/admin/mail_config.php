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
									<h4 class="mb-sm-0 font-size-18">Mail Config</h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Mail Config</li>
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
										<h4 class="card-title">Mail Config</h4>
									</div>
									<div class="card-body">
										<form method="post" enctype="multipart/form-data">
											<?php echo $this->security->csrf_input(); ?>
											<div class="row">
												<div class="col-md-4 mb-3">
													<label for="mailer_method" class="form-label font-size-13 text-muted">Method</label>
													<select class="form-control" name="mailer_method" id="mailer_method">
														<option value="">Select Method</option>
														<option value="mail" <?php echo ($profile['mailer_method'] == 'mail') ? 'selected' : ''; ?>>Mail</option>
														<option value="smtp" <?php echo ($profile['mailer_method'] == 'smtp') ? 'selected' : ''; ?>>SMTP</option>
														<option value="sendmail" <?php echo ($profile['mailer_method'] == 'sendmail') ? 'selected' : ''; ?>>Sendmail</option>
														<option value="qmail" <?php echo ($profile['mailer_method'] == 'qmail') ? 'selected' : ''; ?>>QMail</option>
													</select>
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_Host" class="form-label font-size-13 text-muted">SMTP Host</label>
													<input class="form-control" name="mailer_Host" id="mailer_Host" type="text" placeholder="SMTP Host" value="<?php echo addslashes($profile['mailer_Host']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_Port" class="form-label font-size-13 text-muted">SMTP Port</label>
													<input class="form-control" name="mailer_Port" id="mailer_Port" type="number" placeholder="SMTP Port" value="<?php echo addslashes($profile['mailer_Port']); ?>" min="0" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_SMTPSecure" class="form-label font-size-13 text-muted">SMTPSecure</label>
													<select class="form-control" name="mailer_SMTPSecure" id="mailer_SMTPSecure">
														<option value="0">No Encryption</option>
														<option value="ssl" <?php echo ($profile['mailer_SMTPSecure'] == 'ssl') ? 'selected' : ''; ?>>SSL</option>
														<option value="tls" <?php echo ($profile['mailer_SMTPSecure'] == 'tls') ? 'selected' : ''; ?>>TLS</option>
													</select>
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_SMTPAuth" class="form-label font-size-13 text-muted">SMTPAuth</label>
													<select class="form-control" name="mailer_SMTPAuth" id="mailer_SMTPAuth">
														<option value="1" <?php echo ($profile['mailer_SMTPAuth'] == '1') ? 'selected' : ''; ?>>Yes</option>
														<option value="0" <?php echo ($profile['mailer_SMTPAuth'] == '0') ? 'selected' : ''; ?>>No</option>
													</select>
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_Username" class="form-label font-size-13 text-muted">SMTP Username</label>
													<input class="form-control" name="mailer_Username" id="mailer_Username" type="text" placeholder="SMTP Username" value="<?php echo addslashes($profile['mailer_Username']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_Password" class="form-label font-size-13 text-muted">SMTP Password</label>
													<input class="form-control" name="mailer_Password" id="mailer_Password" type="text" placeholder="SMTP Password" value="<?php echo addslashes($profile['mailer_Password']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_Timeout" class="form-label font-size-13 text-muted">SMTP Timeout</label>
													<input class="form-control" name="mailer_Timeout" id="mailer_Timeout" type="number" min="0" placeholder="SMTP Timeout" value="<?php echo addslashes($profile['mailer_Timeout']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_CharSet" class="form-label font-size-13 text-muted">SMTP CharSet</label>
													<input class="form-control" name="mailer_CharSet" id="mailer_CharSet" type="text" placeholder="SMTP CharSet" value="<?php echo addslashes($profile['mailer_CharSet']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_fromName" class="form-label font-size-13 text-muted">SMTP From Name</label>
													<input class="form-control" name="mailer_fromName" id="mailer_fromName" type="text" placeholder="SMTP From Name" value="<?php echo addslashes($profile['mailer_fromName']); ?>" />
												</div>
												<div class="col-md-4 mb-3">
													<label for="mailer_fromEmail" class="form-label font-size-13 text-muted">SMTP From Email</label>
													<input class="form-control" name="mailer_fromEmail" id="mailer_fromEmail" type="text" placeholder="SMTP From Email" value="<?php echo addslashes($profile['mailer_fromEmail']); ?>" />
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