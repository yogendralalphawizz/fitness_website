<!-- Plugin JS File -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="<?=base_url()?>assets/frontend/vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/parallax/parallax.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/jquery.plugin/jquery.plugin.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/swiper/swiper-bundle.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/skrollr/skrollr.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/zoom/jquery.zoom.js"></script>
<script src="<?=base_url()?>assets/frontend/vendor/jquery.countdown/jquery.countdown.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/lobibox.js"></script>
<script src="<?=base_url()?>assets/frontend/js/notification.js"></script>
<!-- Main JS -->
<script src="<?=base_url()?>assets/frontend/js/main.min.js"></script>
<!--toster js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- DataTables JS library -->
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


<script>
function new_arrival_sort()
{
   var url  = window.location.href;  
  url = url.replace("<?=base_url('new-arrivals')?>", "<?=base_url('Home/new_arrival_products')?>");
  
    $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 
            $(".new_arrival_product-wrapper").html(data);
            $(".overlay-spinner").delay(2000).hide("fast");
            }
        }); 
    var url1  = window.location.href;      
    url1 = url1.replace("<?=base_url('new-arrivals')?>", "<?=base_url('Home/new_arrival_total_products')?>");
    $.ajax({
            type: "POST",
            url: url1, 
            cache: false, 
            async: false,  
            success: function(data){ 
            $(".toolbox-newarrival-pagination").html(data);
            }
        });     
        
    
}
$(window).bind("load", function() 
{
    cart_onload()
    var filter_url='';
    var pathname = window.location.pathname;
    if(pathname=='/FitnessWebsite/new-arrivals')
    {
    let searchParams = new URLSearchParams(window.location.search)
    if(searchParams.has('search'))
     {
     var search=searchParams.get('search');
     if(search!='')
     {
     filter_url+="/FitnessWebsite/new-arrivals?search="+search;
     }
     }
     if(searchParams.has('category'))
     {
     var category=searchParams.get('category');
     if(category!='')
     {
     filter_url+="/FitnessWebsite/new-arrivals?category="+category;
     }
     } 
     
   var url  = window.location.href;  
  url = url.replace("<?=base_url('new-arrivals')?>", "<?=base_url()?>Home/new_arrival_categories");
    $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 
            $(".categories_filter").html(data);

            }
        }); 
        
        
        var url  = window.location.href;  
  url = url.replace("<?=base_url('new-arrivals')?>", "<?=base_url()?>Home/new_arrival_sizes");
    $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 
            $(".sizes_filter").html(data);

            }
        });  
        
         var url  = window.location.href;  
  url = url.replace("<?=base_url('new-arrivals')?>", "<?=base_url()?>Home/new_arrival_colors");
    $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 
            $(".colors_filter").html(data);

            }
        });  
       
    $(".filter_check").click(function() {
        var val = [];
        var filter_url='';
        if($(this).attr('at'))
     {
     var price=$(this).attr('at');
     
        if(val.length != 0)
        {
        filter_url+="&price="+price;
        }
        else
        {
          filter_url+="?price="+price;    
        }
     }
     else
     {
        var minprice=$(".min_price").val();
         var maxprice=$(".max_price").val(); 

         if(minprice.length != 0 && maxprice.length != 0)
        {
        filter_url+="?price="+minprice+","+maxprice;
        }
        
     }
     
    filter_products(filter_url)
    });
    
    $("#sort_by_product").change(function() 
    {
        filter_products()
    });
    
    $("#count_product").change(function() 
    {
        filter_products()
    });
    if(filter_url!='')
    {
     filter_products(filter_url);  
    }
    else
    {
    filter_products()
    }
    } 
});

    function page_click(page)
    {
       const url = new URL(window.location.href);
      url.searchParams.set('page', page);
        window.history.replaceState(null, null, url); // or pushState
        new_arrival_sort();
    }

