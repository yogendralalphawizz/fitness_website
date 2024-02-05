<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        $this->load->library('cart');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->load->model('Email_model');
    }

    public function index() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        }else {
            redirect(site_url('home/login'), 'refresh');
        }
    }

    public function validate_login($from = "") {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1);

        // Checking login credential for admin
        $query = $this->db->get_where('users', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
            $this->session->set_userdata('firstname', $row->first_name);
            $this->session->set_userdata('email', $row->email);
            $this->session->set_userdata('lastname', $row->last_name);
            $this->session->set_userdata('is_instructor', $row->is_instructor);
            $this->session->set_flashdata('flash_message', get_phrase('welcome').' '.$row->first_name.' '.$row->last_name);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                redirect(site_url('admin/dashboard'), 'refresh');
            }else if($row->role_id == 2 || $row->role_id == 3){
                $this->session->set_userdata('user_login', '1');
                $this->add_cart_table();
                redirect(site_url(), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message',get_phrase('invalid_login_credentials'));
            redirect(site_url('login'), 'refresh');
        }
    }
	
    public function register() {
		  $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		  $this->form_validation->set_rules('firstname', 'First Name', 'required');
		  $this->form_validation->set_rules('lastname', 'Last Name', 'required');
		  $this->form_validation->set_rules('password', 'Password', 'required');
		  $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'required|matches[password]');
		  $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		/*if(!$this->input->post('terms_and_conditions')):
			$this->form_validation->set_rules('terms_and_conditions', 'Please read and accept our terms and conditions.', 'required');
		endif;*/
		  
		  if($this->form_validation->run())
		  {
			  
		$data['first_name'] = html_escape($this->input->post('firstname'));
        $data['last_name']  = html_escape($this->input->post('lastname'));
		//$data['username']  = html_escape($this->input->post('username'));
        $data['email']  = html_escape($this->input->post('email'));
        $data['password']  = sha1($this->input->post('password'));

        $verification_code =  md5(rand(100000000, 200000000));
        $data['verification_code'] = $verification_code;

        if (get_settings('user_email_verification') == 'enable') {
            $data['status'] = 0;
        }else {
            $data['status'] = 1;
        }

       
        $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
        $social_links = array(
            'facebook' => "",
            'twitter'  => "",
            'linkedin' => ""
        );
       
	   if($this->input->post('register_as')=='Company'){
		   $data['role_id']  = 3;
		      //is a company or not
	   }else{
		   $data['role_id']  = 2;
	   }
		$validity = $this->user_model->check_duplication('on_create', $data['email']);
        if ($validity) {
            $user_id = $this->user_model->register_user($data);
            if (get_settings('user_email_verification') == 'enable') {
                 $this->Email_model->send_email_verification_mail($data['email'], $verification_code);
				
				$array = array(
				'success' =>  get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address'));
		  
               
            }else {
                
				$array = array(
				'success' =>  get_phrase('your_registration_has_been_successfully_done'),
		   );
               
            }

        }else {
			$array = array(
			'error'   => true,
			'message_error' =>  get_phrase('email_duplication'),
		   );
            
        }
		  }
		  else
		  {
		   $array = array(
			'error'   => true,
			'username_error' => form_error('username'),
			'firstname_error' => form_error('firstname'),
			'lastname_error' => form_error('lastname'),
			'email_error' => form_error('email'),
			'password_error' => form_error('password'),
			'cpassword_error' => form_error('cpassword'),
			'terms_and_conditions_error' => form_error('terms_and_conditions')
		   );
		  }

		  echo json_encode($array);
		 }
	

    public function logout($from = "") {
        //destroy sessions of specific userdata. We've done this for not removing the cart session
        $this->session_destroy();
        redirect(site_url(), 'refresh');
    }

    public function session_destroy() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('is_instructor');
        if ($this->session->userdata('admin_login') == 1) {
            $this->session->unset_userdata('admin_login');
        }else {
            $this->session->unset_userdata('user_login');
        }
    }

    function forgot_password($from = "") {
        $email = $this->input->post('email');
        //resetting user password here
        $new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('users' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $this->db->where('email' , $email);
            $this->db->update('users' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password, $email);
            $this->session->set_flashdata('flash_message', get_phrase('please_check_your_email_for_new_password'));
            //die;
            if ($from == 'backend') {
                redirect(site_url('login'), 'refresh');
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('password_reset_failed'));
            if ($from == 'backend') {
                redirect(site_url('login'), 'refresh');
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function verify_email_address($verification_code = "") {
        $user_details = $this->db->get_where('users', array('verification_code' => $verification_code));
       // echo  $this->db->last_query();
       // die;
        if($user_details->num_rows() == 0) {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }else {
            $user_details = $user_details->row_array();
            $updater = array(
                'status' => 1
            );
            $this->db->where('id', $user_details['id']);
            $this->db->update('users', $updater);
            $this->session->set_flashdata('flash_message', get_phrase('congratulations').'!'.get_phrase('your_email_address_has_been_successfully_verified').'.');
        }
        redirect(site_url('login'), 'refresh');
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
   
}
