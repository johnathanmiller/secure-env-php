# Secure Env PHP

[![Build Status](https://travis-ci.org/johnathanmiller/secure-env-php.svg?branch=master)](https://travis-ci.org/johnathanmiller/secure-env-php)

Env encryption and decryption library.  
Prevent committing and exposing vulnerable plain-text environment variables in production environments.

You can view a more in-depth tutorial on [Medium](https://medium.com/@johnathanmiller/securing-php-environment-variables-for-production-use-f867e584a1f9).

## Installation
Install secure-env-php using Composer
```
composer require johnathanmiller/secure-env-php
```

## .env
Create an `.env` file in your project with environment variables.
```dosini
DB_HOST=localhost
DB_USER=username
DB_PASS=password
```

## Encrypting
Execute `vendor/bin/encrypt-env` in your project directory and follow the command prompts to encrypt your `.env` file. You can press enter to accept the default values in the square brackets.

![Encryption Prompts](https://cdn-images-1.medium.com/max/1600/1*PCjFohyf8AMoL_lHOaip4A.png)
## Encryption Prompts
1. Path to your .env file you want to encrypt.
2. Input "y" or "yes" to generate a new secret key file. Otherwise input path to secret key file when prompted.
3. Your choice of encryption algorith or accept the default provided. For a list of supported algorithms visit: https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php.
4. Path to save the encrypted environment file.

After you've successfully completed the prompts you should now have an encrypted environment file.

## Import and Instantiate
Import into namespace environment
```php
use SecureEnvPHP\SecureEnvPHP;
```
Instantiate class with decryption options.
```php
(new SecureEnvPHP())->parse(
    '.env.enc', //path
    '.env.key' //secret
);
```

## Decryption Options
| name | description | default |
| ------ | ---------- | ------- |
| algo | Encryption algorithm | `aes256`
| path | Path to encrypted file | `.env.enc`
| secret | Path to key file *or* secret string |

## Retrieving Env Values
After instantiating the SecureEnvPHP class you can retrieve your values in your project by calling `getenv` with your variable names, such as `getenv('DB_HOST')`.

## Full Example
```php
<?php

require_once './vendor/autoload.php';

use SecureEnvPHP\SecureEnvPHP;

(new SecureEnvPHP())->parse(
    '.env.enc', //path
    '.env.key' //secret
);

$host = getenv('DB_HOST');
```

## Acknowledgements
**Secure Env PHP** is inspired by https://github.com/kunalpanchal/secure-env for NodeJS.
