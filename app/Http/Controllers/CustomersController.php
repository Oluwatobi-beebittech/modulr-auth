<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthorizationController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CustomersController extends AuthorizationController
{
    public function index(): JsonResponse{
        $response = Http::withHeaders($this->getHeaders())
                            ->get($this->getModulrRoute() . "/customers");

        return response()->json($response->json(), $response->status());
    }
}
