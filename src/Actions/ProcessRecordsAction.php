<?php

namespace Robvh\Kcl\Actions;

class ProcessRecordsAction extends Action
{
    /** @var array */
    private $records;

    public function __construct(array $records)
    {
        $this->type = 'processRecords';
        $this->records = $records;
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        // todo: should we return an deep copy?
        //return array_map(function ($record) { return clone $record; }, $this->records);
        return $this->records;
    }
}
