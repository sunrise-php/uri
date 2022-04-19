## URI wrapper for PHP 7.1+ based on RFC-3986, PSR-7 and PSR-17

[![Gitter](https://badges.gitter.im/sunrise-php/support.png)](https://gitter.im/sunrise-php/support)
[![Build Status](https://scrutinizer-ci.com/g/sunrise-php/uri/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/uri/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sunrise-php/uri/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/uri/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sunrise-php/uri/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/uri/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/sunrise/uri/v/stable?format=flat)](https://packagist.org/packages/sunrise/uri)
[![Total Downloads](https://poser.pugx.org/sunrise/uri/downloads?format=flat)](https://packagist.org/packages/sunrise/uri)
[![License](https://poser.pugx.org/sunrise/uri/license?format=flat)](https://packagist.org/packages/sunrise/uri)

---

## Installation

```bash
composer require sunrise/uri
```

## How to use?

```php
use Sunrise\Uri\Uri;
use Sunrise\Uri\UriFactory;

// creates a new URI
$uri = new Uri('http://user:pass@localhost:3000/path?query#fragment');

// creates a new URI with a factory (is equivalent to new Uri(string))
$uri = (new UriFactory)->createUri('http://user:pass@localhost:3000/path?query#fragment');

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
$uri->getUserInfo();
$uri->getHost();
$uri->getPort();
$uri->getPath();
$uri->getQuery();
$uri->getFragment();
$uri->getAuthority();

// converts the URI to a string
(string) $uri;
```

### Another schemes

```php
$uri = new Uri('mailto:test@example.com');

$uri->getScheme(); // mailto
$uri->getPath(); // test@example.com
```

```php
$uri = new Uri('maps:?q=112+E+Chapman+Ave+Orange,+CA+92866');

$uri->getScheme(); // maps
$uri->getQuery(); // q=112+E+Chapman+Ave+Orange,+CA+92866
```

```php
$uri = new Uri('tel:+1-816-555-1212');

$uri->getScheme(); // tel
$uri->getPath(); // +1-816-555-1212
```

```php
$uri = new Uri('urn:oasis:names:specification:docbook:dtd:xml:4.1.2');

$uri->getScheme(); // urn
$uri->getPath(); // oasis:names:specification:docbook:dtd:xml:4.1.2
```

---

## Test run

```bash
php vendor/bin/phpunit
```

## Useful links

* https://tools.ietf.org/html/rfc3986
* https://www.php-fig.org/psr/psr-7/
* https://www.php-fig.org/psr/psr-17/
