<?php

return [
    'modules' => [
        'ZfcBase',
        'ZfcUser',
        'ZfcAdmin',
        'BjyAuthorize',
        'DluTwBootstrap',
        'Property',
        'Result',
        'Eportal',
        'EportalAdmin',
        'EportalProperty',
        'EportalSetting',
        'EportalUser',
        'EportalResult',
        'EportalRole',
        'EportalSchool',
        'EportalClass',
        'EportalDepartment',
        'EportalSubject',
        'EportalSession',
        'EportalTerm'
    ],
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        'module_paths' => ['./module', './vendor', './module', './module', './module', './module', './module', './module'],
        'config_glob_paths' => ['config/autoload/{,*.}{global,local}.php'],
    ],
];
