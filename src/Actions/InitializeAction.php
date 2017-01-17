<?php

namespace Robvh\Kcl\Actions;

class InitializeAction extends Action
{
    /** @var string */
    private $shardId;

    public function __construct(string $shardId)
    {
        $this->type = 'initialize';
        $this->shardId = $shardId;
    }

    /**
     * @return string
     */
    public function getShardId() : string
    {
        return $this->shardId;
    }
}
