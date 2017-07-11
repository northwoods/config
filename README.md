# Northwoods Config

[![Build Status](https://travis-ci.org/northwoods/config.svg?branch=develop)](https://travis-ci.org/northwoods/config)
[![StyleCI](https://styleci.io/repos/96575702/shield)](https://styleci.io/repos/96575702)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/northwoods/config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/northwoods/config/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/northwoods/config/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/northwoods/config/?branch=master)
[![Latest Stable Version](http://img.shields.io/packagist/v/northwoods/config.svg?style=flat)](https://packagist.org/packages/northwoods/config)
[![Total Downloads](https://img.shields.io/packagist/dt/northwoods/config.svg?style=flat)](https://packagist.org/packages/northwoods/config)
[![License](https://img.shields.io/packagist/l/northwoods/config.svg?style=flat)](https://packagist.org/packages/northwoods/config)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/da8c11c9-6815-4b4f-a9c4-9897c86cbc46/mini.png)](https://insight.sensiolabs.com/projects/da8c11c9-6815-4b4f-a9c4-9897c86cbc46)

PHP configuration loading library. It is made to enable your application to have
different configurations depending on the environment it is running in. For example,
your application can have different configurations for testing, development, staging,
and production. 

It is **not recommended** to include your staging or production configuration in
version control! To support system specific configuration, you may install
[`josegonzalez/dotenv`](https://github.com/josegonzalez/php-dotenv).

## Installation

The best way to install and use this package is  [through composer](http://getcomposer.org/):

```shell
composer require northwoods/config
```

## Usage

There are several different ways to use this package. The most simple is to use
the static factory:

```php
use Northwoods\Config\ConfigFactory;

$config = ConfigFactory::make([
    'directory' => __DIR__ . '/config',
]);
```

Configuration can now be read using a "dot path":

```php
$token = $config->get('app.timezone');
```

This will load `config/app.php` and return the `timezone` key, if it exists.

Optionally, an environment can be set that will add an additional search path:

```php
$config = ConfigFactory::make([
    'directory' => __DIR__ . '/config',
    'environment' => 'dev',
]);
```

Now when `app.timezone` is requested, both `config/dev/app.php` and `config/app.php`
will be searched for the `timezone` key and the first result will be returned.

### Best Practice

It is **not recommended** to add your staging or production secrets to
configuration files that are checked into source control.
A better solution is to use an env loader such as
[`josegonzalez/dotenv`](https://github.com/josegonzalez/php-dotenv) or
[`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv). This will allow writing
PHP configuration files that read from `getenv`:

```php
return [
    'database' => [
        'password' => getenv('DATABASE_PASSWORD')
    ],
];
```

Refer the package documentation for how to populate env values from a `.env` file.

### YAML Files

YAML configuration files are supported when the [`symfony/yaml`](https://github.com/symfony/yaml)
package is installed:

```php
$config = ConfigFactory::make([
    'directory' => __DIR__ . '/config',
    'environment' => 'dev',
    'type' => 'yaml'
]);
```

**Note:** This assumes that all configuration files have a `.yaml` extension!
If you wish to combine PHP and YAML files, create a custom `ConfigCollection`
with `ConfigFactory`.

## `ConfigInterface`

All configuration containers must implement `ConfigInterface`.

### `get()`

Configuration values are accessed using the `get($path, $default)` method.

The first parameter is a "dot path" to search for in the form `file.key.extra`.
An unlimited depth is supported.

The second parameter is a default value that will be returned if the path cannot
be resolved. If the default is not provided `null` will be used.

```php
// If not defined, $timezone will be null
$timezone = $config->get('app.timezone');

// If not defined, $timezone will be "UTC"
$timezone = $config->get('app.timezone', 'UTC');
```

### `set()`

Configuration values can also be set at runtime using the `set($path, $value)` method.

The first parameter is a "dot path" to set in the form `file.key.extra`.
An unlimited depth is supported.

The second parameter is the value to set for the path.

```php
$config->set('app.timezone', 'Europe/Berlin');
```

### Classes

The following classes are part of this package:

- `ConfigFactory` - factory for configuration containers
- `ConfigDirectory` - container that reads a single directory
- `ConfigCollection` - container that reads from an collection of containers
- `Loader\LoaderFactory` - factory for configuration readers
- `Loader\PhpLoader` - reader for `.php` configuration files
- `Loader\YamlLoader` - reader for `.yaml` configuration files

### Functions

Getting and setting functionality is implemented by `array_path` and `array_path_set`:

```php
use function Northwoods\Config\array_path;
use function Northwoods\Config\array_path_set;

$config = [
    'service' => [
        'uri' => 'http://api.example.com/'
    ],
];

// get a value from an array
$uri = array_path($config, 'service.uri');

// set a value in an array
$config = array_path_set($config, 'service.uri', 'https://api.example.com/v2/')
```

## Examples

See more examples in the [examples folder](https://github.com/northwoods/config/tree/master/examples).

### PHP Configuration File

Example of a PHP configuration file:

```php
return [
    'timezone' => "America/New_York"
];
```

### YAML Configuration File

Example of a YAML configuration file:

```yaml
timezone: America/New_York
```

## Original Ownership

This library is a fork of [`sinergi/config`](https://github.com/sinergi/config),
starting in July 2017, and has changed significantly. Thank you to Gabriel Bull
for creating the original package!

## License

Config is licensed under The MIT License (MIT).

