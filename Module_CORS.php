<?php
namespace GDO\CORS;

use GDO\Core\GDO_Module;
use GDO\DB\GDT_Checkbox;
use GDO\Util\Common;

/**
 * Add CORS headers on non cli requests.
 * Optional: Allow any origin. will try a lot of possible working values from request. If cors is set in request vars you can force it.
 * Default to SERVER_NAME.
 * @author gizmore
 * @version 6.11.0
 * @since 6.7.0
 */
final class Module_CORS extends GDO_Module
{
    ##############
    ### Module ###
    ##############
    public $module_priority = 10;
    public function onLoadLanguage() { return $this->loadLanguage('lang/cors'); }
    
    ##############
    ### Config ###
    ##############
	public function getConfig()
	{
		return [
			GDT_Checkbox::make('cors_allow_any')->initial('0'),
		    GDT_Checkbox::make('cors_allow_creds')->initial('1'),
		];
	}
	public function cfgAllowAny() { return $this->getConfigValue('cors_allow_any'); }
	public function cfgAllowCredentials() { return $this->getConfigValue('cors_allow_creds'); }
	
	############
	### Init ###
	############
	public function onInit()
	{
	    # Origin
		hdr("Access-Control-Allow-Origin: " . $this->getOrigin());
		
		# Credentials
		if ($this->cfgAllowCredentials())
		{
		    hdr("Access-Control-Allow-Credentials: true");
		}
		
		hdr('Access-Control-Allow-Headers: Content-Type, Authorization');
		hdr('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	}
	
	private function getOrigin()
	{
		if ($this->cfgAllowAny())
		{
			if ($cors = Common::getRequestString('cors'))
			{
				return $cors;
			}
			if ($cors = @$_SERVER['HTTP_ORIGIN'])
			{
				return $cors;
			}
			if ($cors = @$_SERVER['HTTP_REFERER'])
			{
				return $cors;
			}
			if ($cors = @$_SERVER['REMOTE_ADDR'])
			{
				return $cors;
			}
		}
		return @$_SERVER['SERVER_NAME'];
	}
	
}
