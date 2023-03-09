<div x-data="{connected: @entangle('state.connected'), waiting_qr: @entangle('state.waiting_qr'), waiting_load: @entangle('state.waiting_load'), progress: @entangle('state.progress')}" class="w-full h-full" wire:init="connect">
    <template x-if="!connected">
        <div class="h-full w-full flex justify-center items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            <div class="font-semibold">
                Connecting
            </div>
        </div>
    </template>
    <template x-if="connected">
        <div class="w-full h-full">
            <template x-if="waiting_qr">
                <div class="w-full h-full flex items-center justify-center">
                    @if($instance->last_qrcode)
                        <div class="flex items-center justify-center flex-col gap-4">
                            {!! QrCode::size(300)->generate($instance->last_qrcode) !!}
                            <span class="font-semibold">
                                Scan the QR Code with your device.
                            </span>
                        </div>
                    @else
                    <div style="width: 300px; height: 300px;" class="flex items-center justify-center border flex-col gap-4">
                        <svg class="animate-spin h-16 w-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-semibold">
                            Waiting for QR Code
                        </span>
                    </div>
                    @endif
                </div>
            </template>
            <template x-if="waiting_load">
                <div class="w-full h-full flex items-center justify-center">
                    <div style="width: 300px; height: 300px;" class="flex items-center justify-center border flex-col gap-4">
                        <svg class="animate-spin h-16 w-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-semibold">
                            <span x-text="progress"></span>% Loading
                        </span>
                    </div>
                </div>
            </template>
            @if(!$state['waiting_qr'] && !$state['waiting_load'] && $state['connected'])
                <div class="w-full h-full grid grid-cols-12">
                    <div class="col-span-3 border-r h-full">
                        @livewire('chat-list', ['instance' => $instance])
                    </div>
                    <div class="col-span-9 h-full">
                        @if($state['chat'])
                            @livewire('chat', ['instance' => $instance, 'chat' => $state['chat']])
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </template>
</div>