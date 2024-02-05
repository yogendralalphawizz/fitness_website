<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {
	public function signup(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('school', 'School', 'required');
		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[password]');
		
		$this->form_validation->set_rules('father_name', 'Father\'s Name', 'required');
		$this->form_validation->set_rules('father_education', 'Father\'s Education', 'required');
		$this->form_validation->set_rules('father_occupation', 'Father\'s Occupation', 'required');
		$this->form_validation->set_rules('mother_name', 'Mother\'s Name', 'required');
		$this->form_validation->set_rules('mother_education', 'Mother\'s Education', 'required');
		$this->form_validation->set_rules('mother_occupation', 'Mother\'s Occupation', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('zipcode', 'ZIP Code', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		
		if( $this->form_validation->run() ){
		    $this->db->where('email', $this->input->post('username'));
		    $this->db->or_where('mobile', $this->input->post('username'));
			$already = $this->db->get('students')->row_array();
			
			if( ! $already ){
			    $otp_code = 666666; // $this->_rand_str(6, ['0']);
			    
				$this->db->set([
					'name' => $this->input->post('name'),
					'gender' => $this->input->post('gender'),
					'dob' => $this->input->post('dob'),
					'school' => $this->input->post('school'),
					'user_id' => $this->input->post('user_id'),
					'password' => md5( $this->input->post('password') ),
					'father_name' => $this->input->post('father_name'),
					'father_education' => $this->input->post('father_education'),
					'father_occupation' => $this->input->post('father_occupation'),
					'mother_name' => $this->input->post('mother_name'),
					'mother_education' => $this->input->post('mother_education'),
					'mother_occupation' => $this->input->post('mother_occupation'),
					'country_code' => $this->input->post('country_code'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'zipcode' => $this->input->post('zipcode'),
					'state' => $this->input->post('state'),
					'country' => $this->input->post('country'),
					'password_reset_otp' => $otp_code
				]);
				
				$this->db->insert('students');
				
				// send $otp_code to $user['mobile'];
				
				$result = [
					'status' => 1,
					'user_id' => $this->db->insert_id(),
					'message' => 'Account created, OTP Code has been sent to your mobile number.'
				];
			} else {
				$result = [
					'status' => 0,
					'message' => 'Email address / Mobile Number already registered with us.'
				];
			}
		} else {
			$result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
		}
		
		echo json_encode($result);
	}
	
	public function validate_signup(){
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('user_id', 'User ID', 'required');
	    $this->form_validation->set_rules('otp_code','OTP Code', 'required');
	    
	    if( $this->form_validation->run() ){
	        $user = $this->db->get_where('students',['id' => $this->input->post('user_id')])->row_array();
	        
	        if( $user ){
	            if( $user['status'] == 'Pending' ){
	                if( $this->input->post('otp_code') == $user['password_reset_otp'] ){
	                    $this->db->set([
	                       'password_reset_otp' => NULL,
	                       'status' => 'Allowed'
	                    ]);
	                    $this->db->where('id',$this->input->post('user_id'));
	                    $this->db->update('students');
	                    
	                    $result = [
        					'status' => 1,
        					'message' => 'Account has been successfully verified.'
        				];
	                } else {
	                    $result = [
        					'status' => 0,
        					'message' => 'Invalid OTP.'
        				];
	                }
	            } else {
	                $result = [
    					'status' => 0,
    					'message' => 'Your account is already verified.'
    				];
	            }
	        } else {
	            $result = [
					'status' => 0,
					'message' => 'Invalid User ID.'
				];
	        }
	    } else {
	        $result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
	    }
	}
	
	public function login(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Email / Mobile Number', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if( $this->form_validation->run() ){
		    $this->db->where('email', $this->input->post('username'));
		    $this->db->or_where('mobile', $this->input->post('username'));
			$user = $this->db->get('students')->row_array();

			if( $user ){
				if( $user['status'] == 'Rejected' ){
					$result = [
						'status' => 0,
						'message' => 'This Account is not Allowed.'
					];
				} else if( $user['status'] == 'Pending' ){
				    $otp_code = 666666; // $this->_rand_str(6, ['0']);
				    
				    $this->db->set('password_reset_otp', $otp_code);
    	            $this->db->where('id', $user['id']);
    	            $this->db->update('students');
    	            
				    // send $otp_code to $user['mobile'];
				    
					$result = [
						'status' => 0,
						'verify' => true,
						'message' => 'Email / Mobile number Verification is pending, OTP has been sent to your Mobile Number.'
					];
				} else if( md5( $this->input->post('password') ) != $user['password'] ){
					$result = [
						'status' => 0,
						'message' => 'Invalid Credentials.'
					];
				} else {
					unset($user['password']);
					if( $user['profile_pic'] ){ $user['profile_pic'] = base_url($user['profile_pic']); }
					
					$this->load->library('encryption');
					
					$result = [
						'status' => 1,
						'message' => 'Successfully logged in.',
						'token' => $this->encryption->encrypt( $user['id'] ),
						'data' => $user
					];
				}
			} else {
				$result = [
					'status' => 0,
					'message' => 'This Email address / Mobile Number is not registered with us.'
				];
			}
		} else {
			$result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
		}
		
		echo json_encode($result);
	}
	
	public function reset_password_pre(){
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('username','Email / Mobile','required');
	    
	    if( $this->form_validation->run() ){
	        $this->db->where('email', $this->input->post('username'));
		    $this->db->or_where('mobile', $this->input->post('username'));
			$user = $this->db->get('students')->row_array();
	        
	        if($user){
	            if($user['status'] == 'Allowed'){
	                $otp_code = 666666; // $this->_rand_str(6, ['0']);
	            
    	            $this->db->set('password_reset_otp', $otp_code);
    	            $this->db->where('id', $user['id']);
    	            $this->db->update('students');
    	            
    	            // send $otp_code to $user['mobile'];
    	            
                    $result = [
                        'status' => 1,
                        'message' => 'OTP has been sent to your mobile number.'
                    ];
	            } else {
	                $result = [
						'status' => 0,
						'message' => 'This Account is not Allowed.'
					];
	            }
	        } else {
	            $result = [
					'status' => 0,
					'message' => 'This Mobile Number is not registered with us.'
				];
	        }
	    } else {
	        $result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
	    }
	    
	    echo json_encode($result);
	}
	
	public function reset_password_post_1(){
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('username','Email / Mobile','required');
	    $this->form_validation->set_rules('otp_code','OTP Code', 'required');
	    
	    if( $this->form_validation->run() ){
	        $this->db->where('email', $this->input->post('username'));
		    $this->db->or_where('mobile', $this->input->post('username'));
			$user = $this->db->get('students')->row_array();
	        
	        if( $user ){
	            if( $this->input->post('otp_code') == $user['password_reset_otp'] ){
	                $result = [
	                    'status' => 1,
	                    'message' => 'OTP Verified Successfully.'
	                ];
	            } else {
	                $result = [
    					'status' => 0,
    					'message' => 'Invalid OTP.'
    				];
	            }
	        } else {
	            $result = [
					'status' => 0,
					'message' => 'This Mobile Number is not registered with us.'
				];
	        }
	    } else {
	        $result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
	    }
	    
	    echo json_encode($result);
	}

    public function reset_password_post_2(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username','Email / Mobile','required');
        $this->form_validation->set_rules('otp_code','OTP Code','required');
        $this->form_validation->set_rules('new_pass','New Password','required');
        $this->form_validation->set_rules('confirm_pass','Confirm Password','required|matches[new_pass]');
        
        if( $this->form_validation->run() ){
            $this->db->where('email', $this->input->post('username'));
		    $this->db->or_where('mobile', $this->input->post('username'));
			$user = $this->db->get('students')->row_array();
	        
	        if( $user ){
	            if( $this->input->post('otp_code') == $user['password_reset_otp'] ){
	                $this->db->set('password', md5( $this->input->post('new_pass') ));
	                $this->db->set('password_reset_otp', NULL);
	                $this->db->where('id', $user['id']);
	                $this->db->update('students');
	                
	                $result = [
    					'status' => 1,
    					'message' => 'Password has been updated successfully.'
    				];
	            } else {
	                $result = [
    					'status' => 0,
    					'message' => 'Invalid OTP.'
    				];
	            }
	        } else {
	            $result = [
					'status' => 0,
					'message' => 'This Mobile Number is not registered with us.'
				];
	        }
        } else {
            $result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
        }
        
        echo json_encode($result);
    }
	
	public function change_password(){
	    $this->load->library('form_validation');
	    
	    $this->form_validation->set_rules('token','Token','required');
	    $this->form_validation->set_rules('new_pass','New Password','required');
	    $this->form_validation->set_rules('confirm_pass','Confirm Password','required|matches[new_pass]');
	    
	    if( $this->form_validation->run() ){
	        $this->load->library('encryption');
	        
	        $user_id = $this->encryption->decrypt( $this->input->post('token') );
	        
	        if( $user_id ){
	            $user = $this->db->get_where('students',['id' => $user_id])->row_array();
	            
	            if( $user ){
	                if( $user['status'] == 'Allowed' ){
	                    $this->db->set('password', md5( $this->input->post('password')));
	                    $this->db->where('id', $user_id);
	                    $this->db->update('students');
	                    
	                    $result = [
            				'status' => 1,
            				'message' => 'Your password has been successfully updated.'
            			];
	                } else {
	                    $result = [
            				'status' => 0,
            				'message' => 'You are not allowed on this application.'
            			];
	                }
	            } else {
	                $result = [
        				'status' => 0,
        				'message' => 'Invalid User'
        			];
	            }
	        } else {
	            $result = [
    				'status' => 0,
    				'message' => 'Unauthorized'
    			];
	        }
	    } else {
	        $result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
	    }
	    
	    echo json_encode($result);
	}
	
	public function update_profile(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('token', 'Token', 'required');
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('school', 'School', 'required');
		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		
		$this->form_validation->set_rules('father_name', 'Father\'s Name', 'required');
		$this->form_validation->set_rules('father_education', 'Father\'s Education', 'required');
		$this->form_validation->set_rules('father_occupation', 'Father\'s Occupation', 'required');
		$this->form_validation->set_rules('mother_name', 'Mother\'s Name', 'required');
		$this->form_validation->set_rules('mother_education', 'Mother\'s Education', 'required');
		$this->form_validation->set_rules('mother_occupation', 'Mother\'s Occupation', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('zipcode', 'ZIP Code', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		
		if( $this->form_validation->run() ){
		    $this->load->library('encryption');
	        $user_id = $this->encryption->decrypt( $this->input->post('token') );
	        
	        if( $user_id ){
	            $user = $this->db->get_where('students', ['id' => $user_id])->row_array();
			
    			if( $user ){
					try {
						$file = $this->input->upload( 'profile_pic', './uploads/students/', [
							'allowed' => ['image/jpeg','image/png','image/gif'],
							'required' => false
						] );
						
						if( isset($file) ){
							$this->db->set('profile_pic', $file['path']);
						}
						
						$this->db->set([
							'name' => $this->input->post('name'),
							'gender' => $this->input->post('gender'),
							'dob' => $this->input->post('dob'),
							'school' => $this->input->post('school'),
							'user_id' => $this->input->post('user_id'),
							'father_name' => $this->input->post('father_name'),
							'father_education' => $this->input->post('father_education'),
							'father_occupation' => $this->input->post('father_occupation'),
							'mother_name' => $this->input->post('mother_name'),
							'mother_education' => $this->input->post('mother_education'),
							'mother_occupation' => $this->input->post('mother_occupation'),
							'country_code' => $this->input->post('country_code'),
							'address' => $this->input->post('address'),
							'city' => $this->input->post('city'),
							'zipcode' => $this->input->post('zipcode'),
							'state' => $this->input->post('state'),
							'country' => $this->input->post('country')
						]);
						$this->db->where('id', $user['id']);
						$this->db->update('students');
						
						$user = $this->db->get_where('students', ['id' => $user['id']])->row_array();
						unset($user['password']);
						if( $user['profile_pic'] ){ $user['profile_pic'] = base_url($user['profile_pic']); }
						
						$result = [
							'status' => 1,
							'data' => $user,
							'message' => 'Profile has been successfully updated.'
						];
					} catch (\Exception $e){
						$result = [
							'status' => 0,
							'message' => $e->getMessage()
						];
					}
    			} else {
    				$result = [
    					'status' => 0,
    					'message' => 'Invalid User.'
    				];
    			}
	        } else {
	            $result = [
    				'status' => 0,
    				'message' => 'Unauthorized'
    			];
	        }
		} else {
			$result = [
				'status' => 0,
				'message' => strip_tags( validation_errors() )
			];
		}
		
		echo json_encode($result);
	}
	
	public function categories(){
		$categories = $this->db->get_where('categories', ['status' => 'Active'])->result_array();
		foreach($categories as &$category){
			if($category['image']){
				$category['image'] = base_url($category['image']);
			}
		}
		echo json_encode(['status' => 1, 'data' => $categories]);
	}
	
	public function sub_categories($category_id){
		$subcategories = $this->db->get_where('sub_categories', ['status' => 'Active', 'parent_id' => $category_id])->result_array();
		foreach($subcategories as &$category){
			if($category['image']){
				$category['image'] = base_url($category['image']);
			}
		}
		echo json_encode(['status' => 1, 'data' => $subcategories]);
	}
	
	public function schools(){
		$schools = $this->db->get_where('schools', ['status' => 'Active'])->result_array();
		foreach($schools as &$school){
			if($school['logo']){
				$school['logo'] = base_url($school['logo']);
			}
		}
		echo json_encode(['status' => 1, 'data' => $schools]);
	}
	
	public function classes(){
		$classes = $this->db->get_where('classes', ['status' => 'Active'])->result_array();
		echo json_encode(['status' => 1, 'data' => $classes]);
	}
	
	public function subjects(){
		$subjects = $this->db->get_where('subjects', ['status' => 'Active'])->result_array();
		foreach($subjects as &$subject){
			if($subject['document']){
				$subject['document'] = base_url($subject['document']);
			}
		}
		echo json_encode(['status' => 1, 'data' => $subjects]);
	}
	
	public function splash_screen(){
		$splash_screen = $this->db->get('splash_screen')->row_array();
		echo json_encode(['status' => 1, 'data' => $splash_screen]);
	}
	
	public function banners(){
		$this->db->order_by('priority','ASC');
		$banners = $this->db->get_where('banners', ['status' => 'Active'])->result_array();
		foreach($banners as &$banner){
			if($banner['image']){
				$banner['image'] = base_url($banner['image']);
			}
		}
		echo json_encode(['status' => 1, 'data' => $banners]);
	}
	
	public function app_page($slug){
		$app_page = $this->db->get_where('app_pages', ['status' => 'Active', 'slug' => $slug])->row_array();
		echo json_encode(['status' => 1, 'data' => $app_page]);
	}
	
	public function videos(){
		if( $this->input->get('school') ){
			$this->db->where('videos.school',$this->input->get('school'));
		}
		
		if( $this->input->get('class') ){
			$this->db->where('videos.class',$this->input->get('class'));
		}
		
		if( $this->input->get('subject') ){
			$this->db->where('videos.subject',$this->input->get('subject'));
		}
		
		$this->db->select('videos.*, subjects.name AS subject, classes.name AS class, schools.name AS school');
		$this->db->from('videos');
		$this->db->join('subjects','subjects.id = videos.subject');
		$this->db->join('classes', 'classes.id = videos.class');
		$this->db->join('schools', 'schools.id = videos.school');
		$this->db->where(['videos.status' => 'Active']);
		
		$total_query = $this->db->get_compiled_select('', false);
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 50;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$videos = $this->db->get()->result_array();
		
		foreach($videos as &$video){
			if( $video['video_type'] == 'file' && $video['video'] ){
				$video['video'] = base_url($video['video']);
			}
		}
		
		$total_page = ceil( $this->db->query($total_query)->num_rows() / $limit );
		
		echo json_encode(['status' => 1, 'data' => $videos, 'total_page' => $total_page, 'current_page' => $page ]);
	}
	
	public function products(){
		if( $this->input->get('category') ){
			$this->db->where('products.category',$this->input->get('category'));
		}
		
		if( $this->input->get('subcategory') ){
			$this->db->where('products.subcategory',$this->input->get('subcategory'));
		}
		
		if( $this->input->get('school') ){
			$this->db->where('products.school',$this->input->get('school'));
		}
		
		if( $this->input->get('class') ){
			$this->db->where('products.class',$this->input->get('class'));
		}
		
		if( $this->input->get('subject') ){
			$this->db->where('products.subject',$this->input->get('subject'));
		}
		
		$this->db->select('products.*, categories.name AS category, sub_categories.name AS subcategory, subjects.name AS subject, classes.name AS class, schools.name AS school');
		$this->db->from('products');
		$this->db->join('categories','categories.id = products.category');
		$this->db->join('sub_categories','sub_categories.id = products.subcategory');
		$this->db->join('subjects', 'subjects.id = products.subject');
		$this->db->join('classes', 'classes.id = products.class');
		$this->db->join('schools', 'schools.id = products.school');
		$this->db->where(['products.status' => 'Active']);
		
		$total_query = $this->db->get_compiled_select('', false);
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 50;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$products = $this->db->get()->result_array();
		
		foreach($products as &$product){
			if($product['image']){
				$product['image'] = base_url($product['image']);
			}
		}
		
		$total_page = ceil( $this->db->query($total_query)->num_rows() / $limit );
		
		echo json_encode(['status' => 1, 'data' => $products, 'total_page' => $total_page, 'current_page' => $page ]);
	}
	
	public function faqs(){
		$this->db->order_by('priority','ASC');
		$faqs = $this->db->get_where('faqs', ['status' => 'Active'])->result_array();
		echo json_encode(['status' => 1, 'data' => $faqs]);
	}
	
	protected function _rand_str($length = 6, $types = array('0','A','a','$'))
    {
    	$characters = '';
    		
    	if(in_array('0', $types)){ $characters = $characters . '0123456789'; }
    	if(in_array('A', $types)){ $characters = $characters . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
    	if(in_array('a', $types)){ $characters = $characters . 'abcdefghijklmnopqrstuvwxyz'; }
    	if(in_array('$', $types)){ $characters = $characters . '!"#$%&\'()*+,-./:;<=>?@[]\\^_`{}|~'; }
    	
    	if($characters == ''){ $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'!"#$%&\'()*+,-./:;<=>?@[]\\^_`{}|~';}
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
}