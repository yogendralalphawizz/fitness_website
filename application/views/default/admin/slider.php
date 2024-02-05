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
									    echo 'Slider';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Slider </li>
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
										<h4 class="card-title">Slider  &nbsp; </h4>
										<div class="actionbutton">
											<a href="<?php echo base_url('/admin/Dashboard/add_slider/'); ?>" class="btn btn-success waves-effect waves-light"><i class=" fas fa-plus font-size-16 align-middle me-2"></i> Add slider</a>
										</div>
									</div>
									<div class="card-body">
										<table class="table table-bordered" id="social_slider_table">
											<thead>
												<tr>
													<th>Slider title</th>
													<th>Slider image</th>
													<th>Slider button</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($sliders as $slider){ ?>
												<tr>
													<td><?php echo $slider['title']; ?></td>
													<td><img src="<?php echo base_url($slider['image']); ?>" style="width:96px; height:96px; object-fit:cover;"></td>
													<td><a href="<?php echo $slider['btn_link']; ?>" target="_blank"><?php echo $slider['btn_text']; ?></a></td>
													<td>
														<div class="form-check form-switch mb-3" dir="ltr">
															<label class="form-check-label"><input type="checkbox" class="form-check-input" <?php if($slider['status'] == 'Enabled'){ echo 'checked'; } ?> onchange="confirm_ajax('<?php echo base_url('/admin/Dashboard/slider_status/'.$slider['id']); ?>?status='+(this.checked ? 'Enabled' : 'Disabled'))"></label>
														</div>
													</td>
													<td>
														<div class="dropdown">
															<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
															<div class="dropdown-menu">
																<a class="dropdown-item" href="<?php echo base_url('/admin/Dashboard/edit_slider/'.$slider['id']); ?>">Edit</a>
																<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect('<?php echo base_url('/admin/Dashboard/delete_slider/'.$slider['id']); ?>')">Delete</a>
															</div>
														</div>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div>
										<?php echo $pager; ?>
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