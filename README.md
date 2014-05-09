# Wordpress SDK
[![Build Status](https://travis-ci.org/benja-M-1/wordpress-sdk.png?branch=master)](https://travis-ci.org/benja-M-1/wordpress-sdk) [![Latest Stable Version](https://poser.pugx.org/benjam1/wordpress-sdk/v/stable.png)](https://packagist.org/packages/benjam1/wordpress-sdk) [![Total Downloads](https://poser.pugx.org/benjam1/wordpress-sdk/downloads.png)](https://packagist.org/packages/benjam1/wordpress-sdk) [![Latest Unstable Version](https://poser.pugx.org/benjam1/wordpress-sdk/v/unstable.png)](https://packagist.org/packages/benjam1/wordpress-sdk) [![License](https://poser.pugx.org/benjam1/wordpress-sdk/license.png)](https://packagist.org/packages/benjam1/wordpress-sdk) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benja-M-1/wordpress-sdk/badges/quality-score.png?s=1d134454a71636861f1f266c35288bbf7fb0afed)](https://scrutinizer-ci.com/g/benja-M-1/wordpress-sdk/)

Wordpress WML-RPC API sdk written in PHP

## Installation

Install Wordpress-SDK through [composer](http://getcomposer.org/)

```bash
$> composer require benjam1/wordpress-sdk
```

## Usage

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

$wordpress = new \BenjaM1\Wordpress\Wordpress('http://www.theodo.fr/blog/xmlrpc.php');
$wordpress->connect('username', 'password');
$wordpress->getUsers();
```

## Testing

```bash
$> composer install --dev
$> ./vendor/bin/phpspec run
```