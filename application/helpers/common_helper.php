<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package		CodeIgniter
* @author		ExpressionEngine Dev Team
* @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link		http://codeigniter.com
* @since		Version 1.0
* @filesource
*/

if (! function_exists('get_settings')) {
    function get_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key_name', $key);
        $result = $CI->db->get('settings')->row('key_value');
        return $result;
    }
}


if(! function_exists('categories'))
{
    function categories()
    {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->select('*');
        $CI->db->from('categories');
        $CI->db->where('status','1');
        $CI->db->order_by('sort_order', 'asc');
        
        $query = $CI->db->get();
        $CI->db->last_query();
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
}

if(! function_exists('app_pages'))
{
    function app_pages()
    {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->select('*');
        $CI->db->from('app_pages');
        $CI->db->where('status','Active');
        $CI->db->order_by('title', 'asc');
        
        $query = $CI->db->get();
        $CI->db->last_query();
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
}


if (! function_exists('get_about_settings')) {
    function get_about_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('label_key', $key);
        $result = $CI->db->get('about_us')->row('value');
        return $result;
    }
}

if (! function_exists('get_home_settings')) {
    function get_home_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key', $key);
        $result = $CI->db->get('home_page')->row('value');
        return $result;
    }
}

if (! function_exists('get_frontend_settings')) {
    function get_frontend_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key_name', $key);
        $result = $CI->db->get('settings')->row()->key_value;
        return $result;
    }
}


if (! function_exists('currency')) {
    function currency($price = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($price != "") {
            $CI->db->where('key', 'system_currency');
            $currency_code = $CI->db->get('settings')->row()->value;

            $CI->db->where('code', $currency_code);
            $symbol = $CI->db->get('currency')->row()->symbol;

            $CI->db->where('key', 'currency_position');
            $position = $CI->db->get('settings')->row()->value;

            if ($position == 'right') {
                return $price.$symbol;
            }elseif ($position == 'right-space') {
                return $price.' '.$symbol;
            }elseif ($position == 'left') {
                return $symbol.$price;
            }elseif ($position == 'left-space') {
                return $symbol.' '.$price;
            }
        }
    }
}

if (! function_exists('currency_code_and_symbol')) {
    function currency_code_and_symbol($type = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('key', 'system_currency');
        $currency_code = $CI->db->get('settings')->row()->value;

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row()->symbol;
        if ($type == "") {
            return $symbol;
        }else {
            return $currency_code;
        }

    }
}



if ( ! function_exists('slugify'))
{
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('super_slugify'))
{
    function super_slugify($table_name="",$col_slug_param="",$custom_name="") {
     $CI	=&	get_instance();
     $CI->load->database();
     $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($custom_name)));
     $result= $CI->db->select('*')->from($table_name)->where("$col_slug_param LIKE '$slug%'")->get()->result_array();
     $total_row = $CI->db->select('*')->from($table_name)->where("$col_slug_param LIKE '$slug%'")->get()->num_rows(); 
         if($total_row > 0)
        {
        foreach($result as $row_slug)
            {
            $data[] = $row_slug[$col_slug_param];
            }
                if(in_array($slug, $data))
               {
                $slug = $slug . '-' . $row_slug['id'];
               }
        }
        return $slug;
    }
}



if ( ! function_exists('_rand_str'))
{
    function _rand_str($length = 6, $types = array('0','A','a','$'))
    {
    	$characters = '';
    		
    	if(in_array('0', $types)){ $characters = $characters . '0123456789'; }
    	if(in_array('A', $types)){ $characters = $characters . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
    	if(in_array('a', $types)){ $characters = $characters . 'abcdefghijklmnopqrstuvwxyz'; }
    	if(in_array('#', $types)){ $characters = $characters . '!"#$%&\'()*+,-./:;<=>?@[]\\^_`{}|~'; }
    	
    	if($characters == ''){ $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'!"#$%&\'()*+,-./:;<=>?@[]\\^_`{}|~';}
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
}


if ( ! function_exists('get_video_extension'))
{
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

if ( ! function_exists('ellipsis'))
{
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}



// Human readable time
if ( ! function_exists('readable_time_for_humans')){
    function readable_time_for_humans($duration) {
        if ($duration) {
            $duration_array = explode(':', $duration);
            $hour   = $duration_array[0];
            $minute = $duration_array[1];
            $second = $duration_array[2];
            if ($hour > 0) {
                $duration = $hour.' '.get_phrase('hr').' '.$minute.' '.get_phrase('min');
            }elseif ($minute > 0) {
                if ($second > 0) {
                    $duration = ($minute+1).' '.get_phrase('min');
                }else{
                    $duration = $minute.' '.get_phrase('min');
                }
            }elseif ($second > 0){
                $duration = $second.' '.get_phrase('sec');
            }else {
                $duration = '00:00';
            }
        }else {
            $duration = '00:00';
        }
        return $duration;
    }
}

if ( ! function_exists('trimmer'))
{
    function trimmer($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}


// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('random')) {
    function random($length_of_string) {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('phpFileUploadErrors')) {
    function phpFileUploadErrors($error_code) {
        $phpFileUploadErrorsArray = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        return $phpFileUploadErrorsArray[$error_code];
    }
}

//IMAGE RESIZER
if (! function_exists('resize')) {
 function resize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];
    
        switch ($mime) {
                case 'image/jpeg':
                        $image_create_func = 'imagecreatefromjpeg';
                        $image_save_func = 'imagejpeg';
                        $new_image_ext = 'jpg';
                        break;
    
                case 'image/png':
                        $image_create_func = 'imagecreatefrompng';
                        $image_save_func = 'imagepng';
                        $new_image_ext = 'png';
                        break;
    
                case 'image/gif':
                        $image_create_func = 'imagecreatefromgif';
                        $image_save_func = 'imagegif';
                        $new_image_ext = 'gif';
                        break;
    
                default: 
                        throw new Exception('Unknown image type.');
        }
    
        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);
    
        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
        if (file_exists($targetFile)) {
                unlink($targetFile);
        }
        $image_save_func($tmp, "$targetFile");
    }
}

// ------------------------------------------------------------------------
/* End of file common_helper.php */
/* Location: ./system/helpers/common.php */
