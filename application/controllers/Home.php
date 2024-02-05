<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        $this->load->library('cart');
        // $this->load->library('stripe');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
       
        // CHECK CUSTOM SESSION DATA
        $this->session_data();
		$this->load->model('Home_model');
		$this->load->library("pagination");
    }

    public function index() {
        $this->home();
    }

    public function home() {
        $page_data['page_name'] = "home";
        $page_data['page_title'] = site_phrase('home');
        $page_data['categories_slider'] = $this->Home_model->categories();
        $page_data['products_slider'] = $this->Home_model->products_slider();
        $page_data['off_products_slider'] = $this->Home_model->off_products_slider();
        $page_data['banners'] = $this->Home_model->banners();
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function product_detail($product_slug)
    {
       $page_data['page_name'] = "product";
        $page_data['page_title'] = site_phrase('Product Detail');
        $product_detial= $this->Home_model->product_detail($product_slug);

        $page_data['product_detial']=$product_detial;
        $product_id=$product_detial['product_id'];
        $page_data['product_images'] = $this->Home_model->product_images($product_id);
        $page_data['product_sizes'] = $this->Home_model->product_sizes($product_id);
        $page_data['product_colors'] = $this->Home_model->product_colors($product_id);
        $page_data['product_match'] = $this->Home_model->product_match($product_id);
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data); 
    }
    public function new_arrivals()
    {
        $page_data['page_name'] = "new_arrivals";
        $page_data['page_title'] = site_phrase('New Arrivals');
        $page_data['categories_slider'] = $this->Home_model->categories();
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function new_arrival_products($search="",$category="",$size="",$color="",$price="",$sort_by="",$count="12",$page="1")
    {
        if($this->input->get('search', TRUE))
        {
        $search=$this->input->get('search');
        }
        if($this->input->get('page', TRUE))
        {
        $page=$this->input->get('page');
        }
        if($this->input->get('sort_by', TRUE))
        {
        $sort_by=$this->input->get('sort_by');
        }
        if($this->input->get('count', TRUE))
        {
        $count=$this->input->get('count');
        }
        if($this->input->get('category', TRUE))
        {
        $category=$this->input->get('category');
        }
        if($this->input->get('size', TRUE))
        {
        $size=$this->input->get('size');
        }
        if($this->input->get('color', TRUE))
        {
        $color=$this->input->get('color');
        }
        if($this->input->get('price', TRUE))
        {
        $price=$this->input->get('price');
        }
        
    $new_arrival_products = $this->Home_model->new_arrival_products($search,$category,$size,$color,$price,$sort_by,$count,$page);
    if($new_arrival_products)
    {
    foreach($new_arrival_products as $row)
    {
    ?>
    <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?=base_url()?>product/<?=$row['slug']?>">
                                            <?php
                                            $images = $this->db->get_where('product_image', ['product_id' => $row['product_id']])->result_array();
                                            $i_img=0;
                                            foreach($images as $image_row)
                                            {
                                                if($i_img<2)
                                                {
                                                ?>
                                             <img src="<?=base_url()?><?=$image_row['image']?>" alt="<?=$row['product_name']?>" width="300"
                                                    height="338" />   
                                                <?php
                                                $i_img++;
                                                }
                                            }
                                            ?>
                                                
                                            </a>
                                            <!--<div class="product-action-horizontal">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                    title="Add to cart"></a>
                                                <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                    title="Wishlist"></a>
                                                <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                    title="Compare"></a>
                                                <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                                    title="Quick View"></a>
                                            </div>-->
                                        </figure>
                                        <div class="product-details">
                                            <div class="product-cat">
                                                <?php
                                                $cate_name=array();
                                    		    $cate_slug=explode(",",$row['category']);
                                    		    for($i=0;$i<count($cate_slug);$i++)
                                        		{
                                        		    $this->db->like('category_slug', $cate_slug[$i], 'both');
                                        		    $category = $this->db->get('categories')->row_array();
                                        		   ?>
                                        		  | <a href="<?=base_url()?>category/<?=$category['category_slug']?>"><?=$category['category_name']?></a> |
                                        		<?php
                                        		}
                                        		?>
                                                
                                            </div>
                                            <h3 class="product-name">
                                                <a href="<?=base_url()?>product/<?=$row['slug']?>"><?=$row['product_name']?></a>
                                            </h3>
                                            <!--<div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                            </div>-->
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <?php
                                                    if($row['offer_price'])
                                                    {
                                                        echo '<strike>Rs. '.$row['price'].'</strike> Rs. '.$row['offer_price'];
                                                    }
                                                    else
                                                    {
                                                       echo 'Rs. '.$row['price']; 
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    <?php
    }
    }
    else
    {
        echo "<h3>Sorry, Result Not Found !</h3>";
    }
    }
    public function new_arrival_total_products($search="",$category="",$size="",$color="",$price="",$sort_by="",$count="12",$page="1")
    {
        if($this->input->get('search', TRUE))
        {
        $search=$this->input->get('search');
        }
       if($this->input->get('page', TRUE))
        {
        $page=$this->input->get('page');
        }
        if($this->input->get('sort_by', TRUE))
        {
        $sort_by=$this->input->get('sort_by');
        }
        if($this->input->get('count', TRUE))
        {
        $count=$this->input->get('count');
        }
        if($this->input->get('category', TRUE))
        {
        $category=$this->input->get('category');
        }
        if($this->input->get('size', TRUE))
        {
        $size=$this->input->get('size');
        }
        if($this->input->get('color', TRUE))
        {
        $color=$this->input->get('color');
        }
        if($this->input->get('price', TRUE))
        {
        $price=$this->input->get('price');
        }
        
    $new_arrival_products = $this->Home_model->new_arrival_total_products($search,$category,$size,$color,$price,$sort_by,$count,$page);
    if($new_arrival_products)
    {
    $tot_product=count($new_arrival_products);
    }
    else
    {
      $tot_product=0;  
    }
    $count_change=$count;
    if(!isset($page) || $page==1)
    {
     $start=1;    
     $count=$count;  
     $per_page=1;
     $next_page=2;
     $page=1;
    }
    else
    {
     $start=$count*($page-1)+1;    
     $count_change=$count*$page;
     $per_page=$page-1;
     $next_page=$page+1;
    }
    if($count>=$tot_product)
    {
       $count_change= $tot_product;
    }
    if($tot_product==0)
    {
     $tot_page=1;   
    }
    else
    {
    $tot_page=ceil($tot_product/$count);
    }
    
    ?>
    <p class="showing-info mb-2 mb-sm-0">
                                    Showing<span><?=$start?> - <?=$count_change?> of <?=$tot_product?></span>Products
                                </p>
                                <ul class="pagination">
                                    <li class="prev <?php if($per_page==1) { echo "disabled"; } ?>">
                                        <a href="javascript:void(0)" class="page_click" page_at="<?=$per_page?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                            <i class="w-icon-long-arrow-left"></i>Prev
                                        </a>
                                    </li>
                                    <?php
                                    for($i=1;$i<=$tot_page;$i++)
                                    {
                                        
                                        ?>
                                         <li class="page-item <?php if($page==$i) { echo "active"; } ?>">
                                        <a class="page-link page_click" onclick="page_click(<?=$i?>);" at=<?=$i?> href="javascript:void(0)"><?=$i?></a>
                                    </li>
                                        <?php
                                    }
                                    ?>
                                    
                                    <li class="next" <?php if($tot_page==$page) { echo "disabled"; } ?>>
                                        <a href="javascript:void(0)" class="page_click" page_at="<?=$next_page?>" aria-label="Next">
                                            Next<i class="w-icon-long-arrow-right"></i>
                                        </a>
                                    </li>
                                </ul>
    <?php                            
    }
    
    public function new_arrival_categories()
    {
        if($this->input->get('category', TRUE))
        {
        $cat_slug=$this->input->get('category', TRUE);
        $cat_slug_arr=explode(",",$cat_slug);
        }
        else
        {
         $cat_slug_arr=array();   
        }
        $new_arrival_categories = $this->Home_model->new_arrival_categories();
    foreach($new_arrival_categories as $row)
    {
        if(in_array($row['category_slug'],$cat_slug_arr))
        {
    ?>
    <li><input type="checkbox" checked class="filter_check cat_check" value="<?=$row['category_slug']?>"><?=$row['category_name']?></li>
    <?php
        }
        else
        {
            ?>
    <li><input type="checkbox"  class="filter_check cat_check" value="<?=$row['category_slug']?>"><?=$row['category_name']?></li>
            <?php
        }
    }
    }
    
    public function new_arrival_sizes()
    {
     if($this->input->get('size', TRUE))
        {
        $size_slug=$this->input->get('size', TRUE);
        $size_slug_arr=explode(",",$size_slug);
        }
        else
        {
         $size_slug_arr=array();   
        }
        $new_arrival_sizes = $this->Home_model->new_arrival_sizes();
    foreach($new_arrival_sizes as $row)
    {
        if(in_array($row['slug'],$size_slug_arr))
        {
    ?>
    <li><input type="checkbox" checked class="filter_check size_check" value="<?=$row['slug']?>"><?=$row['name']?></li>
    <?php
        }
        else
        {
            ?>
    <li><input type="checkbox"  class="filter_check size_check" value="<?=$row['slug']?>"><?=$row['name']?></li>
            <?php
        }
    }   
    }
    
    public function new_arrival_colors()
    {
     if($this->input->get('color', TRUE))
        {
        $color_slug=$this->input->get('color', TRUE);
        $color_slug_arr=explode(",",$color_slug);
        }
        else
        {
         $color_slug_arr=array();   
        }
        $new_arrival_colors = $this->Home_model->new_arrival_colors();
    foreach($new_arrival_colors as $row)
    {
        if(in_array($row['slug'],$color_slug_arr))
        {
    ?>
    <li><input type="checkbox" checked class="filter_check color_check" value="<?=$row['slug']?>"><?=$row['name']?></li>
    <?php
        }
        else
        {
            ?>
    <li><input type="checkbox"  class="filter_check color_check" value="<?=$row['slug']?>"><?=$row['name']?></li>
            <?php
        }
    }   
    }
    
    public function product_details()
    {
       $page_data['page_name'] = "product_details";
        $page_data['page_title'] = site_phrase('Product');
        $page_data['categories_slider'] = $this->Home_model->categories();
        $page_data['products_slider'] = $this->Home_model->products_slider();
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data); 
    }
    
	public function contact_us() {
	    $this->form_validation->set_rules('name','Name','required|alpha');
	    $this->form_validation->set_rules('email','Email','required|valid_email');
	    $this->form_validation->set_rules('tel','Mobile Number','required|regex_match[/^[0-9]{10}$/]');
	    $this->form_validation->set_rules('message','Message','required');
	    if($this->form_validation->run()==false){
	    $page_data['page_name'] = "contact_us";
        $page_data['page_title'] = site_phrase('contact_us');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);   
	    }
	    else{
	        $name = $this->input->post('name');
	        $email = $this->input->post('email');
	        $tel = $this->input->post('tel');
	        $message = $this->input->post('message');
	        
	        $data = array(
	            'name'=>$name,
	            'email'=>$email,
	            'phone'=>$tel,
	            'message'=>$message,
	            );
	       $res = $this->Home_model->insert_contact_us($data);   
	       if($res){
	           $this->session->set_flashdata('success','Inquiry Submited Successfully!!');
	           redirect('Home/contact_us');
	       }
	       else{
	          $this->session->set_flashdata('error','Inquiry Not Submited'); 
	           redirect('Home/contact_us');
	       }
	    }
       
    }

	public function about_us() {
        $page_data['page_name'] = 'about_us';
        $page_data['page_title'] = site_phrase('about_us');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

	
	public function login() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'login';
        $page_data['page_title'] = site_phrase('login');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function register() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'register';
        $page_data['page_title'] = site_phrase('register');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

	public function forgot_password() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'recover_password';
        $page_data['page_title'] = site_phrase('recover_password');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
   
   private function upload_helper($file, $target_dir, $isRequired = true, $allowedExt = [], $allowedSize = '*')
  {
	if(isset($_FILES[ $file ]) &&  $_FILES[ $file ]['error'] == 0) { $FILE_array = $_FILES[ $file ]; }
	elseif($isRequired == true){ throw new Exception('File was not uploaded to Server.'); }
	else{ return true; } // File is not required.

	if($FILE_array['name'] == ''){ throw new Exception('File name is not valid.'); }

	if($allowedSize != '*')
	{
		$allowedSize = $allowedSize * 1024;  /* In KB */
		if( filesize( $FILE_array['tmp_name'] ) > $allowedSize ) { throw new Exception('Uploaded File Size was Too Large'); }
	}
	
	$target_file_name = preg_replace('/[^A-Za-z0-9\.\-\_]/', '', basename( $FILE_array['name'] ) );

	$target_file_details = pathinfo( $target_file_name );
	$target_file_wo_ext = $target_file_details['filename'];
	$target_file_ext = strtolower( $target_file_details['extension'] );

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	if(!$finfo){ throw new Exception('FINFO : Internal Error Occured.'); }
	$file_mime = finfo_file($finfo, $FILE_array['tmp_name']);
	finfo_close($finfo);
	
	$allowedExt = array_map('strtolower', $allowedExt);
	if( ! in_array($target_file_ext, $allowedExt) ){
		throw new Exception('File type is not supported.');
	}

	if( $file_mime == 'text/plain' && $target_file_ext != 'txt' ){
		$target_file_ext = 'txt';
	} else if ( $target_file_ext == '' ){
		$target_file_ext = 'file';
	}

	$i = 0;
	$target_path = $target_dir . '/' . $target_file_name;
	while( file_exists( $target_path ) ){
		$target_file_name = $target_file_wo_ext . ' ('.$i.').' . $target_file_ext;
		$target_path = $target_dir . '/' . $target_file_name;
		$i++;
	}

	if(!is_dir($target_dir)){
		if( ! mkdir($target_dir, 0777, true) ){
			throw new Exception('Upload Directory is not available.');
		}
	}
	
	if(!@move_uploaded_file($FILE_array['tmp_name'], $target_path))
		{ throw new Exception('File Could not be uploaded.'); }

	return array(
		'file_name' => $target_file_name,
		'file_ext' => $target_file_ext,
		'file_mime'=> $file_mime,
		'orig_name' => $FILE_array['name']
	);
}

    public function user_profile(){
         if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->data = array();
        
        if( $this->input->method() == 'post' ){
            
            try {
                $image_data = $this->upload_helper('profile', './uploads/profiles/', false, ['jpg','png','gif']);
            } catch ( Exception $e ){
                $this->data['image_upload_error'] = $e->getMessage();
            }
            
            $this->form_validation->set_rules('f_name','First Name','required');
            $this->form_validation->set_rules('l_name','Last Name','required');
            $this->form_validation->set_rules('phone','Phone','required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('biography','Biography','required');
            
            if( $this->form_validation->run() === TRUE && ! isset($this->data['image_upload_error']) ){
                // save to database
                $this->db->where('id', $this->session->userdata('user_id'));
                $this->db->set([
                    'first_name' => $this->input->post('f_name'),
                    'last_name' => $this->input->post('l_name'),
                    'phone' => $this->input->post('phone'),
                    'biography' => $this->input->post('biography'),
                ]);
                
                if( isset($image_data['file_name']) ){
                    $this->db->set('profile', $image_data['file_name']);
                }
                
                if( $this->db->update('users') ){
                    $this->session->set_flashdata('success', 'Successfully Saved the profile data.');
                } else {
                    $this->session->set_flashdata('error', 'Internal Error Occured.');
                }
            } else {
                // show errors
            }
        }
        
        $this->data['profile_data'] = $this->db->get_where('users', [
            'id' => $this->session->userdata('user_id')
        ])->row_array();
        
        
        $this->data['page_name'] = "user_profile";
        $this->data['page_title'] = "User Profile";
        
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $this->data);
    }
    
    
   
       
  
	


/* ABOVE CODE IS OF ODDDEVELOPERS ONLY */
    public function shopping_cart() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $page_data['page_name'] = "shopping_cart";
        $page_data['page_title'] = site_phrase('shopping_cart');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    public function set_layout_to_session() {
        $layout = $this->input->post('layout');
        $this->session->set_userdata('layout', $layout);
    }


    public function instructor_page($instructor_id = "") {
        $page_data['page_name'] = "instructor_page";
        $page_data['page_title'] = site_phrase('instructor_page');
        $page_data['instructor_id'] = $instructor_id;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    public function my_messages($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }
        if ($param1 == 'read_message') {
            $page_data['message_thread_code'] = $param2;
        }
        elseif ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', site_phrase('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $message_thread_code), 'refresh');
        }
        elseif ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', site_phrase('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $param2), 'refresh');
        }
        $page_data['page_name'] = "my_messages";
        $page_data['page_title'] = site_phrase('my_messages');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function my_notifications() {
        $page_data['page_name'] = "my_notifications";
        $page_data['page_title'] = site_phrase('my_notifications');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function my_wishlist() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $page_data['page_name'] = "my_wishlist";
        $page_data['page_title'] = site_phrase('my_wishlist');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function purchase_history() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        $total_rows = $this->crud_model->purchase_history($this->session->userdata('user_id'))->num_rows();
        $config = array();
        $config = pagintaion($total_rows, 10);
        $config['base_url']  = site_url('home/purchase_history');
        $this->pagination->initialize($config);
        $page_data['per_page']   = $config['per_page'];

        if(addon_status('offline_payment') == 1):
            $this->load->model('addons/offline_payment_model');
            $page_data['pending_offline_payment_history'] = $this->offline_payment_model->pending_offline_payment($this->session->userdata('user_id'))->result_array();
        endif;

        $page_data['page_name']  = "purchase_history";
        $page_data['page_title'] = site_phrase('purchase_history');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function profile($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        if ($param1 == 'user_profile') {
            $page_data['page_name'] = "user_profile";
            $page_data['page_title'] = site_phrase('user_profile');
        }elseif ($param1 == 'user_credentials') {
            $page_data['page_name'] = "user_credentials";
            $page_data['page_title'] = site_phrase('credentials');
        }elseif ($param1 == 'user_photo') {
            $page_data['page_name'] = "update_user_photo";
            $page_data['page_title'] = site_phrase('update_user_photo');
        }
        $page_data['user_details'] = $this->user_model->get_user($this->session->userdata('user_id'));
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function update_profile($param1 = "") {
        if ($param1 == 'update_basics') {
            $this->user_model->edit_user($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_profile'), 'refresh');
        }elseif ($param1 == "update_credentials") {
            $this->user_model->update_account_settings($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_credentials'), 'refresh');
        }elseif ($param1 == "update_photo") {
            $this->user_model->upload_user_image($this->session->userdata('user_id'));
            $this->session->set_flashdata('flash_message', site_phrase('updated_successfully'));
            redirect(site_url('home/profile/user_photo'), 'refresh');
        }

    }

    public function handleWishList($return_number = "") {
        if ($this->session->userdata('user_login') != 1) {
            echo false;
        }else {
            if (isset($_POST['course_id'])) {
                $course_id = $this->input->post('course_id');
                $this->crud_model->handleWishList($course_id);
            }
            if($return_number == 'true'){
                echo sizeof($this->crud_model->getWishLists());
            }else{
                $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
            }
        }
    }
    public function handleCartItems($return_number = "") {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        $course_id = $this->input->post('course_id');
        $previous_cart_items = $this->session->userdata('cart_items');
        if (in_array($course_id, $previous_cart_items)) {
            $key = array_search($course_id, $previous_cart_items);
            unset($previous_cart_items[$key]);
        }else {
            array_push($previous_cart_items, $course_id);
        }

        $this->session->set_userdata('cart_items', $previous_cart_items);
        if($return_number == 'true'){
            echo sizeof($previous_cart_items);
        }else{
            $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
        }
    }

    public function handleCartItemForBuyNowButton() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        $course_id = $this->input->post('course_id');
        $previous_cart_items = $this->session->userdata('cart_items');
        if (!in_array($course_id, $previous_cart_items)) {
            array_push($previous_cart_items, $course_id);
        }
        $this->session->set_userdata('cart_items', $previous_cart_items);
        $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
    }

    public function refreshWishList() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
    }

    public function refreshShoppingCart() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/shopping_cart_inner_view');
    }

    public function isLoggedIn() {
        if ($this->session->userdata('user_login') == 1)
        echo true;
        else
        echo false;
    }

    //choose payment gateway
    /*public function payment(){
        if ($this->session->userdata('user_login') != 1)
        redirect('login', 'refresh');

        $page_data['total_price_of_checking_out'] = $this->session->userdata('total_price_of_checking_out');
        $page_data['page_title'] = site_phrase("payment_gateway");
        $this->load->view('payment/index', $page_data);
    }*/

    // SHOW PAYPAL CHECKOUT PAGE
    public function paypal_checkout($payment_request = "only_for_mobile") {
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
        redirect('home', 'refresh');

        //checking price
        if($this->session->userdata('total_price_of_checking_out') == $this->input->post('total_price_of_checking_out')):
            $total_price_of_checking_out = $this->input->post('total_price_of_checking_out');
        else:
            $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        endif;
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/paypal_checkout', $page_data);
    }

    // PAYPAL CHECKOUT ACTIONS
    public function paypal_payment($user_id = "", $amount_paid = "", $paymentID = "", $paymentToken = "", $payerID = "", $payment_request_mobile = "") {
        $paypal_keys = get_settings('paypal');
        $paypal = json_decode($paypal_keys);

        if ($paypal[0]->mode == 'sandbox') {
            $paypalClientID = $paypal[0]->sandbox_client_id;
            $paypalSecret   = $paypal[0]->sandbox_secret_key;
        }else{
            $paypalClientID = $paypal[0]->production_client_id;
            $paypalSecret   = $paypal[0]->production_secret_key;
        }

        //THIS IS HOW I CHECKED THE PAYPAL PAYMENT STATUS
        $status = $this->payment_model->paypal_payment($paymentID, $paymentToken, $payerID, $paypalClientID, $paypalSecret);
        if (!$status) {
            $this->session->set_flashdata('error_message', site_phrase('an_error_occurred_during_payment'));
            redirect('home', 'refresh');
        }
        $this->crud_model->enrol_student($user_id);
        $this->crud_model->course_purchase($user_id, 'paypal', $amount_paid);
        $this->email_model->course_purchase_notification($user_id, 'paypal', $amount_paid);
        $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
        if($payment_request_mobile == 'true'):
            $course_id = $this->session->userdata('cart_items');
            redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/paid', 'refresh');
        else:
            $this->session->set_userdata('cart_items', array());
            redirect('home', 'refresh');
        endif;

    }

    // SHOW STRIPE CHECKOUT PAGE
    public function stripe_checkout($payment_request = "only_for_mobile") {
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
        redirect('home', 'refresh');

        //checking price
        $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('payment/stripe/stripe_checkout', $page_data);
    }

    // STRIPE CHECKOUT ACTIONS
    public function stripe_payment($user_id = "", $payment_request_mobile = "") {
        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $response = $this->payment_model->stripe_payment($user_id);

        if ($response['payment_status'] === 'succeeded') {
            // STUDENT ENROLMENT OPERATIONS AFTER A SUCCESSFUL PAYMENT
            $this->crud_model->enrol_student($user_id);
            $this->crud_model->course_purchase($user_id, 'stripe', $response['paid_amount']);
            $this->email_model->course_purchase_notification($user_id, 'stripe', $response['paid_amount']);

            if($payment_request_mobile == 'true'):
                $course_id = $this->session->userdata('cart_items');
                $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/paid', 'refresh');
            else:
                $this->session->set_userdata('cart_items', array());
                $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                redirect('home', 'refresh');
            endif;
        }else{
            if($payment_request_mobile == 'true'):
                $course_id = $this->session->userdata('cart_items');
                $this->session->set_flashdata('flash_message', $response['status_msg']);
                redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/error', 'refresh');
            else:
                $this->session->set_flashdata('error_message', $response['status_msg']);
                redirect('home', 'refresh');
            endif;

        }

    }


    public function lesson($slug = "", $course_id = "", $lesson_id = "") {
        if ($this->session->userdata('user_login') != 1){
            if ($this->session->userdata('admin_login') != 1){
                redirect('home', 'refresh');
            }
        }

        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        $sections = $this->crud_model->get_section('course', $course_id);
        if ($sections->num_rows() > 0) {
            $page_data['sections'] = $sections->result_array();
            if ($lesson_id == "") {
                $default_section = $sections->row_array();
                $page_data['section_id'] = $default_section['id'];
                $lessons = $this->crud_model->get_lessons('section', $default_section['id']);
                if ($lessons->num_rows() > 0) {
                    $default_lesson = $lessons->row_array();
                    $lesson_id = $default_lesson['id'];
                    $page_data['lesson_id']  = $default_lesson['id'];
                }else {
                    $page_data['page_name'] = 'empty';
                    $page_data['page_title'] = site_phrase('no_lesson_found');
                    $page_data['page_body'] = site_phrase('no_lesson_found');
                }
            }else {
                $page_data['lesson_id']  = $lesson_id;
                $section_id = $this->db->get_where('lesson', array('id' => $lesson_id))->row()->section_id;
                $page_data['section_id'] = $section_id;
            }

        }else {
            $page_data['sections'] = array();
            $page_data['page_name'] = 'empty';
            $page_data['page_title'] = site_phrase('no_section_found');
            $page_data['page_body'] = site_phrase('no_section_found');
        }

        // Check if the lesson contained course is purchased by the user
        if (isset($page_data['lesson_id']) && $page_data['lesson_id'] > 0) {
            $lesson_details = $this->crud_model->get_lessons('lesson', $page_data['lesson_id'])->row_array();
            $lesson_id_wise_course_details = $this->crud_model->get_course_by_id($lesson_details['course_id'])->row_array();
            if ($this->session->userdata('role_id') != 1 && $lesson_id_wise_course_details['user_id'] != $this->session->userdata('user_id')) {
                if (!is_purchased($lesson_details['course_id'])) {
                    redirect(site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
                }
            }
        }else {
            if (!is_purchased($course_id)) {
                redirect(site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
            }
        }

        $page_data['course_id']  = $course_id;
        $page_data['page_name']  = 'lessons';
        $page_data['page_title'] = $course_details['title'];
        $this->load->view('lessons/index', $page_data);
    }

    public function my_courses_by_category() {
        $category_id = $this->input->post('category_id');
        $course_details = $this->crud_model->get_my_courses_by_category_id($category_id)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }

    public function search($search_string = "") {
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search_string = $_GET['query'];
            $page_data['courses'] = $this->crud_model->get_courses_by_search_string($search_string)->result_array();
        }else {
            $this->session->set_flashdata('error_message', site_phrase('no_search_value_found'));
            redirect(site_url(), 'refresh');
        }

        if (!$this->session->userdata('layout')) {
            $this->session->set_userdata('layout', 'list');
        }
        $page_data['layout']     = $this->session->userdata('layout');
        $page_data['page_name'] = 'courses_page';
        $page_data['search_string'] = $search_string;
        $page_data['page_title'] = site_phrase('search_results');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function my_courses_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_my_courses_by_search_string($search_string)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }

    public function get_my_wishlists_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_courses_of_wishlists_by_search_string($search_string);
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }

    public function reload_my_wishlists() {
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }

    public function get_course_details() {
        $course_id = $this->input->post('course_id');
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        echo $course_details['title'];
    }

    public function rate_course() {
        $data['review'] = $this->input->post('review');
        $data['ratable_id'] = $this->input->post('course_id');
        $data['ratable_type'] = 'course';
        $data['rating'] = $this->input->post('starRating');
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['user_id'] = $this->session->userdata('user_id');
        $this->crud_model->rate($data);
    }

    

    public function terms_and_condition() {
        $page_data['page_name'] = 'terms_and_condition';
        $page_data['page_title'] = site_phrase('terms_and_condition');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function privacy_policy() {
        $page_data['page_name'] = 'privacy_policy';
        $page_data['page_title'] = site_phrase('privacy_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function cookie_policy() {
        $page_data['page_name'] = 'cookie_policy';
        $page_data['page_title'] = site_phrase('cookie_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    // Version 1.1
    public function dashboard($param1 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == "") {
            $page_data['type'] = 'active';
        }else {
            $page_data['type'] = $param1;
        }

        $page_data['page_name']  = 'instructor_dashboard';
        $page_data['page_title'] = site_phrase('instructor_dashboard');
        $page_data['user_id']    = $this->session->userdata('user_id');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function create_course() {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        $page_data['page_name'] = 'create_course';
        $page_data['page_title'] = site_phrase('create_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function edit_course($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param2 == "") {
            $page_data['type']   = 'edit_course';
        }else {
            $page_data['type']   = $param2;
        }
        $page_data['page_name']  = 'manage_course_details';
        $page_data['course_id']  = $param1;
        $page_data['page_title'] = site_phrase('edit_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function course_action($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == 'create') {
            if (isset($_POST['create_course'])) {
                $this->crud_model->add_course();
                redirect(site_url('home/create_course'), 'refresh');
            }else {
                $this->crud_model->add_course('save_to_draft');
                redirect(site_url('home/create_course'), 'refresh');
            }
        }elseif ($param1 == 'edit') {
            if (isset($_POST['publish'])) {
                $this->crud_model->update_course($param2, 'publish');
                redirect(site_url('home/dashboard'), 'refresh');
            }else {
                $this->crud_model->update_course($param2, 'save_to_draft');
                redirect(site_url('home/dashboard'), 'refresh');
            }
        }
    }


    public function sections($action = "", $course_id = "", $section_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($action == "add") {
            $this->crud_model->add_section($course_id);

        }elseif ($action == "edit") {
            $this->crud_model->edit_section($section_id);

        }elseif ($action == "delete") {
            $this->crud_model->delete_section($course_id, $section_id);
            $this->session->set_flashdata('flash_message', site_phrase('section_deleted'));
            redirect(site_url("home/edit_course/$course_id/manage_section"), 'refresh');

        }elseif ($action == "serialize_section") {
            $container = array();
            $serialization = json_decode($this->input->post('updatedSerialization'));
            foreach ($serialization as $key) {
                array_push($container, $key->id);
            }
            $json = json_encode($container);
            $this->crud_model->serialize_section($course_id, $json);
        }
        $page_data['course_id'] = $course_id;
        $page_data['course_details'] = $this->crud_model->get_course_by_id($course_id)->row_array();
        return $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_section', $page_data);
    }

    public function manage_lessons($action = "", $course_id = "", $lesson_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        if ($action == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', site_phrase('lesson_added'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', site_phrase('lesson_updated'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', site_phrase('lesson_deleted'));
        }
        redirect('home/edit_course/'.$course_id.'/manage_lesson');
    }

    public function lesson_editing_form($lesson_id = "", $course_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $page_data['type']      = 'manage_lesson';
        $page_data['course_id'] = $course_id;
        $page_data['lesson_id'] = $lesson_id;
        $page_data['page_name']  = 'lesson_edit';
        $page_data['page_title'] = site_phrase('update_lesson');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function download($filename = "") {
        $tmp           = explode('.', $filename);
        $fileExtension = strtolower(end($tmp));
        $yourFile = base_url().'uploads/lesson_files/'.$filename;
        $file = @fopen($yourFile, "rb");

        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
    }

    // Version 1.3 codes
    public function get_enrolled_to_free_course($course_id) {
        if ($this->session->userdata('user_login') == 1) {
            $this->crud_model->enrol_to_free_course($course_id, $this->session->userdata('user_id'));
            redirect(site_url('home/my_courses'), 'refresh');
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }

    // Version 1.4 codes
    

    public function submit_quiz($from = "") {
        $submitted_quiz_info = array();
        $container = array();
        $quiz_id = $this->input->post('lesson_id');
        $quiz_questions = $this->crud_model->get_quiz_questions($quiz_id)->result_array();
        $total_correct_answers = 0;
        foreach ($quiz_questions as $quiz_question) {
            $submitted_answer_status = 0;
            $correct_answers = json_decode($quiz_question['correct_answers']);
            $submitted_answers = array();
            foreach ($this->input->post($quiz_question['id']) as $each_submission) {
                if (isset($each_submission)) {
                    array_push($submitted_answers, $each_submission);
                }
            }
            sort($correct_answers);
            sort($submitted_answers);
            if ($correct_answers == $submitted_answers) {
                $submitted_answer_status = 1;
                $total_correct_answers++;
            }
            $container = array(
                "question_id" => $quiz_question['id'],
                'submitted_answer_status' => $submitted_answer_status,
                "submitted_answers" => json_encode($submitted_answers),
                "correct_answers"  => json_encode($correct_answers),
            );
            array_push($submitted_quiz_info, $container);
        }
        $page_data['submitted_quiz_info']   = $submitted_quiz_info;
        $page_data['total_correct_answers'] = $total_correct_answers;
        $page_data['total_questions'] = count($quiz_questions);
        if ($from == 'mobile') {
            $this->load->view('mobile/quiz_result', $page_data);
        }else{
            $this->load->view('lessons/quiz_result', $page_data);
        }
    }

    private function access_denied_courses($course_id){
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft' && $course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', site_phrase('you_do_not_have_permission_to_access_this_course'));
            redirect(site_url('home'), 'refresh');
        }elseif ($course_details['status'] == 'pending') {
            if ($course_details['user_id'] != $this->session->userdata('user_id') && $this->session->userdata('role_id') != 1) {
                $this->session->set_flashdata('error_message', site_phrase('you_do_not_have_permission_to_access_this_course'));
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function invoice($purchase_history_id = '') {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $purchase_history = $this->crud_model->get_payment_details_by_id($purchase_history_id);
        if ($purchase_history['user_id'] != $this->session->userdata('user_id')) {
            redirect('home', 'refresh');
        }
        $page_data['payment_info'] = $purchase_history;
        $page_data['page_name'] = 'invoice';
        $page_data['page_title'] = 'invoice';
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function page_not_found() {
        $page_data['page_name'] = '404';
        $page_data['page_title'] = site_phrase('404_page_not_found');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    // AJAX CALL FUNCTION FOR CHECKING COURSE PROGRESS
    function check_course_progress($course_id) {
        echo course_progress($course_id);
    }

    // This is the function for rendering quiz web view for mobile
    public function quiz_mobile_web_view($lesson_id = "") {
        $data['lesson_details'] = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
        $data['page_name'] = 'quiz';
        $this->load->view('mobile/index', $data);
    }


    // CHECK CUSTOM SESSION DATA
    public function session_data() {
        // SESSION DATA FOR CART
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        // SESSION DATA FOR FRONTEND LANGUAGE
        if (!$this->session->userdata('language')) {
            $this->session->set_userdata('language', get_settings('language'));
        }

    }

    // SETTING FRONTEND LANGUAGE
    public function site_language() {
        $selected_language = $this->input->post('language');
        $this->session->set_userdata('language', $selected_language);
        echo true;
    }


    //FOR MOBILE
    public function course_purchase($auth_token = '', $course_id  = ''){
        $this->load->model('jwt_model');
        if(empty($auth_token) || $auth_token == "null"){
            $page_data['cart_item'] = $course_id;
            $page_data['user_id'] = '';
            $page_data['is_login_now'] = 0;
            $page_data['enroll_type'] = null;
            $page_data['page_name'] = 'shopping_cart';
            $this->load->view('mobile/index', $page_data);
        }else{

            $logged_in_user_details = json_decode($this->jwt_model->token_data_get($auth_token), true);

            if ($logged_in_user_details['user_id'] > 0) {

                $credential = array('id' => $logged_in_user_details['user_id'], 'status' => 1, 'role_id' => 2);
                $query = $this->db->get_where('users', $credential);
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $page_data['cart_item'] = $course_id;
                    $page_data['user_id'] = $row->id;
                    $page_data['is_login_now'] = 1;
                    $page_data['enroll_type'] = null;
                    $page_data['page_name'] = 'shopping_cart';

                    $cart_item = array($course_id);
                    $this->session->set_userdata('cart_items', $cart_item);
                    $this->session->set_userdata('user_login', '1');
                    $this->session->set_userdata('user_id', $row->id);
                    $this->session->set_userdata('role_id', $row->role_id);
                    $this->session->set_userdata('role', get_user_role('user_role', $row->id));
                    $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
                    $this->load->view('mobile/index', $page_data);
                }
            }

        }
    }

    //FOR MOBILE
    public function get_enrolled_to_free_course_mobile($course_id ="", $user_id ="", $get_request = "") {
        if ($get_request == "true") {
            $this->crud_model->enrol_to_free_course_mobile($course_id, $user_id);
        }
    }

    //FOR MOBILE
    public function payment_success_mobile($course_id = "", $user_id = "", $enroll_type = ""){
        if($course_id > 0 && $user_id > 0):
            $page_data['cart_item'] = $course_id;
            $page_data['user_id'] = $user_id;
            $page_data['is_login_now'] = 1;
            $page_data['enroll_type'] = $enroll_type;
            $page_data['page_name'] = 'shopping_cart';

            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('role_id');
            $this->session->unset_userdata('role');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('user_login');
            $this->session->unset_userdata('cart_items');

            $this->load->view('mobile/index', $page_data);
        endif;
    }

    //FOR MOBILE
    public function payment_gateway_mobile($course_id = "", $user_id = ""){
        if($course_id > 0 && $user_id > 0):
            $page_data['page_name'] = 'payment_gateway';
            $this->load->view('mobile/index', $page_data);
        endif;
    }
    
    // product add to basket    
    function add_cart() {
      $product_id       = base64_decode($this->input->post('product_id'));
          $query= $this->db->get_where('products', ['product_id'  => $product_id]);
            $product_image= $this->db->get_where('product_image', ['product_id'  => $product_id])->row_array();
            $is_already_added=0;
            if ($this->session->userdata('user_login'))
                {
           $is_already_added = $this->db->get_where('cart', ['cid_product_id'=> $product_id,
                                                          'size' => $this->input->post('size') ,
                                                          'color' => $this->input->post('color'),
                                                          'userid' => $this->session->userdata('user_id')])->num_rows();
                }    
            if($is_already_added==0)
            {
            if ($query->num_rows() > 0)
                {
                $row = $query->row_array();
                $data  = array(
                    'id' => $product_id,
                    'name' => $row['product_name'] ,
                    'image' => $product_image['image'],
                    'slug' => $row['slug'] ,
                    'price' => $row['price'],
                    'offer_price' => $row['offer_price'],
                    'off' => $row['off'],
                    'qty' => $this->input->post('qty') ,
                    'options' => array('Size' => $this->input->post('size'), 'Color' => $this->input->post('color')),
                    'style' => $row['style'] ,
                    'category' => $row['category'] 
                    );


                $this->cart->insert($data);
                $totcart=count($this->cart->contents())-1;
                $carts=$this->cart->contents();
                foreach($carts as $cart_item)
                {
                    $row_id=$cart_item['rowid'];
                }
                if ($this->session->userdata('user_login'))
                {
                    $cartdata2 = array(
                        'cart_rowid'=>$row_id,
                        'userid' => $this->session->userdata('user_id') ,
                        'cid_product_id' => $product_id,
                        'cid_name' => $row['product_name'] ,
                        'image' => $product_image['image'],
                        'slug' => $row['slug'] ,
                        'price' => $row['price'],
                        'offer_price' => $row['offer_price'],
                        'off' => $row['off'],
                        'qty' => $this->input->post('qty') ,
                        'size' => $this->input->post('size') ,
                        'color' => $this->input->post('color') ,
                        'style' => $row['style'],
                        'category' => $row['category'] 
                        );
                    $this->db->insert('cart', $cartdata2);
                }
                $this->session->set_flashdata('success','Product Data Successfully Update In cart');  
                $message='Product Data Successfully Add In cart';
                $msg_type='success';
                $this->show_cart($message,$msg_type);
                }
            }
            else
            {
                $this->session->set_flashdata('error','Product Data already Add In cart');
                $message='Product Data already Add In cart';
                $msg_type='error';
                //$this->show_cart($message,$msg_type);
            }
    }
    
    public function show_cart($message='',$msg_type='')
        {
            

        if (empty($this->cart->contents()))
            {
            $data['counts_cart']        = '0';
            $data['output'] = '<center><img src="' . base_url() . 'assets/backend/images/empty_cart.png" alt="product" width="200"></center>';
            }
        else
            {
            $no     = 0;
            $cart_total=0;
            $output='';
            foreach ($this->cart->contents() as $items)
                {
                $no++;    
            
            
            $output.='<div class="product product-cart">
                                        <div class="product-detail">
                                            <a href="'.base_url().'product/'.$items["slug"].'" class="product-name">'.$items["name"].'</a>
                                            <div class="price-box">
                                                <span class="product-quantity">'.$items["qty"].'</span>
                                                <span class="product-price">Rs.';
                                                if($items["offer_price"]!='')
                                                {
                                                  $output.= $items["qty"]*$items["offer_price"]; 
                                                  $cart_total+=$items["qty"]*$items["offer_price"];
                                                  
                                                }
                                                else
                                                {
                                                   $output.= $items["qty"]*$items["price"]; 
                                                   $cart_total+=$items["qty"]*$items["price"];
                                                }
                                                $output.='</span>
                                            </div>
                                        </div>
                                        <figure class="product-media">
                                            <a href="'.base_url().'product/'.$items["slug"].'">
                                                <img src="'.base_url().$items["image"].'" alt="product" height="84" width="94">
                                            </a>
                                        </figure>
                                        <button class="btn btn-link btn-close" aria-label="Close" rowid="'.$items['rowid'].'" id="'.$items['id'].'">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>';
                }         
            $data['message']=$message; 
            $data['msg_type']=$msg_type; 
            $data['output'] = $output;
            $data['counts_cart'] = count($this->cart->contents());
            $data['cart_total'] = 'Rs.'.$cart_total;
            
            }
        //  $data['cart_details']=$output;
        echo json_encode($data);
        }
        public function delete_cart()
        {
        $rowid = $this->input->post('rowid');
        if ($rowid === "all")
            {
            // Destroy data which store in session.
            $this->cart->destroy();
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->delete('cart');
            }
        else
            {
            // Destroy selected rowid in session.
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            // Update cart data, after cancel.
            $this->cart->update($data);
            $this->db->where('cart_rowid', $rowid);
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->where('cid_product_id', $this->input->post('product_id'));
            $this->db->delete('cart');
            }
                $message='Cart Item Successfully Delete.';
                $msg_type='message';
                $this->show_cart($message,$msg_type);
        }
     function remove($rowid, $productid = '')
        {
        // Check rowid value.
        if ($rowid === "all")
            {
            // Destroy data which store in session.
            $this->cart->destroy();
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->delete('cart');
            $this->session->set_flashdata('success', 'Hey! Successfully cart has been cleared..');
            }
        else
            {
            // Destroy selected rowid in session.
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            // Update cart data, after cancel.
            $this->cart->update($data);

            if (!empty($productid) && !empty($this->session->userdata('user_id')))
                {
                $this->db->where('userid', $this->session->userdata('user_id'));
                $this->db->where('id', $productid);
                $this->db->delete('cart');
                }
            $this->session->set_flashdata('success', 'Hey! Successfully removed item from the cart..');
            }

        redirect('cart');
        }    
    public function view_cart()
    {
        $page_data['page_name'] = "cart";
        $page_data['page_title'] = site_phrase('Cart');
        if($this->session->userdata('user_id'))
        {
        $result['cart_detail'] = $this->Home_model->cart_detail();
        }
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    
    public function update_cart()
    {
    $cart_row_id = $this->input->post('cart_row_id');
    $qty = $this->input->post('qty');

            $data      = array(
                'rowid' => $cart_row_id,
                'qty' => $qty
            );

            $this->cart->update($data);
            $output='';
                $output.='<center><h1 class="cart-heading">SHOPPING CART</h1> </center>
                            
                            <div class="table-content table-responsive">
                                    <table>
                                        <thead>
                                            <tr style="text-align: left;">
                                               <!-- <th class="product-name">
												<label class="checkbox_container">All
												  <input type="checkbox"  name="checkAll" id="checkAll">
												  <span class="checkmark"></span>
												</label>
                                                   </th>-->
                                                <th class="product-name"></th>
                                                <th class="product-name switchable" colspan="1">Item</th>
                                                <th class="product-price master_hider">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Total</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>';
                        
                        $total_amount=0;
                        foreach ($this->cart->contents() as $items)
                        {
                        
                                            $output.='<tr class="row_bottom">
                                              
                                             <td style="width: 12%;">
                                                 <img src="'.base_url().$items['image'].'" alt="" width="80" height="80">
                                             </td>
                                                 <td class="product-name switchable" colspan="1">
												<a href="#">
												<div class="row">
												
													<div class="col-sm-12 font_changer" style="font-size: 15px;">
													   <span>'.$items['name'].'</span>
													</div>
													</div>
												</a>
												</td>
                                                <td class="product-price master_hider"><span class="amount">Rs.';
                                                
                                                if($items['offer_price']!='')
                                                {
                                                    $output.=$items['offer_price'];
                                                }
                                                else
                                                {
                                                    $output.=$items['price'];
                                                }
                                                $output.='</span></td>
                                                <td class="product-quantity ">
                                                    <div class="row">
                                                        <div class="col-12 quantity master_qty">
                                                <div class="quantity-nav"><div class="quantity-button quantity-down">-</div></div><input type="number" style="background:initial;border-style: initial;" class="'.$items['rowid'].' qty_manager" name="'.$items['rowid'].'" value="'.$items['qty'].'" min="1" max="50"  maxlength="3"  onkeyup="return false" onchange="checking_max_qty(';
                                                $output.="'".$items['rowid']."'";
                                                $output.=')" readonly=""><div class="quantity-nav"><div class="quantity-button quantity-up">+</div></div>
                                               
                                                        </div>
                                                        <div class="col-12">
                                                  <a style="padding: 0px 18px;text-decoration: underline;" href="">Remove <!--<i  class="ti-trash fontsize24 hvr-buzz-out"></i>--></a>

                                                        </div>
                                                    </div>
                                   
                                                </td>
                                        <td class="product-subtotal product_subtotal_'.$items['rowid'].'">Rs.';
                                            
                                                if($items['offer_price']!='')
                                                {
                                                    $output.= floatval($items['qty'])*floatval($items['offer_price']);
                                                    $total_amount+=floatval($items['qty'])*floatval($items['offer_price']);
                                                }
                                                else
                                                {
                                                    $output.= floatval($items['qty'])*floatval($items['price']);
                                                     $total_amount+=floatval($items['qty'])*floatval($items['price']);
                                                }
                                                
                                        $output.='</td>
                                                
                                            </tr>';
                        
                        }
                        
$output.='<tr class="row_bottom">
    <td colspan="1" class="product-subtotal" style="text-align:right;">  </td>
    <td colspan="1" class="product-subtotal switchable" style="text-align:right;">  </td>
    <td colspan="1" class="product-subtotal master_hider" style="text-align:right;">  </td>
     <td colspan="1" class="product-subtotal-qty" style="text-align:left;padding:8px 15px;font-weight:900;">1</td>
    <td colspan="2" class="product-subtotal" style="padding:8px 15px;"> <strong id="subtotal_accumulator">Rs.'.$total_amount.'</strong> </td>
</tr>
                                        </tbody>
                                    </table>
                                </div>';
								
            $data['output'] = $output;
            $data['counts_cart'] = count($this->cart->contents());
            $data['cart_total'] = 'Rs.'.$total_amount;
            
          
        echo json_encode($data);
          
    }        

    public function checkout()
    {
        if(!$this->session->userdata('user_login'))
        {
            redirect(site_url('login'), 'refresh');
        }
        elseif(empty($this->cart->contents()))
        {
           redirect(site_url('cart'), 'refresh'); 
        }
        else
        {
        $this->add_cart_table();    
       $page_data['page_name'] = "checkout";
        $page_data['page_title'] = site_phrase('Checkout');
        $page_data['cart_detail'] = $this->Home_model->cart_detail();
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data); 
        }
    }
    
    public function add_cart_table()
    {
        
        if (!empty($this->cart->contents()))
        {
       foreach ($this->cart->contents() as $items)
        {
           
            $is_already_added = $this->db->get_where('cart', ['cid_product_id'=> $items['id'],
                                                          'size' => $items['options']['Size'] ,
                                                          'color' => $items['options']['Color'],
                                                          'cart_rowid' => $items['rowid'],
                                                          'userid' => $this->session->userdata('user_id')])->num_rows();
                if($is_already_added==0)
                {
                    $cartdata2 = array(
                        'cart_rowid'=>$items['rowid'],
                        'userid' => $this->session->userdata('user_id') ,
                        'cid_product_id' => $items['id'],
                        'cid_name' => $items['name'],
                        'image' => $items['image'],
                        'slug' => $items['slug'],
                        'price' => $items['price'],
                        'offer_price' => $items['offer_price'],
                        'off' => $items['off'],
                        'qty' =>$items['qty'],
                        'size' => $items['options']['Size'],
                        'color' => $items['options']['Color'],
                        'style' => $items['style'],
                        'category' => $items['category'] 
                        );
                    $this->db->insert('cart', $cartdata2); 
                } 
                else
                {
                 $info  = array(
                        'qty' => $items['qty'],
                    );
                    $this->db->where('userid', $this->session->userdata('user_id'));
                    $this->db->where('cart_rowid', $items['rowid']);
                    $this->db->update('cart', $info);
                       
                }
                
           
                
        }
         }
         $cart_rowids=array();
         $carts=$this->cart->contents();
                foreach($carts as $cart_item)
                {
                    $cart_rowids[]=$cart_item['rowid'];
                }    
             
        $cart_data = $this->db->get_where('cart', ['userid' => $this->session->userdata('user_id')])->result_array(); 
            foreach($cart_data as $row)
            {
                if (!in_array($row['cart_rowid'], $cart_rowids)) 
                {
                $data  = array(
                            'id' => $row['cid_product_id'],
                            'name' => $row['cid_name'] ,
                            'image' => $row['image'],
                            'slug' => $row['slug'] ,
                            'price' => $row['price'],
                            'offer_price' => $row['offer_price'],
                            'off' => $row['off'],
                            'qty' => $row['qty'] ,
                            'options' => array('Size' => $row['size'], 'Color' => $row['color']),
                            'style' => $row['style'] ,
                            'category' => $row['category'] 
                            );


                $this->cart->insert($data);   
                }
                
            } 
    }
    
    public function insert_order_data()
    {

        if($this->session->userdata('orderid'))
        {
            $this->session->unset_userdata('orderid');
        }
        
        
               // $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->form_validation->set_rules('bill_fname', 'First name', 'required');
                $this->form_validation->set_rules('bill_lname', 'Last Name', 'required');
                $this->form_validation->set_rules('bill_email', 'Email', 'required');
                $this->form_validation->set_rules('bill_street_line_1', 'Address', 'required');
                $this->form_validation->set_rules('bill_town', 'city', 'required');
                $this->form_validation->set_rules('bill_state', 'State', 'required');
                $this->form_validation->set_rules('bill_country', 'Country', 'required');
                $this->form_validation->set_rules('bill_postcode', 'Zipcode', 'required');
                $this->form_validation->set_rules('bill_phone', 'Phone', 'required');
                if ($this->input->post('ship_to') && $this->input->post('ship_to') == 'other_shipment')
                {
                $this->form_validation->set_rules('ship_fname', 'Shipment First name', 'required');
                $this->form_validation->set_rules('ship_lname', 'Shipment Last Name', 'required');
                $this->form_validation->set_rules('ship_email', 'Shipment Email', 'required');
                $this->form_validation->set_rules('ship_add_line_1', 'Shipment Address', 'required');
                $this->form_validation->set_rules('ship_city', 'Shipment city', 'required');
                $this->form_validation->set_rules('ship_state', 'Shipment State', 'required');
                $this->form_validation->set_rules('ship_country', 'Shipment Country', 'required');
                $this->form_validation->set_rules('ship_zip', 'Shipment Zipcode', 'required');
                }
                $this->form_validation->set_rules('cart_t_c', 'Check terms and conditions', 'required');
                if (!$this->form_validation->run()) {
            $json = array(
                'f_name' => form_error('bill_fname', '<p class="mt-3 text-danger">', '</p>'),
                'l_name' => form_error('bill_lname', '<p class="mt-3 text-danger">', '</p>'),
                'email' => form_error('bill_email', '<p class="mt-3 text-danger">', '</p>'),
                'bill_street_line_1' => form_error('bill_street_line_1', '<p class="mt-3 text-danger">', '</p>'),
                'bill_town' => form_error('bill_town', '<p class="mt-3 text-danger">', '</p>'),
                'bill_state' => form_error('bill_state', '<p class="mt-3 text-danger">', '</p>'),
                'country' => form_error('bill_country', '<p class="mt-3 text-danger">', '</p>'),
                'bill_postcode' => form_error('bill_postcode', '<p class="mt-3 text-danger">', '</p>'),
                'bill_phone' => form_error('bill_phone', '<p class="mt-3 text-danger">', '</p>'),
                'f_name_2' => form_error('ship_fname', '<p class="mt-3 text-danger">', '</p>'),
                'l_name_2' => form_error('ship_lname', '<p class="mt-3 text-danger">', '</p>'),
                'email_2' => form_error('ship_email', '<p class="mt-3 text-danger">', '</p>'),
                'shipment_street_1' => form_error('ship_add_line_1', '<p class="mt-3 text-danger">', '</p>'),
                'city_2' => form_error('ship_city', '<p class="mt-3 text-danger">', '</p>'),
                'country_2' => form_error('ship_country', '<p class="mt-3 text-danger">', '</p>'),
                'state_2' => form_error('ship_state', '<p class="mt-3 text-danger">', '</p>'),
                'postcode_2' => form_error('ship_postcode', '<p class="mt-3 text-danger">', '</p>'),
                'cart_t_c' => form_error('cart_t_c', '<p class="mt-3 text-danger">', '</p>'),
            );
            $datashow['error'] = "yes";
            $datashow['error_output'] = $json;
        echo json_encode($datashow);
        return;
        }

        
        $totamount=0;
        $cart_data = $this->db->get_where('cart', ['userid' => $this->session->userdata('user_id')])->result_array(); 
            foreach($cart_data as $row)
            {
                if($row['offer_price']!='')
                {
                $totamount+=$row['qty']*$row['offer_price'];
                }
                else
                {
                  $totamount+=$row['qty']*$row['price'];  
                }
            }
                  if ($this->input->post('ship_to') && $this->input->post('ship_to') == 'other_shipment')
                {
                    $shipment_fname              = $this->input->post('ship_fname');
                        $shipment_lname              = $this->input->post('ship_lname');
                        $shipment_email              = $this->input->post('ship_email');
                        $shipment_add_1              = $this->input->post('ship_add_line_1');
                        $shipment_add_2              = $this->input->post('ship_add_line_2');
                        $shipment_city              = $this->input->post('ship_city');
                        $shipment_state              = $this->input->post('ship_state');
                        $shipment_country              = $this->input->post('ship_country');
                        $shipment_postcode              = $this->input->post('ship_postcode');
                }
                else
                {
                    $shipment_fname              = $this->input->post('bill_fname');
                        $shipment_lname              = $this->input->post('bill_lname');
                        $shipment_email              = $this->input->post('bill_email');
                        $shipment_add_1              = $this->input->post('bill_street_line_1');
                        $shipment_add_2              = $this->input->post('bill_street_line_2');
                        $shipment_city              = $this->input->post('bill_town');
                        $shipment_state              = $this->input->post('bill_state');
                        $shipment_country              = $this->input->post('bill_country');
                        $shipment_postcode              = $this->input->post('bill_postcode');
                }
         $order_detail = array(
                        'order_by_user'              => $this->session->userdata('user_id'),
                        'order_ship_to_other_address'              => $this->input->post('ship_to'),
                        'order_net_amount'              => $totamount,
                        'billing_fname'              => ucfirst($this->input->post('bill_fname')) ,
                        'billing_lname'              => ucfirst($this->input->post('bill_lname')) ,
                        'billing_email'              => $this->input->post('bill_email'),
                        'billing_address_line_1'              => $this->input->post('bill_street_line_1'),
                        'billing_address_line_2'              => $this->input->post('bill_street_line_2'),
                        'billing_city'              => ucfirst($this->input->post('bill_town')) ,
                        'billing_state'              => ucfirst($this->input->post('bill_state')) ,
                        'billing_country'              => $this->input->post('bill_country'),
                        'billing_postcode'              => $this->input->post('bill_postcode'),
                        'billing_phone'             => $this->input->post('bill_phone'),
                        'shipment_fname'              => $shipment_fname,
                        'shipment_lname'              => $shipment_lname,
                        'shipment_email'              => $shipment_email,
                        'shipment_add_1'              => $shipment_add_1,
                        'shipment_add_2'              => $shipment_add_2,
                        'shipment_city'              => $shipment_city,
                        'shipment_state'              => $shipment_state,
                        'shipment_country'              => $shipment_country,
                        'shipment_postcode'              => $shipment_postcode,
                        'order_note'              => $this->input->post('ship_ordernote'),
                        'order_date'              => strtotime(date('d-m-Y h:i:sa')),
                    );   
              
                    $this->db->insert('master_orders',$order_detail);
                   $orderid= $this->db->insert_id();
                       $cart_data = $this->db->get_where('cart', ['userid' => $this->session->userdata('user_id')])->result_array(); 
            foreach($cart_data as $row)
            {
                
                $data  = array(
                            'order_id' => $orderid,
                            'userid' => $this->session->userdata('user_id'),    
                            'product_id' => $row['cid_product_id'],
                            'name' => $row['cid_name'] ,
                            'image' => $row['image'],
                            'slug' => $row['slug'] ,
                            'price' => $row['price'],
                            'offer_price' => $row['offer_price'],
                            'off' => $row['off'],
                            'qty' => $row['qty'] ,
                            'size' => $row['size'],
                            'color' => $row['color'],
                            'style' => $row['style'] ,
                            'category' => $row['category'] 
                            );
                    $this->db->insert('master_orders_item',$data);
                $this->cart->insert($data);   
                
                
            } 
        if($this->input->post('paymentmethod')=='cash')
        {
            $this->db->where('order_pid' , $orderid);
            $this->db->where('data_store' , 'temp');
            $this->db->where('order_by_user' , $this->session->userdata('user_id'));
            $this->db->update('master_orders' , array('data_store' => 'full','payment_mode' => 'cash','payment_status' => 'paid','payment_time' => strtotime(date('d-m-Y h:i:sa')))); 
            $this->db->where('userid' , $this->session->userdata('user_id'));
            $this->db->where('order_id' , $orderid);
            $this->db->where('data_store' , 'temp');
            $this->db->update('master_orders_item' , array('data_store' => 'full')); 
            $this->cart->destroy();
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->delete('cart');
            $this->db->where('order_by_user', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders');
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders_item');
            $this->ordermail($orderid);
        $datashow['paymentmethod'] = $this->input->post('paymentmethod');
        echo json_encode($datashow);    
            //redirect(site_url('my-account'), 'refresh');
        }
        else
        {
            $this->ordermail($orderid);
            $this->session->set_userdata('orderid',$orderid);
            $datashow['paymentmethod'] = $this->input->post('paymentmethod');
        echo json_encode($datashow);
        }
        
    }
    // main function for payment start
public function payment()
{
if($this->session->userdata('orderid'))
{
	$this->load->library('cashier');
	$this->cashier->driver('razorpay');
	$temp_order = $this->db->get_where('master_orders', ['order_pid' => $this->session->userdata('orderid'),
	                                                'order_by_user' => $this->session->userdata('user_id'),
	                                                  'data_store' => 'temp'])->row_array();
                                            
	$result = $this->cashier->pre_payment([
	             'order_id' => $temp_order['order_pid'],
		'order_amount' => $temp_order['order_net_amount'],
		'order_currency' => 'INR',
		'customer_name' => $temp_order['billing_fname'].' '.$temp_order['billing_fname'],
		'customer_email' => $temp_order['billing_email'],
		'customer_contact' => $temp_order['billing_phone'],
		'order_note' => $temp_order['order_note']
	    ]);

	if( ! $result ){
		echo $this->cashier->message();
	}
	if($this->session->userdata('orderid'))
        {
            $this->session->unset_userdata('orderid');
        }
}
else
{
    if($this->session->userdata('orderid'))
        {
            $this->session->unset_userdata('orderid');
        }
    redirect(site_url(), 'refresh');
}
}

// payment gateway will redirect you here
public function after_payment(){
    if($this->session->userdata('orderid'))
        {
            $this->session->unset_userdata('orderid');
        }
	$this->load->library('cashier');

	$result = $this->cashier->post_payment(100, 'INR');
	
	if( $result ){
		// confirm order and save reference_id in database
		if($result['tx_status']=='paid')
		{
		   $this->db->where('order_by_user' , $this->session->userdata('user_id'));
		    $this->db->where('order_pid' , $result['order_id']);
            $this->db->where('data_store' , 'temp');
            $this->db->update('master_orders' , array('data_store' => 'full','txn_id' => $result['reference_id'],'payment_mode' => $result['payment_mode'],'payment_status' => $result['tx_status'],'payment_time' => $result['tx_time'])); 
            
            $this->db->where('userid' , $this->session->userdata('user_id'));
            $this->db->where('order_id' , $result['order_id']);
            $this->db->where('data_store' , 'temp');
            $this->db->update('master_orders_item' , array('data_store' => 'full')); 
            $this->cart->destroy();
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->delete('cart');
            $this->db->where('order_by_user', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders');
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders_item');
            redirect(site_url('payment-success'), 'refresh'); 
		}
	} else {
	    $this->db->where('order_by_user', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders');
            $this->db->where('userid', $this->session->userdata('user_id'));
            $this->db->where('data_store', 'temp');
            $this->db->delete('master_orders_item');
		echo $this->cashier->message();
	}
}

// payment gateway will notify you here
public function payment_webhook(){
	$this->load->library('cashier');

	$result = $this->cashier->webhook();
	if( $result ){
		// confirm order and save reference_id in database if not done already
		print_r($result);
	}

	http_response_code(200);
} 

public function payment_success()
{
        $page_data['page_name'] = "payment_success";
        $page_data['page_title'] = site_phrase('Payment Success');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
        
        
}

public function account_update_creds()
{
    $user_id              = $this->session->userdata('user_id');
        $acc_current_password = sha1($this->input->post('acc_current_password'));
        $acc_new_password     = sha1($this->input->post('acc_new_password'));
        $acc_confirm_password = sha1($this->input->post('acc_confirm_password'));

        if (!empty($acc_current_password))
            {

            $this->form_validation->set_rules('acc_current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('acc_new_password', 'Password', 'required');
            $this->form_validation->set_rules('acc_confirm_password', 'Password Confirmation', 'required|matches[acc_new_password]');
            if ($this->form_validation->run() == false)
                {
                $data = array(
                    'status' => '0',
                    'msg' => validation_errors()
                );

                }
            else
                {
                
                $user_data = $this->db->get_where('users', array(
                    'id'=> $user_id
                ))->row_array();
                $old_password       = $user_data['password'];
                if ($acc_current_password != $old_password)
                    {
                    $data = array(
                        'status' => '0',
                        'msg'   => sha1($old_password)
                    );
                    }
                else
                    {
                    $info  = array(
                        'password' => $acc_confirm_password ,
                    );
                    $this->db->where('id', $user_id);
                    $this->db->update('users', $info);
                    
                        $data               = array(
                            'status'=> '1',
                            'msg' => 'Successfully Updated Credentials'
                        );
                        
                    
                    }
                }

            }
        else
            {
            $data               = array(
                'status' => '0',
                'msg' => "Provide Your Old Password"
            );
            }

        echo json_encode($data);

}

public function update_billing_address()
{
  $user_id            = $this->session->userdata('user_id');
        $billing_first_name = $this->input->post('bill_first_name');
        $billing_last_name  = $this->input->post('bill_last_name');
        $billing_phone      = $this->input->post('bill_tel');
        $billing_address_1  = $this->input->post('bill_address1');
        $billing_address_2  = $this->input->post('bill_address2');
        $billing_city       = $this->input->post('bill_city');
        $billing_state      = $this->input->post('bill_state');
        $billing_country    = $this->input->post('bill_country');
        $billing_postcode   = $this->input->post('bill_zipcode');
        $this->form_validation->set_rules('bill_first_name', 'First name', 'required');
        $this->form_validation->set_rules('bill_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('bill_tel', 'Phone Number', 'required');
        

        if ($this->form_validation->run() == false)
            {
            $data          = array(
                'status'=> '0',
                'msg' => 'Please Fill All The Mandatory Fields'
            );

            }
        else
            {
            $info          = array(
                'first_name'               => $billing_first_name,
                'last_name'               => $billing_last_name,
                'phone'               => $billing_phone,
                'address_line_1'               => $billing_address_1,
                'address_line_2'               => $billing_address_2,
                'city'               => $billing_city,
                'state'               => $billing_state,
                'country'               => $billing_country,
                'postcode'               => $billing_postcode,
            );

        $this->db->where('id', $user_id);
        $this->db->update('users', $info);
        
                $data          = array(
                    'status'=> '1',
                    'msg'  => 'Successfully Updated Billing Information'
                );
                
            

            }
        echo json_encode($data);

        }


public function my_account()
{
        if(!$this->session->userdata('user_id'))
        {
            redirect(site_url(), 'refresh');
        }
        else
        {
           $userid= $this->session->userdata('user_id');
        }
        $page_data['page_name'] = "my_account";
        $page_data['page_title'] = site_phrase('My Account');
        $page_data['profile'] = $this->Home_model->profile_data($userid);
        $page_data['orders'] = $this->Home_model->orders_data($userid);
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
}
 
public function my_orders()
{
        if(!$this->session->userdata('user_id'))
        {
            redirect(site_url(), 'refresh');
        }
        else
        {
           $userid= $this->session->userdata('user_id');
        }
        $page_data['page_name'] = "orders";
        $page_data['page_title'] = site_phrase('My Orders');
        $page_data['profile'] = $this->Home_model->profile_data($userid);
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
}

public function get_orders()
{
    if(!$this->session->userdata('user_id'))
        {
            redirect(site_url(), 'refresh');
        }
        else
        {
           $userid= $this->session->userdata('user_id');
        }
        $search='';
        $start=$_POST['start'];
        $limit=$_POST['length'];
        $min=$_POST['min'];
        $max=$_POST['max'];
    $get_data = $this->Home_model->orders_data($userid,$start,$limit,$search,$min,$max);
$tot_record = $this->Home_model->orders_data_tot($userid,$search,$min,$max);
$data=array();  
        if($get_data)
        {
        $i = $_POST['start'];
        foreach($get_data as $row){
            $i++;
            $created = $time = date("m/d/Y h:i:s",$row['order_date']);
            $action='<button class="button hvr-float-shadow" onclick="view_order_info('.$row['order_pid'].')">View</button>';
            $data[] = array($i,$created, $row['order_pid'], $row['order_net_amount'], $row['order_status'],$action);
        }
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $tot_record,
            "recordsFiltered" => $tot_record,
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
}
public function show_order_detail($order_id)
{
    $order_row    = $this->db->get_where('master_orders', array(
            'order_pid'              => $order_id
        ))->row();

        $head_conetnt = '';
        $body_content = '';

        $head_conetnt .= 'Order No- #' . $order_id;

        $body_content .= '<div class="container">
                        <div class="card">
                        <div class="card-header">
                        Invoice No.
                        <strong>' . $order_row->order_pid . '</strong> 
                          <span style="float: right;"> <strong>Status:</strong> ' . $order_row->order_status . '</span>
                        
                        </div>
                        <div class="card-body">
                        <div class="row mb-4">';

        $fullname     = "";
        $fullname .= $order_row->billing_fname;
        $fullname .= $order_row->billing_lname;
        $Baddress1     = $order_row->billing_address_line_1;
        $Baddress2     = $order_row->billing_address_line_2;
        $Bcity         = $order_row->billing_city;
        $Bstate        = $order_row->billing_state;
        $Bcountry      = $order_row->billing_country;
        $Bpostcode     = $order_row->billing_postcode;
        $Bemail        = $order_row->billing_email;
        $Bphone_number = $order_row->billing_phone;

        $body_content .= '<div class="col-sm-6">
                        <h6 class="mb-3">Billing Address:</h6>
                        <div>
                        <strong>' . $fullname . '</strong>
                        </div>
                        <div>' . $Baddress1 . '</div>';
        if (!empty($Baddress2))
            {
            $body_content .= '<div>' . $Baddress2 . '</div>';
            }
        $body_content .= '<div>' . $Bcity . ', ' . $Bstate . ', ' . $Bcountry . ', ' . $Bpostcode . '</div>
                        <div>Email:' . $Bemail . '</div>
                        <div>Phone: ' . $Bphone_number . '</div>
                        </div>
                        
                        <div class="col-sm-6">
                        <h6 class="mb-3">Delivery Address:</h6>';

       
            $body_content .= '<div>
                        <strong>' . $order_row->shipment_fname . " " . $order_row->shipment_lname . '</strong>
                        </div>
                        <div>' . $order_row->shipment_add_1 . '</div>';
            if (!empty($order_row->shipment_add_2))
                {
                $body_content .= '<div>' . $order_row->shipment_add_2 . '</div>';
                }
            $body_content .= '<div>' . $order_row->shipment_city . ', ' . $order_row->shipment_state . ', ' . $order_row->shipment_country . ', ' . $order_row->shipment_postcode . '</div>
                        <div>Email: ' . $order_row->shipment_email . '</div>';

            

        $body_content .= '</div></div>
                    <div class="table-responsive-sm">
                    <table class="table table-striped">
                    <thead>
                    <tr>
                    <th class="center">#</th>
                    <th>Item</th>
                    <th class="right">Unit Cost</th>
                      <th class="center">Qty</th>
                    <th class="right">Total</th>
                    </tr>
                    </thead>
                    <tbody>';

        $this->db->select('*');
        $this->db->from('master_orders_item');
        $this->db->where('order_id', $order_id);
        $this->db->where('data_store', 'full');
        $query     = $this->db->get();
        $item_rows = $query->result();
        $k         = 1;
        foreach ($item_rows as $item_row)
            {
            $body_content .= '<tr>
                <td class="center">' . $k . '</td>
                <td class="left strong">' . $item_row->name . '<br>Size : '.$item_row->size.'<br>Color : '.$item_row->color.' </td>
                <td class="right">Rs.';
                if($item_row->offer_price!='')
                              {
                                $body_content.=$item_row->offer_price;  
                              }
                              else
                              {
                                 $body_content.=$item_row->price; 
                              }
                $body_content.='</td>
                <td class="center">' . $item_row->qty . '</td>
                <td class="right">Rs.';
                if($item_row->offer_price!='')
                              {
                                $body_content.=$item_row->qty.$item_row->offer_price;  
                              }
                              else
                              {
                                 $body_content.=$item_row->qty.$item_row->price; 
                              }
                $body_content.='</td>
                </tr>';

            $k++;
            }

        $body_content .= '</tbody>
                    </table>
                    </div>
                    <div class="row">
                    <div class="col-lg-8 col-sm-7">
                    
                    </div>
                    
                    <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                    <tbody>
                    <tr>
                    <td class="left">
                    <strong>Subtotal</strong>
                    </td>
                    <td class="right">Rs.' . $order_row->order_net_amount . '</td>
                    </tr>';
       
        $body_content .= '<tr>
                <td class="left">
                <strong>Total</strong>
                </td>
                <td class="right">
                <strong>Rs.' . $order_row->order_net_amount . '</strong>
                </td>
                </tr>
                </tbody>
                </table>
                </div>
                </div></div></div></div>';

        $output = array(
            'header_content' => $head_conetnt,
            'body_content' => $body_content,

        );
        echo json_encode($output);

}

        public function Add_to_wishlist()
        {
            $data=array();
            if($this->session->userdata('user_id'))
            {
            $pid=$this->input->post('pid');    
            $uid=$this->session->userdata('user_id');    
            $data_found = $this->db->get_where('wishlist', ['wishlist_product_id' => $pid , 'wishlist_user_id' => $uid])->num_rows();
            if($data_found==0)
            {
         $data_arr = array(
                'wishlist_user_id' => $uid,
                'wishlist_product_id' => $pid,
                'wishlist_product_added_on' => date('d-m-Y')
            );
            $this->db->insert('wishlist', $data_arr);
            $data['count']= $this->db->get_where('wishlist', ['wishlist_user_id' => $uid])->num_rows();

            $data['success'] = "Successfully Added To Wishlist";
            }
            else
            {
            $this->db->where('wishlist_user_id', $uid);
            $this->db->where('wishlist_product_id', $pid);
            $this->db->delete('wishlist');
            $data['error'] = "Successfully Removed From Wishlist";
            $data['count']= $this->db->get_where('wishlist', ['wishlist_user_id' => $uid])->num_rows();
            }
            }
            else
            {
             $data['error']        = "Please Login Before Add Wishlist!";
            }
            
        echo json_encode($data);
        return;
        }
        public function wishlist()
        {
            if(!$this->session->userdata('user_id'))
            {
                redirect(site_url(), 'refresh');
            }
            else
            {
                $userid= $this->session->userdata('user_id');
                $page_data['page_name'] = "wishlist";
                $page_data['page_title'] = site_phrase('Wishlist');
                $page_data['wishlists'] = $this->Home_model->wishlist($userid);
                $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
            }
        }
        public function pages($page_slug)
        {
                $page_datas = $this->Home_model->pages($page_slug);
                if(!$page_datas)
                {
                  redirect(site_url(), 'refresh');  
                }
                else
                {
                $page_data['page_name'] = "page_show";
                $page_data['page_title'] = site_phrase($page_datas['title']);
                $page_data['page_details'] = $page_datas;
                $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
                }
        }
        public function faq()
        {
               
                $page_data['page_name'] = "faq";
                $page_data['page_title'] = site_phrase('FAQs');
                $page_data['faq_details'] = $this->Home_model->faqs();
                $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
        }
        public function ordermail($orderid)
        {
            $order_row    = $this->db->get_where('master_orders', array(
            'order_pid'              => $orderid
        ))->row();

        $head_conetnt = '';
        $body_content = '';
        $body_content.='<body
    class="clean-body"
    style="
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      background-color: #f2fafc;
    "
  >
    
    <table
      bgcolor="#f2fafc"
      cellpadding="0"
      cellspacing="0"
      class="nl-container"
      role="presentation"
      style="
        table-layout: fixed;
        vertical-align: top;
        min-width: 320px;
        border-spacing: 0;
        border-collapse: collapse;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        background-color: #f2fafc;
        width: 100%;
      "
      valign="top"
      width="100%"
    >
      <tbody>
        <tr style="vertical-align: top" valign="top">
          <td style="word-break: break-word; vertical-align: top" valign="top">
            
            <div style="background-color: #fb3c2d">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="01"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 0px solid transparent;
                                    height: 01px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="1"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                   <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="5"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 0px solid transparent;
                                    height: 5px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="5"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        
                      </div>
                     
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            
                  </div>
                  
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                > 
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    ">
                    <div class="col_cont" style="width: 100% !important">
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        
                        <div
                          align="center"
                          class="img-container center fixedwidth"
                          style="padding-right: 0px; padding-left: 0px"
                        >
                          <img
                            align="center"
                            alt="Sports Wear"
                            border="0"
                            class="center fixedwidth"
                            src="'.base_url().'assets/frontend/images/imgpsh_fullsize_anim.png"
                            style="
                              text-decoration: none;
                              -ms-interpolation-mode: bicubic;
                              height: auto;
                              border: 0;
                              width: 100%;
                              max-width: 322px;
                              display: block;
                            "
                            title="Sports Wear"
                            width="272"
                          />
                          
                        </div>
                       
                        <div
                          style="
                            color: #44464a;
                            font-family:  Georgia, serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              font-family:  Georgia, serif;
                              color: #44464a;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 30px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: center;
                                font-family:  Georgia, serif;
                                mso-line-height-alt: 36px;
                                margin: 0;
                              "
                            >
                              <span style="font-size: 30px"
                                >Thank you for shopping with us!</span
                              >
                            </p>
                          </div>
                        </div>
                       
                        <div
                          align="center"
                          class="img-container center fixedwidth"
                          style="padding-right: 25px; padding-left: 25px"
                        >

                          <div style="
						  line-height: 1.2;
						  font-size: 12px;
						  color: #44464a;
						  font-family: Nunito, Arial, Helvetica Neue,
							Helvetica, sans-serif;
						  mso-line-height-alt: 14px;
						">

							  <h3>Shipping Address</h3>
							  <p>'. $order_row->shipment_add_1 .' '. $order_row->shipment_add_2 .' <br>'. $order_row->shipment_city .','. $order_row->shipment_state .','. $order_row->shipment_country .'<br>'. $order_row->shipment_postcode .'<br>'. $order_row->shipment_email.'</p>
						</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid mixed-two-up"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  "
                >
                  <div
                    class="col num8"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 448px;
                      width: 453px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 15px;
                          padding-bottom: 5px;
                          padding-right: 10px;
                          padding-left: 10px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #44464a;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #44464a;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Order number:
                              <span style="color: #fb3c2d"
                                ><strong>'.$orderid.'</strong></span
                              >
                            </p>
                          </div>
                        </div>
                         <div
                          style="
                            color: #44464a;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #44464a;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Order Status: '.$order_row->order_status.'
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td><td align="center" width="226" style="background-color:#ffffff;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:15px;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 15px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <div class="mobile_hide">
                          <table
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            class="divider"
                            role="presentation"
                            style="
                              table-layout: fixed;
                              vertical-align: top;
                              border-spacing: 0;
                              border-collapse: collapse;
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              min-width: 100%;
                              -ms-text-size-adjust: 100%;
                              -webkit-text-size-adjust: 100%;
                            "
                            valign="top"
                            width="100%"
                          >
                            <tbody>
                              <tr style="vertical-align: top" valign="top">
                                <td
                                  class="divider_inner"
                                  style="
                                    word-break: break-word;
                                    vertical-align: top;
                                    min-width: 100%;
                                    -ms-text-size-adjust: 100%;
                                    -webkit-text-size-adjust: 100%;
                                    padding-top: 0px;
                                    padding-right: 0px;
                                    padding-bottom: 0px;
                                    padding-left: 0px;
                                  "
                                  valign="top"
                                >
                                  <table
                                    align="center"
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                    class="divider_content"
                                    height="15"
                                    role="presentation"
                                    style="
                                      table-layout: fixed;
                                      vertical-align: top;
                                      border-spacing: 0;
                                      border-collapse: collapse;
                                      mso-table-lspace: 0pt;
                                      mso-table-rspace: 0pt;
                                      border-top: 0px solid transparent;
                                      height: 15px;
                                      width: 100%;
                                    "
                                    valign="top"
                                    width="100%"
                                  >
                                    <tbody>
                                      <tr
                                        style="vertical-align: top"
                                        valign="top"
                                      >
                                        <td
                                          height="15"
                                          style="
                                            word-break: break-word;
                                            vertical-align: top;
                                            -ms-text-size-adjust: 100%;
                                            -webkit-text-size-adjust: 100%;
                                          "
                                          valign="top"
                                        >
                                          <span></span>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:transparent;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="15"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 0px solid transparent;
                                    height: 15px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="15"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid three-up no-stack"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="226" style="background-color:transparent;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top:5px; padding-bottom:5px;background-color:#f9feff;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      background-color: #f9feff;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 15px;
                          padding-left: 15px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #fb3c2d;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #fb3c2d;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Item
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td><td align="center" width="226" style="background-color:transparent;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top:5px; padding-bottom:5px;background-color:#f9feff;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      background-color: #f9feff;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 15px;
                          padding-left: 15px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #fb3c2d;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #fb3c2d;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: center;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Quantity
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td><td align="center" width="226" style="background-color:transparent;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 15px; padding-left: 15px; padding-top:5px; padding-bottom:5px;background-color:#f9feff;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      background-color: #f9feff;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 15px;
                          padding-left: 15px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #fb3c2d;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #fb3c2d;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: right;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Total
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>';
            
            
             $this->db->select('*');
        $this->db->from('master_orders_item');
        $this->db->where('order_id', $orderid);
        $this->db->where('data_store', 'full');
        $query     = $this->db->get();
        $item_rows = $query->result();
        $k         = 1;
        foreach ($item_rows as $item_row)
            {
            $body_content.='
            <div style="background-color: transparent">
              <div
                class="block-grid three-up no-stack"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="226" style="background-color:transparent;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 5px;
                          padding-left: 5px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #393d47;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 0px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #393d47;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              '.$item_row->name.'
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td><td align="center" width="226" style="background-color:transparent;width:226px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 5px;
                          padding-left: 5px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #393d47;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 5px;
                            padding-bottom: 10px;
                            padding-left: 5px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #393d47;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: center;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              '.$item_row->qty.'
                            </p>
                          </div>
                        </div>
                        
                      </div>
                     
                    </div>
                  </div>
                  
                  <div
                    class="col num4"
                    style="
                      display: table-cell;
                      vertical-align: top;
                      max-width: 320px;
                      min-width: 224px;
                      width: 226px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 5px;
                          padding-left: 5px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 0px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #393d47;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 0px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #393d47;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: right;
                                mso-line-height-alt: 17px;
                                margin: 0;
                              "
                            >
                              Rs.';
                              if($item_row->offer_price!='')
                              {
                                $body_content.=$item_row->qty*$item_row->offer_price;  
                              }
                              else
                              {
                                 $body_content.=$item_row->qty*$item_row->price; 
                              }
                            $body_content.='</p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:transparent;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="1"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 1px solid #e1ecef;
                                    height: 1px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="1"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>';
            }
            
          
            $body_content.='<div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:transparent;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="1"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 1px solid #e1ecef;
                                    height: 1px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="1"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:transparent;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 5px;
                          padding-left: 5px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #fb3c2d;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.2;
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.2;
                              font-size: 12px;
                              color: #fb3c2d;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 14px;
                            "
                          >
                            <p
                              style="
                                font-size: 22px;
                                line-height: 1.2;
                                word-break: break-word;
                                text-align: right;
                                mso-line-height-alt: 26px;
                                margin: 0;
                              "
                            >
                              <span style="font-size: 22px"
                                ><strong
                                  ><span style="">Total Rs. '.$order_row->order_net_amount.'</span></strong
                                ></span
                              >
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: transparent;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: transparent;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:transparent;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 5px;
                          padding-bottom: 5px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          class="divider"
                          role="presentation"
                          style="
                            table-layout: fixed;
                            vertical-align: top;
                            border-spacing: 0;
                            border-collapse: collapse;
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            min-width: 100%;
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                          "
                          valign="top"
                          width="100%"
                        >
                          <tbody>
                            <tr style="vertical-align: top" valign="top">
                              <td
                                class="divider_inner"
                                style="
                                  word-break: break-word;
                                  vertical-align: top;
                                  min-width: 100%;
                                  -ms-text-size-adjust: 100%;
                                  -webkit-text-size-adjust: 100%;
                                  padding-top: 0px;
                                  padding-right: 0px;
                                  padding-bottom: 0px;
                                  padding-left: 0px;
                                "
                                valign="top"
                              >
                                <table
                                  align="center"
                                  border="0"
                                  cellpadding="0"
                                  cellspacing="0"
                                  class="divider_content"
                                  height="40"
                                  role="presentation"
                                  style="
                                    table-layout: fixed;
                                    vertical-align: top;
                                    border-spacing: 0;
                                    border-collapse: collapse;
                                    mso-table-lspace: 0pt;
                                    mso-table-rspace: 0pt;
                                    border-top: 0px solid transparent;
                                    height: 40px;
                                    width: 100%;
                                  "
                                  valign="top"
                                  width="100%"
                                >
                                  <tbody>
                                    <tr
                                      style="vertical-align: top"
                                      valign="top"
                                    >
                                      <td
                                        height="40"
                                        style="
                                          word-break: break-word;
                                          vertical-align: top;
                                          -ms-text-size-adjust: 100%;
                                          -webkit-text-size-adjust: 100%;
                                        "
                                        valign="top"
                                      >
                                        <span></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            <div style="background-color: transparent">
              <div
                class="block-grid"
                style="
                  min-width: 320px;
                  max-width: 680px;
                  overflow-wrap: break-word;
                  word-wrap: break-word;
                  word-break: break-word;
                  margin: 0 auto;
                  background-color: #ffffff;
                "
              >
                <div
                  style="
                    border-collapse: collapse;
                    display: table;
                    width: 100%;
                    background-color: #ffffff;
                  "
                >
                  <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:680px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                  <!--[if (mso)|(IE)]><td align="center" width="680" style="background-color:#ffffff;width:680px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px;"><![endif]-->
                  <div
                    class="col num12"
                    style="
                      min-width: 320px;
                      max-width: 680px;
                      display: table-cell;
                      vertical-align: top;
                      width: 680px;
                    "
                  >
                    <div class="col_cont" style="width: 100% !important">
                      <!--[if (!mso)&(!IE)]><!-->
                      <div
                        style="
                          border-top: 0px solid transparent;
                          border-left: 0px solid transparent;
                          border-bottom: 0px solid transparent;
                          border-right: 0px solid transparent;
                          padding-top: 15px;
                          padding-bottom: 15px;
                          padding-right: 0px;
                          padding-left: 0px;
                        "
                      >
                        <!--<![endif]-->
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 35px; padding-left: 35px; padding-top: 15px; padding-bottom: 15px; font-family: Arial, sans-serif"><![endif]-->
                        <div
                          style="
                            color: #44464a;
                            font-family: Nunito, Arial, Helvetica Neue,
                              Helvetica, sans-serif;
                            line-height: 1.5;
                            padding-top: 15px;
                            padding-right: 35px;
                            padding-bottom: 15px;
                            padding-left: 35px;
                          "
                        >
                          <div
                            class="txtTinyMce-wrapper"
                            style="
                              line-height: 1.5;
                              font-size: 12px;
                              color: #44464a;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              mso-line-height-alt: 18px;
                            "
                          >
                            <p
                              style="
                                font-size: 14px;
                                line-height: 1.5;
                                word-break: break-word;
                                text-align: center;
                                mso-line-height-alt: 21px;
                                margin: 0;
                              "
                            >
                              You can find more amazing products on our website.
                            </p>
                          </div>
                        </div>
                        <!--[if mso]></td></tr></table><![endif]-->
                        <div
                          align="center"
                          class="button-container"
                          style="
                            padding-top: 10px;
                            padding-right: 10px;
                            padding-bottom: 10px;
                            padding-left: 10px;
                          "
                        >
                         <a
                            href="'.base_url().'"
                            style="
                              -webkit-text-size-adjust: none;
                              text-decoration: none;
                              display: inline-block;
                              color: #fb3c2d;
                              background-color: transparent;
                              border-radius: 28px;
                              -webkit-border-radius: 28px;
                              -moz-border-radius: 28px;
                              width: auto;
                              width: auto;
                              border-top: 1px solid #fb3c2d;
                              border-right: 1px solid #fb3c2d;
                              border-bottom: 1px solid #fb3c2d;
                              border-left: 1px solid #fb3c2d;
                              padding-top: 5px;
                              padding-bottom: 5px;
                              font-family: Nunito, Arial, Helvetica Neue,
                                Helvetica, sans-serif;
                              text-align: center;
                              mso-border-alt: none;
                              word-break: keep-all;
                            "
                            target="_blank"
                            ><span
                              style="
                                padding-left: 20px;
                                padding-right: 20px;
                                font-size: 16px;
                                display: inline-block;
                                letter-spacing: undefined;
                              "
                              ><span
                                style="
                                  font-size: 16px;
                                  line-height: 2;
                                  word-break: break-word;
                                  mso-line-height-alt: 32px;
                                "
                                >View More</span
                              ></span
                            ></a
                          >
                          <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                        </div>
                        <!--[if (!mso)&(!IE)]><!-->
                      </div>
                      <!--<![endif]-->
                    </div>
                  </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                </div>
              </div>
            </div>
            
            
            
            
          </td>
        </tr>
      </tbody>
    </table>
    
  </body>';
 
  
   $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE;
   $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->set_mailtype("html");
      $from_email=get_settings('mailer_Host');
      $this->email->from($from_email); // change it to yours
      $this->email->to($this->session->userdata('email'));// change it to yours
      $this->email->subject('Order Confirm');
      $this->email->message($body_content);
      $this->email->send();
      

        }
    
}
