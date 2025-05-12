<?php

return [
    /*
    |--------------------------------------------------------------------------
    | GraphQL Schema File
    |--------------------------------------------------------------------------
    |
    | Define the path to the GraphQL schema file.
    |
    */
    'schema' => base_path('graphql/schema.graphql'),

    /*
    |--------------------------------------------------------------------------
    | GraphQL Route
    |--------------------------------------------------------------------------
    |
    | Here you can define the route for your GraphQL endpoint.
    |
    */
    'route' => [
        'uri' => 'graphql',
        'name' => 'graphql',
        'middleware' => ['api'],
    ],

    /*
    |--------------------------------------------------------------------------
    | GraphQL Playground
    |--------------------------------------------------------------------------
    |
    | Enabling or disabling the GraphQL playground (interactive IDE) in development.
    |
    */
    'playground' => env('GRAPHQL_PLAYGROUND', true),



    'scalars' => [
    'Date' => \App\GraphQL\Scalars\Date::class,
    'Time' => \App\GraphQL\Scalars\Time::class,
],
];
