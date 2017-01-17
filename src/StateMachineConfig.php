<?php

return [
    'graph' => 'graph',
    'property_path' => 'state',
    'states' => [
        'Start',
        'Initializing',
        'Ready',
        'Processing',
        'Checkpointing',
        'ShuttingDown',
        'FinalCheckpointing',
        'End',
    ],
    'transitions' => [
        'BeginInitialize' => [
            'from' => ['Start'],
            'to'   => 'Initializing',
        ],
        'FinishInitialize' => [
            'from' => ['Initializing'],
            'to'   => 'Ready',
        ],
        'BeginProcessRecords' => [
            'from' => ['Ready'],
            'to'   => 'Processing',
        ],
        'BeginCheckout' => [
            ['from' => ['Processing'], 'to' => 'Checkpointing'],
            ['from' => ['ShuttingDown'], 'to' => 'FinalCheckpointing'],
        ],
        'FinishCheckpoint' => [
            ['from' => ['Checkpointing'], 'to' => 'Processing'],
            ['from' => ['FinalCheckpointing'], 'to' => 'ShuttingDown'],
        ],
        'FinishProcessRecords' => [
            'from' => ['Processing'], 'to' => 'Ready',
        ],
        'BeginShutdown' => [
            'from' => ['Ready'], 'to' => 'ShuttingDown',
        ],
        'FinishShutdown' => [
            'from' => ['ShuttingDown'], 'to' => 'End',
        ],
    ],
    'callbacks' => [
        'after' => [
            'to-ready-finish-processing' => [
                'on' => ['FinishProcessRecords'],
                'to' => ['ready'],
                'do' => ['object', 'finishProcessRecords'],
            ],
            'to-ready-finish-initializing' => [
                'on' => ['FinishInitialize'],
                'to' => ['ready'],
                'do' => ['object', 'finishInitialize'],
            ],
            'to-Checkpointing' => [
                'on' => ['BeginCheckpoint'],
                'do' => ['object', 'beginCheckpoint'],
            ],
            'to-shutting-down-on-begin-shutdown' => [
                'to' => ['ShuttingDown'],
                'on' => ['BeginShutdown'],
                'do' => ['object', 'beginShutdown'],
            ],
            'to-shutting-down-on-finish-checkpoint' => [
                'to' => ['ShuttingDown'],
                'on' => ['FinishCheckpoint'],
                'do' => ['object', 'finishCheckpoint'],
            ],
            'to-end' => [
                'to' => ['End'],
                'do' => ['object', 'finishShutdown'],
            ],
            'to-processing-on-begin-process-records' => [
                'to' => ['Processing'],
                'on' => ['BeginProcessRecords'],
                'do' => ['object', 'beginProcessRecords'],
            ],
            'to-processing-on-finish-checkpoint' => [
                'to' => ['Processing'],
                'on' => ['FinishCheckpoint'],
                'do' => ['object', 'finishCheckpoint'],
            ],
        ]
    ]
];
