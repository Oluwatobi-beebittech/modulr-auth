<?php

use Illuminate\Support\Facades\Facade;

return [

    'key' => env('MODULR_API_KEY'),

    'secret' => env('MODULR_API_SECRET'),

    'base_url' => env('MODULR_BASE_URL', 'https://api-sandbox.modulrfinance.com'),

];
