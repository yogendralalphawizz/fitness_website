<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable {
	protected $request;
	protected $filters;
	protected $extra_columns;
	protected $raw_columns;
	protected $escaper;
	protected $table;
	
	public function __construct(){
		$this->reset();
	}
	
	public function set_default_table($table){
	    $this->table = $table;
	    return $this;
	}
	
	public function set_request( $request ){
		$this->request = $request;
		return $this;
	}
	
	public function set_escaper( $escaper ){
		$this->escaper = $escaper;
		return $this;
	}
	
	public function set_column( $column, $callback, $order_by = false ){
		if( $order_by === false ){ $order_by = $column; }
		$this->extra_columns[ $column ] = [ $callback, $order_by ];
		return $this;
	}
	
	public function set_filter( $column, $callback, $order_by = false ){
		$this->filters[ $column ] = [ $callback, $order_by ];
		return $this;
	}
	
	public function raw_columns( array $columns ){
		$this->raw_columns = $columns;
		return $this;
	}

	public function run( $query ){
		$query_clone = clone $query;

		$total_query = $query_clone->get_compiled_select('', false);
		$first_row = $query->query($total_query)->row_array();
		$total_num_rows = $query->query($total_query)->num_rows();

		$draw = isset ( $this->request['draw'] ) ? intval( $this->request['draw'] ) : 0;

		if( ! $first_row ){
			return json_encode( array(
				'draw' => $draw,
				'recordsTotal' => 0,
				'recordsFiltered' => 0,
				'data' => [],
				'query' => (ENVIRONMENT == 'development') ? trim(preg_replace('/\s+/', ' ', $total_query)) : ''
			) );
		}
		
		foreach($first_row as $column => $value){
			$columns[ $column ] = $column;
		}

		foreach($this->extra_columns as $column => $value){
			$columns[ $column ] = $value[1];
		}
		
		if ( isset( $this->request['columns'] ) ) {
			$is_single_filtered = false;
			
			$query_clone->group_start();
			for ( $i = 0, $ien = count($this->request['columns']); $i < $ien; $i++ ) {
				$requestColumn = $this->request['columns'][$i];
				$str = $requestColumn['search']['value'];

				if ( $str != '' && $requestColumn['searchable'] == 'true' && ! isset( $columns[ $requestColumn['data'] ] ) ) {
					$is_single_filtered = true;
					
					$query_clone->group_start();
					if( isset( $this->filters[ $requestColumn['data'] ] ) ){
						call_user_func($this->filters[ $requestColumn['data'] ][0], $query_clone, $str);
					} else if( $requestColumn['search']['regex'] == 'false' ){
						$query_clone->like($this->_get_default_table() . $requestColumn['data'], $str);
					} else {
						$query_clone->where($this->_get_default_table() . $requestColumn['data'] . ' REGEXP "' . addslashes($str) . '"');
					}
					$query_clone->group_end();
				}
			}
			
			if( $is_single_filtered === false ){
				$query_clone->where('1 = 1');
			}
			
			$query_clone->group_end();
		}
		
		if ( isset($this->request['search']) && $this->request['search']['value'] != '' ) {
			$str = $this->request['search']['value'];
			
			$query_clone->group_start();
			for ( $i = 0, $ien = count($this->request['columns']); $i < $ien; $i++ ) {
				$requestColumn = $this->request['columns'][$i];

				if ( $requestColumn['searchable'] == 'true' && isset( $columns[ $requestColumn['data'] ] ) ) {
					$query_clone->or_group_start();
					if( isset( $this->filters[ $requestColumn['data'] ] ) ){
						$query_clone = call_user_func($this->filters[ $requestColumn['data'] ][0], $query_clone, $str);
					} else if( $requestColumn['search']['regex'] == 'false' ){
						$query_clone->like($this->_get_default_table() . $requestColumn['data'], $str);
					} else {
						$query_clone->where($this->_get_default_table() . $requestColumn['data'] . ' REGEXP "' . addslashes($str) . '"');
					}
					$query_clone->group_end();
				}
			}
			$query_clone->group_end();
		}
		
		foreach($this->filters as $column => $value){
			if( $value[1] !== false ){
				$columns[ $column ] = $value[1];
			}
		}
		
		if ( isset($this->request['order']) && count($this->request['order']) ) {
			$orderBy = array();
			
			for ( $i = 0, $ien = count($this->request['order']); $i < $ien; $i++ ) {
				$columnIdx = intval($this->request['order'][$i]['column']);
				$requestColumn = $this->request['columns'][$columnIdx];

				if ( $requestColumn['orderable'] == 'true' && isset( $columns[ $requestColumn['data'] ] ) ) {
					$dir = $this->request['order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
					$orderBy[] = $columns[ $requestColumn['data'] ].' '.$dir;
				}
			}

			if ( count( $orderBy ) ) {
				$query_clone->order_by( implode(', ', $orderBy) );
			}
		}

		$filtered_query = $query_clone->get_compiled_select('', false);
		$filtered_num_rows = $query->query($filtered_query)->num_rows();

		if( $filtered_num_rows == 0 ){
			return json_encode( array(
				'draw' => $draw,
				'recordsTotal' => $total_num_rows,
				'recordsFiltered' => 0,
				'data' => [],
				'query' => (ENVIRONMENT == 'development') ? trim(preg_replace('/\s+/', ' ', $filtered_query)) : ''
			) );
		}

		if ( isset($this->request['start']) && $this->request['length'] != -1 ) {
			$query_clone->limit(intval($this->request['length']), intval($this->request['start']));
		}

		$filtered_rows_limited = $query->query( $query_clone->get_compiled_select() )->result_array();
		
		$query->reset_query();
		
		foreach($filtered_rows_limited as &$filtered_row){
			$formatted = $filtered_row;

			foreach($this->extra_columns as $column => $extra_column_value){
				$formatted[ $column ] = call_user_func($extra_column_value[0], $filtered_row, $query);
			}

			foreach($formatted as $column => &$value){
				if( ! in_array($column, $this->raw_columns) ){
					$value = call_user_func($this->escaper, $value);
				}
			}

			$filtered_row = $formatted;
			
			$query->reset_query();
		}

		return json_encode( array(
			'draw' => $draw,
			'recordsTotal' => $total_num_rows,
			'recordsFiltered' => $filtered_num_rows,
			'data' => $filtered_rows_limited,
			'query' => (ENVIRONMENT == 'development') ? trim(preg_replace('/\s+/', ' ', $filtered_query)) : ''
		) );
	}
	
	public function reset(){
		$this->request = isset($_REQUEST) ? $_REQUEST : array();
		$this->extra_columns = array();
		$this->raw_columns = array();
		$this->filters = array();
		$this->escaper = 'htmlspecialchars';
		$this->table = false;
	}
	
	protected function _get_default_table(){
	    if( $this->table ){
	        return $this->table . '.';
	    }
	    
	    return '';
	}
}
