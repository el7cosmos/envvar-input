<?php

namespace EnvVarInput;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\String\UnicodeString;

class EnvVarInputOption extends InputOption
{

    private $env;

    private $prefix;

    /**
     * @param string $name The option name
     * @param string|array<string>|null $shortcut The shortcuts, can be null, a
     *     string of shortcuts delimited by | or an array of shortcuts
     * @param int|null $mode The option mode: One of the VALUE_* constants
     * @param string $description A description text
     * @param string|string[]|int|bool|null $default The default value (must be
     *     null for self::VALUE_NONE)
     * @param string|null $env
     * @param string|null $prefix
     */
    public function __construct(
        string $name,
        $shortcut = null,
        int $mode = null,
        string $description = '',
        $default = null,
        ?string $env = null,
        ?string $prefix = null
    ) {
        if (self::VALUE_REQUIRED !== $mode) {
            throw new InvalidArgumentException(
                __CLASS__ . " only support VALUE_REQUIRED mode."
            );
        }

        parent::__construct($name, $shortcut, $mode, $description, $default);

        $this->env = $env;
        $this->prefix = $prefix;
    }

    public function getEnvVarName(): string
    {
        $suffix = $this->env ?: (new UnicodeString($this->getName()))->snake()
            ->upper();
        return $this->prefix ? $this->prefix . '_' . $suffix : $suffix;
    }
}
