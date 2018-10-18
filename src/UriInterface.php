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
 * Uniform Resource Identifier
 *
 * @link https://tools.ietf.org/html/rfc3986
 */
interface UriInterface
{

	/**
	 * Constructor of the class
	 *
	 * @param string $uri
	 *
	 * @throws Exception\InvalidUriException If the given value is not a valid URI
	 */
	public function __construct(string $uri);

	/**
	 * Sets the URI component "scheme"
	 *
	 * @param string $scheme
	 *
	 * @return UriInterface
	 *
	 * @throws Exception\InvalidUriComponentException If the given value is not a valid URI scheme
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.1
	 */
	public function setScheme(string $scheme) : UriInterface;

	/**
	 * Sets the URI component "username"
	 *
	 * @param string $username
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setUsername(string $username) : UriInterface;

	/**
	 * Sets the URI component "password"
	 *
	 * @param string $password
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setPassword(string $password) : UriInterface;

	/**
	 * Sets the URI component "host"
	 *
	 * @param string $host
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.2
	 */
	public function setHost(string $host) : UriInterface;

	/**
	 * Sets the URI component "port"
	 *
	 * @param null|int $port
	 *
	 * @return UriInterface
	 *
	 * @throws Exception\InvalidUriComponentException If the given value is not a valid URI port
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.3
	 */
	public function setPort(?int $port) : UriInterface;

	/**
	 * Sets the URI component "path"
	 *
	 * @param string $path
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.3
	 */
	public function setPath(string $path) : UriInterface;

	/**
	 * Sets the URI component "query"
	 *
	 * @param string $query
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.4
	 */
	public function setQuery(string $query) : UriInterface;

	/**
	 * Sets the URI component "fragment"
	 *
	 * @param string $fragment
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.5
	 */
	public function setFragment(string $fragment) : UriInterface;

	/**
	 * Gets the URI payload
	 *
	 * @return CollectionInterface
	 */
	public function getPayload() : CollectionInterface;

	/**
	 * Gets the URI component "scheme"
	 *
	 * @return string
	 */
	public function getScheme() : string;

	/**
	 * Gets the URI component "username"
	 *
	 * @return string
	 */
	public function getUsername() : string;

	/**
	 * Gets the URI component "password"
	 *
	 * @return string
	 */
	public function getPassword() : string;

	/**
	 * Gets the URI component "host"
	 *
	 * @return string
	 */
	public function getHost() : string;

	/**
	 * Gets the URI component "port"
	 *
	 * @return null|int
	 */
	public function getPort() : ?int;

	/**
	 * Gets the URI component "path"
	 *
	 * @return string
	 */
	public function getPath() : string;

	/**
	 * Gets the URI component "query"
	 *
	 * @return string
	 */
	public function getQuery() : string;

	/**
	 * Gets the URI component "fragment"
	 *
	 * @return string
	 */
	public function getFragment() : string;

	/**
	 * Gets the URI user info
	 *
	 * @return string
	 */
	public function getUserInfo() : string;

	/**
	 * Gets the URI host and port
	 *
	 * @return string
	 */
	public function getHostPort() : string;

	/**
	 * Gets the URI authority
	 *
	 * @return string
	 */
	public function getAuthority() : string;

	/**
	 * Converts the URI to string
	 *
	 * @return string
	 */
	public function toString() : string;
}
