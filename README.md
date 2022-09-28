
# REPOSITORY-PATTERN
This repository helps to you that create interface, create repository class in [laravel](https://laravel.com/) projects.
## Installation

Install this package with composer

```bash
  composer require usmonaliyev/repository-pattern
```
    
## Using

```bash
php artisan create:pattern Foo
```

This command creates `FooInterface` in `App/Interfaces` folder.

It creates `FooRepository` in `App/Repositories` which is implemented `FooInterface`.

It inserts `$this->app->singleton(FooInterface::class, FooRepository::class);` to boot function of `App/Providers/AppServiceProvider.php` 
## Authors

- [Temur5319436](https://www.github.com/Temur5319436)

