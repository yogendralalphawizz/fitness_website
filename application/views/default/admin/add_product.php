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
									    echo 'Add Product';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/products'); ?>">Products</a></li>
											<li class="breadcrumb-item active">Add Product </li>
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
														<label>Product Name</label>
														<input type="text" required name="product_name" class="form-control" placeholder="Product Name" />
													</div>
												</div>
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Product Style</label>
														<input type="text" required name="style" class="form-control" placeholder="Product Style" />
													</div>
												</div>
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Product Off %</label>
														<input type="product_off" name="off" class="form-control" placeholder="Product Off" />
													</div>
												</div>
												
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Price</label>
														<input type="Number" required name="price" class="form-control" placeholder="Price" />
													</div>
												</div>
													<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Offer Price</label>
														<input type="Number"  name="offer_price" class="form-control" placeholder="Offer Price" />
													</div>
												</div>
													<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
													    <label><b>Product Size </b></label>
													    <br>
													    <?php
													    foreach($sizes as $size)
													    {
													        ?>
													   <input class="form-check-input" name="size[]" value="<?=$size['slug']?>" type="checkbox" id="formCheck1"> <?=$size['name']?> &nbsp;&nbsp;     
													        <?php
													    }
													    ?>
													    
                                                   
													</div>
												</div>
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
													    <label><b>Product Color </b></label>
													    <br>
											<?php
													    foreach($colors as $color)
													    {
													        ?>
													   <input class="form-check-input" name="color[]" value="<?=$color['slug']?>" type="checkbox" id="formCheck1"> <?=$color['name']?> &nbsp;&nbsp;     
													        <?php
													    }
													    ?>
													    
													</div>
												</div>
												
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Category</label>
													 <select class="form-control" name="category[]" 
                                                            id="multiselect1"
                                                            placeholder="This is a placeholder" multiple>	
                      <option selected="selected" value="">Select Category</option>	
														<?php
                      
                                            if(isset($categories) && !empty($categories))
                                            {
                                              $cats='';
                                              foreach ($categories as $row) 
                                              {
                                                $cat=array();
                                                $cat[]=$row['category_name'];
                                               
                                                 $parent=$row['parent_category'];
                                            $cat_id=$row['category_slug'];
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
                                                echo '<option value="'.$cat_id.'">';
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
                                              ?>
                                                 
                                                    </select>
													</div>
												</div>
												
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Product Description</label>
														<textarea id="product_desc"  name="product_desc" class="form-control ckeditor" placeholder="Enter Product Description"></textarea>
                                                 
													</div>
												</div>
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Offer Description</label>
														<textarea id="offer_desc"  name="offer_desc" class="form-control ckeditor" placeholder="Offer Description"></textarea>
                                                 
													</div>
												</div>
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Specification</label>
														<textarea id="specification"  name="specification" class="form-control ckeditor" placeholder="Enter Product specification"></textarea>
                                                
													</div>
												</div>
												
												<div class="col-xl-12 col-md-12">
													<div class="form-group mb-3">
														<label>Image Upload <span >( 1932 X 462 px )</span></label>
														<div>
															<div class="x-dropzone">
																<div xrole="previews">
																	<div xrole="placeholder">Select or Drop Files Here</div>
																</div>
																<div class="input-group" xrole="input-container">
																	<input name="product_image[]" type="file" xrole="input" class="form-control" accept=".jpeg,.jpg,.png,.gif" multiple="multiple" required>
																	<div class="input-group-append">
																		<button class="btn btn-warning" type="button" xrole="clear">Clear</button>
																	</div>
																</div>
															</div>
														</div>
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
	
	document.getElementById('output').innerHTML = location.search;
$(".chosen-select").chosen();
	
	function ml_dropdown_init(){
    	function _fireEvent(elem, ev){
    		var event;
    		if(document.createEvent){
    			event = document.createEvent("HTMLEvents");
    			event.initEvent(ev, true, true);
    			event.eventName = ev;
    			elem.dispatchEvent(event);
    		} else {
    			event = document.createEventObject();
    			event.eventName = ev;
    			event.eventType = ev;
    			elem.fireEvent("on" + event.eventType, event);
    		}
    	}
    	
    	function _fetch(parent, child, init = false){
    		var url = child.getAttribute('data-ml-url');
    		var placeholder = child.getAttribute('data-ml-placeholder');
    		var trigger = child.getAttribute('data-ml-trigger') || 'change';
    
    		if( placeholder ){
    			placeholder = '<option value="">'+placeholder+'</option>';
    		} else {
    			placeholder = '';
    		}
    		
    		if( parent.value == '' ){
    			child.innerHTML = placeholder;
    			if( init === false ){
    				_fireEvent(child, trigger);
    			}
    			return false;
    		}
            
    		child.innerHTML = '<option value="">Loading...</option>';
    
    		const xhr = new XMLHttpRequest();
    		xhr.onload = function() {
    			var response = JSON.parse(this.responseText);
    			
    			child.innerHTML = placeholder;
    			for(var row of response){
    				child.innerHTML += '<option value="'+row.id+'" '+(row.id == init ? 'selected' : '')+'>'+row.text+'</option>'
    			}
    			
    			if( init !== false ){
    				if( 'ml_child' in child ){
    					_fetch(child, child['ml_child'], child['ml_child'].getAttribute('data-ml-init') || '');
    				}
    			} else {
    				_fireEvent(child, trigger);
    			}
            }
            xhr.open("GET", url.replace('%v%', parent.value), true);
            xhr.send();
    	}
    	
    	document.querySelectorAll('[data-ml-parent]:not(.ml-init)').forEach(function(child){
    		child.classList.add('ml-init');
    		
    		var parent = document.querySelector( child.getAttribute('data-ml-parent') );
    		if( ! parent ){ return false; }
    		
    		if( parent.getAttribute('data-ml-parent') === null ){
    			_fetch(parent, child, child.getAttribute('data-ml-init') || '');
    		} else {
    			parent['ml_child'] = child;
    		}
    		
    		parent.addEventListener('change', function(){
    			_fetch(this, child);
    		});
    	});
    }
    

	x_dropzone();
	ml_dropdown_init();

	</script>