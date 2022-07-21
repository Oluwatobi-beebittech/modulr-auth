<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulr\AuthorizationSignatureGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class AuthorizationController extends Controller
{
    private ?string $nonce = null;
    private ?string $timestamp = null;

    public function getModulrRoute(): string {
        $baseRoute = App::isProduction() ? '/api-live' : '/api-sandbox';

        return config('modulr.base_url').$baseRoute;
    }

    public function getHeaders(?string $nonce=null, ?string $timestamp=null): array{
        $apiKey = config('modulr.key');
        $apiSecret = config('modulr.secret');

        $nonce = $nonce ?? Str::uuid();
        $timestamp = $timestamp ?? now()->toRfc7231String();

        $auth = new AuthorizationSignatureGenerator($apiKey, $apiSecret);
        return $auth->calculateHeaders($nonce, $timestamp)->getHTTPHeaders();
    }

    public function setNonce(string $nonce){
        $this->nonce = $nonce;
    }

    public function setTimestamp(string $timestamp){
        $this->timestamp = $timestamp;
    }
}
