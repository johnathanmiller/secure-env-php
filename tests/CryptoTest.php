<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\Crypto;
use \SecureEnvPHP\Key;

class CryptoTest extends TestCase {

    /**
     * Test encryption with missing path key/value in object
     */
    public function testEncryptMissingPathKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path not found in options object.');
        (new Crypto)->encrypt([]);
    }

    /**
     * Test encryption with empty path value in object
     */
    public function testEncryptEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path is empty.');
        (new Crypto)->encrypt([
            'path' => ''
        ]);
    }

    /**
     * Test encryption with invalid path/file value
     */
    public function testEncryptInvalidPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto)->encrypt([
            'path' => './tests/.wrong.env'
        ]);
    }

    /**
     * Test encryption with unknown algorithm
     */
    public function testEncryptUnknownAlgorithm() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto)->encrypt([
            'path' => './tests/.env',
            'algo' => 'not-supported-or-unknown'
        ]);
    }

    /**
     * Test encryption with missing secret key/value in object
     */
    public function testEncryptMissingSecretKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Secret not found in options object.');
        (new Crypto)->encrypt([
            'path' => './tests/.env'
        ]);
    }

    /**
     * Test encryption with a newly generated secret key file
     */
    public function testEncryptWithGeneratedKey() : void {
        $secret = (new Key)->generate('./tests/.env.key');
        $this->assertNotEmpty($secret);

        (new Crypto)->encrypt([
            'path' => './tests/.env',
            'secret' => $secret
        ]);
        $this->assertTrue(file_exists('./tests/.env.enc'));
    }

    /**
     * Test encryption with content string from secret key file
     */
    public function testEncryptWithKeyString() : void {
        $secret = (new \SecureEnvPHP\Key)->read('./tests/.env.key');
        (new Crypto)->encrypt([
            'path' => './tests/.env',
            'secret' => $secret
        ]);
        $this->assertTrue(file_exists('./tests/.env.enc'));
    }

    /**
     * Test decryption with empty path value in object
     */
    public function testDecryptEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path is empty.');
        (new Crypto)->decrypt([
            'path' => ''
        ]);
    }

    /**
     * Test decryption with invalid env path/file
     */
    public function testDecryptInvalidPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto)->decrypt([
            'path' => './tests/.wrong.env'
        ]);
    }

    /**
     * Test decryption with unknown algorithm
     */
    public function testDecryptUnknownAlgorithm() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto)->decrypt([
            'path' => './tests/.env.enc',
            'algo' => 'not-supported-or-unknown',
            'secret' => './tests/.env.key'
        ]);
    }

    /**
     * Test decryption with missing secret key/value
     */
    public function testDecryptMissingSecretKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Secret key not found in options object.');
        (new Crypto)->decrypt([
            'path' => './tests/.env.enc'
        ]);
    }

    /**
     * Test decryption with path to secret key file
     */
    public function testDecryptWithSecretKeyFile() : void {
        $crypto = new Crypto;
        $decrypt = $crypto->decrypt([
            'path' => './tests/.env.enc',
            'secret' => './tests/.env.key'
        ]);
        $this->assertNotEmpty($decrypt);
    }

    /**
     * Test decryption with content string from secret key file
     */
    public function testDecryptWithSecretKeyString() : void {
        $secret = (new \SecureEnvPHP\Key)->read('./tests/.env.key');
        $this->assertNotEmpty($secret);

        $crypto = new Crypto;
        $decrypt = $crypto->decrypt([
            'path' => './tests/.env.enc',
            'secret' => $secret
        ]);
        $this->assertNotEmpty($decrypt);
    }

}