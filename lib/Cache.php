<?PHP

namespace Redis;

use Redis;
use Redis\Configuration;
use RedisException;
use Closure;

use Knight\armor\Cipher;

/* The Cache class is used to store and retrieve data from the cache */

class Cache
{
    const ESCAPE = ':';
    const EVERYONE = 'everyone';

    protected static $ttl = null; // (int)

    final protected function __construct() {}

    /* A constructor. */

    final public static function instance() :? Redis
    {
        try {
            static $instance;
            if (null !== $instance
                && (int)$instance->ping(1)) return $instance;

            $instance = new Redis(); 
            $instance->connect(Configuration::getHost(), Configuration::getPort(), Configuration::getTimeout());
            $instance_application = Configuration::getApplication();
            $instance->setOption(Redis::OPT_PREFIX, $instance_application . chr(58));

            return $instance;
        } catch (RedisException $exception) {
            return null;
        }
    }

    /**
     * Set the time to live for the cache
     * 
     * @param seconds The number of seconds to cache the result for.
     */

    public static function setTTL(?int $seconds = null) : void
    {
        static::$ttl = $seconds;
    }

    /**
     * Get the TTL value from the configuration file, or use the default value
     * 
     * @return The TTL value from the configuration file.
     */

    public static function getTTL() : int
    {
        return static::$ttl ?? Configuration::getTTL();
    }

    /**
     * Set a value in the cache
     * 
     * @param string key The key to store the value under.
     * @param string whoami The name of the object that is using the cache. This is used to prevent
     * collisions between multiple objects using the cache.
     * @param value The value to be stored.
     * @param int ttl The time-to-live for the key.
     * 
     * @return A boolean value indicating success or failure.
     */

    public static function set(string $key, string $whoami, $value, int $ttl) : bool
    {
        $redis = static::instance();
        if (null === $redis) return false;

        $named = $whoami . static::ESCAPE . static::hash($key);
        $value_encoded = static::encode($value);
        return $redis->set($named, $value_encoded, $ttl);
    }

    /**
     * If the key is in the cache, return it. Otherwise, call the closure and cache the result
     * 
     * @param string key The key to use for the cache.
     * @param string whoami The name of the class that is calling the function.
     * @param closure A closure that returns the value to be cached.
     * 
     * @return The value of the key.
     */

    public static function get(string $key, string $whoami, ?Closure $closure = null)
    {
        $redis = static::instance();
        if (null !== $redis) {
            $named = $whoami . static::ESCAPE . static::hash($key);
            $response = $redis->get($named);
            if (!!$response) return static::decode($response);
        }

        if (false === is_callable($closure)) return null;
    
        $cached = call_user_func($closure);
        static::set($key, $whoami, $cached, static::getTTL());

        return $cached;
    }

    /**
     * Increment the value of a key in Redis
     * 
     * @param string key The key to increment.
     * @param string whoami The name of the process that is incrementing the counter.
     * @param int ttl The time-to-live for the key.
     * 
     * @return The value of the key.
     */

    public static function increment(string $key, string $whoami, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $named = $whoami . static::ESCAPE . static::hash($key);
        $redis_response = $redis->incr($named);
        $redis->expire($named, $ttl ?? static::getTTL());

        return $redis_response;
    }

    /**
     * Decrement the value of a key in Redis
     * 
     * @param string key The key to increment.
     * @param string whoami The name of the process that is calling the function.
     * @param int ttl The time-to-live for the key.
     * 
     * @return The value of the key.
     */

    public static function decrement(string $key, string $whoami, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $named = $whoami . static::ESCAPE . static::hash($key);
        $redis_response = $redis->decr($named);
        $redis->expire($named, $ttl ?? static::getTTL());

        return $redis_response;
    }

    /**
    * Encrypts the serialized data using the cipher and returns the base64 encoded result
    * 
    * @param mixed The value to be encrypted.
    * 
    * @return The encrypted data.
    */

    protected static function encode($mixed) : string
    {
        $cipher = static::getCipher();
        $cached = serialize($mixed);
        $cached = $cipher->encrypt($cached);
        return base64_encode($cached);
    }

    /**
     * Decode the data using the cipher and unserialize the decoded data
     * 
     * @param string data The data to be decrypted.
     * 
     * @return An array of the user's data.
     */

    protected static function decode(string $data)
    {
        $cipher = static::getCipher();
        $cached = base64_decode($data);
        $cached = $cipher->decrypt($cached);
        return unserialize($cached);
    }

    /**
     * It returns a Cipher object that is initialized with the passphrase.
     * 
     * @return The Cipher object.
     */

    protected static function getCipher() : Cipher
    {
        $cipher = new Cipher();
        $cipher->setKeyPersonal(Configuration::getPassphrase());
        return $cipher;
    }

    /**
     * It hashes the key using the algorithm specified in the configuration.
     * 
     * @param string key The key to hash.
     * 
     * @return The hash of the key.
     */

    protected static function hash(string $key) : string
    {
        $algorithm = Configuration::getAlgorithm();
        return hash($algorithm, $key);
    }
}