<?php
namespace Robvh\Kcl\Parameters;

use Robvh\Kcl\Checkpointer\Checkpointer;

/**
 * Interface ProcessRecordsInput
 * Contains a batch of records to be processed, along with contextual information.
 *
 * @package kcl
 */
interface ProcessRecordsInput
{
    /**
     * Get the records to be processed.
     *
     * @return array
     */
    public function getRecords() : array;

    /**
     * Gets the checkpointer.
     *
     * @return Checkpointer
     */
    public function getCheckpointer() : Checkpointer;
}
