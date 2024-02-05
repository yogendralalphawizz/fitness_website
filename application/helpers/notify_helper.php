<?php

if( ! function_exists('notify') ){
	// $status = error | message | notify | success | warning
	function notify($message, $status = 'success', $wait = 3){
		if( ! isset($_SESSION['alertify_helper_messages']) ){
			$_SESSION['alertify_helper_messages'] = array();
		}
		
		if($wait < 0){
			$wait = 3;
		}

		$_SESSION['alertify_helper_messages'][] = array(
			'type' => 'notifier',
			'status' => $status,
			'message' => trim(preg_replace("/\r|\n/", ' ', $message)),
			'payload' => $wait
		);
	}
}

if( ! function_exists('alertify') ){
	function alertify($message, $title = null){
		if( ! isset($_SESSION['alertify_helper_messages']) ){
			$_SESSION['alertify_helper_messages'] = array();
		}

		$_SESSION['alertify_helper_messages'][] = array(
			'type' => 'alertify',
			'message' => trim(preg_replace("/\r|\n/", ' ', $message)),
			'payload' => trim(preg_replace("/\r|\n/", ' ', $title))
		);
	}
}

if( ! function_exists('alertify_render') ){
	function alertify_render( $base_url_to_alertify_assets, $position = 'top-right' ){
		if( ! isset($_SESSION['alertify_helper_messages']) ){
			$_SESSION['alertify_helper_messages'] = array();
		}

		$content = '<link rel="stylesheet" href="'.$base_url_to_alertify_assets.'/css/alertify.min.css"/>
		    <link rel="stylesheet" href="'.$base_url_to_alertify_assets.'/css/themes/bootstrap.min.css"/>
			<script src="'.$base_url_to_alertify_assets.'/alertify.min.js"></script>
			<script type="text/javascript">
				alertify.defaults.notifier.position = "'.$position.'";
				alertify.defaults.notifier.closeButton = true;
				alertify.defaults.movable = false;
		';
				
		
		foreach($_SESSION['alertify_helper_messages'] as $message){
			if($message['type'] == 'notifier'){
				$content .= 'alertify.notify("'.$message['message'].'", "'.$message['status'].'", "'.$message['payload'].'");';
			} else {
				if($message['payload'] == null){
					$content .= 'alertify.alert("'.$message['message'].'");';
				} else {
					$content .= 'alertify.alert("'.$message['payload'].'", "'.$message['message'].'");';
				}
			}
		}
		$content .= '</script>';

		$_SESSION['alertify_helper_messages'] = array();
		return $content;
	}
}
