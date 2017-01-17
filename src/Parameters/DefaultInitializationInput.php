<?php

namespace Robvh\Kcl\Parameters;

class DefaultInitializationInput implements InitializationInput
{
    /**
     * @var string
     */
    private $shardId;

    public function __construct(string $shardId)
    {
        $this->shardId = $shardId;
    }

    /**
     * @return string
     */
    public function getShardId(): string
    {
        return $this->shardId;
    }
}
