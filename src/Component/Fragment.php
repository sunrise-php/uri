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
 * URI component "fragment"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.5
 */
class Fragment implements ComponentInterface
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
		if ('' === $value)
		{
			return;
		}
		else if (! \is_string($value))
		{
			throw new InvalidUriComponentException('URI component "fragment" must be a string');
		}

		$regex = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=\:@\/\?]+)|(.?))/u';

		$this->value = \preg_replace_callback($regex, function($match)
		{
			return isset($match[1]) ? \rawurlencode($match[1]) : $match[0];

		}, $value);
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
