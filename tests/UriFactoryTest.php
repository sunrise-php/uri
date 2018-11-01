<?php

namespace Sunrise\Uri\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Sunrise\Uri\UriFactory;

class UriFactoryTest extends TestCase
{
	public function testConstructor()
	{
		$factory = new UriFactory();

		$this->assertInstanceOf(UriFactoryInterface::class, $factory);
	}

	public function testCreateUri()
	{
		$uri = (new UriFactory)->createUri('/');

		$this->assertInstanceOf(UriInterface::class, $uri);

		$this->assertEquals('/', $uri->getPath());
	}

	public function testCreateUriWithoutUri()
	{
		$uri = (new UriFactory)->createUri();

		$this->assertInstanceOf(UriInterface::class, $uri);

		$this->assertEquals('', $uri->getPath());
	}

	public function testCreateUriWithEmptyUri()
	{
		$uri = (new UriFactory)->createUri('');

		$this->assertInstanceOf(UriInterface::class, $uri);

		$this->assertEquals('', $uri->getPath());
	}

	public function testCreateUriFromServer()
	{
		$uri = (new UriFactory)->createUriFromServer([]);
		$this->assertEquals('http://localhost/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['HTTPS' => 'off']);
		$this->assertEquals('http://localhost/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['HTTPS' => 'on']);
		$this->assertEquals('https://localhost/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['HTTP_HOST' => 'example.com']);
		$this->assertEquals('http://example.com/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['HTTP_HOST' => 'example.com:3000']);
		$this->assertEquals('http://example.com:3000/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['SERVER_NAME' => 'example.com']);
		$this->assertEquals('http://example.com/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['SERVER_NAME' => 'example.com', 'SERVER_PORT' => 3000]);
		$this->assertEquals('http://example.com:3000/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['SERVER_PORT' => 3000]);
		$this->assertEquals('http://localhost/', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['REQUEST_URI' => '/path']);
		$this->assertEquals('http://localhost/path', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['REQUEST_URI' => '/path?query']);
		$this->assertEquals('http://localhost/path?query', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['PHP_SELF' => '/path']);
		$this->assertEquals('http://localhost/path', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['PHP_SELF' => '/path', 'QUERY_STRING' => 'query']);
		$this->assertEquals('http://localhost/path?query', $uri->toString());

		$uri = (new UriFactory)->createUriFromServer(['QUERY_STRING' => 'query']);
		$this->assertEquals('http://localhost/', $uri->toString());
	}
}
