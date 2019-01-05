<?php declare(strict_types = 1);

namespace SecureEnvPHP\Tests;

use PHPUnit\Framework\TestCase;
use SecureEnvPHP\Constants;
use SecureEnvPHP\SecureEnvPHP;

class SecureEnvPHPTest extends TestCase
{
    /**
     * Testing with path to env and path to secret key, then retrieving env value
     */
    public function testInitWithSecretPathAndGetEnv(): void
    {
        $secureEnv = new SecureEnvPHP();
        $secureEnv->parse(Constants::ENV_ENC_TEST, Constants::ENV_KEY_TEST);
        $this->assertInstanceOf(SecureEnvPHP::class, $secureEnv);
        $this->assertEquals('bar', getenv('FOO'));
    }

    /**
     * Testing with path to env and secret string, then retrieving env value
     */
    public function testInitWithSecretStringAndGetEnv(): void
    {
        $path = Constants::ENV_KEY_TEST;
        $key_file = fopen($path, 'rb');
        $secret = fread($key_file, filesize($path));
        fclose($key_file);

        $secureEnv = new SecureEnvPHP();
        $secureEnv->parse(Constants::ENV_ENC_TEST, $secret);
        $this->assertInstanceOf(SecureEnvPHP::class, $secureEnv);
        $this->assertEquals('bar', getenv('FOO'));
    }

    /**
     * Test retrieving env value
     */
    public function testGetEnv(): void
    {
        $this->assertEquals('bar', getenv('FOO'));
    }
}
