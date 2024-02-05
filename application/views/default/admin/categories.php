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
									    echo 'Categories';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">Categories</li>
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
										<h4 class="card-title">Categories &nbsp; </h4>
									</div>
									<div class="card-body">
										<table class="table table-bordered" id="Category_table"  style="text-align: center;">
											<thead>
												<tr>
													<th>Image</th>
													<th>Name</th>
													<th>Short</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										<tbody>
                <?php
                if(isset($categories) && !empty($categories))
                {
                  $cats='';
                  foreach ($categories as $row) 
                  {
                    $cat=array();
                    $cat[]=$row['category_name'];
                   
                    $parent=$row['parent_category'];

                    if(!empty($parent))
                    {
                       do {
                        $result = $this->Dashboard_modal->get_parent_category($parent);
                        $cat[]=$result[0]['category_name'];
                        $parent=$result[0]['parent_category'];
                      }
                    while (!empty($parent));
                    }
                    $arr_count=count($cat);
                  ?>
                  <tr>
                    <!--<td class="text-center">
                      <div class="icheck-primary">
                    <input type="checkbox" id="checkbox_id_<?=$row['id']?>" class="checkSingle" name="selected[]" value="<?=$row['id']?>">
                    <label for="checkbox_id_<?=$row['id']?>"></label>
                </div>
                    </td>-->
                    <td><img src="<?=base_url()?><?=$row['image']?>" style="width:35px; height: 35px;" data-pagespeed-url-hash="908572957" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></td>
                    <td class="text-center" style="text-transform: uppercase;">
                        <?php
                         for ($i=$arr_count-1; $i >=0; $i--) { 
                          echo $cat[$i];
                          if($i!=0)
                          {
                            echo ' > '; 
                          }
                         
                         }
                        ?>
                      </td>
                      
									<!--<td class="text-center">
                                    <img src="../../admin_assets/upload_image/category_image/<?=$row['category_file']?>"  style="width:35px; height: 35px;">
									</td>-->
                    <td class="text-center"><?=$row['sort_order']?></td>
                    	 <td class="text-center">
                                    <?php
                                    if ($row['status']==1) 
                                    {
                                       ?>
                                       <span style="color: #8be98b !important;cursor: pointer;" title="Status Change" class="badge gradient-quepal text-white shadow" onclick="confirm_btn_status(<?=$row['id']?>,<?=$row['status']?>)">Enabled</span>
                                    <?php
                                 }
                                    else
                                    {
                                       ?>                                    
                                    <span style="color:#f9745e !important;cursor: pointer;" title="Status Change" class="badge gradient-meridian text-white shadow" onclick="confirm_btn_status(<?=$row['id']?>,<?=$row['status']?>)">Disabled</span>
                                    <?php
                                    }
                                    ?>
                                 </td>
                    <td class="text-center">
                    <a href="javascript:void(0)" onclick="confirm_btn_delete(<?=$row['id']?>)" class="btn btn-danger notika-btn-danger waves-effect btn-sm">Delete</a>
                      <a href="<?=base_url()?>admin/Dashboard/edit_category/<?=$row['id']?>" class="btn btn-info notika-btn-info waves-effect btn-sm">Edit</a>
                                 
<!--                                       <button type="button" onclick="confirm_btn_delete(<?=$row['id']?>)" id="confirm-btn-delete" class="btn btn-sm btn-danger waves-effect waves-light"> <i class="fa fa fa-trash-o"></i> 
                                    </button>-->
                    </td>
                </tr>

                  <?php
                    }
                }
                   ?>                             
                               
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


<script>

function confirm_btn_status(id,status)
   {
      swal({
                    title: "Are you sure?",
                    text: "Change Data Status!!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      swal("Your Data Status Successfully Changed!", {
                        icon: "success",
                      }).then(function() {
                     window.location.href="<?php echo base_url(); ?>admin/Dashboard/category_status_change?id="+id+"&status="+status;
                  });
                    } else {
                      swal("Your imaginary Data is Not Changed!");
                    }
                  });
   }
   function confirm_btn_delete(id)
   {
       swal({
                    title: "Are you sure?",
                    text: "You Want to delete this category!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      swal("Category Successfully Deleted.", {
                        icon: "success",
                      }).then(function() {
                     window.location.href="<?php echo base_url(); ?>admin/Dashboard/delete_category?id="+id;
                  });
                    } else {
                      swal("Your imaginary Data is Not Changed!");
                    }
                  });
   }
</script>