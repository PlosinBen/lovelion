<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\DeployNotification;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class TravisCiController extends Controller
{
    public function hook(Request $request, Client $client)
    {
        $signature = $request->header('signature');

        try {
            $response = $client
                ->get('https://api.travis-ci.com/config')
                ->getBody()
                ->getContents();
        } catch (GuzzleException $e) {
            Log::error("TravisCi api fetch error");
            return false;
        }

        $travisPublicKey = json_decode($response)
            ->config
            ->notifications
            ->webhook
            ->public_key;

        $payload = $request->get("payload");

        if (openssl_verify($payload, base64_decode($signature), $travisPublicKey) !== 1) {
            Log::error('Travis CI webhooks verify error');
            return false;
        }

        $payload = json_decode($payload);

        $branch = env('GIT_DEPLOY_BRANCH');
        if ($payload->state === 'passed' && $payload->branch === $branch && env('APP_ENV') === 'production') {
            $path = env('GIT_DEPLOY_PATH');
            passthru("git reset --hard; git -C {$path} pull origin {$branch} 2>&1");
            passthru("composer install");
            passthru("composer dump-autoload -o");

            Notification::route('telegram', 581968280)
                ->notify(new DeployNotification($payload));
        }
    }
}
