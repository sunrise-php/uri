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
 * URI component "scheme"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.1
 */
class Scheme implements ComponentInterface
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
	 * @param mixed $value
	 *
	 * @throws InvalidUriComponentException
	 */
	public function __construct($value)
	{
		$regex = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

		if ('' === $value)
		{
			return;
		}
		else if (! \is_string($value))
		{
			throw new InvalidUriComponentException('URI component "scheme" must be a string');
		}
		else if (! \preg_match($regex, $value))
		{
			throw new InvalidUriComponentException('Invalid URI component "scheme"');
		}

		$this->value = $value;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return string
	 */
	public function present() : string
	{
		return \strtolower($this->value);
	}
}
