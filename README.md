# Documentation knight-artifact-redis

## `public static function setTTL(?int $seconds = null) : void`

Set the time to live for the cache

 * **Parameters:** `seconds` — number of seconds to cache the result for.

## `public static function getTTL() : int`

Get the TTL value from the configuration file, or use the default value

 * **Returns:** `The` — TTL value from the configuration file.

## `public static function set(string $key, string $whoami, $value, int $ttl) : bool`

Set a value in the cache

 * **Parameters:**
   * `string` — The key to store the value under.
   * `string` — The name of the object that is using the cache. This is used to prevent collisions between multiple objects using the cache.
   * `value` — value to be stored.
   * `int` — The time-to-live for the key.

 * **Returns:** `A` — boolean value indicating success or failure.

## `public static function get(string $key, string $whoami, ?Closure $closure = null)`

If the key is in the cache, return it. Otherwise, call the closure and cache the result

 * **Parameters:**
   * `string` — The key to use for the cache.
   * `string` — The name of the class that is calling the function.
   * `closure` — closure that returns the value to be cached.

 * **Returns:** `The` — value of the key.

## `public static function increment(string $key, string $whoami, int $ttl = null) :? int`

Increment the value of a key in Redis

 * **Parameters:**
   * `string` — The key to increment.
   * `string` — The name of the process that is incrementing the counter.
   * `int` — The time-to-live for the key.

 * **Returns:** `The` — value of the key.

## `public static function decrement(string $key, string $whoami, int $ttl = null) :? int`

Decrement the value of a key in Redis

 * **Parameters:**
   * `string` — The key to increment.
   * `string` — The name of the process that is calling the function.
   * `int` — The time-to-live for the key.

 * **Returns:** `The` — value of the key.

## `protected static function encode($mixed) : string`

Encrypts the serialized data using the cipher and returns the base64 encoded result

 * **Parameters:** `mixed` — value to be encrypted.

 * **Returns:** `The` — encrypted data.

## `protected static function decode(string $data)`

Decode the data using the cipher and unserialize the decoded data

 * **Parameters:** `string` — The data to be decrypted.

 * **Returns:** `An` — array of the user's data.

## `protected static function getCipher() : Cipher`

It returns a Cipher object that is initialized with the passphrase.

 * **Returns:** `The` — Cipher object.

## `protected static function hash(string $key) : string`

It hashes the key using the algorithm specified in the configuration.

 * **Parameters:** `string` — The key to hash.

 * **Returns:** `The` — hash of the key.