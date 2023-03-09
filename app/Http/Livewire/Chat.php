<?php

namespace App\Http\Livewire;

use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Chat extends Component
{

    use LivewireAlert;

    public $lazy = false;

    public $chat;

    public $instance;

    public $state = [
        'loading' => true,
        'chat' => null,
        'messages' => [],
        'body' => ''
    ];

    protected function getListeners()
    {
        return [
            'fetchChat',
            'fetchMessages',
            'messageReceived'
        ];
    }

    public function render()
    {
        return view('livewire.chat');
    }

    public function init() {
        $this->lazy = true;
        $this->emit('fetchChat');
    }

    public function fetchChat() {
        try {
            $response = Http::withHeaders([
                'api_key' => config('services.whatsapi.secret'),
                'x-instance-id' => $this->instance->instance_id,
                'x-instance-secret' => $this->instance->instance_secret,
            ])->get(config('services.whatsapi.host') . "/chat/" . $this->chat);

            if($response->failed()) {
                if(isset($response['message'])) {
                    $this->alert('error', $response['message']);
                } else {
                    $this->alert('error', 'Failed to fetch chat for instance ' . $this->instance->name);
                }
                return true;
            } else if($response->successful()) {
                $this->state['chat'] = $response->json();
                $this->state['loading'] = false;
                $this->emit('fetchMessages');
            }

        } catch(Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    public function fetchMessages() {
        try {
            $response = Http::withHeaders([
                'api_key' => config('services.whatsapi.secret'),
                'x-instance-id' => $this->instance->instance_id,
                'x-instance-secret' => $this->instance->instance_secret,
            ])->get(config('services.whatsapi.host') . "/chat/" . $this->chat . '/messages');

            if($response->failed()) {
                if(isset($response['message'])) {
                    $this->alert('error', $response['message']);
                } else {
                    $this->alert('error', 'Failed to fetch chat for instance ' . $this->instance->name);
                }
                return true;
            } else if($response->successful()) {
                $this->state['messages'] = $response['message'];
                $this->dispatchBrowserEvent('scrollDown');
            }

        } catch(Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }

    }
    public function messageReceived($id) {
        if($this->state['chat']['id']['_serialized'] == $id) {
            $this->fetchMessages();
        }
    }

    public function sendMessage()
    {
        if($this->state['body'] != '') {
            try {
                $message = $this->state['body'];
                $this->state['body'] = '';
                $response = Http::withHeaders([
                    'api_key' => config('services.whatsapi.secret'),
                    'x-instance-id' => $this->instance->instance_id,
                    'x-instance-secret' => $this->instance->instance_secret,
                ])->post(config('services.whatsapi.host') . "/chat/send-message/" . $this->chat, [
                    'message' => $message
                ]);
    
                if($response->failed()) {
                    if(isset($response['message'])) {
                        $this->alert('error', $response['message']);
                    } else {
                        $this->alert('error', 'Failed to send message');
                    }
                    return true;
                } else if($response->successful()) {
                    $this->emit('fetchMessages');
                }
    
            } catch(Exception $exception) {
                $this->alert('error', $exception->getMessage());
            }
        }
    }
}
