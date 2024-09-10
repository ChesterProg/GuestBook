<?php

namespace App\Service;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlPurifierService
{
	private HTMLPurifier $purifier;

	public function __construct()
	{
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.Allowed', 'a,code,i,strike,strong');  // Дозволені теги
		$this->purifier = new HTMLPurifier($config);
	}

	public function purify(string $html): string
	{
		return $this->purifier->purify($html);
	}
}
