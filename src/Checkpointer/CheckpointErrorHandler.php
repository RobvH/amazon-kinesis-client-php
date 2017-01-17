<?php

namespace Robvh\Kcl\Checkpointer;

/**
 * Class CheckpointErrorHandler
 * Instances of this delegate can be passed to Checkpointer's Checkpoint methods. The delegate will be
 * invoked when a checkpoint operation fails.
 *
 * @package kcl
 */
abstract class CheckpointErrorHandler
{
    /**
     * @var string
     */
    protected $sequenceNumber;
    /**
     * @var string
     */
    protected $errorMessage;
    /**
     * @var Checkpointer
     */
    protected $checkpointer;

    /**
     * CheckpointErrorHandler constructor.
     *
     * @param string       $sequenceNumber The sequence number at which the checkpoint was attempted.
     * @param string       $errorMessage   The error message received from the checkpoint failure.
     * @param Checkpointer $checkpointer   The Checkpointer instance that was used to perform the checkpoint operation.
     */
    public function __construct(string $sequenceNumber, string $errorMessage, Checkpointer $checkpointer)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->errorMessage = $errorMessage;
        $this->checkpointer = $checkpointer;
    }
}
