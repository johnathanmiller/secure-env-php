<?php

namespace SecureEnvPHP;

class Key {

    /**
     * Reads key file contents
     * 
     * @param string $path
     * @return string
     */
    public function read(string $path) : string {
        if (empty($path)) {
            throw new \Exception('Key path is empty.');
        }

        if (!file_exists($path) || is_dir($path)) {
            throw new \Exception('Key file not found.');
        }

        $key_file = fopen($path, 'r');
        $secret = fread($key_file, filesize($path));

        fclose($key_file);

        return $secret;
    }

    /**
     * Generates key file
     * 
     * @param string $path
     * @return string
     */
    public function generate(string $path) : string {
        if (empty($path)) {
            throw new \Exception('Key path is empty.');
        }

        $key_file = fopen($path, 'w');

        if (function_exists('random_bytes')) {
            $secret = bin2hex(random_bytes(128));

        } else {
            $secret = bin2hex(openssl_random_pseudo_bytes(128));
        }

        fwrite($key_file, $secret);
        fclose($key_file);

        return $secret;
    }

}