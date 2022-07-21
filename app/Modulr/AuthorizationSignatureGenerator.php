<?php

namespace App\Modulr;

use App\Modulr\AuthorizationResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuthorizationSignatureGenerator
{
    private string $apiKey;
    private string $apiSecret; 

    public function __construct(string $apiKey, string $apiSecret){
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    private function getAPIKey(): string {
		return $this->apiKey;
	}

	private function getAPISecret(): string {
		return $this->apiSecret;
	}

    private function getSignature(string $nonce, string $timestamp): string {
        return "date: $timestamp\nx-mod-nonce: $nonce";
	}

    public function calculateHeaders(string $nonce, string $timestamp): AuthorizationResult{
        $apiKey = $this->getAPIKey();
        $apiSecret = $this->getAPISecret();

        $signature = $this->getSignature($nonce, $timestamp);
        $hashedSignature = hash_hmac('sha1', $signature, utf8_encode($apiSecret));
        $encodedSignature = urlencode(base64_encode(hex2bin($hashedSignature)));

        return new AuthorizationResult($apiKey, $timestamp, $nonce, $encodedSignature);
    }

}
