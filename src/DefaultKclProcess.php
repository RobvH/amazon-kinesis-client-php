<?php

namespace Robvh\Kcl;

use Robvh\Kcl\Actions\Action;
use Robvh\Kcl\Actions\CheckpointAction;
use Robvh\Kcl\Actions\InitializeAction;
use Robvh\Kcl\Actions\MalformedActionException;
use Robvh\Kcl\Actions\ProcessRecordsAction;
use Robvh\Kcl\Actions\ShutdownAction;
use Robvh\Kcl\Actions\StatusAction;
use Robvh\Kcl\Checkpointer\InternalCheckpointer;
use Robvh\Kcl\Io\IoHandler;
use Robvh\Kcl\Parameters\DefaultInitializationInput;
use Robvh\Kcl\Parameters\DefaultProcessRecordsInput;
use Robvh\Kcl\Parameters\DefaultShutdownInput;
use Robvh\Kcl\Parameters\ShutdownReason;
use Robvh\Kcl\Processor\RecordProcessor;
use Robvh\Kcl\Record\Record;
use SM\StateMachine\StateMachine;
use SM\StateMachine\StateMachineInterface;

class DefaultKclProcess extends KclProcess
{
    /** @var StateMachineInterface */
    private $stateMachine;
    /**
     * @var RecordProcessor
     */
    private $processor;
    /**
     * @var IoHandler
     */
    private $ioHandler;
    /**
     * @var InternalCheckpointer
     */
    private $checkpointer;
    /**
     * @var string
     */
    private $shardId;
    /**
     * @var Record[]|array
     */
    private $records;
    /**
     * @var ShutdownReason
     */
    private $shutdownReason;
    /**
     * @var string checkpointError
     */
    private $checkpointError;
    /**
     * @var string checkpointSequenceNumber
     */
    private $checkpointSequenceNumber;

    /**
     * @return StateMachineInterface
     */
    public function getStateMachine(): StateMachineInterface
    {
        return $this->stateMachine;
    }

    public function __construct(RecordProcessor $processor, IoHandler $ioHandler)
    {
        $this->processor = $processor;
        $this->ioHandler = $ioHandler;
        $this->checkpointer = new InternalCheckpointer($this);
        $this->initializeStateMachine();
    }

    private function initializeStateMachine()
    {
        $config = require 'StateMachineConfig.php';

        $this->stateMachine = new StateMachine($this, $config);
    }

    public function run()
    {
        while ($this->processNextLine()) {

        }
    }

    private function processNextLine()
    {
        /** @var Action $action */
        $action = $this->ioHandler->readAction();

        if (is_null($action)) {
            return false;
        }

        $this->dispatchAction($action);
        return true;
    }

    private function dispatchAction(Action $action)
    {
        /*
         * @todo: the lib/worker/ShutdownMessage enum shows a 'REQUESTED' type
         * @todo: the lib/worker/ShutdownMessage enum docs for 'ZOMBIE' say it should not
         *        be allowed to checkpoint. Do we honor this?
         */
        switch (get_class($action)) {
            case InitializeAction::class:
                /** @var InitializeAction $action */
                $this->shardId = $action->getShardId();
                $this->stateMachine->apply('BeginInitialize');

                return;

            case ProcessRecordsAction::class:
                /** @var ProcessRecordsAction $action */
                $this->records = $action->getRecords();
                $this->stateMachine->apply('BeginProcessRecords');

                return;

            case ShutdownAction::class:
                /** @var ShutdownAction $action */
                $this->shutdownReason = ShutdownReason::forReason($action->getReason());
                $this->stateMachine->apply('BeginShutdown');

                return;

            case CheckpointAction::class:
                /** @var CheckpointAction $action */
                $this->checkpointError = $action->getError();
                $this->checkpointSequenceNumber = $action->getSequenceNumber();
                $this->stateMachine->apply('FinishCheckpoint');

                return;

            default:
                throw new MalformedActionException(
                    'Received an action which couldn\'t be understood: '.get_class($action)
                );
        }
    }

    public function beginInitialize()
    {
        $this->processor->initialize(new DefaultInitializationInput($this->shardId));
        $this->stateMachine->apply('FinishInitialize');
    }

    public function finishInitialize()
    {
        // @todo: check this
        $this->ioHandler->writeAction(StatusAction::fromClass(InitializeAction::class));
    }

    public function beginShutdown()
    {
        $this->processor->shutdown(new DefaultShutdownInput($this->shutdownReason, $this->checkpointer));
        $this->stateMachine->apply('FinishShutdown');
    }

    public function finishShutdown()
    {
        $this->ioHandler->writeAction(StatusAction::fromClass(ShutdownAction::class));
    }

    public function beginProcessRecords()
    {
        $this->processor->processRecords(
            new DefaultProcessRecordsInput($this->records, $this->checkpointer)
        );
        $this->stateMachine->apply('FinishProcessRecords');
    }

    public function finishProcessRecords()
    {
        $this->ioHandler->writeAction(StatusAction::fromClass(ProcessRecordsAction::class));
    }

    public function beginCheckpoint()
    {
        $this->ioHandler->writeAction(new CheckpointAction($this->checkpointSequenceNumber));
        $this->processNextLine();
    }

    public function finishCheckpoint()
    {
        // reserved
    }
}
