<?php

return [

    // MainController
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],
    

    // TaskController
    'tasks{sort:(\?[a-z]+\=[0-9a-z-%]+)?(\&?[a-z]+\=[0-9a-z-%]+)*}' => [
        'controller' => 'task',
        'action' => 'index',
    ],

    'tasks/create' => [
        'controller' => 'task',
        'action' => 'create',
    ],

    'tasks/edit/{id:\d+}' => [
        'controller' => 'task',
        'action' => 'edit',
    ],

    'tasks/update' => [
        'controller' => 'task',
        'action' => 'update',
    ],

    'tasks/delete/{id:\d+}' => [
        'controller' => 'task',
        'action' => 'delete',
    ],


    // AccountController
    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],

    'account/reset' => [
        'controller' => 'account',
        'action' => 'reset',
    ],

    'account/active{active:(\?[a-z]+\=[0-9a-zA-Z-%.$/]+)?}' => [
        'controller' => 'account',
        'action' => 'active',
    ],

    'account/sign-in' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],
    

    // Seeder
    'seed' => [
        'controller' => 'seed',
        'action' => 'index',
    ],
    
    // Migration
    'migration' => [
        'controller' => 'migration',
        'action' => 'index',
    ],

];
