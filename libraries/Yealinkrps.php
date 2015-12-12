<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class YealinkRPS {
	protected $CI = NULL;

	protected $yeaUsername = '';
	protected $yeaPassword = '';
	protected $yeaHostname = 'https://{u}:{p}@rps.yealink.com/xmlrpc';

	public function __construct()
	{
		self::$CI =& get_instance();
		self::$CI->load->library('xmlrpc');

		if(self::$CI->load->config('yealinkrps', TRUE))
		{
			die('YealinkRPS Config File Missing');
		}

		if(isset(self::$CI->config['yealinkrps']['yeaUsername']))
		{
			self::$yeaUsername = self::$CI->config['yealinkrps']['yeaUsername'];
		}

                if(isset(self::$CI->config['yealinkrps']['yeaPassword']))
                {
                        self::$yeaPassword = self::$CI->config['yealinkrps']['yeaPassword'];
                }
	}

	private function __doXMLRPC($method=NULL,$request=NULL)
	{
		$xmlURI = str_replace(array('{u}','{p}'),array(self::$yeaUsername,self::$yeaPassword),self::$yeaHostname);

		self::$CI->xmlrpc->server(self::$yeaHostname);

		if($method == NULL)
		{
			die('YealinkRPS Request Method Missing');
		}

		self::$CI->xmlrpc->method($method);

		if(!is_array($request))
		{
			die('YealinkRPS Request Array Missing');
		}

		self::$CI->xmlrpc->request($request);

		if (!self::$CI->xmlrpc->send_request())
		{
			return self::$CI->xmlrpc->display_error();
		} else {
			return self::$CI->xmlrpc->display_response());
		}
	}

	public function registerDevice($devices=NULL,$server=NULL,$override=TRUE)
	{
		$data = array($devices,$server,$override);
		return self::__doXMLRPC('redirect.registerDevices',$data);
	}

	public function deRegisterDevice($devices=NULL)
	{
                $data = array($devices);
                return self::__doXMLRPC('redirect.deRegisterDevices',$data);
	}

	public function listDevices()
	{
		return self::__doXMLRPC('redirect.listDevices');
	}

	public function checkDevice($device=NULL)
	{
                $data = array($device);
                return self::__doXMLRPC('redirect.checkDevice',$data);
	}

	public function addServer($serverName=NULL,$serverURL=NULL)
	{
                $data = array($serverName,$serverURL);
                return self::__doXMLRPC('redirect.addServer',$data);
	}

	public function editDevice($devices=NULL,$serverName=NULL)
	{
                $data = array($devices,$serverName);
                return self::__doXMLRPC('redirect.editDevices',$data);
	}
}
