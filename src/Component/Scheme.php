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
 * Import functions
 */
use function is_string;
use function preg_match;
use function strtolower;

/**
 * URI component "scheme"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.1
 */
class Scheme implements ComponentInterface
{

    /**
     * Regular expression to validate the component value
     *
     * @var string
     */
    private const VALIDATE_REGEX = '/^(?:[A-Za-z][0-9A-Za-z\+\-\.]*)?$/';

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
        if ($value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new InvalidUriComponentException('URI component "scheme" must be a string');
        }

        if (!preg_match(self::VALIDATE_REGEX, $value)) {
            throw new InvalidUriComponentException('Invalid URI component "scheme"');
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function present() : string
    {
        return strtolower($this->value);
    }
}
