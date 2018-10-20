# :globe_with_meridians: Sunrise URI (Uniform Resource Identifier)

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

## How to use

```php
try
{
    $uri = new \Sunrise\Uri\Uri('http://user:pass@localhost:3000/path?key=value#fragment');
}
catch (\Sunrise\Uri\Exception\InvalidUriException $e)
{
    // Invalid URI...
}
catch (\Sunrise\Uri\Exception\InvalidUriComponentException $e)
{
    // Invalid URI component...
}
catch (\Sunrise\Uri\Exception\Exception $e)
{
    // Any URI error...
}

$uri->getPayload()->get('key'); // Returns "value"
$uri->getScheme(); // Returns "http"
$uri->getUsername(); // Returns "user"
$uri->getPassword(); // Returns "pass"
$uri->getHost(); // Returns "localhost"
$uri->getPort(); // Returns "3000"
$uri->getPath(); // Returns "/path"
$uri->getQuery(); // Returns "key=value"
$uri->getFragment(); // Returns "fragment"
$uri->getUserInfo(); // Returns "user:pass"
$uri->getHostPort(); // Returns "localhost:3000"
$uri->getAuthority(); // Returns "user:pass@localhost:3000"
$uri->toString(); // Returns "http://user:pass@localhost:3000/path?key=value#fragment"
```

## Api documentation

https://phpdoc.fenric.ru/

## Useful links

https://tools.ietf.org/html/rfc3986

###### With :heart: for you
