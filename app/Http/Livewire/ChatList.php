<?php

namespace App\Http\Livewire;

use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatList extends Component
{

    use LivewireAlert;

    public $instance;

    public $lazy = false;

    protected function getListeners() {
        return [
            'fetchChats',
            'messageReceived' => 'fetchChats'
        ];
    }

    public $state = [
        'chats' => [],
        'loading' => true
    ];

    public function render()
    {
        return view('livewire.chat-list');
    }

    public function init() {
        $this->lazy = true;
        $this->emit('fetchChats');
    }

    public function fetchChats()
    {
        try {
            $response = Http::withHeaders([
                'api_key' => config('services.whatsapi.secret'),
                'x-instance-id' => $this->instance->instance_id,
                'x-instance-secret' => $this->instance->instance_secret,
            ])->get(config('services.whatsapi.host') . "/chat/all");

            if($response->failed()) {
                if(isset($response['message'])) {
                    $this->alert('error', $response['message']);
                } else {
                    $this->alert('error', 'Failed to fetch chats for instance ' . $this->instance->name);
                }
                return true;
            } else if($response->successful()) {
                $this->state['chats'] = $response->json();
                $this->state['loading'] = false;
            }

        } catch(Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    public function openChat($id)
    {
        $this->emitUp('openChat', $id);
    }
}
