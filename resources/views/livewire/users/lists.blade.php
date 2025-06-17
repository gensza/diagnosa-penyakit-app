<div>
    <div class="mb-3 d-flex justify-content-between">
        <input type="text" class="form-control border rounded w-50" placeholder="Search title..."
            wire:model.live.debounce.300ms="search">

        <select wire:model.live.debounce.300ms="perPage" class="form-select border rounded w-25">
            <option value="5">5 / page</option>
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
        </select>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th wire:click="sortBy('id')" style="cursor: pointer">
                    No
                    @if ($sortField == 'id')
                        @if ($sortDirection == 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </th>
                <th wire:click="sortBy('name')" style="cursor: pointer">
                    Name
                    @if ($sortField == 'name')
                        @if ($sortDirection == 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </th>
                <th>Email</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $loop->iteration + $posts->firstItem() - 1 }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->email }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        <button wire:click="openEditModal({{ $post->id }})" class="btn btn-sm btn-primary">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $post->id }})">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $posts->links() }}

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" wire:model.defer="editName" class="form-control border rounded">
                        @error('editName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" wire:model.defer="editEmail" class="form-control border rounded">
                        @error('editEmail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    window.addEventListener('show-edit-modal', () => {
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });

    window.addEventListener('hide-edit-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
    });

    window.addEventListener('show-delete-confirmation', () => {
        Swal.fire({
            title: 'Delete this user?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // ✅ this hits the `delete()` Livewire method
                Livewire.find(@js($this->getId())).call('delete');
            }
        });
    });
</script>
