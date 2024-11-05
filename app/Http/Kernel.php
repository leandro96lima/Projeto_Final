<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // outros middlewares
        'check_user_type' => \App\Http\Middleware\CheckUserType::class,
    ];


}
