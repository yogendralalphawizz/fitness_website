<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    
   /* public function index()
	{
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	    }
	    else{
	       redirect(base_url('login'), 'refresh'); 
	    }
		
	}*/
	
	public function login(){
	    if( $this->session->userdata('login_user') ){
	        redirect('/admin/Dashboard/');
	        die;
	    }
	    
	    if( $this->input->method() == 'post' ){
	        $this->form_validation->set_rules('email','Email','required');
	        $this->form_validation->set_rules('password','Password','required');
	        
	        if( $this->form_validation->run() )
	        {
	             $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
 
                $userIp=$this->input->ip_address();
             
                $secret = $this->config->item('google_secret');
           
                $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
         
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $output = curl_exec($ch); 
                curl_close($ch);      
                 
                $status= json_decode($output, true);
         
                if ($status['success']) {
                 $user = $this->db->get_where('admin', [ 'email' => $this->input->post('email') ])->row_array();
	            if( $user ){
	                if( $user['status'] == 'Active' ){
	                    if( md5( $this->input->post('password') ) == $user['password'] ){
	                        $this->session->set_userdata('login_user', $user);
	                        notify( 'You are successfully logged in.', 'success', 3 );
	                        redirect('/admin/Dashboard/');
	                        die;
	                    } else {
	                        notify( 'Invalid Password.', 'warning', 3 );
	                    }
	                } else {
	                    notify( 'Your account is not in Active state.', 'warning', 3 );
	                }
	            } else {
	                notify( 'You are not registered with us.', 'warning', 3 );
	            }   
                }
                else
                {
                    notify( 'Sorry Google Recaptcha Unsuccessful!!', 'warning', 3 );
                }
	            
	            
	        } 
	        else 
	        {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
        $page_data['page_title']='Login';
        $this->load->view('default/admin/auth-login',$page_data);
	}
	
	public function logout(){
	    $this->session->unset_userdata('login_user');
	    notify( 'Successfully Logged Out.', 'success', 3 );
	    redirect('/admin/Auth/login/');
        die;
	}
	
	public function forgot_password(){
	    if( $this->session->userdata('login_user') ){
	        redirect('/admin/Dashboard/');
	        die;
	    }
	    
	    if( $this->input->method() == 'post' ){
	        $this->form_validation->set_rules('email','Email','required');
	        
	        if( $this->form_validation->run() ){
	            $user = $this->db->get_where('admin', [ 'email' => $this->input->post('email') ])->row_array();
	            
	            if( $user ){
	                if( $user['status'] == 'Active' ){
	                    $token = md5( time() . '-' . str_pad(rand(0,999999),6,'0') . '-' . str_pad(rand(0,999999),6,'0') . '-' . str_pad(rand(0,999999),6,'0') );
	                    
	                    $this->db->where('id', $user['id']);
	                    $this->db->set('pw_reset_token', $token);
	                    $this->db->update('admin');
	                    
	                    $this->load->library('Mailer');
	                    
	                    $this->mailer->addAddress($user['email']);
	                    $this->mailer->Subject = 'Reset Password';
	                    $this->mailer->Body = 'Dear User, Your password reset link is : ' . base_url('/admin/Auth/reset_password/' . $token);
	                    $this->mailer->Send();
	                    
	                    notify( 'Password Reset Link has been sent to your email address.', 'success', 3 );
	                } else {
	                    notify( 'Your account is not in Active state.', 'warning', 3 );
	                }
	            } else {
	                notify( 'You are not registered with us.', 'warning', 3 );
	            }
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title']='Forgot Password?';
        $this->load->view('default/admin/auth-forget',$page_data);
	}
	
	public function reset_password($token){
	    if( $this->session->userdata('login_user') ){
	        redirect('/admin/Dashboard/');
	        die;
	    }
	    
	    $user = $this->db->get_where('admin',['pw_reset_token' => $token])->row_array();
	    
	    if( ! $user ){
	        notify( 'Invalid Password Reset Link.', 'warning', 3 );
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    if( $this->input->method() == 'post' ){
	        $this->form_validation->set_rules('new_pass', 'New Password', 'required');
	        $this->form_validation->set_rules('confirm_pass','Confirm Password', 'required|matches[new_pass]');
	        
	        if( $this->form_validation->run() ){
	            $this->db->set('password', md5( $this->input->post('new_pass')));
	            $this->db->set('pw_reset_token', NULL);
	            $this->db->where('id', $user['id']);
	            $this->db->update('admin');
	            
	            notify( 'Password has been successfully updated.', 'success', 3 );
	            redirect('/admin/Auth/login/');
	            die;
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title']='Reset Password';
        $this->load->view('default/admin/auth-reset',$page_data);
	}
}
