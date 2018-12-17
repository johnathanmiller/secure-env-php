# Secure Env PHP
Env encryption and decryption library.  
Prevent commiting and exposing vulnerable plain-text environment variables in production environments.

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
In your project directory, run through the command prompts to encrypt your `.env` file by running `vendor/bin/encrypt-env` in the terminal. You can press enter to accept the default values in the square brackets.
```bash
Path to .env file [.env]: /path/to/.env  
Secret (make sure to copy this or input your own) [randomstring]: secretkey  
Encryption algorithm [aes256]: algorithm-name  
Save to [.env.enc]: /path/to/.env.enc  
```

## Encryption Options
| Prompt | default |
| ------ | ------- |
| Path to .env file | `.env`
| Secret | `randomly generated string`
| Encryption algorithm | `aes256`
| Output path to encrypted file | `.env.enc`

For a list of supported algorithms visit: https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php.

## Import and Instantiate
Import into namespace environment
```php
use SecureEnvPHP\SecureEnvPHP;
```
Instantiate class with decryption options.
```php
new SecureEnvPHP([
    'path' => '.env',
    'secret' => 'secretkey'
]);
```

## Decryption Options
| name | description | default |
| ------ | ---------- | ------- |
| algo | Encryption algorithm | `aes256`
| path | Path to encrypted file | `.env.enc`
| secret | Secret key |

## Retrieving Env Values
After instantiating the SecureEnvPHP class you can retrieve your values in your project by calling `getenv` with your variable names, such as `getenv('DB_HOST')`.

## Full Example
```php
<?php

require_once './vendor/autoload.php';

use SecureEnvPHP\SecureEnvPHP;

new SecureEnvPHP([
    'path' => '.env.enc',
    'secret' => '924f028a2e2055193caa03a77754ccc6'
]);

$host = getenv('DB_HOST');
```

## Acknowledgements
**Secure Env PHP** is inspired by https://github.com/kunalpanchal/secure-env for NodeJS.