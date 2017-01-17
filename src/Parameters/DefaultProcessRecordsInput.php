<?php

namespace Robvh\Kcl\Parameters;

use Robvh\Kcl\Checkpointer\Checkpointer;
use Robvh\Kcl\Record\Record;

class DefaultProcessRecordsInput implements ProcessRecordsInput
{
    /** @var Record[] */
    private $records;
    /** @var Checkpointer */
    private $checkpointer;

    /**
     * @param Record[]                             $records
     * @param \Robvh\Kcl\Checkpointer\Checkpointer $checkpointer
     */
    public function __construct(array $records, Checkpointer $checkpointer) {
        $this->records = (function (Record ...$records) {
            return $records;
        })(...$records);

        $this->checkpointer = $checkpointer;
    }

    /**
     * @return \Robvh\Kcl\Record\Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @return Checkpointer
     */
    public function getCheckpointer(): Checkpointer
    {
        return $this->checkpointer;
    }
}
