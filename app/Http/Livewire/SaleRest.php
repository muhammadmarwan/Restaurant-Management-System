<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ItemSetup;
use App\Models\ItemsCart;
use App\Models\DineInTable;
use App\Models\DineInTableItems;
use Auth;
use App\Models\Items;

class SaleRest extends Component
{
    public $normal,$main,$extra,$ItemsCart=[],$total,$tabId;

    public $payAmount,$balance,$method,$saleType,$tableSelect=[];

    public function mount()
    {

        $this->normal = ItemSetup::where('category',1)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->normal as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->main = ItemSetup::where('category',2)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get(); 

        foreach($this->main as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->extra = ItemSetup::where('category',3)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->extra as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->total = ItemsCart::sum('total_price');

        $this->ItemsCart = ItemsCart::all();

        $this->tabId = 1;
        
    }

    public function InsertoCart($itemId)
    {
        $getProduct = ItemSetup::leftjoin('items','items.transaction_id','item_setups.item_id')
        ->where('item_setups.id',$itemId)
        ->first();

        if($getProduct->item_name!=null)
        {
            $cartCheck = ItemsCart::where('item_id',$getProduct->item_id)->count();

            if($cartCheck!=0)
            {
                //update
                $update = ItemsCart::where('item_id',$getProduct->item_id);
                $update->increment('quantity',1);

                $item = ItemsCart::where('item_id',$getProduct->item_id)->first();

                $sumTotal = $item->price * $item->quantity;

                $update->update(['total_price'=>$sumTotal]);

                $this->ItemsCart = ItemsCart::all();
                

            }else{
                //store carts
            $cart = new ItemsCart();
            $cart->item_name = $getProduct->item_name;
            $cart->item_id = $getProduct->item_id;
            $cart->price = $getProduct->amount;
            $cart->quantity = 1;
            $cart->total_price = $getProduct->amount;
            $cart->user_id = Auth::user()->user_id;
            $cart->payment_method = 'cash';
            $cart->save();

            $this->ItemsCart->prepend($cart);

            }

            $this->total = ItemsCart::sum('total_price');

        }

        $this->tabId = $getProduct->category;

        $this->normal = ItemSetup::where('category',1)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->normal as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->main = ItemSetup::where('category',2)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get(); 

        foreach($this->main as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->extra = ItemSetup::where('category',3)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->extra as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        //update balance
        
        $total = $this->total = ItemsCart::sum('total_price');

        $this->balance = (float)$this->payAmount - $total;

        return;
    }

    public function render()
    {
        $update = ItemsCart::where('status',0)->update(['payment_method'=>$this->method]);

        $this->payAmount;

        $this->payAmount;

        $total = $this->total = ItemsCart::sum('total_price');

        $this->balance = (float)$this->payAmount - $total;

        $this->tableSelect = DineInTable::all();

        $updateCart = ItemsCart::where('status',0)->update(['paid_amount'=>$this->payAmount]);

        return view('livewire.sale-rest');
    }

    public function RemoveItem($id)
    {
        $remove = ItemsCart::where('id',$id)->delete();

        $this->ItemsCart = $this->ItemsCart->except($id);

        $this->normal = ItemSetup::where('category',1)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->normal as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->main = ItemSetup::where('category',2)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get(); 

        foreach($this->main as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->extra = ItemSetup::where('category',3)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->extra as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->total = ItemsCart::sum('total_price');

        //update balance

        $total = $this->total = ItemsCart::sum('total_price');

        $this->balance = (float)$this->payAmount - $total;
    }

    public function BalanceCheck()
    {
        $this->payAmount;

        $total = $this->total = ItemsCart::sum('total_price');

        $this->balance = (float)$this->payAmount - $total;

        $updateCart = ItemsCart::where('status',0)->update(['paid_amount'=>$this->payAmount]);
        
        $this->normal = ItemSetup::where('category',1)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->normal as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->main = ItemSetup::where('category',2)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get(); 

        foreach($this->main as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

        $this->extra = ItemSetup::where('category',3)
        ->select('item_setups.id as itemId','item_setups.*')
        ->orderBy('item_setups.id')
        ->get();

        foreach($this->extra as $val)
        {
            $val->amount = Items::where('transaction_id',$val->item_id)->value('amount');
        }

    }

    // public function SalesType($item)
    // {
    //     $this->normal = ItemSetup::where('category',1)
    //     ->select('item_setups.id as itemId','item_setups.*')
    //     ->orderBy('item_setups.id')
    //     ->get();

    //     $this->main = ItemSetup::where('category',2)
    //     ->select('item_setups.id as itemId','item_setups.*')
    //     ->orderBy('item_setups.id')
    //     ->get(); 

    //     $this->extra = ItemSetup::where('category',3)
    //     ->select('item_setups.id as itemId','item_setups.*')
    //     ->orderBy('item_setups.id')
    //     ->get();

    //     $this->total = ItemsCart::sum('total_price');

    //     $updateItemsCart = ItemsCart::where('status',0)->update(['sale_type'=>$item]);

    //     $this->saleType = ItemsCart::where('status',0)->value('sale_type');
    // }

    // public function TableSelect($table_no)
    // {
        
    //     $this->saleType = ItemsCart::where('status',0)->value('sale_type');
    // }
}