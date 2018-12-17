<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\SecureEnvPHP;

class SecureEnvPHPTest extends TestCase {

    // INIT TEST
    public function testInitAndGetEnv() : void {
        $secureEnv = new SecureEnvPHP([
            'path' => './tests/.env.enc',
            'secret' => 'test'
        ]);
        $this->assertTrue($secureEnv instanceof SecureEnvPHP);
    }

    // GET ENV VAR TEST
    public function testGetEnv() : void {
        $this->assertEquals('bar', getenv('FOO'));
    }

}