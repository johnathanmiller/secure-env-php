<?php declare(strict_types = 1);

namespace SecureEnvPHP\Tests;

use PHPUnit\Framework\TestCase;
use SecureEnvPHP\Constants;
use SecureEnvPHP\Crypto;
use SecureEnvPHP\Parser;

class ParserTest extends TestCase
{
    /**
     * Test parsing decrypted env file and matching expected object
     */
    public function testParse(): void
    {
        $decrypt = (new Crypto())->decrypt(Constants::ENV_ENC_TEST, Constants::ENV_KEY_TEST);

        $parsed = Parser::parse($decrypt);

        $this->assertNotEmpty($parsed);
        $this->assertSame(['FOO' => 'bar'], $parsed);
    }
}
