<?php
namespace Robvh\Kcl\Parameters;

/**
 * Class ShutdownReason
 * Reason the RecordProcessor is being shutdown.
 *
 * Used to distinguish between a fail-over vs. a termination (shard is closed and all records have been delivered).
 * In case of a fail over, applications should NOT checkpoint as part of shutdown,
 * since another record processor may have already started processing records for that shard.
 * In case of termination (resharding use case), applications SHOULD checkpoint their progress to indicate
 * that they have successfully processed all the records (processing of child shards can then begin).
 *
 * @package kcl
 */
final class ShutdownReason
{
    const ZOMBIE = 'ZOMBIE';
    const TERMINATE = 'TERMINATE';
    /**
     * @var string
     */
    private $reason;

    private function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public static function forReason(string $reason): ShutdownReason
    {
        return new self($reason);
    }

    function __invoke()
    {
        return $this->reason;
    }
}

