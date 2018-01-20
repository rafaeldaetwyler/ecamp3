<?php

return [
    'router' => [
        'routes' => [

            'ecamp.api'  => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                        'controller' => \eCamp\Api\Controller\IndexController::class,
                        'action' => 'index'
                    ],
                ],
            ],

            'ecamp.api.login'  => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/login[/:action]',
                    'defaults' => [
                        'controller' => \eCamp\Api\Controller\LoginController::class,
                        'action' => 'index'
                    ],
                ],
            ],

            'ecamp.api.logout'  => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/logout',
                    'defaults' => [
                        'controller' => \eCamp\Api\Controller\LoginController::class,
                        'action' => 'logout'
                    ],
                ],
            ],

            'ecamp.api.docu' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/docu',
                    'defaults' => [
                        'controller' => \eCamp\Api\Controller\SwaggerController::class,
                        'action' => 'index'
                    ],
                ],
            ],

        ],
    ],

    'controllers' => [
        'factories' => [
            eCamp\Api\Controller\IndexController::class => eCamp\Api\Controller\IndexControllerFactory::class,
            eCamp\Api\Controller\LoginController::class => eCamp\Api\Controller\LoginControllerFactory::class,
            eCamp\Api\Controller\SwaggerController::class => eCamp\Api\Controller\SwaggerControllerFactory::class,
        ]
    ],

];
