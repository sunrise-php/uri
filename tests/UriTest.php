<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Uri\{Uri, UriException, UriInterface};

class UriTest extends TestCase
{
	public const TEST_URI = 'scheme://username:password@localhost:3000/path?query#fragment';

	// Constructor...

	public function testConstructor()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertInstanceOf(UriInterface::class, $uri);
	}

	// Getters...

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

		$this->assertEquals('localhost', $uri->getHost());
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

		$uri->setScheme('new-scheme');

		$this->assertEquals('new-scheme', $uri->getScheme());
	}

	public function testSetUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setUsername('new-username');

		$this->assertEquals('new-username', $uri->getUsername());
	}

	public function testSetPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPassword('new-password');

		$this->assertEquals('new-password', $uri->getPassword());
	}

	public function testSetHost()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setHost('new-host');

		$this->assertEquals('new-host', $uri->getHost());
	}

	public function testSetPort()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPort(80);

		$this->assertEquals(80, $uri->getPort());
	}

	public function testSetPath()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPath('/new-path');

		$this->assertEquals('/new-path', $uri->getPath());
	}

	public function testSetQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('new-query');

		$this->assertEquals('new-query', $uri->getQuery());
	}

	public function testSetFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('new-fragment');

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
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setScheme('scheme://');
	}

	public function testSetInvalidUsername()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setUsername('username:password');
	}

	public function testSetInvalidPassword()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPassword('username:password:');
	}

	public function testSetInvalidHost()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setHost('localhost:80');
	}

	public function testSetInvalidPortWhichIsLessThanZero()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(-1);
	}

	public function testSetInvalidPortWhichIsZero()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(0);
	}

	public function testSetInvalidPortWhichIsGreaterThanTheMaximum()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort((2 ** 16) + 1);
	}

	public function testSetInvalidPath()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPath('/path?query');
	}

	public function testSetInvalidQuery()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('query#fragment');
	}

	public function testSetInvalidFragment()
	{
		$this->expectException(UriException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('fragment#another-fragment');
	}

	// Builds...

	public function testBuildUserInfo()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username:password', $uri->getUserInfo());
	}

	public function testBuildHostPort()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('localhost:3000', $uri->getHostPort());
	}

	public function testBuildAuthority()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username:password@localhost:3000', $uri->getAuthority());
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

		$uri->setHost('LOCALHOST');

		$this->assertEquals('localhost', $uri->getHost());
	}
}
