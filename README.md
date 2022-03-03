# Documentation knight-artifact-redis

Knight PHP library for [Redis](https://redis.io/).

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

Configuration is grouped into configuration namespace by the framework [Knight](https://github.com/energia-source/knight).
The configuration files are stored in the configurations folder and file named Cache.php.

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

## Structure

library:
- [Redis](https://github.com/energia-source/knight-artifact-redis/tree/main/lib)

## Usage

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

## Built With

* [PHP](https://www.php.net/) - PHP

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