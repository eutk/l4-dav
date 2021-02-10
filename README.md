# PHP WebDAV client
[![Latest Stable Version](https://poser.pugx.org/ngmy/l4-dav/v)](//packagist.org/packages/ngmy/l4-dav)
[![Total Downloads](https://poser.pugx.org/ngmy/l4-dav/downloads)](//packagist.org/packages/ngmy/l4-dav)
[![Latest Unstable Version](https://poser.pugx.org/ngmy/l4-dav/v/unstable)](//packagist.org/packages/ngmy/l4-dav)
[![License](https://poser.pugx.org/ngmy/l4-dav/license)](//packagist.org/packages/ngmy/l4-dav)
[![composer.lock](https://poser.pugx.org/ngmy/l4-dav/composerlock)](//packagist.org/packages/ngmy/l4-dav)<br>
[![PHP CI](https://github.com/ngmy/l4-dav/workflows/PHP%20CI/badge.svg)](https://github.com/ngmy/l4-dav/actions?query=workflow%3A%22PHP+CI%22)
[![Coverage Status](https://coveralls.io/repos/github/ngmy/l4-dav/badge.svg?branch=master)](https://coveralls.io/github/ngmy/l4-dav?branch=master)

The PHP WebDAV client that makes it easy to send WebDAV requests and trivial to integrate with web services.

- Simple and object-oriented interface for sending WebDAV requests
- Can use any implementation of the PSR-7 UriInterface to specify the request URL
- Response class wraps any implementation of the PSR-7 ResponseInterface, and itself implements the PSR-7 ResponseInterface
- Uses PSR-7 interfaces for requests, responses, and streams. This allows you to utilize other PSR-7 compatible libraries with the PHP WebDAV client
- Uses the [cURL client](https://github.com/php-http/curl-client) for the HTTP client. This allows you to fine control of the HTTP client using the [cURL option](https://www.php.net/manual/en/function.curl-setopt.php)
- Streaming large uploads, streaming large downloads via PSR-7 responses and streams
- Supports the Basic and Digest authentication

## Supported WebDAV Features
The PHP WebDAV client supports the following WebDAV features as defined in [RFC 4918](https://tools.ietf.org/html/rfc4918):

- [x] PUT - Stores the resource
- [x] GET - Retrieves the resource
- [x] HEAD - Retrieves the header information of the resource
- [x] DELETE - Deletes the resource
- [x] MKCOL - Creates a new collection
- [x] COPY - Creates a duplicate of the resource
- [x] MOVE - Moves the resource
- [x] PROPFIND - Retrieves properties
- [x] PROPPATCH - Set and/or removes properties
- [ ] LOCK - Locks the resource
- [ ] UNLOCK - Unlocks the resource

## Requirements
The PHP WebDAV client has the following requirements:

* PHP >= 7.3
* [libxml](https://www.php.net/manual/en/book.libxml.php) PHP extension

## Installation
Execute the Composer `require` command:
```console
composer require ngmy/l4-dav
```

## Examples

### Basic Usage
#### Download a file from the WebDAV server

```php
L4Dav::download('path/to/remote/file', '/path/to/local/file');
```

#### Upload a file to the WebDAV server

```php
L4Dav::upload('/path/to/local/file', 'path/to/remote/file');
```

#### Delete a file on the WebDAV server

```php
L4Dav::delete('path/to/remote/file');
```

#### Copy a file on the WebDAV server

```php
L4Dav::copy('path/to/source/file', 'path/to/dest/file');
```

#### Rename a file on the WebDAV server

```php
L4Dav::move('path/to/source/file', 'path/to/dest/file');
```

#### Make a directory on the WebDAV server

```php
L4Dav::makeDirectory('path/to/remote/directory/');
```

#### Check the existence of a directory on the WebDAV server

```php
L4Dav::exists('path/to/remote/directory/');
```

#### List contents of a directory on the WebDAV server

```php
L4Dav::list('path/to/remote/directory/');
```

### Get Response
#### Get the status code
```php
$response = L4Dav::upload('/path/to/local/file', 'path/to/remote/file');
$response->getStatus();
```

#### Get the status message
```php
$response = L4Dav::upload('/path/to/local/file', 'path/to/remote/file');
$response->getMessage();
```

#### Get the response body
```php
$response = L4Dav::upload('/path/to/local/file', 'path/to/remote/file');
$response->getBody();
```

## Documentation

Please see the [API documentation](https://ngmy.github.io/l4-dav/api/).

## License
The PHP WebDAV client is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
