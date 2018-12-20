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
 * Import classes
 */
use Sunrise\Uri\Exception\InvalidUriComponentException;

/**
 * URI component "port"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.2.3
 */
class Port implements ComponentInterface
{

	/**
	 * The component value
	 *
	 * @var null|int
	 */
	protected $value;

	/**
	 * Constructor of the class
	 *
	 * @param mixed $value
	 *
	 * @throws InvalidUriComponentException
	 */
	public function __construct($value)
	{
		$min = 1;
		$max = 2 ** 16;

		if (null === $value)
		{
			return;
		}
		else if (! \is_int($value))
		{
			throw new InvalidUriComponentException('URI component "port" must be an integer');
		}
		else if (! ($value >= $min && $value <= $max))
		{
			throw new InvalidUriComponentException('Invalid URI component "port"');
		}

		$this->value = $value;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return null|int
	 */
	public function present() : ?int
	{
		return $this->value;
	}
}
