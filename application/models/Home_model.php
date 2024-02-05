<?php

class Home_model extends CI_Model {
    public function __construct() {
        
        $this->load->database();
        
    }
    
    public function categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('status','1');
        $this->db->order_by('sort_order', 'asc');
        
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }
    }
    
    public function products_slider()
    {
        $this->db->select('products.*');
        $this->db->from('products');
        $this->db->where('products.status','1');
        $this->db->limit(15);
        $this->db->order_by("product_id", "desc");
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }
    }
    
    public function wishlist($userid)
    {
        $this->db->select('*');
        $this->db->from('wishlist');
        $this->db->where('wishlist_user_id',$userid);
        $this->db->order_by("wishlist_id", "desc");
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else 
        {
            $error = false;
            return $error;
        }
    }
    public function off_products_slider()
    {
        $this->db->select('products.*');
        $this->db->from('products');
        $this->db->where('products.status','1');
        $this->db->where('products.off >=','50');
        $this->db->limit(30);
        $this->db->order_by("product_id", "desc");
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }
    }
    public function new_arrival_products($search,$category,$size,$color,$price,$sort_by,$count,$page)
    {
        $product_arr_cat_id=array(0.1);
        $product_arr_size_id=array(0.1);
        $product_arr_color_id=array(0.1);
        if($category)
        {
        $cat_arr_slug=explode(",",$category);
        $cat_arr_id='';
        for($i=0;$i<count($cat_arr_slug);$i++)
        {
        
        $this->db->select('product_id');
        $this->db->from('products');
        
        $this->db->like('category', $cat_arr_slug[$i], 'both');
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_cat_id[]=$row_product_id['product_id'];
        }
        }
        }
        if($size)
        {
        $size_arr_slug=explode(",",$size);
        $size_arr_id=array();
        for($i=0;$i<count($size_arr_slug);$i++)
        {
        $this->db->select('product_id');
        $this->db->from('product_size');
        $this->db->where('size', $size_arr_slug[$i]);
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_size_id[]=$row_product_id['product_id'];
        }
            
        }
        }
        
        if($color)
        {
        $color_arr_slug=explode(",",$color);
        $color_arr_id=array();
        for($i=0;$i<count($color_arr_slug);$i++)
        {
        $this->db->select('product_id');
        $this->db->from('product_color');
        $this->db->where('color', $color_arr_slug[$i]);
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_color_id[]=$row_product_id['product_id'];
        }
            
        }
        }
        $price_arr=explode(",",$price);
        if(count($price_arr)==2)
        {
        $min_price=$price_arr[0];
        $max_price=$price_arr[1];
        }
        else
        {
           $min_price=$price; 
        }
        $this->db->select('products.*');
        $this->db->from('products');
        //$this->db->join('product_image', 'products.product_id = product_image.product_id', 'right outer');
        //$this->db->join('product_size', 'products.product_id = product_size.product_id', 'right outer');
        if($search!='')
        {
        $this->db->like('category', $search);
        $this->db->or_like('product_name', $search);
        $this->db->or_like('product_desc', $search);
        }
        $this->db->where('products.status','1');
        if($category !='')
        {
        $this->db->where_in('products.product_id', $product_arr_cat_id);
        }
        if($size !='' )
        {
        $this->db->where_in('products.product_id', $product_arr_size_id);
        }
        if($color!='' )
        {
        $this->db->where_in('products.product_id', $product_arr_color_id);
        }
        if(isset($min_price) && $min_price>=1)
        {
            
            $array = "( products.offer_price >= $min_price)";
            $this->db->where($array);
        }
        if(isset($max_price))
        {
            $array = "( products.offer_price <= $max_price )";
            $this->db->where($array);
        }
        $start=0;
        if($page=1)
        {
            $start=0;
        }
        else
        {
           $start= $count*($page-1)+1;
        }
        if($sort_by=='default')
        {
            $this->db->order_by('rand()');
        }
        else if($sort_by=='date')
        {
            $this->db->order_by('date','DESC');
        }
        else if($sort_by=='price-low')
        {
            $this->db->order_by('offer_price','DESC');
        }
        else if($sort_by=='price-high')
        {
            $this->db->order_by('offer_price','ASC');
        }
        else
        {
           $this->db->order_by('rand()'); 
        }
        $this->db->limit($count, $start);
        $query = $this->db->get();
       //echo $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    public function new_arrival_total_products($search,$category,$size,$color,$price,$sort_by,$count,$page)
    {
        $product_arr_cat_id=array(0.1);
        $product_arr_size_id=array(0.1);
        $product_arr_color_id=array(0.1);
        if($category)
        {
        $cat_arr_slug=explode(",",$category);
        $cat_arr_id='';
        for($i=0;$i<count($cat_arr_slug);$i++)
        {
        
        $this->db->select('product_id');
        $this->db->from('products');
        $this->db->like('category', $cat_arr_slug[$i], 'both');
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_cat_id[]=$row_product_id['product_id'];
        }
        }
        }
        if($size)
        {
        $size_arr_slug=explode(",",$size);
        $size_arr_id=array();
        for($i=0;$i<count($size_arr_slug);$i++)
        {
        $this->db->select('product_id');
        $this->db->from('product_size');
        $this->db->where('size', $size_arr_slug[$i]);
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_size_id[]=$row_product_id['product_id'];
        }
            
        }
        }
        
        if($color)
        {
        $color_arr_slug=explode(",",$color);
        $color_arr_id=array();
        for($i=0;$i<count($color_arr_slug);$i++)
        {
        $this->db->select('product_id');
        $this->db->from('product_color');
        $this->db->where('color', $color_arr_slug[$i]);
        $query = $this->db->get();
        $row = $query->result_array();
        foreach($row as $row_product_id)
        {
            $product_arr_color_id[]=$row_product_id['product_id'];
        }
            
        }
        }
        $price_arr=explode(",",$price);
        if(count($price_arr)==2)
        {
        $min_price=$price_arr[0];
        $max_price=$price_arr[1];
        }
        else
        {
           $min_price=$price; 
        }
        $this->db->select('products.*');
        $this->db->from('products');
        //$this->db->join('product_image', 'products.product_id = product_image.product_id', 'right outer');
        //$this->db->join('product_size', 'products.product_id = product_size.product_id', 'right outer');
        
        $this->db->where('products.status','1');
        if($search!='')
        {
        $this->db->like('category', $search);
        $this->db->or_like('product_name', $search);
        $this->db->or_like('product_desc', $search);
        }
        if($category !='')
        {
        $this->db->where_in('products.product_id', $product_arr_cat_id);
        }
        if($size !='' )
        {
        $this->db->where_in('products.product_id', $product_arr_size_id);
        }
        if($color!='' )
        {
        $this->db->where_in('products.product_id', $product_arr_color_id);
        }
        if(isset($min_price) && $min_price>=1)
        {
            
            $array = "( products.offer_price >= $min_price)";
            $this->db->where($array);
        }
        if(isset($max_price))
        {
            $array = "( products.offer_price <= $max_price )";
            $this->db->where($array);
        }
       
        $query = $this->db->get();
       //echo $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function new_arrival_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('status','1');
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function new_arrival_sizes()
    {
        $this->db->select('*');
        $this->db->from('sizes');
        $this->db->where('status','1');
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function new_arrival_colors()
    {
        $this->db->select('*');
        $this->db->from('colors');
        $this->db->where('status','1');
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function banners()
    {
         $this->db->select('*');
        $this->db->from('banners');
        $this->db->where('status','1');
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }
    }
    
    public function product_detail($product_slug)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->like('slug',$product_slug);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    public function product_images($product_id)
    {
       $this->db->select('*');
        $this->db->from('product_image');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }  
    }
    
    public function product_sizes($product_id)
    {
        $this->db->select('*');
        $this->db->from('product_size');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    public function product_colors($product_id)
    {
        $this->db->select('*');
        $this->db->from('product_color');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function product_match($product_id)
    {
    $category_row = $this->db->get_where('products', ['product_id' => $product_id])->row_array();
    $category=$category_row['category'];
    $cat_arr=explode(",",$category);
    $this->db->select('*');
        $this->db->from('products');
        for($i=0;$i<count($cat_arr);$i++)
        {
        $this->db->or_like('category',$cat_arr[$i]);
        }
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        } 
    }
    
    public function profile_data($userid)
    {
      $query = $this->db->query("SELECT * FROM `users` where id=$userid");
        $data = $query->row_array() ; 
        return $data;
    }
    
    public function orders_data($userid='',$start='',$limit='',$search='',$min='',$max='')
    {
        
      $this->db->select('*');
        $this->db->from('master_orders');
        $this->db->where('data_store','full');
        $this->db->where('payment_status','paid');
        $this->db->where('order_by_user',$userid);
        if($search!='')
        {
          $this->db->where('order_pid',$search);  
        }
        if($min!='')
        {
            $this->db->where('order_date >=',strtotime($min));
        }
        if($max!='')
        {
            $this->db->where('order_date <=',strtotime($max));
        }
         $this->db->limit($limit,$start);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else {
            $error = false;
            return $error;
        }
    }
    
    public function orders_data_tot($userid,$search,$min,$max)
    {
        $this->db->select('*');
        $this->db->from('master_orders');
        $this->db->where('data_store','full');
        $this->db->where('payment_status','paid');
        $this->db->where('order_by_user',$userid);
         if($search!='')
        {
          $this->db->where('order_pid',$search);  
        }
        if($min!='')
        {
            $this->db->where('order_date >=',strtotime($min));
        }
        if($max!='')
        {
            $this->db->where('order_date <=',strtotime($max));
        }
        $query = $this->db->get();
        $this->db->last_query();
        return $query->num_rows();
        
    }
    
    public function cart_detail() {
        $userid = $this->session->userdata('user_id');
        $query = $this->db->query("SELECT * FROM `cart` where userid=$userid");
        $data = $query->result_array();
        return $data;
    }
    
    public function pages($page_slug)
    {
        $this->db->select('*');
        $this->db->from('app_pages');
        $this->db->where('slug',$page_slug);
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
        else 
        {
            $error = false;
            return $error;
        } 
    }
    
    public function faqs()
    {
        $this->db->select('*');
        $this->db->from('faqs');
        $this->db->where('status','Active');
        $this->db->order_by('priority', 'asc');
        $query = $this->db->get();
        $this->db->last_query();
        $query->num_rows();
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
        else 
        {
            $error = false;
            return $error;
        }
    }

}    