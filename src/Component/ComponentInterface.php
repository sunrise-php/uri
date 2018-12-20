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
 * ComponentInterface
 */
interface ComponentInterface
{

	/**
	 * Presents the component value
	 *
	 * @return mixed
	 */
	public function present();
}
