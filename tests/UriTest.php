<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Sunrise\Collection\CollectionInterface;
use Sunrise\Uri\Exception\Exception;
use Sunrise\Uri\Exception\InvalidUriComponentException;
use Sunrise\Uri\Exception\InvalidUriException;
use Sunrise\Uri\Uri;

class UriTest extends TestCase
{
	public const TEST_URI = 'scheme://username:password@host:3000/path?query#fragment';

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

		new Uri(':');
	}

	// Getters...

	public function testGetPayload()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(CollectionInterface::class, $uri->getPayload());
	}

	public function testGetScheme()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('scheme', $uri->getScheme());
	}

	public function testGetUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username', $uri->getUsername());
	}

	public function testGetPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('password', $uri->getPassword());
	}

	public function testGetHost()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('host', $uri->getHost());
	}

	public function testGetPort()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals(3000, $uri->getPort());
	}

	public function testGetPath()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('/path', $uri->getPath());
	}

	public function testGetQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('query', $uri->getQuery());
	}

	public function testGetFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('fragment', $uri->getFragment());
	}

	// Setters...

	public function testSetScheme()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setScheme('new-scheme'));

		$this->assertEquals('new-scheme', $uri->getScheme());
	}

	public function testSetUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setUsername('new-username'));

		$this->assertEquals('new-username', $uri->getUsername());
	}

	public function testSetPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setPassword('new-password'));

		$this->assertEquals('new-password', $uri->getPassword());
	}

	public function testSetHost()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setHost('new-host'));

		$this->assertEquals('new-host', $uri->getHost());
	}

	public function testSetPort()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setPort(80));

		$this->assertEquals(80, $uri->getPort());
	}

	public function testSetPath()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setPath('/new-path'));

		$this->assertEquals('/new-path', $uri->getPath());
	}

	public function testSetQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setQuery('new-query'));

		$this->assertEquals('new-query', $uri->getQuery());

		$this->assertEquals(['new-query' => ''], $uri->getPayload()->toArray());
	}

	public function testSetFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri->setFragment('new-fragment'));

		$this->assertEquals('new-fragment', $uri->getFragment());
	}

	// Setters with empty data...

	public function testSetEmptyScheme()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setScheme('');

		$this->assertEquals('', $uri->getScheme());
	}

	public function testSetEmptyUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setUsername('');

		$this->assertEquals('', $uri->getUsername());
	}

	public function testSetEmptyPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPassword('');

		$this->assertEquals('', $uri->getPassword());
	}

	public function testSetEmptyHost()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setHost('');

		$this->assertEquals('', $uri->getHost());
	}

	public function testSetEmptyPort()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPort(null);

		$this->assertEquals(null, $uri->getPort());
	}

	public function testSetEmptyPath()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPath('');

		$this->assertEquals('', $uri->getPath());
	}

	public function testSetEmptyQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('');

		$this->assertEquals('', $uri->getQuery());

		$this->assertEquals([], $uri->getPayload()->toArray());
	}

	public function testSetEmptyFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('');

		$this->assertEquals('', $uri->getFragment());
	}

	// Setters with invalid data...

	public function testSetInvalidScheme()
	{
		$this->expectException(InvalidUriComponentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setScheme('scheme://');
	}

	public function testSetInvalidUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setUsername('username:password');

		$this->assertEquals('username%3Apassword', $uri->getUsername(), '', 0.0, 10, false, true);
	}

	public function testSetInvalidPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPassword('username:password');

		$this->assertEquals('username%3Apassword', $uri->getPassword(), '', 0.0, 10, false, true);
	}

	public function testSetInvalidHost()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setHost('host:80');

		$this->assertEquals('host%3A80', $uri->getHost(), '', 0.0, 10, false, true);
	}

	public function testSetInvalidPortWhichIsLessThanZero()
	{
		$this->expectException(InvalidUriComponentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(-1);
	}

	public function testSetInvalidPortWhichIsZero()
	{
		$this->expectException(InvalidUriComponentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(0);
	}

	public function testSetInvalidPortWhichIsTooLarge()
	{
		$this->expectException(InvalidUriComponentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort((2 ** 16) + 1);
	}

	public function testSetInvalidPath()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPath('/path?query');

		$this->assertEquals('/path%3Fquery', $uri->getPath(), '', 0.0, 10, false, true);
	}

	public function testSetInvalidQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('query#fragment');

		$this->assertEquals('query%23fragment', $uri->getQuery(), '', 0.0, 10, false, true);
	}

	public function testSetInvalidFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('fragment#another-fragment');

		$this->assertEquals('fragment%23another-fragment', $uri->getFragment(), '', 0.0, 10, false, true);
	}

	// Builds...

	public function testBuildUserInfo()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username:password', $uri->getUserInfo());

		$uri->setPassword('');
		$this->assertEquals('username', $uri->getUserInfo());

		$uri->setUsername('');
		$this->assertEquals('', $uri->getUserInfo());

		$uri->setPassword('password');
		$this->assertEquals('', $uri->getUserInfo());
	}

	public function testBuildHostPort()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('host:3000', $uri->getHostPort());

		$uri->setPort(null);
		$this->assertEquals('host', $uri->getHostPort());

		$uri->setHost('');
		$this->assertEquals('', $uri->getHostPort());

		$uri->setPort(3000);
		$this->assertEquals('', $uri->getHostPort());
	}

	public function testBuildAuthority()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username:password@host:3000', $uri->getAuthority());
	}

	public function testBuildFullUri()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals(self::TEST_URI, $uri->toString());
	}

	// Normalizes...

	public function testNormalizeSchemeToLowerCase()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setScheme('SCHEME');

		$this->assertEquals('scheme', $uri->getScheme());
	}

	public function testNormalizeHostToLowerCase()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setHost('HOST');

		$this->assertEquals('host', $uri->getHost());
	}

	// Payload...

	public function testPayload()
	{
		$uri = new Uri('/?string=value&array%5B%5D=1&array%5B%5D=2&array%5B%5D=3');

		$this->assertEquals(['string' => 'value', 'array' => [1, 2, 3]], $uri->getPayload()->toArray());
	}

	public function testUpdatePayload()
	{
		$uri = new Uri('/?string=value');

		$uri->setQuery('new-string=new-value');

		$this->assertEquals(['new-string' => 'new-value'], $uri->getPayload()->toArray());
	}

	// Exceptions...

	public function testException()
	{
		$this->expectException(\RuntimeException::class);

		new Uri(':');
	}

	public function testInvalidUriException()
	{
		$this->expectException(Exception::class);

		new Uri(':');
	}

	public function testInvalidUriComponentException()
	{
		$this->expectException(Exception::class);

		(new Uri(self::TEST_URI))->setScheme('scheme://');
	}

	// PSR-7

	public function testWithScheme()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withScheme('new-scheme');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('scheme', $uri->getScheme());
		$this->assertEquals('new-scheme', $copy->getScheme());
	}

	public function testWithUserInfo()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withUserInfo('new-username', 'new-password');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('username', $uri->getUsername());
		$this->assertEquals('new-username', $copy->getUsername());

		$this->assertEquals('password', $uri->getPassword());
		$this->assertEquals('new-password', $copy->getPassword());
	}

	public function testWithUserInfoWithoutPassword()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withUserInfo('new-username');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('username', $uri->getUsername());
		$this->assertEquals('new-username', $copy->getUsername());

		$this->assertEquals('password', $uri->getPassword());
		$this->assertEquals('password', $copy->getPassword());
	}

	public function testWithHost()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withHost('new-host');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('host', $uri->getHost());
		$this->assertEquals('new-host', $copy->getHost());
	}

	public function testWithPort()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withPort(80);

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals(3000, $uri->getPort());
		$this->assertEquals(80, $copy->getPort());
	}

	public function testWithPath()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withPath('/new-path');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('/path', $uri->getPath());
		$this->assertEquals('/new-path', $copy->getPath());
	}

	public function testWithQuery()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withQuery('new-query');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('query', $uri->getQuery());
		$this->assertEquals('new-query', $copy->getQuery());
	}

	public function testWithFragment()
	{
		$uri = new Uri(self::TEST_URI);
		$copy = $uri->withFragment('new-fragment');

		$this->assertInstanceOf(UriInterface::class, $copy);
		$this->assertNotEquals($uri, $copy);

		$this->assertEquals('fragment', $uri->getFragment());
		$this->assertEquals('new-fragment', $copy->getFragment());
	}

	public function testMagicToString()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals(self::TEST_URI, (string) $uri);
	}
}
