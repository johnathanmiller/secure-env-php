<?php

namespace SecureEnvPHP;

use \SecureEnvPHP\Parser as Parser;

class SecureEnvPHP {

    public function __construct(array $options) {
        $crypto = new \SecureEnvPHP\Crypto;

        if ($decrypted = $crypto->decrypt($options)) {
            $parsed = Parser::parse($decrypted);

            foreach ($parsed as $key => $value) {
                if (isset($parsed[$key]) && !empty($parsed[$key])) {
                    putenv($key . '=' . $value);
                }
            }
        }
    }

}