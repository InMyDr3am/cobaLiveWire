<?php

namespace App\Http\Livewire;

use App\Models\Contact; 
use Livewire\Component;
use Livewire\WithPagination;

class ContactIndex extends Component
{

    use WithPagination;
    // public $data;
    public $statusUpdate = false;
   

    //listener agar tidak perlu reload page untuk perbarui data di ContactIndex
    protected $listeners = [
        'contactStored' => 'handleStored',
        'contactUpdated' => 'handleUpdated'
    ];
    
    public function render()
    {
        //memanggil cara normal tanpa pagination
        //$this->data = Contact::latest()->get();

        return view('livewire.contact-index', [
            'data' => Contact::latest()->paginate(5)
        ]);
        
        //dengan pagination
        // $this->data = Contact::latest()->paginate(5);
        // return view('livewire.contact-index');
    }

    public function getContact($id)
    {
        $this->statusUpdate = true;
        $contact = Contact::find($id);
        $this->emit('getContact', $contact);
    }

    public function destroy($id)
    {
        if ($id) {
            $data = Contact::find($id);
            $data->delete();
            session()->flash('message', 'Contact Berhasil Dihapus');
        }
    }
    public function handleStored($contact)
    {
        session()->flash('message', 'Contact ' . $contact['name'] . ' Berhasil Tersimpan!');
    }

    public function handleUpdated($contact)
    {
        session()->flash('message', 'Contact ' . $contact['name'] . ' Berhasil Diperbarui!');
    }
}