function filter_products(filter_url='')
 {
     $(".overlay-spinner").toggle("fast");
     var val = [];
     var i=0;
     if(filter_url=='')
     {
     let searchParams = new URLSearchParams(window.location.search)
     if(searchParams.has('price'))
     {
     var price_url=searchParams.get('price');
     filter_url+="?price="+price_url;
     }
     }
     
        $('.cat_check:checked').each(function(i){
          val[i++] = $(this).val();
        });
        if(val.length != 0)
        {
        if(filter_url!='')
        {    
        filter_url+="&category="+val.join(",");
        }
        else
        {
          filter_url+="?category="+val.join(",");    
        }
        }
    var val = [];
     var i=0;
    $('.size_check:checked').each(function(i){
          val[i++] = $(this).val();
        });
        if(val.length != 0)
        {
        if(filter_url!='')
        {
        filter_url+="&size="+val.join(",");
        }
        else
        {
          filter_url+="?size="+val.join(",");  
        }
        }
         var val = [];
     var i=0;
    $('.color_check:checked').each(function(i){
          val[i++] = $(this).val();
        });
        if(val.length != 0)
        {
        if(filter_url!='')
        {
        filter_url+="&color="+val.join(",");
        }
        else
        {
          filter_url+="?color="+val.join(",");  
        }
        }
         var sort_by=$("#sort_by_product").val();
        var count=$("#count_product").val();
        if(filter_url!='')
        {
        filter_url+="&sort_by="+sort_by+"&count="+count;
        }
        else
        {
          filter_url+="?sort_by="+sort_by+"&count="+count;
        }
       let searchParams = new URLSearchParams(window.location.search)
     if(searchParams.has('page'))
     {
     var page=searchParams.get('page');
     filter_url+="&page="+page;
     } 
     
        
    window.history.pushState('category', 'Title', filter_url);
        new_arrival_sort();
 }
 
jQuery(document).ready(function($) { 
$('.product_desc_show').click(function(e){
    $(".product-short-desc").css('height','auto');
    $(".product_desc_show").hide();
    $(".product_desc_hide").show();
    
});
$('.product_desc_hide').click(function(e){
    $(".product-short-desc").animate({height:'50px'}, 100);;
    $(".product_desc_hide").hide();
    $(".product_desc_show").show();
    
});



/*cart function */

$(".cartbtn").click(function() {
    var info=[];
    var color='';
    var size='';
    var qty='';

     var product_id=$(this).attr('product_id');
     color=$(".color-variations .active").attr("at");
     size=$(".size-variations .active").attr("at");
     qty =$(".quantity").val();
     if(!$(".color-variations .active").attr("at"))
     {
        
         Lobibox.notify("error", {
             title: 'Add to Cart Error!',
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg: 'Select Color!',
                }); 
         return false;
     }
     if(!$(".size-variations .active").attr("at"))
     {
         Lobibox.notify("error", {
             title: 'Add to Cart Error!',
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg: 'Select Size!',
                }); 
         return false;
     }
     if(qty==0 || qty=='')
     {
         //alert('Minimum Quntity is 1 !');
          Lobibox.notify("error", {
                    title: 'Add to Cart Error!',
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg: 'Minimum Quntity is 1 !',
                }); 
         return false;
     }
     
    
        jQuery('.cartbtn i').removeClass('w-icon-cart');
        jQuery('.cartbtn i').addClass('fa fa-spinner fa-spin');

 
    var url="<?=base_url()?>Home/add_cart";
    $.ajax({
            type: "POST",
            url: url, 
            data: { product_id: product_id, color: color,size: size,qty: qty },
             dataType: 'json',
            success: function(data){ 
                jQuery('.cartbtn i').removeClass('fa fa-spinner fa-spin');
        jQuery('.cartbtn i').addClass('w-icon-cart');
            $('.products').html(data['output']);
            $('.price').html(data['cart_total']);
            $('.cart-count').html(data['counts_cart']);
            var typedata=data['msg_type'];
            var message=data['message'];
            Lobibox.notify(typedata, {
                title: 'Add to Cart Message.',
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg: message,
                });
            
            if(data['counts_cart']==0)
            {
              $(".cart-total").hide();
              $(".cart-action").hide();
            }
            else
            {
               $(".cart-total").show();
              $(".cart-action").show(); 
            }
        

            }
        }); 
});
$(document).on('click','.btn-close',function(){
     var product_id=$(this).attr('id');
     var rowid=$(this).attr('rowid');
     Lobibox.confirm({
                msg: 'Are You Sure! You Want to delete This Cart Item!',
                callback: function ($this, type) {
                    if(type=='no')
                    {
                    return;
                    }
                    else
                    {
                var url="<?=base_url()?>Home/delete_cart";
                    $.ajax({
                            type: "POST",
                            url: url, 
                            data: { product_id: product_id, rowid: rowid},
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
                                msg:'Cart Item Successfully Deleted.',
                            });
                            $('.products').html(data['output']);
                            $('.price').html(data['cart_total']);
                            $('.cart-count').html(data['counts_cart']);
                            if(data['counts_cart']==0)
                            {
                              $(".cart-total").hide();
                              $(".cart-action").hide();
                            }
                            else
                            {
                               $(".cart-total").show();
                              $(".cart-action").show(); 
                            }
                            }
                        });
                }
            }
     });    

     
});
/*Quantity NUmber increament in Cart page*/
 jQuery('<div class="quantity-nav"><div class="quantity-button quantity-down">-</div></div>').insertBefore('.quantity input');
  jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });
      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
});
 function cart_onload()
{
    var url="<?=base_url()?>Home/show_cart";
    $.ajax({
            type: "POST",
            url: url, 
             dataType: 'json',
            success: function(data){ 
            $('.products').html(data['output']);
            $('.price').html(data['cart_total']);
            $('.cart-count').html(data['counts_cart']);
            if(data['counts_cart']==0)
            {
              $(".cart-total").hide();
              $(".cart-action").hide();
            }
            else
            {
               $(".cart-total").show();
              $(".cart-action").show(); 
            }
            
            }
        }); 
}

