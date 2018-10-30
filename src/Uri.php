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
use Sunrise\Collection\Collection;
use Sunrise\Collection\CollectionInterface;
use Sunrise\Uri\Exception\InvalidUriComponentException;
use Sunrise\Uri\Exception\InvalidUriException;

/**
 * Uniform Resource Identifier
 *
 * @link https://tools.ietf.org/html/rfc3986
 * @link https://www.php-fig.org/psr/psr-7/
 */
class Uri implements UriInterface
{

	/**
	 * Payload of the URI
	 *
	 * @var CollectionInterface
	 */
	protected $payload;

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
	 * Constructor of the class
	 *
	 * @param string $uri
	 */
	public function __construct(string $uri = '')
	{
		$this->payload = new Collection();

		if (! ('' === $uri))
		{
			$this->parse($uri);
		}
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
	public function setScheme(string $scheme) : UriInterface
	{
		$regex = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

		if (! \preg_match($regex, $scheme))
		{
			throw new InvalidUriComponentException('Invalid URI component "scheme"');
		}

		$this->scheme = \strtolower($scheme);

		return $this;
	}

	/**
	 * Sets the URI component "username"
	 *
	 * @param string $username
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setUsername(string $username) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$username = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $username);

		$this->username = $username;

		return $this;
	}

	/**
	 * Sets the URI component "password"
	 *
	 * @param string $password
	 *
	 * @return UriInterface
	 *
	 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
	 */
	public function setPassword(string $password) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

		$password = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $password);

		$this->password = $password;

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
	public function setHost(string $host) : UriInterface
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
	public function setPort(?int $port) : UriInterface
	{
		$min = 1;
		$max = 2 ** 16;

		if (! ($port === null || ($port >= $min && $port <= $max)))
		{
			throw new InvalidUriComponentException('Invalid URI component "port"');
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
	public function setPath(string $path) : UriInterface
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
	public function setQuery(string $query) : UriInterface
	{
		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$query = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $query);

		$this->query = $query;

		\parse_str(\rawurldecode($query), $payload);

		$this->getPayload()->clear()->update($payload);

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
	public function setFragment(string $fragment) : UriInterface
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
	 * Gets the URI payload
	 *
	 * @return CollectionInterface
	 */
	public function getPayload() : CollectionInterface
	{
		return $this->payload;
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
	 * Gets the URI component "username"
	 *
	 * @return string
	 */
	public function getUsername() : string
	{
		return $this->username;
	}

	/**
	 * Gets the URI component "password"
	 *
	 * @return string
	 */
	public function getPassword() : string
	{
		return $this->password;
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
				$result .= ':' . $this->getPort();
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
	 * {@inheritDoc}
	 */
	public function withScheme($scheme) : UriInterface
	{
		$clone = clone $this;

		$clone->setScheme($scheme);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withUserInfo($username, $password = null) : UriInterface
	{
		$clone = clone $this;

		$clone->setUsername($username);

		if (! (null === $password))
		{
			$clone->setPassword($password);
		}

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withHost($host) : UriInterface
	{
		$clone = clone $this;

		$clone->setHost($host);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPort($port) : UriInterface
	{
		$clone = clone $this;

		$clone->setPort($port);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withPath($path) : UriInterface
	{
		$clone = clone $this;

		$clone->setPath($path);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withQuery($query) : UriInterface
	{
		$clone = clone $this;

		$clone->setQuery($query);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withFragment($fragment) : UriInterface
	{
		$clone = clone $this;

		$clone->setFragment($fragment);

		return $clone;
	}

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		return $this->toString();
	}

	/**
	 * Parses the given URI
	 *
	 * @param string $uri
	 *
	 * @return void
	 *
	 * @throws Exception\InvalidUriException If the given value is not a valid URI
	 */
	protected function parse(string $uri) : void
	{
		$components = \parse_url($uri);

		if ($components === false)
		{
			throw new InvalidUriException('Unable to parse URI');
		}

		if (isset($components['scheme']))
		{
			$this->setScheme($components['scheme']);
		}

		if (isset($components['user']))
		{
			$this->setUsername($components['user']);
		}

		if (isset($components['pass']))
		{
			$this->setPassword($components['pass']);
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
