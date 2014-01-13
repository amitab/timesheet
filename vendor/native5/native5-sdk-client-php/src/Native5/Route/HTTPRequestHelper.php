<?php
namespace Native5\Route;

class RequestHelper {
	function do_post_request($url, $data, $optional_headers = null) {
		$params = array('http' => array(
					'method' => 'POST',
					'content' => $data
					));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			throw new Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		return $response;
	}

	function doCurlRequest($url, $data, $method="POST", $optional_headers=null) {
/**
		echo "<h3>Request</h3><hr/>";
                echo "<strong>".$url."</strong>";
                echo "<br/>";
		echo json_decode($data);
**/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    			'Content-Type: application/json; charset=utf-8',
			'Content-Length: ' . strlen($data))  
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
//		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		if($method=="POST") { 
			curl_setopt($ch, CURLOPT_POST, 1); //set how many paramaters to post  
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		} else {
			curl_setopt($ch, CURLOPT_HTTPGET, TRUE); 
		}
		curl_setopt($ch, CURLOPT_URL,$url); //set the url we want to use 
		curl_setopt($ch, CURLOPT_PROXY, "http://localhost");
		curl_setopt($ch, CURLOPT_PROXYPORT, 8080);  
	
		$result = curl_exec($ch);
/**
		echo "<h3>Response</h3><hr/>";
		if($result == NULL) {
			echo "Error CURL: " . curl_error($ch) . " \nError number: " . curl_errno($ch);
		}
**/ 
		curl_close($ch);
//		if($result != null)
//	                echo "Result from service = ".$result;

		return $result;
	}
}
?>
