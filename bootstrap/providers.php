<?php

use App\Providers\ViewServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    App\Providers\ViewServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