function remove_cart_item(cart_row_id)
{
     Lobibox.confirm({
                msg: 'Are You Sure! You Want to delete This Cart Item!',
                callback: function ($this, type) {
                    if(type=='no')
                    {
                    return;
                    }
                    else
                    {
  var url="<?=base_url()?>Home/delete_cart";
    $.ajax({
            type: "POST",
            url: url, 
            data: { rowid: cart_row_id},
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
                                msg:'Cart Item Successfully Deleted.',
                            });
            checking_max_qty(cart_row_id);
            cart_onload();
            }
        }); 
                
                    }
                }
     });    
}

function checking_max_qty(cart_row_id)
{
var qty=$('.'+cart_row_id).val(); 
  var url="<?=base_url()?>Home/update_cart";
    $.ajax({
            type: "POST",
            url: url, 
            data: { cart_row_id: cart_row_id, qty: qty},
             dataType: 'json',
            success: function(data){ 
                if(data['cart_total']=='Rs.0')
                {
                $('.emptycart').html('<h3 style="margin: 15%;    text-align: center;    color: red;">Shoping Cart Empty !</h3>');    
                }
                else
                {
            $('.cart_page_details').html(data['output']);
            $('#subtotal_accumulator').html(data['cart_total']);
                }
            cart_onload();
            /*Quantity NUmber increament in Cart page*/
 jQuery('<div class="quantity-nav"><div class="quantity-button quantity-down">-</div></div>').insertBefore('.quantity input');
  jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });
      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
            }
        }); 
}
function toster_show(typedata,message)
{
        toastr.options.timeOut = 2000; // 1.5s    
    
    
}
jQuery(document).ready(function($) {
$(".address_setter").click(function() {
    if($('.address_setter').is(":checked"))
    {  
      $('input[name="ship_to"]').prop('checked', false);
    }
    else
    {
        $('.address_setter').prop('checked', true);
    }
});    
$(".shipment_to").click(function() {
        $(".account-create").hide();
       var att_id= $(this).attr('data-id');
      
       if($(this).prop("checked") == true){
                 $("#address_"+att_id).fadeIn("100");
            }
            else{
                 $(".account-create").fadeOut("100");
                 // $(".account-create").hide("100");
            }
            var value_storage=$(this).val();
           // console.log(value_storage);
    if(value_storage=='default'){
         $.ajax({
        url: '<?=base_url()?>Front/get_address_data',
        //contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: {'address_id': att_id}, // change this to send js object
        type: "post",
        success: function(data){
           //document.write(data); just do not use document.write
           $('#f_name_2').val(data.shipping_fname);
            $('#l_name_2').val(data.shipping_lname);
             $('#email_2').val(data.shipping_email);
              $('#shipment_street_1').val(data.address_line_1);
               $('#shipment_street_2').val(data.address_line_2);
                $('#city_2').val(data.city);
                 $('#state_2').val(data.state);
                //  $('#country_2').val(data.country);
                   $('#postcode_2').val(data.zipcode);
                    var valt=$("#country_2").children('[value='+data.country+']').attr('selected', true);
                     $('#country_2').val(data.country);
                  // $('.shipment_countries option[value="'+data.country+'"]').prop('selected', true);
                   // console.log($('.shipment_countries option[value="'+data.country+'"]'));
        }
      });
    }else if(value_storage=='other_shipment'){
        $('#f_name_2').val('');
            $('#l_name_2').val('');
             $('#email_2').val('');
              $('#shipment_street_1').val('');
               $('#shipment_street_2').val('');
                $('#city_2').val('');
                 $('#state_2').val('');
                //  $('#country_2').val(data.country);
                   $('#postcode_2').val('');
                    $("#country_2").children('[value=IN]').attr('selected', true);
                    $('#country_2').val('IN');
    }
    });

    $("#address_set").on("change", function () {
        $(".ship-to-different").slideToggle("100");
	});
});
/*Checkout New Javascript*/
jQuery(document).ready(function($) { 
    
$("#creadential_updater").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           dataType:"json",
           data: form.serialize(), // serializes the form's elements.
           success: function(datares)
           {
              
                if(datares.status=='1'){// show response from the php script.
                 Lobibox.notify("success", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg:datares.msg,
                });
                }else if(datares.status=='0' || datares.status=='2'){
                     Lobibox.notify("error", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg:datares.msg,
                });
                }
           }
         });
});    
$("#update_billing_info").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           dataType:"json",
           data: form.serialize(), // serializes the form's elements.
           success: function(datares)
           {
              
                if(datares.status=='1'){// show response from the php script.
                 Lobibox.notify("success", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg:datares.msg,
                });
                }else if(datares.status=='0' || datares.status=='2'){
                     Lobibox.notify("error", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg:datares.msg,
                });
                }
           }
         });


});    
    
