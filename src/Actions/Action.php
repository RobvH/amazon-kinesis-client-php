<?php
namespace Robvh\Kcl\Actions;

use Robvh\Kcl\Actions\MalformedActionException;

class Action
{
    protected static $types = [
        'initialize'     => InitializeAction::class,
        'processRecords' => ProcessRecordsAction::class,
        'shutdown'       => ShutdownAction::class,
        'checkpoint'     => CheckpointAction::class,
        'status'         => StatusAction::class,
    ];
    /** @var string */
    protected $type;

    /**
     * @param string $json
     *
     * @throws MalformedActionException
     *
     * @return Action
     */
    public static function parse(string $json): Action
    {
        try {
            $data = json_decode($json, true);

            $type = self::$types[$data['action']];

            return unserialize('0:'.strlen($type).':"'.$type.'"'.substr(serialize($data), 1));
        } catch (\Throwable $e) {
            throw new MalformedActionException('Received an action which couldn\'t be understood: '.$json, 0, $e);
        }
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
