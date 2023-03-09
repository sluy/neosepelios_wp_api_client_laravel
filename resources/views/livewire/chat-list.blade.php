<div wire:init="init" class="w-full h-full">
    @if($lazy)
    <div x-data="{loading: $wire.entangle('state.loading'), chats: $wire.entangle('state.chats')}" class="h-full w-full">
        <template x-if="loading">
            <div class="flex items-center justify-center h-full w-full">
                <svg class="animate-spin h-16 w-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>
        <template x-if="!loading">
            <div class="flex flex-col divide-y overflow-auto max-h-screen">
                <template x-for="chat in chats" :key="chat.id.user">
                    <template x-if="!chat.isGroup">
                        <div class="px-2 py-1 flex items-center gap-2 cursor-pointer hover:bg-gray-100" x-on:click="$wire.openChat(chat.id.user)">
                            <img src="https://ui-avatars.com/api/?name=" alt="" class="w-12 h-12 rounded-full">
                            <div class="flex flex-col" style="max-width: 300px">
                                <span x-text="chat.name" class="text-sm"></span>
                                <template x-if="chat.last_message">
                                    <span x-text="chat.last_message.body" class="text-xs truncate"></span>
                                </template>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </template>
    </div>
    @endif
</div>