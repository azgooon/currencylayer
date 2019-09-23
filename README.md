# WIP

# :currency_exchange: PHP client for [currencylayer.com](https://currencylayer.com)

[![Latest Stable Version](https://poser.pugx.org/orkhanahmadov/currencylayer/v/stable)](https://packagist.org/packages/orkhanahmadov/currencylayer)
[![Latest Unstable Version](https://poser.pugx.org/orkhanahmadov/currencylayer/v/unstable)](https://packagist.org/packages/orkhanahmadov/currencylayer)
[![Total Downloads](https://img.shields.io/packagist/dt/orkhanahmadov/currencylayer)](https://packagist.org/packages/orkhanahmadov/currencylayer)
[![License](https://img.shields.io/github/license/orkhanahmadov/currencylayer.svg)](https://github.com/orkhanahmadov/currencylayer/blob/master/LICENSE.md)

[![Build Status](https://img.shields.io/travis/orkhanahmadov/currencylayer.svg)](https://travis-ci.org/orkhanahmadov/currencylayer)
[![Test Coverage](https://api.codeclimate.com/v1/badges/a914e880498f0baf6b70/test_coverage)](https://codeclimate.com/github/orkhanahmadov/currencylayer/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/a914e880498f0baf6b70/maintainability)](https://codeclimate.com/github/orkhanahmadov/currencylayer/maintainability)
[![Quality Score](https://img.shields.io/scrutinizer/g/orkhanahmadov/currencylayer.svg)](https://scrutinizer-ci.com/g/orkhanahmadov/currencylayer)
[![StyleCI](https://github.styleci.io/repos/209733029/shield?branch=master)](https://github.styleci.io/repos/209733029)

Simple PHP client for currencylayer.com currency rates.

## Installation

You can install the package via composer:

```bash
composer require orkhanahmadov/currencylayer
```

## Usage

Instantiate `Orkhanahmadov\Currencylayer\CurrencylayerClient` class and pass your "access key"

```php
use Orkhanahmadov\Currencylayer\CurrencylayerClient;

$client = new CurrencylayerClient('your-access-key-here');
```

You can find your access key in [Currencylayer Dashboard](https://currencylayer.com/dashboard).

If you are using [paid plan](https://currencylayer.com/product), you can use HTTPS connection to currencylayer.com API.
While instantiating pass `true` as second parameter to use HTTPS connection.

```php
$client = new CurrencylayerClient('your-access-key-here', true);
```

## Available methods

### `list()`
// todo

### `quotes()`

Use this method to fetch live and historical currency rates.

Pass source currency to `source()` method and rate currency `currency()` method.
Following example will fetch live rates from USD to EUR.

```php
$client->source('USD')->currency('EUR')->quotes();
```

You can also pass multiple rate currencies to `currency()` method as an array:

```php
$client->source('USD')->currency(['EUR', 'AUD'])->quotes();
```

If you want fetch rates for specific date, you can pass the date to `date()` method.
`date()` method accepts dates as string or instance of `DateTimeImmutable`.

```php
$client->source('USD')->currency('EUR')->date('2019-05-20')->quotes();
```

`quotes()` method returns instance of `Orkhanahmadov\Currencylayer\Data\Quotes`.
This class has following methods that you can use:

* `getSource()` - Returns source currency (for example, `USD`)
* `getTimestamp()` - Returns timestamp value from currencylayer API (for example, `1432400348`)
* `getQuotes()` - Returns array of quotes from currencylayer API
* `getDate()` - Returns `DateTimeImmutable` date. If you fetched live rates this method will return `null`

You can also get rates for each fetched currency using currency name as property:

```php
$quotes = $client->source('USD')->currency(['EUR', 'AUD'])->date('2019-05-20')->quotes();

$qoutes->EUR; // returns USD to EUR rate for 2019-05-20
$qoutes->AUD; // returns USD to AUD rate for 2019-05-20
```

### `convert()`

Use this method to convert amount in one currency to another currency.

Pass source currency to `source()` method, rate currency `currency()` method and amount to `convert()` method.
Following example will convert 10 USD to GBP using live rates.

```php
$client->source('USD')->currency('GBP')->convert(10);
```

If you want conversion based on different date's rates, you can pass the date to `date()` method.
`date()` method accepts dates as string or instance of `DateTimeImmutable`.

```php
$client->source('USD')->currency('GBP')->date('2019-05-20')->convert(10);
```

`convert()` method returns instance of `Orkhanahmadov\Currencylayer\Data\Conversion`.
This class has following methods that you can use:

* `getFromCurrency()` - Returns source currency (for example, `USD`)
* `getToCurrency()` - Returns target currency (for example, `GBP`)
* `getTimestamp()` - Returns timestamp value from currencylayer API (for example, `1432400348`)
* `getAmount()` - Returns amount that passed to `convert()` method (for example, `10`)
* `getQuote()` - Returns quote between source and target currencies (for example, `0.658443`)
* `getResult()` - Returns conversion result (for example `6.58443`)
* `getDate()` - Returns `DateTimeImmutable` date. If you fetched live rates this method will return `null`

### `timeframe()`





### `change()`





### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ahmadov90@gmail.com instead of using the issue tracker.

## Credits

- [Orkhan Ahmadov](https://github.com/orkhanahmadov)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
