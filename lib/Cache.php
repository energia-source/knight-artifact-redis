<?PHP

namespace Redis;

use Redis;
use Redis\Configuration;
use RedisException;
use Closure;

use Knight\armor\Cipher;

class Cache
{
    const ESCAPE = ':';
    const EVERYONE = 'everyone';

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

    public static function set(string $key, string $whoami, $value, int $ttl = null) : bool
    {
        $redis = static::instance();
        if (null === $redis) return false;

        $named = $whoami . static::ESCAPE . static::hash($key);
        return $redis->set($named, static::encode($value), $ttl ?? Configuration::getTTL());
    }

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
        static::set($key, $whoami, $cached);

        return $cached;
    }

    public static function increment(string $key, string $whoami, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $named = $whoami . static::ESCAPE . static::hash($key);
        $redis_response = $redis->incr($named);
        $redis->expire($named, $ttl ?? Configuration::getTTL());

        return $redis_response;
    }

    public static function decrement(string $key, string $whoami, int $ttl = null) :? int
    {
        $redis = static::instance();
        if (null === $redis) return null;

        $named = $whoami . static::ESCAPE . static::hash($key);
        $redis_response = $redis->decr($named);
        $redis->expire($named, $ttl ?? Configuration::getTTL());

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