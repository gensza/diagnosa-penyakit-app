<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';

    public function save()
    {
        $validated = $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        session()->flash('message', 'Post Created Successfully');

        $this->reset(); // bersihkan input
        $this->dispatch('post-added'); // trigger event jika ingin refresh data
        $this->dispatch('post-added-alert', message: "User successfully created!"); // trigger event jika ingin refresh data
        $this->dispatch('modal-closed'); // tutup modal
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
