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
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * UriFactory
 *
 * @link https://www.php-fig.org/psr/psr-17/
 */
class UriFactory implements UriFactoryInterface
{

	/**
	 * {@inheritDoc}
	 */
	public function createUri(string $uri = '') : UriInterface
	{
		return new Uri($uri);
	}
}
