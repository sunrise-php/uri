<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Uri\UriParser;
use Sunrise\Uri\Exception\InvalidUriException;

class UriParserTest extends TestCase
{
	public const TEST_URI = 'scheme://user:pass@host:3000/path?query#fragment';

	public function testConstructor()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertInstanceOf(UriParser::class, $uri);
	}

	public function testConstructorWithInvalidString()
	{
		$this->expectException(InvalidUriException::class);
		$this->expectExceptionMessage('URI must be a string');

		$uri = new UriParser(1234456);
	}

	public function testGetScheme()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('scheme', $uri->getScheme()->present());
	}

	public function testGetUser()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('user', $uri->getUser()->present());
	}

	public function testGetPass()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('pass', $uri->getPass()->present());
	}

	public function testGetHost()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('host', $uri->getHost()->present());
	}

	public function testGetPort()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals(3000, $uri->getPort()->present());
	}

	public function testGetPath()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('/path', $uri->getPath()->present());
	}

	public function testGetQuery()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('query', $uri->getQuery()->present());
	}

	public function testGetFragment()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('fragment', $uri->getFragment()->present());
	}

	public function testGetUserInfo()
	{
		$uri = new UriParser(self::TEST_URI);

		$this->assertEquals('user:pass', $uri->getUserInfo()->present());
	}
}
