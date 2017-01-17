<?php

namespace Robvh\Kcl\Parameters;

use Robvh\Kcl\Checkpointer\Checkpointer;
use Robvh\Kcl\Parameters\ShutdownReason;

class DefaultShutdownInput implements ShutdownInput
{
    /**
     * @var ShutdownReason
     */
    private $reason;
    /**
     * @var \Robvh\Kcl\Checkpointer\Checkpointer
     */
    private $checkpointer;

    public function __construct(ShutdownReason $reason, Checkpointer $checkpointer)
    {
        $this->reason = $reason;
        $this->checkpointer = $checkpointer;
    }

    /**
     * @return ShutdownReason
     */
    public function getReason(): ShutdownReason
    {
        return $this->reason;
    }

    /**
     * @return \Robvh\Kcl\Checkpointer\Checkpointer
     */
    public function getCheckpointer(): Checkpointer
    {
        return $this->checkpointer;
    }
}
