<?php
namespace Robvh\Kcl\Checkpointer;

use Robvh\Kcl\TimeSpan;

/**
 * Class RetryingCheckpointErrorHandler
 *
 * Create a simple CheckpointErrorHandler that retries the checkpoint operation a number of times,
 * with a fixed delay in between each attempt.
 *
 * @todo: finish this
 * @package kcl
 */
class RetryingCheckpointErrorHandler
{
    /**
     * @param int      $retries Number of retries to perform before giving up.
     * @param TimeSpan $delay   Delay between each retry.
     *
     * @return mixed
     */
    public static function Create(int $retries, TimeSpan $delay)
    {
        $seq = ''; $err = ''; $checkpointer = '';

        return new class($seq, $err, $checkpointer) extends CheckpointErrorHandler {
            private $retries;
            private $delay;

            public function __construct($seq, $err, $checkpointer, $retries, $delay)
            {
                parent::__construct($seq, $err, $checkpointer);

                $this->retries = $retries;
                $this->delay = $delay;

                if ($retries > 0)
                {
                    sleep($delay);
                    $checkpointer->checkpoint($seq, RetryingCheckpointErrorHandler::Create($retries - 1, $delay));
                }
            }
        };
    }
}
