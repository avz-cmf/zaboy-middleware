<?php

return [ 
    'dataStore' => [
        'middlewareDbTable' => [
            'class' =>'zaboy\res\DataStore\DbTable',
            'tableName' => 'res_test'
            ],
    ],    
    'services' => [
        'factories' => [
            'db' => 'zaboy\res\Db\Adapter\AdapterFactory'            
        ],
    ]
];