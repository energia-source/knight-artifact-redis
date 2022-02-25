<?PHP

namespace Redis;

use Knight\Configuration as KnightConfiguration;

/* This class is used to get the configuration settings from the configuration file */

class Configuration
{
    use KnightConfiguration;

    const CONFIGURATION_FILENAME = 'Cache';
    const CONFIGURATION_HOST = 0x2f4e;
    const CONFIGURATION_PORT = 0x2f53;
    const CONFIGURATION_APPLICATION = 0x2e55;
    const CONFIGURATION_PASSPRHASE = 0x2f99;
    const CONFIGURATION_TIMEOUT = 0x2f58;
    const CONFIGURATION_TTL = 0x2f76;
    const CONFIGURATION_ALGORITHM = 0x3138;

    const DEFAULT_PORT = 6379;
    const DEFAULT_TIMEOUT = 4;
    const DEFAULT_TTL = 24400;
    const DEFAULT_ALGORITHM = 'sha256';

    /**
     * This is the constructor function for the class
     */
    final protected function __construct() {}

    /**
     * Get the host from the configuration file
     * 
     * @return The hostname of the server.
     */

    public static function getHost() : string
    {
        return static::getConfiguration(static::CONFIGURATION_HOST, true, static::CONFIGURATION_FILENAME);
    }

    /**
     * Get the application name from the configuration file
     * 
     * @return The application name.
     */

    public static function getApplication() : string
    {
        return static::getConfiguration(static::CONFIGURATION_APPLICATION, true, static::CONFIGURATION_FILENAME);
    }

    /**
     * It gets the passphrase from the configuration file.
     * 
     * @return The value of the configuration setting.
     */

    public static function getPassphrase() : string
    {
        return static::getConfiguration(static::CONFIGURATION_PASSPRHASE, true, static::CONFIGURATION_FILENAME);
    }

    /**
     * Get the port number from the configuration file
     * 
     * @return The port number.
     */

    public static function getPort() : int
    {
        return static::getConfiguration(static::CONFIGURATION_PORT, false, static::CONFIGURATION_FILENAME) ?? static::DEFAULT_PORT;
    }

    /**
     * Get the timeout value from the configuration file
     * 
     * @return The value of the timeout configuration setting.
     */

    public static function getTimeout() : float
    {
        return static::getConfiguration(static::CONFIGURATION_TIMEOUT, false, static::CONFIGURATION_FILENAME) ?? static::DEFAULT_TIMEOUT;
    }

    /**
     * Get the TTL value from the configuration file
     * 
     * @return The TTL value.
     */

    public static function getTTL() : int
    {
        return static::getConfiguration(static::CONFIGURATION_TTL, false, static::CONFIGURATION_FILENAME) ?? static::DEFAULT_TTL;
    }

    /**
     * Get the algorithm from the configuration file
     * 
     * @return The algorithm name.
     */

    public static function getAlgorithm() : string
    {
        return static::getConfiguration(static::CONFIGURATION_ALGORITHM, false, static::CONFIGURATION_FILENAME) ?? static::DEFAULT_ALGORITHM;
    }
}