## URI wrapper for PHP 7.2+ based on RFC-3986, PSR-7 & PSR-17

[![Build Status](https://api.travis-ci.com/sunrise-php/uri.svg?branch=master)](https://travis-ci.com/sunrise-php/uri)
[![CodeFactor](https://www.codefactor.io/repository/github/sunrise-php/uri/badge)](https://www.codefactor.io/repository/github/sunrise-php/uri)
[![Latest Stable Version](https://poser.pugx.org/sunrise/uri/v/stable?format=flat)](https://packagist.org/packages/sunrise/uri)
[![Total Downloads](https://poser.pugx.org/sunrise/uri/downloads?format=flat)](https://packagist.org/packages/sunrise/uri)
[![License](https://poser.pugx.org/sunrise/uri/license?format=flat)](https://packagist.org/packages/sunrise/uri)

## Awards

[![SymfonyInsight](https://insight.symfony.com/projects/967729eb-31ed-42e0-be84-b738e87c36d2/big.svg)](https://insight.symfony.com/projects/967729eb-31ed-42e0-be84-b738e87c36d2)

## Installation

```
composer require sunrise/uri
```

## How to use?

```php
use Sunrise\Uri\Uri;
use Sunrise\Uri\UriFactory;

// creates a new URI with a factory
$uri = (new UriFactory)->createUri('http://user:pass@localhost:3000/path?query#fragment');

// create a new URI from the server environment with a factory
$uri = (new UriFactory)->createUriFromServer($_SERVER);

// create a new URI from the given mock with a factory
$uri = (new UriFactory)->createUriFromServer([
	'HTTPS' => 'on',
	'HTTP_HOST' => 'localhost:3000',
	'REQUEST_URI' => '/path?query',
]);

// creates a new URI without a factory
$uri = new Uri('http://user:pass@localhost:3000/path?query#fragment');

// list of withers
$uri->withScheme();
$uri->withUserInfo();
$uri->withHost();
$uri->withPort();
$uri->withPath();
$uri->withQuery();
$uri->withFragment();

// list of getters
$uri->getScheme();
$uri->getUser();
$uri->getPass();
$uri->getHost();
$uri->getPort();
$uri->getPath();
$uri->getQuery();
$uri->getFragment();

// list of builders
$uri->getUserInfo();
$uri->getHostPort();
$uri->getAuthority();
$uri->toString();

// magic conversion to a string
(string) $uri;
```

## Test run

```bash
php vendor/bin/phpunit
```

## Api documentation

https://phpdoc.fenric.ru/

## Useful links

https://tools.ietf.org/html/rfc3986<br>
https://www.php-fig.org/psr/psr-7/<br>
https://www.php-fig.org/psr/psr-17/