$(document).on('click','.submit_address',function(){
    $('.address_checkout').hide();
    $('.payment_checkout').show();
    $('.chekout_form').removeClass('strong_highlight');
    $('.chekout_payment').addClass('strong_highlight');
});


$(document).on('click','.paynow',function(){
    var paymentmethod = $("input[type='radio'][name='paymentmethod']:checked").val();
    var bill_fname=$("#f_name").val();
    var bill_lname=$("#l_name").val();
    var bill_email=$("#email").val();
    var bill_country=$("#country").val();
    var bill_street_line_1=$("#bill_street_line_1").val();
    var bill_street_line_2=$("#bill_street_line_2").val();
    var bill_town=$("#bill_town").val();
    var bill_state=$("#bill_state").val();
    var bill_postcode=$("#bill_postcode").val();
    var bill_phone=$("#bill_phone").val();
    var ship_to=$(".shipment_choice:checked").val();
    var ship_fname=$("#f_name_2").val();
    var ship_lname=$("#l_name_2").val();
    var ship_email=$("#email_2").val();
    var ship_country=$("#country_2").val();
    var ship_add_line_1=$("#shipment_street_1").val();
    var ship_add_line_2=$("#shipment_street_2").val();
    var ship_city=$("#city_2").val();
    var ship_state=$("#state_2").val();
    var ship_postcode=$("#postcode_2").val();
    var ship_ordernote=$("#ordernote").val();
    var cart_t_c=$("#cart_t_c").val();
  
    var data_acc="cart_t_c="+cart_t_c+"&paymentmethod="+paymentmethod+"&bill_fname="+bill_fname+"&bill_lname="+bill_lname+"&bill_email="+bill_email+"&bill_country="+bill_country+"&bill_street_line_1="+bill_street_line_1+"&bill_street_line_2="+bill_street_line_2+"&bill_town="+bill_town+"&bill_state="+bill_state+"&bill_postcode="+bill_postcode+"&bill_phone="+bill_phone+"&ship_to="+ship_to+"&ship_fname="+ship_fname+"&ship_lname="+ship_lname+"&ship_email="+ship_email+"&ship_country="+ship_country+"&ship_add_line_1="+ship_add_line_1+"&ship_add_line_2="+ship_add_line_2+"&ship_city="+ship_city+"&ship_state="+ship_state+"&ship_postcode="+ship_postcode+"&ship_ordernote="+ship_ordernote;
     $.ajax({
         data: data_acc,
         type: "post",
         dataType: 'json',
         url:"<?=base_url()?>Home/insert_order_data",
         success: function(data)
         {
             if(data['error'])
             {
                 $('.address_checkout').show();
                 $('.payment_checkout').hide();
                 $('.chekout_form').addClass('strong_highlight');
    $('.chekout_payment').removeClass('strong_highlight');
                $.each(data['error_output'], function(key, value) {
                    if(value!='')
                    {
                    $('#'+key).addClass('is-invalid');
                    }
                    else
                    {
                    $('#'+key).removeClass('is-invalid');    
                    }

                    //$('#'+key).parents('.form-group').find('#error').html(value);
                });
             }
             else
             {
             if(data['paymentmethod']=='cash')
             {
                 location.href = '<?=base_url()?>payment-success';
             }
             else
             {
                 location.href = '<?=base_url()?>Home/payment';
             }
             }
             //toastr.error(data,"Error");
        },
          
    complete: function(data) {
        // $(".spinner").remove();
    }
});
});
});


