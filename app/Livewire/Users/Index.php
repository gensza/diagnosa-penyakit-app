<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public bool $showModal = false;

    public function open_modal_add()
    {
        $this->showModal = true;
    }

    #[On('modal-closed')]
    public function open_modal_close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.users.index');
    }
}
