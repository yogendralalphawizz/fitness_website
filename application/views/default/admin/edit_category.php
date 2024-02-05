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
									    echo 'Edit Category';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/categories'); ?>">Categories</a></li>
											<li class="breadcrumb-item active">Edit Category </li>
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
			<?php
			if($category_datas)
			{
			?>
              <form id="personal-info" method="post" style="max-width:700px;     margin: 0 auto;" action="<?=base_url()?>admin/Dashboard/update_category" enctype="multipart/form-data">
                
          <div class="row col-lg-11 col-sm-12 form_layout_changer">
          
              <div class="col-lg-12 col-md-12 col-sm-10 col-sm-1">
                  
                <div class="form-group row input-field">
                    <input type="hidden" name="category_id" value="<?=$category_datas['id']?>">
                  <label for="input-1" class="col-sm-12 col-form-label">Category Name</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" value="<?=$category_datas['category_name']?>" id="input-1" placeholder="Category Name" name="category_name" required="">
                  </div>
                </div>
                 <div class="input-field">
                <div class="form-group input-selectfield">
                  <label for="input-1" class="col-sm-12 col-form-label">Parent Category</label>
                  <div class="col-sm-12">
                      <?php
                      
                      ?>
                    <select  id="input-status" name="parent_category" class="form-control selector_modify" style="text-transform: uppercase;">
                      <option selected="selected" value="0">None</option>
                      <?php
                      
                if(isset($parrent_categories) && !empty($parrent_categories))
                {
                  $cats='';
                  foreach ($parrent_categories as $row) 
                  {
                    $cat=array();
                    $cat[]=$row['category_name'];
                   
                     $parent=$row['parent_category'];
                $cat_id=$row['id'];
                    if(!empty($parent) && $parent>0)
                    {
                       do {
                        $result = $this->Dashboard_modal->get_parent_category($parent);
                        $cat[]=$result[0]['category_name'];
                        $parent=$result[0]['parent_category'];
                      }
                    while (!empty($parent && $parent>0));
                    }
                    $arr_count=count($cat);
                    if($category_datas['id']!=$cat_id)
                    {
                    echo '<option  value="'.$cat_id.'"';
                    if($category_datas['parent_category']==$cat_id)
                     {
                         echo 'selected >';
                     }
                     else
                     {
                         echo '>';
                     }
                    
                    
                    for ($i=$arr_count-1; $i >=0; $i--) 
                    { 
                         echo  $cat[$i];
                          if($i!=0)
                          {
                            echo ' > '; 
                          }
                          
                         
                     }
                     
                     echo '</option>';
                    }
                         }
                }
                  ?>
                     
                        </select>
                  </div>
                </div>
                </div>
               <div class="col-xl-12 col-md-12">
				<div class="form-group mb-3">
					<label>Image Upload <span >( 500 X 500 px )</span></label>
				<div>
				<div class="x-dropzone">
					<div xrole="previews">
																	<?php if($category_datas['image']){ ?>
																	<div><img src="<?php echo base_url($category_datas['image']); ?>"></div>
																	<?php } else { ?>
																	<div xrole="placeholder">Select or Drop Files Here</div>
																	<?php } ?>
																</div>
							<div class="input-group" xrole="input-container">
							<input name="image" type="file" xrole="input" class="form-control" accept=".jpeg,.jpg,.png,.gif">
							<div class="input-group-append">
							<button class="btn btn-warning" type="button" xrole="clear">Clear</button>
							</div>
							</div>
							</div>
							</div>
							</div>
					</div>									
             

                <div class="form-group row input-field">
                  <label for="input-sort" class="col-sm-12 col-form-label">Sort Order</label>
                  <div class="col-sm-12">
                    <input type="number" class="form-control" value="<?=$category_datas['sort_order']?>" id="input-sort" name="sort_order">
                  </div>
                </div>
                   <div class="input-field">
                <div class="form-group input-selectfield">
                  <label for="input-2" class="col-sm-12 col-form-label">Status</label>
                  <div class="col-sm-12">
                    <select  id="input-status" name="status" class="form-control selector_modify">
                     <option value="1" <?php if($category_datas['sort_order']==1) { echo "selected"; } ?>>Enabled</option>';
                        <option value="0" <?php if($category_datas['sort_order']==0) { echo "selected"; } ?> >Disabled</option>';
                        </select>
                  </div>
                </div>
                </div>
                <div class="form-group row input-field">
                  <label for="input-des" class="col-sm-12 col-form-label">Description</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" id="input-des" name="description"><?=$category_datas['description']?></textarea>
                  </div>
                 </div> 
                 
                 <!--SEO MANAGEMENT-->
                  <div class="form-group row input-field">
                  <label for="meta_title" class="col-sm-12 col-form-label">Meta title</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" value="<?=$category_datas['meta_title']?>" id="meta_title" name="meta_title" >
                  </div>
                </div>
                 <div class="form-group row input-field">
                  <label for="meta_category" class="col-sm-12 col-form-label">Meta Keyword (separated by comma)</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" value="<?=$category_datas['meta_keyword']?>" id="meta_category" name="meta_keyword" >
                  </div>
                </div>
                 <div class="form-group row input-field">
                  <label for="meta_description" class="col-sm-12 col-form-label">Meta Description</label>
                  <div class="col-sm-12">
                       <textarea class="form-control" id="meta_description" name="meta_description"><?=$category_datas['meta_description']?></textarea>
                  </div>
                </div>
           <div class="float-sm-right" style="float: right;    margin-top: 25px;">
                    <a href="<?=base_url()?>admin/Dashboard/categories"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                </div> 
                 </div>
                  </div>
              </form>
            <?php
			}
			?>
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