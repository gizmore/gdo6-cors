<?php
namespace GDO\CORS\Method;

use GDO\Core\Method;

/**
 * Cookie setting triggered by a web-bug.
 * 
 * @author gizmore
 * @since 6.11.3
 */
final class SetCookie extends Method
{
	public function execute()
	{
		$path = $this->filePath('img/pixel.png');
		$picture = file_get_contents($path);
		hdr('Content-Type: image/png');
		hdr('Content-Size: ' . strlen($picture));
		die($picture);
	}
	
}
