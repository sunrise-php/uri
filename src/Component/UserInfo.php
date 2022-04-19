<?php declare(strict_types=1);

/**
 * It's free open-source software released under the MIT License.
 *
 * @author Anatoly Fenric <anatoly@fenric.ru>
 * @copyright Copyright (c) 2018, Anatoly Fenric
 * @license https://github.com/sunrise-php/uri/blob/master/LICENSE
 * @link https://github.com/sunrise-php/uri
 */

namespace Sunrise\Uri\Component;

/**
 * URI component "userinfo"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
 */
class UserInfo implements ComponentInterface
{

    /**
     * URI component "user"
     *
     * @var User
     */
    protected $user;

    /**
     * URI component "pass"
     *
     * @var Pass|null
     */
    protected $pass;

    /**
     * Constructor of the class
     *
     * @param mixed $user
     * @param mixed $pass
     */
    public function __construct($user, $pass = null)
    {
        $this->user = $user instanceof User ? $user : new User($user);

        if (isset($pass)) {
            $this->pass = $pass instanceof Pass ? $pass : new Pass($pass);
        }
    }

    /**
     * @return string
     */
    public function present() : string
    {
        $result = $this->user->present();

        if (isset($this->pass)) {
            $result .= ':' . $this->pass->present();
        }

        return $result;
    }
}
