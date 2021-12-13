![Laravel Green Pass](https://banners.beyondco.de/Laravel%20Green%20Pass.png?theme=light&packageManager=composer+require&packageName=robertogallea%2Flaravel-greenpass&pattern=charlieBrown&style=style_1&description=Green+Pass+validation+and+decoding+is+a+breeze&md=1&showWatermark=0&fontSize=100px&images=identification&widths=200&heights=auto)

# laravel-greenpass

[![Author][ico-author]][link-author]
[![GitHub release (latest SemVer)][ico-release]][link-release]
[![Laravel >=6.0][ico-laravel]][link-laravel]
[![Software License][ico-license]](LICENSE.md)
[![PSR2 Conformance][ico-styleci]][link-styleci]
[![Sponsor me!][ico-sponsor]][link-sponsor]
[![Packagist Downloads][ico-downloads]][link-downloads]

laravel-greenpass is a package for the management of the European <code>Green Pass</code> (i.e. covid certification).
The package allows easy validation and decoding of the GreenPass. It is also suited for Laravel since it provides a
convenient custom validator for request validation.

- [Installation](#installation)
- [Configuration](#configuration)
- [Validation](#validation)
- [Utility GreenPassDecoder class](#utility-greenpassdecoder-class)



## Installation

Run the following command to install the latest applicable version of the package:

```bash
composer require robertogallea/laravel-greenpass
```

### Laravel

In your app config, add the Service Provider to the `$providers` array *(only for Laravel 5.4 or below)*:

 ```php
'providers' => [
    ...
    robertogallea\LaravelGreenPass\GreenPassServiceProvider::class,
],
```

### Lumen

In `bootstrap/app.php`, register the Service Provider

```php
$app->register(robertogallea\LaravelGreenPass\GreenPassServiceProvider::class);
```

## Configuration

By default, the underlying validation package saves the validation certificates inside 
`storage/app/public/green_pass_cache`. 
If you want to change this folder, publish the config file with the command
```
php artisan vendor:publish --provider="robertogallea\LaravelGreenPass\GreenPassServiceProvider" --tag="config"
```
and edit the `certificate-storage-path` key inside the `config/green-pass.php` file.

**Make sure the chosen folder has write access!**

## Validation

To validate a green pass, use the `greenpass` and  `greenpass_file` keyword in your validation rules array

```php
    public function rules()
    {
        return [
            'greenpass_string' => 'greenpass',
            
            //...
        ];
    }
```

```php
    public function rules()
    {
        return [
            'greenpass_uploaded_file' => 'greenpass_file',
            
            //...
        ];
    }
```

## Utility GreenPassDecoder class

A green pass can be read using the `GreenPassDecoder` service:


```php
use robertogallea\LaravelGreenPass\GreenPassDecoder;

...

$greenpass = new GreenPassDecoder();

$result = $greenpass->decode('HC1:...');
var_dump($result);

// or

$result = $greenpass->decodeFile('/path/to/file');
var_dump($result);
```

You can also use the `GreenPass` facade:

```php
use robertogallea\LaravelGreenPass\GreenPassDecoder;

...
$result = \GreenPass::decode('HC1:...');
var_dump($result);

// or

$result = \GreenPass::decodeFile('/path/to/file');
var_dump($result);
```


[ico-author]: https://img.shields.io/static/v1?label=author&message=robgallea&color=50ABF1&logo=twitter&style=flat-square
[ico-release]: https://img.shields.io/github/v/release/robertogallea/laravel-greenpass
[ico-downloads]: https://img.shields.io/packagist/dt/robertogallea/laravel-greenpass
[ico-laravel]: https://img.shields.io/static/v1?label=laravel&message=%E2%89%A56.0&color=ff2d20&logo=laravel&style=flat-square
[ico-sponsor]: https://img.shields.io/static/v1?label=Sponsor&message=%E2%9D%A4&logo=GitHub&link=https://github.com/sponsors/robertogallea
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/177130582/shield

[link-author]: https://twitter.com/robgallea
[link-release]: https://github.com/robertogallea/laravel-greenpass
[link-downloads]: https://packagist.org/packages/robertogallea/laravel-greenpass
[link-laravel]: https://laravel.com
[link-sponsor]: https://github.com/sponsors/robertogallea
[link-styleci]: https://styleci.io/repos/17713058s2/