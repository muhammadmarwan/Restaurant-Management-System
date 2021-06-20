<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Vendor;
use App\Models\PurchaseEntry;
use App\Models\PurchaseInventoryOrder;
use App\Models\PurchaseInventoryProducts;

class Purchasereturn extends Component
{
    public $vendor,$count;
    public $purchase=[],$amount,$date,$invoiceNo,$selectedQuantity;

    public $selectedVendor=null;
    public $selectedPurchase=null;
    public $purchaseType;
    public $purchaseInventory=[];
    public $purchaseProducts=[];

    public function mount()
    {
        $this->vendor = Vendor::all();
    }

    public function render()
    {
        return view('livewire.purchasereturn');
    }

    public function updatedSelectedVendor($vendor_id)
    {
        $this->purchase = PurchaseEntry::where('vendor_id',$vendor_id)->get();
        
        $this->purchaseInventory  = PurchaseInventoryOrder::where('vendor_id',$vendor_id)->get();

        if($this->purchaseInventory!=null)
        {
            $this->purchaseType = 1;
        }else{
            $this->purchaseType = 0;
        }
    }

    public function updatedSelectedPurchase($purchase_id)
    {

        $purchaseCount = PurchaseEntry::where('transaction_id',$purchase_id)->count();

        if($purchaseCount==0)
        {
            $purchase = PurchaseInventoryOrder::where('transaction_id',$purchase_id)
            ->select('*','total_amount as amount')
            ->first();

            $this->purchaseProducts = PurchaseInventoryProducts::where('order_id',$purchase->transaction_id)
            ->leftjoin('products','products.transaction_id','purchase_inventory_products.product_id')
            ->get();

        }else{
            $purchase = PurchaseEntry::where('transaction_id',$purchase_id)->first();
        }

        $this->amount = $purchase->amount;
        $this->date = $purchase->created_at->format('d-F-Y');
        $this->invoiceNo = $purchase->invoice_no;
    }

    // public function quantityUpdate($id,$quantity,$order_id)
    // {
    //     $this->count = $id;

    //     $total = PurchaseInventoryProducts::where('id',$id)->value('total');

    //     $value = $total / $quantity;

    //     $newTotal=0;
    //     if($this->selectedQuantity>0)
    //     {
    //         $newTotal = $this->selectedQuantity * $value;
    //     }

    //     $update = PurchaseInventoryProducts::where('id',$id)->update(['unit_price'=>$newTotal]);

    //     if($this->selectedQuantity>0)
    //     {
    //         $update = PurchaseInventoryProducts::where('id',$id)->update(['quantity_temp'=>$this->selectedQuantity]);
    //     }
        
    //     $this->purchaseProducts = PurchaseInventoryProducts::where('order_id',$order_id)
    //         ->leftjoin('products','products.transaction_id','purchase_inventory_products.product_id')
    //         ->get();        
    // }
}
