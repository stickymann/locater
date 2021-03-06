<?php
/**
 * Curl operations for Handshake to DacEasy Interface automation. 
 *
 * $Id: curlops.php 2013-09-13 16:15:46 dnesbit $
 *
 * @package		Handshake to DacEasy Interface
 * @module	    hndshkif
 * @author      Dunstan Nesbit (dunstan.nesbit@gmail.com)
 * @copyright   (c) 2013
 * @license      
 */
class CurlOps 
{
	
	public function __construct($config = null)
	{

	}
	
	public function get_remote_data($url,&$status)
	{
		$curl = curl_init($url);
//print "<b>[DEBUG]---></b> "; print($url); print( sprintf('<br><b>[line %s - %s, %s]</b><hr>',__LINE__,__FUNCTION__,__FILE__) );
		curl_setopt($curl, CURLOPT_VERBOSE, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

		/*
		 * If you're running curl 7.35.0 and run into this error in php when trying to connect to a remote host:
		 * 35 - error:14077410:SSL routines:SSL23_GET_SERVER_HELLO:sslv3 alert handshake failure
		 * uncomment the following curl_setopt lines
		 */
		//curl_setopt($curl, CURLOPT_SSLVERSION, 3);
		//curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3,RC4-SHA,RC4-MD5');
		curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');

		$response = curl_exec($curl);
//print "<b>[DEBUG]---></b> "; print htmlspecialchars($response); print( sprintf('<br><b>[line %s - %s, %s]</b><hr>',__LINE__,__FUNCTION__,__FILE__) );
		$status = curl_getinfo($curl);  
//print "<b>[DEBUG]---></b> "; print_r($status); print( sprintf('<br><b>[line %s - %s, %s]</b><hr>',__LINE__,__FUNCTION__,__FILE__) );
		curl_close($curl);
		return $response;
	}
	
} // End CurlOps
