<?php

namespace Spatie\LaravelIgnition\Recorders\DumpRecorder;

class MultiDumpHandler
{
    protected array $handlers = [];

    public function dump($value): void
    {
        foreach ($this->handlers as $handler) {
            $handler($value);
        }
    }

    public function addHandler(callable $callable = null): self
    {
        $this->handlers[] = $callable;

        return $this;
    }
}
