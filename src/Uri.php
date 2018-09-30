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
 * Uri
 *
 * @package Sunrise\Uri
 */
class Uri implements UriInterface
{

	/**
	 * Scheme of the URI
	 *
	 * @var string
	 */
	protected $scheme = '';

	/**
	 * Username of the URI
	 *
	 * @var string
	 */
	protected $username = '';

	/**
	 * Password of the URI
	 *
	 * @var string
	 */
	protected $password = '';

	/**
	 * Host of the URI
	 *
	 * @var string
	 */
	protected $host = '';

	/**
	 * Port of the URI
	 *
	 * @var null|int
	 */
	protected $port;

	/**
	 * Path of the URI
	 *
	 * @var string
	 */
	protected $path = '';

	/**
	 * Query of the URI
	 *
	 * @var string
	 */
	protected $query = '';

	/**
	 * Fragment of the URI
	 *
	 * @var string
	 */
	protected $fragment = '';

	/**
	 * {@inheritDoc}
	 */
	public function __construct(string $uri)
	{
		$components = \parse_url($uri);

		if (\array_key_exists('scheme', $components))
		{
			$this->setScheme($components['scheme']);
		}

		if (\array_key_exists('user', $components))
		{
			$this->setUsername($components['user']);
		}

		if (\array_key_exists('pass', $components))
		{
			$this->setPassword($components['pass']);
		}

		if (\array_key_exists('host', $components))
		{
			$this->setHost($components['host']);
		}

		if (\array_key_exists('port', $components))
		{
			$this->setPort($components['port']);
		}

		if (\array_key_exists('path', $components))
		{
			$this->setPath($components['path']);
		}

		if (\array_key_exists('query', $components))
		{
			$this->setQuery($components['query']);
		}

		if (\array_key_exists('fragment', $components))
		{
			$this->setFragment($components['fragment']);
		}
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.1
	 */
	public function setScheme(string $scheme) : UriInterface
	{
		$regex = '/^(?:[A-Z][A-Z0-9\+\-\.]*)?$/i';

		if (! \preg_match($regex, $scheme))
		{
			throw new \InvalidArgumentException('Invalid URI component "scheme"');
		}

		$this->scheme = $scheme;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setUsername(string $username) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=])*$/i';

		if (! \preg_match($regex, $username))
		{
			throw new \InvalidArgumentException('Invalid URI component "username"');
		}

		$this->username = $username;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setPassword(string $password) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=])*$/i';

		if (! \preg_match($regex, $password))
		{
			throw new \InvalidArgumentException('Invalid URI component "password"');
		}

		$this->password = $password;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.2
	 */
	public function setHost(string $host) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=])*$/i';

		if (! \preg_match($regex, $host))
		{
			throw new \InvalidArgumentException('Invalid URI component "host"');
		}

		$this->host = $host;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setPort(?int $port) : UriInterface
	{
		$min = 1;
		$max = 2 ** 16;

		if (! ($port === null || ($port >= $min && $port <= $max)))
		{
			throw new \InvalidArgumentException('Invalid URI component "port"');
		}

		$this->port = $port;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.3
	 */
	public function setPath(string $path) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=\:@\/])*$/i';

		if (! \preg_match($regex, $path))
		{
			throw new \InvalidArgumentException('Invalid URI component "path"');
		}

		$this->path = $path;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.4
	 */
	public function setQuery(string $query) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?])*$/i';

		if (! \preg_match($regex, $query))
		{
			throw new \InvalidArgumentException('Invalid URI component "query"');
		}

		$this->query = $query;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.5
	 */
	public function setFragment(string $fragment) : UriInterface
	{
		$regex = '/^(?:%[A-F0-9]{2}|[A-Z0-9\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?])*$/i';

		if (! \preg_match($regex, $fragment))
		{
			throw new \InvalidArgumentException('Invalid URI component "fragment"');
		}

		$this->fragment = $fragment;

		return $this;
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
	public function getUsername() : string
	{
		return $this->username;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPassword() : string
	{
		return $this->password;
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
	public function getUserInfo() : string
	{
		$result = '';

		if (! ($this->getUsername() === ''))
		{
			$result .= $this->getUsername();

			if (! ($this->getPassword() === ''))
			{
				$result .= ':' . $this->getPassword();
			}
		}

		return $result;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getHostPort() : string
	{
		$result = '';

		if (! ($this->getHost() === ''))
		{
			$result .= $this->getHost();

			if (! ($this->getPort() === null))
			{
				$result .= ':' . $this->getPort();
			}
		}

		return $result;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAuthority() : string
	{
		$result = '';

		$hostport = $this->getHostPort();

		if (! ($hostport === ''))
		{
			$userinfo = $this->getUserInfo();

			if (! ($userinfo === ''))
			{
				$result .= $userinfo . '@';
			}

			$result .= $hostport;
		}

		return $result;
	}

	/**
	 * {@inheritDoc}
	 */
	public function toString() : string
	{
		$result = '';

		if (! ($this->getScheme() === ''))
		{
			$result .= $this->getScheme() . ':';
		}

		$authority = $this->getAuthority();

		if (! ($authority === ''))
		{
			$result .= '//' . $authority;
		}

		$result .= $this->getPath();

		if (! ($this->getQuery() === ''))
		{
			$result .= '?' . $this->getQuery();
		}

		if (! ($this->getFragment() === ''))
		{
			$result .= '#' . $this->getFragment();
		}

		return $result;
	}
}
