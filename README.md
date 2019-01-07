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
Instantiate class with your decryption arguments. First argument is path to your encrypted env file, second argument is path to your secret key file, and optionally a third argument can be set for your choice of encryption algorithm, *(this needs to match the algorithm you used to encrypt your env file)*.
```php
(new SecureEnvPHP())->parse('.env.enc', '.env.key');
```

## Decryption Options
| parameter | description | default |
| ------ | ---------- | ------- |
| 1. path | Path to encrypted file | `.env.enc`
| 2. secret | Path to key file *or* secret string |
| 3. algo | Encryption algorithm | `aes256`

## Retrieving Env Values
After instantiating the SecureEnvPHP class you can retrieve your values in your project by calling `getenv` with your variable names, such as `getenv('DB_HOST')`.

## Full Example
```php
<?php

require_once './vendor/autoload.php';

use SecureEnvPHP\SecureEnvPHP;

(new SecureEnvPHP())->parse('.env.enc', '.env.key');

$host = getenv('DB_HOST');
```

## Acknowledgements
**Secure Env PHP** is inspired by https://github.com/kunalpanchal/secure-env for NodeJS.
