<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class KomponenTemplate extends Component
{
    public function render()
    {
        return view('livewire.admin.page.komponen-template');
    }
}
