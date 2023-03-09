<?php

namespace App\Http\Livewire;

use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Instance extends Component
{

    use LivewireAlert;

    public $instance;

    public $state = [
        'connected' => false,
        'info' => null,
        'waiting_qr' => false,
        'progress' => 0,
        'waiting_load' => false,
        'chat' => null
    ];

    public function getListeners()
    {
        return [
            "echo:private-instance.{$this->instance->id},.whatsapi.qr" => 'qrCodeReceived',
            "echo:private-instance.{$this->instance->id},.whatsapi.ready" => 'ready',
            "echo:private-instance.{$this->instance->id},.whatsapi.message_received" => 'messageReceived',
            "echo:private-instance.{$this->instance->id},.whatsapi.disconnected" => 'disconnected',
            "echo:private-instance.{$this->instance->id},.whatsapi.loading" => 'loading',
            'openChat',
            'openChatById'
        ];
    }

    public function render()
    {
        return view('livewire.instance');
    }

    /**
     * Send /auth/status request to check if instance is running and verify if it is connected or waiting QR Code
     */
    public function connect()
    {
        try {
            $response = Http::withHeaders([
                'api_key' => config('services.whatsapi.secret'),
                'x-instance-id' => $this->instance->instance_id
            ])->get(config('services.whatsapi.host') . "/auth/status");

            if($response->failed()) {
                dd($response);
                if(isset($response['message'])) {
                    $this->alert('error', $response['message']);
                } else {
                    $this->alert('error', 'Failed to connect to instance ' . $this->instance->name);
                }
                return true;
            } else if($response->successful()) {
                $this->state['info'] = $response->json();
                // If instance is not connected set state to Waiting QR Code Scan
                if(!$this->state['info']['connected']) {
                    $this->state['waiting_qr'] = true;
                }
                $this->state['connected'] = true;
            }

        } catch(Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    // Update the QR Code
    public function qrCodeReceived() {
        $this->instance = $this->instance->fresh();
    }

    // Display chat interface when ready event received
    public function ready() {
        $this->state['connected'] = true;
        $this->state['waiting_qr'] = false;
        $this->state['waiting_load'] = false;
    }

    // Display loading screen
    public function loading($data) {
        $this->state['waiting_qr'] = false;
        $this->state['waiting_load'] = true;
        $this->state['progress'] = $data['progress'];
    }
    
    public function disconnected()
    {
        $this->connect();
    }

    public function openChat($id) {
        $this->state['chat'] = null;
        $this->emit('openChatById', $id);
    }

    public function openChatById($id) {
        $this->state['chat'] = $id;
    }

    public function messageReceived($data)
    {
        $this->emit('messageReceived', $data['chatId']);
    }
}
