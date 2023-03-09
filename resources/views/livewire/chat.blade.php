<div wire:init="init" class="w-full h-full">
    @if($lazy)
    <div x-data="{loading: $wire.entangle('state.loading'), chat: $wire.entangle('state.chat'), messages: $wire.entangle('state.messages'), body: $wire.entangle('state.body')}" class="h-full w-full">
        <template x-if="loading">
            <div class="flex items-center justify-center h-full w-full">
                <svg class="animate-spin h-16 w-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>
        <template x-if="!loading && chat">
            <div>
                <div class="border-b p-2 flex items-center justify-center gap-2">
                    <img x-bind:src="chat.avatar_url" alt="" class="w-8 h-8 rounded-full">
                    <span x-text="chat.name"></span>
                </div>
                <div class="overflow-auto h-[calc(100vh-150px)]" id="messages">
                    <template x-for="message in messages" :key="message.id._serialized">
                        <div>
                            <template x-if="message.id.fromMe">
                                <div class="w-full">
                                    <div class="flex flex-col my-4">
                                        <div class="flex flex-row-reverse px-4">
                                            <div class="bg-blue-100 p-2 py-1 rounded text-sm" style="max-width: 50%; overflow-wrap: break-word !important;">
                                               <span style="word-break: break-word;" x-text="message.body"></span>
                                                <div class="mt-1 flex justify-end items-center">
                                                    <div class="mr-1 text-xs text-gray-400" x-text="new Date(message.timestamp).toLocaleTimeString()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-40 flex items-center" style="display: none;">
                                            <div class="mt-4 top-4 right-6 absolute z-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-12 h-12 text-white cursor-pointer">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="fixed inset-0 transform transition-all" enter-class="opacity-0" leave-class="opacity-100" style="display: none;">
                                                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                                            </div>
                                            <div class="mb-6 overflow-hidden transform transition-all sm:w-full sm:mx-auto max-w-6xl" enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" leave-class="opacity-100 translate-y-0 sm:scale-100" style="display: none;">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!message.id.fromMe">
                                <div class="w-full">
                                    <div class="flex flex-col my-4">
                                        <div class="flex px-4">
                                            <div class="bg-gray-100 p-2 py-1 rounded text-sm" style="max-width: 50%; overflow-wrap: break-word !important;">
                                               <span style="word-break: break-word;" x-text="message.body"></span>
                                                <div class="mt-1 flex justify-end items-center">
                                                    <div class="mr-1 text-xs text-gray-400" x-text="new Date(message.timestamp).toLocaleTimeString()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-40 flex items-center" style="display: none;">
                                            <div class="mt-4 top-4 right-6 absolute z-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-12 h-12 text-white cursor-pointer">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="fixed inset-0 transform transition-all" enter-class="opacity-0" leave-class="opacity-100" style="display: none;">
                                                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                                            </div>
                                            <div class="mb-6 overflow-hidden transform transition-all sm:w-full sm:mx-auto max-w-6xl" enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" leave-class="opacity-100 translate-y-0 sm:scale-100" style="display: none;">
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="border-t">
                    <textarea wire:loading.attr="disabled" wire:target="sendMessage" x-model="body" x-on:keyup.enter="$wire.sendMessage()" class="resize-none w-full border-none outline-none" placeholder="Type your message and press enter to send..." rows="3"></textarea>
                </div>
            </div>
        </template>
    </div>
    @endif
    <script>
        window.addEventListener('scrollDown', () => {
            let container = document.querySelector('#messages');
            container.scrollTop = container.scrollHeight
        })
    </script>

</div>
