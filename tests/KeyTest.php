<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use \SecureEnvPHP\Key;

class KeyTest extends TestCase {

    /**
     * Test attempt to read secret key file with empty path string
     */
    public function testReadEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Key path is empty.');
        (new Key)->read('');
    }

    /**
     * Test attempt to read secret key file with invalid path/file
     */
    public function testReadInvalidKeyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Key file not found.');
        (new Key)->read('./tests/.keyfile');
    }

    /**
     * Test attempt to generate secret key file with empty path string
     */
    public function testGenerateEmptyPath() : void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Key path is empty.');
        (new Key)->generate('');
    }

}