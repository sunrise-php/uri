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
use function preg_replace_callback;
use function rawurlencode;

/**
 * URI component "user"
 *
 * @link https://tools.ietf.org/html/rfc3986#section-3.2.1
 */
class User implements ComponentInterface
{

    /**
     * Regular expression to normalize the component value
     *
     * @var string
     */
    private const NORMALIZE_REGEX = '/(?:(?:%[0-9A-Fa-f]{2}|[0-9A-Za-z\-\._~\!\$&\'\(\)\*\+,;\=]+)|(.?))/u';

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
            throw new InvalidUriComponentException('URI component "user" must be a string');
        }

        $this->value = preg_replace_callback(self::NORMALIZE_REGEX, function (array $match) : string {
            /** @var array{0: string, 1?: string} $match */

            return isset($match[1]) ? rawurlencode($match[1]) : $match[0];
        }, $value);
    }

    /**
     * @return string
     */
    public function present() : string
    {
        return $this->value;
    }
}
