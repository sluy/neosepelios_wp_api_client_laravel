<?php

namespace App\Http\Controllers;

use App\Events\Disconnected;
use App\Events\Loading;
use App\Events\MessageReceived;
use App\Events\QRCodeReceived;
use App\Events\Ready;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['type']));

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            return $response;
        }

        return $this->missingMethod($payload);
    }

    protected function missingMethod($parameters = [])
    {
        return new Response();
    }

    protected function handleQr($payload) {
        $instance = Instance::where('instance_id', $payload['instance_id'])->first();
        if($instance)  {
            $instance->last_qrcode = $payload['data']['qr'];
            $instance->save();
            broadcast(new QRCodeReceived($instance));
        }
    }

    protected function handleReady($payload) {
        $instance = Instance::where('instance_id', $payload['instance_id'])->first();
        if($instance)  {
            broadcast(new Ready($instance));
        }
    }

    protected function handleMessage($payload) {
        $instance = Instance::where('instance_id', $payload['instance_id'])->first();
        if($instance)  {
            broadcast(new MessageReceived($instance, $payload['data']['message']['from']));
        }
    }

    protected function handleDisconnected($payload) {
        $instance = Instance::where('instance_id', $payload['instance_id'])->first();
        if($instance)  {
            broadcast(new Disconnected($instance));
        }
    }

    protected function handleLoadingScreen($payload) {
        $instance = Instance::where('instance_id', $payload['instance_id'])->first();
        if($instance)  {
            broadcast(new Loading($instance, $payload['data']['percent']));
        }
    }
}
