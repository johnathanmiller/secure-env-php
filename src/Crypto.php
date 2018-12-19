<?php

namespace SecureEnvPHP;

class Crypto {

    /**
     * Decrypts environment file and returns content in a string
     * 
     * @param array $options
     * @return string
     */
    public function decrypt(array $options) : string {
        $options['path'] = $options['path'] ?? '.env.enc';

        if (empty($options['path'])) {
            throw new \Exception('Path key is empty.');
        }

        if (!file_exists($options['path'])) {
            throw new \Exception('File does not exist.');
        }

        if (isset($options['algo']) && !empty($options['algo']) && !in_array($options['algo'], openssl_get_cipher_methods(true))) {
            throw new \Exception('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }

        if (!isset($options['secret'])) {
            throw new \Exception('Secret key not found in options object.');
        }
        
        $path = fopen($options['path'], 'rb');
        $secret = $options['secret'];
        $algo = $options['algo'] ?? 'aes256';
        $iv = fread($path, openssl_cipher_iv_length($algo));
        $cipher = fread($path, filesize($options['path']));

        $decrypted = openssl_decrypt($cipher, $algo, $secret, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }

    /**
     * Encrypts environment variables and saves them to a separate file
     * 
     * @param array $options
     */
    public function encrypt(array $options) : void {
        if (!isset($options['path'])) {
            throw new \Exception('Path key not found in options object.');
        }

        if (empty($options['path'])) {
            throw new \Exception('Path key is empty.');
        }

        if (!file_exists($options['path'])) {
            throw new \Exception('File does not exist.');
        }

        if (isset($options['algo']) && !empty($options['algo']) && !in_array($options['algo'], openssl_get_cipher_methods(true))) {
            throw new \Exception('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }

        if (!isset($options['secret'])) {
            throw new \Exception('Secret key not found in options object.');
        }
            
        $secret = $options['secret'];
        $algo = $options['algo'] ?? 'aes256';
        $output = $options['output'] ?? $options['path'] . '.enc';
        $path = fopen($options['path'], 'r');
        $data = fread($path, filesize($options['path']));
        fclose($path);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($algo));

        $output_file = fopen($output, 'w');
        fwrite($output_file, $iv);

        $cipher = openssl_encrypt($data, $algo, $secret, OPENSSL_RAW_DATA, $iv);

        fwrite($output_file, $cipher);
        fclose($output_file);
    }

}