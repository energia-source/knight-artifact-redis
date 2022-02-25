# Documentation knight-artifact-redis

> Knight PHP library for [Redis](https://redis.io/).

**NOTE:** This repository is part of [Knight](https://github.com/energia-source/knight). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require knight/artifact-redis
```

## Configuration

### Concepts

Configuration is grouped into configuration namespace by the framework [Knight](https://github.com/energia-source/knight).
The configuration files are stored in the configurations folder and file named Cache.php.

### Example

So the basic setup looks something like this:

```
<?PHP

namespace configurations;

use Knight\Lock;

use Redis\Configuration as Define;

final class Cache
{
	use Lock;

	const PARAMETERS = [
		// redis host
		Define::CONFIGURATION_HOST => '10.58.96.3',
		// redis port
		Define::CONFIGURATION_PORT => 6379,
		// redis timout in second
		Define::CONFIGURATION_TIMEOUT => 1,
		// redis TTL
		Define::CONFIGURATION_TTL => 120,
		// redis application prefix for all keys
		Define::CONFIGURATION_APPLICATION => 'myapplication',
		// redis crypt passphrase
		Define::CONFIGURATION_PASSPRHASE => 'uRrSTm6&m7QbreGMVxK6AR3m@4SnkUy^'
    ];
}

```

### Usage

So the basic usage looks something like this:

```
<?PHP

namespace what\you\want;

use Redis\Cache;

$cache = Cache::get($key, $user_identity, function () {
    $value = 1;
    return $value;
}

```

## Structure

- library:
    - [Redis\Cache](https://github.com/energia-source/knight-artifact-redis/blob/main/lib/Cache.php)
    - [Redis\Configuration](https://github.com/energia-source/knight-artifact-redis/blob/main/lib/Configuration.php)

### Redis\Cache

##### `public static function setTTL(?int $seconds = null) : void`

Set the time to live for the cache

 * **Parameters:** `seconds` — number of seconds to cache the result for.

##### `public static function getTTL() : int`

Get the TTL value from the configuration file, or use the default value

 * **Returns:** `The` — TTL value from the configuration file.

##### `public static function set(string $key, string $whoami, $value, int $ttl) : bool`

Set a value in the cache

 * **Parameters:**
   * `string` — The key to store the value under.
   * `string` — The name of the object that is using the cache. This is used to prevent collisions between multiple objects using the cache.
   * `value` — value to be stored.
   * `int` — The time-to-live for the key.

     <p>
 * **Returns:** `A` — boolean value indicating success or failure.

##### `public static function get(string $key, string $whoami, ?Closure $closure = null)`

If the key is in the cache, return it. Otherwise, call the closure and cache the result

 * **Parameters:**
   * `string` — The key to use for the cache.
   * `string` — The name of the class that is calling the function.
   * `closure` — closure that returns the value to be cached.

     <p>
 * **Returns:** `The` — value of the key.

##### `public static function increment(string $key, string $whoami, int $ttl = null) :? int`

Increment the value of a key in Redis

 * **Parameters:**
   * `string` — The key to increment.
   * `string` — The name of the process that is incrementing the counter.
   * `int` — The time-to-live for the key.

     <p>
 * **Returns:** `The` — value of the key.

##### `public static function decrement(string $key, string $whoami, int $ttl = null) :? int`

Decrement the value of a key in Redis

 * **Parameters:**
   * `string` — The key to increment.
   * `string` — The name of the process that is calling the function.
   * `int` — The time-to-live for the key.

     <p>
 * **Returns:** `The` — value of the key.

#### Redis\Configuration

##### `public static function getHost() : string`

Get the host from the configuration file

 * **Returns:** `The` — hostname of the server.

##### `public static function getApplication() : string`

Get the application name from the configuration file

 * **Returns:** `The` — application name.

##### `public static function getPassphrase() : string`

It gets the passphrase from the configuration file.

 * **Returns:** `The` — value of the configuration setting.

##### `public static function getPort() : int`

Get the port number from the configuration file

 * **Returns:** `The` — port number.

##### `public static function getTimeout() : float`

Get the timeout value from the configuration file

 * **Returns:** `The` — value of the timeout configuration setting.

##### `public static function getTTL() : int`

Get the TTL value from the configuration file

 * **Returns:** `The` — TTL value.

##### `public static function getAlgorithm() : string`

Get the algorithm from the configuration file

 * **Returns:** `The` — algorithm name.

 ## Built With

* [Docker](https://www.docker.com/) - Get Started with Docker
* [Alpine Linux](https://alpinelinux.org/) - Alpine Linux
* [Nginx](https://www.nginx.com/) - Nginx
* [PHP](https://www.php.net/) - PHP
* [Redis](https://redis.io/) - Redis

## Contributing

Please read [CONTRIBUTING.md](https://github.com/energia-source/knight-artifact-redis/blob/main/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting us pull requests.

## Versioning

We use [SemVer](https://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/energia-source/knight-artifact-redis/tags). 

## Authors

* **Paolo Fabris** - *Initial work* - [energia-europa.com](https://www.energia-europa.com/)
* **Gabriele Luigi Masero** - *Developer* - [energia-europa.com](https://www.energia-europa.com/)

See also the list of [contributors](https://github.com/energia-source/knight-artifact-redis/blob/main/CONTRIBUTORS.md) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details