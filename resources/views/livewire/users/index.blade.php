<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session()->has('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <button wire:click="open_modal_add" class="btn btn-success btn-sm">Add</button>
                    </div>
                    <livewire:users.lists />
                </div>
            </div>
        </div>
    </div>

    @if ($showModal)
        <livewire:users.create />
    @endif
</div>

<script>
    document.addEventListener('post-added-alert', event => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: event.detail.message,
        });
    });
</script>
