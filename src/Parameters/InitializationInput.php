<?php
namespace Robvh\Kcl\Parameters;

/**
 * Interface InitializationInput
 * Contextual information that can used to perform specialized initialization for this RecordProcessor.
 *
 * @package kcl
 */
interface InitializationInput
{
    /**
     * Gets the shard identifier.
     *
     * @return string The shard identifier. Each RecordProcessor processes records from one and only one shard.</value>
     */
    public function getShardId() : string;
}
