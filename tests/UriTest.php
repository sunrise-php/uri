<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Sunrise\Uri\Exception\InvalidUriComponentException;
use Sunrise\Uri\Exception\InvalidUriException;
use Sunrise\Uri\Uri;

class UriTest extends TestCase
{
    public const TEST_URI = 'scheme://user:pass@host:3000/path?query#fragment';

    // Constructor...

    public function testConstructor()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testConstructorWithoutUri()
    {
        $uri = new Uri();

        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testConstructorWithEmptyUri()
    {
        $uri = new Uri('');

        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testConstructorWithInvalidUri()
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionMessage('Unable to parse URI');

        new Uri(':');
    }

    // Getters...

    public function testGetScheme()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('scheme', $uri->getScheme());
    }

    public function testGetUserInfo()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('user:pass', $uri->getUserInfo());
    }

    public function testGetHost()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('host', $uri->getHost());
    }

    public function testGetPort()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame(3000, $uri->getPort());
    }

    public function testGetPath()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('/path', $uri->getPath());
    }

    public function testGetQuery()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('query', $uri->getQuery());
    }

    public function testGetFragment()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('fragment', $uri->getFragment());
    }

    public function testGetStandardPort() : void
    {
        $uri = new Uri('http://host:3000');
        $this->assertSame(80, $uri->getStandardPort());

        $uri = new Uri('https://host:3000');
        $this->assertSame(443, $uri->getStandardPort());

        $uri = new Uri('ftp://host:3000');
        $this->assertSame(21, $uri->getStandardPort());
    }

    // Withers...

    public function testWithScheme()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withScheme('new-scheme');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('scheme', $uri->getScheme());
        $this->assertSame('new-scheme', $copy->getScheme());
    }

    public function testWithUserInfo()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withUserInfo('new-user', 'new-pass');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('user:pass', $uri->getUserInfo());
        $this->assertSame('new-user:new-pass', $copy->getUserInfo());
    }

    public function testWithUserInfoWithoutPass()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withUserInfo('new-user');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('user:pass', $uri->getUserInfo());
        $this->assertSame('new-user', $copy->getUserInfo());
    }

    public function testWithHost()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withHost('new-host');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('host', $uri->getHost());
        $this->assertSame('new-host', $copy->getHost());
    }

    public function testWithPort()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withPort(80);

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame(3000, $uri->getPort());
        $this->assertSame(80, $copy->getPort());
    }

    public function testWithPath()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withPath('/new-path');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('/path', $uri->getPath());
        $this->assertSame('/new-path', $copy->getPath());
    }

    public function testWithQuery()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withQuery('new-query');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('query', $uri->getQuery());
        $this->assertSame('new-query', $copy->getQuery());
    }

    public function testWithFragment()
    {
        $uri = new Uri(self::TEST_URI);
        $copy = $uri->withFragment('new-fragment');

        $this->assertInstanceOf(UriInterface::class, $copy);
        $this->assertNotEquals($uri, $copy);

        $this->assertSame('fragment', $uri->getFragment());
        $this->assertSame('new-fragment', $copy->getFragment());
    }

    // Withers with empty data...

    public function testWithEmptyScheme()
    {
        $uri = (new Uri(self::TEST_URI))->withScheme('');

        $this->assertSame('', $uri->getScheme());
    }

    public function testWithEmptyUserInfo()
    {
        $uri = (new Uri(self::TEST_URI))->withUserInfo('');

        $this->assertSame('', $uri->getUserInfo());
    }

    public function testWithEmptyHost()
    {
        $uri = (new Uri(self::TEST_URI))->withHost('');

        $this->assertSame('', $uri->getHost());
    }

    public function testWithEmptyPort()
    {
        $uri = (new Uri(self::TEST_URI))->withPort(null);

        $this->assertNull($uri->getPort());
    }

    public function testWithEmptyPath()
    {
        $uri = (new Uri(self::TEST_URI))->withPath('');

        $this->assertSame('', $uri->getPath());
    }

    public function testWithEmptyQuery()
    {
        $uri = (new Uri(self::TEST_URI))->withQuery('');

        $this->assertSame('', $uri->getQuery());
    }

    public function testWithEmptyFragment()
    {
        $uri = (new Uri(self::TEST_URI))->withFragment('');

        $this->assertSame('', $uri->getFragment());
    }

    // Withers with invalid data...

    public function testWithInvalidScheme()
    {
        $this->expectException(InvalidUriComponentException::class);
        $this->expectExceptionMessage('Invalid URI component "scheme"');

        (new Uri(self::TEST_URI))->withScheme('scheme:');
    }

    public function testWithInvalidUserInfo()
    {
        $uri = (new Uri(self::TEST_URI))->withUserInfo('user:pass', 'user:pass');

        $this->assertSame('user%3Apass:user%3Apass', $uri->getUserInfo(), '', 0.0, 10, false, true);
    }

    public function testWithInvalidHost()
    {
        $uri = (new Uri(self::TEST_URI))->withHost('host:80');

        // %3A or %3a
        $expected = \strtolower('host%3A80');

        $this->assertSame($expected, $uri->getHost(), '', 0.0, 10, false, true);
    }

    public function testWithInvalidPortIsLessThanZero()
    {
        $this->expectException(InvalidUriComponentException::class);
        $this->expectExceptionMessage('Invalid URI component "port"');

        (new Uri(self::TEST_URI))->withPort(-1);
    }

    public function testWithInvalidPortIsZero()
    {
        $this->expectException(InvalidUriComponentException::class);
        $this->expectExceptionMessage('Invalid URI component "port"');

        (new Uri(self::TEST_URI))->withPort(0);
    }

    public function testWithInvalidPortIsTooLarge()
    {
        $this->expectException(InvalidUriComponentException::class);
        $this->expectExceptionMessage('Invalid URI component "port"');

        (new Uri(self::TEST_URI))->withPort((2 ** 16) + 1);
    }

    public function testWithInvalidPath()
    {
        $uri = (new Uri(self::TEST_URI))->withPath('/path?query');

        $this->assertSame('/path%3Fquery', $uri->getPath(), '', 0.0, 10, false, true);
    }

    public function testWithInvalidQuery()
    {
        $uri = (new Uri(self::TEST_URI))->withQuery('query#fragment');

        $this->assertSame('query%23fragment', $uri->getQuery(), '', 0.0, 10, false, true);
    }

    public function testWithInvalidFragment()
    {
        $uri = (new Uri(self::TEST_URI))->withFragment('fragment#fragment');

        $this->assertSame('fragment%23fragment', $uri->getFragment(), '', 0.0, 10, false, true);
    }

    // Withers with invalid data types...

    /**
     * @dataProvider invalidDataTypeProviderForScheme
     */
    public function testWithInvalidDataTypeForScheme($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "scheme" must be a string');

        (new Uri)->withScheme($value);
    }

    public function invalidDataTypeProviderForScheme()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForUser
     */
    public function testWithInvalidDataTypeForUser($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "user" must be a string');

        (new Uri)->withUserInfo($value);
    }

    public function invalidDataTypeProviderForUser()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForPass
     */
    public function testWithInvalidDataTypeForPass($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "pass" must be a string');

        (new Uri)->withUserInfo('user', $value);
    }

    public function invalidDataTypeProviderForPass()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForHost
     */
    public function testWithInvalidDataTypeForHost($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "host" must be a string');

        (new Uri)->withHost($value);
    }

    public function invalidDataTypeProviderForHost()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForPort
     */
    public function testWithInvalidDataTypeForPort($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "port" must be an integer');

        (new Uri)->withPort($value);
    }

    public function invalidDataTypeProviderForPort()
    {
        return [
            [true],
            [false],
            ['a'],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForPath
     */
    public function testWithInvalidDataTypeForPath($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "path" must be a string');

        (new Uri)->withPath($value);
    }

    public function invalidDataTypeProviderForPath()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForQuery
     */
    public function testWithInvalidDataTypeForQuery($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "query" must be a string');

        (new Uri)->withQuery($value);
    }

    public function invalidDataTypeProviderForQuery()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    /**
     * @dataProvider invalidDataTypeProviderForFragment
     */
    public function testWithInvalidDataTypeForFragment($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI component "fragment" must be a string');

        (new Uri)->withFragment($value);
    }

    public function invalidDataTypeProviderForFragment()
    {
        return [
            [true],
            [false],
            [0],
            [0.0],
            [[]],
            [new \stdClass],
            [\STDOUT],
            [null],
            [function () {
            }],
        ];
    }

    // Builders...

    public function testGetAuthority()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame('user:pass@host:3000', $uri->getAuthority());

        $this->assertSame('', $uri->withHost('')->getAuthority());

        $this->assertSame('host:3000', $uri->withUserInfo('')->getAuthority());

        $this->assertSame('user@host:3000', $uri->withUserInfo('user')->getAuthority());

        $this->assertSame('user:pass@host', $uri->withPort(null)->getAuthority());
    }

    public function testToString()
    {
        $uri = new Uri(self::TEST_URI);

        $this->assertSame(self::TEST_URI, (string) $uri);
    }

    public function testToStringIssue31()
    {
        $uri = new Uri('//username@hostname');
        $uri = $uri->withPath('pathname');
        $this->assertSame('//username@hostname/pathname', $uri->__toString());

        $uri = new Uri('scheme:');
        $uri = $uri->withPath('//pathname');
        $this->assertSame('scheme:/pathname', $uri->__toString());

        $uri = new Uri('scheme:');
        $uri = $uri->withPath('///pathname');
        $this->assertSame('scheme:/pathname', $uri->__toString());
    }

    // Normalizes...

    public function testNormalizeScheme()
    {
        $uri = new Uri(self::TEST_URI);

        $uri = $uri->withScheme('UPPERCASED-SCHEME');

        $this->assertSame('uppercased-scheme', $uri->getScheme());
    }

    public function testNormalizeHost()
    {
        $uri = new Uri(self::TEST_URI);

        $uri = $uri->withHost('UPPERCASED-HOST');

        $this->assertSame('uppercased-host', $uri->getHost());
    }

    // Exceptions...

    public function testExceptions()
    {
        $this->assertInstanceOf(\InvalidArgumentException::class, new InvalidUriComponentException(''));
        $this->assertInstanceOf(\InvalidArgumentException::class, new InvalidUriException(''));
    }

    // Ignoring the standard ports

    public function testIgnoringStandardPorts()
    {
        $uri = new Uri('http://example.com:80/');
        $this->assertNull($uri->getPort());
        $this->assertSame('example.com', $uri->getAuthority());
        $this->assertSame('http://example.com/', (string) $uri);

        $uri = new Uri('https://example.com:443/');
        $this->assertNull($uri->getPort());
        $this->assertSame('example.com', $uri->getAuthority());
        $this->assertSame('https://example.com/', (string) $uri);

        $uri = new Uri('http://example.com:443/');
        $this->assertSame(443, $uri->getPort());
        $this->assertSame('example.com:443', $uri->getAuthority());
        $this->assertSame('http://example.com:443/', (string) $uri);

        $uri = new Uri('https://example.com:80/');
        $this->assertSame(80, $uri->getPort());
        $this->assertSame('example.com:80', $uri->getAuthority());
        $this->assertSame('https://example.com:80/', (string) $uri);
    }

    // Another schemes...

    public function testMailtoScheme()
    {
        $uri = new Uri('mailto:test@example.com');

        $this->assertSame('mailto', $uri->getScheme());
        $this->assertSame('test@example.com', $uri->getPath());
    }

    public function testMapsScheme()
    {
        $uri = new Uri('maps:?q=112+E+Chapman+Ave+Orange,+CA+92866');

        $this->assertSame('maps', $uri->getScheme());
        $this->assertSame('q=112+E+Chapman+Ave+Orange,+CA+92866', $uri->getQuery());
    }

    public function testTelScheme()
    {
        $uri = new Uri('tel:+1-816-555-1212');

        $this->assertSame('tel', $uri->getScheme());
        $this->assertSame('+1-816-555-1212', $uri->getPath());
    }

    public function testUrnScheme()
    {
        $uri = new Uri('urn:oasis:names:specification:docbook:dtd:xml:4.1.2');

        $this->assertSame('urn', $uri->getScheme());
        $this->assertSame('oasis:names:specification:docbook:dtd:xml:4.1.2', $uri->getPath());
    }
}
