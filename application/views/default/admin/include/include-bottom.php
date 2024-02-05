	
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="<?=base_url('assets/backend/')?>libs/jquery/jquery.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>js/sweet-alert-script.js"></script>
        <script src="<?=base_url('assets/backend/')?>js/sweetalert.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
		 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/metismenu/metisMenu.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/simplebar/simplebar.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/node-waves/waves.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="<?=base_url('assets/backend/')?>libs/pace-js/pace.min.js"></script>

        <!-- apexcharts -->
        <script src="<?=base_url('assets/backend/')?>libs/apexcharts/apexcharts.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>js/pages/apexcharts.init.js"></script>

        <!-- Plugins js-->
        <script src="<?=base_url('assets/backend/')?>libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?=base_url('assets/backend/')?>libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <!-- dashboard init -->
        <script src="<?=base_url('assets/backend/')?>js/pages/dashboard.init.js"></script>
      <script src="<?=base_url('assets/backend/')?>libs/dropzone/min/dropzone.min.js"></script>
      <script src="<?=base_url('assets/backend/')?>js/table-edits.min.js"></script>
      <script src="<?=base_url('assets/backend/')?>js/table-editable.int.js"></script>
        <script src="<?=base_url('assets/backend/')?>js/app.js"></script>
        <script src="<?=base_url('assets/backend/')?>js/choices.min.js"></script>
        <script src="<?=base_url()?>assets/frontend/js/lobibox.js"></script>

	<script type="text/javascript" src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
		<script type="text/javascript" src="https://www.jqueryscript.net/demo/print-element-css-divjs/divjs/divjs.js"></script>

        
		 <?php echo alertify_render( '//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build', 'top-right' ); ?>
		 
		 <script type="text/javascript">
		 function confirm_redirect(url, message = 'Do you want to continue?'){
			if( typeof alertify !== 'undefined' ){
				alertify.confirm(message, function(){
					window.location.href = url;
				});
			} else if( confirm( message ) ) {
				window.location.href = url;
			}
		}


		function confirm_ajax(url, message = 'Do you want to continue?'){
			function _ajax(){
				var xhr = new XMLHttpRequest();
				xhr.onload = function() {
					var response = JSON.parse(this.responseText);

					if( response.status == '1' ){
						(typeof alertify !== 'undefined') ? alertify.success(response.message) : alert(response.message);
					} else {
						(typeof alertify !== 'undefined') ? alertify.error(response.message) : alert(response.message);
					}
				}
				xhr.open("GET", url, true);
				xhr.send();
			}

			if( typeof alertify !== 'undefined' ){
				alertify.confirm(message, function(){
					_ajax();
				});
			} else if( confirm( message ) ) {
				_ajax();
			}
		}
		
	var i = 0;
	function add_content_list(data = {}){
		for(var item of [ 'title', 'desc']){
			if( ! (item in data) ){
				data[ item ] = '';
			}
		}
		jQuery('#content_list').after('<div class="row" id="content_list" style="background: #fbfaffa3; margin: 10px 0px; padding-top: 10px;">  <div class="col-xl-12 col-md-12">	<div class="form-group mb-3"> <label>Content List Title</label>	<input type="text" required name="list_title[]" class="form-control" placeholder="Content Item Title" /></div>	</div><div class="col-xl-12 col-md-12">	<div class="form-group mb-3"><label>Content List Description</label><textarea type="text" required name="list_desc[]" class="form-control" placeholder="Content List Description"></textarea><button type="button" class="btn btn-danger" title="Remove" onclick="remove_content_section_row(this)"><i class="fa fa-trash"></i></button></div></div></div>');
		i++;
		icon_picker_init()
	}
	
	function remove_content_section_row(btn)
	{
	    jQuery(btn).parents('#content_list').remove();
	}
	
	function remove_content_sction_list(btn,url,message = 'Do you want to continue?'){
	    function _ajax(){
				var xhr = new XMLHttpRequest();
				xhr.onload = function() {
					var response = JSON.parse(this.responseText);

					if( response.status == '1' ){
						(typeof alertify !== 'undefined') ? alertify.success(response.message) : alert(response.message);
					} else {
						(typeof alertify !== 'undefined') ? alertify.error(response.message) : alert(response.message);
					}
				}
				xhr.open("GET", url, true);
				xhr.send();
			}

			if( typeof alertify !== 'undefined' ){
				alertify.confirm(message, function(){
					_ajax();
					jQuery(btn).parents('#content_list').remove();
				});
			} else if( confirm( message ) ) {
				_ajax();
			}
	
	}
	
		

		
		 </script>
		 
	<script>
	 $('.ckeditor').each(function () {
        CKEDITOR.replace($(this).prop('id'));
    });

    </script>
<script>
$(document).ready(function(){
    dataTable =$('#ordertable').DataTable({
        // Processing indicator
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('admin/Dashboard/get_orders'); ?>",
            "type": "POST",
            data: function (d) {
                d.min = $('#min-date').val();
                d.max = $('#max-date').val();
            }
        },
        language: {
        searchPlaceholder: "Order No."
        }
    
        
    });
    $('#min-date, #max-date').change(function () {
        dataTable.draw();
    })
    $(document).on('click','.close',function(){
    $('#order_info_model').hide();
});
});

/*Modal Js view Order Info Data*/
function view_order_info(order_id){
        var status='1';
            $.ajax({
            url:'<?=base_url()?>admin/Dashboard/show_order_detail/'+order_id,
            method:"POST",
            dataType:"json",
            data:{action:status,},
            success:function(data)
            {
               
           // product_view_count(product_id);

            $('#order_number').html(data.header_content);
            $('#order_body').html(data.body_content);
           
            $('#order_info_model').show();
            
            }
        });
}

$(document).on('change','.status_change',function(){
    var product_id=$('option:selected',this).attr('odid');
    var id=$(this).attr('id');
     var status=$(this).val();
     
     var options = $(this).html();
     Lobibox.confirm({
                msg: 'Are You Sure! You Want to Change Status?',
                callback: function ($this, type) {
                    if(type=='no')
                    {
                        $("#"+id).html(options);
                    return false;
                    }
                    else
                    {
                var url="<?=base_url()?>admin/Dashboard/order_status";
                    $.ajax({
                            type: "POST",
                            url: url, 
                            data: { product_id: product_id, status: status},
                             dataType: 'json',
                            success: function(data){ 
                                Lobibox.notify("success", {
                                size: 'normal',
                                delayIndicator: false,
                                showClass: 'flipInX',
                                hideClass: 'zoomOutDown',
                                position: 'top right',
                                delayIndicator:true,      
                                closeOnClick:true, 
                                sound:true,
                                msg:'Order Status Successfully Changed.',
                            });
                            
                            }
                        });
                }
            }
     });    

    
    
});
$(document).on('click','.printMe',function(){
      var printContent = document.getElementById("order_body");

    $('#order_body').printElement({
    });
    }); 
    	document.multiselect('#multiselect1')
		.setCheckBoxClick("checkboxAll", function(target, args) {
			console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
		})
		.setCheckBoxClick("1", function(target, args) {
			console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
		});  
</script>
    </body>

</html>