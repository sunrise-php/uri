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
	 * The component value
	 *
	 * @var string
	 */
	protected $value = '';

	/**
	 * Constructor of the class
	 *
	 * @param mixed $user
	 * @param mixed $pass
	 */
	public function __construct($user, $pass = null)
	{
		$user = new User($user);

		$this->value = $user->present();

		if (! (null === $pass))
		{
			$pass = new Pass($pass);

			$this->value .= ':' . $pass->present();
		}
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return string
	 */
	public function present() : string
	{
		return $this->value;
	}
}
