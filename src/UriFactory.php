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
	 * @param array $server
	 *
	 * @return UriInterface
	 *
	 * @link http://php.net/manual/en/reserved.variables.server.php
	 */
	public function createUriFromServer(array $server) : UriInterface
	{
		if (\array_key_exists('HTTPS', $server))
		{
			if (! ('off' === $server['HTTPS']))
			{
				$scheme = 'https://';
			}
		}

		if (\array_key_exists('HTTP_HOST', $server))
		{
			$domain = $server['HTTP_HOST'];
		}
		else if (\array_key_exists('SERVER_NAME', $server))
		{
			$domain = $server['SERVER_NAME'];

			if (\array_key_exists('SERVER_PORT', $server))
			{
				$domain .= ':' . $server['SERVER_PORT'];
			}
		}

		if (\array_key_exists('REQUEST_URI', $server))
		{
			$target = $server['REQUEST_URI'];
		}
		else if (\array_key_exists('PHP_SELF', $server))
		{
			$target = $server['PHP_SELF'];

			if (\array_key_exists('QUERY_STRING', $server))
			{
				$target .= '?' . $server['QUERY_STRING'];
			}
		}

		return new Uri(
			($scheme ?? 'http://') .
			($domain ?? 'localhost') .
			($target ?? '/')
		);
	}
}
