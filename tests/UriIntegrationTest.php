<?php

namespace Sunrise\Uri\Tests;

use Http\Psr7Test\UriIntegrationTest as BaseUriIntegrationTest;
use Sunrise\Uri\Uri;

class UriIntegrationTest extends BaseUriIntegrationTest
{
	public function createUri($uri)
	{
		return new Uri($uri);
	}
}
