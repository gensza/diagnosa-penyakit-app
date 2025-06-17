<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    public $deleteId;
    public $editId;
    public $editName;
    public $editEmail;

    #[On('post-added')]
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;

        $this->resetPage();
    }

    public function openEditModal($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;

        $this->dispatch('show-edit-modal', user: $user);
    }

    public function update()
    {
        $this->validate([
            'editName' => 'required|string',
            'editEmail' => 'required|email',
        ]);

        $user = User::findOrFail($this->editId);
        $user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
        ]);

        $this->reset(['editId', 'editName', 'editEmail']);
        $this->dispatch('post-added-alert', message: "User updated successfully!");
        $this->dispatch('hide-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function delete()
    {
        $user = User::findOrFail($this->deleteId);
        $user->delete();

        $this->reset('deleteId');
        $this->dispatch('post-added-alert', message: "User deleted successfully!");
    }

    public function render()
    {
        $posts = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.users.lists', ['posts' => $posts]);
    }
}
