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
use Sunrise\Uri\Component\ComponentInterface;
use Sunrise\Uri\Component\Scheme;
use Sunrise\Uri\Component\User;
use Sunrise\Uri\Component\Pass;
use Sunrise\Uri\Component\Host;
use Sunrise\Uri\Component\Port;
use Sunrise\Uri\Component\Path;
use Sunrise\Uri\Component\Query;
use Sunrise\Uri\Component\Fragment;
use Sunrise\Uri\Component\UserInfo;
use Sunrise\Uri\Exception\InvalidUriException;

/**
 * UriParser
 */
class UriParser
{

	/**
	 * The parsed URI component "scheme"
	 *
	 * @var ComponentInterface
	 */
	protected $scheme;

	/**
	 * The parsed URI component "user"
	 *
	 * @var ComponentInterface
	 */
	protected $user;

	/**
	 * The parsed URI component "pass"
	 *
	 * @var ComponentInterface
	 */
	protected $pass;

	/**
	 * The parsed URI component "host"
	 *
	 * @var ComponentInterface
	 */
	protected $host;

	/**
	 * The parsed URI component "port"
	 *
	 * @var ComponentInterface
	 */
	protected $port;

	/**
	 * The parsed URI component "path"
	 *
	 * @var ComponentInterface
	 */
	protected $path;

	/**
	 * The parsed URI component "query"
	 *
	 * @var ComponentInterface
	 */
	protected $query;

	/**
	 * The parsed URI component "fragment"
	 *
	 * @var ComponentInterface
	 */
	protected $fragment;

	/**
	 * The parsed URI component "userinfo"
	 *
	 * @var ComponentInterface
	 */
	protected $userinfo;

	/**
	 * Constructor of the class
	 *
	 * @param mixed $uri
	 *
	 * @throws InvalidUriException
	 *
	 * @link http://php.net/manual/en/function.parse-url.php
	 */
	public function __construct($uri)
	{
		if (! \is_string($uri))
		{
			throw new InvalidUriException('URI must be a string');
		}

		$components = \parse_url($uri);

		if (false === $components)
		{
			throw new InvalidUriException('Unable to parse URI');
		}

		$this->scheme = new Scheme($components['scheme'] ?? '');
		$this->user = new User($components['user'] ?? '');
		$this->pass = new Pass($components['pass'] ?? '');
		$this->host = new Host($components['host'] ?? '');
		$this->port = new Port($components['port'] ?? null);
		$this->path = new Path($components['path'] ?? '');
		$this->query = new Query($components['query'] ?? '');
		$this->fragment = new Fragment($components['fragment'] ?? '');

		$this->userinfo = new UserInfo(
			$components['user'] ?? '',
			$components['pass'] ?? null
		);
	}

	/**
	 * Gets the parsed URI component "scheme"
	 *
	 * @return ComponentInterface
	 */
	public function getScheme() : ComponentInterface
	{
		return $this->scheme;
	}

	/**
	 * Gets the parsed URI component "user"
	 *
	 * @return ComponentInterface
	 */
	public function getUser() : ComponentInterface
	{
		return $this->user;
	}

	/**
	 * Gets the parsed URI component "pass"
	 *
	 * @return ComponentInterface
	 */
	public function getPass() : ComponentInterface
	{
		return $this->pass;
	}

	/**
	 * Gets the parsed URI component "host"
	 *
	 * @return ComponentInterface
	 */
	public function getHost() : ComponentInterface
	{
		return $this->host;
	}

	/**
	 * Gets the parsed URI component "port"
	 *
	 * @return ComponentInterface
	 */
	public function getPort() : ComponentInterface
	{
		return $this->port;
	}

	/**
	 * Gets the parsed URI component "path"
	 *
	 * @return ComponentInterface
	 */
	public function getPath() : ComponentInterface
	{
		return $this->path;
	}

	/**
	 * Gets the parsed URI component "query"
	 *
	 * @return ComponentInterface
	 */
	public function getQuery() : ComponentInterface
	{
		return $this->query;
	}

	/**
	 * Gets the parsed URI component "fragment"
	 *
	 * @return ComponentInterface
	 */
	public function getFragment() : ComponentInterface
	{
		return $this->fragment;
	}

	/**
	 * Gets the parsed URI component "userinfo"
	 *
	 * @return ComponentInterface
	 */
	public function getUserInfo() : ComponentInterface
	{
		return $this->userinfo;
	}
}
