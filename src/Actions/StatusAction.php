<?php

namespace Robvh\Kcl\Actions;

class StatusAction extends Action
{
    /** @var string */
    private $responseFor;

    public function __construct(string $type)
    {
        if ($type === '') {
            throw new \InvalidArgumentException('Cannot initialize status action without type.');
        }

        $this->type = 'status';
        $this->responseFor = $type;
    }

    public static function fromClass(string $className): StatusAction
    {
        if (empty(self::$types[$className])) {
            throw new \InvalidArgumentException('StatusAction init with unknown type: '.$className);
        }

        return new static(self::$types[$className]);
    }
}
