<?php
namespace GDO\CORS;
use GDO\Core\GDO_Module;
use GDO\Core\Application;
/**
 * Add CORS headers on non cli requests.
 * @author gizmore
 */
final class Module_CORS extends GDO_Module
{
	public function onInit()
	{
		$app = Application::instance();
		if  (!$app->isCLI())
		{
			header("Access-Control-Allow-Origin: ".$_SERVER['SERVER_NAME']);
			header("Access-Control-Allow-Credentials: true");
		}
	}
}
