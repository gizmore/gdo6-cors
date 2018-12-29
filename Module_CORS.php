<?php
namespace GDO\CORS;
use GDO\Core\GDO_Module;
use GDO\Core\Application;
use GDO\DB\GDT_Checkbox;
use GDO\Util\Common;
/**
 * Add CORS headers on non cli requests.
 * Optional: Allow any origin. will try a lot of possible working values from request. If cors is set in request vars you can force it.
 * Default to SERVER_NAME.
 * @since 6.07
 * @version 6.09
 * @author gizmore
 */
final class Module_CORS extends GDO_Module
{
	public function getConfig()
	{
		return array(
			GDT_Checkbox::make('cors_allow_any')->initial('0'),
		);
	}
	
	public function cfgAllowAny() { return $this->getConfigValue('cors_allow_any'); }
	
	public function onInit()
	{
		$app = Application::instance();
		if (!$app->isCLI())
		{
			header("Access-Control-Allow-Origin: " . $this->getOrigin());
			header("Access-Control-Allow-Credentials: true");
		}
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
		return $_SERVER['SERVER_NAME'];
	}
}
