# Duplicate PHP Constants in JavaScript
Requires Laravel ^9.0 and PHP ^8.0

[![Latest Stable Version](http://poser.pugx.org/jefhar/laravel-export-constants/v)](https://packagist.org/packages/jefhar/laravel-export-constants)
[![Total Downloads](http://poser.pugx.org/jefhar/laravel-export-constants/downloads)](https://packagist.org/packages/jefhar/laravel-export-constants)
[![Latest Unstable Version](http://poser.pugx.org/jefhar/laravel-export-constants/v/unstable)](https://packagist.org/packages/jefhar/laravel-export-constants)
[![License](http://poser.pugx.org/jefhar/laravel-export-constants/license)](https://packagist.org/packages/jefhar/laravel-export-constants)
[![PHP Version Require](http://poser.pugx.org/jefhar/laravel-export-constants/require/php)](https://packagist.org/packages/jefhar/laravel-export-constants)


[![Latest Version on Packagist](https://img.shields.io/packagist/v/jefhar/laravel-export-constants.svg?style=flat-square)](https://packagist.org/packages/jefhar/laravel-export-constants)
[![Total Downloads](https://img.shields.io/packagist/dt/jefhar/laravel-export-constants.svg?style=flat-square)](https://packagist.org/packages/jefhar/laravel-export-constants)

Like you, I hate bare strings and magic numbers in code, so we use PHP constants. 
With the magic of [Attributes](https://www.php.net/manual/en/language.attributes.overview.php), 
your PHP constants can be duplicated for use in your Vue, React, and POJS

## Installation

You can install the package via composer:

```bash
composer require jefhar/laravel-export-constants
```

## Usage
Add the attribute `#[LaravelExportConstants\Attributes\ExportToJs]` to your public 
constants and add the blade directive `@constants` to your `app.blade.php` file. Use 
your PHP constant as normal, and look for your JavaScript constant under the 
`CONSTANTS` global constant
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NunyaController extends Controller
{
    #[LaravelExportConstants\Attributes\ExportToJs]
    public const URL_INDEX = 'nunya.index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }
}
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jeff@jeffharris.us instead of using the issue tracker.

## Credits

-   [Jeff Harris](https://github.com/jefhar)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
