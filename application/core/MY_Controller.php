<?php

class MY_Controller extends CI_Controller {

    public $data = array();
    public function __construct() {
        parent::__construct();
        
		if($this->session->userdata('site_lang')){
			$this->set_language=$this->session->userdata('site_lang');
		}else{
			$this->set_language='en';
		}
    }
    
   
    public function isLogged() {
        if (!($this->session->userdata('loged_in') > 0)) {
            redirect(ADMIN . '/login', 'refresh');
            exit;
        }
    }
    
    
    protected function blogpager($query){
		$limit = 20;
		if( isset($_GET['limit']) && is_numeric($_GET['limit']) ){
			$limit = $_GET['limit'];
		}

		$current_page = 1;
		if( isset($_GET['page']) && is_numeric($_GET['page']) ){
			$current_page = $_GET['page'];
		}

		$offset = ($current_page - 1) * $limit;

		$result = array();

		$total_page = ceil ( $this->db->query($query)->num_rows() / $limit );
		$query = $query . ' LIMIT '.$offset.','.$limit;

		$result['result'] = $this->db->query($query)->result_array();
		
		$result['page_widget'] = self::page_widget($total_page, $current_page);
		$result['filter_widget'] = self::filter_widget( isset($_GET['search']) ?$_GET['search'] : '', $limit );

		return $result;
	}
	
	protected function page_widget($total_page, $current_page, $attributes = 'pagination-style text-center')
	{
		$html = ''; $links_limit = 7;

		$temp_GET = $_GET;
		$html .= '<div class="'.$attributes.'"><ul>';

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
			$html .= '<li ><a  href="?'.http_build_query($temp_GET).'">Previous</a></li>';
		}

		for($i = $start; $i <= $end; $i++)
		{
			$temp_GET['page'] = $i;
			if( $current_page == $i ){
				$html .= '<li class="active"><a  href="javascript:void(0)">'.$i.'</a></li>';
			} else {
				$html .= '<li><a  href="?'.http_build_query($temp_GET).'">'.$i.'</a></li>';
			}
		}

		if($current_page < $total_page)
		{
			$temp_GET['page'] = $current_page + 1;
			$html .= '<li><a  href="?'.http_build_query($temp_GET).'">Next</a></li>';
		}

		$html .= '</ul></div>';

		return $html;
	}
	
	protected function filter_widget( $search, $current_limit ){
		return '<div class="row filter_widget">
			<div class="col-md-6">
				
			</div>
			<div class="col-md-6 text-right">
				<input type="text" placeholder="Press Enter to Search" onkeyup="filter_widget_search(this)" value="'.$search.'">
			</div>
			<script type="text/javascript">
				function filter_widget_search(elem){
					if (event.keyCode === 13) {
						window.location.href = "?search="+elem.value;
					}
				}
			</script>
		</div>';
	}
	
 
}

?>