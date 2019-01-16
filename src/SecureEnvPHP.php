<?php declare(strict_types = 1);

namespace SecureEnvPHP;

use Exception;
use RuntimeException;

class SecureEnvPHP
{
    public function parse(string $path = Constants::ENV_ENC, string $secret = '', string $algo = Constants::ALGO): void
    {
        try {
            if ($decrypted = (new Crypto())->decrypt($path, $secret, $algo)) {
                $parsed = Parser::parse($decrypted) ?? [];

                foreach ($parsed as $key => $value) {
                    if (isset($parsed[$key]) && !empty($parsed[$key])) {
                        putenv($key.'='.$value);
                    }
                }
            }
        } catch (Exception $e) {
            throw new RuntimeException('Parser failed to decrypt environment.');
        }
    }
}
