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
use Sunrise\Collection\CollectionInterface;

/**
 * UriInterface
 *
 * @package Sunrise\Uri
 *
 * @link https://tools.ietf.org/html/rfc3986
 */
interface UriInterface
{

	/**
	 * Constructor of the class
	 */
	public function __construct(string $uri);

	/**
	 * Sets the URI component "scheme"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.1
	 */
	public function setScheme(string $scheme) : UriInterface;

	/**
	 * Sets the URI component "username"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setUsername(string $username) : UriInterface;

	/**
	 * Sets the URI component "password"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setPassword(string $password) : UriInterface;

	/**
	 * Sets the URI component "host"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.2
	 */
	public function setHost(string $host) : UriInterface;

	/**
	 * Sets the URI component "port"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.3
	 */
	public function setPort(?int $port) : UriInterface;

	/**
	 * Sets the URI component "path"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.3
	 */
	public function setPath(string $path) : UriInterface;

	/**
	 * Sets the URI component "query"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.4
	 */
	public function setQuery(string $query) : UriInterface;

	/**
	 * Sets the URI component "fragment"
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.5
	 */
	public function setFragment(string $fragment) : UriInterface;

	/**
	 * Gets the URI payload
	 */
	public function getPayload() : CollectionInterface;

	/**
	 * Gets the URI component "scheme"
	 */
	public function getScheme() : string;

	/**
	 * Gets the URI component "username"
	 */
	public function getUsername() : string;

	/**
	 * Gets the URI component "password"
	 */
	public function getPassword() : string;

	/**
	 * Gets the URI component "host"
	 */
	public function getHost() : string;

	/**
	 * Gets the URI component "port"
	 */
	public function getPort() : ?int;

	/**
	 * Gets the URI component "path"
	 */
	public function getPath() : string;

	/**
	 * Gets the URI component "query"
	 */
	public function getQuery() : string;

	/**
	 * Gets the URI component "fragment"
	 */
	public function getFragment() : string;

	/**
	 * Gets the URI user info
	 */
	public function getUserInfo() : string;

	/**
	 * Gets the URI host and port
	 */
	public function getHostPort() : string;

	/**
	 * Gets the URI authority
	 */
	public function getAuthority() : string;

	/**
	 * Converts the URI to string
	 */
	public function toString() : string;
}
