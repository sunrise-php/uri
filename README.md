# Sunrise URI

[![Build Status](https://api.travis-ci.com/sunrise-php/uri.svg?branch=master)](https://travis-ci.com/sunrise-php/uri)
[![CodeFactor](https://www.codefactor.io/repository/github/sunrise-php/uri/badge)](https://www.codefactor.io/repository/github/sunrise-php/uri)
[![Latest Stable Version](https://poser.pugx.org/sunrise/uri/v/stable)](https://packagist.org/packages/sunrise/uri)
[![Total Downloads](https://poser.pugx.org/sunrise/uri/downloads)](https://packagist.org/packages/sunrise/uri)
[![License](https://poser.pugx.org/sunrise/uri/license)](https://packagist.org/packages/sunrise/uri)

## Installation

```
composer require sunrise/uri
```

## Usage

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

## Useful links

https://tools.ietf.org/html/rfc3986
