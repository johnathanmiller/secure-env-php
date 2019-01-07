<?php

namespace SecureEnvPHP;

class Constants
{
    public const TESTS = './tests/';
    public const ENV_FILE = '.env';
    public const ENV_KEY = '.env.key';
    public const ENV_ENC = '.env.enc';
    public const ALGO = 'aes256';

    public const ENV_FILE_TEST = self::TESTS.self::ENV_FILE;
    public const ENV_KEY_TEST = self::TESTS.self::ENV_KEY;
    public const ENV_ENC_TEST = self::TESTS.self::ENV_ENC;
    public const ENV_WRONG_TEST = self::TESTS.'.wrong.env';
    public const KEY_FILE_TEST = self::TESTS.'.keyfile';
}
