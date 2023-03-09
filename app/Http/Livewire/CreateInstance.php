<?php

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateInstance extends Component
{

    use LivewireAlert;

    public $state = [
        'name' => ''
    ];

    public function render()
    {
        return view('livewire.create-instance');
    }

    public function create() {
        try {
            $response = Http::withHeaders([
                'api_key' => config('services.whatsapi.secret')
            ])->post(config('services.whatsapi.host') . "/auth/register", [
                "instance_id" => Str::slug($this->state['name'])
            ]);
    
            if($response->failed()) {
                if(isset($response['message'])) {
                    $this->alert('error', $response['message']);
                } else {
                    $this->alert('error', 'Failed to create new instance');
                }
                return true;
            } else if($response->successful()) {
                Auth::user()->instances()->create([
                    'name' => $this->state['name'],
                    'instance_id' => $response['instance_id'],
                    'instance_secret' => $response['secret']
                ]);
                return redirect(request()->header('Referer'));
            }
        } catch(Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }
}
