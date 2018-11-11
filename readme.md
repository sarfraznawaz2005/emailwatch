[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

# Laravel EmailWatch

Laravel package to open sent emails in **default email client** directly whenever an email is sent useful for local testing.

**Note:** You should have default email client set to open ***eml*** format files by default otherwise it won't work. Normally most email clients open .eml files by default.

## Requirements

 - PHP >= 5.6
 - Laravel 5.5 or greater

## Installation

Via Composer

``` bash
$ composer require sarfraznawaz2005/emailwatch
```

---

Publish package's config file by running below command:

```bash
$ php artisan vendor:publish --provider="Sarfraznawaz2005\EmailWatch\ServiceProvider"
```
It should publish `config/emailwatch.php` config file. Now make sure package is enabled by setting `enabled` value in `config/emailwatch.php`.

## Credits

- [Sarfraz Ahmed][link-author]
- [All Contributors][link-contributors]

## License

Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sarfraznawaz2005/emailwatch.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sarfraznawaz2005/emailwatch.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sarfraznawaz2005/emailwatch
[link-downloads]: https://packagist.org/packages/sarfraznawaz2005/emailwatch
[link-author]: https://github.com/sarfraznawaz2005
[link-contributors]: https://github.com/sarfraznawaz2005/emailwatch/graphs/contributors
