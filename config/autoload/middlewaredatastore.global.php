<?php

return [ 
    'storeMiddleware' => [
        'StoreMwGetAll' => [
            'class' =>'zaboy\middleware\Middleware\StoreMwGetAll',
            'dataStore' => 'resDbTable'
        ],
    ],    
];