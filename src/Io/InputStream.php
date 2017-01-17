<?php

namespace Robvh\Kcl\Io;

class InputStream extends ResourceProxy implements Readable
{
    public function readLine(): string
    {
        return trim(fgets($this->getHandle()));
    }
}
