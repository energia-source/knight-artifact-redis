<?PHP

namespace Redis;

use Redis;
use Redis\Configuration;
use RedisException;
use Closure;

use Knight\armor\Cipher;

class Cache
{
    final protected function __construct() {}

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

    public static function set(string $key, $value, int $ttl = null) : bool
    {
        $redis = static::instance();
        if (null === $redis) return false;
        return $redis->set(static::hash($key), static::encode($value), $ttl ?? Configuration::getTTL());
    }

    public static function get(string $key, ?Closure $closure = null)
    {
        $redis = static::instance();
        if (null !== $redis)
            if ($response = $redis->get(static::hash($key)))
                return static::decode($response);

        if (false === is_callable($closure)) return null;
    
        $cached =  call_user_func($closure);
        static::set($key, $cached);
        return $cached;
    }

    public static function increment(string $key, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $redis_response = $redis->incr(static::hash($key));
        $redis->expire(static::hash($key), $ttl ?? Configuration::getTTL());

        return $redis_response;
    }

    public static function decrement(string $key, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $redis_response = $redis->decr(static::hash($key));
        $redis->expire(static::hash($key), $ttl ?? Configuration::getTTL());

        return $redis_response;
    }

    protected static function encode($mixed) : string
    {
        $cipher = static::getCipher();
        $cached = serialize($mixed);
        $cached = $cipher->encrypt($cached);
        return base64_encode($cached);
    }

    protected static function decode(string $data)
    {
        $cipher = static::getCipher();
        $cached = base64_decode($data);
        $cached = $cipher->decrypt($cached);
        return unserialize($cached);
    }

    protected static function getCipher() : Cipher
    {
        $cipher = new Cipher();
        $cipher->setKeyPersonal(Configuration::getPassphrase());
        return $cipher;
    }

    protected static function hash(string $key) : string
    {
        $algorithm = Configuration::getAlgorithm();
        return hash($algorithm, $key);
    }
}