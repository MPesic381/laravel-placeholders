# Find and Replace placeholder strings in Laravel 8 and newer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mpesic381/laravel-placeholders.svg?style=flat-square)](https://packagist.org/packages/mpesic381/laravel-placeholders)
[![Total Downloads](https://img.shields.io/packagist/dt/mpesic381/laravel-placeholders.svg?style=flat-square)](https://packagist.org/packages/mpesic381/laravel-placeholders)

## Installation

You can install the package via composer:

```bash
composer require mpesic381/laravel-placeholders
```
Then you will need to run these commands in the terminal in order to copy the config file
```bash
php artisan vendor:publish --provider="MPesic381\Placeholders\PlaceholdersServiceProvider"
```

## Usage

```php
use Placeholders;

// Basic
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
	'veg' => 'cucumber'
]); //I like oranges and cucumbers

// Globally
Placeholders::set("fruit", "apple");
Placeholders::set("veg", "carrot");
Placeholders::parse("I like [fruit]s and [veg]s"); // I like apples and carrots
```

### Style
```php
// Change the style
Placeholders::setStyle("{{", "}}");
Placeholders::parse("I like {{fruit}}s and {{veg}}s", [
	'fruit' => 'lemon',
	'veg' => 'string bean'
]); //I like lemons and string beans
```

### Behaviors
```php
// Throw an error if one is missed
Placeholders::setBehavior('error')
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
]); //Throws an Exception: Could not find a replacement for [veg]

// Delete the placeholder from the output if it is missing.
Placeholders::setBehavior('skip')
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
]); // I like oranges and s

Placeholders::setBehavior('preserve')
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
]); // I like oranges and [veg]s


```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

-   [tylercd100](https://github.com/tylercd100) - This package is based on his one

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
