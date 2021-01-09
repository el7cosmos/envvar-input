<?php

namespace Tests;

use EnvVarInput\EnvVarInputOption;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class EnvVarInputOptionTest extends TestCase
{

    /**
     * @return array<string, array<int, int>>
     */
    public static function unsupportedModeProvider(): array
    {
        return [
            'VALUE_NONE' => [EnvVarInputOption::VALUE_NONE],
            'VALUE_IS_ARRAY' => [EnvVarInputOption::VALUE_IS_ARRAY],
            'VALUE_OPTIONAL' => [EnvVarInputOption::VALUE_OPTIONAL],
        ];
    }

    /**
     * @param int $mode
     *
     * @dataProvider unsupportedModeProvider
     */
    public function testUnsupportedMode(int $mode): void
    {
        $this->expectException(InvalidArgumentException::class);
        new EnvVarInputOption('name', null, $mode);
    }

    public function testDefaultNoPrefix(): void
    {
        $option = new EnvVarInputOption(
            'name',
            null,
            EnvVarInputOption::VALUE_REQUIRED
        );
        self::assertEquals('NAME', $option->getEnvVarName());
    }

    public function testCustomNoPrefix(): void
    {
        $option = new EnvVarInputOption(
            'name',
            null,
            EnvVarInputOption::VALUE_REQUIRED,
            '',
            null,
            'CUSTOM'
        );
        self::assertEquals('CUSTOM', $option->getEnvVarName());
    }

    public function testDefaultWithPrefix(): void
    {
        $option = new EnvVarInputOption(
            'name',
            null,
            EnvVarInputOption::VALUE_REQUIRED,
            '',
            null,
            null,
            'PREFIX'
        );
        self::assertEquals('PREFIX_NAME', $option->getEnvVarName());
    }

    public function testCustomWithPrefix(): void
    {
        $option = new EnvVarInputOption(
            'name',
            null,
            EnvVarInputOption::VALUE_REQUIRED,
            '',
            null,
            'CUSTOM',
            'PREFIX'
        );
        self::assertEquals('PREFIX_CUSTOM', $option->getEnvVarName());
    }
}
