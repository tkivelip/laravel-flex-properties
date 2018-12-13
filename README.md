# Laravel Flex Properties

## Introduction
With this package you can define custom attributes for Laravel's 
Eloquent models.

## Installation

You can install the package via composer:

```bash
composer require tkivelip/laravel-flex-properties
```

## How to use?

### Set up the model

#### Simple setup

The easiest to use this package it to extended the shipped model. 
Anything you need is already setted up. Now you can customize your
flex attributes by creating a property called 'flex_properties';

```php
namespace Example;

use tkivelip\LaravelFlexProperties\Model;

class ExampleModel extends Model
{
    protected $flex_properties = [
        'title'   => 'string',
        'text'    => 'text',
        'data'    => 'json',
    ];
}
```

The `$flex_properties` keys are the names of your properties. As value you 
have to set up a valid flex property type. You can add or change flex 
property types in the main config file `config/flex-properties.php` 

#### Publish Config and Migrations

If you like to custoize the configuration or the migrations, you can 
publish these files to your local installation. Same old story. Use 
any terminal, go to your project root dir and type:

```batch
php artisan vendor:publish
```

#### Extended Setup

Coming soon...


### Flex Helper
You can find some helpfull tools in the `Flex` helper class.
For example we can use the `typeExists()` method to determaniate, 
if a flex property type is configured:

```php
namespace Example;

use tkivelip\LaravelFlexProperties\Flex;

Flex::typeExists('string'); // returns true
``` 

### Querying Flex Properties

You can use the `Flex::where()`helper to extend the usual
query builder functions like where(), orWhere(), andWhere(), etc.
It takes the flex property name as first parameter. All other
parameters are equal to the eloquent builder methods. 

```php
namespace Example;

ExampleModel::where(
    Flex::where('property_name', $value);  
);

ExampleModel::where(
    Flex::where('description', 'LIKE', 'Starts with%');  
);
``` 

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [tkivelip](https://github.com/tkivelip)
- [All Other Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
 
