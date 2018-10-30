# URI wrapper for PHP 7.2+ based on RFC-3986, PSR-7 & PSR-17

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

// creates a new URI
$uri = new Uri('http://user:pass@localhost:3000/path?key=value#fragment');

// list of setters
$uri->setScheme();
$uri->setUsername();
$uri->setPassword();
$uri->setHost();
$uri->setPort();
$uri->setPath();
$uri->setQuery();
$uri->setFragment();

// list of getters
$uri->getScheme();
$uri->getUsername();
$uri->getPassword();
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

// payload collection
$uri->getPayload()->get('key');

// psr-7 setters (with cloning)
$uri->withScheme();
$uri->withUserInfo();
$uri->withHost();
$uri->withPort();
$uri->withPath();
$uri->withQuery();
$uri->withFragment();

// psr-17 factory
$uri = (new UriFactory)->createUri('/');
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
