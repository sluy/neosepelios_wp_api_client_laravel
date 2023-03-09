<div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Instance Name</label>
        <div class="mt-1">
          <input type="text" wire:loading.attr="disabled" name="name" wire:model.defer="state.name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Instance Display Name">
        </div>
        <div class="flex justify-end mt-4">
            <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-default" wire:click="create" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create
            </button>
        </div>
    </div>
</div>
