<?php
namespace Robvh\Kcl;

use Robvh\Kcl\Io\IoHandler;
use Robvh\Kcl\Processor\RecordProcessor;

/**
 * Class KclProcess
 * Instances of KclProcess communicate with the multi-lang daemon. The Main method of your application must
 * create an instance of KclProcess and call its Run method.
 *
 * @package kcl
 */
abstract class KclProcess
{
    /**
     * Create an instance of KclProcess that uses the given RecordProcessor to process records.
     *
     * @param RecordProcessor $recordProcessor RecordProcessor used to process records.
     *
     * @return KclProcess
     */
    public static function Create(RecordProcessor $recordProcessor) : KclProcess
    {
        return new DefaultKclProcess($recordProcessor, new IoHandler());
    }

    /**
     * Starts the KclProcess. Once this method is called, the KclProcess instance will continuously communicate with
     * the multi-lang daemon, performing actions as appropriate. This method blocks until it detects that the
     * multi-lang daemon has terminated the communication.
     *
     * @return mixed
     */
    public abstract function run();
}


