<?php declare(strict_types=1);

/**
 * It's free open-source software released under the MIT License.
 *
 * @author Anatoly Fenric <anatoly@fenric.ru>
 * @copyright Copyright (c) 2018, Anatoly Fenric
 * @license https://github.com/sunrise-php/uri/blob/master/LICENSE
 * @link https://github.com/sunrise-php/uri
 */

namespace Sunrise\Uri;

/**
 * Import classes
 */
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * UriFactory
 *
 * @link https://www.php-fig.org/psr/psr-17/
 */
class UriFactory implements UriFactoryInterface
{

	/**
	 * {@inheritDoc}
	 */
	public function createUri(string $uri = '') : UriInterface
	{
		return new Uri($uri);
	}

	/**
	 * Creates URI from the server environment
	 *
	 * @param array $SERVER
	 *
	 * @return UriInterface
	 *
	 * @link http://php.net/manual/en/reserved.variables.server.php
	 */
	public function createUriFromServer(array $SERVER) : UriInterface
	{
		if (\array_key_exists('HTTPS', $SERVER))
		{
			if (! ('off' === $SERVER['HTTPS']))
			{
				$scheme = 'https://';
			}
		}

		if (\array_key_exists('HTTP_HOST', $SERVER))
		{
			$domain = $SERVER['HTTP_HOST'];
		}
		else if (\array_key_exists('SERVER_NAME', $SERVER))
		{
			$domain = $SERVER['SERVER_NAME'];

			if (\array_key_exists('SERVER_PORT', $SERVER))
			{
				$domain .= ':' . $SERVER['SERVER_PORT'];
			}
		}

		if (\array_key_exists('REQUEST_URI', $SERVER))
		{
			$target = $SERVER['REQUEST_URI'];
		}
		else if (\array_key_exists('PHP_SELF', $SERVER))
		{
			$target = $SERVER['PHP_SELF'];

			if (\array_key_exists('QUERY_STRING', $SERVER))
			{
				$target .= '?' . $SERVER['QUERY_STRING'];
			}
		}

		return new Uri(
			($scheme ?? 'http://') .
			($domain ?? 'localhost') .
			($target ?? '/')
		);
	}
}
