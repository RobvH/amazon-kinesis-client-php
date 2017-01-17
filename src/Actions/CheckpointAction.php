<?php

namespace Robvh\Kcl\Actions;

class CheckpointAction extends Action
{
    /**
     * @var string
     */
    private $sequenceNumber;
    /**
     * @var string
     */
    private $error;

    public function __construct(string $sequenceNumber, string $error = null)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}
