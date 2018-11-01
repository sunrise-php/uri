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
	 * The URI component "user"
	 *
	 * @var string
	 */
	protected $user = '';

	/**
	 * The URI component "pass"
	 *
	 * @var string
	 */
	protected $pass = '';

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
	 * @param string $uri
	 */
	public function __construct(string $uri = '')
	{
		if (! ('' === $uri))
		{
			$this->parse($uri);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function withScheme($scheme) : UriInterface
	{
		return (clone $this)
		->setScheme($scheme);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withUserInfo($user, $pass = null) : UriInterface
	{
		if (! (null === $pass))
		{
			return (clone $this)
			->setUser($user)
			->setPass($pass);
		}

		return (clone $this)
		->setUser($user);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withHost($host) : UriInterface
	{
		return (clone $this)
		->setHost($host);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPort($port) : UriInterface
	{
		return (clone $this)
		->setPort($port);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPath($path) : UriInterface
	{
		return (clone $this)
		->setPath($path);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withQuery($query) : UriInterface
	{
		return (clone $this)
		->setQuery($query);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withFragment($fragment) : UriInterface
	{
		return (clone $this)
		->setFragment($fragment);
	}

	/**
	 * Gets the URI component "scheme"
	 *
	 * @return string
	 */
	public function getScheme() : string
	{
		return $this->scheme;
	}

	/**
	 * Gets the URI component "user"
	 *
	 * @return string
	 */
	public function getUser() : string
	{
		return $this->user;
	}

	/**
	 * Gets the URI component "pass"
	 *
	 * @return string
	 */
	public function getPass() : string
	{
		return $this->pass;
	}

	/**
	 * Gets the URI component "host"
	 *
	 * @return string
	 */
	public function getHost() : string
	{
		return $this->host;
	}

	/**
	 * Gets the URI component "port"
	 *
	 * @return null|int
	 */
	public function getPort() : ?int
	{
		return $this->port;
	}

	/**
	 * Gets the URI component "path"
	 *
	 * @return string
	 */
	public function getPath() : string
	{
		return $this->path;
	}

	/**
	 * Gets the URI component "query"
	 *
	 * @return string
	 */
	public function getQuery() : string
	{
		return $this->query;
	}

	/**
	 * Gets the URI component "fragment"
	 *
	 * @return string
	 */
	public function getFragment() : string
	{
		return $this->fragment;
	}

	/**
	 * Gets the URI user info
	 *
	 * @return string
	 */
	public function getUserInfo() : string
	{
		$result = '';

		if (! ($this->getUser() === ''))
		{
			$result .= $this->getUser();

			if (! ($this->getPass() === ''))
			{
				$result .= ':' . $this->getPass();
			}
		}

		return $result;
	}

	/**
	 * Gets the URI host and port
	 *
	 * @return string
	 */
	public function getHostPort() : string
	{
		$result = '';

		if (! ($this->getHost() === ''))
		{
			$result .= $this->getHost();

			if (! ($this->getPort() === null))
			{
				// Ignoring the standard port for http/https scheme
				if (! ($this->getPort() === 80 && $this->getScheme() === 'http'))
				{
					if (! ($this->getPort() === 443 && $this->getScheme() === 'https'))
					{
						$result .= ':' . $this->getPort();
					}
				}
			}
		}

		return $result;
	}

	/**
	 * Gets the URI authority
	 *
	 * @return string
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
	 * Converts the URI to string
	 *
	 * @return string
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

	/**
	 * Converts the object to string
	 *
	 * @return string
	 *
	 * @link http://php.net/manual/en/language.oop5.magic.php#object.tostring
	 */
	public function __toString()
	{
		return $this->toString();
	}

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
	protected function setScheme(string $scheme) : UriInterface
	{
		$regex = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

		if (! \preg_match($regex, $scheme))
		{
			throw new Exception\InvalidUriComponentException('Invalid URI component "scheme"');
		}

		$this->scheme = \strtolower($scheme);

		return $this;
	}

	/**
	 * Sets the URI component "user"
	 *
	 * @param string $user
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	protected function setUser(string $user) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$user = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $user);

		$this->user = $user;

		return $this;
	}

	/**
	 * Sets the URI component "pass"
	 *
	 * @param string $pass
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	protected function setPass(string $pass) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$pass = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $pass);

		$this->pass = $pass;

		return $this;
	}

	/**
	 * Sets the URI component "host"
	 *
	 * @param string $host
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.2
	 */
	protected function setHost(string $host) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$host = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $host);

		$this->host = \strtolower($host);

		return $this;
	}

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
	protected function setPort(?int $port) : UriInterface
	{
		$min = 1;
		$max = 2 ** 16;

		if (! ($port === null || ($port >= $min && $port <= $max)))
		{
			throw new Exception\InvalidUriComponentException('Invalid URI component "port"');
		}

		$this->port = $port;

		return $this;
	}

	/**
	 * Sets the URI component "path"
	 *
	 * @param string $path
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.3
	 */
	protected function setPath(string $path) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/]+)|(.?))/u';

		$path = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $path);

		$this->path = $path;

		return $this;
	}

	/**
	 * Sets the URI component "query"
	 *
	 * @param string $query
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.4
	 */
	protected function setQuery(string $query) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$query = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $query);

		$this->query = $query;

		return $this;
	}

	/**
	 * Sets the URI component "fragment"
	 *
	 * @param string $fragment
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.5
	 */
	protected function setFragment(string $fragment) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$fragment = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $fragment);

		$this->fragment = $fragment;

		return $this;
	}

	/**
	 * Parses the given URI
	 *
	 * @param string $uri
	 *
	 * @return void
	 *
	 * @throws Exception\InvalidUriException If the given value is not a valid URI
	 *
	 * @link http://php.net/manual/en/function.parse-url.php
	 */
	protected function parse(string $uri) : void
	{
		$components = \parse_url($uri);

		if ($components === false)
		{
			throw new Exception\InvalidUriException('Unable to parse URI');
		}

		if (isset($components['scheme']))
		{
			$this->setScheme($components['scheme']);
		}

		if (isset($components['user']))
		{
			$this->setUser($components['user']);
		}

		if (isset($components['pass']))
		{
			$this->setPass($components['pass']);
		}

		if (isset($components['host']))
		{
			$this->setHost($components['host']);
		}

		if (isset($components['port']))
		{
			$this->setPort($components['port']);
		}

		if (isset($components['path']))
		{
			$this->setPath($components['path']);
		}

		if (isset($components['query']))
		{
			$this->setQuery($components['query']);
		}

		if (isset($components['fragment']))
		{
			$this->setFragment($components['fragment']);
		}
	}
}
