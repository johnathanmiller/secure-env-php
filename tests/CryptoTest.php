<?php declare(strict_types = 1);

namespace SecureEnvPHP\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use SecureEnvPHP\Constants;
use SecureEnvPHP\Crypto;
use SecureEnvPHP\Key;

class CryptoTest extends TestCase
{
    /**
     * Test encryption with invalid path/file value
     */
    public function testEncryptInvalidPath(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto())->encrypt(Constants::ENV_WRONG_TEST);
    }

    /**
     * Test encryption with unknown algorithm
     */
    public function testEncryptUnknownAlgorithm(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto())->encrypt(Constants::ENV_FILE_TEST, '', 'not-supported-or-unknown');
    }

    /**
     * Test encryption with a newly generated secret key file
     */
    public function testEncryptWithGeneratedKey(): void
    {
        $secret = (new Key())->generate(Constants::ENV_KEY_TEST);
        $this->assertNotEmpty($secret);

        (new Crypto())->encrypt(Constants::ENV_FILE_TEST, $secret);
        $this->assertFileExists(Constants::ENV_ENC_TEST);
    }

    /**
     * Test encryption with content string from secret key file
     */
    public function testEncryptWithKeyString(): void
    {
        $secret = (new Key())->read(Constants::ENV_KEY_TEST);
        (new Crypto())->encrypt(Constants::ENV_FILE_TEST, $secret);
        $this->assertFileExists(Constants::ENV_ENC_TEST);
    }

    /**
     * Test decryption with invalid env path/file
     */
    public function testDecryptInvalidPath(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File does not exist.');
        (new Crypto())->decrypt(Constants::ENV_WRONG_TEST);
    }

    /**
     * Test decryption with unknown algorithm
     */
    public function testDecryptUnknownAlgorithm(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        (new Crypto())->decrypt(Constants::ENV_ENC_TEST, Constants::ENV_KEY_TEST, 'not-supported-or-unknown');
    }

    /**
     * Test decryption with path to secret key file
     */
    public function testDecryptWithSecretKeyFile(): void
    {
        $decrypt = (new Crypto())->decrypt(Constants::ENV_ENC_TEST, Constants::ENV_KEY_TEST);
        $this->assertNotEmpty($decrypt);
    }

    /**
     * Test decryption with content string from secret key file
     */
    public function testDecryptWithSecretKeyString(): void
    {
        $secret = (new Key)->read(Constants::ENV_KEY_TEST);
        $this->assertNotEmpty($secret);

        $decrypt = (new Crypto())->decrypt(Constants::ENV_ENC_TEST, $secret);
        $this->assertNotEmpty($decrypt);
    }
}
