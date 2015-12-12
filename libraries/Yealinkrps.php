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
		self::$CI->load->library('xmlrpc-c');

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
		$xmlURI = str_replace(array('u','p'),array(self::$yeaUsername,self::$yeaPassword),self::$yeaHostname);

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

		$this->xmlrpc->request($request);

		if (!$this->xmlrpc->send_request())
		{
			return $this->xmlrpc->display_error();
		} else {
			return $this->xmlrpc->display_response());
		}
	}

	public function registerDevice()
	{
	}

	public function deRegisterDevice()
	{
	}

	public function listDevices()
	{
	}

	public function listDevices()
	{
	}

	public function checkDevice()
	{
	}

	public function addServer()
	{
	}

	public function editDevice()
	{
	}

}
