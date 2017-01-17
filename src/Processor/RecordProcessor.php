<?php
namespace Robvh\Kcl\Processor;

use Robvh\Kcl\Parameters\InitializationInput;
use Robvh\Kcl\Parameters\ProcessRecordsInput;
use Robvh\Kcl\Parameters\ShutdownInput;

/**
 * Interface RecordProcessor
 * Receives and processes Kinesis records. Each RecordProcessor instance processes data from 1 and only 1 shard.
 *
 * @package kcl
 */
interface RecordProcessor
{
    /**
     * Invoked by the Amazon Kinesis Client Library before data records are delivered to the RecordProcessor
     * instance (via processRecords).
     *
     * @param InitializationInput $input The InitializationInput containing information such as the shard id
     *                                   being assigned to this RecordProcessor.
     *
     * @return mixed
     */
    public function initialize(InitializationInput $input);

    /**
     * Process data records. The Amazon Kinesis Client Library will invoke this method to deliver data records to the
     * application.
     *
     * Upon fail over, the new instance will get records with sequence number > checkpoint position
     * for each partition key.
     *
     * @param ProcessRecordsInput $input ProcessRecordsInput that contains a batch of records, a Checkpointer, as
     *                                   well as relevant contextual information.
     *
     * @return mixed
     */
    public function processRecords(ProcessRecordsInput $input);

    /**
     * Invoked by the Amazon Kinesis Client Library to indicate it will no longer send data records to this
     * RecordProcessor instance.
     *
     * The reason parameter indicates:
     *
     * TERMINATE; The shard has been closed and there will not be any more records to process. The
     * record processor should checkpoint (after doing any housekeeping) to acknowledge that it has successfully
     * completed processing all records in this shard.
     *
     * ZOMBIE; A fail over has occurred and a different record processor is (or will be) responsible
     * for processing records.
     *
     * @param ShutdownInput $input ShutdownInput that contains the reason, a Checkpointer, as well as
     *                             contextual information.
     *
     * @return mixed
     */
    public function shutdown(ShutdownInput $input);
}
