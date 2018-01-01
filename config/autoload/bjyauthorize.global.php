<?php

return [
    'bjyauthorize' => [

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

        /* this module uses a meta-role that inherits from any roles that should
         * be applied to the active user. the identity provider tells us which
         * roles the "identity role" should inherit from.
         * for ZfcUser, this will be your default identity provider
        */
        'identity_provider' => \BjyAuthorize\Provider\Identity\ZfcUserZendDb::class,

        /* If you only have a default role and an authenticated role, you can
         * use the 'AuthenticationIdentityProvider' to allow/restrict access
         * with the guards based on the state 'logged in' and 'not logged in'.
         *
         * 'default_role'       => 'guest',         // not authenticated
         * 'authenticated_role' => 'user',          // authenticated
         * 'identity_provider'  => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,
         */
//'identity_provider'  => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,
        /* role providers simply provide a list of roles that should be inserted
         * into the Zend\Acl instance. the module comes with two providers, one
         * to specify roles in a config file and one to load roles using a
         * Zend\Db adapter.
         */
        'role_providers' => [

            /* here, 'guest' and 'user are defined as top-level roles, with
             * 'admin' inheriting from user
             */
//            \BjyAuthorize\Provider\Role\Config::class => [
//                'guest' => [],
//                'admin'  => [],
//            ],

            // this will load roles from the user_role table in a database
            // format: user_role(role_id(varchar], parent(varchar))
            \BjyAuthorize\Provider\Role\ZendDb::class => [
                'table'                 => 'user_role',
                'identifier_field_name' => 'id',
                'role_id_field'         => 'role_id',
                'parent_role_field'     => 'parent_id',
            ],
        ],
    ],
];

