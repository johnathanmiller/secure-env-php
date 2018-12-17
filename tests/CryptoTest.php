<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\Crypto;

class SecureEnvPHPTest extends TestCase {

    // ENCRYPTION TESTS
    public function testEncryptMissingPathKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path key not found in options object.');
        (new Crypto)->encrypt([]);
    }

    public function testEncryptEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path key is empty.');
        (new Crypto)->encrypt([
            'path' => ''
        ]);
    }

    public function testEncryptInvalidPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto)->encrypt([
            'path' => './tests/.wrong.env'
        ]);
    }

    public function testEncryptUnknownAlgorithm() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto)->encrypt([
            'path' => './tests/.env',
            'algo' => 'not-supported-or-unknown'
        ]);
    }

    public function testEncryptMissingSecretKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Secret key not found in options object.');
        (new Crypto)->encrypt([
            'path' => './tests/.env'
        ]);
    }

    public function testEncrypt() : void {
        (new Crypto)->encrypt([
            'path' => './tests/.env',
            'secret' => 'test'
        ]);
        $this->assertTrue(file_exists('./tests/.env.enc'));
    }

    // DECRYPTION TESTS
    public function testDecryptEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Path key is empty.');
        (new Crypto)->decrypt([
            'path' => ''
        ]);
    }

    public function testDecryptInvalidPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto)->decrypt([
            'path' => './tests/.wrong.env'
        ]);
    }

    public function testDecryptUnknownAlgorithm() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto)->decrypt([
            'path' => './tests/.env.enc',
            'algo' => 'not-supported-or-unknown',
            'secret' => 'test'
        ]);
    }

    public function testDecryptMissingSecretKey() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Secret key not found in options object.');
        (new Crypto)->decrypt([
            'path' => './tests/.env.enc'
        ]);
    }

    public function testDecrypt() : void {
        $crypto = new Crypto;
        $decrypt = $crypto->decrypt([
            'path' => './tests/.env.enc',
            'secret' => 'test'
        ]);
        $this->assertNotEmpty($decrypt);
    }

}