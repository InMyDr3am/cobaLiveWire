<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactCreate extends Component
{
    public $name;
    public $phone;

    public function render()
    {
        return view('livewire.contact-create'); 
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required|max:15'
        ]);

        $contact = Contact::create([
            'name' => $this->name,
            'phone' => $this->phone
        ]);

        $this->resetInput();

        //agar tidak perlu reload page untuk perbarui data stelah berhasil ditambah
        $this->emit('contactStored', $contact);
    }

    //karena tidak akan dijalankan di luar, maka private
    private function resetInput()
    {
        $this->name = null;
        $this->phone = null;
    }
}
