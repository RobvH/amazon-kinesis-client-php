<?php

namespace Robvh\Kcl\Io;

class OutputStream extends ResourceProxy implements Writable
{
    public function writeLine(string $line)
    {
        fwrite($this->getHandle(), $line.PHP_EOL);
    }
}
