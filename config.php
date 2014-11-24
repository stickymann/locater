<?php
/**
 * Configuration setup for locater.
 *
 * $Id: config.php 2014-11-21 10:40:00 dnesbit $
 *
 * @package		Locater
 * @module	    core
 * @author      Dunstan Nesbit (dunstan.nesbit@gmail.com)
 * @copyright   (c) 2014
 * @license      
 */

define('CONFIG_FILE',dirname(__FILE__).'/config.xml');
define('DEBUG',false);

class Config 
{
	public $config = null;
	
	public function __construct()
	{
		$configfile = CONFIG_FILE;
		try
			{
				//check for required fields in xml file
				$xml = file_get_contents($configfile);
				$cfg = new SimpleXMLElement($xml);
				
				//database
				if($cfg->database->server) { $this->config['dbserver'] = sprintf('%s',$cfg->database->server); }
				if($cfg->database->name) { $this->config['dbname'] = sprintf('%s',$cfg->database->name); }
				if($cfg->database->user) { $this->config['dbuser'] = sprintf('%s',$cfg->database->user); }
				if($cfg->database->password) { $this->config['dbpasswd'] = sprintf('%s',$cfg->database->password); }
				$this->config['connectstr'] = sprintf('mysql:host=%s;dbname=%s', $this->config['dbserver'], $this->config['dbname']);
				
				//nominatim
				if($cfg->nominatim->url) { $this->config['nominatim_url'] = rtrim( sprintf('%s',$cfg->nominatim->url),'/').'/'; }
				
				//smsd
				if($cfg->smsd->folders->checked) { $this->config['checked'] = rtrim( sprintf('%s', $cfg->smsd->folders->checked),'/').'/'; }
				if($cfg->smsd->folders->failed) { $this->config['failed'] = rtrim( sprintf('%s',$cfg->smsd->folders->failed),'/').'/'; }
				if($cfg->smsd->folders->incoming) { $this->config['incoming'] = rtrim( sprintf('%s', $cfg->smsd->folders->incoming),'/').'/'; }
				if($cfg->smsd->folders->outgoing) { $this->config['outgoing'] = rtrim( sprintf('%s', $cfg->smsd->folders->outgoing),'/').'/'; }
				if($cfg->smsd->folders->sent) { $this->config['sent'] = rtrim( sprintf('%s', $cfg->smsd->folders->sent),'/').'/'; }
								
				//tables
				if($cfg->tables->tb_telbooks) { $this->config['tb_telbooks'] = sprintf('%s',$cfg->tables->tb_telbooks); }

			}
		catch (Exception $e) 
			{
				$desc='Configuration File Error : '.$e->getMessage();
				print $desc;
			}
	}
	
	public function get_config()
	{
		return $this->config;
	}
	
} //End Config 
