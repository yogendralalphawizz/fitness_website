<?php if ($this->session->flashdata('info_message') != ""):?>
<script type="text/javascript">
  //$.NotificationApp.send("<?php echo 'success'; ?>!", '<?php echo $this->session->flashdata("info_message");?>' ,"top-right","rgba(0,0,0,0.2)","info");
  Lobibox.notify('info', {
                    size: 'mini',
                    rounded: true,
                    position: 'top right',
                    delayIndicator: false,
                    msg: '<?php echo $this->session->flashdata("info_message");?>'
                });
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
<script type="text/javascript">
  Lobibox.notify('error', {
                    size: 'mini',
                    position: 'top right',
                    rounded: true,
                    delayIndicator: false,
                    msg: '<?php echo $this->session->flashdata("error_message");?>'
                });
</script>
<?php endif;?>

<?php if ($this->session->flashdata('flash_message') != ""):?>
<script type="text/javascript">
Lobibox.notify('success', {
                    size: 'mini',
                    position: 'top right',
                    rounded: true,
                    delayIndicator: false,
                    msg: '<?=$this->session->flashdata('flash_message')?>'
                });
</script>
<?php endif;?>

<script>
$(document).ready(function(){

 $('#registration_form').on('submit', function(event){
  event.preventDefault();
  

  $.ajax({
   url:"<?php echo base_url(); ?>login/register",
   method:"POST",
   data:$(this).serialize(),
   dataType:"json",
   beforeSend:function(){
    $('#register-btn').attr('disabled', 'disabled');
   },
   success:function(data)
   {
    if(data.error)
    {
     if(data.username_error != '')
     {
      $('#username_error').html(data.username_error);
     }
     else
     {
      $('#username_error').html('');
     }
	 if(data.firstname_error != '')
     {
      $('#firstname_error').html(data.firstname_error);
     }
     else
     {
      $('#firstname_error').html('');
     }
	 if(data.lastname_error != '')
     {
      $('#lastname_error').html(data.lastname_error);
     }
     else
     {
      $('#lastname_error').html('');
     }
     if(data.email_error != '')
     {
      $('#email_error').html(data.email_error);
     }
     else
     {
      $('#email_error').html('');
     }
     if(data.password_error != '')
     {
      $('#password_error').html(data.password_error);
     }
     else
     {
      $('#password_error').html('');
     }
     if(data.cpassword_error != '')
     {
      $('#cpassword_error').html(data.cpassword_error);
     }
     else
     {
      $('#cpassword_error').html('');
     }
     if(data.recaptcha_error != '')
     {
      $('#recaptcha_error').html(data.recaptcha_error);
     }
     else
     {
      $('#recaptcha_error').html('');
     }
	 if(data.terms_and_conditions_error != '')
     {
      $('#terms_and_conditions_error').html(data.terms_and_conditions_error);
     }
     else
     {
      $('#terms_and_conditions_error').html('');
     }
	 
	 
    }
    if(data.success)
    {
    
     $('#username_error').html('');
	 $('#firstname_error').html('');
	 $('#lastname_error').html('');
     $('#email_error').html('');
     $('#password_error').html('');
     $('#cpassword_error').html('');
	 $('#terms_and_conditions').html('');
	 
     $('#registration_form')[0].reset();
	 
	 Lobibox.notify('success', {
                    size: 'normal',
                    position: 'top right',
                    rounded: true,
                    delayIndicator: false,
                    msg: data.success
                });
    window.location.href = '<?php echo base_url(); ?>login';        
    }
    $('#register-btn').attr('disabled', false);
   }
  })
 });

});




function checkRequiredFields() {
	var pass = 1;
	$('form.required-form').find('input, select').each(function(){
		if($(this).prop('required')){
			if ($(this).val() === "") {
				pass = 0;
				var name_error=$(this).attr("name");
				error_required_field(name_error);
				
			}
		}
		
	});

	if (pass === 1) {
		$('form.required-form').submit();
	}
}

function error_required_field(msg) {
    var new_text=msg.replace("_", "");
	Lobibox.notify('error', {
                    size: 'mini',
                    position: 'top right',
                    rounded: true,
                    delayIndicator: false,
                    msg: new_text.toUpperCase()+" is a mandatory field",
                });
    
}
</script>

<script type="text/javascript">
function toggleRatingView(course_id) {
  $('#course_info_view_'+course_id).toggle();
  $('#course_rating_view_'+course_id).toggle();
  $('#edit_rating_btn_'+course_id).toggle();
  $('#cancel_rating_btn_'+course_id).toggle();
}

function publishRating(course_id) {
    var review = $('#review_of_a_course_'+course_id).val();
    var starRating = 0;
    starRating = $('#star_rating_of_course_'+course_id).val();
    if (starRating > 0) {
        $.ajax({
            type : 'POST',
            url  : '<?php echo site_url('home/rate_course'); ?>',
            data : {course_id : course_id, review : review, starRating : starRating},
            success : function(response) {
                location.reload();
            }
        });
    }else{

    }
}
</script>


<!--sweart alert script-->

<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");
    
       swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
             url: '<?=base_url()?>Home/project_delete/'+id,
             type: 'DELETE',
             error: function() {
                alert('Something is wrong');
             },
             success: function(data) {
                  $("#"+id).remove();
                  swal("Deleted!", "Your imaginary file has been deleted.", "success");
             }
          });
        } else {
          swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
      });
     
    });
    
</script>


<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>


<script type="text/javascript">
    $(function () {
        $("a[id='boxshow']").click(function () {
            $("#exampleModal").modal("show");
            return false;
        });
    });
</script>


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>


  <!-- box model show -->
<!--<script type="text/javascript">
function load_port(pid)
{
    $.ajax({
                type: "POST",
                url: "<?php echo site_url('Home/get_portfolio');?>",
                data: "pid="+pid,
                success: function (response) {
                $(".displaycontent").html(response);
                //$('#myModal).modal('show'); 
                }
            });
}
</script>-->

<!--<div class="modal fade bd-example-modal-lg displaycontent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">-->
<script>
$(document).ready(function() 
{
    var url='<?=base_url()?>Home/new_arrivals';
    $.ajax({
            type: "POST",
            url: url, 
            cache: false, 
            async: false,  
            success: function(data){ 


            }
        }); 
}
function get_new_arrival()
{
    
}
   
</script>





