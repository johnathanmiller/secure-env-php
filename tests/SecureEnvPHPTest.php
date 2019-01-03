<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\SecureEnvPHP;

class SecureEnvPHPTest extends TestCase {

    /**
     * Testing with path to env and path to secret key, then retrieving env value
     */
    public function testInitWithSecretPathAndGetEnv() : void {
        $secureEnv = new SecureEnvPHP();
        $secureEnv->parse([
            'path' => './tests/.env.enc',
            'secret' => './tests/.env.key'
        ]);
        $this->assertTrue($secureEnv instanceof SecureEnvPHP);
        $this->assertEquals('bar', getenv('FOO'));
    }

    /**
     * Testing with path to env and secret string, then retrieving env value
     */
    public function testInitWithSecretStringAndGetEnv() : void {
        $path = './tests/.env.key';
        $key_file = fopen($path, 'r');
        $secret = fread($key_file, filesize($path));
        fclose($key_file);
        
        $secureEnv = new SecureEnvPHP();
        $secureEnv->parse([
            'path' => './tests/.env.enc',
            'secret' => $secret
        ]);
        $this->assertTrue($secureEnv instanceof SecureEnvPHP);
        $this->assertEquals('bar', getenv('FOO'));
    }

    /**
     * Test retrieving env value
     */
    public function testGetEnv() : void {
        $this->assertEquals('bar', getenv('FOO'));
    }

}
