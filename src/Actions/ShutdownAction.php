<?php
namespace Robvh\Kcl\Actions;

class ShutdownAction extends Action
{
    /** @var string */
    private $reason;

    public function __construct(string $reason)
    {
        $this->type = 'shutdown';
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }
}
