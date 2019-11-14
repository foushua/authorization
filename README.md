# Authorization (W.I.P)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foushua/authorization.svg?style=flat-square)](https://packagist.org/packages/foushua/authorization)
[![Quality Score](https://img.shields.io/scrutinizer/g/foushua/authorization.svg?style=flat-square)](https://scrutinizer-ci.com/g/foushua/authorization)
[![Total Downloads](https://img.shields.io/packagist/dt/foushua/authorization.svg?style=flat-square)](https://packagist.org/packages/foushua/authorization)

This package allows you to manage user role in a database.

## Installation

You can install the package via composer:

```bash
composer require foushua/authorization
```

### Config File And Migrations

Publish the package config file and migrations to your application. Run these commands inside your terminal.

```bash
php artisan vendor:publish --provider="Foushua\Authorization\Providers\AuthorizationServiceProvider" --tag=config
php artisan vendor:publish --provider="Foushua\Authorization\Providers\AuthorizationServiceProvider" --tag=migrations
```

And also run migrations.

```bash
php artisan migrate
```

> This uses the default users table which is in Laravel. You should already have the migration file for the users table available and migrated.

## Usage

in order to use this package, it is necessary to update your ```User.php``` model to add the ```Authorizable``` trait.


``` php
<?php 

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Foushua\Authorization\Traits\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use Authorizable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

Once this is done, you will have access to the different methods made available to you by this package.

To view all of theses methods please, referer to [Authorizable](src/Traits/Authorizable.php)

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email contact@foushua.be instead of using the issue tracker.

## Credits

- [Fouyon Joshua](https://github.com/foushua)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
