<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        //$this->load->database();
		
		$this->db->query('SET sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""));');
		
     $this->load->model('Dashboard_modal');
        $this->load->model('Home_model');
        // CHECK CUSTOM SESSION DATA
    
		//$this->load->model('Home_model');
		//$this->load->library("pagination");
		$this->load->helper('common_helper');
		//$this->load->library('notifier');
    }

	public function index()
	{
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
        $page_data['page_title']='Dashboard';
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
	
	protected function slugify($text, string $divider = '-'){
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, $divider);
		$text = preg_replace('~-+~', $divider, $text);
		$text = strtolower($text);

		if( $text == '' ){
			return (time() . $divider . str_pad( rand(0,999999), 6, '0', STR_PAD_LEFT ));
		}
		return $text;
	}

	protected function slugify_db($table, $column, $text, $divider = '-'){
		$db = clone get_instance()->db;
		$db->reset_query();
		
		$i = 0; 
		$slug = $this->slugify($text);
		$temp_slug = $slug;
		
		while( true ){
			$count = $db->get_where($table, [$column => $temp_slug])->num_rows();
			if( $count > 0 ){
				$i++;
				$temp_slug = $slug . $divider . $i;
			} else {
				break;
			}
		}
		
		return $temp_slug;
	}

	
	public function change_pass(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('old_pass', 'Old Password', 'required');
			$this->form_validation->set_rules('new_pass', 'New Password', 'required');
			$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[new_pass]');
			
			if( $this->form_validation->run() ){
				$user = $this->db->get_where('admin', ['id' => $this->session->userdata('login_user')['id']])->row_array();

				if( $user['password'] == md5( $this->input->post('old_pass') ) ){
					$this->db->set('password', md5( $this->input->post('new_pass') ));
					$this->db->where('id', $this->session->userdata('login_user')['id']);
					$this->db->update('admin');
					
					notify( 'Your Password has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/change_pass/');
					die;
				} else {
					notify( 'Invalid Old Password.', 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['page_title'] = 'Change Password';
		$this->load->view('default/admin/change_password',$page_data);
	}
	
	public function profile(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('email', 'Email Address', 'required');
			$this->form_validation->set_rules('phone_num', 'Phone Number', 'required');
			
			if( $this->form_validation->run() ){
				$this->db->set([
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'phone_num' => $this->input->post('phone_num')
				]);
				
				try {
					$file = $this->input->upload( 'profile_pic', './uploads/profile_pics/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
					] );
					
					if( isset($file) ){
						$this->db->set('profile_pic', $file['path']);
					}
					
					$this->db->where('id', $this->session->userdata('login_user')['id']);
					$this->db->update('admin');
					
					notify( 'Your Profile Details has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/profile/');
				} catch (\Exception $e){
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['profile'] = $this->db->get_where('admin', ['id' => $this->session->userdata('login_user')['id']])->row_array();
		$page_data['page_title'] = 'Update Profile';
		$this->load->view('default/admin/update_profile',$page_data);
	}
	
	public function web_config(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('site_title', 'Site Title', 'required');
			$this->form_validation->set_rules('site_tagline', 'Site Tagline', 'required');
			$this->form_validation->set_rules('company_email', 'Company Email', 'required');
			$this->form_validation->set_rules('company_phone', 'Company Phone', 'required');
			$this->form_validation->set_rules('company_address', 'Company Address', 'required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'company_logo', './uploads/settings/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
					] );
					
					if( isset($file) ){
						$this->db->set('key_value', $file['path']);
						$this->db->where('key_name', 'company_logo');
						$this->db->update('settings');
					}
					
					$file = $this->input->upload( 'favicon', './uploads/settings/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
					] );
					
					if( isset($file) ){
						$this->db->set('key_value', $file['path']);
						$this->db->where('key_name', 'favicon');
						$this->db->update('settings');
					}
					
					foreach($this->input->post() as $key => $value){
						$this->db->set('key_value', $value);
						$this->db->where('key_name', $key);
						$this->db->update('settings');
					}
					
					notify( 'Web Config Details has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/web_config/');
				} catch (\Exception $e){
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['profile'] = [];
		$temp = $this->db->get('settings')->result_array();
		foreach($temp as $temp_single){
			$page_data['profile'][ $temp_single['key_name'] ] = $temp_single['key_value'];
		}
		
		$page_data['page_title'] = 'Web Configuration';
		$this->load->view('default/admin/web_config',$page_data);
	}
	
	public function mail_config(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('mailer_method', 'Mailer Method', 'required');
			
			if( $this->form_validation->run() ){
				foreach($this->input->post() as $key => $value){
					$this->db->set('key_value', $value);
					$this->db->where('key_name', $key);
					$this->db->update('settings');
				}
				
				notify( 'Mail Config Details has been successfully updated.', 'success', 3 );
				redirect('/admin/Dashboard/mail_config/');
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}
		}
		
		$page_data['profile'] = [];
		$temp = $this->db->get('settings')->result_array();
		foreach($temp as $temp_single){
			$page_data['profile'][ $temp_single['key_name'] ] = $temp_single['key_value'];
		}
		
		$page_data['page_title'] = 'Mail Config';
		$this->load->view('default/admin/mail_config',$page_data);
	}
	
	public function social_config(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->db->where('1=1');
			$this->db->delete('social_config');
			
			foreach($this->input->post('socials') as $social){
				$this->db->set($social);
				$this->db->insert('social_config');
			}			
			
			notify( 'Mail Config Details has been successfully updated.', 'success', 3 );
			redirect('/admin/Dashboard/social_config/');
		}
		
		$page_data['rows'] = $this->db->get('social_config')->result_array();
		
		$page_data['page_title'] = 'Social Config';
		$this->load->view('default/admin/social_config',$page_data);
	}
	
	public function sliders(){
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
		$page_data['sliders'] = $this->db->get('sliders')->result_array();
		
		$page_data['pager'] = $this->pager($this->db->get('sliders')->num_rows(), $page, $limit);
		
		$page_data['page_title'] = 'Slider';
		$this->load->view('default/admin/slider',$page_data);
	}
	
	
	public function add_slider(){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			$this->form_validation->set_rules('btn_link','Button Link','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/sliders/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'btn_text' => $this->input->post('btn_text'),
						'btn_link' => $this->input->post('btn_link'),
						'image' => $file['path']
					]);
					
					$this->db->insert('sliders');
					
					notify( 'Slider has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/sliders/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$page_data['page_title'] = 'Add slider';
		$this->load->view('default/admin/add_slider',$page_data);
	}
	
	public function slider_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('sliders');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function edit_slider($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		if( $this->input->method() == 'post' ){
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('tagline','Tagline','required');
			$this->form_validation->set_rules('btn_text','Button Text','required');
			$this->form_validation->set_rules('btn_link','Button Link','required');
			
			if( $this->form_validation->run() ){
				try {
					$file = $this->input->upload( 'image', './uploads/sliders/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'tagline' => $this->input->post('tagline'),
						'btn_text' => $this->input->post('btn_text'),
						'btn_link' => $this->input->post('btn_link')
					]);
					$this->db->where('id', $id);
					$this->db->update('sliders');
					
					notify( 'Slider has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/sliders/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
			} else {
				notify( strip_tags( validation_errors() ), 'warning', 3 );
			}

		}
		
		$slider = $this->db->get_where('sliders', ['id' => $id])->row_array();
		
		if( ! $slider ){
			redirect('/admin/Dashboard/sliders/');
		}
		
		$page_data['slider'] = $slider;
		
		$page_data['page_title'] = 'Edit slider';
		$this->load->view('default/admin/edit_slider',$page_data);
	}
	
	public function delete_slider($id){
		if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		
		$this->db->where('id', $id);
		$this->db->delete('sliders');
		
		redirect('/admin/Dashboard/sliders/');
	}
	
	
	
	

	
	public function categories(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Categories';
	    $page_data['categories'] = $this->Dashboard_modal->categories();
		$this->load->view('default/admin/categories',$page_data);
	}
	public function category_status_change()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	     $id=$this->input->get('id');
		$status=$this->input->get('status');
		$result = $this->Dashboard_modal->category_status_change($id,$status);
		$this->session->set_flashdata('success', 'Category Status Successfully Changed.');
		redirect('admin/Dashboard/categories');
	}
	public function delete_category()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $id=$this->input->get('id');
	    $result = $this->Dashboard_modal->delete_category($id);
		$this->session->set_flashdata('success', 'Category Successfully Delete.');
		redirect('admin/Dashboard/categories');
	}
	
	/*public function categories_datatable(){
		$this->load->library('datatable');
		
		$query = $this->db->from('categories');
		
		$this->datatable->set_column('image', function($row, $db){
			if(!$row['image']){
			    return '-';
			}
			
			return '<a href="'.base_url($row['image']).'" target="_blank"><img style="width:72px; height:72px; object-fit:cover;" src="'.base_url($row['image']).'"></a>';
		});
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == 'Active' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/category_status/'.$row['id']).'?status=\'+(this.checked ? \'Active\' : \'Inactive\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:void(0)" onclick="preview_modal(\''.base_url('/admin/Dashboard/category_json/'.$row['id']).'\', \'#preview_modal\', this, category_img_mw)">View</a>
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_category/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_category/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['image','status','action']);
		echo $this->datatable->run($query);
	}*/
	
	public function add_category(){
	if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Add Category';
	    $page_data['parrent_categories'] = $this->Dashboard_modal->parrent_categories();
		$this->load->view('default/admin/add_category',$page_data);
	}
	
	public function edit_category($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $page_data['category_datas'] = $this->db->get_where('categories',['id' => $id])->row_array();
	    $page_data['parrent_categories'] = $this->Dashboard_modal->parrent_categories();
	    $page_data['page_title'] = 'Edit Category';
		$this->load->view('default/admin/edit_category',$page_data);
	}
	
	public function update_category()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
     	$this->form_validation->set_rules('category_name','Category Name','required');
			
	        if( $this->form_validation->run() )
	        {
     $file = $this->input->upload( 'image', './uploads/categories/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) )
					{
						$this->db->set('image', $file['path']);
					}
		 $this->db->set([
								'category_name' 	=> $this->input->post('category_name'),
								'description' 		=> $this->input->post('description'),
								'parent_category' 	=> $this->input->post('parent_category'),
								'sort_order'		=> $this->input->post('sort_order'),
								'status'			=> $this->input->post('status'),
                                'meta_title'        => $this->input->post('meta_title'),
                                'meta_keyword'        => $this->input->post('meta_keyword'),
                                'meta_description'        => $this->input->post('meta_description')
							]);
			$this->db->where('id', $this->input->post('category_id'));			
			 $result = $this->db->update('categories');			
    		 if($result==true)
    		 {
    		     notify( 'Category has been successfully Updated.', 'success', 3 );
    		     redirect('admin/Dashboard/categories');
    		 }
	        }
    		 else
    		 {
    		     notify( strip_tags( validation_errors() ), 'warning', 3 );
    		     redirect('admin/Dashboard/add_category');
    		 }
		 
	}
	
	/*public function delete_category($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('id', $id);
	    $this->db->delete('categories');
	    
	    redirect('/admin/Dashboard/categories/');
	}*/
	
	public function category_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('categories');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function category_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('categories',['id' => $id])->row_array();
		if($student['image']){ $student['image'] = base_url($student['image']); }
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	
	    public function sub_categories(){
	        if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Sub-Categories';
	    
		$this->load->view('default/admin/sub_categories',$page_data);
	}

		public function banners()
		{
		    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Banners';
		$this->load->view('default/admin/banners',$page_data);
	}
	
	public function banners_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$query = $this->db->from('banners');
		
		$this->datatable->set_column('image', function($row, $db){
			if(!$row['image']){
			    return '-';
			}
			
			return '<a href="'.base_url($row['image']).'" target="_blank"><img style="width:72px; height:72px; object-fit:cover;" src="'.base_url($row['image']).'"></a>';
		});
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == 'Active' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/banner_status/'.$row['id']).'?status=\'+(this.checked ? \'Active\' : \'Inactive\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_banner/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_banner/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['image','status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_banner(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        $this->form_validation->set_rules('link','Link','required');
	        $this->form_validation->set_rules('priority','Priority','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$file = $this->input->upload( 'image', './uploads/banners/', [
						'allowed' => ['image/jpeg','image/png','image/gif'],
						'required' => true
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'link' => $this->input->post('link'),
						'priority' => $this->input->post('priority'),
						'banner_desc' => $this->input->post('desc'),
						'slug' => $this->slugify_db('banners', 'slug', $this->input->post('title'))
					]);
					$this->db->insert('banners');
					
					notify( 'Banner has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/banners/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title'] = 'Add Banner';
		$this->load->view('default/admin/add_banner',$page_data);
	}
	
	public function edit_banner($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        $this->form_validation->set_rules('link','Link','required');
	        $this->form_validation->set_rules('priority','Priority','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$file = $this->input->upload( 'image', './uploads/banners/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) ){
						$this->db->set('image', $file['path']);
					}
					
					$this->db->set([
						'title' => $this->input->post('title'),
						'link' => $this->input->post('link'),
						'priority' => $this->input->post('priority'),
						'banner_desc' => $this->input->post('desc'),
					]);
					$this->db->where('id',$id);
					$this->db->update('banners');
					
					notify( 'Banner has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/banners/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['slider'] = $this->db->get_where('banners',['id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit Banner';
		$this->load->view('default/admin/edit_banner',$page_data);
	}
	
	public function delete_banner($id){
	    
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('id', $id);
	    $this->db->delete('banners');
	    
	    redirect('/admin/Dashboard/banners/');
	}
	
	public function banner_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('banners');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function banner_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('banners',['id' => $id])->row_array();
		if($student['image']){ $student['image'] = base_url($student['image']); }
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	public function users()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Users';
		$this->load->view('default/admin/users',$page_data);
	}
	
	
	public function users_datatable()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $this->load->library('datatable');
		
		$query = $this->db->from('users');
			$this->datatable->set_column('first_name', function($row, $db){
			return $row['first_name'].' '.$row['last_name'] ;
		});
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == '1' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/user_status/'.$row['id']).'?status=\'+(this.checked ? \'1\' : \'0\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['first_name','status','action']);
		echo $this->datatable->run($query);
	}
	
	public function user_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('users');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function user_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('users',['id' => $id])->row_array();
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	
	public function sizes()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Sizes';
		$this->load->view('default/admin/sizes',$page_data);
	}
	
	public function sizes_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$query = $this->db->from('sizes');
		
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == '1' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/size_status/'.$row['id']).'?status=\'+(this.checked ? \'1\' : \'0\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_size/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_size/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_size(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        
	        
	        if( $this->form_validation->run() ){
	            try {
					
					
					$this->db->set([
						'name' => $this->input->post('title'),
						'slug' => $this->slugify_db('sizes', 'slug', $this->input->post('title'))
						]);
					$this->db->insert('sizes');
					
					notify( 'Size has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/sizes/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title'] = 'Add Size';
		$this->load->view('default/admin/add_size',$page_data);
	}
	
	public function edit_size($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        
	        
	        if( $this->form_validation->run() ){
	            try {
					$this->db->set([
						'name' => $this->input->post('title'),
					]);
					$this->db->where('id',$id);
					$this->db->update('sizes');
					
					notify( 'Size has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/sizes/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['slider'] = $this->db->get_where('sizes',['id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit Size';
		$this->load->view('default/admin/edit_size',$page_data);
	}
	
	public function delete_size($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $this->db->where('id', $id);
	    $this->db->delete('sizes');
	    redirect('/admin/Dashboard/sizes/');
	}
	
	public function size_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('sizes');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function size_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('sizes',['id' => $id])->row_array();
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	
	public function colors(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Sizes';
		$this->load->view('default/admin/colors',$page_data);
	}
	
	public function colors_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$query = $this->db->from('colors');
		
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == '1' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/color_status/'.$row['id']).'?status=\'+(this.checked ? \'1\' : \'0\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_color/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_color/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_color(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        
	        
	        if( $this->form_validation->run() ){
	            try {
					
					
					$this->db->set([
						'name' => $this->input->post('title'),
						'slug' => $this->slugify_db('colors', 'slug', $this->input->post('title'))
						]);
					$this->db->insert('colors');
					
					notify( 'Size has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/colors/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title'] = 'Add Size';
		$this->load->view('default/admin/add_color',$page_data);
	}
	
	public function edit_color($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        
	        
	        if( $this->form_validation->run() ){
	            try {
				
					
					$this->db->set([
						'name' => $this->input->post('title'),
						
					]);
					$this->db->where('id',$id);
					$this->db->update('colors');
					
					notify( 'Size has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/colors/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['slider'] = $this->db->get_where('colors',['id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit Size';
		$this->load->view('default/admin/edit_color',$page_data);
	}
	
	public function delete_color($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('id', $id);
	    $this->db->delete('colors');
	    
	    redirect('/admin/Dashboard/colors/');
	}
	
	public function color_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('colors');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function color_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('sizes',['id' => $id])->row_array();
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	
	public function app_pages(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'App Pages';
		$this->load->view('default/admin/app_pages',$page_data);
	}
	
	public function app_pages_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$query = $this->db->from('app_pages');
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == 'Active' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/app_page_status/'.$row['id']).'?status=\'+(this.checked ? \'Active\' : \'Inactive\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:void(0)" onclick="preview_modal(\''.base_url('/admin/Dashboard/app_page_json/'.$row['id']).'\', \'#preview_modal\', this, app_page_img_mw)">View</a>
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_app_page/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_app_page/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_app_page(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        $this->form_validation->set_rules('short_descr','Short Description','required');
	        $this->form_validation->set_rules('long_descr','Long Description','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_descr' => $this->input->post('short_descr'),
						'long_descr' => $this->input->post('long_descr'),
						'slug' => $this->slugify_db('app_pages', 'slug', $this->input->post('title'))
					]);
					$this->db->insert('app_pages');
					
					notify( 'App Page has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/app_pages/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title'] = 'Add App Page';
		$this->load->view('default/admin/add_app_page',$page_data);
	}
	
	public function edit_app_page($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('title','Title','required');
	        $this->form_validation->set_rules('short_descr','Short Description','required');
	        $this->form_validation->set_rules('long_descr','Long Description','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$this->db->set([
						'title' => $this->input->post('title'),
						'short_descr' => $this->input->post('short_descr'),
						'long_descr' => $this->input->post('long_descr'),
					]);
					$this->db->where('id',$id);
					$this->db->update('app_pages');
					
					notify( 'App Page has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/app_pages/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['slider'] = $this->db->get_where('app_pages',['id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit App Page';
		$this->load->view('default/admin/edit_app_page',$page_data);
	}
	
	public function delete_app_page($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('id', $id);
	    $this->db->delete('app_pages');
	    
	    redirect('/admin/Dashboard/app_pages/');
	}
	
	public function app_page_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('app_pages');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function app_page_json($id){
	    
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('app_pages',['id' => $id])->row_array();
		echo json_encode(['status' => 1, 'data' => $student]);
	}
	
	public function faqs(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'FAQs';
		$this->load->view('default/admin/faqs',$page_data);
	}
	
	public function faqs_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$query = $this->db->from('faqs');
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == 'Active' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/faq_status/'.$row['id']).'?status=\'+(this.checked ? \'Active\' : \'Inactive\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:void(0)" onclick="preview_modal(\''.base_url('/admin/Dashboard/faq_json/'.$row['id']).'\', \'#preview_modal\', this, faq_img_mw)">View</a>
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_faq/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_faq/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_faq(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('question','Question','required');
	        $this->form_validation->set_rules('answer','Answer','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$this->db->set([
						'question' => $this->input->post('question'),
						'answer' => $this->input->post('answer'),
						'priority' => $this->input->post('priority')
					]);
					$this->db->insert('faqs');
					
					notify( 'FAQ has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/faqs/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['page_title'] = 'Add FAQ';
		$this->load->view('default/admin/add_faq',$page_data);
	}
	
	public function edit_faq($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('question','Question','required');
	        $this->form_validation->set_rules('answer','Answer','required');
	        
	        if( $this->form_validation->run() ){
	            try {
					$this->db->set([
						'question' => $this->input->post('question'),
						'answer' => $this->input->post('answer'),
						'priority' => $this->input->post('priority')
					]);
					$this->db->where('id',$id);
					$this->db->update('faqs');
					
					notify( 'FAQ has been successfully updated.', 'success', 3 );
					redirect('/admin/Dashboard/faqs/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
	    $page_data['slider'] = $this->db->get_where('faqs',['id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit FAQ';
		$this->load->view('default/admin/edit_faq',$page_data);
	}
	
	public function delete_faq($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('id', $id);
	    $this->db->delete('faqs');
	    
	    redirect('/admin/Dashboard/faqs/');
	}
	
	public function faq_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('id', $id);
		$this->db->update('faqs');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function faq_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$student = $this->db->get_where('faqs',['id' => $id])->row_array();
		echo json_encode(['status' => 1, 'data' => $student]);
	}

	
	public function products(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Products';
		$this->load->view('default/admin/products',$page_data);
	}
	
	public function product_ajax()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $start=$this->input->get('start');
	    $length=$this->input->get('length');
	    $search=$this->input->get('search[value]');
	    $data_array=array();
	    $this->db->select('*');
        $this->db->from('products');
        if($this->input->get('search[value]'))
        {
           $search=$this->input->get('search[value]');
           $this->db->like('product_name', "%".$search."%");
        }
        $this->db->where('status', '1');
        $this->db->order_by("product_id" , "desc");
         $this->db->limit($length, $start);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $products = $query->result_array();
        
        
		$data_array=array();
		foreach($products as $product_row)
		{
		    $data_array1=array();
		    $size='';
		    $color='';
		    $product_image = $this->db->get_where('product_image', ['product_id' => $product_row['product_id']])->row_array();
		    $image='<img src="'.base_url().$product_image['image'].'" style="width:75px;height:75px;">';
		    $data_array1[]=$image;
		    $data_array1[]=$product_row['product_name'];
		    $data_array1[]=$product_row['price'];
		    $action='<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:void(0)" onclick="preview_modal(\''.base_url('/admin/Dashboard/product_json/'.$product_row['product_id']).'\', \'#preview_modal\', this, product_img_mw)">View</a>
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_product/'.$product_row['product_id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_product/'.$product_row['product_id']).'\')">Delete</a>
				</div>
			</div>';
		    
		    $product_size = $this->db->get_where('product_size', ['product_id' => $product_row['product_id']])->result_array();
		    foreach($product_size as $row)
		    {
		    $sizes = $this->db->get_where('sizes', ['slug' => $row['size']])->row_array();      
		    $size.=$sizes['name'].' - ';
		    }
		    $data_array1[]=trim($size, "- ");
		    $product_color = $this->db->get_where('product_color', ['product_id' => $product_row['product_id']])->result_array();
		    foreach($product_color as $row)
		    {
		    $colors = $this->db->get_where('colors', ['slug' => $row['color']])->row_array();       
		    $color.=$colors['name'].' - ';
		    }
		    $data_array1[]=rtrim($color, "- ");
		    
		    $data_array1[]=$action;
		    $arr['data'][]=$data_array1;
		}
		//$arr['data']=$data_array;
		$arr['draw']=2;
		$products_count = $this->db->get_where('products', ['status' => '1'])->result_array();
		$arr['recordsTotal']=count($products_count);
        }
        else
        {
        $arr['data']=$data_array;
		$arr['draw']=1;
		$products_count = $this->db->get_where('products', ['status' => '1'])->result_array();
		$arr['recordsTotal']=count($products_count);
		$arr['recordsFiltered']=0;
        }	$arr['recordsFiltered']=count($products);
	
		echo json_encode($arr);

	}
	
	public function products_datatable(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->load->library('datatable');
		
		$this->db->select('products.*, categories.name AS category, sub_categories.name AS subcategory');
		$this->db->join('categories','categories.id = products.category');
		$this->db->join('sub_categories','sub_categories.id = products.subcategory');
		$query = $this->db->from('products');
		
		$this->datatable->set_default_table('products');
		
		$this->datatable->set_filter('category', function($query, $category){
        	return $query->like('categories.name', $category);
        }, 'categories.name');
		
		$this->datatable->set_filter('subcategory', function($query, $category){
        	return $query->like('sub_categories.name', $category);
        }, 'sub_categories.name');
		
		$this->datatable->set_column('image', function($row, $db){
		    if( ! $row['image'] ){
		        return '';
		    }
			return '<img src="'.base_url($row['image']).'" style="width:72px; height:72px; object-fit:cover;">';
		});
		
		$this->datatable->set_column('status', function($row, $db){
			return '<div class="form-check form-switch mb-3" dir="ltr">
				<label class="form-check-label"><input type="checkbox" class="form-check-input" '.($row['status'] == 'Active' ? 'checked' : '').' onchange="confirm_ajax(\''.base_url('/admin/Dashboard/product_status/'.$row['id']).'?status=\'+(this.checked ? \'Active\' : \'Inactive\'))"></label>
			</div>';
		});
		
		$this->datatable->set_column('action', function($row, $db){
			return '<div class="dropdown">
				<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:void(0)" onclick="preview_modal(\''.base_url('/admin/Dashboard/product_json/'.$row['id']).'\', \'#preview_modal\', this, product_img_mw)">View</a>
					<a class="dropdown-item" href="'.base_url('/admin/Dashboard/edit_product/'.$row['id']).'">Edit</a>
					<a class="dropdown-item" href="javascript:void(0)" onclick="confirm_redirect(\''.base_url('/admin/Dashboard/delete_product/'.$row['id']).'\')">Delete</a>
				</div>
			</div>';
		}, 'id');
		
		$this->datatable->raw_columns(['image','status','action']);
		echo $this->datatable->run($query);
	}
	
	public function add_product(){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('product_name','Product Name','required');
			$this->form_validation->set_rules('price','Price','required');
			$this->form_validation->set_rules('size[]','Size','required');
	        $this->form_validation->set_rules('color[]','Color','required');
			$this->form_validation->set_rules('category[]','Category','required');
			$this->form_validation->set_rules('product_desc','Product Description','required');
			
			
	        if( $this->form_validation->run() ){
	            try {
					
					$this->db->set([
						'product_name' => $this->input->post('product_name'),
						'style' => $this->input->post('style'),
						'off' => $this->input->post('off'),
						'price' => $this->input->post('price'),
						'offer_price' => $this->input->post('offer_price'),
						'category' => implode(",",$this->input->post('category')),
						'product_desc' => $this->input->post('product_desc'),
						'offer_desc' => $this->input->post('offer_desc'),
						'specification' => $this->input->post('specification'),
						'slug' => $this->slugify_db('products', 'slug', $this->input->post('product_name'))
					]);
					$this->db->insert('products');
					$product_id = $this->db->insert_id();
					
					/*Size Variations */
					foreach($this->input->post('size') as $size)
					{
					   	        $this->db->set([
                						'product_id' => $product_id,
                						'size' => $size,
                						]);
                					$this->db->insert('product_size');  
					}
					
					/*End Size Variation*/
					
					/*color Variations */
					foreach($this->input->post('color') as $color)
					{
					   	        $this->db->set([
                						'product_id' => $product_id,
                						'color' => $color,
                						]);
                					$this->db->insert('product_color');  
					}
					
					/*End color Variation*/
					
					/*image upload start*/
                if($_FILES['product_image']['name'])
                {
                $this->load->library('upload');
                  $image = array();
                  $ImageCount = count($_FILES['product_image']['name']);
                        for($i = 0; $i < $ImageCount; $i++){
                            $_FILES['file']['name']       = $_FILES['product_image']['name'][$i];
                            $_FILES['file']['type']       = $_FILES['product_image']['type'][$i];
                            $_FILES['file']['tmp_name']   = $_FILES['product_image']['tmp_name'][$i];
                            $_FILES['file']['error']      = $_FILES['product_image']['error'][$i];
                            $_FILES['file']['size']       = $_FILES['product_image']['size'][$i];
                
                            // File upload configuration
                            $uploadPath = './uploads/products/';
                            $config['upload_path'] = $uploadPath;
                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
                
                            // Load and initialize upload library
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                
                            // Upload file to server
                            if($this->upload->do_upload('file')){
                                // Uploaded file data
                                $imageData = $this->upload->data();
                                
                        if(!empty($imageData))
                        {
                            // Insert files data into the database
                           	$this->db->set([
                						'product_id' => $product_id,
                						'image' => $uploadPath.$imageData['file_name'],
                						]);
                					$this->db->insert('product_image');   
                        }
                            }    
                                
                            }
                        }
					/*image upload end*/
					
					
					
					notify( 'Product has been successfully added.', 'success', 3 );
					redirect('/admin/Dashboard/products/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    
		
		
		$this->db->order_by('category_name','ASC');
		$page_data['categories'] = $this->db->get_where('categories', ['status' => '1'])->result_array();
		$page_data['sizes'] = $this->db->get_where('sizes', ['status' => '1'])->result_array();
		$page_data['colors'] = $this->db->get_where('colors', ['status' => '1'])->result_array();
	    $page_data['page_title'] = 'Add Product';
		$this->load->view('default/admin/add_product',$page_data);
	}
	
	public function edit_product($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    if( $this->input->method() == 'post' ){
	        $this->load->library('form_validation');
	        
	        $this->form_validation->set_rules('product_name','Product Name','required');
			$this->form_validation->set_rules('price','Price','required');
			$this->form_validation->set_rules('size[]','Size','required');
	        $this->form_validation->set_rules('color[]','Color','required');
			$this->form_validation->set_rules('category[]','Category','required');
			$this->form_validation->set_rules('product_desc','Product Description','required');
			
			
	        if( $this->form_validation->run() ){
	            try {
					
					$this->db->set([
						'product_name' => $this->input->post('product_name'),
						'style' => $this->input->post('style'),
						'off' => $this->input->post('off'),
						'price' => $this->input->post('price'),
						'offer_price' => $this->input->post('offer_price'),
						'category' => implode(",",$this->input->post('category')),
						'product_desc' => $this->input->post('product_desc'),
						'offer_desc' => $this->input->post('offer_desc'),
						'specification' => $this->input->post('specification'),
					]);
					$this->db->where('product_id', $id);
					$this->db->update('products');

					/*Size Variations */
					$this->db->where('product_id', $id);
	                $this->db->delete('product_size');
					foreach($this->input->post('size') as $size)
					{
					   	        $this->db->set([
                						'product_id' => $id,
                						'size' => $size,
                						]);
                					$this->db->insert('product_size');  
					}
					
					/*End Size Variation*/
					
					/*color Variations */
					$this->db->where('product_id', $id);
	                $this->db->delete('product_color');
					foreach($this->input->post('color') as $color)
					{
					   	        $this->db->set([
                						'product_id' => $id,
                						'color' => $color,
                						]);
                					$this->db->insert('product_color');  
					}
					
					/*End color Variation*/
					
					/*image upload start*/
				$this->db->where('product_id', $id);
				$this->db->where('status', '0');
	                $this->db->delete('product_image');	
                if($_FILES['product_image']['name'])
                {
                    
                    
                $this->load->library('upload');
                  $image = array();
                  $ImageCount = count($_FILES['product_image']['name']);
                        for($i = 0; $i < $ImageCount; $i++){
                            $_FILES['file']['name']       = $_FILES['product_image']['name'][$i];
                            $_FILES['file']['type']       = $_FILES['product_image']['type'][$i];
                            $_FILES['file']['tmp_name']   = $_FILES['product_image']['tmp_name'][$i];
                            $_FILES['file']['error']      = $_FILES['product_image']['error'][$i];
                            $_FILES['file']['size']       = $_FILES['product_image']['size'][$i];
                
                            // File upload configuration
                            $uploadPath = './uploads/products/';
                            $config['upload_path'] = $uploadPath;
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                
                            // Load and initialize upload library
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                           
                            // Upload file to server
                            if($this->upload->do_upload('file')){
                                // Uploaded file data
                                $errors = $this->upload->display_errors();
                                $imageData = $this->upload->data();
                                 
                        if(!empty($imageData))
                        {
                            // Insert files data into the database
                           	$this->db->set([
                						'product_id' => $id,
                						'image' => $uploadPath.$imageData['file_name'],
                						]);
                					$this->db->insert('product_image');   
                        }
                            }    
                                
                            }
                        }
					/*image upload end*/
					
					
					
					notify( 'Product has been successfully Updated.', 'success', 3 );
					redirect('/admin/Dashboard/products/');
				} catch (\Exception $e){ 
					notify( $e->getMessage(), 'warning', 3 );
				}
	        } else {
	            notify( strip_tags( validation_errors() ), 'warning', 3 );
	        }
	    }
	    

		
		$this->db->order_by('category_name','ASC');
		$page_data['categories'] = $this->db->get_where('categories', ['status' => '1'])->result_array();
		$page_data['sizes'] = $this->db->get_where('sizes', ['status' => '1'])->result_array();
		$page_data['colors'] = $this->db->get_where('colors', ['status' => '1'])->result_array();
	    $page_data['product'] = $this->db->get_where('products',['product_id' => $id])->row_array();
	    $page_data['page_title'] = 'Edit Product';
		$this->load->view('default/admin/edit_product',$page_data);
	}
	
	public function delete_product($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    
	    $this->db->where('product_id', $id);
	    $this->db->delete('products');
	    $this->db->where('product_id', $id);
	    $this->db->delete('product_color');
	    $this->db->where('product_id', $id);
	    $this->db->delete('product_size');
	    $this->db->where('product_id', $id);
	    $this->db->delete('product_image');
	    
	    redirect('/admin/Dashboard/products/');
	}
	
	public function products_image_del()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $id=$this->input->post('id');
	    $this->db->set('status', '0');
		$this->db->where('image_id', $id);
		$this->db->update('product_image');
		return true;
	}
	
	public function product_status($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->set('status', $this->input->get('status'));
		$this->db->where('product_id', $id);
		$this->db->update('products');
		
		echo json_encode(['status' => 1, 'message' => 'Status has been successfully updated.']);
	}
	
	public function product_json($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $product_row = $this->db->get_where('products', ['product_id' => $id])->row_array();
		$data_array=array();
		
		    $data_array1=array();
		    $size=array();
		    $color=array();
		    $image=array();
		    $product_image = $this->db->get_where('product_image', ['product_id' => $product_row['product_id']])->result_array();
		    foreach($product_image as $row)
		    {
		    $image[]=$row['image'];
		    }
		    
		    
		    $product_size = $this->db->get_where('product_size', ['product_id' => $product_row['product_id']])->result_array();
		    foreach($product_size as $row)
		    {
		    $sizes = $this->db->get_where('sizes', ['slug' => $row['size']])->row_array();
		    $size[]=$sizes['name'];
		    }
		    
		    $product_color = $this->db->get_where('product_color', ['product_id' => $product_row['product_id']])->result_array();
		    foreach($product_color as $row)
		    {
		    $colors = $this->db->get_where('colors', ['slug' => $row['color']])->row_array();
		    $color[]=$colors['name'];
		    }
		    $cate_name=array();
		    $cate_slug=explode(",",$product_row['category']);
		    for($i=0;$i<count($cate_slug);$i++)
    		{
    		   $category = $this->db->get_where('categories', ['category_slug' => $cate_slug[$i]])->row_array(); 
    		   $cate_name[]=$category['category_name'];
    		}
		 ?>
		 <div class="modal-header">
    				<h5 class="modal-title"><?=$product_row['product_name']?></h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
    				<table class="table table-bordered">
    					<tr>
    						<th style="max-width: 150px;">Name</th>
    						<td><?=$product_row['product_name']?></td>
    					</tr>
    					<tr>
    						<th>Images</th>
    						<td>
    						  <?php
    						  for($i=0;$i<count($image);$i++)
    						  {
    						      ?>
    						      <img src="<?=base_url()?><?=$image[$i]?>" width="75px;" height="75px;">
    						      <?php
    						  }
    						  ?>
    						 </td>
    					</tr>
    					<tr>
    						<th>Style</th>
    						<td><?=$product_row['style']?></td>
    					</tr>
    					<tr>
    						<th>Off %</th>
    						<td><?=$product_row['off']?> %</td>
    					</tr>
    					<tr>
    						<th>Price</th>
    						<td>Rs. <?=$product_row['price']?></td>
    					</tr>
						<tr>
    						<th>Offer Price</th>
    						<td>Rs. <?=$product_row['offer_price']?></td>
    					</tr>
    					<tr>
    						<th>Category</th>
    						<td><?=implode(" | ",$cate_name)?></td>
    					</tr>
    					<tr>
    						<th>Size</th>
    						<td><?=implode(" | ",$size)?></td>
    					</tr>
    					<tr>
    						<th>Color</th>
    						<td><?=implode(" | ",$color)?></td>
    					</tr>
						<tr>
    						<th>Description</th></th>
    						<td><?=$product_row['product_desc']?></td>
    					</tr>
    					<tr>
    						<th>Offer Description</th>
    						<td><?=$product_row['offer_desc']?></td>
    					</tr>
    					<tr>
    						<th>Specification</th>
    						<td><?=$product_row['specification']?></td>
    					</tr>
    					<tr>
    						<th>Stock</th>
    						<td><?=$product_row['stock']?></td>
    					</tr>
    					<tr>
    						<th>Date</th>
    						<td><?=$product_row['date']?></td>
    					</tr>
    				</table>
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    			</div>
    				<?php
		$arr['data']=$product_row;
		$arr['data_color']=$color;
		$arr['data_size']=$size;
		$arr['data_image']=$image;
	
		//echo json_encode($arr);

	}
	
	public function get_categories($id){
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
		$this->db->select('id, name AS text');
		$this->db->where('parent_id', $id);
		$this->db->where('status','Active');
		$this->db->order_by('name','ASC');
		$sub_categories = $this->db->get('sub_categories')->result_array();
		echo json_encode($sub_categories);
	}
	
	public function insert_category()
	{
	    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $text=$this->input->post('category_name');
	    $slug = $slug = $this->slugify($text);
     $total_row = $this->db->select('*')->from('categories')->where("category_slug LIKE '$slug%'")->get()->num_rows();
     	$this->form_validation->set_rules('category_name','Category Name','required');
			
	        if( $this->form_validation->run() )
	        {
     $file = $this->input->upload( 'image', './uploads/categories/', [
						'allowed' => ['image/jpeg','image/png','image/gif']
					] );
					
					if( isset($file) )
					{
						$this->db->set('image', $file['path']);
					}
		 $this->db->set([
								'category_name' 	=> $this->input->post('category_name'),
								'category_slug'=>$slug,
								'description' 		=> $this->input->post('description'),
								'parent_category' 	=> $this->input->post('parent_category'),
								'sort_order'		=> $this->input->post('sort_order'),
								'status'			=> $this->input->post('status'),
                                'meta_title'        => $this->input->post('meta_title'),
                                'meta_keyword'        => $this->input->post('meta_keyword'),
                                'meta_description'        => $this->input->post('meta_description')
							]);
						
			 $result = $this->db->insert('categories');			
    		 if($result==true)
    		 {
    		     notify( 'Category has been successfully added.', 'success', 3 );
    		     redirect('admin/Dashboard/categories');
    		 }
	        }
    		 else
    		 {
    		     notify( strip_tags( validation_errors() ), 'warning', 3 );
    		     redirect('admin/Dashboard/add_category');
    		 }
		 
	}
	
public function orders()
{
        if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $page_data['page_title'] = 'Orders';
		$this->load->view('default/admin/orders',$page_data);
        
}

public function get_orders()
{
    if( ! $this->session->userdata('login_user') ){
	        redirect('/admin/Auth/login/');
	        die;
	    }
	    $params = $_REQUEST;
	    $date_sort=$params['order'][0]['dir'];
	    $sort_arr='';
	    $sort_type='';
	    if($params['order'][0]['column']==1)
	    {
	        $sort_arr='order_date';
	       $sort_type= $params['order'][0]['dir'];    
	    }
	    if($params['order'][0]['column']==2)
	    {
	        $sort_arr='order_pid';
	       $sort_type= $params['order'][0]['dir'];    
	    }
	    if($params['order'][0]['column']==3)
	    {
	        $sort_arr='order_net_amount';
	       $sort_type= $params['order'][0]['dir'];    
	    }

        if($params['order'][0]['column']==4)
	    {
	        $sort_arr='order_status';
	       $sort_type= $params['order'][0]['dir'];    
	    }        $search='';
        $start=$_POST['start'];
        $limit=$_POST['length'];
        $min=$_POST['min'];
        $max=$_POST['max'];
    $get_data = $this->Dashboard_modal->orders_data($start,$limit,$search,$min,$max,$sort_arr,$sort_type);
$tot_record = $this->Dashboard_modal->orders_data_tot($search,$min,$max);
$data=array();  
        if($get_data)
        {
        $i = $_POST['start'];
        foreach($get_data as $row){
            $i++;
            $created = $time = date("m/d/Y h:i:s",$row['order_date']);
            $status ='<select class="status_change" name="status_change" id="status_change_'.$row['order_pid'].'">';
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Pending') { $status .='selected '; }
            $status .='value="Pending">Pending</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Approved') { $status .='selected '; }
            $status .='value="Approved">Approved</option>';
            
             $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Processing') { $status .='selected '; }
            $status .='value="Processing">Processing</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Packed') { $status .='selected '; }
            $status .='value="Packed">Packed</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Picked') { $status .='selected '; }
            $status .='value="Picked">Picked</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Shipped') { $status .='selected '; }
            $status .='value="Shipped">Shipped</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Cancelled') { $status .='selected '; }
            $status .='value="Cancelled">Cancelled</option>';
            
            $status .='<option odid="'.$row['order_pid'].'" value="Delivered"';
            if($row['order_status']=='Delivered') { $status .='selected '; }
             $status .='>Delivered</option>';
             
            $status .='<option odid="'.$row['order_pid'].'" ';
            if($row['order_status']=='Cancelled') { $status .='selected '; }
            $status .='value="Cancelled">Cancelled</option>'; 
             
            $status .='</select>';
            $action='<button class="button hvr-float-shadow" onclick="view_order_info('.$row['order_pid'].')">View</button>';
            $data[] = array($i,$created, $row['order_pid'], $row['order_net_amount'], $status,$action);
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
                <td class="right">Rs.' . $item_row->offer_price . '</td>
                <td class="center">' . $item_row->qty . '</td>
                <td class="right">Rs.' . $item_row->offer_price*$item_row->qty . '</td>
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
	public function order_status()
	{
	               $this->db->set('order_status',$this->input->post('status'));
					$this->db->where('order_pid', $this->input->post('product_id'));
					$this->db->update('master_orders');
					$order_id=$this->input->post('product_id');
					$this->ordermail($order_id);
		$output = array(
            'message' => "success",
        );
        echo json_encode($output);
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
      $this->email->to($order_row->billing_email);// change it to yours
      $this->email->subject('Order '.$order_row->order_status);
      $this->email->message($body_content);
      $this->email->send();
      

        }
	
	
}
