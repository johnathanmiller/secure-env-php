<?php declare(strict_types = 1);

namespace SecureEnvPHP;

use Exception;
use RuntimeException;

class Crypto
{
    /**
     * Decrypts environment file and returns content in a string
     *
     * @param string $secret
     * @param string $path
     * @param string $algo
     *
     * @return string
     */
    public function decrypt(string $path = Constants::ENV_ENC, string $secret = '', string $algo = Constants::ALGO): string
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File does not exist.');
        }

        if (!in_array($algo, openssl_get_cipher_methods(true), true)) {
            throw new RuntimeException('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }

        if (file_exists($secret) && !is_dir($secret)) {
            $secret = (new Key())->read($secret);
        }

        $handler = fopen($path, 'rb');
        $iv = fread($handler, openssl_cipher_iv_length($algo));
        $cipher = fread($handler, filesize($path));

        return openssl_decrypt($cipher, $algo, $secret, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Encrypts environment variables and saves them to a separate file
     *
     * @param string $secret
     * @param string $path
     * @param string $algo
     * @param string|null $output
     *
     * @throws Exception
     */
    public function encrypt(string $path = Constants::ENV_ENC, string $secret = '', string $algo = Constants::ALGO, ?string $output = null): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File does not exist.');
        }

        if (!in_array($algo, openssl_get_cipher_methods(true), true)) {
            throw new RuntimeException('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }

        $output = $output ?? $path.'.enc';
        $handler = fopen($path, 'rb');
        $data = fread($handler, filesize($path));
        fclose($handler);

        if (function_exists('random_bytes')) {
            $iv = random_bytes(openssl_cipher_iv_length($algo));
        } else {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($algo));
        }

        $output_file = fopen($output, 'wb');
        fwrite($output_file, $iv);

        $cipher = openssl_encrypt($data, $algo, $secret, OPENSSL_RAW_DATA, $iv);

        fwrite($output_file, $cipher);
        fclose($output_file);
    }
}
