<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SchedulerController extends Controller
{
    public function __invoke()
    {
        Artisan::call('schedule:run');

        var_dump(response());
    }
}
