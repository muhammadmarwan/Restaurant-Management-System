<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ItemSetup;

class ItemSale extends Component
{
    public $ItemsCart=[],$normal=[],$main=[],$extra=[];

    public function mount()
    {
        $this->ItemsCart;

        $this->normal = ItemSetup::where('category',1)
        ->orderBy('item_setups.id')
        ->get();

    }

    public function render()
    {
        return view('livewire.item-sale');
    }

    public function demo()
    {
        
    }
}
