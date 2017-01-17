<?php
namespace Robvh\Kcl\Record;

/**
 * Class Record
 * A Kinesis record.
 *
 * @package kcl
 */
abstract class Record
{
    /**
     * Gets the binary data from this Kinesis record, already decoded from Base64.
     *
     * @return mixed The data in the Kinesis record.
     */
    public abstract function getData();

    /**
     * Gets the sequence number of this Kinesis record.
     *
     * @return string The sequence number.
     */
    public abstract function getSequenceNumber() : string;

    /**
     * Gets the partition key of this Kinesis record.
     *
     * @return string The partition key.
     */
    public abstract function getPartitionKey() : string;
}
