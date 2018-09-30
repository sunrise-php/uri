<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Uri\{Uri, UriInterface};

class UriTest extends TestCase
{
	public const TEST_URI = 'scheme://username:password@localhost:8080/path?query#fragment';

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

		$this->assertEquals(8080, $uri->getPort());
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

		$uri->setScheme('redefinedScheme');

		$this->assertEquals('redefinedScheme', $uri->getScheme());
	}

	public function testSetUsername()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setUsername('redefinedUsername');

		$this->assertEquals('redefinedUsername', $uri->getUsername());
	}

	public function testSetPassword()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPassword('redefinedPassword');

		$this->assertEquals('redefinedPassword', $uri->getPassword());
	}

	public function testSetHost()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setHost('redefinedHost');

		$this->assertEquals('redefinedHost', $uri->getHost());
	}

	public function testSetPort()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPort(666);

		$this->assertEquals(666, $uri->getPort());
	}

	public function testSetPath()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setPath('/redefinedPath');

		$this->assertEquals('/redefinedPath', $uri->getPath());
	}

	public function testSetQuery()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('redefinedQuery');

		$this->assertEquals('redefinedQuery', $uri->getQuery());
	}

	public function testSetFragment()
	{
		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('redefinedFragment');

		$this->assertEquals('redefinedFragment', $uri->getFragment());
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
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setScheme(':invalidScheme:');
	}

	public function testSetInvalidUsername()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setUsername(':invalidUsername:');
	}

	public function testSetInvalidPassword()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPassword(':invalidPassword:');
	}

	public function testSetInvalidHost()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setHost(':invalidHost:');
	}

	public function testSetInvalidPortWhichIsLessThanZero()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(-1);
	}

	public function testSetInvalidPortWhichIsZero()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort(0);
	}

	public function testSetInvalidPortWhichIsGreaterThanTheMaximum()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPort((2 ** 16) + 1);
	}

	public function testSetInvalidPath()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setPath('?invalidPath?');
	}

	public function testSetInvalidQuery()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setQuery('#invalidQuery#');
	}

	public function testSetInvalidFragment()
	{
		$this->expectException(\InvalidArgumentException::class);

		$uri = new Uri(self::TEST_URI);

		$uri->setFragment('#invalidFragment#');
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

		$this->assertEquals('localhost:8080', $uri->getHostPort());
	}

	public function testBuildAuthority()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals('username:password@localhost:8080', $uri->getAuthority());
	}

	public function testBuildFullUri()
	{
		$uri = new Uri(self::TEST_URI);

		$this->assertEquals(self::TEST_URI, $uri->toString());
	}
}
