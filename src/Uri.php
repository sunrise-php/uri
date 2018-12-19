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
		return (clone $this)->setScheme($scheme);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withUserInfo($user, $pass = null) : UriInterface
	{
		if (! (null === $pass))
		{
			return (clone $this)->setUser($user)->setPass($pass);
		}

		return (clone $this)->setUser($user);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withHost($host) : UriInterface
	{
		return (clone $this)->setHost($host);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPort($port) : UriInterface
	{
		return (clone $this)->setPort($port);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPath($path) : UriInterface
	{
		return (clone $this)->setPath($path);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withQuery($query) : UriInterface
	{
		return (clone $this)->setQuery($query);
	}

	/**
	 * {@inheritDoc}
	 */
	public function withFragment($fragment) : UriInterface
	{
		return (clone $this)->setFragment($fragment);
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
	 * Gets the URI component "userinfo"
	 *
	 * @return string
	 */
	public function getUserInfo() : string
	{
		return $this->userinfo;
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
	 * Gets the URI component "authority"
	 *
	 * @return string
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
	 * Converts the URI to string
	 *
	 * @return string
	 *
	 * @link http://php.net/manual/en/language.oop5.magic.php#object.tostring
	 */
	public function __toString()
	{
		$uri = '';

		$scheme = $this->getScheme();

		if (! ($scheme === ''))
		{
			$uri .= $scheme . ':';
		}

		$authority = $this->getAuthority();

		if (! ($authority === ''))
		{
			$uri .= '//' . $authority;
		}

		$path = $this->getPath();

		if (! ($path === ''))
		{
			$uri .= $path;
		}

		$query = $this->getQuery();

		if (! ($query === ''))
		{
			$uri .= '?' . $query;
		}

		$fragment = $this->getFragment();

		if (! ($fragment === ''))
		{
			$uri .= '#' . $fragment;
		}

		return $uri;
	}

	/**
	 * Sets the URI component "scheme"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @throws Exception\InvalidUriComponentException If the given value is not a valid URI scheme
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.1
	 */
	protected function setScheme($value) : UriInterface
	{
		$regex = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "scheme" must be a string');
		}
		else if (! \preg_match($regex, $value))
		{
			throw new Exception\InvalidUriComponentException('Invalid URI component "scheme"');
		}

		$this->scheme = \strtolower($value);

		return $this;
	}

	/**
	 * Sets the URI component "user"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	protected function setUser($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "user" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->userinfo = $value;

		return $this;
	}

	/**
	 * Sets the URI component "pass"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	protected function setPass($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "pass" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->userinfo .= ':' . $value;

		return $this;
	}

	/**
	 * Sets the URI component "host"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.2
	 */
	protected function setHost($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "host" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->host = \strtolower($value);

		return $this;
	}

	/**
	 * Sets the URI component "port"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a null or is not an integer
	 *
	 * @throws Exception\InvalidUriComponentException If the given value is not a valid URI port
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.3
	 */
	protected function setPort($value) : UriInterface
	{
		$min = 1;
		$max = 2 ** 16;

		if (! (\is_null($value) || \is_int($value)))
		{
			throw new \InvalidArgumentException('URI component "port" must be a null or an integer');
		}
		else if (! ($value === null || ($value >= $min && $value <= $max)))
		{
			throw new Exception\InvalidUriComponentException('Invalid URI component "port"');
		}

		$this->port = $value;

		return $this;
	}

	/**
	 * Sets the URI component "path"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.3
	 */
	protected function setPath($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "path" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->path = $value;

		return $this;
	}

	/**
	 * Sets the URI component "query"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.4
	 */
	protected function setQuery($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "query" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->query = $value;

		return $this;
	}

	/**
	 * Sets the URI component "fragment"
	 *
	 * @param mixed $value
	 *
	 * @return UriInterface
	 *
	 * @throws \InvalidArgumentException If the given value is not a string
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.5
	 */
	protected function setFragment($value) : UriInterface
	{
		if (! \is_string($value))
		{
			throw new \InvalidArgumentException('URI component "fragment" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);

		$this->fragment = $value;

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

		if (false === $components)
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
