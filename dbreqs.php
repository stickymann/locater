<?php
/**
 * Returns AJAX request to javascripts. 
 *
 * $Id: dbreqs.php 2014-11-23 20:56:00 dnesbit $
 *
 * @package		Locater
 * @module	    core
 * @author      Dunstan Nesbit (dunstan.nesbit@gmail.com)
 * @copyright   (c) 2014
 * @license     
 */

require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/dbops.php');
require_once(dirname(__FILE__).'/curlops.php');

class Dbreqs
{
	private $reverse_geo_url;
	private $wikimapia = "http://wikimapia.org/";
	
	public function __construct()
	{
		$this->cfg		= new Config();
		$this->config 	= $this->cfg->get_config();
		$this->dbops	= new DbOps($this->config);
		$this->curlops 	= new CurlOps($this->config);
		$this->reverse_geo_url = sprintf("%sreverse.php?",$this->config['nominatim_url']);
	}

	public function action_index()
	{
		$limit = "limit 500";
		$option = $_REQUEST['option'];
		switch($option)
		{
			case "locate":
				
				print "locate";
			break;
			
			case "whereis":
				$lat = ""; $lon = "";
				if( isset($_REQUEST['lat']) ){ $lat = $_REQUEST['lat']; }
				if( isset($_REQUEST['lon']) ){ $lon = $_REQUEST['lon']; }
				if($lat == "" || $lon == "" )
				{
					$arr = array(
						"status"=>"ERR",
						"value"=>"Invalid Lat or Lon value",
						"view_url"=>"",
						"details_url"=> ""
					);
					$json_str = json_encode($arr);
				}
				else
				{
					$result = "";
					$view_url = sprintf("%s#lang=en&lat=%s&lon=%s&z=14&m=o",$this->wikimapia,$lat,$lon);
					$params = sprintf('format=xml&lat=%s&lon=%s',$lat,$lon);
					$url = $this->reverse_geo_url.$params;
					$response = $this->curlops->get_remote_data($url,$status);
					$reversegeocode = new SimpleXMLElement($response);
					if($reversegeocode->result)
					{ 
						$result = sprintf('%s',$reversegeocode->result); 
						$place_id = sprintf('%s',$reversegeocode->result['place_id']);
					}
					if( $result == "" ) 
					{ 
						$result = "No result";
						$arr = array(
							"status"=>"ERR",
							"value"=>$result,
							"view_url"=>"",
							"details_url"=> ""
						);
					}
					else
					{
						$details_url = sprintf("%sdetails.php?place_id=%s",$this->config['nominatim_url'],$place_id);
						$arr = array(
							"status"=>"OK",
							"value"=>$result,
							"view_url"=>$view_url,
							"details_url"=> $details_url
						);
					}	
					$json_str = json_encode($arr);
				}	
				print $json_str;
			break;
		}
	}

} // End Dbreqs
	
	$req = new Dbreqs();
	$req->action_index();
?>
