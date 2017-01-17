<?php
namespace Robvh\Kcl\Parameters;

use Robvh\Kcl\Checkpointer\Checkpointer;
use Robvh\Kcl\Parameters\ShutdownReason;

/**
 * Interface ShutdownInput
 * Contextual information that can used to perform specialized shutdown procedures for this RecordProcessor.
 *
 * @package kcl
 */
interface ShutdownInput
{
    /**
     * Gets the shutdown reason.
     *
     * @return ShutdownReason
     */
    public function getReason() : ShutdownReason;

    /**
     * Gets the checkpointer.
     *
     * @return Checkpointer
     */
    public function getCheckpointer() : Checkpointer;
}
