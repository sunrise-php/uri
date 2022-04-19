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
 * Import functions
 */
use function getservbyname;
use function ltrim;
use function strncmp;

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
     * @var int|null
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
        if ($uri === '') {
            return;
        }

        $parsedUri = new UriParser($uri);

        $scheme = $parsedUri->getScheme();
        if (isset($scheme)) {
            $this->scheme = $scheme->present();
        }

        $userinfo = $parsedUri->getUserInfo();
        if (isset($userinfo)) {
            $this->userinfo = $userinfo->present();
        }

        $host = $parsedUri->getHost();
        if (isset($host)) {
            $this->host = $host->present();
        }

        $port = $parsedUri->getPort();
        if (isset($port)) {
            $this->port = $port->present();
        }

        $path = $parsedUri->getPath();
        if (isset($path)) {
            $this->path = $path->present();
        }

        $query = $parsedUri->getQuery();
        if (isset($query)) {
            $this->query = $query->present();
        }

        $fragment = $parsedUri->getFragment();
        if (isset($fragment)) {
            $this->fragment = $fragment->present();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function withScheme($scheme) : UriInterface
    {
        $clone = clone $this;
        $component = new Scheme($scheme);
        $clone->scheme = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-suppress ParamNameMismatch
     */
    public function withUserInfo($user, $pass = null) : UriInterface
    {
        $clone = clone $this;
        $component = new UserInfo($user, $pass);
        $clone->userinfo = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withHost($host) : UriInterface
    {
        $clone = clone $this;
        $component = new Host($host);
        $clone->host = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withPort($port) : UriInterface
    {
        $clone = clone $this;
        $component = new Port($port);
        $clone->port = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withPath($path) : UriInterface
    {
        $clone = clone $this;
        $component = new Path($path);
        $clone->path = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withQuery($query) : UriInterface
    {
        $clone = clone $this;
        $component = new Query($query);
        $clone->query = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withFragment($fragment) : UriInterface
    {
        $clone = clone $this;
        $component = new Fragment($fragment);
        $clone->fragment = $component->present();

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme() : string
    {
        return $this->scheme;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo() : string
    {
        return $this->userinfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort() : ?int
    {
        // The 80 is the default port number for the HTTP protocol.
        if ($this->port === 80 && $this->scheme === 'http') {
            return null;
        }

        // The 443 is the default port number for the HTTPS protocol.
        if ($this->port === 443 && $this->scheme === 'https') {
            return null;
        }

        return $this->port;
    }

    /**
     * Gets the standard port number associated with the URI scheme
     *
     * @return int|null
     *
     * @codeCoverageIgnore
     */
    public function getStandardPort() : ?int
    {
        $servicePort = getservbyname($this->scheme, 'tcp');
        if ($servicePort !== false) {
            return $servicePort;
        }

        $servicePort = getservbyname($this->scheme, 'udp');
        if ($servicePort !== false) {
            return $servicePort;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery() : string
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment() : string
    {
        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthority() : string
    {
        // Host is the basic subcomponent.
        if ($this->host === '') {
            return '';
        }

        $authority = $this->host;
        if ($this->userinfo !== '') {
            $authority = $this->userinfo . '@' . $authority;
        }

        $port = $this->getPort();
        if ($port !== null) {
            $authority = $authority . ':' . $port;
        }

        return $authority;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $uri = '';

        $scheme = $this->getScheme();
        if ($scheme !== '') {
            $uri .= $scheme . ':';
        }

        $authority = $this->getAuthority();
        if ($authority !== '') {
            $uri .= '//' . $authority;
        }

        $path = $this->getPath();
        if ($path !== '') {
            // https://github.com/sunrise-php/uri/issues/31
            // https://datatracker.ietf.org/doc/html/rfc3986#section-3.3
            //
            // If a URI contains an authority component,
            // then the path component must either be empty
            // or begin with a slash ("/") character.
            if ($authority !== '' && strncmp($path, '/', 1) !== 0) {
                $path = '/' . $path;
            }

            // https://github.com/sunrise-php/uri/issues/31
            // https://datatracker.ietf.org/doc/html/rfc3986#section-3.3
            //
            // If a URI does not contain an authority component,
            // then the path cannot begin with two slash characters ("//").
            if ($authority === '' && strncmp($path, '//', 2) === 0) {
                $path = '/' . ltrim($path, '/');
            }

            $uri .= $path;
        }

        $query = $this->getQuery();
        if ($query !== '') {
            $uri .= '?' . $query;
        }

        $fragment = $this->getFragment();
        if ($fragment !== '') {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }
}
