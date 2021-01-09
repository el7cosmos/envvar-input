<?php

namespace EnvVarInput;

use Symfony\Component\Console\Input\ArgvInput;

class ArgvEnvVarInput extends ArgvInput
{

    protected function parse(): void
    {
        parent::parse();

        foreach ($this->definition->getOptions() as $option) {
            $name = $option->getName();
            if (isset($this->options[$name]) || !($option instanceof EnvVarInputOption)) {
                continue;
            }

            $envVar = $option->getEnvVarName();
            if (isset($_SERVER[$envVar])) {
                $this->options[$name] = $_SERVER[$envVar];
            }
        }
    }
}
