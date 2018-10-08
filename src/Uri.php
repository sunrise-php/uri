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
use Sunrise\Collection\Collection;

/**
 * Uri
 *
 * @package Sunrise\Uri
 */
class Uri implements UriInterface
{

	/**
	 * Payload of the URI
	 *
	 * @var \Sunrise\Collection\Collection
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
	 * {@inheritDoc}
	 *
	 * @throws \Sunrise\Uri\UriException
	 */
	public function __construct(string $uri)
	{
		$components = \parse_url($uri);

		if ($components === false)
		{
			throw new UriException('Unable to parse URI');
		}

		$this->payload = new Collection();

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

	/**
	 * {@inheritDoc}
	 *
	 * @throws \Sunrise\Uri\UriException
	 */
	public function setScheme(string $scheme) : UriInterface
	{
		$regex = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

		if (! \preg_match($regex, $scheme))
		{
			throw new UriException('Invalid URI component "scheme"');
		}

		$this->scheme = \strtolower($scheme);

		return $this;
	}

	/**
	 * {@inheritDoc}
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
	 * {@inheritDoc}
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
	 * {@inheritDoc}
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
	 * {@inheritDoc}
	 *
	 * @throws \Sunrise\Uri\UriException
	 */
	public function setPort(?int $port) : UriInterface
	{
		$min = 1;
		$max = 2 ** 16;

		if (! ($port === null || ($port >= $min && $port <= $max)))
		{
			throw new UriException('Invalid URI component "port"');
		}

		$this->port = $port;

		return $this;
	}

	/**
	 * {@inheritDoc}
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
	 * {@inheritDoc}
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
	 * {@inheritDoc}
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
	 * {@inheritDoc}
	 */
	public function getPayload() : Collection
	{
		return $this->payload;
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
