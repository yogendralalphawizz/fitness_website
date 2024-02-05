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
									    echo 'App Pages';
									}
									?></h4>

									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('/admin/Dashboard/'); ?>">Dashboard</a></li>
											<li class="breadcrumb-item active">App Pages</li>
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
										<h4 class="card-title">App Pages &nbsp; </h4>
								<a href="<?=base_url('admin/Dashboard/add_app_page')?>">	
									<button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i> Add Page</button>
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

<div class="modal fade" tabindex="-1" id="preview_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">%title%</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tr>
						<th>Title</th>
						<td>%title%</td>
					</tr>
					<tr>
						<th>Short Description</th>
						<td>%short_descr%</td>
					</tr>
					<tr>
						<th>Long Description</th>
						<td>%long_descr_html%</td>
					</tr>
					<tr>
						<th>Status</th>
						<td>%status%</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
window.addEventListener('load', function(){
	$('#social_slider_table').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": "<?php echo base_url('admin/Dashboard/app_pages_datatable'); ?>",
		"columns": [
			{ "data": 'title' },
			{ "data": 'status' },
			{ "data": 'action', "orderable": false, "searchable": false }
		]
	});
});

function preview_modal(url, modal_selector, initiator = false, middleware = false){
	var modal_elem = document.querySelector(modal_selector);
	if( ! modal_elem ){ console.error('No Matched Element Found for Preview Modal.'); }
	
	if( ! ('template_content' in modal_elem) ){
		modal_elem[ 'template_content' ] = modal_elem.innerHTML;
	}

	var initiator_content;
	var icon_url = 'loader.gif';

	function _template_parser(template_string, data){
		function _strip_tags(val){
			var div = document.createElement("div");
			div.innerHTML = val;
			return (div.textContent || div.innerText || "");
		}
		
		function _flat_object(ob) {
			var toReturn = {};

			for (var i in ob) {
				if (!ob.hasOwnProperty(i)) continue;

				if ((typeof ob[i]) == 'object' && ob[i] !== null) {
					var flatObject = _flat_object(ob[i]);
					for (var x in flatObject) {
						if (!flatObject.hasOwnProperty(x)) continue;

						toReturn[i + '.' + x] = flatObject[x];
					}
				} else {
					toReturn[i] = ob[i];
				}
			}
			return toReturn;
		}

		data = _flat_object( data );

		return template_string.replace(/\%.*?\%/g, function(matches){
			var trimmed = matches.replace(/^\%/, '').replace(/\%$/, '');
			
			if( trimmed.endsWith('_html') ){
				return (trimmed in data) ? data[ trimmed ] : matches;
			}
			return (trimmed in data) ? _strip_tags( data[ trimmed ] ) : matches;
		});
	}
	
	$.ajax({
		url:url,
		method:'GET',
		beforeSend: function(){
			if( initiator !== false ){
				if( initiator.tagName == 'INPUT' && initiator.type.toLowerCase() == 'button' ){
					initiator_content = initiator.value;
					initiator.value = 'Loading...';
				} else {
					initiator_content = initiator.innerHTML;
					initiator.innerHTML = '<img src="'+icon_url+'" style="height:100%; object-fit:cover;">';
				}
			}
		},
		complete: function(){
			if( initiator !== false ){
				if( initiator.tagName == 'INPUT' && initiator.type.toLowerCase() == 'button' ){
					initiator.value = initiator_content;
				} else {
					initiator.innerHTML = initiator_content;
				}
			}
		},
		success: function(response){
			response = JSON.parse(response);
			
			if( response.status == '1' ){
				if( middleware !== false ){ response.data = middleware(response.data); }
				modal_elem.innerHTML = _template_parser( modal_elem['template_content'], response.data );
				
				// bootstrap 5
				bootstrap.Modal.getOrCreateInstance(modal_elem).show();
				
				// bootstrap <= 4
				// jQuery(modal_elem).show();
			} else {
				if( typeof alertify !== 'undefined' ){
					alertify.error(response.message);
				} else {
					alert(response.message);
				}
			}
		}
	});
}

function app_page_img_mw(data){
    data['long_descr_html'] =  data['long_descr'];
	
    return data;
}
</script>

