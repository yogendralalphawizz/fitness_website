<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homesetting extends MY_Controller {
	public function index()
	{
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
        $page_data['page_title']='Homesetting';
        $this->load->view('default/admin/index',$page_data);
	}
	
	public function pager($total_result, $current_page, $per_page = 15, $payload = array())
	{
		$total_page = ceil( $total_result / $per_page );
		$links_limit = 7; $html = '';

		if( $total_page <= 1 ){ return $html; }

		$temp_GET = array_merge($_GET, $payload);
		$html .= '<ul class="pagination">';

		$side = ($links_limit - 1) / 2;
		$start = $current_page - $side; $end = $current_page + $side;

		if($start < 1)
		{
			$end = $end - $start + 1;
			$start = 1;
		}

		if($end > $total_page)
		{
			$start = $total_page - (2 * $side);
			$end = $total_page;
		}

		if($start < 1){ $start = 1; }

		if($current_page > 1)
		{
			$temp_GET['page'] = $current_page - 1;
			$html .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($temp_GET).'">Previous</a></li>';
		}

		for($i = $start; $i <= $end; $i++)
		{
			$temp_GET['page'] = $i;
			if( $current_page == $i ){
				$html .= '<li class="page-item active"><a class="page-link" href="javascript:void(0)">'.$i.'</a></li>';
			} else {
				$html .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($temp_GET).'">'.$i.'</a></li>';
			}
		}

		if($current_page < $total_page)
		{
			$temp_GET['page'] = $current_page + 1;
			$html .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($temp_GET).'">Next</a></li>';
		}

		$html .= '</ul>';

		return $html;
	}


	
	
	
	public function practicalboard_setting(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','required');
			$this->form_validation->set_rules('total_items','Total Items','required');
		
			
			if( $this->form_validation->run() ){
				try {
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'total_items' => $this->input->post('total_items'),
						'page_type' => $this->input->post('page_type'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('/admin/Homesetting/practicalboard_setting/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Practical board SME';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','practical_board');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/practical-boardsetting',$page_data);
	}
	
    
    
    	public function why_us_setting(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','');
			$this->form_validation->set_rules('total_items','Total Items','required');
		
			
			if( $this->form_validation->run() ){
				try {
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'total_items' => $this->input->post('total_items'),
						'page_type' => $this->input->post('page_type'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('/admin/Homesetting/why_us_setting/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Why us setting manage';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','why_us');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/why_us_setting',$page_data);
	}
	
	
		public function schedule_section(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','');
			$this->form_validation->set_rules('btn_text','Button text','');
		   	$this->form_validation->set_rules('btn_link','Button link','');
			
			if( $this->form_validation->run() ){
				try {
					
					$file = $this->input->upload( 'image', './uploads/background/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('background_image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'button_text' => $this->input->post('btn_text'),
						'button_link' => $this->input->post('btn_link'),
						'page_type' => $this->input->post('page_type'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	//echo $this->db->last_query();
					    //	die;
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('admin/homesetting/scheule-section');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Schedule demo section';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','schedule_section');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/schedule_demo_section',$page_data);
	}
	
	
		public function cosecaction_section(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','');
			$this->form_validation->set_rules('total_items','Total Items','required');
		
			
			if( $this->form_validation->run() ){
				try {
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'total_items' => $this->input->post('total_items'),
						'page_type' => $this->input->post('page_type'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('/admin/Homesetting/cosecaction_section/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Cosec action';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','cosec_action');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/cosec-action-section',$page_data);
	}
	
		public function key_features(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','');
			$this->form_validation->set_rules('total_items','Total Items','required');
			$this->form_validation->set_rules('btn_text','Button text','');
		   	$this->form_validation->set_rules('btn_link','Button link','');
		
			
			if( $this->form_validation->run() ){
				try {
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'total_items' => $this->input->post('total_items'),
						'page_type' => $this->input->post('page_type'),
							'button_text' => $this->input->post('btn_text'),
						'button_link' => $this->input->post('btn_link'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('/admin/Homesetting/key_features/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Key features';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','key_features');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/key-features',$page_data);
	}
	
		public function get_more_cosec(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','');
			$this->form_validation->set_rules('total_items','Total Items','required');
		
			
			if( $this->form_validation->run() ){
				try {
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'total_items' => $this->input->post('total_items'),
						'page_type' => $this->input->post('page_type'),
						
					]);
					
					if($this->input->post('id')){
					    	$this->db->where('id', $this->input->post('id'));
					    		$this->db->where('page_type', $this->input->post('page_type'));
					    	$this->db->update('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully updated.', 'success', 3 );
					    
					}else{
					    	$this->db->insert('practicalboard_home_settings');
					    	
					    		notify( 'Items has been successfully inserted.', 'success', 3 );
					}
				
				
				
					redirect('/admin/Homesetting/get_more_cosec/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Get more from cosec';
		
		$this->db->select('*');
		$this->db->from('practicalboard_home_settings');
		$this->db->where('page_type','get_more_cosec');
		$page_data['results']=$this->db->get()->row_array();
		//print_r($page_data['results']);
		//die;
		$this->load->view('default/admin/homesetting/get-more-cosec',$page_data);
	}
	
	
	public function features(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 30;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$page_data['sliders'] = $this->db->get('features')->result_array();
		
		$page_data['pager'] = $this->pager($this->db->get('features')->num_rows(), $page, $limit);
		
		$page_data['page_title'] = 'Features';
		$this->load->view('default/admin/features',$page_data);
	}
	
	public static function slugify($text, string $divider = '-')
	{
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, $divider);
		$text = preg_replace('~-+~', $divider, $text);
		$text = strtolower($text);

		if (empty($text)) {
			return md5( time() . '-' . str_pad( rand(0,999999), 6, '0', STR_PAD_LEFT ) . '-' . str_pad( rand(0,999999), 6, '0', STR_PAD_LEFT ) . '-' . str_pad( rand(0,999999), 6, '0', STR_PAD_LEFT ) );
		}

		return $text;
	}
	
	public function add_feature(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/features/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					$num = $this->db->get('features')->num_rows();
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'image' => $file['path'],
						'slug' => $this->slugify( $this->input->post('title') ) . ($num ? ('-' . $num) : '')
					]);
					
					$this->db->insert('features');
					
					notify( 'Feature has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/features/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['page_title'] = 'Add Feature';
		$this->load->view('default/admin/add_feature',$page_data);
	}
	
	public function feature_status($id){
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('features');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function edit_feature($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/features/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'long_desc' => $this->input->post('long_desc'),
						'btn_text' => $this->input->post('btn_text')
					]);
					$this->db->where('id', $id);
					$this->db->update('features');
					
					notify( 'Feature has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/features/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$slider = $this->db->get_where('features', ['id' => $id])->row_array();
		
		if( ! $slider ){
			redirect('/admin/Dashboard/features/');
		}
		
		$page_data['slider'] = $slider;
		
		$page_data['page_title'] = 'Edit Feature';
		$this->load->view('default/admin/edit_feature',$page_data);
	}
	
	public function delete_feature($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$this->db->where('id', $id);
		$this->db->delete('features');
		
		redirect('/admin/Dashboard/features/');
	}
	
	public function why_us_list(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 30;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$page_data['sliders'] = $this->db->get('why_us_list')->result_array();
		
		$page_data['pager'] = $this->pager($this->db->get('why_us_list')->num_rows(), $page, $limit);
		
		$page_data['page_title'] = 'Why Us List';
		$this->load->view('default/admin/why_us_list',$page_data);
	}
	
	public function add_why_us(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/why_us/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					$num = $this->db->get('why_us_list')->num_rows();
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'image' => $file['path'],
						'slug' => $this->slugify( $this->input->post('title') ) . ($num ? ('-' . $num) : '')
					]);
					
					$this->db->insert('why_us_list');
					
					notify( 'Why Us has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/why_us_list/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['page_title'] = 'Add Why Us';
		$this->load->view('default/admin/add_why_us',$page_data);
	}
	
	public function edit_why_us($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/why_us/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc')
					]);
					$this->db->where('id', $id);
					$this->db->update('why_us_list');
					
					notify( 'Why Us has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/why_us_list/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$slider = $this->db->get_where('why_us_list', ['id' => $id])->row_array();
		
		if( ! $slider ){
			redirect('/admin/Dashboard/why_us_list/');
		}
		
		$page_data['slider'] = $slider;
		
		$page_data['page_title'] = 'Edit Why Us';
		$this->load->view('default/admin/edit_why_us',$page_data);
	}
	
	public function why_us_status($id){
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('why_us_list');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function delete_why_us($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$this->db->where('id', $id);
		$this->db->delete('why_us_list');
		
		redirect('/admin/Dashboard/why_us_list/');
	}
	
	public function product_levels(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 30;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$page_data['sliders'] = $this->db->get('product_levels')->result_array();
		
		$page_data['pager'] = $this->pager($this->db->get('product_levels')->num_rows(), $page, $limit);
		
		$page_data['page_title'] = 'Product Levels';
		$this->load->view('default/admin/product_levels',$page_data);
	}
	
	public function add_product_level(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			$this->form_validation->set_rules('meta_title','Meta Title','required');
			$this->form_validation->set_rules('meta_descr','Meta Description','required');
			$this->form_validation->set_rules('meta_keyword','Meta Keyword','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/product_level/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					$num = $this->db->get('product_levels')->num_rows();
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'image' => $file['path'],
						'slug' => $this->slugify( $this->input->post('title') ) . ($num ? ('-' . $num) : ''),
						'meta_title' => $this->input->post('meta_title'),
						'meta_descr' => $this->input->post('meta_descr'),
						'meta_keyword' => $this->input->post('meta_keyword')
					]);
					
					$this->db->insert('product_levels');
					
					notify( 'Product Level has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/product_levels/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['page_title'] = 'Add Product Level';
		$this->load->view('default/admin/add_product_level',$page_data);
	}
	
	public function edit_product_level($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			$this->form_validation->set_rules('meta_title','Meta Title','required');
			$this->form_validation->set_rules('meta_descr','Meta Description','required');
			$this->form_validation->set_rules('meta_keyword','Meta Keyword','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/product_level/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_descr' => $this->input->post('meta_descr'),
						'meta_keyword' => $this->input->post('meta_keyword')
					]);
					$this->db->where('id', $id);
					$this->db->update('product_levels');
					
					notify( 'Product Level has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/product_levels/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$slider = $this->db->get_where('product_levels', ['id' => $id])->row_array();
		
		if( ! $slider ){
			redirect('/admin/Dashboard/product_levels/');
		}
		
		$page_data['slider'] = $slider;
		
		$page_data['page_title'] = 'Edit Product Level';
		$this->load->view('default/admin/edit_product_level',$page_data);
	}
	
	public function product_level_status($id){
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('product_levels');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function delete_product_level($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$this->db->where('id', $id);
		$this->db->delete('product_levels');
		
		redirect('/admin/Dashboard/product_levels/');
	}
	
	public function services(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$page = 1;
		if( $this->input->get('page') ){
			$page = $this->input->get('page');
		}
		
		$limit = 30;
		if( $this->input->get('limit') ){
			$limit = $this->input->get('limit');
		}
		
		$this->db->limit($limit, ($page - 1) * $limit);
		$page_data['sliders'] = $this->db->get('services')->result_array();
		
		$page_data['pager'] = $this->pager($this->db->get('services')->num_rows(), $page, $limit);
		
		$page_data['page_title'] = 'Services';
		$this->load->view('default/admin/services',$page_data);
	}
	
	public function add_service(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			$this->form_validation->set_rules('meta_title','Meta Title','required');
			$this->form_validation->set_rules('meta_descr','Meta Description','required');
			$this->form_validation->set_rules('meta_keyword','Meta Keyword','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/services/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					$num = $this->db->get('services')->num_rows();
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'image' => $file['path'],
						'slug' => $this->slugify( $this->input->post('title') ) . ($num ? ('-' . $num) : ''),
						'meta_title' => $this->input->post('meta_title'),
						'meta_descr' => $this->input->post('meta_descr'),
						'meta_keyword' => $this->input->post('meta_keyword')
					]);
					
					$this->db->insert('services');
					
					notify( 'Service has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/services/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['page_title'] = 'Add Service';
		$this->load->view('default/admin/add_service',$page_data);
	}
	
	public function edit_service($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('short_desc','Short Description','required');
			$this->form_validation->set_rules('long_desc','Long Description','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			
			$this->form_validation->set_rules('meta_title','Meta Title','required');
			$this->form_validation->set_rules('meta_descr','Meta Description','required');
			$this->form_validation->set_rules('meta_keyword','Meta Keyword','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/services/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_desc' => $this->input->post('short_desc'),
						'btn_text' => $this->input->post('btn_text'),
						'long_desc' => $this->input->post('long_desc'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_descr' => $this->input->post('meta_descr'),
						'meta_keyword' => $this->input->post('meta_keyword')
					]);
					$this->db->where('id', $id);
					$this->db->update('services');
					
					notify( 'Service has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/services/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$slider = $this->db->get_where('services', ['id' => $id])->row_array();
		
		if( ! $slider ){
			redirect('/admin/Dashboard/services/');
		}
		
		$page_data['slider'] = $slider;
		
		$page_data['page_title'] = 'Edit Service';
		$this->load->view('default/admin/edit_service',$page_data);
	}
	
	public function service_status($id){
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('services');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function delete_service($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$this->db->where('id', $id);
		$this->db->delete('services');
		
		redirect('/admin/Dashboard/services/');
	}
}
