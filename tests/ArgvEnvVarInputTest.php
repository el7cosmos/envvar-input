<?php

namespace Tests;

use EnvVarInput\ArgvEnvVarInput;
use EnvVarInput\EnvVarInputOption;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ArgvEnvVarInputTest extends TestCase
{

    /**
     * @var \Symfony\Component\Console\Input\InputDefinition
     */
    private $definition;

    public function testDefaultInput(): void
    {
        $this->definition->addOption(
            new InputOption(
                'option',
                null,
                InputOption::VALUE_REQUIRED
            )
        );
        $_SERVER['OPTION'] = 'option';
        $input = new ArgvEnvVarInput([], $this->definition);
        self::assertNull($input->getOption('option'));
    }

    public function testNoValue(): void
    {
        $this->definition->addOption(
            new EnvVarInputOption(
                'option',
                null,
                InputOption::VALUE_REQUIRED
            )
        );
        unset($_SERVER['OPTION']);
        $input = new ArgvEnvVarInput([], $this->definition);
        self::assertNull($input->getOption('option'));
    }

    public function testWithEnvVar(): void
    {
        $this->definition->addOption(
            new EnvVarInputOption(
                'option',
                null,
                InputOption::VALUE_REQUIRED
            )
        );
        $_SERVER['OPTION'] = 'option';
        $input = new ArgvEnvVarInput([], $this->definition);
        self::assertEquals('option', $input->getOption('option'));
    }

    public function testWithValue(): void
    {
        $this->definition->addOption(
            new EnvVarInputOption(
                'option',
                null,
                InputOption::VALUE_REQUIRED
            )
        );
        $_SERVER['OPTION'] = 'option';
        $input = new ArgvEnvVarInput(['command', '--option', 'test'], $this->definition);
        self::assertEquals('test', $input->getOption('option'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->definition = new InputDefinition();
    }
}
