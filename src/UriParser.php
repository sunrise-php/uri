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
 * Import functions
 */
use function is_string;
use function parse_url;

/**
 * UriParser
 */
class UriParser
{

    /**
     * The parsed URI component "scheme"
     *
     * @var Scheme
     */
    protected $scheme;

    /**
     * The parsed URI component "user"
     *
     * @var User
     */
    protected $user;

    /**
     * The parsed URI component "pass"
     *
     * @var Pass
     */
    protected $pass;

    /**
     * The parsed URI component "host"
     *
     * @var Host
     */
    protected $host;

    /**
     * The parsed URI component "port"
     *
     * @var Port
     */
    protected $port;

    /**
     * The parsed URI component "path"
     *
     * @var Path
     */
    protected $path;

    /**
     * The parsed URI component "query"
     *
     * @var Query
     */
    protected $query;

    /**
     * The parsed URI component "fragment"
     *
     * @var Fragment
     */
    protected $fragment;

    /**
     * The parsed URI component "userinfo"
     *
     * @var UserInfo
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
        if (!is_string($uri)) {
            throw new InvalidUriException('URI must be a string');
        }

        $components = parse_url($uri);
        if ($components === false) {
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
     * @return Scheme
     */
    public function getScheme() : Scheme
    {
        return $this->scheme;
    }

    /**
     * Gets the parsed URI component "user"
     *
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * Gets the parsed URI component "pass"
     *
     * @return Pass
     */
    public function getPass() : Pass
    {
        return $this->pass;
    }

    /**
     * Gets the parsed URI component "host"
     *
     * @return Host
     */
    public function getHost() : Host
    {
        return $this->host;
    }

    /**
     * Gets the parsed URI component "port"
     *
     * @return Port
     */
    public function getPort() : Port
    {
        return $this->port;
    }

    /**
     * Gets the parsed URI component "path"
     *
     * @return Path
     */
    public function getPath() : Path
    {
        return $this->path;
    }

    /**
     * Gets the parsed URI component "query"
     *
     * @return Query
     */
    public function getQuery() : Query
    {
        return $this->query;
    }

    /**
     * Gets the parsed URI component "fragment"
     *
     * @return Fragment
     */
    public function getFragment() : Fragment
    {
        return $this->fragment;
    }

    /**
     * Gets the parsed URI component "userinfo"
     *
     * @return UserInfo
     */
    public function getUserInfo() : UserInfo
    {
        return $this->userinfo;
    }
}
