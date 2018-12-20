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
use Psr\Http\Message\UriInterface;
use Sunrise\Uri\Component\Scheme;
use Sunrise\Uri\Component\UserInfo;
use Sunrise\Uri\Component\Host;
use Sunrise\Uri\Component\Port;
use Sunrise\Uri\Component\Path;
use Sunrise\Uri\Component\Query;
use Sunrise\Uri\Component\Fragment;

/**
 * Uniform Resource Identifier
 *
 * @link https://tools.ietf.org/html/rfc3986
 * @link https://www.php-fig.org/psr/psr-7/
 */
class Uri implements UriInterface
{

	/**
	 * The URI component "scheme"
	 *
	 * @var string
	 */
	protected $scheme = '';

	/**
	 * The URI component "userinfo"
	 *
	 * @var string
	 */
	protected $userinfo = '';

	/**
	 * The URI component "host"
	 *
	 * @var string
	 */
	protected $host = '';

	/**
	 * The URI component "port"
	 *
	 * @var null|int
	 */
	protected $port;

	/**
	 * The URI component "path"
	 *
	 * @var string
	 */
	protected $path = '';

	/**
	 * The URI component "query"
	 *
	 * @var string
	 */
	protected $query = '';

	/**
	 * The URI component "fragment"
	 *
	 * @var string
	 */
	protected $fragment = '';

	/**
	 * Constructor of the class
	 *
	 * @param mixed $uri
	 */
	public function __construct($uri = '')
	{
		// resource savings...
		if ('' === $uri) {
			return;
		}

		$components = new UriParser($uri);

		$this->scheme = $components
		->getScheme()
		->present();

		$this->userinfo = $components
		->getUserInfo()
		->present();

		$this->host = $components
		->getHost()
		->present();

		$this->port = $components
		->getPort()
		->present();

		$this->path = $components
		->getPath()
		->present();

		$this->query = $components
		->getQuery()
		->present();

		$this->fragment = $components
		->getFragment()
		->present();
	}

	/**
	 * {@inheritDoc}
	 */
	public function withScheme($scheme) : UriInterface
	{
		$clone = clone $this;

		$component = new Scheme($scheme);

		$clone->scheme = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withUserInfo($user, $pass = null) : UriInterface
	{
		$clone = clone $this;

		$component = new UserInfo($user, $pass);

		$clone->userinfo = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withHost($host) : UriInterface
	{
		$clone = clone $this;

		$component = new Host($host);

		$clone->host = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPort($port) : UriInterface
	{
		$clone = clone $this;

		$component = new Port($port);

		$clone->port = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPath($path) : UriInterface
	{
		$clone = clone $this;

		$component = new Path($path);

		$clone->path = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withQuery($query) : UriInterface
	{
		$clone = clone $this;

		$component = new Query($query);

		$clone->query = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withFragment($fragment) : UriInterface
	{
		$clone = clone $this;

		$component = new Fragment($fragment);

		$clone->fragment = $component->present();

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getScheme() : string
	{
		return $this->scheme;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getUserInfo() : string
	{
		return $this->userinfo;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getHost() : string
	{
		return $this->host;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPort() : ?int
	{
		$scheme = $this->getScheme();

		// The 80 is the default port number for the HTTP protocol.
		if (80 === $this->port && 'http' === $scheme) {
			return null;
		}

		// The 443 is the default port number for the HTTPS protocol.
		if (443 === $this->port && 'https' === $scheme) {
			return null;
		}

		return $this->port;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPath() : string
	{
		return $this->path;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getQuery() : string
	{
		return $this->query;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFragment() : string
	{
		return $this->fragment;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAuthority() : string
	{
		$authority = $this->getHost();

		// Host is the basic subcomponent.
		if ('' === $authority)
		{
			return '';
		}

		$userinfo = $this->getUserInfo();

		if (! ('' === $userinfo))
		{
			$authority = $userinfo . '@' . $authority;
		}

		$port = $this->getPort();

		if (! (null === $port))
		{
			$authority = $authority . ':' . $port;
		}

		return $authority;
	}

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		$uri = '';

		$scheme = $this->getScheme();

		if (! ('' === $scheme))
		{
			$uri .= $scheme . ':';
		}

		$authority = $this->getAuthority();

		if (! ('' === $authority))
		{
			$uri .= '//' . $authority;
		}

		$path = $this->getPath();

		if (! ('' === $path))
		{
			$uri .= $path;
		}

		$query = $this->getQuery();

		if (! ('' === $query))
		{
			$uri .= '?' . $query;
		}

		$fragment = $this->getFragment();

		if (! ('' === $fragment))
		{
			$uri .= '#' . $fragment;
		}

		return $uri;
	}
}