</script> 
    
    
<script>

/*Modal Js view Order Info Data*/
function view_order_info(order_id){
        var status='1';
            $.ajax({
            url:'<?=base_url()?>Home/show_order_detail/'+order_id,
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


$(document).ready(function(){
    dataTable =$('#ordertable').DataTable({
        // Processing indicator
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('Home/get_orders'); ?>",
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
$(document).ready(function() {
  $(".set > a").on("click", function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this)
        .siblings(".content")
        .slideUp(200);
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
    } else {
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
      $(this)
        .find("i")
        .removeClass("fa-plus")
        .addClass("fa-minus");
      $(".set > a").removeClass("active");
      $(this).addClass("active");
      $(".content").slideUp(200);
      $(this)
        .siblings(".content")
        .slideDown(200);
    }
  });
});



/*WISHLIST ADDING STARTS HERE*/
$(document).on('click','.add-wishlist',function(e){
      e.preventDefault();
      var pid_is=$(this).attr("data-pid")
    $.ajax({
        url: '<?=base_url()?>Home/Add_to_wishlist',
        type: 'POST',
        dataType: 'json',
        
        data: {
            pid :pid_is,

        },
        success: function(data) {
             if(data.success)
             {
                 Lobibox.notify("success", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg:data.success,
                });
                $(".wishlist_icone_top_"+pid_is).removeClass("w-icon-heart").addClass("w-icon-heart-full");
                $(".wishlist-count").html(data.count);
            }
            else
            {
                Lobibox.notify("error", {
                    size: 'normal',
                    delayIndicator: false,
                    showClass: 'flipInX',
                    hideClass: 'zoomOutDown',
                    position: 'top right',
                    delayIndicator:true,      
                    closeOnClick:true, 
                    sound:true,
                    msg: data.error,
                });
                 $(".wishlist_icone_top_"+pid_is).addClass("w-icon-heart").removeClass("w-icon-heart-full");
                 $(".wishlist-count").html(data.count);
                  //console.log(data.message_2);
            }
           
        },
       
    });

});
</script>    
    