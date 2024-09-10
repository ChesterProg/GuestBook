<?php

namespace App\Service;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * HtmlPurifierService class
 *
 * This service is responsible for purifying HTML input to ensure it is safe
 * and free from potentially harmful content. It uses the HTMLPurifier library
 * to filter and sanitize HTML.
 */
class HtmlPurifierService
{
	private HTMLPurifier $purifier;

	/**
	 * Constructor.
	 *
	 * Initializes the HTMLPurifier with a default configuration.
	 * Sets allowed HTML tags to prevent XSS and other vulnerabilities.
	 */
	public function __construct()
	{
		// Create a default configuration for HTMLPurifier
		$config = HTMLPurifier_Config::createDefault();

		// Specify the allowed HTML tags and attributes
		$config->set('HTML.Allowed', 'a,code,i,strike,strong');  // Allowed tags

		// Initialize the HTMLPurifier with the configured settings
		$this->purifier = new HTMLPurifier($config);
	}

	/**
	 * Purifies the provided HTML string.
	 *
	 * @param string $html The HTML string to be purified
	 * @return string The purified HTML string
	 */
	public function purify(string $html): string
	{
		// Use HTMLPurifier to clean the provided HTML and return the result
		return $this->purifier->purify($html);
	}
}