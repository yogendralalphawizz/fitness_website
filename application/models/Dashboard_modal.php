<?php

class Dashboard_modal extends CI_Model {
    public function __construct() {
        
        $this->load->database();
        
    }
    
    public function parrent_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('status', '1');
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
    public function categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('status','1');
        $this->db->order_by('id', 'desc');
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
    public function delete_category($id)
    {
        $this->db->query("delete  from categories where id='".$id."'");
		$this->db->set('parent_category','');
		$this->db->where('parent_category', $id);
		$this->db->update('categories');
		$this->db->last_query();
		return ($this->db->affected_rows() != 1) ? false : true;
    }
    public function get_parent_category($parent)
    {
    	$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('id',$parent);
		$query = $this->db->get();
		//$this->db->last_query();
		$query->num_rows();
		if ( $query->num_rows() > 0 )
		{
			$row = $query->result_array();
			return $row;
		}
		else
		{
			$error=false;
			return $error;
		}
    }
    
    public function category_status_change($id,$status)
    {
        if($status==1)
        {
            $status=0;
        }
        else
        {
            $status=1;
        }
        $this->db->set('status', $status);
        $this->db->where('id', $id);			
		$result = $this->db->update('categories');
    }
    
     public function orders_data($start,$limit,$search,$min,$max,$sort_arr,$sort_type)
    {
        
      $this->db->select('*');
        $this->db->from('master_orders');
        $this->db->where('data_store','full');
        $this->db->where('payment_status','paid');
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
        if($sort_arr)
        {
        $this->db->order_by($sort_arr,$sort_type);
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
    
    public function orders_data_tot($search,$min,$max)
    {
        $this->db->select('*');
        $this->db->from('master_orders');
        $this->db->where('data_store','full');
        $this->db->where('payment_status','paid');
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
    
}    
