<div>
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" wire:click="$dispatch('modal-closed')" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="text" class="form-control border rounded" placeholder="Name"
                            wire:model.defer="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input type="email" class="form-control border rounded" placeholder="Email"
                            wire:model.defer="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input type="password" class="form-control border rounded" placeholder="Password"
                            wire:model.defer="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$dispatch('modal-closed')">Cancel</button>
                    <button class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
