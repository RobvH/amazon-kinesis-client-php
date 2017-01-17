<?php

namespace Robvh\Kcl\Io;

abstract class ResourceProxy
{
    /**
     * @var resource
     */
    private $handle;

    public function __construct(resource $handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return resource
     */
    public function getHandle(): resource
    {
        return $this->handle;
    }
}
