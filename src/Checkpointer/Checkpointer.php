<?php
namespace Robvh\Kcl\Checkpointer;

use Robvh\Kcl\Checkpointer\CheckpointErrorHandler;
use Robvh\Kcl\Record\Record;

/**
 * Class Checkpointer
 *
 * Used by RecordProcessors when they want to checkpoint their progress.
 * The Amazon Kinesis Client Library will pass an object implementing this interface to RecordProcessors,
 * so they can checkpoint their progress.
 *
 * @package kcl
 */
abstract class Checkpointer
{
    abstract protected function commitCheckpoint(string $sequenceNumber, CheckpointErrorHandler $errorHandler = null);

    /**
     * This method will checkpoint the progress at the optional sequence number of the specified record, or, if
     * none is specified, at the last data record that was delivered to the record processor.
     *
     * Upon failover (after a successful checkpoint() call), the new/replacement RecordProcessor instance
     * will receive data records whose sequenceNumber > checkpoint position (for each partition key).
     *
     * In steady state, applications should checkpoint periodically (e.g. once every 5 minutes).
     *
     * Calling this API too frequently can slow down the application (because it puts pressure on the underlying
     * checkpoint storage layer).
     *
     * You may optionally pass a CheckpointErrorHandler to the method, which will be invoked when the
     * checkpoint operation fails.
     *
     * @param Record                      $record       Record whose sequence number to checkpoint at.
     * @param CheckpointErrorHandler|null $errorHandler CheckpointErrorHandler that is invoked when the checkpoint
     *                                                  operation fails.
     */
    public function checkpoint(Record $record = null, CheckpointErrorHandler $errorHandler = null)
    {
        if (is_null($record)) {
            return $this->commitCheckpoint('', $errorHandler);
        }

        return $this->commitCheckpoint($record->getSequenceNumber(), $errorHandler);
    }
}
