<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\Crypto;
use \SecureEnvPHP\Parser as Parser;

class ParserTest extends TestCase {

    /**
     * Test parsing decrypted env file and matching expected object
     */
    public function testParse() : void {
        $crypto = new Crypto;
        $decrypt = $crypto->decrypt([
            'path' => './tests/.env.enc',
            'secret' => './tests/.env.key'
        ]);

        $parsed = Parser::parse($decrypt);

        $this->assertNotEmpty($parsed);
        $this->assertSame(['FOO' => 'bar'], $parsed);
    }

}