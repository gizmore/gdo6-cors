<?php
namespace GDO\CORS;
use GDO\Core\Module;
use GDO\Core\Application;
/**
 * Add CORS headers on non cli requests.
 * @author gizmore
 */
final class Module_CORS extends Module
{
    public function onInit()
    {
        if (!Application::instance()->isCLI())
        {
            header("Access-Control-Allow-Origin: ".$_SERVER['SERVER_NAME']);
            header("Access-Control-Allow-Credentials: true");
        }
    }
    
}
