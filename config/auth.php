<?php
return [
  'defaults'  => [
    'guard'    => env('AUTH_GUARD', 'api'),
    'provider' => 'users',
  ],
  'guards'    => [
    'api' => [
      'driver'   => 'jwt',
      'provider' => 'users',
    ],
  ],

  'providers' => [
    'users' => [
      'driver' => 'eloquent',
      'model'  => Coolcode\Shared\Entities\User::class,
    ],
  ],
];