<?php declare(strict_types = 1);

namespace SecureEnvPHP;

class Parser
{
    /**
     * Parses environment file variables and returns an associative array
     *
     * @param string $content
     *
     * @return array
     */
    public static function parse(string $content): array
    {
        $lines = explode("\n", $content);

        $object = [];

        foreach ($lines as $line) {
            if (preg_match('/^\s*([\w\.\-]+)\s*=\s*(.*)?\s*$/', $line, $matches)) {
                $key = $matches[1];
                $value = $matches[2] ?? '';

                $length = $value ? strlen($value) : 0;
                if ($length > 0 && strpos($value, '"') === 0 && substr($value, -1) === '"') {
                    $value = preg_replace('/\\n/gm', "\n", $value);
                }

                $value = trim(preg_replace('/(^[\'"]|[\'"]$)/', '', $value));

                $object[$key] = $value;
            }
        }

        return $object;
    }
}
