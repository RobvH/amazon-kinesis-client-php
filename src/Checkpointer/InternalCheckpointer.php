<?php

namespace Robvh\Kcl\Checkpointer;

use Robvh\Kcl\Checkpointer\CheckpointErrorHandler;
use Robvh\Kcl\DefaultKclProcess;

/**
 * Class InternalCheckpointer
 *
 * @todo: finish this
 * @package Robvh\Kcl\Checkpointer
 */
class InternalCheckpointer extends Checkpointer
{
    /**
     * @var DefaultKclProcess
     */
    private $kclProcess;

    public function __construct(DefaultKclProcess $kclProcess)
    {
        $this->kclProcess = $kclProcess;
    }

    public function commitCheckpoint(string $sequenceNumber, CheckpointErrorHandler $errorHandler = null)
    {
        $this->kclProcess->setCheckpointSequencNumber($sequenceNumber);

        $this->kclProcess->getStateMachine()->appy('begin_checkpoint');

        $error = $this->kclProcess->getCheckpointError();
        if ($errorHandler && !empty($error)) {
            $errorHandler->invoke($sequenceNumber, $error, $this);
        }
    }
}

/*
        private class InternalCheckpointer : Checkpointer
        {
            private readonly DefaultKclProcess _p;

            public InternalCheckpointer(DefaultKclProcess p)
            {
                _p = p;
            }

            internal override void Checkpoint(string sequenceNumber, CheckpointErrorHandler errorHandler = null)
            {
                _p.CheckpointSeqNo = sequenceNumber;
                _p._stateMachine.Fire(Trigger.BeginCheckpoint);
                if (_p.CheckpointError != null && errorHandler != null)
                {
                    errorHandler.Invoke(sequenceNumber, _p.CheckpointError, this);
                }
            }
        }
 */
