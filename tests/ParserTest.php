<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\Crypto;
use \SecureEnvPHP\Parser as Parser;

class SecureEnvPHPTest extends TestCase {

    // PARSE TEST
    public function testParse() : void {
        $crypto = new Crypto;
        $decrypt = $crypto->decrypt([
            'path' => './tests/.env.enc',
            'secret' => 'test'
        ]);

        $parsed = Parser::parse($decrypt);

        $this->assertNotEmpty($parsed);
        $this->assertSame(['FOO' => 'bar'], $parsed);
    }

}