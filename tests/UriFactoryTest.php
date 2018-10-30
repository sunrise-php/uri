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
}
