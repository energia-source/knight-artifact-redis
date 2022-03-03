# Documentation knight-artifact-redis

Knight PHP library for [Redis](https://redis.io/).

**NOTE:** This repository is part of [Knight](https://github.com/energia-source/knight). Any
support requests, bug reports, or development contributions should be directed to
that project.

## Structure

library:
    - [Redis](https://github.com/energia-source/knight-artifact-redis/tree/main/lib)

<br>

#### ***Class Redis\Cache usable methods***

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

<br>

#### ***Class Redis\Configuration usable methods***

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

* [PHP](https://www.php.net/) - PHP

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details